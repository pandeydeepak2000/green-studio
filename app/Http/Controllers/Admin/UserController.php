<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('company');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();

        return view('admin.users.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:6'],
            'role'       => ['required', 'in:admin,support,staff'],
            'company_id' => ['nullable', 'exists:companies,id'],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('status', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $companies = Company::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'companies'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', "unique:users,email,{$user->id}"],
            'password'   => ['nullable', 'string', 'min:6'],
            'role'       => ['required', 'in:admin,support,staff'],
            'company_id' => ['nullable', 'exists:companies,id'],
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('status', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('status', 'User deleted.');
    }

    public function approve(User $user)
    {
        $user->update(['is_approved' => true]);

        return redirect()->route('admin.users.index')
            ->with('status', "User '{$user->name}' has been approved successfully and can now log in.");
    }

    public function sendResetLink(User $user)
    {
        $status = \Illuminate\Support\Facades\Password::broker()->sendResetLink(['email' => $user->email]);

        if ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
            return redirect()->route('admin.users.index')
                ->with('status', "Password reset link has been sent to {$user->email}.");
        }

        return redirect()->route('admin.users.index')
            ->with('status', 'Password reset dispatch status: ' . __($status));
    }
}