<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Comments on: <?= esc($post['title']) ?></h5>
    <a href="<?= base_url('admin/posts') ?>" class="btn btn-light border btn-sm shadow-sm">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card p-4 border-0 shadow-sm mb-4">
    <div class="fw-bold mb-4">Discussion Thread</div>
    <?php if (empty($comments)): ?>
        <div class="text-muted text-center py-4">No comments on this post yet.</div>
    <?php else: ?>
        <ul class="list-unstyled mb-0">
            <?php foreach ($comments as $c): ?>
                <li class="mb-4">
                    <div class="d-flex">
                        <div class="me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; font-size: 1.1rem;">
                                <?= strtoupper(substr($c['name'], 0, 1)) ?>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0 fw-bold">
                                        <?= esc($c['name']) ?>
                                        <?php if ($c['is_admin']): ?> <span class="badge bg-success ms-1" style="font-size: 0.7rem;">Admin</span> <?php endif; ?>
                                    </h6>
                                    <small class="text-muted"><?= date('d M Y, H:i', strtotime($c['created_at'])) ?></small>
                                </div>
                                <p class="mb-1 text-dark" style="font-size: 0.95rem;"><?= nl2br(esc($c['comment'])) ?></p>
                                
                                <button class="btn btn-sm btn-link text-decoration-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#replyForm<?= $c['id'] ?>">
                                    Reply
                                </button>
                                
                                <div class="collapse mt-2" id="replyForm<?= $c['id'] ?>">
                                    <form action="<?= base_url('admin/posts/replyComment/' . $post['id']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="parent_id" value="<?= $c['id'] ?>">
                                        <div class="mb-2">
                                            <textarea class="form-control form-control-sm" name="comment" rows="2" placeholder="Write a reply..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Post Reply</button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Level 1 Replies -->
                            <?php if (!empty($c['replies'])): ?>
                                <ul class="list-unstyled mt-3 ps-4 border-start border-2 border-primary">
                                    <?php foreach ($c['replies'] as $reply): ?>
                                        <li class="mb-3 ps-3">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                                        <?= strtoupper(substr($reply['name'], 0, 1)) ?>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="bg-light p-2 rounded shadow-sm border">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <strong class="mb-0" style="font-size: 0.9rem;">
                                                                <?= esc($reply['name']) ?>
                                                                <?php if ($reply['is_admin']): ?> <span class="badge bg-success ms-1" style="font-size: 0.65rem;">Admin</span> <?php endif; ?>
                                                            </strong>
                                                            <small class="text-muted" style="font-size: 0.75rem;"><?= date('d M Y, H:i', strtotime($reply['created_at'])) ?></small>
                                                        </div>
                                                        <p class="mb-1 text-dark" style="font-size: 0.9rem;"><?= nl2br(esc($reply['comment'])) ?></p>
                                                        
                                                        <button class="btn btn-sm btn-link text-decoration-none p-0" style="font-size: 0.8rem;" type="button" data-bs-toggle="collapse" data-bs-target="#replyForm<?= $reply['id'] ?>">
                                                            Reply
                                                        </button>
                                                        
                                                        <div class="collapse mt-2" id="replyForm<?= $reply['id'] ?>">
                                                            <form action="<?= base_url('admin/posts/replyComment/' . $post['id']) ?>" method="post">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="parent_id" value="<?= $reply['id'] ?>">
                                                                <div class="mb-2">
                                                                    <textarea class="form-control form-control-sm" name="comment" rows="2" placeholder="Write a reply..." required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.8rem;">Post Reply</button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <!-- Level 2 Replies -->
                                                    <?php if (!empty($reply['replies'])): ?>
                                                        <ul class="list-unstyled mt-2 ps-3 border-start border-2 border-secondary">
                                                            <?php foreach ($reply['replies'] as $grandchild): ?>
                                                                <li class="mb-2 ps-2 mt-2">
                                                                    <div class="d-flex">
                                                                        <div class="me-2">
                                                                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; font-size: 0.75rem;">
                                                                                <?= strtoupper(substr($grandchild['name'], 0, 1)) ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <div class="bg-white p-2 text-dark rounded border border-light shadow-sm">
                                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                                    <strong class="mb-0 text-muted" style="font-size: 0.8rem;">
                                                                                        <?= esc($grandchild['name']) ?>
                                                                                        <?php if ($grandchild['is_admin']): ?> <span class="badge bg-success ms-1" style="font-size: 0.6rem;">Admin</span> <?php endif; ?>
                                                                                    </strong>
                                                                                </div>
                                                                                <p class="mb-0" style="font-size: 0.85rem;"><?= nl2br(esc($grandchild['comment'])) ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
