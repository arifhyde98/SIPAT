<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .profile-avatar-large {
        width: 90px;
        height: 90px;
        font-size: 2.5rem;
        font-weight: 700;
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }
    .profile-card-bg {
        background: linear-gradient(135deg, #1E5EFF 0%, #0F2747 100%);
        height: 100px;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }
    .profile-info-item {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .profile-info-item:last-child {
        border-bottom: none;
    }
</style>

<!-- Header Halaman -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-bold mb-1 text-dark">Profil Saya</h1>
        <small class="text-muted">Kelola informasi pribadi dan keamanan akun Anda</small>
    </div>
    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>

<div class="row g-4">
    <!-- Kolom Info Ringkas (Kiri) -->
    <div class="col-lg-4">
        <div class="card overflow-hidden">
            <div class="profile-card-bg"></div>
            <div class="card-body pt-0 text-center position-relative">
                <div class="d-flex justify-content-center" style="margin-top: -45px;">
                    <div class="profile-avatar-large rounded-circle bg-primary text-white d-flex align-items-center justify-content-center">
                        <?= strtoupper(substr(esc($user['nama']), 0, 1)) ?>
                    </div>
                </div>
                <h5 class="fw-bold mt-3 mb-1"><?= esc($user['nama']) ?></h5>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-medium mb-3">
                    <?= esc($user['role']) ?>
                </span>
                
                <div class="text-start mt-3">
                    <div class="profile-info-item d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Email</span>
                        <span class="fw-medium text-dark small"><?= esc($user['email']) ?></span>
                    </div>
                    <div class="profile-info-item d-flex justify-content-between align-items-center">
                        <span class="text-muted small">OPD</span>
                        <span class="fw-medium text-dark small"><?= esc($user['opd'] ?: '-') ?></span>
                    </div>
                    <div class="profile-info-item d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Terdaftar Sejak</span>
                        <span class="fw-medium text-dark small">
                            <?= date('d M Y', strtotime($user['created_at'])) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Form Edit (Kanan) -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Ubah Informasi Profil</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('profile/update') ?>" method="post" id="form-profile" data-confirm="Simpan perubahan profil Anda?">
                    <?= csrf_field() ?>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= esc(old('nama', $user['nama'])) ?>" required minlength="3">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= esc(old('email', $user['email'])) ?>" required>
                        </div>

                        <hr class="my-4 text-muted">

                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Ganti Password (Opsional)</h6>
                                    <small class="text-muted">Kosongkan jika Anda tidak ingin mengubah password saat ini.</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="password" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control border-start-0" id="password" name="password" minlength="6" placeholder="Masukkan minimal 6 karakter">
                                <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2 d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary">Reset Form</button>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#toggle-password');
        const password = document.querySelector('#password');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                if (type === 'text') {
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>
