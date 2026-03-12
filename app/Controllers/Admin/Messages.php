<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Message;

class Messages extends BaseController
{
    protected $messageModel;

    public function __construct()
    {
        $this->messageModel = new Message();
    }

    public function index()
    {
        $data = [
            'title' => 'Inbox Messages',
            'messages' => $this->messageModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/messages/index', $data);
    }

    public function show($id)
    {
        $message = $this->messageModel->find($id);

        if (!$message) {
            return redirect()->to('admin/messages')->with('error', 'Pesan tidak ditemukan.');
        }

        $data = [
            'title' => 'View Message',
            'message' => $message
        ];

        return view('admin/messages/show', $data);
    }

    public function delete($id)
    {
        $message = $this->messageModel->find($id);
        if ($message) {
            $this->messageModel->delete($id);
            return redirect()->to('admin/messages')->with('success', 'Pesan berhasil dihapus.');
        }

        return redirect()->to('admin/messages')->with('error', 'Pesan tidak ditemukan.');
    }
}
