<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= base_url('store') ?>" class="text-decoration-none text-muted"><i class="bi bi-arrow-left"></i> Kembali
        ke
        Store</a>
</div>

<div class="row g-5">
    <div class="col-lg-7">
        <?php if (!empty($product['thumbnail'])): ?>
            <?php 
                $images = explode(';', $product['thumbnail']); 
                if (count($images) > 1): 
            ?>
                <div id="productCarousel" class="carousel slide shadow-sm rounded overflow-hidden" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($images as $index => $img): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= base_url('uploads/products/' . esc(trim($img))) ?>" class="d-block w-100 object-fit-cover" style="max-height: 500px;" alt="<?= esc($product['title']) ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            <?php else: ?>
                <img src="<?= base_url('uploads/products/' . trim($images[0])) ?>"
                    class="img-fluid rounded shadow-sm w-100 object-fit-cover" style="max-height: 500px;"
                    alt="<?= esc($product['title']) ?>">
            <?php endif; ?>
        <?php else: ?>
            <div class="bg-secondary rounded d-flex align-items-center justify-content-center text-white w-100 shadow-sm text-center p-4"
                style="min-height: 400px;">
                <h1 class="display-5 fw-bold"><?= esc($product['title']) ?></h1>
            </div>
        <?php endif; ?>

        <div class="mt-5">
            <h3 class="fw-bold mb-4">Deskripsi Produk</h3>
            <div class="fs-5" style="line-height: 1.8;">
                <?= $product['description'] ?>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="position-sticky" style="top: 2rem;">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h2 fw-bold mb-3">
                        <?= esc($product['title']) ?>
                    </h1>

                    <div class="d-flex align-items-center mb-4 flex-wrap">
                        <?php if (isset($product['discount_percentage']) && $product['discount_percentage'] > 0): ?>
                            <?php $discountedPrice = $product['price'] - ($product['price'] * ($product['discount_percentage'] / 100)); ?>
                            <div class="w-100 mb-1">
                                <span class="text-muted text-decoration-line-through fs-5">Rp
                                    <?= number_format($product['price'], 0, ',', '.') ?></span>
                                <span class="badge bg-danger ms-2 fs-6">-<?= $product['discount_percentage'] ?>% OFF</span>
                            </div>
                            <span class="fs-1 fw-bold text-danger">Rp
                                <?= number_format($discountedPrice, 0, ',', '.') ?></span>
                        <?php else: ?>
                            <span class="fs-2 fw-bold text-dark">Rp
                                <?= number_format($product['price'], 0, ',', '.') ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($product['features'])):
                        $featuresList = json_decode($product['features'], true);
                        if (!is_array($featuresList)) {
                            // fallback if not JSON array
                            $featuresList = explode("\n", $product['features']);
                        }
                        ?>
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Fitur Utama:</h5>
                            <ul class="list-unstyled">
                                <?php foreach ($featuresList as $feature): ?>
                                    <?php if (trim($feature) !== ''): ?>
                                        <li class="mb-2 d-flex align-items-start">
                                            <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                            <span>
                                                <?= esc($feature) ?>
                                            </span>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid gap-2 mt-4">
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20tertarik%20membeli%20source%20code%20<?= urlencode($product['title']) ?>."
                            target="_blank" class="btn btn-dark btn-lg py-3 rounded-pill fw-bold">
                            <i class="bi bi-whatsapp"></i> Beli Sekarang
                        </a>

                        <?php if (!empty($product['demo_url'])): ?>
                            <a href="<?= esc($product['demo_url']) ?>" target="_blank"
                                class="btn btn-outline-dark btn-lg py-3 rounded-pill fw-bold mt-2">
                                <i class="bi bi-box-arrow-up-right"></i> Lihat Demo
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="text-muted small mt-4 text-center">
                        <i class="bi bi-shield-check"></i> Pembelian mudah dan aman via WhatsApp
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>