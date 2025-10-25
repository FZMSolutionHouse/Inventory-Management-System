<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addUserController;
use App\Http\Controllers\additemController;
use App\Http\Controllers\addlocationproduceController;
use App\Http\Controllers\admininventoryController;
use App\Http\Controllers\adminmasterController;
use App\Http\Controllers\createpremissionController;
use App\Http\Controllers\createproductController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\recordController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DigitalSignController;
use App\Http\Controllers\editshowpremissionController;
use App\Http\Controllers\guestuserController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\PremissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecognitionPage;
use App\Http\Controllers\recordPremissionController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\showProductController;
use App\Http\Controllers\supervisorboardController;
use App\Http\Controllers\supervisorController;
use App\Http\Controllers\UsermanagementController;
use App\Http\Controllers\RolesIndexController;
use App\Http\Controllers\adminrequistionrecordController;
use App\Http\Controllers\intervalchartController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\piechartController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\tablechartController;
use App\Http\Controllers\vegachartController;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\LocationProductController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');



Route::get('/logout',[logoutController::class,'rollback'])->name('logout');
//View the admininventory Page

Route::get('/admininventory', [admininventoryController::class, 'adminpage'])->name('admininventory');

Route::post('/login', [addUserController::class, 'login']);
Route::get('/adminmaster', [addUserController::class, 'adminpage'])->name('adminmaster');

// Registration Routes 
Route::get('/registration', [addUserController::class, 'showForm'])->name('registration.form'); 
Route::post('/registration', [addUserController::class, 'add'])->name('add');

Route::post('/logout', [addUserController::class, 'logout'])->name('logout');

//additem Routes 
Route::get('/additem', [additemController::class, 'Showadd'])->name('additem'); 
Route::post('/additem', [additemController::class, 'item'])->name('additem');
//show Record.
Route::get('/records',[recordController::class,'Showrecord']);

//delete the record.
Route::get('delete_record/{id}',[recordController::class,'delete_record']);


//Edit Record - Display edit form
Route::get('edit_record/{id}',[recordController::class,'edit_record']);

//Update Record - Process the update (Fixed the route name)
Route::post('update_data/{id}',[recordController::class,'update_data'])->name('update_data');

//Admindashboard
Route::get('/admindashboard', [DashboardController::class, 'chart'])->name('admin.dashboard');
Route::get('/debug-items', function () {
    try {
        // Test database connection first
        DB::connection()->getPdo();
        
        // Check if table exists
        $tableExists = DB::getSchemaBuilder()->hasTable('additem');
        if (!$tableExists) {
            return response()->json([
                'success' => false,
                'error' => 'Table "additem" does not exist',
                'suggestion' => 'Check your table name in the database'
            ]);
        }
        
        // Get table columns
        $columns = DB::getSchemaBuilder()->getColumnListing('additem');
        
        // Fetch all data
        $items = DB::table('additem')->get();
        
        return response()->json([
            'success' => true,
            'table_exists' => $tableExists,
            'columns' => $columns,
            'total_rows' => $items->count(),
            'sample_data' => $items->take(3)->toArray(), // Show first 3 rows only
            'all_data' => $items->toArray() // All data
        ]);
        
    } catch (\PDOException $e) {
        return response()->json([
            'success' => false,
            'error' => 'Database connection failed',
            'message' => $e->getMessage(),
            'suggestion' => 'Check your .env file database credentials'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'General error',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
});




//tablechart// routes/web.php
Route::get('/tablechart', [tablechartController::class, 'chart'])->name('tablechart.view');
Route::get('/api/table-data', [tablechartController::class, 'getTableData'])->name('api.table.data');

//PieChart
Route::get('/piechart',[piechartController::class,'pie'])->name('piechart');
Route::get('/item-details/{itemName}', [App\Http\Controllers\piechartController::class, 'getItemDetails']);

// Interval chart route
Route::get('/intervalchart', [intervalchartController::class, 'interval']);
Route::get('/stock-analysis',[intervalchartController::class, 'getStockAnalysis']);


//vegachart
Route::get('/vegachart',[vegachartController::class,'vega'])->name('/vegachart');

//Adminmaster 
Route::get('/adminmaster',[adminmasterController::class,'showadminmaster'])->name('adminmaster');

//Supervisor
Route::get('/supervisormaster',[supervisorController::class,'superview'])->name('supervisormaster');

//Usermanagament
Route::get('/UserManagement',[UsermanagementController::class,'management'])->name('UserManagement');

// Digital Signature Routes
Route::get('/digitalSignature', [DigitalSignController::class, 'create']);
// Route to handle the form submission for creating a user and storing the signature.
Route::post('/confirm',[DigitalSignController::class, 'store']);
// Route to display the user's agreement details
Route::get('/digitalSignature/{id}', [DigitalSignController::class, 'show']);


//Supervisorboard
Route::get('/supervisorboard',[supervisorboardController::class,'showboard'])->name('supervisorboard');

//userguest
Route::get('/guestuser',[guestuserController::class,'showguest'])->name('guestuser');

//Premission 
Route::get('/Premission',[PremissionController::class, 'viewpremission'])->name('Premission'); 
Route::get('/Premission/{id}/edit',[editshowpremissionController::class, 'edpremission'])->name('EditPremission');
Route::put('/Premission/{id}',[editshowpremissionController::class, 'updatepremission'])->name('user.update');
Route::delete('/permission/{id}',[PremissionController::class, 'delete'])->name('permission.delete');
Route::get('/Premission/{id}',[recordPremissionController::class,'sshowrecord'])->name('Premssion.show');


// Simple Product (only name & detail)
Route::get('/product', [ProductController::class, 'viewproduct'])->name('products.index');
Route::post('/product', [createproductController::class, 'store'])->name('products.store');
Route::delete('/Product/{id}', [ProductController::class, 'delete'])->name('products.delete');
Route::get('/product/{id}', [showProductController::class,'sshowrecordpro'])->name('product.show');



//Create User
Route::get('createuser', [CreateUserController::class, 'usermanage'])->name('user.create');
Route::post('store-user', [CreateUserController::class, 'storeuser'])->name('user.store');


//Create premission
Route::get('/Createpremission',[createpremissionController::class,'preview'])->name('Createpremission');
// routes/web.php


// Role Management Routes
Route::get('/roles', [RolesIndexController::class, 'rolebase'])->name('role.index');
Route::get('/createrole', function () {
    return view('livewire.wrapper.create-role');
})->name('create.role');
Route::get('/showrole/{id}', [RolesIndexController::class, 'show'])->name('roles.show');
Route::get('/editrole/{id}', [RolesIndexController::class, 'edit'])->name('roles.edit');
Route::delete('/deleterole/{id}', [RolesIndexController::class, 'delete'])->name('roles.delete');
Route::post('/deleterole/{id}', [RolesIndexController::class, 'delete'])->name('roles.delete.post');




//Corrected Routes
Route::get('/createproduct', [createproductController::class, 'producview'])->name('createproduct');
Route::post('/store-product', [createproductController::class, 'storeproduct'])->name('product.store');

// Recognition.blade.php routes
Route::get('/Recognition', [RequisitionController::class, 'index'])->name('recognition.index');
Route::post('/Recognition/store', [RequisitionController::class, 'storeRecognition'])->name('recognition.store');

// uploadfile.blade.php routes  
Route::get('/uploadfile', [RequisitionController::class, 'showUploadForm'])->name('uploadfile.show');
Route::post('/uploadfile/create', [RequisitionController::class, 'storeUploadFile'])->name('uploadfile.create');



Route::get('/RecognitionPage',[RecognitionPage::class,'index'])->name('RecognitionPage');

//Download functionality 
Route::get('download-form', function(){
    $file = public_path('form/Requisation_form.pdf');
    return response()->download($file, 'Requisation_form.pdf', [
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0'
    ]);
})->name('Requistion_form');

Route::get('/submission/mysubmissions', [SubmissionController::class, 'mySubmissions'])->name('my.submissions');


Route::get('/send-mail',[MailController::class,'SendEmail']);



Route::middleware(['auth'])->group(function () {
    Route::get('/adminrequisitionrecord', [adminrequistionrecordController::class, 'recordshow'])->name('admin.requisitions.index');
    Route::post('/admin/requisitions/update-status', [adminrequistionrecordController::class, 'updateStatus'])->name('admin.requisitions.update-status');
    Route::post('/admin/requisitions/bulk-update-status', [adminrequistionrecordController::class, 'bulkUpdateStatus'])->name('admin.requisitions.bulk-update-status');
});

// SMS Testing 

Route::get('/sms/test', [SmsController::class, 'testSms']);

// SMS Sending Routes  
Route::post('/sms/welcome-user', [SmsController::class, 'sendWelcomeSmsToUser']);
Route::post('/sms/send-to-number', [SmsController::class, 'sendSmsToNumber']);
Route::post('/sms/bulk-send', [SmsController::class, 'sendBulkSms']);

// SMS History & Analytics Routes
Route::get('/sms/history', [SmsController::class, 'getSmsHistory']);
Route::get('/sms/stats', [SmsController::class, 'getSmsStats']);

// API Routes Group (if using API)
Route::prefix('api/v1/sms')->group(function () {
    Route::get('/test', [SmsController::class, 'testSms']);
    Route::post('/welcome-user', [SmsController::class, 'sendWelcomeSmsToUser']);
    Route::post('/send-to-number', [SmsController::class, 'sendSmsToNumber']);
    Route::post('/bulk-send', [SmsController::class, 'sendBulkSms']);
    Route::get('/history', [SmsController::class, 'getSmsHistory']);
    Route::get('/stats', [SmsController::class, 'getSmsStats']);
});



// Settings routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    
    // Main settings page
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    
    // Profile update route (for user_profile table)
    Route::put('/profile/update', [SettingController::class, 'updateProfile'])->name('profile.update');
    // Separate profile page (if needed)
    Route::get('/profile', [SettingController::class, 'showProfile'])->name('profile');
    
    // Fixed typo in your original route - redirect to settings
    Route::get('/proflie', function() {
        return redirect()->route('settings');
    });
});
// Debug route - remove after fixing the issue
Route::get('/debug-user-data', [App\Http\Controllers\DebugController::class, 'checkUserData']);

// Add to web.php
Route::get('/test-image', function() {
    $userProfile = DB::table('userprofile')->where('user_id', 1)->first();
    if ($userProfile && $userProfile->image) {
        $imagePath = public_path('storage/' . $userProfile->image);
        $imageUrl = asset('storage/' . $userProfile->image);
        
        return response()->json([
            'image_from_db' => $userProfile->image,
            'full_path' => $imagePath,
            'url' => $imageUrl,
            'file_exists' => file_exists($imagePath),
        ]);
    }
    return 'No image found';
});


Route::put('/profile/update', [SettingController::class, 'updateProfile'])->name('profile.update');
Route::get('/setting', [SettingController::class, 'index'])->name('setting');


// Balance Sheet Routes
Route::get('/balance-sheet', [BalanceSheetController::class, 'index'])->name('balance-sheet.index');
Route::put('/balance-sheet/update', [BalanceSheetController::class, 'update'])->name('balance-sheet.update');



// Notification routes
Route::get('/notifications', [RequisitionController::class, 'getNotifications']);
Route::post('/notifications/mark-read', [RequisitionController::class, 'markAsRead']);
Route::post('/notifications/clear', [RequisitionController::class, 'clearNotifications']);



// Settings page
Route::middleware(['auth'])->group(function () {
    
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings');
    
    // Send email functionality
    Route::post('/send-email', [App\Http\Controllers\SettingController::class, 'sendEmail'])->name('send.email');
    
    // Profile update
    Route::put('/profile/update', [App\Http\Controllers\SettingController::class, 'updateProfile'])->name('profile.update');
    
// 2FA Toggle Route
    Route::post('/settings/twofa/toggle', [SettingController::class, 'toggleTwoFactor'])->name('twofa.toggle');
});


// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Verification Routes
Route::get('/verify', [VerificationController::class, 'show'])->name('verification.show');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/verify/resend', [VerificationController::class, 'resend'])->name('verification.resend');


// In web.php
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware('auth');

    // In routes/web.php
Route::post('/settings/toggle-2fa', [SettingController::class, 'toggleTwoFactor'])->name('settings.toggle2fa');

Route::get('/check-session', [LoginController::class, 'checkSession'])->name('check.session');


// Location Product (with latitude & longitude)
Route::get('/loactionproduct', [LocationProductController::class, 'local'])->name('loactionproduct');
Route::post('/addlocationproduct', [LocationProductController::class, 'store'])->name('locationproduct.store'); // CHANGE THIS NAME