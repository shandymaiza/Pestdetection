<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Home</title>
    <style>
        @import url(https://pro.fontawesome.com/releases/v5.10.0/css/all.css);
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;800&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }

        .hover\:w-full:hover {
            width: 100%;
        }

        .group:hover .group-hover\:w-full {
            width: 100%;
        }

        .group:hover .group-hover\:inline-block {
            display: inline-block;
        }

        .group:hover .group-hover\:flex-grow {
            flex-grow: 1;
        }

        @keyframes word {
            0% {
                transform: translateY(100%);
            }

            15% {
                transform: translateY(-10%);
                animation-timing-function: ease-out;
            }

            20% {
                transform: translateY(0);
            }

            40%,
            100% {
                transform: translateY(-110%);
            }
        }

        .animate-word {
            animation: word 7s infinite;
            color: #2E7D32; /* Warna hijau */
        }

        .animate-word-delay-1 {
            animation: word 7s infinite;
            animation-delay: -1.4s;
            color: #2E7D32;
        }

        .animate-word-delay-2 {
            animation: word 7s infinite;
            animation-delay: -2.8s;
            color: #2E7D32;
        }

        /* Warna hijau untuk navbar */
        .nav-item:hover .nav-icon {
            background-color: #C8E6C9; /* hijau4 */
            color: #2E7D32; /* hijau1 */
        }

        /* Responsivitas */
        @media (max-width: 768px) {
            .container-flex {
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            
            .text-content {
                margin-top: 2rem;
                text-align: center;
                transform: none !important;
                padding: 0 1rem;
            }
            
            .hero-image {
                width: 80%;
                max-width: 400px;
                margin-top: 2rem;
            }
            
            .navbar-container {
                width: 100%;
                max-width: 100%;
                padding: 0 1rem;
            }
            
            .navbar {
                transform: none !important;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                border-radius: 0;
                margin-bottom: 0;
                box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            }
            
            .text-5xl {
                font-size: 2.5rem;
                line-height: 1.2;
            }
        }
    </style>
</head>

<body>
    <div class="h-screen w-screen flex justify-end items-center container-flex">
        <!-- Navbar - Diubah warnanya saja -->
        <div class="w-full max-w-md mx-auto navbar-container">
            <div class="px-7 bg-white rounded-2xl mb-5 translate-x-[1rem] -translate-y-[26rem] navbar">
                <div class="flex">
                    <div class="flex-auto hover:w-full group">
                        <a href="#" class="flex items-center justify-center text-center mx-auto px-4 py-2 group-hover:w-full text-hijau1">
                            <span class="block px-1 py-1 transition-all delay-150 group-hover:bg-hijau4 rounded-full group-hover:flex-grow nav-item">
                                <i class="far fa-home text-2xl pt-1 nav-icon"></i><span class="hidden group-hover:inline-block ml-3 align-bottom pb-1">Home</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex-auto hover:w-full group">
                        <a href="#" class="flex items-center justify-center text-center mx-auto px-4 py-2 group-hover:w-full text-hijau1">
                            <span class="block px-1 py-1 transition-all delay-150 group-hover:bg-hijau4 rounded-full group-hover:flex-grow nav-item">
                                <i class="far fa-phone text-2xl pt-1 nav-icon"></i><span class="hidden group-hover:inline-block ml-3 align-bottom pb-1">Contact us</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex-auto hover:w-full group">
                        <a href="{{ url('/login') }}" class="flex items-center justify-center text-center mx-auto px-4 py-2 group-hover:w-full text-hijau1">
                            <span class="block px-1 py-1 transition-all delay-150 group-hover:bg-hijau4 rounded-full group-hover:flex-grow nav-item">
                                <i class="far fa-user text-2xl pt-1 nav-icon"></i><span class="hidden group-hover:inline-block ml-3 align-bottom pb-1">Login</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex-auto hover:w-full group">
                        <a href="{{ url('/daftar') }}" class="flex items-center justify-center text-center mx-auto px-4 py-2 group-hover:w-full text-hijau1">
                            <span class="block px-1 py-1 transition-all delay-150 group-hover:bg-hijau4 rounded-full group-hover:flex-grow nav-item">
                                <i class="far fa-sign-in text-2xl pt-1 nav-icon"></i><span class="hidden group-hover:inline-block ml-3 align-bottom pb-1">Sign in</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Konten Teks - Hanya ubah warna -->
        <div class="flex h-80 items-center justify-center font-bold text-hijau1 -translate-x-[28rem] text-content">
            <div class="text-center space-y-12">
                <div class="text-center text-5xl font-bold">
                    Website Ini Menyediakan
                    <div class="relative inline-grid grid-cols-1 grid-rows-1 gap-12 overflow-hidden">
                        <span class="animate-word col-span-full row-span-full">Deteksi Tanaman</span>
                        <span class="animate-word-delay-1 col-span-full row-span-full">Informasi Hama</span>
                        <span class="animate-word-delay-2 col-span-full row-span-full">Informasi Tanaman</span>
                    </div>
                </div>
                <p class="text-hijau1">
                    Ingin Mengetahui Gejala Tanaman Anda? <a class="underline text-hijau1 hover:text-color-coklat1" href="login">klik disini</a>
                </p>
            </div>
        </div>
        
        <!-- Gambar - Tetap sama hanya tambahan class responsif -->
        <img class="object-contain hero-image" width="764.3" src="{{ asset('Icon/Group 5.svg') }}">
    </div>

    <div class="justify">
        < <img class="object-contain hero-image" width="764.3" src="{{ asset('Icon/Group 9.svg') }}">
    </div>
</body>
</html>