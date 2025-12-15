function Sidebar({ role }) {
  const menu = {
    pemohon: ['Dashboard', 'Pengajuan', 'Status'],
    admin: ['Dashboard', 'Verifikasi', 'Tugaskan Petugas'],
    petugas: ['Dashboard', 'Tugas Survei', 'Laporan'],
    kepala: ['Dashboard', 'Review', 'Terbitkan SK'],
  };

  return (
    <aside className="w-64 bg-gray-800 text-white p-4 hidden md:block">
      <h2 className="text-lg font-bold mb-4">Menu {role}</h2>
      <ul className="space-y-2">
        {menu[role]?.map((item) => (
          <li key={item}>
            <a href="#" className="block py-2 px-4 rounded hover:bg-gray-700">
              {item}
            </a>
          </li>
        ))}
      </ul>
    </aside>
  );
}

export default Sidebar;
