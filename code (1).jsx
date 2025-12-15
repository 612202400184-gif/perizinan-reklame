import { useState, useEffect } from 'react';
import { fetchPengajuan } from '../services/api'; // Dummy fetch
import StatusBadge from '../components/ui/StatusBadge';

function DashboardPemohon() {
  const [pengajuan, setPengajuan] = useState([]);

  useEffect(() => {
    fetchPengajuan().then(setPengajuan); // Load data dummy
  }, []);

  return (
    <div className="space-y-6">
      <h1 className="text-2xl font-bold text-gray-800">Dashboard Pemohon</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {pengajuan.map((item) => (
          <div key={item.id} className="bg-white p-4 rounded-lg shadow-md">
            <h3 className="font-semibold">{item.jenisReklame}</h3>
            <p>Lokasi: {item.lokasi}</p>
            <StatusBadge status={item.status} />
            {item.status === 'disetujui' && (
              <button className="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Download SK
              </button>
            )}
          </div>
        ))}
      </div>
    </div>
  );
}

export default DashboardPemohon;
