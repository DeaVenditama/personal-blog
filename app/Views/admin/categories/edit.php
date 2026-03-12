<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Edit Category</h5>
                <a href="<?= base_url('admin/categories') ?>" class="btn btn-light border btn-sm shadow-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger px-3 py-2 small border-0 shadow-sm">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/categories/update/' . $category['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Category Name</label>
                    <input type="text" name="name" class="form-control" value="<?= old('name', $category['name']) ?>"
                        required placeholder="e.g. Technology">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Slug (Auto-generated)</label>
                    <input type="text" class="form-control bg-light text-muted" value="<?= esc($category['slug']) ?>"
                        disabled>
                    <small class="text-muted" style="font-size: 0.75rem;">The slug will automatically update based on
                        the new name.</small>
                </div>

                <div class="mt-4 pt-3 border-top d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100">Update Category</button>
                    <a href="<?= base_url('admin/categories') ?>" class="btn btn-light border w-100">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>