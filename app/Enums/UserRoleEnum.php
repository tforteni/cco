<?php

namespace App\Enums;

enum UserRoleEnum : string {
    case MEMBER = 'member';
    case BRAIDER = 'braider';
    case ADMIN = 'admin';
}