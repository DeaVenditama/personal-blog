<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Personal Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fafafa;
        }

        .login-card {
            border: 1px solid #eaeaea;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background-color: #fff;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="col-md-4 col-sm-8 col-11">
        <div class="card login-card p-5">
            <h3 class="fw-bold text-center mb-4">Blog Admin</h3>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger py-2">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/auth/login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label text-muted small">Email Address</label>
                    <input type="email" name="email" class="form-control" required placeholder="admin@example.com">
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted small">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-dark w-100 py-2">Login to Dashboard</button>
            </form>
            <div class="text-center mt-4">
                <a href="<?= base_url('/') ?>" class="text-muted small text-decoration-none">&larr; Back to Website</a>
            </div>
        </div>
    </div>

</body>

</html>