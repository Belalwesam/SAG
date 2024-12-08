<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //define the permissions
        $permissions = [
            "roles" => [
                [
                    "en" => 'see roles',
                    "ar" => "عرض الأدوار"
                ],
                [
                    "en" => 'create roles',
                    "ar" => "إنشاء الأدوار"
                ],
                [
                    "en" => 'edit roles',
                    "ar" => "تعديل الأدوار"
                ],
            ],
            "admins" => [
                [
                    "en" => 'see admins',
                    "ar" => "عرض مدراء النظام"
                ],
                [
                    "en" => 'create admins',
                    "ar" => "إنشاء مديري النظام"
                ],
                [
                    "en" => 'edit admins',
                    "ar" => "تعديل مديري النظام"
                ],
            ],
        ];

        #loop over groups and create permissions accordingly
        foreach ($permissions as $key => $value) {
            foreach ($value as $permission) {
                Permission::firstOrCreate(["name" => $permission['en']], [
                    'name' => $permission['en'],
                    'name_ar' => $permission['ar'],
                    'guard_name' => 'admin',
                    'permission_group' => $key
                ]);
            }
        }


        #create the super admin role and sync all permissions to it
        $super_admin_role = Role::create([
            'name' => 'Super Admin',
            'name_ar' => "سوبر ادمن",
            'guard_name' => 'admin'
        ]);

        $super_admin_role->syncPermissions(Permission::all());

        #assign the role to the super admin
        Admin::first()->syncRoles([$super_admin_role]);
    }
}
