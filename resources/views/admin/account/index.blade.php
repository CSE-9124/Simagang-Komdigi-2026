@extends('layouts.app')

@section('title', 'Kelola Akun Admin - Sistem Manajemen Magang')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .dash-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8eeff 0%, #f0f4ff 40%, #e4ecff 100%);
        }

        .hero-strip {
            background: linear-gradient(100deg, #1e3a8a 0%, #3b4fd8 50%, #4f46e5 100%);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(20, 40, 120, 0.16);
            color: #fff;
        }

        .panel {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(30, 58, 138, 0.06), 0 4px 20px rgba(30, 58, 138, 0.06);
            overflow: hidden;
        }

        .input-main {
            width: 100%;
            padding: 0.6rem 0.9rem;
            border: 1px solid #d1d5db;
            border-radius: 0.6rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            transition: all .15s ease;
        }

        .input-main:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .action-mobile {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        @media (max-width:768px) {
            .hero-title {
                font-size: 1.6rem;
            }

            .action-mobile {
                width: 100%;
                justify-content: center;
            }

            .table-responsive {
                overflow: auto;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dash-bg py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <div class="hero-strip px-6 py-6 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="hero-title text-4xl font-bold">Kelola Akun Admin</h1>
                            <p class="mt-2 text-blue-100">Atur super admin dan admin lain sesuai akses yang dibutuhkan.</p>
                        </div>
                        <a href="{{ route('admin.accounts.create') }}"
                            class="action-mobile inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Admin</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="panel overflow-hidden mb-6">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-white text-xl font-bold flex items-center"><i class="fas fa-user-shield mr-3"></i>Daftar
                        Akun Admin</h2>
                </div>

                <div class="p-6">
                    <form method="GET" action="{{ route('admin.accounts.index') }}"
                        class="mb-6 flex flex-col sm:flex-row gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email..." class="input-main sm:max-w-md">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-xl">
                            <i class="fas fa-search"></i>
                            <span>Cari</span>
                        </button>
                    </form>

                    <div class="table-responsive">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-blue-50">
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($accounts as $account)
                                    @php
                                        $roleName = $account->getRoleNames()->first() ?? ($account->role ?? '-');
                                        $roleBadgeMap = [
                                            'super_admin' => [
                                                'label' => 'super admin',
                                                'classes' => 'bg-red-100 text-red-800',
                                            ],
                                            'admin_full' => [
                                                'label' => 'admin full',
                                                'classes' => 'bg-blue-100 text-blue-800',
                                            ],
                                            'admin_user_manager' => [
                                                'label' => 'admin user manager',
                                                'classes' => 'bg-green-100 text-green-800',
                                            ],
                                            'admin_data_manager' => [
                                                'label' => 'admin data manager',
                                                'classes' => 'bg-yellow-100 text-yellow-800',
                                            ],
                                        ];
                                        $roleBadge = $roleBadgeMap[$roleName] ?? [
                                            'label' => str_replace('_', ' ', $roleName),
                                            'classes' => 'bg-gray-100 text-gray-800',
                                        ];
                                    @endphp
                                    <tr class="hover:bg-gray-50/70 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $account->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $account->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $roleBadge['classes'] }}">
                                                {{ $roleBadge['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="{{ route('admin.accounts.edit', $account) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-3" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @if (!$account->isSuperAdmin())
                                                <form action="{{ route('admin.accounts.destroy', $account) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Hapus akun admin ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        title="Hapus">
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
