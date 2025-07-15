import os
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options
import time

def test_deteksi_hama():
    chrome_options = Options()
    # chrome_options.add_argument("--headless=new")
    chrome_options.add_argument("--disable-infobars")
    chrome_options.add_argument("--disable-notifications")
    chrome_options.add_argument("--no-sandbox")
    chrome_options.add_argument("--disable-dev-shm-usage")
    chrome_options.add_argument("--disable-blink-features=AutomationControlled")
    chrome_options.add_experimental_option("excludeSwitches", ["enable-automation"])
    chrome_options.add_experimental_option("useAutomationExtension", False)
    chrome_options.add_experimental_option("prefs", {
        "credentials_enable_service": False,
        "profile.password_manager_enabled": False,
        "safebrowsing.enabled": False
    })

    driver = webdriver.Chrome(options=chrome_options)
    try:
        # 1. Login as user
        driver.get("http://localhost:8000/login")
        print("Attempting login...")

        time.sleep(2)

        driver.find_element(By.NAME, "name").clear()
        driver.find_element(By.NAME, "name").send_keys("contoh")
        driver.find_element(By.ID, "password").clear()
        driver.find_element(By.ID, "password").send_keys("zU8@fR2k$9P")
        driver.find_element(By.TAG_NAME, "form").submit()

        time.sleep(2)
        print("Current URL after login:", driver.current_url)

        WebDriverWait(driver, 15).until(
            EC.url_contains("/user/d")
        )
        print("Login succesful")

        # Upload gambar
        script_dir = os.path.dirname(os.path.abspath(__file__))
        image_path = os.path.join(script_dir, "test_image", "sample_plant.jpg")

        if not os.path.isfile(image_path):
            raise FileNotFoundError(f"Gambar tidak ditemukan: {image_path}")

        file_input = driver.find_element(By.ID, "image-upload")
        file_input.send_keys(image_path)
        print("Gambar berhasil diupload.")

        # Klik tombol Deteksi
        detect_btn = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "detect-btn"))
        )

        # Tunggu swal2 menghilang
        WebDriverWait(driver, 10).until(
            EC.invisibility_of_element_located((By.CLASS_NAME, "swal2-container"))
        )
        detect_btn = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "detect-btn"))
        )
        detect_btn.click()
        print("Tombol Deteksi diklik.")

        # Tunggu hasil deteksi muncul
        WebDriverWait(driver, 15).until(
            EC.visibility_of_element_located((By.ID, "result"))
        )
        print("Hasil deteksi muncul.")

        # Verifikasi hasil deteksi
        result_text = driver.find_element(By.ID, "result-text").text
        print("Teks hasil deteksi:", result_text)
        assert len(result_text.strip()) > 0, "Teks hasil deteksi kosong!"

        time.sleep(10)

    finally:
        driver.quit()
