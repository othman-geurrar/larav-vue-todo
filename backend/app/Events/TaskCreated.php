<?php
// app/Events/TaskCreated.php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function broadcastOn()
    {
        return new Channel('tasks');
    }

    public function broadcastAs()
    {
        return 'task.created';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->task->id,
            'title' => $this->task->title,
            'description' => $this->task->description,
            'created_at' => $this->task->created_at->toDateTimeString(),
            'message' => 'Une nouvelle tâche a été créée avec succès!'
        ];
    }
}