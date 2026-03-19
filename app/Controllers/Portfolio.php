<?php

namespace App\Controllers;

use App\Models\Portfolio as PortfolioModel;

class Portfolio extends BaseController
{
    public function index()
    {
        $portfolioModel = new PortfolioModel();

        $data = [
            'title' => 'Portfolio - Dea Venditama',
            'meta_description' => 'Showcase of my latest projects and work.',
            'canonical_url' => base_url('portfolio'),
            'portfolios' => $portfolioModel->where('status', 'published')
                ->orderBy('sort_order', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->findAll()
        ];

        return view('portfolio/index', $data);
    }

    public function show($id)
    {
        $portfolioModel = new PortfolioModel();

        $project = $portfolioModel->where('id', $id)
            ->where('status', 'published')
            ->first();

        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => esc($project['title']) . ' - Portfolio Dea Venditama',
            'meta_description' => substr(strip_tags((string) $project['description']), 0, 160),
            'canonical_url' => base_url('portfolio/' . $project['id']),
            'og_type' => 'article',
            'og_image' => (!empty($project['image_path'])) ? base_url(trim(explode(';', $project['image_path'])[0])) : null,
            'project' => $project
        ];

        return view('portfolio/show', $data);
    }
}
