<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="mb-3">
    <a href="<?= base_url('admin/portfolios') ?>" class="text-decoration-none text-muted"><i
            class="bi bi-arrow-left"></i>
        Back to Portfolios</a>
</div>

<div class="card p-4">
    <h5 class="fw-bold mb-4">Add New Portfolio Project</h5>
    <form action="<?= base_url('admin/portfolios/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label text-muted small"><strong>Project Title</strong></label>
                    <input type="text" name="title" class="form-control" required placeholder="Enter project name..."
                        value="<?= old('title') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small"><strong>Description</strong></label>
                    <textarea name="description" class="form-control" rows="5" required
                        placeholder="Describe the project..."><?= old('description') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small"><strong>Tools / Technologies</strong></label>
                    <input type="text" name="tools" class="form-control" required
                        placeholder="e.g. PHP, Laravel, Vue.js..." value="<?= old('tools') ?>">
                    <div class="form-text">Comma separated values</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small"><strong>Project URL (Optional)</strong></label>
                    <input type="url" name="project_url" class="form-control" placeholder="https://..."
                        value="<?= old('project_url') ?>">
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 p-3 mb-3">
                    <label class="form-label text-muted small"><strong>Status</strong></label>
                    <select name="status" class="form-select mb-3">
                        <option value="draft" <?= old('status') == 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= old('status') == 'published' ? 'selected' : '' ?>>Published</option>
                    </select>

                    <label class="form-label text-muted small"><strong>Sort Order</strong></label>
                    <input type="number" name="sort_order" class="form-control mb-3" min="0"
                        value="<?= old('sort_order', 0) ?>">
                </div>

                <div class="card bg-light border-0 p-3 mb-3">
                    <label class="form-label text-muted small"><strong>Project Image</strong></label>
                    <input type="file" name="image" class="form-control mb-2" accept="image/*" required id="imageInput">
                    <div class="text-center mt-2">
                        <img id="imagePreview" src="" alt="Preview"
                            style="max-width: 100%; display: none; border-radius: 4px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <a href="<?= base_url('admin/portfolios') ?>" class="btn btn-light border me-2">Cancel</a>
            <button type="submit" class="btn btn-dark">Save Project</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('imageInput').addEventListener('change', function (e) {
        if (e.target.files && e.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                let img = document.getElementById('imagePreview');
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
<?= $this->endSection() ?>