<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookingController extends Controller
{
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(): AnonymousResourceCollection
    {
        return BookingResource::collection($this->bookingService->getAllBookings());
    }
    /**
     * @OA\Post(
     *     path="/bookings",
     *     summary="Create a new booking",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BookingRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Booking created successfully"
     *     )
     * )
     */
    public function store(CreateBookingRequest $request): BookingResource
    {
        $booking = $this->bookingService->createBooking($request->validated());
        return new BookingResource($booking);
    }

    public function show(int $id): BookingResource
    {
        return new BookingResource($this->bookingService->getBooking($id));
    }
    /**
     * @OA\Delete(
     *     path="/bookings/{id}",
     *     summary="Cancel a booking",
     *     tags={"Bookings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Booking cancelled successfully"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->bookingService->cancelBooking($id);
        return response()->json(['message' => 'Booking cancelled successfully']);
    }
}
