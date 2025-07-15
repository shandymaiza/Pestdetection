<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-FqELecHrvy2UQsrG"></script>

    <title>Pricing</title>
</head>

<body>
    <!-- component -->
<section class="bg-color-coklat2 from-color-coklat1 to-indigo-900 py-12 h-screen">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h2 class="text-4xl font-extrabold text-white sm:text-5xl">
        MEMBERSHIP
      </h2>
      <p class="mt-4 text-xl text-white">
        Berlangganan Membership Untuk Membuka Fitur Baru
      </p>
    </div>

    <div class="grid grid-cols-1 gap-8 sm:grid-cols-1 lg:grid-cols-2 place-items-center">
      <!-- Basic Plan -->
      <div class="bg-white bg-opacity-10 rounded-lg shadow-lg p-6 relative overflow-hidden lg:col-span-2">
        <div class="absolute top-0 right-0 m-4">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
            Basic
          </span>
        </div>
        <div class="mb-8">
          <h3 class="text-2xl font-semibold text-white">Harga Pemula</h3>
          <p class="mt-4 text-white">Cocok digunakan untuk 1 orang.</p>
        </div>
        <div class="mb-8">
          <span class="text-5xl font-extrabold text-white">Rp 50rb</span>
          <span class="text-xl font-medium text-white">/bln</span>
        </div>
        <ul class="mb-8 space-y-4 text-white">
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>20 Deteksi/hari</span>
          </li>
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Dapat melihat halaman solusi</span>
          </li>
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Arahan menanam tanaman</span>
          </li>
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Cara perawatan</span>
          </li>
        </ul>
        <a href="#" id="pay-button" class="block w-full py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700">
          Berlangganan
      </a>
      </div>
    </div>

    <!-- Button Kembali ke Halaman Deteksi -->
    <div class="mt-8 text-center">
      <li class="rounded-lg text-white text-3xl hover:bg-color-coklat2 active:bg-color-coklat2 focus:outline-none focus:ring focus:ring-bg-color-coklat2">
        <a href="user/d" class="font-light flex items-center justify-center">
          <img class="w-7 h-7 mr-2" src="{{ asset('Icon/icondeteksi.svg') }}" alt="Icon Deteksi">Deteksi
        </a>
      </li>
    </div>
    
  </div>
</section>
</body>
<script>
  document.getElementById('pay-button').addEventListener('click', function (e) {
    e.preventDefault();

    fetch('/payment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.snapToken) {
            snap.pay(data.snapToken, {
                onSuccess: function (result) {
                    // Kirim permintaan ke backend untuk mengupdate status
                    fetch('/update-subscription', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message); // Tampilkan pesan sukses
                        console.log(result); // Log hasil pembayaran
                    })
                    .catch(error => {
                        console.error('Error updating subscription:', error);
                    });
                },
                onPending: function (result) {
                    alert("Pembayaran masih pending. Status belum diperbarui.");
                    console.log(result);
                },
                onError: function (result) {
                    alert("Terjadi kesalahan pada pembayaran.");
                    console.log(result);
                }
            });
        } else {
            alert('Error generating Snap Token');
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>
</html>
