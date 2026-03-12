<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-5 border-bottom pb-4 text-center">
    <h1 class="fw-bold mb-3" style="font-size: 2.5rem;">Portfolio</h1>
    <p class="text-muted fs-5">A selection of my recent work and projects.</p>
</div>

<div class="row g-4 mb-5">
    <?php if (!empty($portfolios)): ?>
        <?php foreach ($portfolios as $project): ?>
            <div class="col-md-6 border-bottom pb-4 mb-2">
                <div class="project-card d-flex flex-column h-100">
                    <?php if (!empty($project['image_path'])): ?>
                        <div class="project-image-wrapper mb-3 overflow-hidden rounded shadow-sm" style="height: 240px;">
                            <a href="<?= base_url('portfolio/' . $project['id']) ?>" class="text-decoration-none">
                                <img src="<?= base_url(esc($project['image_path'])) ?>" alt="<?= esc($project['title']) ?>"
                                    class="w-100 h-100 object-fit-cover transition-transform hover-scale"
                                    data-fallback="<?= htmlspecialchars($project['title'], ENT_QUOTES) ?>"
                                    onerror="this.onerror=null; this.outerHTML='<div class=\'w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white p-3 text-center transition-transform hover-scale\'><strong>' + this.getAttribute('data-fallback') + '</strong></div>';">
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="project-image-wrapper mb-3 overflow-hidden rounded shadow-sm" style="height: 240px;">
                            <a href="<?= base_url('portfolio/' . $project['id']) ?>"
                                class="text-decoration-none d-block w-100 h-100">
                                <div
                                    class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white p-3 text-center transition-transform hover-scale">
                                    <strong><?= esc($project['title']) ?></strong>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>

                    <h3 class="h4 fw-bold mb-2">
                        <a href="<?= base_url('portfolio/' . $project['id']) ?>"
                            class="text-decoration-none text-dark hover-accent">
                            <?= esc($project['title']) ?>
                        </a>
                    </h3>

                    <div class="mb-3">
                        <?php
                        $tools = explode(',', $project['tools']);
                        foreach ($tools as $tool):
                            $tool = trim($tool);
                            if (empty($tool))
                                continue;
                            ?>
                            <span class="badge bg-light text-dark border fw-normal me-1 mb-1">
                                <?= esc($tool) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>

                    <p class="text-muted flex-grow-1 mb-2">
                        <?= substr(strip_tags((string) $project['description']), 0, 150) ?>...
                    </p>
                    <a href="<?= base_url('portfolio/' . $project['id']) ?>"
                        class="text-decoration-none fw-bold text-dark hover-accent">
                        Baca Selengkapnya <i class="bi bi-arrow-right small"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 py-5 text-center">
            <h3 class="text-muted">More projects coming soon.</h3>
            <p>I'm currently updating my portfolio. Check back later!</p>
        </div>
    <?php endif; ?>
</div>

<style>
    .transition-transform {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.03);
    }

    .hover-accent:hover {
        color: var(--accent-color) !important;
        text-decoration: underline !important;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    [data-theme="dark"] .project-card a.text-dark {
        color: var(--text-color) !important;
    }

    [data-theme="dark"] .badge.bg-light {
        background-color: #2a2a2a !important;
        color: var(--text-color) !important;
        border-color: var(--border-color) !important;
    }
</style>
<?= $this->endSection() ?>