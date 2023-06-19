<?php

namespace App\Enums;

enum OrderStatus:string {
    case PLACED = 'PLACED';
    case PACKED = 'PACKED';
    case SHIPPED = 'SHIPPED';
    case OFD = 'OUT FOR DELIVERY';
    case DELIVERED = 'DELIVERED';
    case CANCELLED = 'CANCELLED';
}
