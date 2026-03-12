<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4">
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3">Upload New File</h5>
            <form action="<?= base_url('admin/media/upload') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label text-muted small">Select Image (Max 2MB)</label>
                    <input type="file" name="file" class="form-control" required accept="image/*">
                </div>
                <button type="submit" class="btn btn-dark w-100">Upload</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Media Library</h5>
            <div class="row g-3">
                <?php if (!empty($media)): ?>
                    <?php foreach ($media as $item): ?>
                        <div class="col-sm-6 col-md-4">
                            <div class="card h-100 border p-2">
                                <div class="ratio ratio-1x1 bg-light rounded mb-2 overflow-hidden position-relative">
                                    <img src="<?= base_url($item['file_path']) ?>" alt="<?= esc($item['filename']) ?>"
                                        class="object-fit-cover w-100 h-100"
                                        onerror="this.onerror=null; this.outerHTML='<div class=\'d-flex align-items-center justify-content-center w-100 h-100 bg-light text-muted small\'>Image not found</div>';">
                                </div>
                                <div class="small text-truncate mb-1" title="<?= esc($item['filename']) ?>">
                                    <strong>
                                        <?= esc($item['filename']) ?>
                                    </strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                    <span class="text-muted" style="font-size: 0.75rem;">
                                        <?= number_format($item['file_size'], 1) ?> KB
                                    </span>
                                    <div class="d-flex flex-wrap gap-1">
                                        <a href="<?= base_url('admin/media/delete/' . $item['id']) ?>"
                                            class="btn btn-sm btn-light border text-danger"
                                            onclick="return confirm('Delete this image?');" title="Delete"><i
                                                class="bi bi-trash"></i> Delete</a>
                                    </div>
                                </div>
                                <!-- Helper for copying URL -->
                                <div class="mt-2 text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100 copy-url-btn"
                                        style="font-size:0.75rem" data-url="<?= base_url($item['file_path']) ?>">Copy
                                        URL</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-4 text-muted">No media uploaded yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.querySelectorAll('.copy-url-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            navigator.clipboard.writeText(url).then(() => {
                const originalText = this.innerText;
                this.innerText = 'Copied!';
                this.classList.replace('btn-outline-secondary', 'btn-success');
                this.classList.replace('text-secondary', 'text-white');
                setTimeout(() => {
                    this.innerText = originalText;
                    this.classList.replace('btn-success', 'btn-outline-secondary');
                }, 2000);
            });
        });
    });
</script>
<?= $this->endSection() ?>