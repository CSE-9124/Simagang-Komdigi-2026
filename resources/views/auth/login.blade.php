<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Simagang Admin - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #193097 10%, #628ECB 30%, #D5DEEF 100%);
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: float 8s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -80px;
            left: -80px;
            animation: float 6s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0,0); }
            50% { transform: translate(20px,-30px); }
        }

        .login-container {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
            padding: 48px 40px;
            width: 100%;
            max-width: 450px;
            max-height: 580px;
            animation: slideIn .6s ease-out;
            position: relative;
            z-index: 1;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background: #f9fafb;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59,130,246,.1);
        }
    </style>
</head>

<body>

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="login-container">

        <!-- HEADER LOGO -->
     <div class="text-center mb-3 space-y-3">
        <div class="logo mx-auto flex items-center justify-center w-40 h-40">
            <img
                src="{{ asset('storage/vendor/simagi.png') }}"
                alt="Logo Vendor"
                class="w-40 h-40 object-contain">
        </div>
    </div>


        <!-- FORM -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Email -->
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="email@contoh.com"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                           focus:bg-white focus:border-blue-500 focus:ring-4
                           focus:ring-blue-500/20 transition"
                >
                @error('email')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                           focus:bg-white focus:border-blue-500 focus:ring-4
                           focus:ring-blue-500/20 transition"
                >
                @error('password')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember -->
            <div class="flex items-center">
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    >
                    Ingat saya
                </label>
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full py-3 rounded-xl font-semibold text-white
                       bg-gradient-to-r from-blue-600 to-blue-700
                       hover:from-blue-700 hover:to-blue-800
                       shadow-lg shadow-blue-500/30
                       transition duration-200"
            >
                Masuk
            </button>
        </form>

        <!-- FOOTER -->
        <div class="text-center mt-6 text-xs text-gray-500">
            © 2026 Simagang. Sistem manajemen magang terpadu.
        </div>

    </div>
</div>

</body>
</html>