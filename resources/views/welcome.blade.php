<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Main Container -->
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-500 to-indigo-600">
        <!-- Card -->
        <div class="bg-white shadow-lg rounded-lg w-96 p-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Welcome to Our App</h1>
            <p class="text-gray-600 mb-6">Please choose an option below to proceed:</p>

            <!-- Buttons -->
            <div class="space-y-4">
                <a href="{{ route('login') }}" class="block w-full bg-blue-500 text-white font-semibold py-2 rounded hover:bg-blue-600">
                    Login
                </a>
                <a href="{{ route('register') }}" class="block w-full bg-green-500 text-white font-semibold py-2 rounded hover:bg-green-600">
                    Register
                </a>
            </div>
        </div>
    </div>

</body>
</html>
