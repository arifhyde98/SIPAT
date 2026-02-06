<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 fw-semibold mb-1">Pengaturan Landing Page</h1>
        <small class="text-muted">Ubah logo, header, footer, dan konten utama landing.</small>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <style>
                .preview-thumb {
                    width: 100%;
                    max-width: 240px;
                    height: 140px;
                    border-radius: 12px;
                    object-fit: cover;
                    border: 1px solid rgba(15, 23, 42, 0.12);
                    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
                }
                .preview-logo {
                    width: 64px;
                    height: 64px;
                    border-radius: 50%;
                    object-fit: cover;
                    border: 1px solid rgba(15, 23, 42, 0.12);
                    box-shadow: 0 6px 14px rgba(15, 23, 42, 0.08);
                    background: #fff;
                }
            </style>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Judul Hero</label>
                    <textarea name="landing_hero_title" class="form-control" rows="2"><?= esc($settings['landing_hero_title'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Subjudul Hero</label>
                    <textarea name="landing_hero_subtitle" class="form-control" rows="2"><?= esc($settings['landing_hero_subtitle'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teks CTA</label>
                    <input type="text" name="landing_cta_text" class="form-control" value="<?= esc($settings['landing_cta_text'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teks Footer</label>
                    <input type="text" name="landing_footer_text" class="form-control" value="<?= esc($settings['landing_footer_text'] ?? '') ?>">
                </div>
            </div>

            <hr class="my-4">

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Logo Header</label>
                    <input type="file" name="landing_logo_header" class="form-control">
                    <?php if (!empty($settings['landing_logo_header'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_logo_header']) ?>" alt="Logo Header" class="mt-2 preview-logo">
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Logo Footer</label>
                    <input type="file" name="landing_logo_footer" class="form-control">
                    <?php if (!empty($settings['landing_logo_footer'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_logo_footer']) ?>" alt="Logo Footer" class="mt-2 preview-logo">
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gambar Hero</label>
                    <input type="file" name="landing_hero_image" class="form-control">
                    <?php if (!empty($settings['landing_hero_image'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_hero_image']) ?>" alt="Hero Image" class="mt-2 preview-thumb">
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Galeri 1</label>
                    <input type="file" name="landing_gallery_1" class="form-control">
                    <?php if (!empty($settings['landing_gallery_1'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_gallery_1']) ?>" alt="Galeri 1" class="mt-2 preview-thumb">
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Galeri 2</label>
                    <input type="file" name="landing_gallery_2" class="form-control">
                    <?php if (!empty($settings['landing_gallery_2'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_gallery_2']) ?>" alt="Galeri 2" class="mt-2 preview-thumb">
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Galeri 3</label>
                    <input type="file" name="landing_gallery_3" class="form-control">
                    <?php if (!empty($settings['landing_gallery_3'])) : ?>
                        <img src="<?= base_url('landing/media/' . $settings['landing_gallery_3']) ?>" alt="Galeri 3" class="mt-2 preview-thumb">
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
