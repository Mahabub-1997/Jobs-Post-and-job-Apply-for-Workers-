<?php

namespace App\Events;

use App\Models\JobPost;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class JobPostCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $jobPost;

    public function __construct(JobPost $jobPost)
    {
        $this->jobPost = $jobPost;
    }

    public function broadcastOn()
    {
        // Public channel or private channel
        return new Channel('job-post-channel');
    }

    public function broadcastAs()
    {
        return 'job-post-created';
    }

    public function broadcastWith()
    {
        return [
            'job_post_id' => $this->jobPost->id,
            'title' => $this->jobPost->title ?? 'New Job Post',
            'message' => 'নতুন একটি Job পোস্ট করা হয়েছে',
            'location' => $this->jobPost->location,
            'start_date' => $this->jobPost->start_date?->toDateString(),
        ];
    }
}
