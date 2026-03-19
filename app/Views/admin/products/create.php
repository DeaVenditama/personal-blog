<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Tambah Produk Baru</h5>
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

    <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Produk <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Produk</label>
                    <textarea class="form-control editor" id="description" name="description"
                        rows="5"><?= old('description') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="features" class="form-label">Fitur (Pisahkan dengan Enter)</label>
                    <textarea class="form-control" id="features" name="features" rows="5"
                        placeholder="Fitur A&#10;Fitur B&#10;Fitur C"><?= old('features') ?></textarea>
                    <div class="form-text">Tuliskan satu fitur tiap baris.</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 p-3 mb-3">
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="<?= old('price', '0') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="discount_percentage" class="form-label">Diskon (%)</label>
                        <input type="number" class="form-control" id="discount_percentage" name="discount_percentage"
                            value="<?= old('discount_percentage', '0') ?>" min="0" max="100">
                    </div>

                    <div class="mb-3">
                        <label for="demo_url" class="form-label">URL Demo</label>
                        <input type="url" class="form-control" id="demo_url" name="demo_url"
                            value="<?= old('demo_url') ?>" placeholder="https://...">
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail (Gambar)</label>
                        <input class="form-control" type="file" id="thumbnail" name="thumbnail[]" accept="image/*" multiple>
                        <div class="form-text mt-1">Pilih beberapa gambar sekaligus dengan menahan tombol Ctrl/Cmd.</div>
                    </div>

                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active"
                            value="1" <?= old('is_active', '1') == '1' ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="is_active">Status Aktif (Tampilkan)</label>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="d-flex justify-content-end gap-2">
            <a href="<?= base_url('admin/products') ?>" class="btn btn-light border">Batal</a>
            <button type="submit" class="btn btn-dark">Simpan Produk</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>