<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Peta Aset</h1>
        <small class="text-muted">Sebaran aset berdasarkan status</small>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div id="map" style="height: 540px; border-radius: 12px;"></div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([-2.5, 117.5], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const markers = <?= json_encode($markers) ?>;
    const bounds = [];
    markers.forEach(item => {
        const marker = L.marker([item.lat, item.lng]).addTo(map);
        marker.bindPopup(
            `<strong>${item.kode}</strong><br>${item.nama}<br>Status: ${item.status}<br><a href="<?= base_url('aset') ?>/${item.id}">Detail</a>`
        );
        bounds.push([item.lat, item.lng]);
    });
    if (bounds.length) {
        map.fitBounds(bounds, { padding: [40, 40] });
    }
</script>
<?= $this->endSection() ?>
