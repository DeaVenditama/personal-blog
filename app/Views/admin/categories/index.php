<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4">
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3">Add Category</h5>
            <form action="<?= base_url('admin/categories/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label text-muted small">Category Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Technology">
                </div>
                <button type="submit" class="btn btn-dark w-100">Save Category</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Manage Categories</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td><strong>
                                            <?= esc($cat['name']) ?>
                                        </strong></td>
                                    <td><span class="text-muted">
                                            <?= esc($cat['slug']) ?>
                                        </span></td>
                                    <td class="text-end">
                                        <div class="d-flex flex-wrap gap-1 justify-content-end">
                                            <a href="<?= base_url('admin/categories/delete/' . $cat['id']) ?>"
                                                class="btn btn-sm btn-light border text-danger"
                                                onclick="return confirm('Delete this category?');"><i class="bi bi-trash"></i>
                                                Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No categories created yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>