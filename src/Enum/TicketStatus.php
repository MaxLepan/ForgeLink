<?php

namespace App\Enum;

enum TicketStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
    case BLOCKED = 'blocked';
    case CLOSED = 'closed';
}