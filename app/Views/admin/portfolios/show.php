<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">View Project:
        <?= esc($portfolio['title']) ?>
    </h5>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/portfolios/edit/' . $portfolio['id']) ?>"
            class="btn btn-outline-dark btn-sm shadow-sm">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="<?= base_url('admin/portfolios') ?>" class="btn btn-light border btn-sm shadow-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 mb-4">
            <div class="mb-3 d-flex flex-wrap gap-2">
                <span class="badge bg-secondary">
                    <?= esc($portfolio['status']) ?>
                </span>
                <span class="badge bg-light text-dark border"><i class="bi bi-sort-numeric-down"></i> Sort Order:
                    <?= esc($portfolio['sort_order']) ?>
                </span>
                <?php if (!empty($portfolio['project_url'])): ?>
                    <a href="<?= esc($portfolio['project_url']) ?>" target="_blank"
                        class="badge bg-primary text-decoration-none">
                        <i class="bi bi-link-45deg"></i> Visit Project URL
                    </a>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold text-muted small text-uppercase">Tools / Tech Stack</h6>
                <div class="bg-light p-2 rounded border small">
                    <?= esc($portfolio['tools']) ?>
                </div>
            </div>

            <div>
                <h6 class="fw-bold text-muted small text-uppercase">Description</h6>
                <div class="typography-content" style="line-height: 1.8;">
                    <?= $portfolio['description'] ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <?php if (!empty($portfolio['image_path'])): ?>
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h6 class="fw-bold text-muted small text-uppercase mb-3">Project Images</h6>
                <div class="text-center bg-light rounded p-3 border d-flex flex-column gap-3">
                    <?php 
                    $images = explode(';', $portfolio['image_path']);
                    foreach ($images as $img): 
                    ?>
                    <img src="<?= base_url(trim($img)) ?>" alt="<?= esc($portfolio['title']) ?>"
                        class="img-fluid rounded shadow-sm mx-auto d-block" style="max-height: 400px; object-fit: contain;">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>