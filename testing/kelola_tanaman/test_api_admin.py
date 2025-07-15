import requests
import os

BASE_URL = "http://localhost:8000/api/admin/plants"
ADMIN_CREDENTIALS = {
    "Username": "Admin",
    "password": "admin123"
}

def get_admin_token():
    response = requests.post(
        "http://localhost:8000/api/admin/login",
        json=ADMIN_CREDENTIALS
    )
    return response.json()["token"]

def test_plant_crud_operations():
    # Login untuk dapatkan token
    token = get_admin_token()
    headers = {"Authorization": f"Bearer {token}"}
    
    # ===== TEST CREATE =====
    with open("testing/kelola_tanaman/test_image/lidah_buaya.jpg", "rb") as img:
        create_response = requests.post(
            BASE_URL,
            files={
                "gambar": img,
                "nama": (None, "Tanaman Test API"),
                "klasifikasi": (None, "Testus APIus"),
                "jenis_tanaman_id": (None, "1"),
                "deskripsi": (None, "Deskripsi dari API test")
            },
            headers=headers
        )
    assert create_response.status_code == 201
    plant_id = create_response.json()["id"]
    
    # ===== TEST READ =====
    get_response = requests.get(
        f"{BASE_URL}/{plant_id}",
        headers=headers
    )
    assert get_response.status_code == 200
    assert get_response.json()["Nama"] == "Tanaman Test API"
    
    # ===== TEST UPDATE =====
    update_response = requests.put(
        f"{BASE_URL}/{plant_id}",
        data={
            "nama": "Tanaman Test Updated",
            "klasifikasi": "Testus Updated",
            "jenis_tanaman_id": "1",
            "deskripsi": "Deskripsi updated"
        },
        headers=headers
    )
    assert update_response.status_code == 200
    
    # ===== TEST DELETE =====
    delete_response = requests.delete(
        f"{BASE_URL}/{plant_id}",
        headers=headers
    )
    assert delete_response.status_code == 204
    
    # Verifikasi sudah terhapus
    verify_response = requests.get(
        f"{BASE_URL}/{plant_id}",
        headers=headers
    )
    assert verify_response.status_code == 404