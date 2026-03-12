<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Media extends BaseController
{
    public function index()
    {
        $mediaModel = new \App\Models\Media();
        $data = [
            'title' => 'Media Library',
            'media' => $mediaModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/media/index', $data);
    }

    public function upload()
    {
        $validationRule = [
            'file' => [
                'label' => 'Image File',
                'rules' => 'uploaded[file]|is_image[file]|mime_in[file,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[file,2048]',
            ],
        ];
        if (!$this->validate($validationRule)) {
            session()->setFlashdata('error', $this->validator->getErrors()['file']);
            return redirect()->to(base_url('admin/media'));
        }

        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);

            $mediaModel = new \App\Models\Media();
            $mediaModel->insert([
                'user_id' => session()->get('id'),
                'filename' => $file->getClientName(),
                'file_path' => 'uploads/' . $newName,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSizeByUnit('kb')
            ]);

            session()->setFlashdata('success', 'File uploaded successfully.');
        } else {
            session()->setFlashdata('error', 'File upload failed: ' . $file->getErrorString());
        }

        return redirect()->to(base_url('admin/media'));
    }

    public function delete($id)
    {
        $mediaModel = new \App\Models\Media();
        $media = $mediaModel->find($id);

        if ($media) {
            $filePath = FCPATH . $media['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $mediaModel->delete($id);
            session()->setFlashdata('success', 'File deleted successfully.');
        } else {
            session()->setFlashdata('error', 'File not found.');
        }

        return redirect()->to(base_url('admin/media'));
    }
}
