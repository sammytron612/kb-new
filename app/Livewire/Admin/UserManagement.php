<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedRole = '';
    public $selectedStatus = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Modal properties
    public $showEditModal = false;
    public $editingUser = null;
    public $editRole = '';
    public $editStatus = '';

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'editRole' => 'required|in:1,2,3',
        'editStatus' => 'required|boolean',
    ];

    public function mount()
    {
        // Check if user is admin
        if (!Gate::allows('isAdmin')) {
            abort(403);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedRole()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function editUser($userId)
    {
        $this->editingUser = User::findOrFail($userId);

        // Prevent editing yourself
        if ($this->editingUser->id === auth()->id()) {
            session()->flash('error', 'You cannot edit your own account.');
            return;
        }

        // Set the current values
        $this->editRole = (string) $this->editingUser->role;
        $this->editStatus = $this->editingUser->status;

        // Reset validation errors
        $this->resetValidation();

        $this->showEditModal = true;
    }

    public function updateUser()
    {
        $this->validate([
            'editRole' => 'required|in:1,2,3',
            'editStatus' => 'required|boolean',
        ], [
            'editRole.required' => 'Please select a role.',
            'editRole.in' => 'Please select a valid role.',
            'editStatus.required' => 'Please select a status.',
            'editStatus.boolean' => 'Status must be true or false.',
        ]);

        if (!$this->editingUser || $this->editingUser->id === auth()->id()) {
            session()->flash('error', 'You cannot modify your own account.');
            return;
        }

        $this->editingUser->update([
            'role' => (int) $this->editRole,
            'status' => (bool) $this->editStatus,
        ]);

        $this->closeEditModal();

        session()->flash('success', 'User updated successfully.');
    }

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);

        // Prevent disabling yourself
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot disable your own account.');
            return;
        }

        $user->update(['status' => !$user->status]);

        session()->flash('success', $user->fresh()->status ? 'User enabled successfully.' : 'User disabled successfully.');
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingUser = null;
        $this->editRole = '';
        $this->editStatus = '';
        $this->resetValidation();
    }

    // Computed properties for role names and colors
    public function getRoleNameProperty()
    {
        return [
            0 => 'Disabled',
            1 => 'Admin',
            2 => 'Editor',
            3 => 'Viewer'
        ];
    }

    public function getRoleColorsProperty()
    {
        return [
            0 => 'bg-gray-500 text-white dark:bg-gray-600 dark:text-gray-200',
            1 => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            2 => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            3 => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
        ];
    }

    public function getStatusColorsProperty()
    {
        return [
            1 => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            0 => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
        ];
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedRole !== '', function ($query) {
                $query->where('role', $this->selectedRole);
            })
            ->when($this->selectedStatus !== '', function ($query) {
                $query->where('status', $this->selectedStatus);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.user-management', compact('users'));
    }
}
