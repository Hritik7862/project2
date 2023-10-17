<?php

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RemarkAdded extends Notification
{
    public $taskId;
    public $remarks;

    public function __construct($taskId, $remarks)
    {
        $this->taskId = $taskId;
        $this->remarks = $remarks;
    }

    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->taskId,
            'remarks' => $this->remarks,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->taskId,
            'remarks' => $this->remarks,
        ];
    }

    // ...
}
