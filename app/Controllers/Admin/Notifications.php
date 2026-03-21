<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Notifications extends BaseController
{
    public function read($id)
    {
        $notificationModel = new \App\Models\Notification();
        $notif = $notificationModel->find($id);

        if ($notif) {
            $notificationModel->update($id, ['is_read' => 1]);
            
            // Redirect based on type
            if ($notif['type'] == 'New Comment') {
                return redirect()->to(base_url('admin/posts/comments/' . $notif['reference_id']));
            }
        }

        return redirect()->back();
    }
}
