@extends('layouts.adminmaster')

@section('content')
    
<div class="user-management-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-icon">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="header-text">
            <h2>User Management</h2>
            <p>Manage user roles and permissions for the inventory system</p>
        </div>
    </div>

    <!-- User Card 1: Admin User (Current User) -->
    <div class="user-card">
        <div class="user-info-section">
            <div class="user-avatar">
                <i class="fa-solid fa-user-gear"></i>
            </div>
            <div class="user-details">
                <h3>Admin User</h3>
                <p><i class="fa-regular fa-envelope"></i>ahmedtahirofficial@gmail.com</p>
            </div>
        </div>
        <div class="user-role-section">
            <p>Current Role: <span class="role-badge admin">admin</span></p>
            <span>Full access to all features including user management and analytics</span>
        </div>
        <div class="user-action-section">
            <span class="current-user-badge">Current User</span>
        </div>
    </div>

    <!-- User Card 2: Admin -->
    <div class="user-card">
        <div class="user-info-section">
            <div class="user-avatar">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="user-details">
                <h3>Create User</h3>
                <p><i class="fa-regular fa-envelope"></i>gil.uob@gmail.com</p>
            </div>
        </div>
        <div class="user-role-section">
            <p>Current Role: <span class="role-badge admin">Create your own User</span></p>
            <span>Full access to all features including user management and analytics</span>
        </div>
      <!-- This HTML is correct and does not need to be changed -->
            <div class="user-action-section">
           <a href="/Premission" class="btn-assign">Asign Role/Permission</a>
        </div>
    </div>

   
</div>
    </div>
    
</div>
@endsection