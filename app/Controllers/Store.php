<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Store extends BaseController
{
    public function index()
    {
        $query = $this->request->getGet('q');

        if (empty($query)) {
            $this->cachePage(300); // Cache for 5 minutes
        }

        $productModel = new \App\Models\Product();

        $products = $productModel->where('is_active', true);

        if (!empty($query)) {
            $products = $products->groupStart()
                ->like('title', $query)
                ->orLike('description', $query)
                ->groupEnd();
        }

        $data = [
            'title' => 'Source Code Store | Dea Venditama',
            'meta_description' => 'Jelajahi dan dapatkan source code berkualitas tinggi untuk proyek pengembangan selanjutnya.',
            'canonical_url' => base_url('store'),
            'request' => $this->request,
            'searchQuery' => $query,
            'products' => $products->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('store/index', $data);
    }

    public function show($slug)
    {
        $productModel = new \App\Models\Product();
        $product = $productModel->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $product['title'] . ' | Source Code | Dea Venditama',
            'meta_description' => substr(strip_tags($product['description']), 0, 160),
            'canonical_url' => base_url('store/' . $product['slug']),
            'og_type' => 'product',
            'og_image' => (!empty($product['thumbnail'])) ? base_url('uploads/products/' . $product['thumbnail']) : null, // Uses default if null
            'product' => $product
        ];

        return view('store/show', $data);
    }
}
