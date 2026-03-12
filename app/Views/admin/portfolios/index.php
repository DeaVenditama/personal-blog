<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Manage Portfolios</h5>
    <a href="<?= base_url('admin/portfolios/create') ?>" class="btn btn-dark btn-sm shadow-sm"><i
            class="bi bi-plus-lg"></i>
        New Project</a>
</div>

<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Sort Order</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($portfolios)): ?>
                    <?php foreach ($portfolios as $portfolio): ?>
                        <tr>
                            <td>
                                <?php if (!empty($portfolio['image_path'])): ?>
                                    <img src="<?= base_url($portfolio['image_path']) ?>" alt="Project Image"
                                        style="height: 40px; width: 60px; object-fit: cover; border-radius: 4px;"
                                        onerror="this.onerror=null; this.outerHTML='<div class=\'bg-light d-flex align-items-center justify-content-center text-muted text-center\' style=\'height: 40px; width: 60px; border-radius: 4px; font-size: 0.6rem; line-height: 1;\'>Image not found</div>';">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center text-muted text-center"
                                        style="height: 40px; width: 60px; border-radius: 4px; font-size: 0.6rem; line-height: 1;">
                                        Image not found</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong>
                                    <?= esc($portfolio['title']) ?>
                                </strong>
                                <div class="text-muted small">
                                    <?= esc($portfolio['tools']) ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($portfolio['status'] == 'published'): ?>
                                    <span class="badge bg-success">Published</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= esc($portfolio['sort_order']) ?>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="<?= base_url('admin/portfolios/show/' . $portfolio['id']) ?>"
                                        class="btn btn-sm btn-light border text-primary" title="View Project">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="<?= base_url('admin/portfolios/edit/' . $portfolio['id']) ?>"
                                        class="btn btn-sm btn-light border text-dark"><i class="bi bi-pencil"></i> Edit</a>
                                    <a href="<?= base_url('admin/portfolios/delete/' . $portfolio['id']) ?>"
                                        class="btn btn-sm btn-light border text-danger"
                                        onclick="return confirm('Delete this project?');"><i class="bi bi-trash"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No portfolio projects found. Add your first
                            project!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>