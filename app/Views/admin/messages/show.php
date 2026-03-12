<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-envelope-open me-2"></i> Detail Pesan</h5>
    <a href="<?= base_url('admin/messages') ?>" class="btn btn-light border btn-sm shadow-sm">
        <i class="bi bi-arrow-left"></i> Kembali ke Inbox
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 50px; height: 50px; font-size: 1.25rem; font-weight: bold;">
                    <?= strtoupper(substr(esc($message['name']), 0, 1)) ?>
                </div>
                <div>
                    <h5 class="mb-1 fw-bold">
                        <?= esc($message['name']) ?>
                    </h5>
                    <div class="text-muted small">
                        <i class="bi bi-envelope me-1"></i>
                        <a href="mailto:<?= esc($message['email']) ?>" class="text-decoration-none text-muted">
                            <?= esc($message['email']) ?>
                        </a>
                    </div>
                </div>
                <div class="ms-auto text-end text-muted small">
                    <div>
                        <?= date('d M Y', strtotime($message['created_at'])) ?>
                    </div>
                    <div>
                        <?= date('H:i', strtotime($message['created_at'])) ?>
                    </div>
                </div>
            </div>

            <div class="message-content" style="line-height: 1.8; font-size: 1.05rem;">
                <?= nl2br(esc($message['message'])) ?>
            </div>

            <div class="mt-5 pt-3 border-top d-flex gap-2">
                <a href="mailto:<?= esc($message['email']) ?>" class="btn btn-primary d-inline-flex align-items-center">
                    <i class="bi bi-reply-fill me-2"></i> Balas Email
                </a>
                <a href="<?= base_url('admin/messages/delete/' . $message['id']) ?>"
                    class="btn btn-outline-danger d-inline-flex align-items-center"
                    onclick="return confirm('Delete this message?');">
                    <i class="bi bi-trash me-2"></i> Hapus Pesan
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>