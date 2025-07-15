<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>

<body>
  <div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col min-h-screen">
      <!-- Page content here -->
      <label for="my-drawer-2" class="btn btn-primary drawer-button lg:hidden">
        Open drawer 
      </label>
      <div class=" flex-1 p-3 ">
        <div class="flex items-center justify-between mb-8 pr-5 pl-1">
          <div class="flex gap-2 items-center justify-center">
            
          </div>
          <!-- Input Pencarian -->
          <!-- <input type="text" placeholder="search" class="p-2 border rounded-xl shadow-2xl"> -->

          <div class="mb-4 mt-6">
          <form action="{{ route('informasihama.index') }}" method="GET" class="flex items-center p-2 bg-white border rounded-xl">
                <div class="relative flex-grow">
                    <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" 
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" 
                              d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                    <input type="text" name="cari" value="{{ $pencarian ?? '' }}" placeholder="Cari Informasi Hama" 
                          class="w-full p-2 pl-10 outline-none rounded-l-xl" />
                    </div>
                <button type="submit" 
                        class="p-2 bg-hijau1 text-white rounded-r-xl hover:bg-hijau1 transition duration-300">
                    Search
                </button>
            </form>
        </div>

          <!-- Input Pencarian -->

        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 h-2/3">
        @if ($hamaa->isEmpty())
        <div class="flex justify-center items-center h-64">
           <p class="text-center text-lg font-medium">Informasi Hama tidak ditemukan.</p>
           </div>
        @else
          @foreach ($hamaa as $hama)
            
          
          <!-- Card 1 -->
          <a class="btn btn-ghost hover:bg-transparent" onclick="document.getElementById('my_modal_hama{{ $hama->Id_Hama }}').showModal();">
            <div class="relative overflow-hidden rounded-lg shadow-lg">
              <img src="{{ asset('uploads/' . $hama->Gambar) }}" alt="Serangga Padi" class="w-screen h-64 object-cover">
              <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-white text-center py-2">
                {{$hama->Nama}}
              </div>
            </div>
          </a>
          <!-- Modal -->
          <dialog id="my_modal_hama{{$hama->Id_Hama}}" class="modal">
            <div class="max-h-[50rem] overflow-y-hidden bg-transparent border-2 rounded-3xl w-full max-w-2xl">
              <img class="w-full max-h-96 h-96 max-w-2xl object-cover" src="{{ asset('uploads/' . $hama->Gambar) }}">
              <div class="bg-white px-5 w-full">
                <p class="text-center font-bold text-2xl py-2">Deskripsi</p>
                <p class="text-center text-xl mb-4">{{$hama->Deskripsi}}</p>
                <p class="text-center font-bold text-2xl py-2 ">Klasifikasi Atau Jenis</p>
                <p class="text-center text-xl mb-4">{{$hama->Klasifikasi}}</p>
                <!-- <p class="text-center font-bold 2xl py-2">Penanganan</p>
                <p class="text-center text-xl">{{$hama->Deskripsi}}</p> -->
                <div class="modal-action py-5">
                  <form method="dialog">
                    <!-- if there is a button, it will close the modal -->
                    <button class="btn">Close</button>
                  </form>
                </div>
              </div>

            </div>
          </dialog>
  <!-- Modal -->
        @endforeach
        @endif

        </div>
      </div>
    </div>
    <div class="bg-hijau1 drawer-side h-screen">
      <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
      <ul class="menu text-white w-80 p-4">

        <!-- Sidebar content here -->
        <div class="flex justify-between items-center pb-14">
          <div class="flex items-center gap-x-2">
            <img class="w-8 h-8 " src="{{ asset('Icon/image 3.svg') }}">
            <h1 class="text-white text-2xl font-semibold"> PestDetection </h1>
          </div>
          <button @click="isSidebarOpen = false"><img class="w-6 h-6" src="{{ asset('Icon/Vector.svg') }}"></button>
        </div>
        <li class="mb-8 rounded-lg text-white text-3xl hover:bg-color-abu1 active:bg-color-abu1 focus:outline-none focus:ring focus:ring-bg-color-coklat2">
          <a class="font-light"><img class="w-7 h-7" src="{{ asset('Icon/iconhama.svg') }}">Hama</a>
        </li>
        <li class="mb-8 rounded-lg text-white text-3xl hover:bg-color-abu1 active:bg-color-abu1 focus:outline-none focus:ring focus:ring-bg-color-coklat2">
          <a href="informasitanaman" class="font-light"><img class="w-7 h-7" src="{{ asset('Icon/icontanaman.svg') }}">Tanaman</a>
        </li>
        <li class=" rounded-lg text-white text-3xl hover:bg-color-abu1 active:bg-color-abu1 focus:outline-none focus:ring focus:ring-bg-color-coklat2">
          <a href="d" class="font-light"><img class="w-7 h-7" src="{{ asset('Icon/icondeteksi.svg') }}">Deteksi</a>
        </li>
      </ul>
      <div class="dropdown dropdown-top gap-5">
      <div class="avatar pl-8 pb-4 translate-y-[35rem]">
        <div class=" w-14 rounded-full ring ">
          <button class="w-full h-full ">
            <img src="{{ asset('Icon/user-circle.svg') }}" />
          </button>
            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
              <!-- <li><a href="/pricing"><img class="w-8 h-8" src="{{ asset('Icon/money-icon.svg') }}">Membership</a></li> -->
              <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img class="w-8 h-8" src="{{ asset('Icon/logout.svg') }}">Logout</a>
              </li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>

</html>
