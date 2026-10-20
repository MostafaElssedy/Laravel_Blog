<div class="w-100 d-flex flex-column flex-grow-1">
    <div class="pd-20 card-box premium-card w-100 flex-grow-1">
        <div class="premium-content">
            
            <div class="text-center">
                <div class="profile-photo mx-auto" wire:ignore>
                    <a href="javascript:;" onclick="event.preventDefault();document.getElementById('profile_picture').click();" class="edit-avatar">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <input type="file" name="profile_picture" id="profile_picture" class="d-none">
                    <img src="{{ $admin->picture }}" alt="" class="avatar-photo profile-picture" id="admin_profile_picture">
                </div>
                <h5 class="admin-profile-name" id="admin_profile_name">{{ $admin->name }}</h5>
                <p class="admin-profile-email" id="admin_profile_email"><i class="fa fa-envelope-o" style="margin-right: 5px;"></i>{{ $admin->email }}</p>
                <p class="admin-profile-username" id="admin_profile_username">{{ '@' . $admin->username }}</p>
            </div>
            
            
            <div class="profile-info">
                <h5 class="premium-section-title">
                    <i class="fa fa-share-alt" aria-hidden="true"></i> Social Links
                </h5>
                <div class="social-links-container">
                    <a href="{{ optional($admin->socialLinks)->facebook ?? 'javascript:;' }}" 
                       {!! optional($admin->socialLinks)->facebook ? 'target="_blank"' : 'onclick="ijabo.showToast(\'No social link added yet.\', \'info\');"' !!}
                       class="social-link facebook">
                        <i class="fa fa-facebook"></i>
                    </a>
                       
                    <a href="{{ optional($admin->socialLinks)->x ?? 'javascript:;' }}" 
                       {!! optional($admin->socialLinks)->x ? 'target="_blank"' : 'onclick="ijabo.showToast(\'No social link added yet.\', \'info\');"' !!}
                       class="social-link x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                            <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/>
                        </svg>
                    </a>
                    
                    <a href="{{ optional($admin->socialLinks)->linkedin ?? 'javascript:;' }}" 
                       {!! optional($admin->socialLinks)->linkedin ? 'target="_blank"' : 'onclick="ijabo.showToast(\'No social link added yet.\', \'info\');"' !!}
                       class="social-link linkedin">
                        <i class="fa fa-linkedin"></i>
                    </a>
                       
                    <a href="{{ optional($admin->socialLinks)->instagram ?? 'javascript:;' }}" 
                       {!! optional($admin->socialLinks)->instagram ? 'target="_blank"' : 'onclick="ijabo.showToast(\'No social link added yet.\', \'info\');"' !!}
                       class="social-link instagram">
                        <i class="fa fa-instagram"></i>
                    </a>
                       
                    <a href="{{ optional($admin->socialLinks)->github ?? 'javascript:;' }}" 
                       {!! optional($admin->socialLinks)->github ? 'target="_blank"' : 'onclick="ijabo.showToast(\'No social link added yet.\', \'info\');"' !!}
                       class="social-link github">
                        <i class="fa fa-github"></i>
                    </a>
                       
                    <a href="{{ optional($admin->socialLinks)->whatsapp ?? 'javascript:;' }}" 
                       {!! optional($admin->socialLinks)->whatsapp ? 'target="_blank"' : 'onclick="ijabo.showToast(\'No social link added yet.\', \'info\');"' !!}
                       class="social-link whatsapp">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                       
                    <a href="{{ optional($admin->socialLinks)->youtube ?? 'javascript:;' }}" 
                       {!! optional($admin->socialLinks)->youtube ? 'target="_blank"' : 'onclick="ijabo.showToast(\'No social link added yet.\', \'info\');"' !!}
                       class="social-link youtube">
                        <i class="fa fa-youtube-play"></i>
                    </a>
                </div>
            </div>
            
            
            <div class="profile-info">
                <h5 class="premium-section-title">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i> About Me
                </h5>
                <div class="premium-bio">
                    <span id="admin_profile_bio">
                        {!! $admin->bio ? nl2br(e($admin->bio)) : '<span class="text-muted font-italic">No bio added yet. Tell us something about yourself!</span>' !!}
                    </span>
                </div>
            </div>
            
        </div>
    </div>
</div>
