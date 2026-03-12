<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        $postModel = new \App\Models\Post();
        $categoryModel = new \App\Models\Category();
        $db = \Config\Database::connect();

        $totalPosts = $postModel->countAllResults();
        $totalCategories = $categoryModel->countAllResults();

        // Sum of all read counts
        $totalViewsQuery = $postModel->selectSum('read_count')->get()->getRow();
        $totalViews = $totalViewsQuery->read_count ?? 0;

        // Top 5 popular posts
        $topPosts = $postModel->orderBy('read_count', 'DESC')
            ->where('status', 'published')
            ->limit(5)
            ->findAll();

        $data = [
            'title' => 'Dashboard',
            'totalPosts' => $totalPosts,
            'totalCategories' => $totalCategories,
            'totalViews' => $totalViews,
            'topPosts' => $topPosts
        ];
        return view('admin/dashboard', $data);
    }
}
