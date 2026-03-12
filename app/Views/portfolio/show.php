<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('portfolio') ?>" class="text-decoration-none text-muted"><i class="bi bi-arrow-left"></i>
        Kembali ke Portfolio</a>
</div>

<div class="row g-5">
    <div class="col-lg-8">
        <?php if (!empty($project['image_path'])): ?>
            <img src="<?= base_url(esc($project['image_path'])) ?>"
                class="img-fluid rounded shadow-sm w-100 object-fit-cover mb-4" style="max-height: 500px;"
                alt="<?= esc($project['title']) ?>" data-fallback="<?= htmlspecialchars($project['title'], ENT_QUOTES) ?>"
                onerror="this.onerror=null; this.outerHTML='<div class=\'bg-secondary rounded d-flex align-items-center justify-content-center text-white w-100 shadow-sm text-center p-4 mb-4\' style=\'min-height: 400px;\'><h1 class=\'display-5 fw-bold\'>' + this.getAttribute('data-fallback') + '</h1></div>';">
        <?php else: ?>
            <div class="bg-secondary rounded d-flex align-items-center justify-content-center text-white w-100 shadow-sm text-center p-4 mb-4"
                style="min-height: 400px;">
                <h1 class="display-5 fw-bold">
                    <?= esc($project['title']) ?>
                </h1>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <h1 class="fw-bold mb-3">
                <?= esc($project['title']) ?>
            </h1>
            <div class="d-flex align-items-center text-muted mb-4 pb-4 border-bottom">
                <i class="bi bi-calendar3 me-2"></i>
                <span>Tahun Rilis:
                    <?= date('Y', strtotime($project['created_at'])) ?>
                </span>
            </div>

            <div class="fs-5" style="line-height: 1.8;">
                <?= nl2br(esc($project['description'])) ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="position-sticky" style="top: 2rem;">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Project Details</h5>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Technologies Used:</h6>
                        <div>
                            <?php
                            $tools = explode(',', $project['tools']);
                            foreach ($tools as $tool):
                                $tool = trim($tool);
                                if (empty($tool))
                                    continue;
                                ?>
                                <span class="badge bg-light text-dark border fw-normal me-1 mb-2 px-2 py-1 fs-6">
                                    <?= esc($tool) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php if (!empty($project['project_url'])): ?>
                        <div class="d-grid gap-2">
                            <a href="<?= esc($project['project_url']) ?>" target="_blank" rel="noopener noreferrer"
                                class="btn btn-dark btn-lg py-3 rounded-pill fw-bold">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Kunjungi Proyek
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [data-theme="dark"] .badge.bg-light {
        background-color: #2a2a2a !important;
        color: var(--text-color) !important;
        border-color: var(--border-color) !important;
    }
</style>
<?= $this->endSection() ?>