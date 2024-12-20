<?php 

namespace App\Enum;

enum UserRoles: string
{
    case ROLE_ADMIN = 'admin';
    case ROLE_PROJECT_MANAGER = 'project_manager';
    case ROLE_LEAD_DEVELOPER = 'lead_developer';
    case ROLE_DEVELOPER = 'developer';
    case ROLE_LEAD_ENGINEER = 'lead_engineer';
    case ROLE_ENGINEER = 'engineer';
    case ROLE_LEAD_MANUFACTURER = 'lead_manufacturer';
    case ROLE_MANUFACTURER = 'manufacturer';
    case ROLE_TERRAIN_OPERATOR = 'terrain_operator';
}