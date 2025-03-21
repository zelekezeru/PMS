<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    public $assigningUser;

    /**
     * Create a new message instance.
     */
    public function __construct($task, $assigningUser)
    {
        $this->task = $task;
        $this->assigningUser = $assigningUser;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You have been assigned to a new task',
            from: new Address($this->assigningUser->email, $this->assigningUser->name)  // Set the From address dynamically
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->markdown('emails.task-assigned')->with([
            'task' => $this->task,
            'assigningUser' => $this->assigningUser,  // Pass the assigning user to the view
        ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
