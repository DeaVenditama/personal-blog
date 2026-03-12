<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Portfolios extends BaseController
{
    public function index()
    {
        $portfolioModel = new \App\Models\Portfolio();
        $data = [
            'title' => 'Manage Portfolios',
            'portfolios' => $portfolioModel->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/portfolios/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Portfolio Project'
        ];
        return view('admin/portfolios/create', $data);
    }

    public function store()
    {
        $portfolioModel = new \App\Models\Portfolio();

        $validationRule = [
            'title' => 'required|min_length[3]|max_length[250]',
            'description' => 'required',
            'status' => 'required|in_list[draft,published]',
            'tools' => 'required',
            'project_url' => 'permit_empty|valid_url',
            'sort_order' => 'permit_empty|is_natural',
            'image' => [
                'label' => 'Project Image',
                'rules' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[image,2048]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('image');
        $imagePath = '';

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/portfolio', $newName);
            $imagePath = 'uploads/portfolio/' . $newName;
        }

        $description = $this->request->getPost('description');
        $description = preg_replace('#<script(.*?)>(.*?)</script>#is', '', (string) $description);

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $description,
            'tools' => $this->request->getPost('tools'),
            'project_url' => $this->request->getPost('project_url') ?: null,
            'status' => $this->request->getPost('status'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'image_path' => $imagePath
        ];

        $portfolioModel->insert($data);
        session()->setFlashdata('success', 'Portfolio project added successfully!');
        return redirect()->to(base_url('admin/portfolios'));
    }

    public function show($id)
    {
        $portfolioModel = new \App\Models\Portfolio();
        $data = [
            'title' => 'View Portfolio Project',
            'portfolio' => $portfolioModel->find($id)
        ];

        if (!$data['portfolio']) {
            return redirect()->to(base_url('admin/portfolios'))->with('error', 'Project not found.');
        }

        return view('admin/portfolios/show', $data);
    }

    public function edit($id)
    {
        $portfolioModel = new \App\Models\Portfolio();
        $data = [
            'title' => 'Edit Portfolio Project',
            'portfolio' => $portfolioModel->find($id)
        ];

        if (!$data['portfolio'])
            return redirect()->to(base_url('admin/portfolios'));

        return view('admin/portfolios/edit', $data);
    }

    public function update($id)
    {
        $portfolioModel = new \App\Models\Portfolio();
        $portfolio = $portfolioModel->find($id);

        if (!$portfolio) {
            return redirect()->to(base_url('admin/portfolios'));
        }

        $validationRule = [
            'title' => 'required|min_length[3]|max_length[250]',
            'description' => 'required',
            'status' => 'required|in_list[draft,published]',
            'tools' => 'required',
            'project_url' => 'permit_empty|valid_url',
            'sort_order' => 'permit_empty|is_natural',
            'image' => [
                'label' => 'Project Image',
                'rules' => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[image,2048]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $description = $this->request->getPost('description');
        $description = preg_replace('#<script(.*?)>(.*?)</script>#is', '', (string) $description);

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $description,
            'tools' => $this->request->getPost('tools'),
            'project_url' => $this->request->getPost('project_url') ?: null,
            'status' => $this->request->getPost('status'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/portfolio', $newName);
            $data['image_path'] = 'uploads/portfolio/' . $newName;

            // Delete old image
            if (!empty($portfolio['image_path']) && file_exists(FCPATH . $portfolio['image_path'])) {
                unlink(FCPATH . $portfolio['image_path']);
            }
        }

        $portfolioModel->update($id, $data);
        session()->setFlashdata('success', 'Portfolio project updated successfully!');
        return redirect()->to(base_url('admin/portfolios'));
    }

    public function delete($id)
    {
        $portfolioModel = new \App\Models\Portfolio();
        $portfolio = $portfolioModel->find($id);

        if ($portfolio) {
            if (!empty($portfolio['image_path']) && file_exists(FCPATH . $portfolio['image_path'])) {
                unlink(FCPATH . $portfolio['image_path']);
            }
            $portfolioModel->delete($id);
            session()->setFlashdata('success', 'Portfolio project deleted successfully!');
        } else {
            session()->setFlashdata('error', 'Project not found.');
        }

        return redirect()->to(base_url('admin/portfolios'));
    }
}
