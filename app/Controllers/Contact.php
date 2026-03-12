<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Contact extends BaseController
{
    public function send()
    {
        // Rate Limiting: Max 3 messages per hour per session to prevent spam
        $session = session();
        $contactCount = $session->get('contact_count') ?? 0;
        $lastContactTime = $session->get('last_contact_time') ?? 0;

        // Reset count if an hour has passed
        if (time() - $lastContactTime > 3600) {
            $contactCount = 0;
        }

        if ($contactCount >= 3) {
            return redirect()->back()->with('contact_error', 'Anda telah mencapai batas pengiriman pesan (maksimal 3 per jam).');
        }

        // Validation Rules
        $rules = [
            'name' => 'required|max_length[150]',
            'email' => 'required|valid_email|max_length[150]',
            'message' => 'required|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $messageBody = $this->request->getPost('message');

        // Save to Database
        $messageModel = new \App\Models\Message();
        $messageModel->save([
            'name' => $name,
            'email' => $email,
            'message' => $messageBody
        ]);

        // Increment Rate Limit Counters
        $session->set('contact_count', $contactCount + 1);
        $session->set('last_contact_time', time());

        return redirect()->back()->with('contact_success', 'Pesan Anda berhasil dikirim dan tersimpan di sistem kami!');
    }
}
