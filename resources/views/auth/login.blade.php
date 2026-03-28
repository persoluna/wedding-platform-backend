<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Persoluna</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <div class="flex-grow flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden p-8">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block text-2xl font-serif text-teal-800 font-bold mb-4">Persoluna</a>
                <h2 class="text-3xl font-semibold text-gray-900">Welcome Back</h2>
                <p class="text-gray-500 mt-2">Sign in to your account</p>
            </div>

            @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-teal-800 text-white py-3 px-4 rounded-xl font-medium hover:bg-teal-900 transition-colors">
                    Sign In
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-gray-600">
                Don't have an account? <a href="{{ route('register') }}" class="font-medium text-teal-800 hover:text-teal-900">Sign up</a>
            </p>
        </div>
    </div>
</body>
</html>
