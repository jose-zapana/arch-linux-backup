<?php

namespace App\Enums;

enum QuotationStatus: int
{
    case Pending = 1; // Pendiente
    case Sent = 2; // Enviada
    case Accepted = 3; // Aceptada
    case Rejected = 4; // Rechazada
    case Expired = 5; // Vencida
    case Cancelled = 6; // Cancelada
    case ConvertedToOrder = 8; // Convertida en Orden
    case Archived = 9; // Archivada
    case Processing = 10; // En Proceso
}
