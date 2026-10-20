<div>
    {{-- Custom Styles for Users Management --}}
    <style>
        .users-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .user-stat-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 18px 22px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s;
        }
        .user-stat-card:hover {
            transform: translateY(-2px);
        }
        .user-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .user-avatar-cell {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #E2E8F0;
            flex-shrink: 0;
        }
        .user-avatar-placeholder {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5B4BDB, #4F8DFF);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(91, 75, 219, 0.25);
        }
        .badge-super-admin {
            background: rgba(91, 75, 219, 0.12);
            color: #5B4BDB;
            border: 1px solid rgba(91, 75, 219, 0.25);
            font-weight: 700;
        }
        .badge-admin {
            background: rgba(59, 130, 246, 0.12);
            color: #2563EB;
            border: 1px solid rgba(59, 130, 246, 0.25);
            font-weight: 700;
        }
        .status-toggle-btn {
            cursor: pointer;
            border: none;
            background: none;
            padding: 0;
            transition: opacity 0.2s;
        }
        .status-toggle-btn:hover {
            opacity: 0.8;
        }
        .modal.fade .modal-dialog {
            transform: scale(0.9);
            opacity: 0;
            transition: all 0.25s ease-out !important;
        }
        .modal.show .modal-dialog {
            transform: scale(1);
            opacity: 1;
        }
    </style>

    {{-- Breadcrumb & Title --}}
    <div class="premium-page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Users &amp; Authors</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users &amp; Authors</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-md-right mt-3 mt-md-0">
                <a href="javascript:;" wire:click="openCreateModal" class="custom-action-btn add-btn m-0" style="padding: 10px 24px; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center;">
                    <i class="fa fa-user-plus mr-2"></i>Add New User
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Cards Row --}}
    <div class="users-stats-grid">
        <div class="user-stat-card">
            <div class="user-stat-icon" style="background: rgba(91, 75, 219, 0.1); color: #5B4BDB;">
                <i class="dw dw-user1"></i>
            </div>
            <div>
                <h3 class="mb-0 font-weight-bold" style="font-size: 1.6rem; color: #1E293B;">{{ $totalCount }}</h3>
                <span class="text-muted font-13 font-weight-500">Total Users</span>
            </div>
        </div>

        <div class="user-stat-card">
            <div class="user-stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                <i class="dw dw-checked"></i>
            </div>
            <div>
                <h3 class="mb-0 font-weight-bold" style="font-size: 1.6rem; color: #1E293B;">{{ $activeCount }}</h3>
                <span class="text-muted font-13 font-weight-500">Active Authors</span>
            </div>
        </div>

        <div class="user-stat-card">
            <div class="user-stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3B82F6;">
                <i class="dw dw-shield"></i>
            </div>
            <div>
                <h3 class="mb-0 font-weight-bold" style="font-size: 1.6rem; color: #1E293B;">{{ $superAdminCount }}</h3>
                <span class="text-muted font-13 font-weight-500">Super Admins</span>
            </div>
        </div>

        <div class="user-stat-card">
            <div class="user-stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                <i class="dw dw-time"></i>
            </div>
            <div>
                <h3 class="mb-0 font-weight-bold" style="font-size: 1.6rem; color: #1E293B;">{{ $pendingCount }}</h3>
                <span class="text-muted font-13 font-weight-500">Inactive / Pending</span>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="card-box pd-20 mb-30 shadow-sm border" style="border-radius: 14px;">
        {{-- Toolbar Filters --}}
        <div class="row align-items-center mb-3">
            <div class="col-lg-4 col-md-6 mb-2 mb-lg-0">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-right-0"><i class="fa fa-search text-muted"></i></span>
                    </div>
                    <input type="text" wire:model.live.debounce.400ms="search" class="form-control form-control-sm border-left-0" placeholder="Search by name, @username, or email...">
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-6 mb-2 mb-lg-0">
                <select wire:model.live="filterType" class="form-control form-control-sm custom-select">
                    <option value="">All Roles</option>
                    <option value="superAdmin">Super Admin</option>
                    <option value="admin">Admin / Author</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-3 col-6 mb-2 mb-lg-0">
                <select wire:model.live="filterStatus" class="form-control form-control-sm custom-select">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-12 text-lg-right">
                <select wire:model.live="perPage" class="form-control form-control-sm custom-select d-inline-block w-auto">
                    <option value="5">5 per page</option>
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                </select>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 32%;">User / Author</th>
                        <th style="width: 15%;">Role</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 13%;">Articles</th>
                        <th style="width: 13%;">Joined</th>
                        <th style="width: 12%; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        {{-- User & Avatar --}}
                        <td>
                            <div class="d-flex align-items-center">
                                @if($user->profile_image && file_exists(public_path('images/users/' . $user->profile_image)))
                                    <img src="{{ asset('images/users/' . $user->profile_image) }}" class="user-avatar-cell mr-3" alt="{{ $user->name }}">
                                @else
                                    <div class="user-avatar-placeholder mr-3">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="min-width-0">
                                    <h6 class="mb-0 font-weight-bold text-dark font-14">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="badge badge-pill badge-primary font-10 ml-1">You</span>
                                        @endif
                                    </h6>
                                    <span class="font-12 text-muted d-block text-truncate" style="max-width: 200px;">
                                        &#64;{{ $user->username }} &middot; {{ $user->email }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- Role --}}
                        <td>
                            @if(optional($user->type)->value === 'superAdmin')
                                <span class="badge badge-pill badge-super-admin px-3 py-1 font-12">
                                    <i class="fa fa-star mr-1"></i> Super Admin
                                </span>
                            @else
                                <span class="badge badge-pill badge-admin px-3 py-1 font-12">
                                    <i class="fa fa-user mr-1"></i> Admin
                                </span>
                            @endif
                        </td>

                        {{-- Status (Quick toggle) --}}
                        <td>
                            @php
                                $statusVal = optional($user->status)->value ?? 'active';
                            @endphp
                            <button type="button" wire:click="toggleStatus({{ $user->id }})" class="status-toggle-btn" title="Click to toggle status">
                                @if($statusVal === 'active')
                                    <span class="badge badge-pill badge-success px-2 py-1 font-11">
                                        <i class="fa fa-check-circle mr-1"></i> Active
                                    </span>
                                @elseif($statusVal === 'inactive')
                                    <span class="badge badge-pill badge-danger px-2 py-1 font-11">
                                        <i class="fa fa-ban mr-1"></i> Inactive
                                    </span>
                                @elseif($statusVal === 'pending')
                                    <span class="badge badge-pill badge-warning text-dark px-2 py-1 font-11">
                                        <i class="fa fa-clock-o mr-1"></i> Pending
                                    </span>
                                @else
                                    <span class="badge badge-pill badge-secondary px-2 py-1 font-11">
                                        {{ ucfirst($statusVal) }}
                                    </span>
                                @endif
                            </button>
                        </td>

                        {{-- Articles count --}}
                        <td>
                            <a href="{{ route('admin.posts.all-posts', ['author' => $user->id]) }}" class="badge badge-pill badge-light border text-primary font-12 font-weight-bold px-2 py-1" title="View all articles by this author">
                                <i class="fa fa-file-text-o mr-1"></i> {{ $user->posts_count }}
                            </a>
                        </td>

                        {{-- Joined Date --}}
                        <td class="text-muted font-13">
                            {{ optional($user->created_at)->format('d M, Y') ?? '—' }}
                        </td>

                        {{-- Actions --}}
                        <td class="text-right">
                            <div class="btn-group btn-group-sm">
                                <button type="button" wire:click="openEditModal({{ $user->id }})" class="btn btn-outline-primary btn-sm" title="Edit User">
                                    <i class="dw dw-edit2"></i>
                                </button>
                                @if($user->id !== auth()->id())
                                <button type="button" wire:click="confirmDelete({{ $user->id }})" class="btn btn-outline-danger btn-sm" title="Delete User">
                                    <i class="dw dw-delete-3"></i>
                                </button>
                                @else
                                <button type="button" class="btn btn-outline-secondary btn-sm disabled" disabled title="Cannot delete yourself">
                                    <i class="dw dw-delete-3"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="dw dw-user-11" style="font-size: 2.5rem; opacity: 0.3; display: block; margin-bottom: 12px;"></i>
                            <h5 class="text-muted">No users found</h5>
                            <p class="font-13">Try adjusting your search criteria or add a new user.</p>
                            <button type="button" wire:click="openCreateModal" class="btn btn-primary btn-sm mt-2 rounded-pill px-3">
                                <i class="fa fa-user-plus mr-1"></i> Add First User
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
            <span class="text-muted font-13 mb-2 mb-md-0">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
            </span>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>

    {{-- ========================================================
         ADD / EDIT USER MODAL
         ======================================================== --}}
    <div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #5B4BDB 0%, #4338CA 100%);">
                    <h5 class="modal-title text-white font-weight-bold" id="userModalLabel">
                        <i class="fa {{ $isEditMode ? 'fa-pencil-square-o' : 'fa-user-plus' }} mr-2"></i>
                        {{ $isEditMode ? 'Edit User / Author' : 'Create New User / Author' }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.85;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form wire:submit.prevent="{{ $isEditMode ? 'updateUser' : 'createUser' }}">
                    <div class="modal-body p-4">
                        <div class="row">
                            {{-- Full Name --}}
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold text-dark font-13">Full Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. John Doe">
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            {{-- Username --}}
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold text-dark font-13">Username (slug) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">&#64;</span>
                                    </div>
                                    <input type="text" wire:model="username" class="form-control @error('username') is-invalid @enderror" placeholder="johndoe">
                                </div>
                                @error('username') <span class="text-danger font-12 d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-12 form-group">
                                <label class="font-weight-bold text-dark font-13">Email Address <span class="text-danger">*</span></label>
                                <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" placeholder="john@example.com">
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            {{-- Role & Status --}}
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold text-dark font-13">Role / Permissions <span class="text-danger">*</span></label>
                                <select wire:model="type" class="form-control custom-select @error('type') is-invalid @enderror">
                                    <option value="admin">Admin / Author</option>
                                    <option value="superAdmin">Super Admin</option>
                                </select>
                                <small class="form-text text-muted">Super Admins can manage settings, categories, and other users.</small>
                                @error('type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold text-dark font-13">Account Status <span class="text-danger">*</span></label>
                                <select wire:model="status" class="form-control custom-select @error('status') is-invalid @enderror">
                                    <option value="active">Active (Can log in &amp; write)</option>
                                    <option value="inactive">Inactive (Suspended)</option>
                                    <option value="pending">Pending Approval</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold text-dark font-13">
                                    Password {!! $isEditMode ? '<small class="text-muted">(Leave empty to keep current)</small>' : '<span class="text-danger">*</span>' !!}
                                </label>
                                <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 6 characters">
                                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold text-dark font-13">
                                    Confirm Password {!! $isEditMode ? '' : '<span class="text-danger">*</span>' !!}
                                </label>
                                <input type="password" wire:model="password_confirmation" class="form-control" placeholder="Repeat password">
                            </div>

                            {{-- Bio --}}
                            <div class="col-md-12 form-group mb-0">
                                <label class="font-weight-bold text-dark font-13">Author Biography <small class="text-muted">(Displayed on author page)</small></label>
                                <textarea wire:model="bio" rows="3" class="form-control @error('bio') is-invalid @enderror" placeholder="Brief summary about the writer..."></textarea>
                                @error('bio') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="{{ $isEditMode ? 'updateUser' : 'createUser' }}">
                                <i class="fa fa-check mr-1"></i> {{ $isEditMode ? 'Update User' : 'Create User' }}
                            </span>
                            <span wire:loading wire:target="{{ $isEditMode ? 'updateUser' : 'createUser' }}">
                                <i class="fa fa-spinner fa-spin mr-1"></i> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ========================================================
         CONFIRM DELETE MODAL
         ======================================================== --}}
    <div wire:ignore.self class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg text-center p-4" style="border-radius: 16px;">
                <div class="mb-3">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: rgba(239, 68, 68, 0.1); color: #EF4444; font-size: 1.8rem;">
                        <i class="dw dw-delete-3"></i>
                    </div>
                </div>
                <h4 class="font-weight-bold mb-2">Delete User Account?</h4>
                <p class="text-muted font-14 mb-4">
                    Are you sure you want to delete this user?
                    <br>
                    <span class="text-info font-weight-bold">Note:</span> Any articles authored by this user will be safely transferred to your account so content is preserved.
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 mr-2" data-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="deleteUser" class="btn btn-danger rounded-pill px-4" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="deleteUser">
                            <i class="fa fa-trash mr-1"></i> Delete Account
                        </span>
                        <span wire:loading wire:target="deleteUser">
                            <i class="fa fa-spinner fa-spin mr-1"></i> Deleting...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.addEventListener('showUserModal', function(){
        $('#userModal').modal('show');
    });
    window.addEventListener('hideUserModal', function(){
        $('#userModal').modal('hide');
    });
    window.addEventListener('showDeleteModal', function(){
        $('#deleteUserModal').modal('show');
    });
    window.addEventListener('hideDeleteModal', function(){
        $('#deleteUserModal').modal('hide');
    });
</script>
@endpush
