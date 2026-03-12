<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-inbox me-2"></i> Inbox Messages</h5>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="width: 40%;">Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td class="text-muted small">
                                <?= date('d M Y, H:i', strtotime($msg['created_at'])) ?>
                            </td>
                            <td><strong>
                                    <?= esc($msg['name']) ?>
                                </strong></td>
                            <td><a href="mailto:<?= esc($msg['email']) ?>" class="text-decoration-none">
                                    <?= esc($msg['email']) ?>
                                </a></td>
                            <td>
                                <div style="max-height: 80px; overflow-y: auto; font-size: 0.9rem;" class="text-muted pe-2">
                                    <?= nl2br(esc($msg['message'])) ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="<?= base_url('admin/messages/show/' . $msg['id']) ?>"
                                        class="btn btn-sm btn-light border text-primary" title="View Message">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="<?= base_url('admin/messages/delete/' . $msg['id']) ?>"
                                        class="btn btn-sm btn-light border text-danger"
                                        onclick="return confirm('Delete this message?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            Belum ada pesan masuk dari pengunjung.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>