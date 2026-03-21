<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Posts extends BaseController
{
    public function index()
    {
        $postModel = new \App\Models\Post();
        $posts = $postModel->orderBy('created_at', 'DESC')->findAll();

        $commentModel = new \App\Models\Comment();
        $notificationModel = new \App\Models\Notification();

        foreach ($posts as &$post) {
            $post['comment_count'] = $commentModel->where('post_id', $post['id'])->countAllResults();
            $post['has_new_comment'] = $notificationModel->where('type', 'New Comment')
                ->where('reference_id', $post['id'])
                ->where('is_read', 0)
                ->countAllResults() > 0;
        }

        $data = [
            'title' => 'Manage Posts',
            'posts' => $posts
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

    public function generateText()
    {
        $context = $this->request->getPost('context');
        $readingTime = $this->request->getPost('reading_time');
        
        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->orderBy('name', 'ASC')->findAll();
        $categoryListString = '';
        if (!empty($categories)) {
            $catArr = [];
            foreach ($categories as $cat) {
                $catArr[] = $cat['id'] . ': ' . $cat['name'];
            }
            $categoryListString = implode(', ', $catArr);
        }

        if (empty($context)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Context is required', 'csrfHash' => csrf_hash()]);
        }

        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey)) {
            return $this->response->setJSON(['success' => false, 'message' => 'API Key is missing', 'csrfHash' => csrf_hash()]);
        }

        $styleGuide = "
SYSTEM PROMPT: THE HYBRID TECH-STORYTELLER STYLE GUIDE (DEA VENDITAMA X RADITYA DIKA)
1. PERSONA DEFINITION
- Role: A Senior Software Engineer/Data Scientist with a sense of humor.
- Character: The Relatable Expert. Highly technical but struggles with everyday human problems like bugs, deadlines, etc.
- Primary Language: Bahasa Indonesia (Santai/Semi-formal).

2. NARRATIVE ARCHITECTURE
- The Keresahan Hook: Every article MUST start with a personal anxiety or a funny observation.
- Self-Deprecation: Mention mistakes, confusion, or stupid bugs.
- Slice-of-Life Analogies: Explain complex tech using absurd everyday analogies.
- The Twist or Observation: Include short, witty observations about programmer life.

3. TECHNICAL CORE
- Systematic Clarity: After the narrative intro, transition into a structured tutorial using headers.
- The Documentation Bridge: Always explain *why* we use a certain function, not just *what* it does.
- Code as Narrative: Code snippets should be clean and commented. Explain logic as if talking to a friend.
- Scannability: Use Bullet points, Bold text for keywords.

4. TONE & DICTION
- Personal Pronoun: Always use 'Saya'.
- Phrasing: Use conversational Indonesian. Avoid being overly academic.
- Technical Terms: Keep English technical terms as they are but explain them in a simple Indonesian context.
- Humor Style: Observational and slightly dry.

5. ARTICLE TEMPLATE / FLOW
1. [THE HOOK]: A 1-2 paragraph story about a problem or keresahan.
2. [THE TRANSITION]: Transition into the topic.
3. [THE TUTORIAL]: Clear Headers, Practical steps, Lesson Learned notes.
4. [THE REFLECTION]: A short closing or funny closing thought.

Format the output strictly as a JSON object containing the following keys:
- \"title\": A catchy and engaging title for the blog post
- \"content\": The actual blog post content formatted directly in clean, semantic HTML (using <p>, <h2>, <ul>, etc.) so it can be directly pasted into a WYSIWYG editor.
- \"category_id\": The integer ID of the most relevant category from this list ($categoryListString). Pick the closest fit, or leave as null if none fit.
- \"slug\": A URL-friendly slug based on the title (e.g. \"my-awesome-post\").
- \"meta_title\": SEO meta title (max 60 characters).
- \"meta_description\": SEO meta description (max 160 characters).

Do NOT wrap the output in any markdown blocks (like ```json or ```html). Just return the raw JSON object.
";

        $prompt = $styleGuide . "\n\nPlease write a blog post about: " . $context . ". The reading time should be approximately " . $readingTime . ".";

        $client = \Config\Services::curlrequest();
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key=' . $apiKey;

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ], // Move generationConfig down here, outside 'contents'
                    'generationConfig' => [
                        'temperature' => 0.7, // Adjust parameters as needed
                        'thinkingConfig' => [
                            'thinkingBudget' => 1024
                        ]
                    ]
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody(), true);

                if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
                    $generatedText = $body['candidates'][0]['content']['parts'][0]['text'];

                    // Remove markdown wrapper if exists (some LLMs still add it despite instructions)
                    $generatedText = preg_replace('/^```(?:json|html)?\s*/i', '', $generatedText);
                    $generatedText = preg_replace('/```$/', '', trim($generatedText));

                    return $this->response->setJSON(['success' => true, 'text' => $generatedText, 'csrfHash' => csrf_hash()]);
                }
            }

            return $this->response->setJSON(['success' => false, 'message' => 'Invalid response from AI server', 'csrfHash' => csrf_hash()]);
        }
        catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage(), 'csrfHash' => csrf_hash()]);
        }
    }
    
    public function uploadImage()
    {
        $file = $this->request->getFile('image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            // Pindahkan file ke public/assets/images
            $file->move(FCPATH . 'assets/images', $newName);
            
            return $this->response->setJSON([
                'success' => true,
                'url' => base_url('assets/images/' . $newName),
                'csrfHash' => csrf_hash()
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to upload image.',
            'csrfHash' => csrf_hash()
        ]);
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
