<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingCreated extends Notification
{
    private $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Confirmation')
            ->line('Your booking has been confirmed.')
            ->line('Resource: ' . $this->booking->resource->name)
            ->line('Date: ' . $this->booking->start_time->format('Y-m-d H:i'))
            ->action('View Booking', url('/bookings/' . $this->booking->id));
    }
}
