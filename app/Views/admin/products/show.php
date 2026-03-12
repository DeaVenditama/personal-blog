<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">View Product:
        <?= esc($product['title']) ?>
    </h5>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/products/edit/' . $product['id']) ?>"
            class="btn btn-outline-dark btn-sm shadow-sm">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="<?= base_url('admin/products') ?>" class="btn btn-light border btn-sm shadow-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
            <div class="mb-4 text-center bg-light rounded p-3 border">
                <?php if ($product['thumbnail']): ?>
                    <img src="<?= base_url('uploads/products/' . $product['thumbnail']) ?>"
                        alt="<?= esc($product['title']) ?>" class="img-fluid rounded shadow-sm"
                        style="max-height: 400px; object-fit: contain;">
                <?php else: ?>
                    <div class="py-5 text-muted"><i class="bi bi-image" style="font-size: 3rem;"></i><br>No thumbnail</div>
                <?php endif; ?>
            </div>

            <div class="mb-3 d-flex flex-wrap gap-2">
                <?php if ($product['is_active']): ?>
                    <span class="badge bg-success">Aktif</span>
                <?php else: ?>
                    <span class="badge bg-secondary">Nonaktif</span>
                <?php endif; ?>
                <span class="badge bg-light text-dark border"><i class="bi bi-tag"></i> Harga: Rp
                    <?= number_format($product['price'], 0, ',', '.') ?>
                </span>

                <?php if (!empty($product['demo_url'])): ?>
                    <a href="<?= esc($product['demo_url']) ?>" target="_blank"
                        class="badge bg-primary text-decoration-none">
                        <i class="bi bi-play-circle"></i> Live Demo
                    </a>
                <?php endif; ?>
            </div>

            <div>
                <h6 class="fw-bold text-muted small text-uppercase mt-4">Description</h6>
                <div class="typography-content" style="line-height: 1.8;">
                    <?= $product['description'] ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
            <h6 class="fw-bold text-muted small text-uppercase mb-3">Features Included</h6>
            <ul class="list-group list-group-flush border rounded">
                <?php
                $features = json_decode($product['features'], true) ?: [];
                if (!empty($features)):
                    foreach ($features as $feature):
                        if (trim($feature) !== ''):
                            ?>
                            <li class="list-group-item bg-light border-bottom border-white d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 border-0"></i>
                                <?= esc(trim($feature)) ?>
                            </li>
                        <?php
                        endif;
                    endforeach;
                else:
                    ?>
                    <li class="list-group-item text-muted text-center py-3">No specific features listed.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>