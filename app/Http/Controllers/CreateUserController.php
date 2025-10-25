<?php

namespace App\Http\Controllers;

use App\Http\Requests\createuserRequest;
use App\Models\createuser;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class CreateUserController extends Controller
{
    /**
     * Display the user creation form and pass roles to it.
     */
    public function usermanage()
    {
        // This correctly fetches all roles.
        $roles = Role::orderBy('name')->get();
        return view('createuser', ['roles' => $roles]);
    }

    /**
     * Store a newly created user in the database.
     *
     * @param  \App\Http\Requests\createuserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeuser(createuserRequest $request)
    {
        // Validation is handled by createuserRequest.
        $validatedData = $request->validated();

        // Step 1: Create the user and store the new user object in a variable.
        $user = createuser::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);

        // Step 2: Get the roles from the request and assign them to the new user.
        if ($request->has('roles')) {
            $user->syncRoles($request->input('roles'));
        }

        // Step 3: Send welcome email to the newly created user
        try {
            $emailSubject = "Welcome to GIL Quetta - Account Created";
            
            Mail::to($user->email)->send(new WelcomeEmail($user, $emailSubject));
            
            // Success message with email confirmation
            return redirect()->back()->with('success', 'User created successfully and welcome email sent to ' . $user->email . '!');
            
        } catch (\Exception $e) {
            // If email fails, still show success for user creation but mention email issue
            return redirect()->back()->with('success', 'User created successfully, but email could not be sent. Please check email configuration.');
        }
    }
}