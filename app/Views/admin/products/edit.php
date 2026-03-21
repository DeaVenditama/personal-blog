<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Edit Produk Store</h5>
    <a href="<?= base_url('admin/products') ?>" class="btn btn-light border btn-sm shadow-sm"><i
            class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card p-4">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="post"
        enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Produk <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title"
                        value="<?= old('title', $product['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Produk</label>
                    <textarea class="form-control editor" id="description" name="description"
                        rows="5"><?= old('description', $product['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <?php
                    $featureStr = '';
                    if (!empty($product['features'])) {
                        $featuresList = json_decode($product['features'], true);
                        if (is_array($featuresList)) {
                            $featureStr = implode("\n", $featuresList);
                        } else {
                            $featureStr = $product['features'];
                        }
                    }
                    ?>
                    <label for="features" class="form-label">Fitur (Pisahkan dengan Enter)</label>
                    <textarea class="form-control" id="features" name="features" rows="5"
                        placeholder="Fitur A&#10;Fitur B"><?= old('features', $featureStr) ?></textarea>
                    <div class="form-text">Tuliskan satu fitur tiap baris.</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 p-3 mb-3">
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="<?= old('price', $product['price']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="discount_percentage" class="form-label">Diskon (%)</label>
                        <input type="number" class="form-control" id="discount_percentage" name="discount_percentage"
                            value="<?= old('discount_percentage', $product['discount_percentage'] ?? 0) ?>" min="0"
                            max="100">
                    </div>

                    <div class="mb-3">
                        <label for="demo_url" class="form-label">URL Demo</label>
                        <input type="url" class="form-control" id="demo_url" name="demo_url"
                            value="<?= old('demo_url', $product['demo_url']) ?>" placeholder="https://...">
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail Baru (Gambar)</label>
                        <input class="form-control" type="file" id="thumbnail" name="thumbnail[]" accept="image/*" multiple>
                        <div class="form-text mt-1">Pilih beberapa gambar sekaligus. Biarkan kosong jika tidak ingin mengubah.</div>
                        <?php if ($product['thumbnail']): ?>
                            <div class="mt-2 text-muted small border bg-white p-2 rounded">
                                <div class="mb-2 text-center">Saat ini:</div>
                                <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <?php 
                                    $oldImages = explode(';', $product['thumbnail']);
                                    foreach($oldImages as $oldImg):
                                ?>
                                    <img src="<?= base_url('uploads/products/' . trim($oldImg)) ?>" alt="Thumbnail"
                                        class="img-fluid border shadow-sm" style="max-height: 80px; object-fit: contain; border-radius: 4px;">
                                <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active"
                            value="1" <?= old('is_active', $product['is_active']) == '1' ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="is_active">Status Aktif (Tampilkan)</label>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="d-flex justify-content-end gap-2">
            <a href="<?= base_url('admin/products') ?>" class="btn btn-light border">Batal</a>
            <button type="submit" class="btn btn-dark">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#description').summernote({
            placeholder: 'Tulis deskripsi produk...',
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