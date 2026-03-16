<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php if (isset($title) && strpos($title, 'Category: ') === 0): ?>
    <div class="mb-4 pb-2 border-bottom">
        <h4 class="fw-bold"><?= esc($title) ?></h4>
        <p class="text-muted"><?= count($posts) ?> artikel dalam kategori ini.</p>
    </div>
<?php endif; ?>

<?php if (!empty($searchQuery)): ?>
    <div class="mb-4 pb-2 border-bottom">
        <h4 class="fw-bold">Hasil pencarian untuk: "<?= esc($searchQuery) ?>"</h4>
        <p class="text-muted"><?= count($posts) ?> ditemukan.</p>
    </div>
<?php endif; ?>

<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <article class="post-card">
            <div class="post-meta">
                <span>
                    <?= date('M d, Y', strtotime($post['published_at'])) ?>
                </span>

                <?php if (!empty($post['category_name'])): ?>
                    <span class="mx-2">&bull;</span>
                    <a href="<?= base_url('category/' . $post['category_slug']) ?>" class="text-decoration-none text-muted">
                        <?= esc($post['category_name']) ?>
                    </a>
                <?php endif; ?>

                <span class="mx-2">&bull;</span>
                <span><i class="bi bi-eye"></i>
                    <?= $post['read_count'] ?> tayangan
                </span>

                <span class="mx-2">&bull;</span>
                <span><i class="bi bi-clock"></i>
                    <?= ceil(str_word_count(strip_tags((string) $post['content'])) / 200) ?> mnt baca
                </span>
            </div>

            <?php 
                $thumbnail_url = null;
                if (!empty($post['image_path'])) {
                    $thumbnail_url = base_url($post['image_path']);
                } else {
                    // Try to extract first image from content
                    // Summernote often uses data:image/base64 so the src can be very long
                    if (preg_match('/<img[^>]+src=(?:\"|\')([^\"\']+)(?:\"|\')[^>]*>/i', $post['content'], $match)) {
                        $thumbnail_url = $match[1];
                    }
                }
            ?>

            <?php if (!empty($thumbnail_url)): ?>
                <div class="mb-3 rounded overflow-hidden shadow-sm" style="height: 200px;">
                    <a href="<?= base_url($post['slug']) ?>">
                        <img src="<?= $thumbnail_url ?>" class="w-100 h-100 object-fit-cover"
                            alt="<?= esc($post['title']) ?>" data-fallback="<?= htmlspecialchars($post['title'], ENT_QUOTES) ?>"
                            onerror="this.onerror=null; this.outerHTML='<div class=\'w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white p-3 text-center\'><strong>' + this.getAttribute('data-fallback') + '</strong></div>';">
                    </a>
                </div>
            <?php else: ?>
                <div class="mb-3 rounded overflow-hidden shadow-sm" style="height: 200px;">
                    <a href="<?= base_url($post['slug']) ?>"
                        class="text-decoration-none text-white w-100 h-100 d-flex align-items-center justify-content-center bg-secondary p-3 text-center">
                        <strong><?= esc($post['title']) ?></strong>
                    </a>
                </div>
            <?php endif; ?>

            <a href="<?= base_url($post['slug']) ?>" class="text-decoration-none">
                <h2 class="post-title mb-3">
                    <?= esc($post['title']) ?>
                </h2>
            </a>

            <p class="post-excerpt">
                <?= substr(strip_tags($post['content']), 0, 200) ?>...
            </p>

            <a href="<?= base_url($post['slug']) ?>" class="read-more">Baca selengkapnya <i class="bi bi-arrow-right"></i></a>
        </article>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center py-5">
        <h3 class="fw-bold text-muted mb-3">Belum Ada Artikel</h3>
        <p class="text-muted">Kembali lagi nanti untuk melihat konten menarik lainnya.</p>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>