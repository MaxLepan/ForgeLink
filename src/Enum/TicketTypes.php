<?php

namespace App\Enum;

enum TicketTypes: string
{
    case BUG = 'bug';
    case FEATURE = 'feature';
    case MAINTENANCE = 'maintenance';
    case HARDWARE_ISSUE = 'hardware_issue';
    case SOFTWARE_ISSUE = 'software_issue';
}