<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Daftar</title>
</head>

<body>
    <div class="h-screen bg-white w-screen flex justify-center items-center">
        <div class="bg-white w-7/12 h-[35rem] flex justify-center shadow-2xl relative border-2">
            <div class= "absolute w-7/12 top -4 left-4 z-50">
                <div class="navbar-start">
                    <ul class="menu menu-horizontal px-1 text-color-coklat2">
                      <img width="30" src="{{ asset('Icon/image 3.svg') }}" alt="Logo" class="object-contain">
                      
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
            </div>
            <div class="flex flex-col justify-center -translate-x-64 gap-4">
                <label class="text-center text-3xl font-semibold text-green-600 underline">Daftar</label>

                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('daftar.post') }}" method="POST">
                    @csrf
                    <label class="input input-bordered flex items-center gap-2 mb-2 bg-white border-green-600">
                        <input type="email" name="email" class="grow" placeholder="Email" required />
                    </label>
                    <label class="input input-bordered flex items-center gap-2 mb-2 bg-white border-green-600">
                        <input type="text" name="name" class="grow" placeholder="Username" required />
                    </label>
                    <label class="input input-bordered flex items-center gap-2 mb-2 bg-white border-green-600">
                        <input type="password" name="password" id="password" class="grow" placeholder="Password" required />
                        <button type="button" onclick="togglePasswordVisibility('password')" class="text-gray-500 focus:outline-none">👁️</button>
                    </label>
                    <button type="submit" class="btn btn-wide bg-green-600 text-white">Daftar</button>
                </form>
            </div>

            <img class="object-contain translate-x-[23rem] absolute" width="447.7" src="{{ asset('Icon/Group 1.svg') }}">
        </div>
    </div>
    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const fieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', fieldType);
        }
    </script>
</body>

</html>
