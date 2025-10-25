@extends('layouts.adminmaster')
@section('content')
<div class="settings-wrapper">
    <div class="settings-header">
        <h1>Settings</h1>
        <p>Manage your account preferences and configurations</p>
    </div>

<div class="settings-container">
    <nav class="settings-sidebar">
        <a href="#" class="settings-nav-item active" data-page="profile">
            <div class="settings-nav-header">
                <svg class="settings-nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                <span>Profile</span>
            </div>
            <div class="settings-nav-desc">
                Manage your personal information and contact details.
            </div>
        </a>
        
        <a href="#" class="settings-nav-item" data-page="mail">
            <div class="settings-nav-header">
                <svg class="settings-nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                </svg>
                <span>Send E-Mail</span>
            </div>
            <div class="settings-nav-desc">
                Send emails to employees and manage templates.
            </div>
        </a>
        
        <a href="#" class="settings-nav-item" data-page="2fa">
            <div class="settings-nav-header">
                <svg class="settings-nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1Z"/>
                </svg>
                <span>2 Step Verification</span>
            </div>
            <div class="settings-nav-desc">
                Manage security feature.
            </div>
        </a>
    </nav>
    
    <div class="settings-content">
        <!-- Profile Section -->
        <div id="profile-section" class="content-section active">
            <div class="profile-wrapper">
                <div class="profile-title">
                    <h2>User Profile</h2>
                    <p>Manage your profile information and settings</p>
                </div>
                
                <form id="settingsProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="profile-image-wrapper">
                        <div class="profile-avatar" id="settingsProfileImage">
                            @if($userProfile && $userProfile->image)
                                <img src="{{ asset('storage/' . $userProfile->image) }}" alt="Profile Image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <span style="display: none;">{{ substr($userProfile->name ?? auth()->user()->name ?? 'U', 0, 1) }}</span>
                            @else
                                <span>{{ substr($userProfile->name ?? auth()->user()->name ?? 'U', 0, 1) }}</span>
                            @endif
                            <div class="profile-camera" onclick="document.getElementById('settingsImageInput').click()">
                                <svg viewBox="0 0 24 24">
                                    <path d="M9 2l1.55 2H15l1.55-2H20a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h5zm3 15.5A6.5 6.5 0 1 0 12 4a6.5 6.5 0 0 0 0 13zm0-2A4.5 4.5 0 1 1 12 6.5a4.5 4.5 0 0 1 0 9z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="file" id="settingsImageInput" name="profile_image" class="profile-file-input" accept="image/*">
                    </div>
                    
                    <div class="profile-form-group">
                        <label for="settings_name" class="profile-label">Name</label>
                        <input type="text" id="settings_name" name="name" class="profile-input" 
                               placeholder="Enter your name" 
                               value="{{ old('name', $userProfile->name ?? auth()->user()->name ?? '') }}" required>
                        @error('name')
                            <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="profile-form-group">
                        <label for="settings_email" class="profile-label">Email</label>
                        <input type="email" id="settings_email" name="email" class="profile-input" 
                               placeholder="Enter your email" 
                               value="{{ old('email', $userProfile->email ?? auth()->user()->email ?? '') }}" required>
                        @error('email')
                            <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="profile-form-group">
                        <label for="settings_phone" class="profile-label">Phone Number</label>
                        <input type="tel" id="settings_phone" name="phonenumber" class="profile-input" 
                               placeholder="Enter your phone number" 
                               value="{{ old('phonenumber', $userProfile->phonenumber ?? '') }}" required>
                        @error('phonenumber')
                            <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="profile-form-group">
                        <label for="settings_role" class="profile-label">Role</label>
                        <input type="text" id="settings_role" name="role" class="profile-input" 
                               placeholder="Enter your Role" 
                               value="{{ old('role', $userProfile->role ?? '') }}" required>
                        @error('role')
                            <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="profile-save-btn">
                        <svg viewBox="0 0 24 24">
                            <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                        </svg>
                        Save Changes
                    </button>
                </form>
            </div>
        </div>

        <!-- Email Section -->
        <div id="mail-section" class="content-section">
            <div class="email-composer-wrapper">
                <div class="email-composer-header">
                    <h2>Send Email to Employees</h2>
                    <p>Send emails directly to your team members</p>
                </div>
                
                <form id="emailForm" method="POST" action="{{ route('send.email') }}">
                    @csrf
                    
                    <div class="email-form-group">
                        <label class="email-label">Recipients:</label>
                        <div class="recipients-container" id="recipientsContainer">
                            <div class="recipients-input-wrapper">
                                <input type="text" id="recipientSearch" class="recipients-input" 
                                       placeholder="Type email address and press Enter, or search employees by name...">
                                <small style="color: #6b7280; font-size: 12px;">Tip: You can type any email address and press Enter to add it</small>
                                <div class="recipients-dropdown" id="recipientsDropdown"></div>
                            </div>
                            <div class="selected-recipients" id="selectedRecipients"></div>
                        </div>
                        <input type="hidden" name="recipients" id="hiddenRecipients" required>
                        @error('recipients')
                            <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="email-form-group">
                        <label for="email_subject" class="email-label">Subject:</label>
                        <input type="text" id="email_subject" name="subject" class="email-input" 
                               placeholder="Enter email subject" required value="{{ old('subject') }}">
                        @error('subject')
                            <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="email-form-group">
                        <label class="email-label">Quick Templates:</label>
                        <div class="email-templates">
                            <button type="button" class="template-btn" data-template="meeting">Meeting Invitation</button>
                            <button type="button" class="template-btn" data-template="announcement">Announcement</button>
                            <button type="button" class="template-btn" data-template="reminder">Reminder</button>
                        </div>
                    </div>
                    
                    <div class="email-form-group">
                        <label for="email_content" class="email-label">Message:</label>
                        <textarea name="content" id="emailContent" class="email-textarea" 
                                  placeholder="Write your message here..." required rows="8">{{ old('content') }}</textarea>
                        @error('content')
                            <span class="text-danger" style="font-size: 12px; color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="email-actions">
                        <button type="submit" class="btn-primary" id="sendEmailBtn">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
                                <path d="M2,21L23,12L2,3V10L17,12L2,14V21Z"/>
                            </svg>
                            Send Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
<!-- Two-Step Verification Section -->
<div id="2fa-section" class="content-section">
    <div class="verification-wrapper-main">
        <div class="verification-card-container">
            <!-- Header -->
            <div class="verification-card-header">
                <div class="verification-icon-box">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1Z"/>
                    </svg>
                </div>
                <h2>Two-Step Verification</h2>
            </div>

            <!-- Main Content -->
            <div class="verification-card-body">
                <p class="verification-intro-text">
                    Add an extra layer of security by requiring a verification code from your email
                </p>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="verification-notification verification-notification-success" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="verification-notification-dismiss" onclick="this.parentElement.remove()">×</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="verification-notification verification-notification-error" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="verification-notification-dismiss" onclick="this.parentElement.remove()">×</button>
                    </div>
                @endif

                <!-- Toggle Section -->
                <div class="verification-toggle-box">
                    <div class="verification-toggle-inner">
                        <div class="verification-toggle-info">
                            <h3>Enable Two-Step Verification</h3>
                            <p>When enabled, you'll need both your password and a verification code to sign in</p>
                        </div>
                        
                        <label class="verification-switch-label">
                            <input 
                                type="checkbox" 
                                id="verification-input-checkbox"
                                {{ Auth::user()->two_factor_enabled ? 'checked' : '' }}
                                onchange="handleVerificationToggle(this)"
                            >
                            <span class="verification-switch-slider"></span>
                        </label>
                        
                        <form action="{{ route('settings.toggle2fa') }}" method="POST" id="verification-form-toggle" style="display: none;">
                            @csrf
                            <input type="hidden" name="enable_2fa" id="verification-input-hidden" value="{{ Auth::user()->two_factor_enabled ? '0' : '1' }}">
                        </form>
                    </div>
                </div>

                <!-- Status Alert -->
                @if(!Auth::user()->two_factor_enabled)
                    <div class="verification-status-box verification-status-warning">
                        <div class="verification-status-icon-wrapper">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2L1 21h22L12 2zm0 3.5L19.5 19h-15L12 5.5zM11 10v4h2v-4h-2zm0 6v2h2v-2h-2z"/>
                            </svg>
                        </div>
                        <div class="verification-status-message">
                            Your account is not protected by two-step verification. Enable it now to enhance your security.
                        </div>
                    </div>
                @else
                    <div class="verification-status-box verification-status-success">
                        <div class="verification-status-icon-wrapper">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <div class="verification-status-message">
                            <strong>Active:</strong> Two-step verification is currently enabled. You will receive a verification code via email when signing in.
                        </div>
                    </div>
                @endif

                <!-- Security Tips -->
                <div class="verification-tips-container">
                    <h4>
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        Security Tips
                    </h4>
                    <ul>
                        <li>Keep your email account secure with a strong password</li>
                        <li>Never share your verification codes with anyone</li>
                        <li>Verification codes expire after 10 minutes for security</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/javascript/setting.js"></script>
@endsection