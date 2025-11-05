<?php

namespace App\Notifications;

use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewJobPostNotification extends Notification
{
    use Queueable;

    protected $jobPost;

    public function __construct($jobPost)
    {
        $this->jobPost = $jobPost;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'job_post_id' => $this->jobPost->id,
            'title' => $this->jobPost->title ?? 'New Job Post',
            'message' => 'নতুন একটি Job পোস্ট করা হয়েছে',
            'location' => $this->jobPost->location,
            'start_date' => $this->jobPost->start_date?->toDateString(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'job_post_id' => $this->jobPost->id,
            'title' => $this->jobPost->title ?? 'New Job Post',
            'message' => 'নতুন একটি Job পোস্ট করা হয়েছে',
            'location' => $this->jobPost->location,
            'start_date' => $this->jobPost->start_date?->toDateString(),
            'created_at' => now()->toDateTimeString(),
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('job-post-channel'); // public channel for all tradepersons
    }

    public function broadcastAs()
    {
        return 'job-post-created';
    }
}
