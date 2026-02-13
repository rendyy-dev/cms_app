@extends('layouts.super_admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-emerald-400">Dashboard Super Admin</h1>

<!-- INFO CARDS -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white/5 border border-white/10 rounded-xl p-6 flex flex-col justify-between hover:bg-white/10 transition">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-gray-400 text-sm">Total Users (Termasuk Super Admin)</h2>
                <p class="text-2xl font-bold mt-2">{{ $totalUsers ?? 0 }}</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h5"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 12a5 5 0 100-10 5 5 0 000 10z"/>
            </svg>
        </div>
        <a href="{{ route('super_admin.users') }}"
           class="mt-4 text-sm text-emerald-400 hover:underline">Lihat Semua Users</a>
    </div>

    <!-- Total Roles -->
    <div class="bg-white/5 border border-white/10 rounded-xl p-6 flex flex-col justify-between hover:bg-white/10 transition">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-gray-400 text-sm">Total Roles</h2>
                <p class="text-2xl font-bold mt-2">{{ $totalRoles ?? 0 }}</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-5H3v5a2 2 0 002 2z"/>
            </svg>
        </div>
        <a href="{{ route('super_admin.roles.index') }}"
           class="mt-4 text-sm text-emerald-400 hover:underline">Lihat Semua Roles</a>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white/5 border border-white/10 rounded-xl p-6 flex flex-col justify-between hover:bg-white/10 transition">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-gray-400 text-sm">Quick Actions</h2>
                <ul class="mt-2 text-sm space-y-1">
                    <li><a href="{{ route('super_admin.users') }}" class="text-emerald-400 hover:underline">Manage Users</a></li>
                    <li><a href="{{ route('super_admin.roles.index') }}" class="text-emerald-400 hover:underline">Manage Roles</a></li>
                    <li><a href="{{ route('super_admin.settings') }}" class="text-emerald-400 hover:underline">Settings</a></li>
                </ul>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7"/>
            </svg>
        </div>
    </div>
</div>

<!-- RECENT USERS TABLE -->
<div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/10 transition">
    <h2 class="text-xl font-semibold mb-4 text-emerald-400">Recent Users</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-white/10">
            <thead>
            <tr class="text-left text-gray-400 text-sm uppercase">
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Role</th>
                <th class="px-4 py-2">Created At</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-white/10 text-gray-100">
            @forelse ($recentUsers ?? [] as $user)
                <tr>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ $user->role->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-2 text-gray-400 text-center">Belum ada user.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
