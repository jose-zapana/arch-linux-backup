<?php

namespace App\Enums;

enum ShipmentStatus: int
{
    case Pending = 1;
    case Shipped = 2;
    case Failed = 3;

}
