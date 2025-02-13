import sys
import pickle
import numpy as np
import json
import os
import warnings

warnings.filterwarnings("ignore")

MODEL_PATH = os.path.join(os.path.dirname(__file__), "model.pkl")

def load_model():
    with open(MODEL_PATH, "rb") as f:
        return pickle.load(f)

if __name__ == "__main__":
    try:
        json_file = sys.argv[1]  # Ambil file JSON dari argumen
        with open(json_file, "r", encoding="utf-8") as f:
            input_json = json.load(f)  # Baca JSON dari file
    except Exception as e:
        print(json.dumps({"error": f"Invalid JSON input: {str(e)}"}))
        sys.exit(1)

    model = load_model()
    results = []

    for item in input_json:
        gate_valve_time = float(item["gate_valve_time"])
        pressure = float(item["pressure"])
        input_data = np.array([[gate_valve_time, pressure]])
        berat_pupuk_prediksi = model.predict(input_data)[0]

        status = "On Spec" if 50.20 <= berat_pupuk_prediksi <= 50.40 else "Off Spec"

        results.append({
            "gate_valve_time": gate_valve_time,
            "pressure": pressure,
            "berat_pupuk_prediksi": berat_pupuk_prediksi,
            "status": status
        })

    print(json.dumps(results))
