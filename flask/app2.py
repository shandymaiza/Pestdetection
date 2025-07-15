from flask import Flask, request, jsonify
from PIL import Image
import numpy as np
import os
import json
import traceback
import tensorflow as tf
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, Conv2D, MaxPooling2D, Flatten, Dropout


app = Flask(__name__)

# Load model joblib dari folder models dengan error handling
try:
    MODEL_PATH = os.path.join(os.path.dirname(__file__), 'models', 'combined_model.h5')
    CLASS_INDICES_PATH = os.path.join(os.path.dirname(__file__), 'models', 'class_indices.json')

    print("Loading model from:", MODEL_PATH)
    model = load_model(MODEL_PATH)
    print("Model loaded successfully!")

    with open(CLASS_INDICES_PATH, 'r') as f:
        class_indices = json.load(f)
    print("Class indices loaded:", class_indices)

except Exception as e:
    print(f"Error loading model or class indices: {str(e)}")
    raise

solutions = {
    'Pepper__bell___Bacterial_spot':'Solusi: \n1. Gunakan fungisida berbasis tembaga secara berkala dengan dosis yang direkomendasikan.\n2. Lakukan rotasi tanaman dengan jenis yang tidak rentan terhadap penyakit ini.\n3. Hindari penyiraman dari atas untuk mencegah penyebaran bakteri melalui air.\n4. Buang dan musnahkan tanaman yang terinfeksi parah untuk mencegah penyebaran.\n5. Bersihkan alat-alat pertanian secara teratur untuk mengurangi kontaminasi.',
    'Pepper__bell___healthy': 'Tanaman sehat. Lanjutkan perawatan rutin:\n1. Penyiraman secukupnya, hindari genangan air.\n2. Pemupukan seimbang sesuai fase pertumbuhan tanaman.\n3. Pemangkasan rutin untuk meningkatkan sirkulasi udara.\n4. Monitoring kondisi tanaman untuk deteksi dini penyakit atau hama.',
    'Potato___Early_blight': 'Solusi:\n1. Gunakan fungisida berbasis chlorothalonil atau azoxystrobin sesuai rekomendasi.\n2. Lakukan rotasi tanaman setiap musim untuk mengurangi akumulasi patogen di tanah.\n3. Buang daun yang terinfeksi dan musnahkan jauh dari area tanam.\n4. Jaga jarak antar tanaman untuk meningkatkan sirkulasi udara.\n5. Terapkan mulsa organik untuk mencegah spora naik ke daun.',
    'Potato___Late_blight': 'Solusi:\n1. Aplikasikan fungisida berbasis tembaga atau metalaxyl secara preventif.\n2. Tingkatkan sirkulasi udara dengan mengatur jarak tanam yang cukup.\n3. Hindari kelembaban tinggi dengan tidak menyiram langsung pada daun.\n4. Buang tanaman yang terinfeksi parah untuk mencegah penyebaran penyakit.\n5. Pastikan area tanam bebas dari gulma untuk mengurangi tempat berkembangnya patogen.',
    'Potato___healthy': 'Tanaman sehat. Pertahankan kondisi dengan:\n1. Penyiraman teratur dengan volume yang tepat.\n2. Pemupukan seimbang dengan memperhatikan kebutuhan nitrogen, fosfor, dan kalium.\n3. Pengendalian gulma secara rutin untuk menghindari kompetisi nutrisi.\n4. Monitoring rutin untuk mendeteksi potensi serangan hama atau penyakit.\n5. Pastikan rotasi tanaman dilakukan secara berkala.',
    'Tomato_Bacterial_spot': 'Solusi:\n1. Aplikasikan fungisida berbasis tembaga sesuai dosis anjuran.\n2. Hindari penyiraman dari atas untuk mencegah penyebaran bakteri.\n3. Lakukan rotasi tanaman dengan jenis yang tidak rentan terhadap penyakit ini.\n4. Gunakan benih bersertifikat bebas penyakit.\n5. Bersihkan dan sterilisasi alat-alat pertanian sebelum digunakan.',
    'Tomato_Early_blight': 'Solusi:\n1. Gunakan fungisida berbasis chlorothalonil atau mancozeb sesuai petunjuk.\n2. Buang daun yang terinfeksi secara teratur dan musnahkan.\n3. Jaga jarak tanam untuk meningkatkan sirkulasi udara.\n4. Gunakan mulsa organik untuk mencegah penyebaran spora dari tanah ke daun.\n5. Hindari penyiraman berlebihan yang menyebabkan kelembaban tinggi.',
    'Tomato_Late_blight': 'Solusi:\n1. Aplikasikan fungisida sistemik seperti metalaxyl-m sesuai anjuran.\n2. Tingkatkan sirkulasi udara dengan mengatur jarak tanam dan pemangkasan.\n3. Kurangi kelembaban dengan sistem irigasi tetes.\n4. Lakukan sanitasi kebun secara berkala untuk mencegah akumulasi patogen.\n5. Hindari penggunaan tanaman inang di sekitar area tanam.',
    'Tomato_Leaf_Mold': 'Solusi:\n1. Kurangi kelembaban udara dengan meningkatkan ventilasi di sekitar tanaman.\n2. Gunakan kipas atau alat ventilasi jika tanaman berada di greenhouse.\n3. Aplikasikan fungisida berbasis sulfur atau chlorothalonil sesuai kebutuhan.\n4. Buang dan musnahkan daun yang terinfeksi.\n5. Monitor kondisi tanaman secara rutin untuk mencegah penyebaran lebih lanjut.',
    'Tomato_Septoria_leaf_spot': 'Solusi:\n1. Aplikasikan fungisida berbasis mancozeb atau chlorothalonil.\n2. Buang daun yang terinfeksi segera dan musnahkan.\n3. Gunakan mulsa organik untuk mengurangi cipratan tanah ke daun.\n4. Rotasi tanaman setiap musim untuk mengurangi akumulasi patogen di tanah.\n5. Pilih varietas yang tahan terhadap penyakit ini jika memungkinkan.',
    'Tomato_Spider_mites_Two_spotted_spider_mite': 'Solusi:\n1. Gunakan akarisida yang direkomendasikan dan aman untuk tanaman.\n2. Semprotkan air bertekanan tinggi pada bagian bawah daun untuk mengusir hama.\n3. Introduksi predator alami seperti kumbang predator atau tungau predator.\n4. Jaga kelembaban lingkungan untuk mengurangi populasi tungau.\n5. Bersihkan gulma dan sisa tanaman di sekitar area tanam.',
    'Tomato__Target-Spot': 'Solusi:\n1. Kurangi kelembaban udara dengan meningkatkan ventilasi di sekitar tanaman.\n2. Gunakan kipas atau alat ventilasi jika tanaman berada di greenhouse.\n3. Aplikasikan fungisida berbasis sulfur atau chlorothalonil sesuai kebutuhan.\n4. Buang dan musnahkan daun yang terinfeksi.\n5. Monitor kondisi tanaman secara rutin untuk mencegah penyebaran lebih lanjut.',
    'Tomato__mosaic-virus': 'Solusi:\n1. Kurangi kelembaban udara dengan meningkatkan ventilasi di sekitar tanaman.\n2. Gunakan kipas atau alat ventilasi jika tanaman berada di greenhouse.\n3. Aplikasikan fungisida berbasis sulfur atau chlorothalonil sesuai kebutuhan.\n4. Buang dan musnahkan daun yang terinfeksi.\n5. Monitor kondisi tanaman secara rutin untuk mencegah penyebaran lebih lanjut.',
    'Tomato_YellowLeaf_Curl_virus': 'Solusi:\n1. Kurangi kelembaban udara dengan meningkatkan ventilasi di sekitar tanaman.\n2. Gunakan kipas atau alat ventilasi jika tanaman berada di greenhouse.\n3. Aplikasikan fungisida berbasis sulfur atau chlorothalonil sesuai kebutuhan.\n4. Buang dan musnahkan daun yang terinfeksi.\n5. Monitor kondisi tanaman secara rutin untuk mencegah penyebaran lebih lanjut.',
    'Tomato_healty': 'Tanaman sehat. Lanjutkan perawatan rutin:\n1. Penyiraman secukupnya, hindari genangan air.\n2. Pemupukan seimbang sesuai fase pertumbuhan tanaman.\n3. Pemangkasan rutin untuk meningkatkan sirkulasi udara.\n4. Monitoring kondisi tanaman untuk deteksi dini penyakit atau hama.',
    'Cassava__healty': 'Solusi:\n1. Aplikasikan fungisida sistemik seperti metalaxyl-m sesuai anjuran.\n2. Tingkatkan sirkulasi udara dengan mengatur jarak tanam dan pemangkasan.\n3. Kurangi kelembaban dengan sistem irigasi tetes.\n4. Lakukan sanitasi kebun secara berkala untuk mencegah akumulasi patogen.\n5. Hindari penggunaan tanaman inang di sekitar area tanam.',
    'Cassava__bacterial_blight': 'Solusi:\n1. Kurangi kelembaban udara dengan meningkatkan ventilasi di sekitar tanaman.\n2. Gunakan kipas atau alat ventilasi jika tanaman berada di greenhouse.\n3. Aplikasikan fungisida berbasis sulfur atau chlorothalonil sesuai kebutuhan.\n4. Buang dan musnahkan daun yang terinfeksi.\n5. Monitor kondisi tanaman secara rutin untuk mencegah penyebaran lebih lanjut.',
    'Cassava__green_mottle': 'Solusi:\n1. Aplikasikan fungisida berbasis mancozeb atau chlorothalonil.\n2. Buang daun yang terinfeksi segera dan musnahkan.\n3. Gunakan mulsa organik untuk mengurangi cipratan tanah ke daun.\n4. Rotasi tanaman setiap musim untuk mengurangi akumulasi patogen di tanah.\n5. Pilih varietas yang tahan terhadap penyakit ini jika memungkinkan.',
    'Cassava__brown_streak_disease': 'Solusi:\n1. Gunakan akarisida yang direkomendasikan dan aman untuk tanaman.\n2. Semprotkan air bertekanan tinggi pada bagian bawah daun untuk mengusir hama.\n3. Introduksi predator alami seperti kumbang predator atau tungau predator.\n4. Jaga kelembaban lingkungan untuk mengurangi populasi tungau.\n5. Bersihkan gulma dan sisa tanaman di sekitar area tanam.',
}


def predict_disease(img):
    img = img.resize((128, 128))
    img_array = image.img_to_array(img) / 255.0
    img_array = np.expand_dims(img_array, axis=0)

    predictions = model.predict(img_array)
    predicted_class_index = np.argmax(predictions)

    class_mapping = {v: k for k, v in class_indices.items()}
    predicted_class = class_mapping.get(predicted_class_index, "Unknown")

    print(f"Predicted index: {predicted_class_index}")
    print(f"Predicted class: {predicted_class}")

    solution = solutions.get(predicted_class, "Solusi tidak tersedia untuk kategori ini.")
    confidence = float(np.max(predictions)) * 100

    plant_parts = predicted_class.split('_')
    plant_type = plant_parts[0]
    condition = ' '.join(plant_parts[1:])

    return {
        'jenis_tanaman': plant_type,
        'kondisi': condition,
        'solusi': solution,
        'confidence': confidence
    }

@app.route('/detect', methods=['POST'])
def detect_plant_disease():
    if 'image' not in request.files:
        return jsonify({
            'status': 'error',
            'message': 'Tidak ada file gambar yang diunggah.'
        }), 400

    try:
        image_file = request.files['image']
        img = Image.open(image_file)

        result = predict_disease(img)

        return jsonify({
            'status': 'success',
            'result': {
                'jenis_tanaman': result['jenis_tanaman'],
                'kondisi': result['kondisi'],
                'solusi': result['solusi'],
                'confidence': f"{result['confidence']:.2f}%"
            }
        })

    except Exception as e:
        traceback.print_exc()
        return jsonify({
            'status': 'error',
            'message': f'Terjadi kesalahan: {str(e)}'
        }), 500

if __name__ == '__main__':
    app.run(port=9001, debug=True)
