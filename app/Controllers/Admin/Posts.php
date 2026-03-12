<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Posts extends BaseController
{
    public function index()
    {
        $postModel = new \App\Models\Post();
        $data = [
            'title' => 'Manage Posts',
            'posts' => $postModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/posts/index', $data);
    }

    public function create()
    {
        $categoryModel = new \App\Models\Category();
        $data = [
            'title' => 'Create New Post',
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll()
        ];
        return view('admin/posts/create', $data);
    }

    public function store()
    {
        $postModel = new \App\Models\Post();
        $validationRule = [
            'title' => 'required|min_length[3]|max_length[250]',
            'content' => 'required',
            'status' => 'required|in_list[draft,published]',
            'category_id' => 'permit_empty|is_natural_no_zero',
            'meta_title' => 'permit_empty|max_length[250]',
            'slug' => 'permit_empty|max_length[250]|is_unique[posts.slug]',
        ];

        if (!$this->validate($validationRule)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $title = $this->request->getPost('title');

        $slugInput = $this->request->getPost('slug');
        $slug = !empty($slugInput) ? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slugInput))) : strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        $data = [
            'user_id' => session()->get('id'),
            'category_id' => $this->request->getPost('category_id') ?: null,
            'title' => $title,
            'slug' => $slug,
            'content' => $this->request->getPost('content'),
            'status' => $this->request->getPost('status'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'published_at' => ($this->request->getPost('status') == 'published') ? date('Y-m-d H:i:s') : null,
        ];

        $postModel->insert($data);
        session()->setFlashdata('success', 'Post created successfully!');
        return redirect()->to(base_url('admin/posts'));
    }

    public function show($id)
    {
        $postModel = new \App\Models\Post();
        $post = $postModel->find($id);
        if (!$post)
            return redirect()->to('admin/posts');

        $data = [
            'title' => 'View Post',
            'post' => $post
        ];
        return view('admin/posts/show', $data);
    }

    public function comments($id)
    {
        $postModel = new \App\Models\Post();
        $post = $postModel->find($id);
        if (!$post)
            return redirect()->to('admin/posts');

        $commentModel = new \App\Models\Comment();
        $flatComments = $commentModel->where('post_id', $post['id'])
            ->orderBy('created_at', 'ASC')
            ->findAll();

        $comments = [];
        $level1Replies = [];
        $level2Replies = [];

        foreach ($flatComments as $comment) {
            $comment['replies'] = [];
            if ($comment['parent_id'] === null) {
                $comments[$comment['id']] = $comment;
            }
        }

        foreach ($flatComments as $comment) {
            if ($comment['parent_id'] !== null && isset($comments[$comment['parent_id']])) {
                $level1Replies[$comment['id']] = $comment;
                $level1Replies[$comment['id']]['replies'] = [];
            }
        }

        foreach ($flatComments as $comment) {
            if ($comment['parent_id'] !== null && isset($level1Replies[$comment['parent_id']])) {
                $level2Replies[] = $comment;
            }
        }

        foreach ($level2Replies as $l2) {
            $level1Replies[$l2['parent_id']]['replies'][] = $l2;
        }

        foreach ($level1Replies as $l1) {
            $comments[$l1['parent_id']]['replies'][] = $l1;
        }

        $data = [
            'title' => 'Post Comments',
            'post' => $post,
            'comments' => $comments
        ];

        return view('admin/posts/comments', $data);
    }

    public function replyComment($postId)
    {
        $commentModel = new \App\Models\Comment();
        $parent_id = $this->request->getPost('parent_id') ?: null;
        $commentText = $this->request->getPost('comment');

        $name = session()->get('name') ?? 'Admin';

        $data = [
            'post_id' => $postId,
            'parent_id' => $parent_id,
            'is_admin' => 1,
            'name' => $name,
            'email' => session()->get('email') ?? 'admin@example.com',
            'comment' => $commentText,
        ];

        $commentModel->insert($data);

        return redirect()->to('admin/posts/comments/' . $postId)->with('success', 'Reply posted successfully.');
    }

    public function edit($id)
    {
        $postModel = new \App\Models\Post();
        $categoryModel = new \App\Models\Category();
        $data = [
            'title' => 'Edit Post',
            'post' => $postModel->find($id),
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll()
        ];

        if (!$data['post'])
            return redirect()->to(base_url('admin/posts'));

        return view('admin/posts/edit', $data);
    }

    public function update($id)
    {
        $postModel = new \App\Models\Post();
        $validationRule = [
            'title' => 'required|min_length[3]|max_length[250]',
            'content' => 'required',
            'status' => 'required|in_list[draft,published]',
            'category_id' => 'permit_empty|is_natural_no_zero',
            'meta_title' => 'permit_empty|max_length[250]',
            'slug' => "permit_empty|max_length[250]|is_unique[posts.slug,id,{$id}]", // allow keeping same slug
        ];

        if (!$this->validate($validationRule)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $title = $this->request->getPost('title');

        $slugInput = $this->request->getPost('slug');
        $slug = !empty($slugInput) ? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slugInput))) : strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        $data = [
            'title' => $title,
            'slug' => $slug,
            'category_id' => $this->request->getPost('category_id') ?: null,
            'content' => $this->request->getPost('content'),
            'status' => $this->request->getPost('status'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ];

        // Update publish date only if status changed to published and it was not published before
        if ($data['status'] == 'published') {
            $existing = $postModel->find($id);
            if (!$existing['published_at']) {
                $data['published_at'] = date('Y-m-d H:i:s');
            }
        }

        $postModel->update($id, $data);
        session()->setFlashdata('success', 'Post updated successfully!');
        return redirect()->to(base_url('admin/posts'));
    }

    public function delete($id)
    {
        $postModel = new \App\Models\Post();
        $postModel->delete($id);
        session()->setFlashdata('success', 'Post deleted successfully!');
        return redirect()->to(base_url('admin/posts'));
    }
}
