<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Roles
        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleEditor = Role::create(['name' => 'editor']);
        $roleUser = Role::create(['name' => 'user']);

        //Permissions List as array
        $permissions = [

            /**
             * Permission Module
             *only for
             *Dashboard
             */

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    //Dashboard Permission
                    'dashboard.view',
                    'dashboard.edit',
                ],
            ],

            /**
             * Permission Module
             *Blog
             */
            [
                'group_name' => 'blog',
                'permissions' => [
                    //Blog Permissions
                    'blog.create',
                    'blog.view',
                    'blog.edit',
                    'blog.delete',
                    'blog.approve',
                ],
            ],

            /**
             * Permission Module
             *Admin
             */
            [
                'group_name' => 'admin',
                'permissions' => [
                    //Admin Permissions
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                    'admin.approve',
                ],
            ],

            /**
             * Permission Module
             *Role
             */
            [
                'group_name' => 'role',
                'permissions' => [
                    //Role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.approve',
                ],
            ],

            /**
             * Permission Module
             *Profile
             */
            [
                'group_name' => 'profile',
                'permissions' => [
                    //Profile Permissions
                    'profile.view',
                    'profile.edit',
                ],
            ],

        ];

        //Create Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {

            //Create and assign permission group
            $permissionGroup = $permissions[$i]['group_name'];

            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                //Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);

                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);

            }

        }

    } //end of the run method

} //end of the RolePermissionSeeder class