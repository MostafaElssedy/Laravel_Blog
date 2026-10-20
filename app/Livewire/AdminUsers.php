<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\UserType;
use App\UserStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminUsers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Filters and search
    public $search = '';
    public $filterType = '';
    public $filterStatus = '';
    public $perPage = 10;

    // Form inputs
    public $isEditMode = false;
    public $selectedUserId = null;
    public $name = '';
    public $username = '';
    public $email = '';
    public $type = 'admin';
    public $status = 'active';
    public $password = '';
    public $password_confirmation = '';
    public $bio = '';

    // Deletion
    public $userToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset([
            'isEditMode',
            'selectedUserId',
            'name',
            'username',
            'email',
            'password',
            'password_confirmation',
            'bio',
        ]);
        $this->type = 'admin';
        $this->status = 'active';

        $this->dispatch('showUserModal');
    }

    public function createUser()
    {
        $this->validate([
            'name'     => 'required|string|min:3|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'username' => 'required|string|min:3|max:100|alpha_dash|unique:users,username',
            'type'     => ['required', Rule::in(['admin', 'superAdmin'])],
            'status'   => ['required', Rule::in(['active', 'inactive', 'pending', 'rejected'])],
            'password' => 'required|string|min:6|confirmed',
            'bio'      => 'nullable|string|max:500',
        ], [
            'name.required'      => 'Please enter the user\'s name.',
            'email.required'     => 'Email address is required.',
            'email.unique'       => 'This email address is already in use.',
            'username.required'  => 'Username is required.',
            'username.unique'    => 'This username is already taken.',
            'password.required'  => 'Password is required.',
            'password.min'       => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user = new User();
        $user->name = trim($this->name);
        $user->email = strtolower(trim($this->email));
        $user->username = strtolower(trim($this->username));
        $user->type = UserType::from($this->type);
        $user->status = UserStatus::from($this->status);
        $user->password = Hash::make($this->password);
        $user->bio = $this->bio ? trim($this->bio) : null;
        $user->save();

        $this->dispatch('hideUserModal');
        $this->dispatch('showToast', [
            'type'    => 'success',
            'message' => 'User "' . $user->name . '" has been created successfully.'
        ]);
    }

    public function openEditModal($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);

        $this->isEditMode = true;
        $this->selectedUserId = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->type = $user->type->value ?? 'admin';
        $this->status = $user->status->value ?? 'active';
        $this->bio = $user->bio ?? '';
        $this->password = '';
        $this->password_confirmation = '';

        $this->dispatch('showUserModal');
    }

    public function updateUser()
    {
        if (!$this->selectedUserId) {
            return;
        }

        $user = User::findOrFail($this->selectedUserId);

        $rules = [
            'name'     => 'required|string|min:3|max:255',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'username' => ['required', 'string', 'min:3', 'max:100', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
            'type'     => ['required', Rule::in(['admin', 'superAdmin'])],
            'status'   => ['required', Rule::in(['active', 'inactive', 'pending', 'rejected'])],
            'bio'      => 'nullable|string|max:500',
        ];

        if (!empty($this->password)) {
            $rules['password'] = 'string|min:6|confirmed';
        }

        $this->validate($rules, [
            'name.required'      => 'Please enter the user\'s name.',
            'email.required'     => 'Email address is required.',
            'email.unique'       => 'This email address is already in use.',
            'username.required'  => 'Username is required.',
            'username.unique'    => 'This username is already taken.',
            'password.min'       => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Prevent current superAdmin from demoting or disabling self
        if ($user->id === Auth::id()) {
            if ($this->type !== 'superAdmin') {
                $this->addError('type', 'You cannot change your own Super Admin role.');
                return;
            }
            if ($this->status !== 'active') {
                $this->addError('status', 'You cannot deactivate your own logged-in account.');
                return;
            }
        }

        $user->name = trim($this->name);
        $user->email = strtolower(trim($this->email));
        $user->username = strtolower(trim($this->username));
        $user->type = UserType::from($this->type);
        $user->status = UserStatus::from($this->status);
        $user->bio = $this->bio ? trim($this->bio) : null;

        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $this->dispatch('hideUserModal');
        $this->dispatch('showToast', [
            'type'    => 'success',
            'message' => 'User "' . $user->name . '" has been updated successfully.'
        ]);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            $this->dispatch('showToast', [
                'type'    => 'error',
                'message' => 'You cannot change the status of your own account.'
            ]);
            return;
        }

        $currentStatus = $user->status->value ?? 'active';
        $newStatus = ($currentStatus === 'active') ? UserStatus::Inactive : UserStatus::Active;
        $user->status = $newStatus;
        $user->save();

        $this->dispatch('showToast', [
            'type'    => 'success',
            'message' => 'Status for ' . $user->name . ' changed to ' . ucfirst($newStatus->value) . '.'
        ]);
    }

    public function confirmDelete($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            $this->dispatch('showToast', [
                'type'    => 'error',
                'message' => 'You cannot delete your own account!'
            ]);
            return;
        }

        $this->userToDelete = $user->id;
        $this->dispatch('showDeleteModal');
    }

    public function deleteUser()
    {
        if (!$this->userToDelete) {
            return;
        }

        $user = User::findOrFail($this->userToDelete);

        if ($user->id === Auth::id()) {
            $this->dispatch('hideDeleteModal');
            $this->dispatch('showToast', [
                'type'    => 'error',
                'message' => 'You cannot delete your own account!'
            ]);
            return;
        }

        $userName = $user->name;

        // Reassign their posts to current superAdmin so articles are never orphaned or lost
        if ($user->posts()->count() > 0) {
            $user->posts()->update(['author_id' => Auth::id()]);
        }

        // Delete profile picture file if exists and not default
        if ($user->profile_image) {
            $imgPath = public_path('images/users/' . $user->profile_image);
            if (file_exists($imgPath)) {
                @unlink($imgPath);
            }
        }

        $user->delete();
        $this->userToDelete = null;

        $this->dispatch('hideDeleteModal');
        $this->dispatch('showToast', [
            'type'    => 'success',
            'message' => 'User "' . $userName . '" deleted. Any existing articles were safely reassigned to you.'
        ]);
    }

    public function render()
    {
        $query = User::withCount('posts');

        if (!empty($this->search)) {
            $search = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('username', 'like', $search)
                  ->orWhere('email', 'like', $search);
            });
        }

        if (!empty($this->filterType)) {
            $query->where('type', $this->filterType);
        }

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        $users = $query->latest()->paginate($this->perPage);

        // Stats summary for header cards
        $totalCount      = User::count();
        $superAdminCount = User::where('type', 'superAdmin')->count();
        $activeCount     = User::where('status', 'active')->count();
        $pendingCount    = User::whereIn('status', ['pending', 'inactive', 'rejected'])->count();

        return view('livewire.admin-users', [
            'users'           => $users,
            'totalCount'      => $totalCount,
            'superAdminCount' => $superAdminCount,
            'activeCount'     => $activeCount,
            'pendingCount'    => $pendingCount,
        ]);
    }
}
