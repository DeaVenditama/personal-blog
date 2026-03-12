<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card p-4 text-center">
            <h1 class="display-4 fw-bold"><?= esc($totalPosts) ?></h1>
            <p class="text-muted mb-0">Total Posts</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card p-4 text-center">
            <h1 class="display-4 fw-bold"><?= esc($totalViews) ?></h1>
            <p class="text-muted mb-0">Total Views</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card p-4 text-center">
            <h1 class="display-4 fw-bold"><?= esc($totalCategories) ?></h1>
            <p class="text-muted mb-0">Categories</p>
        </div>
    </div>
</div>

<div class="card p-4 mt-2">
    <h5 class="fw-bold mb-3"><i class="bi bi-star-fill text-warning"></i> Top 5 Popular Posts</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($topPosts)): ?>
                    <?php foreach ($topPosts as $post): ?>
                        <tr>
                            <td>
                                <a href="<?= base_url($post['slug']) ?>" target="_blank"
                                    class="text-decoration-none text-dark fw-bold">
                                    <?= esc($post['title']) ?>
                                </a>
                            </td>
                            <td>
                                <?php if ($post['status'] == 'published'): ?>
                                    <span class="badge bg-success">Published</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($post['read_count']) ?></td>
                            <td class="text-muted small"><?= date('M d, Y', strtotime($post['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('admin/posts/edit/' . $post['id']) ?>"
                                    class="btn btn-sm btn-light border text-muted">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No posts available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>