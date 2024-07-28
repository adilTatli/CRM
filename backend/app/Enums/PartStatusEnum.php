<?php

namespace App\Enums;

enum PartStatusEnum: string
{
    case PENDING = 'Pending';
    case NEED_TO_ORDER = 'Need To Order';
    case PARTS_ORDERED = 'Parts Ordered';
    case PARTS_RECEIVED = 'Parts Received';
    case INSTALLED = 'Installed';
    case ORDER_CANCELLED = 'Order Cancelled';
}
