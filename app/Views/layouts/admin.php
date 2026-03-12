<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?? 'Admin Panel' ?> - Personal Blog
    </title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon-16x16.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('apple-touch-icon.png') ?>">
    <link rel="manifest" href="<?= base_url('site.webmanifest') ?>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #fafafa;
            color: #333;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #fff;
            border-right: 1px solid #eaeaea;
        }

        .sidebar .nav-link {
            color: #555;
            padding: 0.8rem 1.2rem;
            margin-bottom: 0.2rem;
            border-radius: 6px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #f0f0f0;
            color: #000;
        }

        .topbar {
            background-color: #fff;
            border-bottom: 1px solid #eaeaea;
            padding: 1rem 1.5rem;
        }

        .content-area {
            padding: 2rem;
        }

        .card {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            background-color: #fff;
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar d-none d-md-block">
                <div class="p-4 border-bottom text-center">
                    <h5 class="fw-bold mb-0">MyBlog Admin</h5>
                </div>
                <div class="p-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('admin/dashboard*')) ? 'active' : '' ?>"
                                href="<?= base_url('admin/dashboard') ?>">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('admin/posts*')) ? 'active' : '' ?>"
                                href="<?= base_url('admin/posts') ?>">
                                <i class="bi bi-file-earmark-text me-2"></i> Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('admin/categories*')) ? 'active' : '' ?>"
                                href="<?= base_url('admin/categories') ?>">
                                <i class="bi bi-folder me-2"></i> Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('admin/media*')) ? 'active' : '' ?>"
                                href="<?= base_url('admin/media') ?>">
                                <i class="bi bi-images me-2"></i> Media Library
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('admin/portfolios*')) ? 'active' : '' ?>"
                                href="<?= base_url('admin/portfolios') ?>">
                                <i class="bi bi-briefcase me-2"></i> Portfolios
                            </a>
                        </li>
                        <!-- Nav Item - Store/Products -->
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('admin/product*')) ? 'active' : '' ?>"
                                href="<?= base_url('admin/products') ?>">
                                <i class="bi bi-shop me-2"></i> Store (Source Code)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (url_is('admin/messages*')) ? 'active' : '' ?>"
                                href="<?= base_url('admin/messages') ?>">
                                <i class="bi bi-chat-left-text me-2"></i> Messages
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link text-danger" href="<?= base_url('admin/auth/logout') ?>">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-0">
                <!-- Topbar -->
                <div class="topbar d-flex justify-content-between align-items-center">
                    <div>
                        <button class="btn btn-light d-md-none me-2"><i class="bi bi-list"></i></button>
                        <span class="fs-5 fw-semibold">
                            <?= $title ?? 'Dashboard' ?>
                        </span>
                    </div>
                    <div>
                        <span class="text-muted"><i class="bi bi-person-circle me-1"></i> Admin User</span>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="content-area">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success border-0 shadow-sm">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger border-0 shadow-sm">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>