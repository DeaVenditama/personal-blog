<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="mb-3">
    <a href="<?= base_url('admin/posts') ?>" class="text-decoration-none text-muted"><i class="bi bi-arrow-left"></i>
        Back to Posts</a>
</div>

<div class="card p-4">
    <h5 class="fw-bold mb-4">Edit Post:
        <?= esc($post['title']) ?>
    </h5>
    <form action="<?= base_url('admin/posts/update/' . $post['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-toggle-ai">
                <i class="bi bi-robot"></i> Auto Generate Post
            </button>
        </div>

        <div class="card p-3 mb-4 bg-light border-primary d-none" id="ai-form-container" style="border-style: dashed !important;">
            <h6 class="fw-bold mb-3"><i class="bi bi-magic text-primary"></i> AI Content Generator</h6>
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold mb-1">Context / Topic</label>
                <textarea id="ai-context" class="form-control" rows="5" placeholder="Describe the topic in detail (e.g. A comprehensive guide on PHP 8 features including JIT compiler and match expression...)" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" style="overflow:hidden; resize:none;"></textarea>
            </div>
            <div class="row align-items-end">
                <div class="col-md-5 mb-2 mb-md-0">
                    <label class="form-label text-muted small fw-bold mb-1">Reading Time</label>
                    <select id="ai-reading-time" class="form-select">
                        <option value="Short (1-2 minutes)">Short (1-2 minutes)</option>
                        <option value="Medium (3-5 minutes)">Medium (3-5 minutes)</option>
                        <option value="Long (5+ minutes)">Long (5+ minutes)</option>
                    </select>
                </div>
                <div class="col-md-7 text-md-end text-start mt-3 mt-md-0 flex-wrap d-flex justify-content-md-end gap-2">
                    <button type="button" class="btn btn-outline-secondary" id="btn-copy-content" title="Copy from Editor to Context">
                        <i class="bi bi-clipboard"></i> Copy Content
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-generate-ai">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="ai-spinner" role="status" aria-hidden="true"></span>
                        <i class="bi bi-stars" id="ai-icon"></i> Generate Post
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-muted small"><strong>Post Title</strong></label>
            <input type="text" id="post-title" name="title" class="form-control" required value="<?= esc($post['title']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label text-muted small"><strong>Content</strong></label>
            <textarea name="content" id="editor" class="form-control" rows="15"><?= esc($post['content']) ?></textarea>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label text-muted small"><strong>Category</strong></label>
                <select name="category_id" class="form-select">
                    <option value="">-- Uncategorized --</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($post['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small"><strong>Status</strong></label>
                <select name="status" class="form-select">
                    <option value="draft" <?= ($post['status'] == 'draft') ? 'selected' : '' ?>>Draft (Hidden)</option>
                    <option value="published" <?= ($post['status'] == 'published') ? 'selected' : '' ?>>Publish Now
                    </option>
                </select>
            </div>
        </div>

        <hr class="my-4">
        <h6 class="fw-bold mb-3 text-muted"><i class="bi bi-search"></i> SEO Settings</h6>
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted small"><strong>Custom Slug</strong></label>
                <input type="text" name="slug" class="form-control" value="<?= esc($post['slug']) ?>"
                    placeholder="Leave blank to auto-generate from title">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted small"><strong>Meta Title</strong></label>
                <input type="text" name="meta_title" class="form-control" value="<?= esc($post['meta_title'] ?? '') ?>"
                    placeholder="SEO Title (optional)">
            </div>
            <div class="col-12">
                <label class="form-label text-muted small"><strong>Meta Description</strong></label>
                <textarea name="meta_description" class="form-control" rows="2"
                    placeholder="Brief summary for search engines (optional)"><?= esc($post['meta_description'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="<?= base_url('admin/posts') ?>" class="btn btn-light border me-2">Cancel</a>
            <button type="submit" class="btn btn-dark">Update Post</button>
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
        let csrfName = '<?= csrf_token() ?>';
        let csrfHash = '<?= csrf_hash() ?>';

        $('#btn-toggle-ai').click(function() {
            $('#ai-form-container').toggleClass('d-none');
        });

        $('#btn-copy-content').click(function() {
            let currentTitle = $('#post-title').val().trim();
            let currentContent = $('#editor').summernote('code');
            // Remove HTML tags to get plain text, or keep HTML if AI needs it.
            // Plain text is usually better for context summarizing/re-writing.
            let cleanText = $('<div>').html(currentContent).text().trim();
            
            let finalContext = '';
            if (currentTitle) {
                finalContext += 'Title: ' + currentTitle + '\n\n';
            }
            if (cleanText) {
                finalContext += 'Content:\n' + cleanText;
            }

            if (finalContext === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Content',
                    text: 'The title and editor are empty. Nothing to copy.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            
            $('#ai-context').val(finalContext);
            
            // Auto-resize the textarea
            $('#ai-context').css('height', 'auto');
            $('#ai-context').css('height', $('#ai-context')[0].scrollHeight + 'px');
        });

        $('#btn-generate-ai').click(function() {
            let context = $('#ai-context').val();
            let time = $('#ai-reading-time').val();
            let btn = $(this);
            let spinner = $('#ai-spinner');

            if (!context) {
                alert('Please enter a context or topic.');
                return;
            }

            btn.prop('disabled', true);
            spinner.removeClass('d-none');

            Swal.fire({
                title: 'Generating Content...',
                html: 'Please wait while the AI writes your post.<br>This might take a few seconds.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let dataPayload = {
                context: context,
                reading_time: time
            };
            dataPayload[csrfName] = csrfHash;

            $.ajax({
                url: '<?= base_url("admin/posts/generateText") ?>',
                type: 'POST',
                data: dataPayload,
                success: function(response) {
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');
                    
                    // Update CSRF hash for next request
                    if(response.csrfHash) {
                        csrfHash = response.csrfHash;
                    }

                    if(response.success) {
                        $('#ai-form-container').addClass('d-none');
                        try {
                            // The AI is instructed to return JSON
                            let data = JSON.parse(response.text);
                            
                            if(data.title) $('#post-title').val(data.title);
                            if(data.content) $('#editor').summernote('code', data.content);
                            if(data.slug) $('input[name="slug"]').val(data.slug);
                            if(data.meta_title) $('input[name="meta_title"]').val(data.meta_title);
                            if(data.meta_description) $('textarea[name="meta_description"]').val(data.meta_description);
                            if(data.category_id) $('select[name="category_id"]').val(data.category_id);
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Content generated and fields populated successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } catch (e) {
                            console.error("Failed to parse JSON response", e, response.text);
                            Swal.fire({
                                icon: 'error',
                                title: 'Parsing Error',
                                text: 'Generated output format was corrupted. Please try again.'
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Generation Failed',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');
                    console.log(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Request Error',
                        text: 'Error generating text. See console for details.'
                    });
                }
            });
        });

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