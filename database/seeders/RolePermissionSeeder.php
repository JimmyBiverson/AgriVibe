<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = 'web';

        // 1. Create every permission from the resource => actions map.
        $permissionNames = [];
        foreach (config('agrivibe.permissions') as $resource => $actions) {
            foreach ($actions as $action) {
                $name = "{$resource}.{$action}";
                $permissionNames[$name] = true;
                Permission::findOrCreate($name, $guard);
            }
        }
        $allPermissions = array_keys($permissionNames);

        // 2. Create roles.
        $roleNames = collect(config('agrivibe.roles'))->flatten()->keys()->all();
        $roles = [];
        foreach (config('agrivibe.roles') as $group => $groupRoles) {
            foreach ($groupRoles as $name => $label) {
                $roles[$name] = Role::findOrCreate($name, $guard);
            }
        }

        // Refresh the permission cache so freshly created permissions are visible.
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 3. Assign permissions to roles (expanding wildcards).
        foreach (config('agrivibe.role_permissions') as $role => $patterns) {
            if (! isset($roles[$role])) {
                continue;
            }

            $resolved = $this->expand($patterns, $allPermissions);
            $roles[$role]->syncPermissions($resolved);
        }

        // 4. Grant every permission to super_admin explicitly (belt & braces).
        $roles['super_admin']->syncPermissions($allPermissions);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * @param  array<int, string>  $patterns
     * @param  array<int, string>  $all
     * @return array<int, string>
     */
    protected function expand(array $patterns, array $all): array
    {
        $resolved = [];

        foreach ($patterns as $pattern) {
            if ($pattern === '*') {
                return $all;
            }

            if (str_ends_with($pattern, '.*')) {
                $prefix = substr($pattern, 0, -1); // keep trailing dot

                foreach ($all as $permission) {
                    if (str_starts_with($permission, $prefix)) {
                        $resolved[] = $permission;
                    }
                }

                continue;
            }

            if (in_array($pattern, $all, true)) {
                $resolved[] = $pattern;
            }
        }

        return array_values(array_unique($resolved));
    }
}
