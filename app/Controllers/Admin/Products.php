<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Products extends BaseController
{
    public function index()
    {
        $productModel = new \App\Models\Product();
        $data['products'] = $productModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/products/index', $data);
    }

    public function create()
    {
        return view('admin/products/create');
    }

    public function store()
    {
        $rules = [
            'title' => 'required',
            'price' => 'required|numeric',
            'thumbnail' => [
                'rules' => 'max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = mb_url_title($this->request->getPost('title'), '-', TRUE);

        $thumbnailName = null;
        $file = $this->request->getFile('thumbnail');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $thumbnailName = $file->getRandomName();
            $file->move('uploads/products', $thumbnailName);
        }

        $description = $this->request->getPost('description');
        $description = preg_replace('#<script(.*?)>(.*?)</script>#is', '', (string) $description);

        $productModel = new \App\Models\Product();
        $productModel->save([
            'title' => $this->request->getPost('title'),
            'slug' => $slug,
            'description' => $description,
            'features' => json_encode(explode("\n", (string) $this->request->getPost('features'))),
            'price' => $this->request->getPost('price'),
            'discount_percentage' => (int) $this->request->getPost('discount_percentage'),
            'demo_url' => $this->request->getPost('demo_url'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'thumbnail' => $thumbnailName
        ]);

        return redirect()->to(base_url('admin/products'))->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $productModel = new \App\Models\Product();
        $data['title'] = 'View Product';
        $data['product'] = $productModel->find($id);

        if (!$data['product']) {
            return redirect()->to(base_url('admin/products'))->with('error', 'Product not found.');
        }

        return view('admin/products/show', $data);
    }

    public function edit($id)
    {
        $productModel = new \App\Models\Product();
        $data['product'] = $productModel->find($id);

        if (!$data['product']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/products/edit', $data);
    }

    public function update($id)
    {
        $productModel = new \App\Models\Product();
        $product = $productModel->find($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'title' => 'required',
            'price' => 'required|numeric',
            'thumbnail' => [
                'rules' => 'max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = mb_url_title($this->request->getPost('title'), '-', TRUE);

        $thumbnailName = $product['thumbnail'];
        $file = $this->request->getFile('thumbnail');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($thumbnailName && file_exists('uploads/products/' . $thumbnailName)) {
                unlink('uploads/products/' . $thumbnailName);
            }
            $thumbnailName = $file->getRandomName();
            $file->move('uploads/products', $thumbnailName);
        }

        $description = $this->request->getPost('description');
        $description = preg_replace('#<script(.*?)>(.*?)</script>#is', '', (string) $description);

        $productModel->update($id, [
            'title' => $this->request->getPost('title'),
            'slug' => $slug,
            'description' => $description,
            'features' => json_encode(explode("\n", (string) $this->request->getPost('features'))),
            'price' => $this->request->getPost('price'),
            'discount_percentage' => (int) $this->request->getPost('discount_percentage'),
            'demo_url' => $this->request->getPost('demo_url'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'thumbnail' => $thumbnailName
        ]);

        return redirect()->to(base_url('admin/products'))->with('success', 'Product updated successfully');
    }

    public function delete($id)
    {
        $productModel = new \App\Models\Product();
        $product = $productModel->find($id);

        if ($product) {
            if ($product['thumbnail'] && file_exists('uploads/products/' . $product['thumbnail'])) {
                unlink('uploads/products/' . $product['thumbnail']);
            }
            $productModel->delete($id);
        }

        return redirect()->to(base_url('admin/products'))->with('success', 'Product deleted successfully');
    }
}

