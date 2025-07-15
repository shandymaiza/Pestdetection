import os
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.select import Select
import time

def test_tambah_tanaman_admin():
    driver = webdriver.Chrome()
    try:
        # 1. Login as admin
        driver.get("http://localhost:8000/login")
        print("Attempting login...")
        
        # More robust login with clear() first
        driver.find_element(By.NAME, "name").clear()
        driver.find_element(By.NAME, "name").send_keys("Admin")
        driver.find_element(By.ID, "password").clear()
        driver.find_element(By.ID, "password").send_keys("admin123")
        driver.find_element(By.TAG_NAME, "form").submit()

        # Wait for dashboard - using more reliable indicator
        print("Waiting for dashboard...")
        WebDriverWait(driver, 15).until(
            EC.presence_of_element_located((By.XPATH, "//a[contains(@href,'dashboard')]"))
        )
        print("Login successful")

        # Navigate to plant management
        print("Navigating to plant management...")
        tanaman_link = WebDriverWait(driver, 15).until(
            EC.element_to_be_clickable((By.XPATH, "//a[contains(@href,'mengelolatanaman')]"))
        )
        driver.execute_script("arguments[0].click();", tanaman_link)
        
        # Verify navigation
        WebDriverWait(driver, 15).until(
            EC.url_contains("/admin/mengelolatanaman")
        )
        print("On plant management page")

        # Open modal
        print("Opening modal...")
        tambah_button = WebDriverWait(driver, 15).until(
            EC.element_to_be_clickable((By.XPATH, "//button[contains(.,'Tambah')]"))
        )
        driver.execute_script("arguments[0].click();", tambah_button)
        
        # Force modal open if needed
        driver.execute_script("document.getElementById('my_modal_tambah').showModal();")

        # Wait for modal AND form to be ready
        print("Waiting for modal...")
        modal = WebDriverWait(driver, 15).until(
            EC.visibility_of_element_located((By.ID, "my_modal_tambah"))
        )
        
        # Additional wait for form elements
        WebDriverWait(driver, 15).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, "#my_modal_tambah form"))
        )
        time.sleep(1)  # Small delay for animations

        # DEBUG: Print modal HTML
        print("Modal HTML:", modal.get_attribute('outerHTML'))

        # Fill form - using more reliable selectors scoped to modal
        print("Filling form...")
        
        # Name field - using CSS selector scoped to modal
        name_field = WebDriverWait(driver, 15).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "#my_modal_tambah input[name='nama']"))
        )
        name_field.send_keys("Lidah buaya")
        print("Filled nama field")

        # Classification
        driver.find_element(By.CSS_SELECTOR, "#my_modal_tambah input[name='klasifikasi']").send_keys("Aloe Vera")
        
        # Dropdown - wait for options to load
        select_element = WebDriverWait(driver, 15).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "#my_modal_tambah select[name='jenis_tanaman_id']"))
        )
        Select(select_element).select_by_index(1)
        
        # File upload
        img_path = os.path.abspath("test_image/lidah_buaya.jpg")
        driver.find_element(By.CSS_SELECTOR, "#my_modal_tambah input[name='gambar']").send_keys(img_path)
        
        # Description
        deskripsi = """Tanaman ini merupakan hasil test automation dengan Selenium.
Memiliki karakteristik khusus untuk keperluan pengujian.
Dapat tumbuh di berbagai kondisi lingkungan."""
        driver.find_element(By.CSS_SELECTOR, "#my_modal_tambah textarea[name='deskripsi']").send_keys(deskripsi)

        # Submit form
        print("Submitting form...")
        submit_button = WebDriverWait(driver, 15).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "#my_modal_tambah button.bg-green-600"))
        )
        driver.execute_script("arguments[0].click();", submit_button)

        # Verify - wait for modal to close
        print("Waiting for modal to close...")
        WebDriverWait(driver, 15).until(
            EC.invisibility_of_element_located((By.ID, "my_modal_tambah"))
        )
        
        # Verify in table
        WebDriverWait(driver, 15).until(
            EC.text_to_be_present_in_element(
                (By.CSS_SELECTOR, "tbody"), 
                "Lidah buaya"
            )
        )
        print("Test completed successfully")

    except Exception as e:
        print(f"Test failed at step: {e}")
        driver.save_screenshot("test_failure.png")
        print("Screenshot saved to test_failure.png")
        raise e
    finally:
        driver.quit()