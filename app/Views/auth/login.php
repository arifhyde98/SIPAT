<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIPAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --blue: #0b4a8b;
            --light: #d7e3ee;
            --pill: #e9eef3;
            --green: #58b33f;
        }

        body {
            background: var(--blue);
            min-height: 100vh;
            font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
        }

        .brand-title {
            font-weight: 800;
            letter-spacing: 2px;
            font-size: 56px;
        }

        .sub-title {
            letter-spacing: 2px;
            font-size: 14px;
        }

        .login-panel {
            background: var(--light);
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .logo-box {
            width: 140px;
            height: 140px;
            border-radius: 12px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 0 1px #c5d2de;
            transition: transform 0.3s ease;
        }

        .logo-box:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .pill-input {
            background: var(--pill);
            border: none;
            border-radius: 999px;
            padding: 12px 16px 12px 44px;
            transition: all 0.3s ease;
        }

        .pill-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            transform: scale(1.02);
            background: #fff;
        }

        .pill-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7a89;
            transition: all 0.3s ease;
        }

        .position-relative:focus-within .pill-icon {
            color: var(--blue);
            transform: translateY(-50%) scale(1.1);
        }

        .btn-login {
            background: var(--green);
            border: none;
            border-radius: 999px;
            padding: 12px 40px;
            font-weight: 700;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            opacity: 0.92;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(88, 179, 63, 0.3);
        }

        .footer-text {
            font-size: 12px;
            letter-spacing: 1px;
        }

        @media (max-width: 992px) {
            .brand-title {
                font-size: 42px;
            }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0px); }
        }
        .logo-animate { animation: float 4s ease-in-out infinite; }
    </style>
</head>

<body class="d-flex align-items-center">
    <div class="container py-5">
        <div class="text-center text-white mb-4">
            <div class="brand-title">SIPAT</div>
            <div class="sub-title">Sistem Informasi Monitoring Pensertifikatan Tanah</div>
        </div>

        <div class="login-panel mx-auto" style="max-width: 900px;">
            <div class="row g-4 align-items-center">
                <div class="col-md-4 text-center">
                    <div class="logo-box mx-auto">
                        <img
                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Lambang_Kabupaten_Donggala_%282015-sekarang%29.png/196px-Lambang_Kabupaten_Donggala_%282015-sekarang%29.png"
                            alt="Logo Kabupaten Donggala"
                            style="max-width: 110px;"
                            class="logo-animate">
                    </div>
                </div>
                <div class="col-md-8">
                    <form action="<?= base_url('login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3 position-relative">
                            <i class="bi bi-person pill-icon"></i>
                            <input type="email" name="email" class="form-control pill-input" placeholder="Username / Email" value="<?= old('email') ?>" required>
                        </div>
                        <div class="mb-2 position-relative">
                            <i class="bi bi-lock pill-icon"></i>
                            <input type="password" name="password" class="form-control pill-input" placeholder="Password" required>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="showPass">
                            <label class="form-check-label" for="showPass">Show Password</label>
                        </div>
                        <button type="submit" class="btn btn-login">LOGIN</button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4 footer-text text-muted">
All Right Reserved - PEMERINTAH KABUPATEN DONGGALA 2026

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const sipatEscape = (value) => String(value ?? '').replace(/[&<>"']/g, (c) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
        })[c]);

        <?php
        $errorList = session('errors');
        $errorList = is_array($errorList) ? array_values($errorList) : [];
        ?>
        <?php if (!empty($errorList)) : ?>
        (function () {
            const errors = <?= json_encode($errorList, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
            const items = errors.map(err => `<li>${sipatEscape(err)}</li>`).join('');
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                html: `<ul style="text-align:left;margin:0;padding-left:18px;">${items}</ul>`,
            });
        })();
        <?php endif; ?>

        const showPass = document.getElementById('showPass');
        const passInput = document.querySelector('input[name="password"]');
        if (showPass && passInput) {
            showPass.addEventListener('change', () => {
                passInput.type = showPass.checked ? 'text' : 'password';
            });
        }
    </script>
</body>

</html>
