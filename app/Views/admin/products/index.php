<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Products (Store)</h5>
    <a href="<?= base_url('admin/products/create') ?>" class="btn btn-dark btn-sm shadow-sm"><i
            class="bi bi-plus-lg"></i>
        Tambah Produk Baru</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Thumbnail</th>
                    <th>Judul</th>
                    <th>Harga (Rp)</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($products as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <?php if ($p['thumbnail']): ?>
                                <img src="<?= base_url('uploads/products/' . $p['thumbnail']) ?>" alt="Thumbnail"
                                    style="height: 40px; width: 60px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center text-muted"
                                    style="height: 40px; width: 60px; border-radius: 4px; font-size: 0.8rem;">No Img</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= esc($p['title']) ?></strong>
                        </td>
                        <td><?= number_format($p['price'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($p['is_active']): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <a href="<?= base_url('admin/products/show/' . $p['id']) ?>"
                                    class="btn btn-sm btn-light border text-primary" title="View Product">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="<?= base_url('admin/products/edit/' . $p['id']) ?>"
                                    class="btn btn-sm btn-light border text-dark">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="<?= base_url('admin/products/delete/' . $p['id']) ?>"
                                    class="btn btn-sm btn-light border text-danger"
                                    onclick="return confirm('Delete this product?');">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada produk toko.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>