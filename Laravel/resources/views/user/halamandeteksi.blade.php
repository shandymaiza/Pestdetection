<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://horizon-ui.com/shadcn-nextjs-boilerplate/_next/static/css/12f72a06cf11dcdf.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <title>Halaman Deteksi</title>
</head>

<body>
  <div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col items-center justify-start overflow-x-hidden overflow-y-auto min-h-screen">
      <!-- Page content here -->
      <label for="my-drawer-2" class="btn btn-primary drawer-button lg:hidden">
        Open drawer
      </label>

      <div class="flex items-center justify-center min-h-screen w-full bg-white pt-12 ">
        <div class="max-w-[1098px] max-h-screen mx-auto rounded-lg overflow-y-auto overflow-x-hidden">
          <div class="md:flex">
            <div class="w-full p-3">
              <!-- Area Upload -->
              <div id="upload-area" class="relative border-dashed h-[600px] w-[900px] rounded-lg border-4 border-color-biru1 bg-color-biru2 flex justify-center items-center">
                <div class="absolute">
                  <div class="flex flex-col items-center">
                    <img id="uploaded-image" class="hidden mb-4" style="max-width: 100%; max-height: 300px;" />
                    <img src="{{ asset('gambar/gambardeteksi.png') }}">
                    <span class="block text-gray-400 font-normal">
                      Drop your files here or
                      <button id="browse-button" class="text-color-biru1">Browse</button>
                    </span>
                  </div>
                </div>
                <input type="file" class="h-full w-full opacity-0" id="image-upload" name="image">
              </div>
                <!-- Area Upload -->
              <!-- Tombol Deteksi -->
               <div class="flex justify-center space-x-4 mt-2">
              <button id="detect-btn" class="mt-6  bg-blue-500 text-white px-12 py-4 rounded-lg text-lg  font-semibold hover:bg-blue-600 transition">
                Deteksi
              </button>
              <button id="delete-btn" class=" hidden mt-6  bg-red-500 text-white px-12 py-4 rounded-lg text-lg  font-semibold hover:bg-red-600 transition">
                Hapus Gambar
              </button>
              </div>
<!-- Preview Hasil -->
              <div id="result" class="w-full mt-6 hidden">
                            <div
                                class="mr-5 flex h-10 min-h-[40px] min-w-[40px] items-center justify-center rounded-full bg-zinc-950 border border-zinc-800">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                    aria-hidden="true" class="h-4 w-4 text-white" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z"
                                        clip-rule="evenodd"></path>
                                </svg></div>
                            <div
                                class="rounded-lg border-4 shadow-sm flex !max-h-max p-5 !px-[22px] !py-[22px] text-base font-normal leading-6 text-black backdrop-blur-xl md:text-base md:leading-[26px]">
                                <div class=" font-normal">
                                    <!-- <p><strong>Hasil Deteksi</strong></p> -->
                                    <p>&nbsp;</p>
                                    <img id="result-image" class="mt-4 mb-4 rounded-lg max-w-full mx-auto hidden" />
                                    <p id="result-text"></p>
                                </div>
                            </div>
                        </div>
<!-- Preview Hasil -->
                        <div class="flex justify-center">
              <button id="retry-btn" class="hidden mt-4 bg-blue-500 text-white px-12 py-4 rounded-lg hover:bg-blue-600 transition">Coba Deteksi Lagi</button>
              </div>

              <!-- Preview Hasil -->
              <!-- <div id="result" class="mt-4 p-6 bg-white rounded-lg shadow-lg w-full max-w-[900px] hidden ">
                <h2 class="text-xl font-semibold">Hasil Deteksi</h2>
                <p id="result-text" class="mt-2 text-gray-700"></p>
                <img id="result-image" class="mt-4 rounded-lg max-w-full hidden" />
                <div class="flex justify-center">
              <button id="retry-btn" class="hidden mt-4 bg-blue-500 text-white px-12 py-4 rounded-lg hover:bg-blue-600 transition">Coba Deteksi Lagi</button>
              </div>
              </div> -->
<!-- Preview Hasil -->

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="bg-hijau1 drawer-side h-full ">
      <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
      <ul class="menu text-white w-80 p-4">
        <!-- Sidebar content here -->
        <div class="flex justify-between items-center pb-14">
          <div class="flex items-center gap-x-2">
            <img class="w-8 h-8" src="{{ asset('Icon/image 3.svg') }}">
            <h1 class="text-white text-2xl font-semibold"> PestDetection </h1>
          </div>
          <button><img class="w-6 h-6" src="{{ asset('Icon/Vector.svg') }}"></button>
        </div>
        <li class="text-white text-3xl">
          <a href="informasihama" class="font-light"><img class="w-7 h-7" src="{{ asset('Icon/iconhama.svg') }}">Hama</a>
        </li>
        <li class="pt-9 text-white text-3xl">
          <a href="informasitanaman" class="font-light"><img class="w-7 h-7" src="{{ asset('Icon/icontanaman.svg') }}">Tanaman</a>
        </li>
        <li class="pt-9 text-white text-3xl">
          <a class="font-light"><img class="w-7 h-7" src="{{ asset('Icon/icondeteksi.svg') }}">Deteksi</a>
        </li>
      </ul>
      <div class="dropdown dropdown-top">
      <div class="avatar pl-8 pb-4 translate-y-[35rem]">
        <div class=" w-14 rounded-full ring ">
          <button class="w-full h-full ">
            <img src="{{ asset('Icon/user-circle.svg') }}" />
          </button>
          <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
            <!-- <li>
              <a href="/pricing"><img class="w-8 h-8" src="{{ asset('Icon/money-icon.svg') }}">Membership</a>
            </li> -->
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

  <!-- JavaScript untuk Logika -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    // Elemen-elemen DOM
        const uploadInput = document.getElementById('image-upload');
        const uploadArea = document.getElementById('upload-area');
        const detectButton = document.getElementById('detect-btn');
        const resultDiv = document.getElementById('result');
        const resultText = document.getElementById('result-text');
        const resultImage = document.getElementById('result-image');
        const retryButton = document.getElementById('retry-btn');
        const deleteButton = document.getElementById('delete-btn');
        const uploadedPreview = document.createElement('img'); // Elemen untuk menampilkan gambar yang diunggah

        uploadedPreview.classList.add('max-w-full', 'rounded-lg', 'hidden', 'mb-4'); // Tambahkan kelas gaya
        uploadArea.parentNode.insertBefore(uploadedPreview, uploadArea.nextSibling); // Sisipkan di bawah form upload

        //Fungsi untuk mengetikkan teks satu per satu
        function typeText(element, text, delay = 5 ){
          return new Promise((resolve) => {
            element.innerHTML = ""; // Mengosongkan elemen sebelum mengetik
            let index = 0;

            function type() {
            if (index < text.length) {
              element.innerHTML += text[index]; // Tambahkan huruf satu per satu
              index++;
              setTimeout(type, delay); // Tunda sesuai waktu delay
            } else {
              resolve();
            }
          }
             type(); // Mulai mengetik
            });          
      
        }

        //Alert Unggah Gambar
        uploadInput.addEventListener('change', () => {
          const file = uploadInput.files[0];
          if (file) {
            //Menampilkan alert sukses jika gambar berhasil diunggah
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Gambar berhasil diunggah!",
              showConfirmButton: false,
              timer: 1500
              
            });

            
            const reader = new FileReader();
                reader.onload = function (e) {
                    uploadedPreview.src = e.target.result; // Setel sumber gambar dari file yang diunggah
                    uploadedPreview.classList.remove('hidden'); // Tampilkan gambar
                    uploadArea.classList.add('hidden'); // Sembunyikan form upload
                    deleteButton.classList.remove('hidden'); // Tampilkan tombol hapus
                };
                reader.readAsDataURL(file); // Baca file gambar sebagai URL
            }
        });

        // Alert hapus gambar
        deleteButton.addEventListener('click', () => {
            uploadInput.value = ''; // Kosongkan input file
            uploadedPreview.src = ''; // Kosongkan sumber gambar
            uploadedPreview.classList.add('hidden'); // Sembunyikan gambar pratinjau
            uploadArea.classList.remove('hidden'); // Tampilkan form upload kembali
            deleteButton.classList.add('hidden'); // Sembunyikan tombol Hapus Gambar
            // Tampilkan alert sukses untuk hapus gambar
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Gambar berhasil dihapus!",
                showConfirmButton: false,
                timer: 1500
            });
        });

        // Alert deteksi gambar
        detectButton.addEventListener('click', async () => {
            const file = uploadInput.files[0];
            if (!file) {
              //Alert jika tidak ada gambar yang diunggah
                 Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Silakan unggah gambar terlebih dahulu!",
                });
                return;
            }

            const formData = new FormData();
            formData.append('image', file);
            // Efek loading ke deteksi
            Swal.fire({
                title: "Sedang memproses...",
                html: "Harap tunggu, gambar anda sedang dianalisis.",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading(); // Tampilkan animasi loading
                },
            });


            try {
              // Mengirim permintaan ke server untuk mendeteksi gambar
                const response = await fetch("{{ route('deteksi.upload') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', //Token CSRF untuk keamanan
                    },
                    body: formData, //Gambar yang diunggah
                });

                const result = await response.json();

                // Modifikasi bagian displaySections
if (response.ok) {
    Swal.close();

    // Sembunyikan tombol
    detectButton.classList.add('hidden');
                    uploadArea.classList.add('hidden');
                    uploadedPreview.classList.add('hidden');
                    deleteButton.classList.add('hidden');
                    retryButton.classList.remove('hidden');
                    
    resultText.innerHTML = "";
    resultImage.src = result.image_url;
    resultImage.classList.remove('hidden');
    resultDiv.classList.remove('hidden');

    // Fungsi tampilkan hasil dengan efek mengetik
    async function displayResult(data) {
        // Jenis Tanaman
        const plantHeader = document.createElement("h3");
        plantHeader.classList.add("font-bold", "mb-2", "text-lg");
        resultText.appendChild(plantHeader);
        await typeText(plantHeader, "Jenis Tanaman:", 10);

        const plantContent = document.createElement("p");
        plantContent.classList.add("font-roboto", "text-black", "mb-4", "font-medium");
        resultText.appendChild(plantContent);
        await typeText(plantContent, data.jenis_tanaman, 4);

        // Kondisi
        const conditionHeader = document.createElement("h3");
        conditionHeader.classList.add("font-bold", "mb-2", "text-lg");
        resultText.appendChild(conditionHeader);
        await typeText(conditionHeader, "Kondisi:", 10);

        const conditionContent = document.createElement("p");
        conditionContent.classList.add("font-roboto", "text-black", "mb-4", "font-medium");
        resultText.appendChild(conditionContent);
        await typeText(conditionContent, data.kondisi, 4);

        // Tingkat Kepercayaan
        const confidenceHeader = document.createElement("h3");
        confidenceHeader.classList.add("font-bold", "mb-2", "text-lg");
        resultText.appendChild(confidenceHeader);
        await typeText(confidenceHeader, "Tingkat Prediksi:", 10);

        const confidenceContent = document.createElement("p");
        confidenceContent.classList.add("font-roboto", "text-black", "mb-4", "font-medium");
        resultText.appendChild(confidenceContent);
        await typeText(confidenceContent, data.confidence, 4);

        // Solusi
        const solutionHeader = document.createElement("h3");
        solutionHeader.classList.add("font-bold", "mb-2", "text-lg");
        resultText.appendChild(solutionHeader);
        await typeText(solutionHeader, "Solusi:", 10);

        const solutionContent = document.createElement("p");
        solutionContent.classList.add("font-roboto", "text-black", "mb-4", "font-medium");
        resultText.appendChild(solutionContent);
        await typeText(solutionContent, data.solusi, 4);
    }

    // Panggil fungsi dengan data dari hasil
    await displayResult(result.result);
                    
                   
                
                } else {
                  //Alert jika terjadi error pada server
                  Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: result.message || "Gagal mendeteksi gambar.",
                    });
                }
            } catch (error) {
              // Alert jika terjadi error pada koneksi
                console.error('Error:', error);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Terjadi kesalahan saat mendeteksi.",
                });
            }
        });

        // Event listener untuk tombol coba deteksi lagi
        retryButton.addEventListener('click', () => {
          //Alert coba deteksi lagi
          Swal.fire({
                position: "center",
                icon: "info",
                title: "Siap untuk deteksi baru!",
                showConfirmButton: false,
                timer: 1500
            });
            setTimeout(() => {
            // Reset tampilan untuk mencoba deteksi baru
            uploadInput.value = ''; // Kosongkan input file
            resultDiv.classList.add('hidden'); // Sembunyikan hasil deteksi
            resultText.textContent = ''; // Kosongkan teks hasil
            resultImage.src = ''; // Kosongkan URL gambar
            resultImage.classList.add('hidden'); // Sembunyikan gambar
            retryButton.classList.add('hidden'); // Sembunyikan tombol Retry
            detectButton.classList.remove('hidden'); // Tampilkan tombol Deteksi
            uploadArea.classList.remove('hidden'); // Tampilkan Form Upload
            uploadedPreview.classList.add('hidden'); // Sembunyikan gambar pratinjau
            deleteButton.classList.add('hidden'); // Sembunyikan tombol Hapus Gambar
            },1500);
        });
    });
  </script>
</body>

</html>