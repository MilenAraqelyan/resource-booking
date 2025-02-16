<?php

namespace App\Services;

use App\Exceptions\BookingCancellationException;
use App\Exceptions\InvalidBookingTimeException;
use App\Exceptions\ResourceNotAvailableException;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BookingService
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository,
        private readonly ResourceService $resourceService
    ) {
    }

    public function getAllBookings(): Collection
    {
        return $this->bookingRepository->all();
    }

    public function getBooking(int $id)
    {
        return $this->bookingRepository->find($id);
    }

    public function createBooking(array $data)
    {
        if (!$this->resourceService->checkResourceAvailability(
            $data['resource_id'],
            $data['start_time'],
            $data['end_time']
        )) {
            throw new ResourceNotAvailableException(
                'Resource is not available for the selected time period'
            );
        }

        // Validate booking time constraints
        $this->validateBookingTime($data['start_time'], $data['end_time']);

        return $this->bookingRepository->create($data);
    }

    public function cancelBooking(int $id): bool
    {
        $booking = $this->getBooking($id);

        if (Carbon::parse($booking->start_time)->isPast()) {
            throw new BookingCancellationException('Cannot cancel past bookings');
        }

        return $booking->cancel();
    }

    private function validateBookingTime(string $startTime, string $endTime): void
    {
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);

        if ($start->isPast()) {
            throw new InvalidBookingTimeException('Cannot create bookings in the past');
        }

        if ($end->diffInHours($start) > 24) {
            throw new InvalidBookingTimeException('Booking duration cannot exceed 24 hours');
        }
    }
}
