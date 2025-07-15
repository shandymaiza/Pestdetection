from tensorflow.keras.models import load_model

# Path ke model lama (.h5)
model = load_model("models/combined_model.h5")  # pastikan path ini benar

# Simpan ulang model dalam format baru yang kompatibel
model.save("models/converted_model.keras")

print("Model berhasil dikonversi ke format .keras")
