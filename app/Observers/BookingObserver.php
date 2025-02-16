<?php

namespace App\Observers;

use App\Models\Booking;
use App\Notifications\BookingCreated;
use App\Notifications\BookingCancelled;
use App\Events\BookingCreatedEvent;
use App\Events\BookingCancelledEvent;

class BookingObserver
{
    public function created(Booking $booking): void
    {
        // Отправка уведомления пользователю
        $booking->user->notify(new BookingCreated($booking));

        // Отправка уведомления администратору ресурса
        $booking->resource->administrator->notify(new BookingCreated($booking));

        // Вызов события для других слушателей
        event(new BookingCreatedEvent($booking));
    }

    public function updated(Booking $booking): void
    {
        if ($booking->isDirty('status') && $booking->status === 'cancelled') {
            $booking->user->notify(new BookingCancelled($booking));
            event(new BookingCancelledEvent($booking));
        }
    }
}
