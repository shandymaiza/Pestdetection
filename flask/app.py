from flask import Flask, request, jsonify
import google.generativeai as genai
from PIL import Image
import io
import os

app = Flask(__name__)

# Konfigurasi API Key Gemini

genai.configure(api_key="AIzaSyBoPhDGL9ZL1S_NyhOyr4MFeo56AEz7pIc")

@app.route('/detect', methods=['POST'])
def detect_plant_disease():
    if 'image' not in request.files:
        return jsonify({'status': 'error', 'message': 'No image file provided.'}), 400

    # Ambil gambar dari permintaan
    image_file = request.files['image']

    try:
        # Buka gambar
        img = Image.open(image_file)

        # Inisialisasi model
        model = genai.GenerativeModel('gemini-1.5-flash')

        # Prompt untuk deteksi
        prompt = """
        Kamu adalah ahli pertanian yang sangat berpengalaman.
        Tolong identifikasi dengan format berikut:
        - **Jenis Tanaman:** 
        - **Penyakit atau Hama yang Mungkin Menyerang:** 
        - **Gejala yang Terlihat:** 
        - **Rekomendasi Penanganan:** 

        Jawab secara detail dan ilmiah.
        """

        # Kirim gambar dan prompt ke model
        response = model.generate_content([prompt, img])

        # Ambil teks hasil generasi
        result_text = response.text

        return jsonify({'status': 'success', 'result': result_text})

    except Exception as e:
        return jsonify({'status': 'error', 'message': str(e)}), 500

if __name__ == '__main__':
    app.run(port=9000, debug=True)
