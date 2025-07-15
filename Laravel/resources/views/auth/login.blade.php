<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Login</title>

</head>

<body>
    <div class="h-screen bg-white w-screen flex justify-center items-center">
        <div class="bg-white w-7/12 h-[35rem] flex justify-center shadow-2xl relative border-2 border-green-600">
            <!-- Navbar -->
            <div class="absolute w-7/12 top-4 left-4 z-50">
                <ul class="flex items-center gap-8">
                    <li>
                        <img width="30" src="{{ asset('Icon/image 3.svg') }}" alt="Logo" class="object-contain">
                    </li>
                    <li>
                        <a href="{{ url('/') }}" class="nav-link text-gray-600">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('/login') }}" class="nav-link text-gray-600">Login</a>
                    </li>
                    <li>
                        <a href="{{ url('/daftar') }}" class="nav-link text-gray-600">Daftar</a>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col justify-center -translate-x-64 gap-6">
                <label class="text-center text-3xl font-semibold text-green-600 underline underline-offset-8">Login</label>

                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <!-- Username Input -->
                    <label class="input input-bordered flex items-center gap-4 mb-4 bg-white border-2 border-green-600">
                        <input type="text" name="name" class="grow" placeholder="Username" required />
                    </label>
                    
                    <!-- Password Input -->
                    <label class="input input-bordered flex items-center gap-4 mb-4 bg-white border-2 border-green-600">
                        <input type="password" name="password" id="password" class="grow" placeholder="Password" required />
                        <button type="button" onclick="togglePasswordVisibility()" class="text-gray-500 focus:outline-none">👁️</button>
                    </label>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-wide bg-green-600 text-white gap-4">Login</button>
                </form>
            </div>

            <img class="object-contain translate-x-[23rem] absolute " width="447.7" src="{{ asset('Icon/Group 1.svg') }}"
        </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const fieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', fieldType);
        }
    </script>
</body>

</html>