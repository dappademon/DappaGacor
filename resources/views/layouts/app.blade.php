<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Sistem Informasi Arsip Desa</title>
    
    {{-- Fonts: Inter for a clean, modern administrative look --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 flex flex-col">

    {{-- TOP NAVBAR (Modern Command Center Style) --}}
    <nav class="bg-slate-900 text-white shadow-md sticky top-0 z-50 border-b border-slate-800">
        <div class="px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            {{-- Brand --}}
            <div class="flex items-center gap-3">
                <div class="bg-indigo-600 text-white p-2 rounded-lg shadow-inner">
                    <i class="fas fa-landmark text-lg"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg tracking-wide uppercase leading-tight">E-Archive Desa</h1>
                    <p class="text-[10px] text-slate-400 font-medium tracking-wider uppercase">Pemerintah Desa</p>
                </div>
            </div>

            {{-- User Menu --}}
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3 border-r border-slate-700 pr-6 hidden md:flex">
                    <div class="text-right">
                        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-indigo-300 font-medium tracking-wider uppercase">{{ auth()->user()->role }}</p>
                    </div>
                    <div class="h-9 w-9 rounded-full bg-slate-700 flex items-center justify-center border border-slate-600 shadow-inner">
                        <i class="fas fa-user text-slate-300"></i>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm font-medium text-slate-300 hover:text-white transition flex items-center gap-2 group">
                        <span class="hidden sm:inline">Keluar</span>
                        <div class="bg-red-500/10 text-red-400 group-hover:bg-red-500 group-hover:text-white p-2 rounded-lg transition">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden">
        {{-- SIDEBAR (Structured & Clean) --}}
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col shrink-0">
            <div class="flex-1 overflow-y-auto py-6 px-4">
                
                <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-l-4 border-transparent' }}">
                        <i class="fas fa-chart-pie w-5 text-center {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400' }}"></i> 
                        Dashboard Utama
                    </a>

                    @if(in_array(auth()->user()->role, ['admin', 'staff']))
                    <a href="{{ route('arsip.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('arsip.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-l-4 border-transparent' }}">
                        <i class="fas fa-folder-open w-5 text-center {{ request()->routeIs('arsip.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i> 
                        Data Arsip
                    </a>
                    @endif
                </nav>

                @if(auth()->user()->isAdmin())
                <div class="mt-8">
                    <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Administrator</p>
                    <nav class="space-y-1">
                        <a href="{{ route('kategori.index') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('kategori.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-l-4 border-transparent' }}">
                            <i class="fas fa-tags w-5 text-center {{ request()->routeIs('kategori.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i> 
                            Kategori Surat
                        </a>
                        <a href="{{ route('users.index') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-l-4 border-transparent' }}">
                            <i class="fas fa-users-cog w-5 text-center {{ request()->routeIs('users.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i> 
                            Manajemen Akun
                        </a>
                    </nav>
                </div>
                @endif
                @if(in_array(auth()->user()->role, ['admin', 'kades']))
                <a href="{{ route('laporan.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('laporan.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-l-4 border-transparent' }}">
                    <i class="fas fa-print w-5 text-center {{ request()->routeIs('laporan.*') ? 'text-indigo-600' : 'text-slate-400' }}"></i> 
                    Laporan Arsip
                </a>
@endif
            </div>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-2 text-slate-500 text-xs font-medium">
                    <i class="fas fa-shield-alt text-slate-400"></i>
                    Sistem Terenkripsi
                </div>
                <p class="text-[10px] text-slate-400 mt-1 ml-5">V 1.0.0 &copy; {{ date('Y') }}</p>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 overflow-y-auto p-6 sm:p-8">
            <div class="max-w-7xl mx-auto">
                
                {{-- Modern Flash Messages --}}
                @if(session('success'))
                <div class="mb-6 bg-white border-l-4 border-emerald-500 shadow-sm rounded-r-lg p-4 flex items-center gap-3" x-data="{ show: true }" x-show="show">
                    <div class="bg-emerald-100 text-emerald-600 p-2 rounded-full">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800">Berhasil</p>
                        <p class="text-sm text-slate-600">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-white border-l-4 border-rose-500 shadow-sm rounded-r-lg p-4 flex items-center gap-3" x-data="{ show: true }" x-show="show">
                    <div class="bg-rose-100 text-rose-600 p-2 rounded-full">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800">Peringatan Sistem</p>
                        <p class="text-sm text-slate-600">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
                </div>
                @endif

                {{-- Page Content --}}
                <div class="animate-fade-in-up">
                    @yield('content')
                </div>

            </div>
        </main>
    </div>

    {{-- Simple Custom Animation for smooth page loads --}}
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.4s ease-out; }
    </style>
</body>
</html>