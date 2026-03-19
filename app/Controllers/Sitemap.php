<?php

namespace App\Controllers;

class Sitemap extends BaseController
{
    public function index()
    {
        $postModel = new \App\Models\Post();
        $categoryModel = new \App\Models\Category();
        $portfolioModel = new \App\Models\Portfolio();
        $productModel = new \App\Models\Product();

        $posts = $postModel->where('status', 'published')
                           ->orderBy('published_at', 'DESC')
                           ->findAll();
        $categories = $categoryModel->findAll();
        $portfolios = $portfolioModel->where('status', 'published')
                                     ->orderBy('created_at', 'DESC')
                                     ->findAll();
        $products = $productModel->where('is_active', true)
                                 ->orderBy('created_at', 'DESC')
                                 ->findAll();

        $data = [
            'posts' => $posts,
            'categories' => $categories,
            'portfolios' => $portfolios,
            'products' => $products,
        ];

        return $this->response->setContentType('text/xml')->setBody(view('sitemap', $data, ['debug' => false]));
    }
}
