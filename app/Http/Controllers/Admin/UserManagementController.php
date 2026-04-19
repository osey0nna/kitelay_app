<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserManagementController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'user' => new User(),
            'roles' => User::roles(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::query()->create($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Akun {$user->name} berhasil dibuat.");
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => User::roles(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $payload = $request->safe()->except('password', 'password_confirmation');

        if (filled($request->validated('password'))) {
            $payload['password'] = $request->validated('password');
        }

        $user->update($payload);

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Akun {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('status', 'Akun admin yang sedang dipakai login tidak bisa dihapus.');
        }

        $userName = $user->name;
        $user->deleteWithRelations();

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Akun {$userName} berhasil dihapus.");
    }
}
