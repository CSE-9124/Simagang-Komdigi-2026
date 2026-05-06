@extends('layouts.app')

@section('title', 'Kelola Akun Admin - Sistem Manajemen Magang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-4xl font-bold leading-tight bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2 pb-2">
                    Kelola Akun Admin
                </h1>
                <p class="mt-2 text-gray-600">Atur super admin dan admin lain sesuai akses yang dibutuhkan.</p>
            </div>

            <a href="{{ route('admin.accounts.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-plus"></i>
                <span>Tambah Admin</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-blue-100 overflow-hidden mb-6">
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-white text-xl font-bold flex items-center">
                    <i class="fas fa-user-shield mr-3"></i>
                    Daftar Akun Admin
                </h2>
            </div>

            <div class="p-6">
                <form method="GET" action="{{ route('admin.accounts.index') }}" class="mb-6 flex flex-col sm:flex-row gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full sm:max-w-md px-4 py-3 border border-blue-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-xl">
                        <i class="fas fa-search"></i>
                        <span>Cari</span>
                    </button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-blue-50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($accounts as $account)
                                @php
                                    $roleName = $account->getRoleNames()->first() ?? $account->role ?? '-';
                                    $roleBadgeMap = [
                                        'super_admin' => ['label' => 'super admin', 'classes' => 'bg-red-100 text-red-800'],
                                        'admin_full' => ['label' => 'admin full', 'classes' => 'bg-blue-100 text-blue-800'],
                                        'admin_user_manager' => ['label' => 'admin user manager', 'classes' => 'bg-green-100 text-green-800'],
                                        'admin_data_manager' => ['label' => 'admin data manager', 'classes' => 'bg-yellow-100 text-yellow-800'],
                                    ];
                                    $roleBadge = $roleBadgeMap[$roleName] ?? ['label' => str_replace('_', ' ', $roleName), 'classes' => 'bg-gray-100 text-gray-800'];
                                @endphp
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $account->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $account->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $roleBadge['classes'] }}">
                                            {{ $roleBadge['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('admin.accounts.edit', $account) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if (!$account->isSuperAdmin())
                                            <form action="{{ route('admin.accounts.destroy', $account) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun admin ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">Tidak bisa dihapus</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        Belum ada akun admin.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $accounts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection