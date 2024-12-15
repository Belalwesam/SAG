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
            "clients" => [
                [
                    "en" => 'see clients',
                    "ar" => "عرض العملاء"
                ],
                [
                    "en" => 'create clients',
                    "ar" => "إنشاء العملاء"
                ],
                [
                    "en" => 'edit clients',
                    "ar" => "تعديل العملاء"
                ],
            ],
            "projects" => [
                [
                    "en" => 'see projects',
                    "ar" => "عرض المشاريع"
                ],
                [
                    "en" => 'create projects',
                    "ar" => "إنشاء المشاريع"
                ],
                [
                    "en" => 'edit projects',
                    "ar" => "تعديل المشاريع"
                ],
            ],
            "tickets" => [
                [
                    "en" => 'see tickets',
                    "ar" => "عرض التذاكر"
                ],
                [
                    "en" => 'create tickets',
                    "ar" => "إنشاء التذاكر"
                ],
                [
                    "en" => 'edit tickets',
                    "ar" => "تعديل التذاكر"
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
        $supervisor_role = Role::create([
            'name' => 'Supervisor',
            'name_ar' => "مشرف",
            'guard_name' => 'admin'
        ]);

        $supervisor_permissions = Permission::where('name', 'see tickets')->get();

        $supervisor_role->syncPermissions($supervisor_permissions);

        #assign the role to the super admin
        Admin::first()->syncRoles([$super_admin_role]);
        Admin::find(2)->syncRoles([$supervisor_role]);
    }
}
