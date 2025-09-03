<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('Admin.Users.index',['users'=>$users]);
    }

   public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Optional: prevent deleting the currently logged-in admin or yourself
            if (auth()->id() === $user->id) {
                return redirect()->back()->with('error', 'You cannot delete yourself.');
            }

            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            return redirect()->back()->with('error', 'Failed to delete user.');
        }
    }

    public function create()
        {
            return view('Admin.Users.create');
        }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required', 'string', 'min:8',
                'regex:/[a-z]/',       // Lowercase
                'regex:/[A-Z]/',       // Uppercase
                'regex:/[0-9]/',       // Number
                'regex:/[@$!%*#?&]/',  // Special char
                'confirmed'
            ],
            'phone' => 'required|string|regex:/^[0-9]{8,15}$/',
            'role' => 'required|in:0,1'
        ]);

        // Convert `role` to `is_admin`
        $validated['is_admin'] = $validated['role'];
        unset($validated['role']); // remove role key

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User account added successfully.');
    }

    public function edit($id)
    {
        $user=User::find($id);
        return view('Admin.Users.edit',['user'=>$user]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email,' . $id,
            'role'       => 'required|in:0,1',
            'phone'      => 'nullable|string|max:20',
            'password'   => 'nullable|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->is_admin   = $request->role;
        $user->phone      = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }


}
