<?php

/**
 * @OA\Schema(
 *     schema="Resource",
 *     required={"id", "name", "type"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Meeting Room A"),
 *     @OA\Property(property="type", type="string", example="room"),
 *     @OA\Property(property="description", type="string", example="Large meeting room with projector")
 * )
 */

/**
 * @OA\Schema(
 *     schema="Booking",
 *     required={"id", "resource_id", "user_id", "start_time", "end_time"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="resource_id", type="integer", example=1),
 *     @OA\Property(property="start_time", type="string", format="date-time")
 * )
 */

