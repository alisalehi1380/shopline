<?php

namespace Modules\RolePermission\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * Permissions
     */
    public const PERMISSION_SUPER_ADMIN = 'permission super admin';
    public const PERMISSION_PANEL = 'permission panel';
    public const PERMISSION_USERS = 'permission users';
    public const PERMISSION_CATEGORIES = 'permission categories';
    public const PERMISSION_ROLE_PERMISSIONS = 'permission role permissions';
    public const PERMISSION_ARTICLES = 'permission articles';

    /**
     * Get permissions in array with static.
     *
     * @var array|string[]
     */
    public static array $permissions = [
        self::PERMISSION_SUPER_ADMIN,
        self::PERMISSION_PANEL,
        self::PERMISSION_USERS,
        self::PERMISSION_CATEGORIES,
        self::PERMISSION_ROLE_PERMISSIONS,
        self::PERMISSION_ARTICLES,
    ];
}
