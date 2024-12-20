<?php

namespace App\Enum;

enum TicketDeadline: string
{
    case NOW = 'now';
    case TODAY = '24h';
    case THIS_WEEK = 'this_week';
    case THIS_MONTH = 'this_month';
    case NON_PRIORITY = 'non_priority';
}