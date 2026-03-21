<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="mb-3">
    <a href="<?= base_url('admin/portfolios') ?>" class="text-decoration-none text-muted"><i
            class="bi bi-arrow-left"></i>
        Back to Portfolios</a>
</div>

<div class="card p-4">
    <h5 class="fw-bold mb-4">Edit Portfolio Project:
        <?= esc($portfolio['title']) ?>
    </h5>
    <form action="<?= base_url('admin/portfolios/update/' . $portfolio['id']) ?>" method="post"
        enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label text-muted small"><strong>Project Title</strong></label>
                    <input type="text" name="title" class="form-control" required
                        value="<?= old('title', $portfolio['title']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small"><strong>Description</strong></label>
                    <textarea name="description" id="editor" class="form-control" rows="5"
                        required><?= old('description', $portfolio['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small"><strong>Tools / Technologies</strong></label>
                    <input type="text" name="tools" class="form-control" required
                        value="<?= old('tools', $portfolio['tools']) ?>">
                    <div class="form-text">Comma separated values</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small"><strong>Project URL (Optional)</strong></label>
                    <input type="url" name="project_url" class="form-control"
                        value="<?= old('project_url', $portfolio['project_url']) ?>">
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 p-3 mb-3">
                    <label class="form-label text-muted small"><strong>Status</strong></label>
                    <select name="status" class="form-select mb-3">
                        <option value="draft" <?= old('status', $portfolio['status']) == 'draft' ? 'selected' : '' ?>>Draft
                        </option>
                        <option value="published" <?= old('status', $portfolio['status']) == 'published' ? 'selected' : '' ?>>Published</option>
                    </select>

                    <label class="form-label text-muted small"><strong>Sort Order</strong></label>
                    <input type="number" name="sort_order" class="form-control mb-3" min="0"
                        value="<?= old('sort_order', $portfolio['sort_order']) ?>">
                </div>

                <div class="card bg-light border-0 p-3 mb-3">
                    <label class="form-label text-muted small"><strong>Project Image</strong></label>
                    <?php if (!empty($portfolio['image_path'])): ?>
                        <div class="mb-2">
                            <div class="form-text mt-1 mb-2">Current Images:</div>
                            <div class="d-flex flex-wrap gap-2">
                                <?php 
                                $oldImages = explode(';', $portfolio['image_path']);
                                foreach($oldImages as $oldImg):
                                ?>
                                    <img src="<?= base_url(trim($oldImg)) ?>" alt="Current Image"
                                        style="max-height: 80px; border-radius: 4px;" class="border shadow-sm">
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <input type="file" name="image[]" class="form-control mb-2" accept="image/*" multiple id="imageInput">
                    <div class="form-text text-muted mb-2">Leave empty to keep current images. You can select multiple images.</div>

                    <div class="d-flex flex-wrap gap-2 mt-2 justify-content-center" id="imagePreviewContainer">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <a href="<?= base_url('admin/portfolios') ?>" class="btn btn-light border me-2">Cancel</a>
            <button type="submit" class="btn btn-dark">Update Project</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('imageInput').addEventListener('change', function (e) {
        let previewContainer = document.getElementById('imagePreviewContainer');
        previewContainer.innerHTML = '';
        if (e.target.files && e.target.files.length > 0) {
            for(let i=0; i<e.target.files.length; i++) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    let img = document.createElement('img');
                    img.src = event.target.result;
                    img.style.maxHeight = '100px';
                    img.style.borderRadius = '4px';
                    img.classList.add('shadow-sm', 'border');
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(e.target.files[i]);
            }
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor').summernote({
            placeholder: 'Describe the project...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
<?= $this->endSection() ?>