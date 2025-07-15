<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')

  <title>Pengguna</title>
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
            <h1 class="text-white text-2xl font-semibold">Gaichu</h1>
          </div>
        </div>
        <ul class="space-y-4 ">
          <li class="text-color-coklat1 text-2xl rounded-l-2xl p-1 bg-white">
            <a href="dashboard" class=" font-semibold"><img class="w-7 h-7" src="{{ asset('Icon/dashboard coklat.svg') }}" alt="Dashboard Icon">Dashboard</a>
          </li>
          <li class=" text-white text-2xl rounded-l-2xl p-1 bg-color-coklat2">
            <a href="pengguna" class="font-semibold"><img class="w-7 h-7" src="{{ asset('Icon/pengguna putih.svg') }}" alt="Pengguna Icon">Pengguna</a>
          </li>
          <li class=" text-color-coklat1 text-2xl rounded-l-2xl p-1 bg-white">
            <a href="mengelolatanaman" class="font-semibold"><img class="w-7 h-7" src="{{ asset('Icon/tanaman admin.svg') }}" alt="Tanaman Icon">Tanaman</a>
          </li>
          <li class=" text-color-coklat1 text-2xl  rounded-l-2xl bg-white p-1 ">
            <a href="mengelolahama" class="font-semibold"><img class="w-7 h-7" src="{{ asset('Icon/hama admin.svg') }}" alt="Hama Icon">Hama</a>
          </li>
          <ul class="space-y-2">
          </ul>
    </div>

    <div class="drawer-content flex flex-col bg-color-abu1">

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


      <div class="p-10 ">
        <div class="overflow-x-auto shadow-1xl bg-white">
          <div class="flex justify-between p-5 border-b-2 items-center font-medium text-2xl">
            <h1>Status Pengguna</h1>
          </div>
          <table class="table text-lg">
            <!-- head -->
            <thead>
              <tr>
                <th></th>
                <th>Nama</th>
                <th>Email</th>
                <th>Membership</th>
              </tr>
            </thead>
            <tbody>
            @forelse ($penggunabiasa as $index => $pengguna )
              <!-- row 1 -->
              <tr>
                <th>{{$index + 1}}</th>
                <td><p class="truncate w-40">{{$pengguna->name}}</p></td>
                <td><p class="truncate w-40">{{$pengguna->email}}</p></td>
                <td>
                @if ($pengguna->membership == 'free')
                <img src="{{ asset('Icon/x.svg') }}">
                @elseif ($pengguna->membership == 'premium')
                <img src="{{ asset('Icon/check.svg') }}">
                @endif
                </td>
              </tr>
              @empty
              <tr>
                    <td colspan="4" class="text-center">Tidak ada pengguna biasa.</td>
                </tr>
                @endforelse
            </tbody>
          </table>
        </div>
        <label for="my-drawer-2" class="btn btn-primary drawer-button lg:hidden">Open drawer</label>
      </div>
    </div>
  </div>




</body>

</html>