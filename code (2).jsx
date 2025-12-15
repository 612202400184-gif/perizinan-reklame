import { useState } from 'react';
import { submitPengajuan } from '../services/api'; // Dummy submit

function FormPengajuan() {
  const [form, setForm] = useState({ jenis: '', ukuran: '', lokasi: '', file: null });

  const handleSubmit = (e) => {
    e.preventDefault();
    submitPengajuan(form); // Simulasi submit
    alert('Pengajuan berhasil!');
  };

  return (
    <div className="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
      <h2 className="text-xl font-bold mb-4">Form Pengajuan Izin Reklame</h2>
      <form onSubmit={handleSubmit} className="space-y-4">
        <input
          type="text"
          placeholder="Jenis Reklame"
          value={form.jenis}
          onChange={(e) => setForm({ ...form, jenis: e.target.value })}
          className="w-full p-2 border rounded"
          required
        />
        <input
          type="text"
          placeholder="Ukuran"
          value={form.ukuran}
          onChange={(e) => setForm({ ...form, ukuran: e.target.value })}
          className="w-full p-2 border rounded"
          required
        />
        <input
          type="text"
          placeholder="Lokasi"
          value={form.lokasi}
          onChange={(e) => setForm({ ...form, lokasi: e.target.value })}
          className="w-full p-2 border rounded"
          required
        />
        <input
          type="file"
          onChange={(e) => setForm({ ...form, file: e.target.files[0] })}
          className="w-full p-2 border rounded"
          required
        />
        <button type="submit" className="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">
          Ajukan
        </button>
      </form>
    </div>
  );
}

export default FormPengajuan;
