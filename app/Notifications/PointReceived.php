<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PointReceived extends Notification
{
    use Queueable;

    private $data;

    /**
     * ডাটা রিসিভ করার জন্য কনস্ট্রাক্টর সেট করা হলো
     */
    public function __construct($details)
    {
        $this->data = $details;
    }

    /**
     * ডেলিভারি চ্যানেল হিসেবে আমরা শুধু database ব্যবহার করবো
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * ডাটাবেজের 'data' কলামে যা যা সেভ হবে
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title'   => $this->data['title'] ?? 'পয়েন্ট আপডেট',
            'message' => $this->data['message'] ?? 'আপনি নতুন পয়েন্ট পেয়েছেন।',
            'icon'    => $this->data['icon'] ?? 'mdi-star',
            'color'   => $this->data['color'] ?? 'text-primary',
            'url'     => $this->data['url'] ?? route('passbook') // যেখানে ক্লিক করলে নিয়ে যাবে
        ];
    }
}