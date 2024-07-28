<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case NEED_TO_SELL = 'Need to Sell';
    case NEED_TO_SCHEDULE = 'Need to Schedule';
    case APPOINTMENT_SCHEDULED = 'Appointment Scheduled';
    case CANCELLED = 'Cancelled';
    case NEED_AUTHORIZATION = 'Need Authorization';
    case NEED_PARTS = 'Need Parts';
    case PARTS_ORDERED = 'Parts Ordered';
    case HOLD = 'Hold';
    case NEED_TO_BILL = 'Need to Bill';
    case BILLED = 'Billed';
    case COMPLETED = 'Completed';
}
