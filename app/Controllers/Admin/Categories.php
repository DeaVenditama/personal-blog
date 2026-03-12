<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Categories extends BaseController
{
    public function index()
    {
        $categoryModel = new \App\Models\Category();
        $data = [
            'title' => 'Manage Categories',
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll()
        ];
        return view('admin/categories/index', $data);
    }

    public function store()
    {
        $categoryModel = new \App\Models\Category();
        $validationRule = [
            'name' => 'required|min_length[3]|max_length[100]|is_unique[categories.name]'
        ];

        if (!$this->validate($validationRule)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->to(base_url('admin/categories'));
        }

        $name = $this->request->getPost('name');
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

        $categoryModel->insert([
            'name' => $name,
            'slug' => $slug
        ]);

        session()->setFlashdata('success', 'Category added successfully!');
        return redirect()->to(base_url('admin/categories'));
    }

    public function edit($id)
    {
        $categoryModel = new \App\Models\Category();
        $data = [
            'title' => 'Edit Category',
            'category' => $categoryModel->find($id)
        ];

        if (!$data['category']) {
            return redirect()->to(base_url('admin/categories'))->with('error', 'Category not found.');
        }

        return view('admin/categories/edit', $data);
    }

    public function update($id)
    {
        $categoryModel = new \App\Models\Category();

        $validationRule = [
            'name' => "required|min_length[3]|max_length[100]|is_unique[categories.name,id,{$id}]"
        ];

        if (!$this->validate($validationRule)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $name = $this->request->getPost('name');
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

        $categoryModel->update($id, [
            'name' => $name,
            'slug' => $slug
        ]);

        session()->setFlashdata('success', 'Category updated successfully!');
        return redirect()->to(base_url('admin/categories'));
    }

    public function delete($id)
    {
        $categoryModel = new \App\Models\Category();
        $categoryModel->delete($id);

        session()->setFlashdata('success', 'Category deleted successfully!');
        return redirect()->to(base_url('admin/categories'));
    }
}
