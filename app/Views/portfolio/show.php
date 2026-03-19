<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="<?= base_url('portfolio') ?>" class="text-decoration-none text-muted"><i class="bi bi-arrow-left"></i>
        Kembali ke Portfolio</a>
</div>

<div class="row g-5">
    <div class="col-lg-8">
        <?php if (!empty($project['image_path'])): ?>
            <?php 
                $images = explode(';', $project['image_path']); 
                if (count($images) > 1): 
            ?>
                <div id="portfolioCarousel" class="carousel slide mb-4 shadow-sm rounded overflow-hidden" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($images as $index => $img): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= base_url(esc(trim($img))) ?>" class="d-block w-100 object-fit-cover" style="max-height: 500px;" alt="<?= esc($project['title']) ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#portfolioCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#portfolioCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            <?php else: ?>
                <img src="<?= base_url(esc(trim($images[0]))) ?>"
                    class="img-fluid rounded shadow-sm w-100 object-fit-cover mb-4" style="max-height: 500px;"
                    alt="<?= esc($project['title']) ?>">
            <?php endif; ?>
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
                        <div class="d-grid gap-2 mb-4">
                            <a href="<?= esc($project['project_url']) ?>" target="_blank" rel="noopener noreferrer"
                                class="btn btn-dark rounded-pill fw-bold">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Kunjungi Proyek
                            </a>
                        </div>
                    <?php endif; ?>

                    <hr class="my-4">
                    <h6 class="text-muted mb-3">Bagikan Proyek Ini:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $shareUrl = urlencode(current_url());
                        $shareTitle = urlencode($project['title']);
                        ?>
                        <a href="https://twitter.com/intent/tweet?text=<?= $shareTitle ?>&url=<?= $shareUrl ?>" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3"><i class="bi bi-twitter-x"></i> X</a>
                        <a href="https://threads.net/intent/post?text=<?= $shareTitle ?>%20<?= $shareUrl ?>" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3"><i class="bi bi-threads"></i> Threads</a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $shareUrl ?>" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3"><i class="bi bi-linkedin"></i> LinkedIn</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3"><i class="bi bi-facebook"></i> Facebook</a>
                        <a href="https://api.whatsapp.com/send?text=<?= $shareTitle ?>%20<?= $shareUrl ?>" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3"><i class="bi bi-whatsapp"></i> WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>