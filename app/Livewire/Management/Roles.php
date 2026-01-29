<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Role;
use Livewire\Attributes\Validate;

class Roles extends Component
{
    public $roles;
    public $showModal = false;
    public $isEditing = false;
    public $viewOnly = false;
    
    // Form properties
    public $roleId;
    #[Validate('required|min:3')]
    public $name;
    #[Validate('required|min:3')]
    public $label;
    public $description;
    public $selectedPermissions = [];

    // Detailed permissions list grouped by category
    public $availablePermissions = [
        'Users' => [
            'view_users' => 'Bekijk gebruikers',
            'create_users' => 'Gebruikers aanmaken',
            'edit_users' => 'Gebruikers bewerken',
            'delete_users' => 'Gebruikers verwijderen',
        ],
        'Roles' => [
            'view_roles' => 'Bekijk rollen',
            'manage_roles' => 'Rollen beheren',
        ],
        'Sales' => [
            'view_customers' => 'Bekijk klanten',
            'manage_customers' => 'Klanten beheren',
            'view_offertes' => 'Bekijk offertes',
            'manage_offertes' => 'Offertes beheren',
        ],
        'Finance' => [
            'view_invoices' => 'Bekijk facturen',
            'manage_invoices' => 'Facturen beheren',
            'view_contracts' => 'Bekijk contracten',
        ],
        'Technician' => [
            'view_tickets' => 'Bekijk tickets',
            'manage_tickets' => 'Tickets beheren',
            'view_planning' => 'Bekijk planning',
        ],
        'Purchasing' => [
            'view_products' => 'Bekijk producten',
            'manage_products' => 'Producten beheren',
            'view_orders' => 'Bekijk bestellingen',
        ],
    ];

    public function mount()
    {
        $this->loadRoles();
    }

    public function loadRoles()
    {
        $this->roles = Role::all();
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->viewOnly = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->label = $role->label;
        $this->description = $role->description;
        // Ensure permissions is an array, default to empty
        $this->selectedPermissions = $role->permissions ?? [];
        
        $this->isEditing = true;
        $this->viewOnly = false;
        $this->showModal = true;
    }

    public function preview($id)
    {
        $role = Role::findOrFail($id);
        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->label = $role->label;
        $this->description = $role->description;
        $this->selectedPermissions = $role->permissions ?? [];
        
        $this->isEditing = false;
        $this->viewOnly = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $role = Role::findOrFail($this->roleId);
            $role->update([
                'name' => $this->name,
                'label' => $this->label,
                'description' => $this->description,
                'permissions' => $this->selectedPermissions,
            ]);
        } else {
            Role::create([
                'name' => $this->name,
                'label' => $this->label,
                'description' => $this->description,
                'permissions' => $this->selectedPermissions,
            ]);
        }

        $this->loadRoles();
        $this->showModal = false;
        session()->flash('success', $this->isEditing ? 'Rol succesvol bijgewerkt.' : 'Nieuwe rol succesvol aangemaakt.');
        $this->resetForm();
    }

    public function delete($id)
    {
        Role::findOrFail($id)->delete();
        $this->loadRoles();
    }

    public function resetForm()
    {
        $this->roleId = null;
        $this->name = '';
        $this->label = '';
        $this->description = '';
        $this->selectedPermissions = [];
        $this->viewOnly = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.management.roles');
    }
}
