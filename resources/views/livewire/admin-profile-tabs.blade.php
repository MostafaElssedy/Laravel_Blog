<div class="w-100 d-flex flex-column flex-grow-1">

    <div class="profile-tab w-100 d-flex flex-column flex-grow-1">
        <div class="tab premium-tabs-card w-100 flex-grow-1">
            <ul class="nav premium-nav-tabs" role="tablist">
                <li class="nav-item flex-fill">
                    <a wire:click.prevent="selectTab('personal_details')" class="nav-link {{ $tab == 'personal_details' ? 'active' : '' }}" data-toggle="tab" href="#personal_details" role="tab">Personal Details</a>
                </li>
                <li class="nav-item flex-fill">
                    <a wire:click.prevent="selectTab('update_password')" class="nav-link {{ $tab == 'update_password' ? 'active' : '' }}" data-toggle="tab" href="#update_password" role="tab">Update Password</a>
                </li>
                <li class="nav-item flex-fill">
                    <a wire:click.prevent="selectTab('social_links')" class="nav-link {{ $tab == 'social_links' ? 'active' : '' }}" data-toggle="tab" href="#social_links" role="tab">Social Links</a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Personal Details Tab start -->
                <div class="tab-pane fade {{ $tab == 'personal_details' ? 'show active' : '' }}" id="personal_details" role="tabpanel">
                    <div class="pt-2">
                        <form wire:submit.prevent="updateProfileInfo">
                            <div class="flex-row-gap">
                                <div class="flex-col-half">
                                    <div class="premium-form-group">
                                        <label>Name</label>
                                        <input type="text" class="premium-form-control" wire:model="name" placeholder="Enter your full name">
                                        @error('name')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col-half">
                                    <div class="premium-form-group">
                                        <label>Username</label>
                                        <input type="text" class="premium-form-control" wire:model="username" placeholder="Choose a username">
                                        @error('username')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col-full">
                                    <div class="premium-form-group">
                                        <label>Email Address</label>
                                        <input type="text" class="premium-form-control" wire:model="email" placeholder="Enter email address">
                                        @error('email')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col-full">
                                    <div class="premium-form-group">
                                        <label>Biography</label>
                                        <textarea wire:model="bio" class="premium-form-control" cols="30" rows="6" placeholder="Tell us something about yourself"></textarea>
                                        @error('bio')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="premium-form-group mt-3 mb-0 text-right">
                                <button type="submit" class="premium-btn" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="updateProfileInfo">Save Changes</span>
                                    <span wire:loading wire:target="updateProfileInfo">
                                        <i class="fa fa-spinner fa-spin"></i> Saving...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Personal Details Tab End -->
                
                <!-- Update Password Tab start -->
                <div class="tab-pane fade {{ $tab == 'update_password' ? 'show active' : '' }}" id="update_password" role="tabpanel">
                    <div class="pt-2">
                        <form wire:submit.prevent="changePassword">
                            <div class="flex-row-gap">
                                <div class="flex-col-full">
                                    <div class="premium-form-group">
                                        <label>Current Password</label>
                                        <input type="password" class="premium-form-control" wire:model="current_password" placeholder="Enter current password">
                                        @error('current_password')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col-full">
                                    <div class="premium-form-group">
                                        <label>New Password</label>
                                        <input type="password" class="premium-form-control" wire:model="new_password" placeholder="Enter new password">
                                        @error('new_password')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col-full">
                                    <div class="premium-form-group">
                                        <label>Confirm New Password</label>
                                        <input type="password" class="premium-form-control" wire:model="new_password_confirmation" placeholder="Confirm new password">
                                        @error('new_password_confirmation')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="premium-form-group mt-3 mb-0 text-right">
                                <button type="submit" class="premium-btn" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="changePassword">Update Password</span>
                                    <span wire:loading wire:target="changePassword">
                                        <i class="fa fa-spinner fa-spin"></i> Updating...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Update Password Tab End -->
                
                <!-- Social Links Tab start -->
                <div class="tab-pane fade {{ $tab == 'social_links' ? 'show active' : '' }}" id="social_links" role="tabpanel">
                    <div class="pt-2">
                        <form wire:submit.prevent="updateSocialLinks">
                            <div class="flex-row-gap">
                                <div class="flex-col-half">
                                    <div class="premium-form-group">
                                        <label>Facebook</label>
                                        <input type="text" class="premium-form-control" wire:model="facebook" placeholder="https://facebook.com/username">
                                    </div>
                                </div>
                                <div class="flex-col-half">
                                    <div class="premium-form-group">
                                        <label>X</label>
                                        <input type="text" class="premium-form-control" wire:model="x" placeholder="https://x.com/username">
                                    </div>
                                </div>
                                <div class="flex-col-half">
                                    <div class="premium-form-group">
                                        <label>LinkedIn</label>
                                        <input type="text" class="premium-form-control" wire:model="linkedin" placeholder="https://linkedin.com/in/username">
                                    </div>
                                </div>
                                <div class="flex-col-half">
                                    <div class="premium-form-group">
                                        <label>Instagram</label>
                                        <input type="text" class="premium-form-control" wire:model="instagram" placeholder="https://instagram.com/username">
                                    </div>
                                </div>
                                <div class="flex-col-half">
                                    <div class="premium-form-group">
                                        <label>GitHub</label>
                                        <input type="text" class="premium-form-control" wire:model="github" placeholder="https://github.com/username">
                                    </div>
                                </div>
                                <div class="flex-col-half">
                                    <div class="premium-form-group">
                                        <label>WhatsApp</label>
                                        <input type="text" class="premium-form-control" wire:model="whatsapp" placeholder="https://wa.me/number">
                                    </div>
                                </div>
                                <div class="flex-col-half">
                                    <div class="premium-form-group">
                                        <label>YouTube</label>
                                        <input type="text" class="premium-form-control" wire:model="youtube" placeholder="https://youtube.com/@channel">
                                    </div>
                                </div>
                            </div>
                            <div class="premium-form-group mt-3 mb-0 text-right">
                                <button type="submit" class="premium-btn" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="updateSocialLinks">Save Social Links</span>
                                    <span wire:loading wire:target="updateSocialLinks">
                                        <i class="fa fa-spinner fa-spin"></i> Saving...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Social Links Tab End -->
            </div>
        </div>
    </div>
</div>
