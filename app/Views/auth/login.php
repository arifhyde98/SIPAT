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
        }

        .pill-input {
            background: var(--pill);
            border: none;
            border-radius: 999px;
            padding: 12px 16px 12px 44px;
        }

        .pill-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .pill-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7a89;
        }

        .btn-login {
            background: var(--green);
            border: none;
            border-radius: 999px;
            padding: 12px 40px;
            font-weight: 700;
            color: #fff;
        }

        .btn-login:hover {
            opacity: 0.92;
            color: #fff;
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
    </style>
</head>

<body class="d-flex align-items-center">
    <div class="container py-5">
        <div class="text-center text-white mb-4">
            <div class="brand-title">SIPAT</div>
            <div class="sub-title">Sistem Informasi Monitoring Pensertifikatan Tanah</div>
        </div>

        <?php $errors = session('errors') ?? []; ?>
        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="login-panel mx-auto" style="max-width: 900px;">
            <div class="row g-4 align-items-center">
                <div class="col-md-4 text-center">
                    <div class="logo-box mx-auto">
                        <img
                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Lambang_Kabupaten_Donggala_%282015-sekarang%29.png/196px-Lambang_Kabupaten_Donggala_%282015-sekarang%29.png"
                            alt="Logo Kabupaten Donggala"
                            style="max-width: 110px;">
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
All Right Reserved - KEMENTERIAN DALAM NEGERI
            </div>
        </div>
    </div>

    <script>
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
