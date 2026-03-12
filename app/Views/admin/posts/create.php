<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="mb-3">
    <a href="<?= base_url('admin/posts') ?>" class="text-decoration-none text-muted"><i class="bi bi-arrow-left"></i>
        Back to Posts</a>
</div>

<div class="card p-4">
    <h5 class="fw-bold mb-4">Create New Post</h5>
    <form action="<?= base_url('admin/posts/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label text-muted small"><strong>Post Title</strong></label>
            <input type="text" name="title" class="form-control" required placeholder="Enter an engaging title...">
        </div>

        <div class="mb-3">
            <label class="form-label text-muted small"><strong>Content</strong></label>
            <textarea name="content" id="editor" class="form-control" rows="15"
                placeholder="Write your post content here..."></textarea>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label text-muted small"><strong>Category</strong></label>
                <select name="category_id" class="form-select">
                    <option value="">-- Uncategorized --</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small"><strong>Status</strong></label>
                <select name="status" class="form-select">
                    <option value="draft">Draft (Hidden)</option>
                    <option value="published">Publish Now</option>
                </select>
            </div>
        </div>

        <hr class="my-4">
        <h6 class="fw-bold mb-3 text-muted"><i class="bi bi-search"></i> SEO Settings</h6>
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted small"><strong>Custom Slug</strong></label>
                <input type="text" name="slug" class="form-control"
                    placeholder="Leave blank to auto-generate from title">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted small"><strong>Meta Title</strong></label>
                <input type="text" name="meta_title" class="form-control" placeholder="SEO Title (optional)">
            </div>
            <div class="col-12">
                <label class="form-label text-muted small"><strong>Meta Description</strong></label>
                <textarea name="meta_description" class="form-control" rows="2"
                    placeholder="Brief summary for search engines (optional)"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="<?= base_url('admin/posts') ?>" class="btn btn-light border me-2">Cancel</a>
            <button type="submit" class="btn btn-dark">Save Post</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function () {
        $('#editor').summernote({
            placeholder: 'Write your post content here...',
            tabsize: 2,
            height: 500,
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