<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Manage Posts</h5>
    <a href="<?= base_url('admin/posts/create') ?>" class="btn btn-dark btn-sm shadow-sm"><i class="bi bi-plus-lg"></i>
        New Post</a>
</div>

<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Reads</th>
                    <th>Published At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td>
                                <strong>
                                    <?= esc($post['title']) ?>
                                </strong>
                            </td>
                            <td>
                                <?php if ($post['status'] == 'published'): ?>
                                    <span class="badge bg-success">Published</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><i class="bi bi-eye"></i>
                                    <?= $post['read_count'] ?></span>
                            </td>
                            <td>
                                <?= $post['published_at'] ? date('M d, Y', strtotime($post['published_at'])) : '-' ?>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="<?= base_url('admin/posts/show/' . $post['id']) ?>"
                                        class="btn btn-sm btn-light border text-primary" title="View Post">
                                        <i class="bi bi-box-arrow-up-right"></i> View
                                    </a>
                                    <a href="<?= base_url('admin/posts/comments/' . $post['id']) ?>"
                                        class="btn btn-sm btn-light border text-success" title="View & Reply Comments">
                                        <i class="bi bi-chat-dots"></i> Review
                                    </a>
                                    <a href="<?= base_url('admin/posts/edit/' . $post['id']) ?>"
                                        class="btn btn-sm btn-light border text-dark"><i class="bi bi-pencil"></i> Edit</a>
                                    <a href="<?= base_url('admin/posts/delete/' . $post['id']) ?>"
                                        class="btn btn-sm btn-light border text-danger"
                                        onclick="return confirm('Delete this post?');"><i class="bi bi-trash"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No posts found. Create your first post!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>