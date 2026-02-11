<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Sales',
                'label' => 'Sales',
                'description' => 'Verkoop en klantrelatie management',
                'permissions' => ['view_customers', 'manage_customers', 'view_offertes', 'manage_offertes']
            ],
            [
                'name' => 'Finance',
                'label' => 'Finance',
                'description' => 'Financiële administratie en boekhouding',
                'permissions' => ['view_invoices', 'manage_invoices', 'view_contracts']
            ],
            [
                'name' => 'Technician',
                'label' => 'Service',
                'description' => 'Technische ondersteuning en planning',
                'permissions' => ['view_tickets', 'manage_tickets', 'view_planning']
            ],
            [
                'name' => 'Purchasing',
                'label' => 'Inkoop',
                'description' => 'Inkoop en voorraadbeheer',
                'permissions' => ['view_products', 'manage_products', 'view_orders']
            ],
            [
                'name' => 'Planner',
                'label' => 'Planner',
                'description' => 'Planning van werkzaamheden',
                'permissions' => ['view_tickets', 'view_planning']
            ],
        ];

        $allPermissions = collect($roles)
            ->pluck('permissions')
            ->flatten()
            ->unique()
            ->values()
            ->all();

        $adminExtraPermissions = [
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'view_roles',
            'manage_roles',
        ];

        array_unshift($roles, [
            'name' => 'Admin',
            'label' => 'Admin',
            'description' => 'Volledige systeem toegang met alle permissies',
            'permissions' => collect($allPermissions)
                ->merge($adminExtraPermissions)
                ->unique()
                ->values()
                ->all(),
        ]);

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
