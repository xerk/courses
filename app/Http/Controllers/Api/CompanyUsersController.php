<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class CompanyUsersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Company $company)
    {
        $this->authorize('view', $company);

        $search = $request->get('search', '');

        $users = $company
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'name_ar' => ['nullable', 'max:255', 'string'],
            'avatar' => ['nullable', 'file'],
            'email' => ['required', 'unique:users,email', 'email'],
            'private_email' => ['nullable', 'max:255', 'string'],
            'password' => ['required'],
            'phone' => ['nullable', 'max:255', 'string'],
            'phone2' => ['nullable', 'max:255', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
            'inside_address' => ['nullable', 'max:255', 'string'],
            'type' => ['nullable', 'in:trainer,employee,admin'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'city' => ['nullable', 'max:255', 'string'],
            'country' => ['nullable', 'max:255', 'string'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public');
        }

        $user = $company->users()->create($validated);

        $user->syncRoles($request->roles);

        return new UserResource($user);
    }
}
