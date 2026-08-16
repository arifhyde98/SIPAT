<?php

namespace App\Models;

use CodeIgniter\Model;

class AsetModel extends Model
{
    protected $table            = 'aset_tanah';
    protected $primaryKey       = 'id_aset';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'kode_aset',
        'nama_aset',
        'peruntukan',
        'luas',
        'alamat',
        'lat',
        'lng',
        'opd',
        'dasar_perolehan',
        'harga_perolehan',
        'tanggal_perolehan',
        'keterangan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'kode_aset' => 'required|is_unique[aset_tanah.kode_aset,id_aset,{id_aset}]',
        'nama_aset' => 'required',
    ];

    protected $validationMessages = [
        'kode_aset' => [
            'required'  => 'Kode aset wajib diisi.',
            'is_unique' => 'Data sudah ada. Kode aset tersebut sudah digunakan.',
        ],
        'nama_aset' => [
            'required'  => 'Nama aset wajib diisi.',
        ],
    ];

    /**
     * Mendapatkan daftar id_status aktif yang ada pada riwayat proses aset terbaru.
     */
    public function getActiveStatusIds(): array
    {
        $sql = "SELECT DISTINCT p1.id_status 
                FROM proses_aset p1
                JOIN (
                    SELECT id_aset, MAX(id_proses) AS max_id
                    FROM proses_aset
                    GROUP BY id_aset
                ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id";

        return array_column($this->db->query($sql)->getResultArray(), 'id_status');
    }

    /**
     * Mendapatkan pemetaan status terbaru untuk sejumlah id_aset.
     */
    public function getLatestStatusMap(array $asetIds): array
    {
        if (empty($asetIds)) {
            return [];
        }

        $ids = implode(',', array_map('intval', $asetIds));
        $sql = "SELECT p1.id_aset, p1.durasi_hari, s.nama_status, s.warna
                FROM proses_aset p1
                JOIN status_proses s ON s.id_status = p1.id_status
                JOIN (
                    SELECT id_aset, MAX(id_proses) AS max_id
                    FROM proses_aset
                    WHERE id_aset IN ($ids)
                    GROUP BY id_aset
                ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id";

        $statusMap = [];
        foreach ($this->db->query($sql)->getResultArray() as $row) {
            $statusMap[(int) $row['id_aset']] = $row;
        }

        return $statusMap;
    }

    /**
     * Mendapatkan daftar id_aset yang status terkininya adalah salah satu dari $statusIds.
     */
    public function getLatestStatusAssetIds(array $statusIds): array
    {
        if (empty($statusIds)) {
            return [0];
        }

        $placeholders = implode(',', array_fill(0, count($statusIds), '?'));
        $sql = "SELECT p1.id_aset
                FROM proses_aset p1
                JOIN (
                   SELECT id_aset, MAX(id_proses) AS max_id
                   FROM proses_aset
                   GROUP BY id_aset
                ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
                WHERE p1.id_status IN ($placeholders)";

        $rows = $this->db->query($sql, $statusIds)->getResultArray();
        $asetIds = array_values(array_filter(array_map(
            static fn ($row) => (int) ($row['id_aset'] ?? 0),
            $rows
        )));

        return $asetIds !== [] ? $asetIds : [0];
    }

    /**
     * Membangun Query Builder untuk ekspor & laporan aset.
     */
    public function buildExportQuery(array $filters)
    {
        $builder = $this->db->table('aset_tanah a')
            ->select('a.kode_aset, a.nama_aset, a.peruntukan, a.opd, a.luas, a.harga_perolehan, a.tanggal_perolehan, a.keterangan as keterangan_aset, sp.nama_status, p.durasi_hari')
            ->join(
                '(SELECT p1.id_aset, p1.id_status, p1.durasi_hari
                  FROM proses_aset p1
                  JOIN (
                      SELECT id_aset, MAX(id_proses) AS max_id
                      FROM proses_aset
                      GROUP BY id_aset
                  ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id) p',
                'p.id_aset = a.id_aset',
                'left',
                false
            )
            ->join('status_proses sp', 'sp.id_status = p.id_status', 'left')
            ->orderBy('a.id_aset', 'DESC');

        if (($filters['opd'] ?? '') !== '') {
            if ($filters['opd'] === 'KOSONG') {
                $builder->groupStart()
                    ->where('a.opd', null)
                    ->orWhere('a.opd', '')
                    ->groupEnd();
            } else {
                $builder->where('a.opd', $filters['opd']);
            }
        }
        if (($filters['tanggal_perolehan'] ?? '') !== '') {
            $builder->where('a.tanggal_perolehan', $filters['tanggal_perolehan']);
        }
        if (($filters['q'] ?? '') !== '') {
            $builder->groupStart()
                ->like('a.kode_aset', $filters['q'])
                ->orLike('a.nama_aset', $filters['q'])
                ->orLike('a.peruntukan', $filters['q'])
                ->orLike('a.opd', $filters['q'])
                ->groupEnd();
        }
        if (!empty($filters['status'])) {
            $builder->whereIn('a.id_aset', $this->getLatestStatusAssetIds($filters['status']));
        }

        return $builder;
    }

    /**
     * Mengambil daftar aset untuk respon API dengan status terkini.
     */
    public function getAssetsForApi(array $filters = [], int $limit = 5000): array
    {
        $builder = $this->db->table('aset_tanah a')
            ->select('a.*, sp.nama_status as status_terkini, sp.warna as warna_status, sp.kategori as kategori_status')
            ->join('(
                SELECT p1.id_aset, p1.id_status
                FROM proses_aset p1
                JOIN (
                    SELECT id_aset, MAX(id_proses) AS max_id
                    FROM proses_aset
                    GROUP BY id_aset
                ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
            ) r', 'r.id_aset = a.id_aset', 'left')
            ->join('status_proses sp', 'sp.id_status = r.id_status', 'left');

        if (!empty($filters['q'])) {
            $builder->groupStart()
                ->like('a.kode_aset', $filters['q'])
                ->orLike('a.nama_aset', $filters['q'])
                ->orLike('a.peruntukan', $filters['q'])
                ->groupEnd();
        }

        if (!empty($filters['opd'])) {
            $builder->where('a.opd', $filters['opd']);
        }

        return $builder->orderBy('a.id_aset', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    /**
     * Mengambil detail satu aset untuk respon API berdasarkan NIBAR atau ID.
     */
    public function getAssetWithStatusForApi(string $nibarOrId): ?array
    {
        $builder = $this->db->table('aset_tanah a')
            ->select('a.*, sp.nama_status as status_terkini, sp.warna as warna_status, sp.kategori as kategori_status')
            ->join('(
                SELECT p1.id_aset, p1.id_status
                FROM proses_aset p1
                JOIN (
                    SELECT id_aset, MAX(id_proses) AS max_id
                    FROM proses_aset
                    GROUP BY id_aset
                ) p2 ON p1.id_aset = p2.id_aset AND p1.id_proses = p2.max_id
            ) r', 'r.id_aset = a.id_aset', 'left')
            ->join('status_proses sp', 'sp.id_status = r.id_status', 'left');

        if (is_numeric($nibarOrId)) {
            $builder->where('a.id_aset', $nibarOrId)->orWhere('a.kode_aset', $nibarOrId);
        } else {
            $builder->where('a.kode_aset', urldecode($nibarOrId));
        }

        return $builder->get()->getRowArray() ?: null;
    }

    /**
     * Mendapatkan daftar kode aset ganda (duplikat).
     */
    public function getDuplicates(): array
    {
        return $this->db->table('aset_tanah')
            ->select('kode_aset, COUNT(*) as jumlah, GROUP_CONCAT(nama_aset SEPARATOR ", ") as daftar_aset')
            ->where('kode_aset IS NOT NULL')
            ->where('kode_aset !=', '')
            ->groupBy('kode_aset')
            ->having('jumlah > 1')
            ->get()
            ->getResultArray();
    }
}
