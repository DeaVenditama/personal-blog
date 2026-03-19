<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $query = $this->request->getGet('q');

        if (empty($query)) {
            $this->cachePage(300); // Cache for 5 minutes only if not searching
        }

        $postModel = new \App\Models\Post();

        $posts = $postModel->select('posts.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->where('posts.status', 'published');

        if (!empty($query)) {
            $posts = $posts->groupStart()
                ->like('posts.title', $query)
                ->orLike('posts.content', $query)
                ->groupEnd();
        }

        $data = [
            'request' => $this->request,
            'searchQuery' => $query,
            'posts' => $posts->orderBy('published_at', 'DESC')->findAll(),
        ];

        return view('home', $data);
    }

    public function category($slug)
    {
        $query = $this->request->getGet('q');

        if (empty($query)) {
            $this->cachePage(300); // Cache for 5 minutes only if not searching
        }

        $categoryModel = new \App\Models\Category();
        $category = $categoryModel->where('slug', $slug)->first();

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $postModel = new \App\Models\Post();
        $query = $this->request->getGet('q');

        $posts = $postModel->select('posts.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->where('posts.status', 'published')
            ->where('posts.category_id', $category['id']);

        if (!empty($query)) {
            $posts = $posts->groupStart()
                ->like('posts.title', $query)
                ->orLike('posts.content', $query)
                ->groupEnd();
        }

        $data = [
            'request' => $this->request,
            'searchQuery' => $query,
            'category' => $category,
            'title' => 'Category: ' . $category['name'],
            'posts' => $posts->orderBy('published_at', 'DESC')->findAll(),
        ];

        return view('home', $data);
    }

    public function show($slug)
    {
        $postModel = new \App\Models\Post();
        $post = $postModel->select('posts.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->where('posts.slug', $slug)
            ->where('posts.status', 'published')
            ->first();

        if ($post) {
            // Logic for Anti-spam Read Count
            $ip = $this->request->getIPAddress();
            $viewTimeLimit = date('Y-m-d H:i:s', strtotime('-1 hour'));

            $db = \Config\Database::connect();
            $viewExists = $db->table('post_views')
                ->where('post_id', $post['id'])
                ->where('ip_address', $ip)
                ->where('viewed_at >=', $viewTimeLimit)
                ->countAllResults();

            if ($viewExists == 0) {
                // Add view record
                $db->table('post_views')->insert([
                    'post_id' => $post['id'],
                    'ip_address' => $ip,
                    'viewed_at' => date('Y-m-d H:i:s')
                ]);

                // Increment view count on post table
                $post['read_count']++;
                $postModel->update($post['id'], [
                    'read_count' => $post['read_count']
                ]);
            }

            $commentModel = new \App\Models\Comment();

            $limit = $this->request->getGet('limit') ?: 10;

            // Fetch Level 0 (Main comments) directly paginated, DESC
            $mainComments = $commentModel->where('post_id', $post['id'])
                ->where('parent_id', null)
                ->orderBy('created_at', 'DESC')
                ->findAll($limit);

            // Count total main comments for "Load More" logic
            $totalMainComments = $commentModel->where('post_id', $post['id'])
                ->where('parent_id', null)
                ->countAllResults();

            $comments = [];
            $level1Replies = [];

            // Fetch up to 5 Level 1 Replies per Main Comment, DESC
            foreach ($mainComments as $main) {
                $main['replies'] = [];

                $repliesLevel1 = $commentModel->where('post_id', $post['id'])
                    ->where('parent_id', $main['id'])
                    ->orderBy('created_at', 'DESC')
                    ->findAll(5);

                foreach ($repliesLevel1 as $r1) {
                    // Fetch up to 5 Level 2 Replies per Level 1 Reply, DESC
                    $r1['replies'] = [];
                    $repliesLevel2 = $commentModel->where('post_id', $post['id'])
                        ->where('parent_id', $r1['id'])
                        ->orderBy('created_at', 'DESC')
                        ->findAll(5);

                    foreach ($repliesLevel2 as $r2) {
                        $r1['replies'][] = $r2;
                    }

                    $main['replies'][] = $r1;
                }

                $comments[$main['id']] = $main;
            }

            $data = [
                'title' => (!empty($post['meta_title'])) ? $post['meta_title'] : $post['title'],
                'meta_description' => (!empty($post['meta_description'])) ? $post['meta_description'] : substr(strip_tags($post['content']), 0, 160),
                'canonical_url' => base_url($post['slug']),
                'og_type' => 'article',
                'og_image' => (!empty($post['image_path'])) ? base_url($post['image_path']) : null,
                'post' => $post,
                'comments' => $comments,
                'totalMainComments' => $totalMainComments,
                'currentLimit' => $limit
            ];

            return view('post_single', $data);
        }

        // Check Portfolios
        $portfolioModel = new \App\Models\Portfolio();
        $project = $portfolioModel->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if ($project) {
            $data = [
                'title' => esc($project['title']) . ' - Portfolio Dea Venditama',
                'meta_description' => substr(strip_tags((string) $project['description']), 0, 160),
                'canonical_url' => base_url($project['slug']),
                'og_type' => 'article',
                'og_image' => (!empty($project['image_path'])) ? base_url(trim(explode(';', $project['image_path'])[0])) : null,
                'project' => $project
            ];
            return view('portfolio/show', $data);
        }

        // Check Products
        $productModel = new \App\Models\Product();
        $product = $productModel->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if ($product) {
            $data = [
                'title' => $product['title'] . ' | Source Code | Dea Venditama',
                'meta_description' => substr(strip_tags($product['description']), 0, 160),
                'canonical_url' => base_url($product['slug']),
                'og_type' => 'product',
                'og_image' => (!empty($product['thumbnail'])) ? base_url('uploads/products/' . trim(explode(';', $product['thumbnail'])[0])) : null,
                'product' => $product
            ];
            return view('store/show', $data);
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    public function feed()
    {
        $postModel = new \App\Models\Post();
        $posts = $postModel->select('posts.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->where('posts.status', 'published')
            ->orderBy('published_at', 'DESC')
            ->findAll(20);

        $data = [
            'feed_name' => 'Dea Venditama Blog',
            'feed_url' => base_url(),
            'page_description' => 'A minimalist personal blog platform.',
            'page_language' => 'en-us',
            'creator_email' => 'author@example.com',
            'posts' => $posts
        ];

        return $this->response->setContentType('application/rss+xml')->setBody(view('rss', $data));
    }

    public function storeComment($postId)
    {
        $postModel = new \App\Models\Post();
        $post = $postModel->find($postId);

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'comment' => 'required|min_length[5]'
        ];

        // Normal comment validation (name and email required)
        $isAdmin = session()->get('isLoggedIn');
        $parentId = $this->request->getPost('parent_id') ?: null;

        if (!$isAdmin) {
            $rules['name'] = 'required|min_length[3]|max_length[100]';
            $rules['email'] = 'required|valid_email|max_length[100]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $session = session();
        $name = $isAdmin ? $session->get('name') : $this->request->getPost('name');
        $email = $isAdmin ? $session->get('email') : $this->request->getPost('email');

        $commentModel = new \App\Models\Comment();
        $commentModel->save([
            'post_id' => $postId,
            'parent_id' => $parentId,
            'is_admin' => $isAdmin ? 1 : 0,
            'name' => $name,
            'email' => $email,
            'comment' => $this->request->getPost('comment')
        ]);

        return redirect()->to(base_url($post['slug']))->with('success', 'Komentar berhasil ditambahkan.');
    }
}
