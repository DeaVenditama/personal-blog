<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">View Post:
        <?= esc($post['title']) ?>
    </h5>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/posts/edit/' . $post['id']) ?>" class="btn btn-outline-dark btn-sm shadow-sm">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="<?= base_url('admin/posts') ?>" class="btn btn-light border btn-sm shadow-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card p-4 border-0 shadow-sm mb-4">
    <div class="mb-3 d-flex flex-wrap gap-2">
        <span class="badge bg-secondary">
            <?= esc($post['status']) ?>
        </span>
        <span class="badge bg-light text-dark border"><i class="bi bi-eye"></i>
            <?= $post['read_count'] ?> Reads
        </span>
    </div>

    <div class="typography-content" style="line-height: 1.8;">
        <?= $post['content'] ?>
    </div>
</div>
<?= $this->endSection() ?>