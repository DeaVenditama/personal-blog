<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px; /* Optional: adds nice rounded corners */
        display: block; /* Helps with margins if needed */
        margin: 1rem auto; /* Centers the image */
    }
</style>

<div class="mb-4">
    <a href="<?= base_url() ?>" class="text-decoration-none text-muted"><i class="bi bi-arrow-left"></i> Kembali ke
        Beranda</a>
</div>

<article class="post-detail">
    <h1 class="display-4 fw-bold mb-3">
        <?= esc($post['title']) ?>
    </h1>

    <div class="post-meta mb-5 pb-3 border-bottom d-flex align-items-center">
        <span><i class="bi bi-calendar3"></i>
            <?= date('M d, Y', strtotime($post['published_at'])) ?>
        </span>

        <?php if (!empty($post['category_name'])): ?>
            <span class="mx-3">&bull;</span>
            <a href="<?= base_url('category/' . $post['category_slug']) ?>" class="text-decoration-none text-muted">
                <i class="bi bi-folder"></i> <?= esc($post['category_name']) ?>
            </a>
        <?php endif; ?>

        <span class="mx-3">&bull;</span>
        <span><i class="bi bi-eye"></i>
            <?= $post['read_count'] ?> tayangan
        </span>
        <span class="mx-3">&bull;</span>
        <span><i class="bi bi-clock"></i>
            <?= ceil(str_word_count(strip_tags((string) $post['content'])) / 200) ?> mnt baca
        </span>
    </div>

    <div class="post-content fs-5" style="line-height: 1.8;">
        <?= $post['content'] ?>
    </div>

    <div class="mt-5 pt-4 border-top">
        <h5 class="fw-bold mb-3 text-muted">Terima kasih telah membaca!</h5>
        <div class="d-flex gap-2">
            <?php
            $shareUrl = urlencode(current_url());
            $shareTitle = urlencode($post['title']);
            ?>
            <a href="https://twitter.com/intent/tweet?text=<?= $shareTitle ?>&url=<?= $shareUrl ?>" target="_blank"
                rel="noopener noreferrer" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                <i class="bi bi-twitter-x"></i> Bagikan ke X
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $shareUrl ?>" target="_blank"
                rel="noopener noreferrer" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                <i class="bi bi-linkedin"></i> Bagikan ke LinkedIn
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>" target="_blank"
                rel="noopener noreferrer" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                <i class="bi bi-facebook"></i> Bagikan
            </a>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="mt-5 pt-4" id="comments-section">
        <h4 class="fw-bold mb-4">Komentar (<?= isset($totalMainComments) ? $totalMainComments : count($comments) ?>)</h4>

        <!-- Comment Form -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-3">Tinggalkan Komentar</h5>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('comments/store/' . $post['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>"
                                required>
                            <div class="form-text">Email Anda tidak akan dipublikasikan.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Komentar <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="comment" name="comment" rows="4"
                            required><?= old('comment') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark">Kirim Komentar</button>
                </form>
            </div>
        </div>

        <!-- Comments List -->
        <div class="comments-list">
            <?php if (empty($comments)): ?>
                <p class="text-muted text-center py-4 bg-light rounded">Belum ada komentar. Jadilah yang pertama
                    berkomentar!</p>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px; font-size: 1.2rem;">
                                <?= strtoupper(substr(esc($comment['name']), 0, 1)) ?>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1 text-dark fw-bold">
                                <?= esc($comment['name']) ?>
                                <?php if ($comment['is_admin']): ?>
                                    <span class="badge bg-primary ms-1"
                                        style="font-size: 0.7em; vertical-align: middle;">Admin</span>
                                <?php endif; ?>
                            </h5>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-clock"></i> <?= date('d M Y, H:i', strtotime($comment['created_at'])) ?>
                            </p>
                            <div class="text-dark bg-light p-3 rounded">
                                <?= nl2br(esc($comment['comment'])) ?>
                            </div>

                            <!-- Level 1 Reply Button (Accessible to All Users) -->
                            <button class="btn btn-sm btn-link text-decoration-none mt-2 p-0" type="button"
                                data-bs-toggle="collapse" data-bs-target="#replyForm<?= $comment['id'] ?>" aria-expanded="false"
                                aria-controls="replyForm<?= $comment['id'] ?>">
                                <i class="bi bi-reply"></i> Balas
                            </button>

                            <div class="collapse mt-3" id="replyForm<?= $comment['id'] ?>">
                                <div class="card card-body bg-light border-0">
                                    <form action="<?= base_url('comments/store/' . $post['id']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="parent_id" value="<?= $comment['id'] ?>">
                                        
                                        <?php if (!session()->get('isLoggedIn')): ?>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Nama" required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <input type="email" name="email" class="form-control form-control-sm" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="mb-3">
                                            <textarea class="form-control" name="comment" rows="2" placeholder="Balasan Anda..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-dark">Kirim Balasan</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Nested Replies (Level 1 and Level 2) -->
                            <?php if (!empty($comment['replies'])): ?>
                                <div class="mt-4 ms-2 ms-md-4 ps-3 ps-md-4 border-start border-2 border-primary">
                                    <?php foreach ($comment['replies'] as $reply): ?>
                                        <div class="d-flex mb-3">
                                            <div class="flex-shrink-0">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px; font-size: 1rem;">
                                                    <?= strtoupper(substr(esc($reply['name']), 0, 1)) ?>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 text-dark fw-bold">
                                                    <?= esc($reply['name']) ?>
                                                    <?php if ($reply['is_admin']): ?>
                                                        <span class="badge bg-primary ms-1"
                                                            style="font-size: 0.7em; vertical-align: middle;">Admin</span>
                                                    <?php endif; ?>
                                                </h6>
                                                <p class="text-muted small mb-2">
                                                    <i class="bi bi-clock"></i>
                                                    <?= date('d M Y, H:i', strtotime($reply['created_at'])) ?>
                                                </p>
                                                <div class="text-dark bg-white p-3 rounded shadow-sm border mb-2">
                                                    <?= nl2br(esc($reply['comment'])) ?>
                                                </div>
                                                
                                                <!-- Level 2 Reply Button -->
                                                <button class="btn btn-sm btn-link text-decoration-none p-0" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#replyForm<?= $reply['id'] ?>" aria-expanded="false"
                                                    aria-controls="replyForm<?= $reply['id'] ?>">
                                                    <i class="bi bi-reply"></i> Balas
                                                </button>

                                                <div class="collapse mt-3" id="replyForm<?= $reply['id'] ?>">
                                                    <div class="card card-body bg-light border-0">
                                                        <form action="<?= base_url('comments/store/' . $post['id']) ?>" method="post">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="parent_id" value="<?= $reply['id'] ?>">
                                                            
                                                            <?php if (!session()->get('isLoggedIn')): ?>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-2">
                                                                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Nama" required>
                                                                </div>
                                                                <div class="col-md-6 mb-2">
                                                                    <input type="email" name="email" class="form-control form-control-sm" placeholder="Email" required>
                                                                </div>
                                                            </div>
                                                            <?php endif; ?>
                                                            
                                                            <div class="mb-3">
                                                                <textarea class="form-control" name="comment" rows="2" placeholder="Balasan untuk <?= esc($reply['name']) ?>..." required></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-sm btn-dark">Kirim Balasan</button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- Level 2 Replies (Grandchildren) -->
                                                <?php if (!empty($reply['replies'])): ?>
                                                    <div class="mt-3 ms-2 ms-md-4 ps-3 border-start border-2 border-secondary">
                                                        <?php foreach ($reply['replies'] as $sub_reply): ?>
                                                            <div class="d-flex mb-3">
                                                                <div class="flex-shrink-0">
                                                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                                        style="width: 32px; height: 32px; font-size: 0.9rem;">
                                                                        <?= strtoupper(substr(esc($sub_reply['name']), 0, 1)) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h6 class="mb-1 text-dark fw-bold" style="font-size: 0.9rem;">
                                                                        <?= esc($sub_reply['name']) ?>
                                                                        <?php if ($sub_reply['is_admin']): ?>
                                                                            <span class="badge bg-primary ms-1"
                                                                                style="font-size: 0.7em; vertical-align: middle;">Admin</span>
                                                                        <?php endif; ?>
                                                                    </h6>
                                                                    <p class="text-muted small mb-1" style="font-size: 0.75rem;">
                                                                        <i class="bi bi-clock"></i>
                                                                        <?= date('d M Y, H:i', strtotime($sub_reply['created_at'])) ?>
                                                                    </p>
                                                                    <div class="text-dark bg-white p-2 rounded shadow-sm border" style="font-size: 0.9rem;">
                                                                        <?= nl2br(esc($sub_reply['comment'])) ?>
                                                                    </div>
                                                                    <!-- Max Depth Reached: No more reply buttons here -->
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <?php if (isset($totalMainComments) && $totalMainComments > $currentLimit): ?>
            <div class="text-center mt-4">
                <a href="?limit=<?= $currentLimit + 10 ?>#comments-section" class="btn btn-outline-dark rounded-pill px-4">
                    Tampilkan Lebih Banyak Komentar...
                </a>
            </div>
        <?php endif; ?>
    </div>
</article>

<?= $this->endSection() ?>