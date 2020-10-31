<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function getUnread()
    {
        return auth()->user()
            ->unreadNotifications;
    }

    public function getRead()
    {
        return auth()->user()
            ->readNotifications;
    }

    public function getAll()
    {
        return auth()->user()
            ->notifications;
    }

    public function read($id)
    {
        $notification = $this->get($id);

        abort_if($notification->read_at, 404, 'Notification already read');

        $notification->markAsRead();

        return response()->json(true);
    }

    public function unread($id)
    {
        $notification = $this->get($id);

        abort_if(!$notification->read_at, 404, "Can't unread. Notification was not read yet");

        $notification->markAsUnread();

        return response()->json(true);
    }

    public function get($id)
    {
        return auth()->user()
            ->notifications()
            ->whereId($id)
            ->first() ?? abort(404, 'Notification was not found');
    }

    public function delete($id)
    {
        $this->get($id)->delete();

        return response()->json(true);
    }

    public function deleteAll()
    {
        $this->getAll()->each->delete();

        return response()->json(true);
    }

    public function readAll()
    {
        auth()->user()
            ->unreadNotifications
            ->each
            ->markAsRead();

        return response()->json(true);
    }

    public function unreadAll()
    {
        auth()->user()
            ->readNotifications
            ->each
            ->markAsUnread();

        return response()->json(true);
    }
}
