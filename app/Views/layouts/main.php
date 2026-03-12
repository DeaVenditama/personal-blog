<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO Meta Tags -->
    <?php
    $site_name = 'Dea Venditama Blog';
    $page_title = $title ?? $site_name;
    $page_description = $meta_description ?? 'A minimalist personal blog platform.';
    $page_url = $canonical_url ?? current_url();
    $page_type = $og_type ?? 'website';
    $page_image = $og_image ?? base_url('assets/images/default-social-card.png'); // Pastikan file gambar default tersedia
    ?>
    <title><?= esc($page_title) ?></title>
    <meta name="description" content="<?= esc($page_description) ?>">
    <link rel="canonical" href="<?= esc($page_url) ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon-16x16.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('apple-touch-icon.png') ?>">
    <link rel="manifest" href="<?= base_url('site.webmanifest') ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?= esc($page_type) ?>">
    <meta property="og:url" content="<?= esc($page_url) ?>">
    <meta property="og:title" content="<?= esc($page_title) ?>">
    <meta property="og:description" content="<?= esc($page_description) ?>">
    <meta property="og:image" content="<?= esc($page_image) ?>">
    <meta property="og:site_name" content="<?= esc($site_name) ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= esc($page_url) ?>">
    <meta name="twitter:title" content="<?= esc($page_title) ?>">
    <meta name="twitter:description" content="<?= esc($page_description) ?>">
    <meta name="twitter:image" content="<?= esc($page_image) ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --bg-color: #ffffff;
            --text-color: #222222;
            --text-muted: #666666;
            --border-color: #eaeaea;
            --accent-color: #000000;
        }

        /* Dark Mode Variables (Implementation for next phase) */
        [data-theme="dark"] {
            --bg-color: #121212;
            --text-color: #e0e0e0;
            --text-muted: #a0a0a0;
            --border-color: #333333;
            --accent-color: #ffffff;
        }

        [data-theme="dark"] .bg-light {
            background-color: #1a1a1a !important;
            color: var(--text-color) !important;
        }

        [data-theme="dark"] .text-muted {
            color: var(--text-muted) !important;
        }

        [data-theme="dark"] .form-control {
            background-color: #2a2a2a !important;
            color: var(--text-color) !important;
            border-color: var(--border-color) !important;
        }

        [data-theme="dark"] .form-control::placeholder {
            color: var(--text-muted) !important;
        }

        [data-theme="dark"] .btn-dark {
            background-color: #e0e0e0 !important;
            color: #121212 !important;
            border-color: #e0e0e0 !important;
        }

        [data-theme="dark"] .btn-dark:hover {
            background-color: #ffffff !important;
        }

        [data-theme="dark"] .btn-outline-dark {
            color: #e0e0e0 !important;
            border-color: #e0e0e0 !important;
        }

        [data-theme="dark"] .btn-outline-dark:hover {
            background-color: #e0e0e0 !important;
            color: #121212 !important;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            transition: background-color 0.3s, color 0.3s;
        }

        h1,
        h2,
        h3,
        .brand-logo {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            border-bottom: 1px solid var(--border-color);
            background-color: var(--bg-color) !important;
            padding: 1.5rem 0;
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent-color);
            text-decoration: none;
        }

        .nav-link {
            color: var(--text-muted);
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--accent-color);
        }

        main {
            min-height: calc(100vh - 200px);
            padding-top: 3rem;
            padding-bottom: 5rem;
        }

        footer {
            border-top: 1px solid var(--border-color);
            padding: 3rem 0;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Card and Post Styling */
        .post-card {
            border: none;
            background: transparent;
            margin-bottom: 3rem;
        }

        .post-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.2s;
        }

        .post-title:hover {
            color: var(--text-muted);
        }

        .post-meta {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .post-excerpt {
            color: var(--text-muted);
            margin-bottom: 1.2rem;
        }

        .read-more {
            color: var(--accent-color);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .read-more:hover {
            text-decoration: underline;
        }

        <?= $this->renderSection('styles') ?>
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container maxWidth-md">
            <a class="brand-logo" href="<?= base_url() ?>">Dea Venditama.</a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav align-items-center">
                    <?php
                    $isStore = url_is('store*');
                    $isPortfolio = url_is('portfolio*');
                    $searchAction = $isPortfolio ? base_url('portfolio') : base_url();
                    $searchPlaceholder = $isPortfolio ? 'Cari project/portofolio...' : 'Cari artikel...';
                    ?>
                    <?php if (!$isStore): ?>
                        <li class="nav-item">
                            <form action="<?= $searchAction ?>" method="GET"
                                class="d-flex align-items-center bg-light rounded-pill px-3 py-1 border search-form">
                                <i class="bi bi-search text-muted small"></i>
                                <input type="search" name="q"
                                    class="form-control border-0 bg-transparent shadow-none form-control-sm ms-2"
                                    placeholder="<?= $searchPlaceholder ?>"
                                    value="<?= esc(service('request')->getGet('q') ?? '') ?>" style="width: 200px;">
                                <button type="submit" class="d-none">Search</button>
                            </form>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item ms-md-4">
                        <a class="nav-link <?= (url_is('/')) ? 'active fw-bold text-dark' : '' ?>"
                            href="<?= base_url() ?>">Beranda</a>
                    </li>
                    <li class="nav-item ms-md-3">
                        <a class="nav-link <?= (url_is('portfolio*')) ? 'active fw-bold text-dark' : '' ?>"
                            href="<?= base_url('portfolio') ?>">Portfolio</a>
                    </li>
                    <li class="nav-item ms-md-3">
                        <a class="nav-link <?= (url_is('store*')) ? 'active fw-bold text-dark' : '' ?>"
                            href="<?= base_url('store') ?>">Store</a>
                    </li>
                    <li class="nav-item ms-md-3">
                        <a class="nav-link" href="#" title="Toggle Dark Mode" id="theme-toggle">
                            <i class="bi bi-moon-stars"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </main>

    <!-- Newsletter Section -->
    <div class="bg-light py-5 mt-5 border-top">
        <div class="container maxWidth-md text-center">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <h3 class="fw-bold mb-3">Berlangganan Newsletter</h3>
                    <p class="text-muted mb-4">Dapatkan artikel terbaru dan info menarik langsung di kotak masuk Anda.
                    </p>
                    <form action="#" method="POST" class="d-flex gap-2">
                        <input type="email" name="email" class="form-control rounded-pill px-4"
                            placeholder="Alamat email Anda" required>
                        <button type="submit" class="btn btn-dark rounded-pill px-4 fw-medium">Langganan</button>
                    </form>
                    <div class="form-text mt-3 text-muted" style="font-size: 0.8rem;">Bebas spam. Berhenti langganan
                        kapan saja.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy;
                <?= date('Y') ?> Dea Venditama. Hak cipta dilindungi undang-undang.
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple dark mode toggle logic
        const toggleBtn = document.getElementById('theme-toggle');
        const icon = toggleBtn.querySelector('i');
        const currentTheme = localStorage.getItem('theme') || 'light';

        if (currentTheme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            icon.classList.replace('bi-moon-stars', 'bi-sun-fill');
        }

        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            let theme = document.documentElement.getAttribute('data-theme');
            if (theme === 'dark') {
                document.documentElement.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
                icon.classList.replace('bi-sun-fill', 'bi-moon-stars');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                icon.classList.replace('bi-moon-stars', 'bi-sun-fill');
            }
        });
    </script>
    <!-- Floating Contact Widget -->
    <button class="btn btn-dark contact-widget-btn shadow" id="contactToggleBtn" aria-label="Hubungi Saya">
        <i class="bi bi-chat-dots-fill me-2"></i> Hubungi Saya
    </button>

    <div class="contact-widget-window shadow border d-none" id="contactWindow">
        <div class="contact-header bg-dark text-white d-flex justify-content-between align-items-center p-3">
            <h6 class="mb-0 fw-bold"><i class="bi bi-envelope-fill me-2"></i> Kirim Pesan</h6>
            <button type="button" class="btn-close btn-close-white" id="contactCloseBtn" aria-label="Close"></button>
        </div>
        <div class="contact-body p-3 bg-body">
            <?php if (session()->getFlashdata('contact_success')): ?>
                <div class="alert alert-success py-2 text-center" style="font-size: 0.85rem;">
                    <?= esc(session()->getFlashdata('contact_success')) ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('contact_error')): ?>
                <div class="alert alert-danger py-2 text-center" style="font-size: 0.85rem;">
                    <?= esc(session()->getFlashdata('contact_error')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('contact/send') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="mb-2">
                    <label class="form-label small text-muted mb-1">Nama</label>
                    <input type="text" name="name" class="form-control form-control-sm" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small text-muted mb-1">Email</label>
                    <input type="email" name="email" class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted mb-1">Pesan</label>
                    <textarea name="message" class="form-control form-control-sm" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-dark btn-sm w-100 fw-bold">Kirim pesan <i
                        class="bi bi-send-fill ms-1"></i></button>
            </form>
        </div>
    </div>

    <style>
        .contact-widget-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            border-radius: 50px;
            padding: 10px 20px;
            z-index: 1050;
            transition: transform 0.2s;
        }

        .contact-widget-btn:hover {
            transform: scale(1.05);
        }

        .contact-widget-window {
            position: fixed;
            bottom: 90px;
            right: 30px;
            width: 320px;
            border-radius: 12px;
            overflow: hidden;
            z-index: 1050;
            transition: all 0.3s ease;
        }

        @media (max-width: 576px) {
            .contact-widget-window {
                width: 90%;
                right: 5%;
                bottom: 80px;
            }

            .contact-widget-btn {
                bottom: 20px;
                right: 20px;
            }
        }
    </style>

    <script>
        const contactToggleBtn = document.getElementById('contactToggleBtn');
        const contactCloseBtn = document.getElementById('contactCloseBtn');
        const contactWindow = document.getElementById('contactWindow');

        // Automatically open if there's a flash message indicating a submission attempt
        <?php if (session()->getFlashdata('contact_success') || session()->getFlashdata('contact_error')): ?>         contactWindow.classList.remove('d-none');
        <?php endif; ?>

        contactToggleBtn.addEventListener('click', () => {
            contactWindow.classList.toggle('d-none');
        });

        contactCloseBtn.addEventListener('click', () => {
            contactWindow.classList.add('d-none');
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>