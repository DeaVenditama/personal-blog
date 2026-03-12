<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-5 text-center">
    <h1 class="display-4 fw-bold">Source Code Store</h1>
    <p class="lead text-muted">Jelajahi dan dapatkan source code berkualitas untuk proyek Anda selanjutnya.</p>
</div>

<div class="row mb-4">
    <div class="col-md-8 mx-auto">
        <form action="<?= base_url('store') ?>" method="get" class="d-flex">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Cari source code..."
                    value="<?= esc($searchQuery ?? '') ?>">
                <button class="btn btn-dark px-4" type="submit">Cari</button>
            </div>
        </form>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-2">
    <?php if (empty($products)): ?>
        <div class="col-12 text-center py-5">
            <h3 class="text-muted">Oops! Belum ada produk.</h3>
            <p class="text-muted">Produk yang Anda cari tidak ditemukan atau store masih kosong.</p>
            <a href="<?= base_url('store') ?>" class="btn btn-outline-dark mt-3">Reset Pencarian</a>
        </div>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card transition-hover">
                    <?php if (!empty($product['thumbnail'])): ?>
                        <div class="ratio ratio-16x9">
                            <a href="<?= base_url('store/' . $product['slug']) ?>" class="text-decoration-none">
                                <img src="<?= base_url('uploads/products/' . $product['thumbnail']) ?>"
                                    class="card-img-top object-fit-cover w-100 h-100" alt="<?= esc($product['title']) ?>"
                                    data-fallback="<?= htmlspecialchars($product['title'], ENT_QUOTES) ?>"
                                    onerror="this.onerror=null; this.outerHTML='<div class=\'w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white p-3 text-center\'><strong>' + this.getAttribute('data-fallback') + '</strong></div>';">
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="ratio ratio-16x9">
                            <a href="<?= base_url('store/' . $product['slug']) ?>" class="text-decoration-none d-block w-100 h-100">
                                <div
                                    class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white p-3 text-center">
                                    <strong><?= esc($product['title']) ?></strong>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-2">
                            <a href="<?= base_url('store/' . $product['slug']) ?>"
                                class="text-decoration-none text-dark hover-accent">
                                <?= esc($product['title']) ?>
                            </a>
                        </h5>
                        <p class="card-text text-muted small flex-grow-1">
                            <?= substr(strip_tags((string) $product['description']), 0, 100) ?>...
                        </p>
                        <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                            <?php if (isset($product['discount_percentage']) && $product['discount_percentage'] > 0): ?>
                                <?php $discountedPrice = $product['price'] - ($product['price'] * ($product['discount_percentage'] / 100)); ?>
                                <div>
                                    <div class="text-muted small text-decoration-line-through">Rp
                                        <?= number_format($product['price'], 0, ',', '.') ?>
                                    </div>
                                    <div class="fw-bold fs-5 text-danger">
                                        Rp <?= number_format($discountedPrice, 0, ',', '.') ?>
                                        <span class="badge bg-danger ms-1"
                                            style="font-size: 0.7em;">-<?= $product['discount_percentage'] ?>%</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="fw-bold fs-5 text-dark">Rp
                                    <?= number_format($product['price'], 0, ',', '.') ?>
                                </span>
                            <?php endif; ?>
                            <a href="<?= base_url('store/' . $product['slug']) ?>"
                                class="btn btn-dark rounded-pill px-3 py-2 position-relative z-3 flex-shrink-0 text-nowrap"><i
                                    class="bi bi-cart"></i>
                                Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style>
    .product-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }

    .hover-accent:hover {
        color: var(--accent-color) !important;
        text-decoration: underline !important;
    }

    .hover-accent-badge:hover {
        background-color: var(--accent-color) !important;
        color: #fff !important;
    }
</style>

<?= $this->endSection() ?>