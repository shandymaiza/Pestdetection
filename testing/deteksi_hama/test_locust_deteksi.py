from locust import HttpUser, task, between
from bs4 import BeautifulSoup

class WebsiteUser(HttpUser):
    wait_time = between(1, 3)

    @task
    def upload_and_detect(self):
        print("=== TASK DIMULAI ===")

        # 1. GET /login (ambil CSRF token)
        login_page = self.client.get("/login", name="GET /login", allow_redirects=True)
        print("LOGIN PAGE STATUS:", login_page.status_code)

        # Print isi awal halaman login
        print("=== CUplikan Halaman Login ===")
        print(login_page.text[:1000])

        soup = BeautifulSoup(login_page.text, "html.parser")
        csrf_token_input = soup.find("input", {"name": "_token"})

        if csrf_token_input:
            csrf_token = csrf_token_input.get("value")
            print("Token CSRF ditemukan di input hidden:")
            print(csrf_token_input)
        else:
            print("Login token CSRF tidak ditemukan di halaman login!")
            return

        # 2. POST login
        login_data = {
            "_token": csrf_token,
            "name": "contoh",             # ganti jika bukan 'name'
            "password": "zU8@fR2k$9P"
        }

        login_response = self.client.post("/login", data=login_data, name="POST /login", allow_redirects=True)
        print("LOGIN RESPONSE STATUS:", login_response.status_code)

        if "dashboard" not in login_response.text.lower():
            print("Login gagal")
            return

        # 3. GET /user/d untuk ambil token upload
        deteksi_page = self.client.get("/user/d", name="GET /user/d")
        print("=== HTML dari /user/d ===")
        print(deteksi_page.text[:1000])

        soup = BeautifulSoup(deteksi_page.text, "html.parser")
        token_input = soup.find("meta", {"name": "csrf-token"}) or soup.find("input", {"name": "_token"})

        detect_token = (
            token_input.get("content") if token_input and token_input.has_attr("content")
            else token_input.get("value") if token_input else None
        )

        print("=== CSRF TOKEN DETEKSI ===")
        print(detect_token)

        if not detect_token:
            print("CSRF token deteksi tidak ditemukan!")
            return

        # 4. Kirim gambar
        image_path = "test_image/sample_plant.jpg"
        try:
            with open(image_path, "rb") as img:
                files = {
                    "image": ("sample_plant.jpg", img, "image/jpeg")
                }
                headers = {
                    "X-CSRF-TOKEN": detect_token
                }
                response = self.client.post("/user/d/upload", files=files, headers=headers, name="POST /user/d/upload")
                print("UPLOAD STATUS:", response.status_code)
                print("RESPONSE:", response.text)
        except FileNotFoundError:
            print("Gambar tidak ditemukan:", image_path)


