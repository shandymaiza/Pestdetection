<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/js/app.js', 'resources/css/app.css'])
  <title>Mengelola Informasi hama</title>
  
</head>


<body>

  <div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />

    <div class="drawer-side bg-hijau1">
      <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
      <ul class="menu text-base-content text-white min-h-full w-80 p-4">
        <div class="flex justify-between items-center pb-14">
          <div class="flex items-center gap-x-2">
            <img class="w-6 h-6" src="{{ asset('Icon/image 3.svg') }}" alt="Logo">
            <h1 class="text-white text-2xl font-semibold">PestDetection</h1>
          </div>
        </div>
        <ul class="space-y-4 ">
          <li class="text-hijau1 text-2xl rounded-l-2xl p-1 bg-white">
            <a href="dashboard" class=" font-semibold"><img class="w-7 h-7" src="{{ asset('Icon/dashboard coklat.svg') }}" alt="Dashboard Icon">Dashboard</a>
          </li>
          <li class=" text-hijau1 text-2xl rounded-l-2xl p-1 bg-white">
            <a href="pengguna" class="font-semibold"><img class="w-7 h-7" src="{{ asset('Icon/pengguna admin.svg') }}" alt="Pengguna Icon">Pengguna</a>
          </li>
          <li class=" text-hijau1 text-2xl  rounded-l-2xl bg-white p-1 ">
            <a href="mengelolatanaman" class="font-semibold"><img class="w-7 h-7" src="{{ asset('Icon/tanaman admin.svg') }}" alt="Tanaman Icon">Tanaman</a>
          </li>
          <li class=" text-hijau1 text-2xl  rounded-l-2xl bg-white p-1 ">
            <a href="mengelolahama" class="font-semibold"><img class="w-7 h-7" src="{{ asset('Icon/iconhama.svg') }}" alt="Hama Icon">Hama</a>
          </li>
          <ul class="space-y-2">
          </ul>
    </div>

    <div class="drawer-content flex flex-col  bg-color-abu1">

      <div class="navbar bg-base-100 shadow-lg ">
        <div class="flex-1">
          <a class=" pl-5 text-3xl font-bold text-hijau1 ">Dashboard</a>
        </div>
        <div class="flex-none gap-2">
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="flex items-center space-x-3 btn btn-ghost">
              <div class="avatar">
                <div class="w-10 rounded-full">
                  <img alt="User Avatar" src="{{ asset('Icon/user-circle.svg') }}" />
                </div>
              </div>
              <div>
                <p class="font-bold">Admin</p>
                <!-- <p class="text-sm font-semibold">Admin</p> -->
              </div>

            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
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
<!-- search -->
<div class="mb-2 mt-6 mr-10 flex justify-end">
          <form action="{{ route('mengelolahama.index') }}" method="GET" class="flex items-center p-2 bg-white border rounded-xl w-auto">
                <div class="relative flex-grow">
                    <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" 
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" 
                              d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                    <input type="text" name="cari" value="{{ $pencarian ?? '' }}" placeholder="Cari Informasi Hama" 
                          class=" p-2 pl-10 outline-none rounded-l-xl w-96" />
                    </div>
                <button type="submit" 
                        class="p-2 bg-hijau1 text-white rounded-r-xl hover:bg-color-coklat1 transition duration-300">
                    Search
                </button>
            </form>
        </div>


<!-- search -->
      <div class="p-10">
        <div class=" w-full col-span-2 shadow-lg text-lg bg-white">
          <div class="flex justify-between p-5 border-b-2 items-center text-2xl font-medium">
            <h1>Informasi Hama</h1>
            <button class="btn bg-hijau1 text-white" onclick="my_modal_tambah.showModal()">Tambah</button>
          </div>
          <table class="table text-lg">
            <!-- head -->
            <thead class="text-lg ">
              <tr>
                <th></th>
                <th>Nama Hama</th>
                <th>Deskripsi</th>
                <th>Klasifikasi Hama</th>
              </tr>
            </thead>
            <tbody>
              @if ($hamaa->isEmpty())
              <tr>
                <td colspan="4">
              <div class="flex justify-center items-center h-64">
              <p class="text-center text-lg font-medium">Informasi Hama tidak ditemukan.</p>
              </div>
                </td>
              </tr>
              @else
              
            @foreach ($hamaa as $index => $hama)
              <!-- row 1 -->
              <tr>
                <th>{{ $index + 1 }}</th>
                <td>
                  <p class="w-40 truncate">{{$hama->Nama}}</p>
                </td>
                <td>
                  <p class="w-40 truncate">{{$hama->Deskripsi}}</p>
                </td>
                <td>
                  <p class="w-40 truncate">{{$hama->Klasifikasi}}</p>
                </td>
                <th>
                  <a class="btn btn-ghost hover:bg-transparent">
                    <img src="{{ asset('icon/iconpalu.svg') }}" class="#" onclick="document.getElementById('my_modal_edit{{ $hama->Id_Hama}}').showModal();" >
                  </a>
                  <a class="btn btn-ghost hover:bg-transparent" onclick="document.getElementById('my_modal_delete{{ $hama->Id_Hama}}').showModal();">
                    <img src="{{ asset('icon/icontong.svg') }}" class="#">
                  </a>
                  <a class="btn btn-ghost hover:bg-transparent" onclick="document.getElementById('my_modal_detail{{ $hama->Id_Hama}}').showModal();">
                    <img src="{{ asset('icon/detail.svg') }}" class="#">
                  </a>
                </th>

              </tr>
               <!-- Modal Hapus -->
        <dialog id="my_modal_delete{{$hama->Id_Hama}}" class="modal">
            <div class="modal-box">
              <h3 class="font-bold text-lg">Hello!</h3>
              <p class="py-4">Apakah anda yakin ingin menghapus ?</p>
              <div class="modal-action">
              <button type="button" class="btn" onclick="document.getElementById('my_modal_delete{{$hama->Id_Hama}}').close();">Tutup</button>
             <form method="POST" action="{{route ('mengelolahama.destroy', $hama->Id_Hama)}}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn bg-red-600 text-white">Hapus</button>
              </div>
            </div>
        </form>
           
          </dialog>
  <!-- Modal Hapus -->

  <!-- Modal edit-->

  <dialog id="my_modal_edit{{$hama->Id_Hama}}" class="modal">
    <div class="modal-box w-full max-w-lg mx-auto">
        <h2 class="text-xl font-semibold border-b pb-2 mb-4">Edit Data Tanaman</h2>
        <form action="{{route ('mengelolahama.update', $hama->Id_Hama)}}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
        <div class="gap-4 w-full p-3 grid">
            <label class="flex flex-col gap-1">
                <span class="font-medium">Nama</span>
                <input type="text" name="nama" class="input input-bordered w-full" placeholder="Nama Tanaman" value="{{$hama->Nama}}" required/>
            </label>
            <label class="flex flex-col gap-1">
                <span class="font-medium">Klasifikasi Ilmiah</span>
                <input type="text"  name="klasifikasi" class="input input-bordered w-full" placeholder="Klasifikasi Tanaman" value="{{$hama->Klasifikasi}}" required/>
            </label>
            <label class="flex flex-col gap-1">
                <span class="font-medium">Gambar</span>
                <input type="file" name="gambar" class="file-input file-input-bordered w-full  file:bg-color-coklat2"/>
            </label>
            <label class="flex flex-col gap-1">
                <span class="font-medium">Deskripsi</span>
                <textarea  name="deskripsi" class="input input-bordered w-full" placeholder="Deskripsi" required >{{$hama->Deskripsi}}</textarea>
            </label>
        </div>

    
      <div class="modal-action">
        <form method="dialog">
          <!-- if there is a button in form, it will close the modal -->
          <button type="button" class="btn" onclick="document.getElementById('my_modal_edit{{$hama->Id_Hama}}').close();">Tutup</button>
          <button class="btn bg-green-600 text-white" type="submit">Edit</button>
        </form>
      </div>
        </form>
    </div>
  </dialog>
   <!-- Modal edit-->
    <!-- MOdal Detail -->
    <dialog id="my_modal_detail{{$hama->Id_Hama}}" class="modal">
    <div class="modal-box max-h-screen overflow-y-auto">
        <h3 class="text-lg font-bold border-b-2">Detail Informasi Hama</h3>
        <h3 class="text-lg font-bold mt-5 mb-4">Nama Tanaman</h3>
        <p>{{$hama->Nama}}</p>
        <h3 class="text-lg font-bold mt-5 mb-4">Deskripsi</h3>
        <p>{{$hama->Deskripsi}}</p>
        <h3 class="text-lg font-bold mt-5 mb-4">Klasifikasi</h3>
        <p>{{$hama->Klasifikasi}}</p>
        <h3 class="text-lg font-bold mt-5 mb-4">Gambar</h3>
        <img class="object-contain" width="695" src="{{ asset('uploads/' . $hama->Gambar) }}">
        <div class="modal-action">
            <form method="dialog">
                <!-- Close button -->
                <button class="btn"  onclick="document.getElementById('my_modal_edit{{$hama->Id_Hama}}').close();">Close</button>
            </form>
        </div>
    </div>
</dialog>

    <!-- MOdal Detail -->
  @endforeach
  @endif
            </tbody>
          </table>
        </div>
        <label for="my-drawer-2" class="btn btn-primary drawer-button lg:hidden">Open drawer</label>
      </div>
    </div>
  </div>

 
  <!-- Modal Tambah -->
  <dialog id="my_modal_tambah" class="modal">
    <div class="modal-box w-full max-w-lg mx-auto">
        <h2 class="text-xl font-semibold border-b pb-2 mb-4">Tambah Data Hama</h2>
        <form action="{{ route('mengelolahama.store') }}" method="POST" enctype="multipart/form-data">
        @csrf 
            <div class="gap-4 w-full p-3 grid">
            <label class="flex flex-col gap-1">
                <span class="font-medium">Nama</span>
                <input type="text" name="nama" class="input input-bordered w-full" placeholder="Nama Hama"  required/>
            </label>
            <label class="flex flex-col gap-1">
                <span class="font-medium">Klasifikasi Ilmiah</span>
                <input type="text"  name="klasifikasi" class="input input-bordered w-full" placeholder="Klasifikasi Hama" required />
            </label>
            <label class="flex flex-col gap-1">
                <span class="font-medium">Gambar</span>
                <input type="file" name="gambar" class="file-input file-input-bordered w-full  file:bg-hijau1" required />
            </label>
            <label class="flex flex-col gap-1">
                <span class="font-medium">Deskripsi</span>
                <textarea  name="deskripsi" class="input input-bordered w-full" placeholder="Deskripsi" rows="4" required ></textarea>
            </label>
        </div>
            <div class="modal-action">
                <button type="button" class="btn" onclick="document.getElementById('my_modal_tambah').close();">Tutup</button>
                <button type="submit" class=" btn bg-green-600 text-white ">Tambah</button>
            </div>
        </form>
    </div>
</dialog>
   <!-- Modal Tambah -->



@if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif
</body>
</html>

