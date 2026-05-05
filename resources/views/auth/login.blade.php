<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Archive Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 mx-4">
        <div class="text-center mb-8">
            <div class="bg-blue-900 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-archive text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">E-Archive Desa</h1>
            <p class="text-gray-500 text-sm">Silakan login untuk mengakses arsip</p>
        </div>

        @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" 
                        placeholder="admin@desa.id" required autofocus>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" 
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" 
                        placeholder="••••••••" required>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 mr-2">
                    Ingat Saya
                </label>
            </div>

            <button type="submit" 
                class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-8 pt-6 border-t text-center">
            <p class="text-gray-500 text-xs uppercase tracking-widest font-semibold mb-2">Sistem Pengarsipan Digital</p>
            <p class="text-gray-400 text-xs">Versi 1.0 &copy; {{ date('Y') }} Pemerintah Desa</p>
        </div>
    </div>
</body>
</html>