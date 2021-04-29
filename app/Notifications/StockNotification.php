<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
//use Illuminate\Notifications\Notification;
use Notification;


class StockNotification extends Notification
{
    use Queueable;
    private $stockData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($stockData)
    {
        $this->stockData = $stockData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->name($this->stockData['name'])
                    ->line($this->stockData['body'])
                    ->action($this->stockData['text'], $this->stockData['url'])
                    ->line($this->stockData['thanks']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
         return [
            'pdid'     => $this->stockData['pdid'],
            'status' => 'placed',
        ];
    }
}
