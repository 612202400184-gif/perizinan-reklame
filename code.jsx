import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { useContext } from 'react';
import AuthContext from './contexts/AuthContext'; // Context untuk auth dan role
import Login from './pages/auth/Login';
import Register from './pages/auth/Register';
import DashboardPemohon from './pages/pemohon/DashboardPemohon';
import DashboardAdmin from './pages/admin/DashboardAdmin';
import DashboardPetugas from './pages/petugas/DashboardPetugas';
import DashboardKepala from './pages/kepala/DashboardKepala';
import Header from './components/common/Header';
import Sidebar from './components/common/Sidebar';

function App() {
  const { user, role } = useContext(AuthContext); // Ambil user dan role dari context

  // Protected Route berdasarkan role
  const ProtectedRoute = ({ children, allowedRoles }) => {
    if (!user) return <Navigate to="/login" />;
    if (!allowedRoles.includes(role)) return <Navigate to="/dashboard" />;
    return children;
  };

  return (
    <Router>
      {user ? (
        <div className="flex h-screen bg-gray-100">
          <Sidebar role={role} />
          <div className="flex-1 flex flex-col">
            <Header />
            <main className="p-6 overflow-auto">
              <Routes>
                <Route path="/dashboard" element={
                  role === 'pemohon' ? <DashboardPemohon /> :
                  role === 'admin' ? <DashboardAdmin /> :
                  role === 'petugas' ? <DashboardPetugas /> :
                  <DashboardKepala />
                } />
                <Route path="/pengajuan" element={<ProtectedRoute allowedRoles={['pemohon']}><FormPengajuan /></ProtectedRoute>} />
                <Route path="/verifikasi" element={<ProtectedRoute allowedRoles={['admin']}><VerifikasiPengajuan /></ProtectedRoute>} />
                <Route path="/survei" element={<ProtectedRoute allowedRoles={['petugas']}><FormSurvei /></ProtectedRoute>} />
                <Route path="/review" element={<ProtectedRoute allowedRoles={['kepala']}><ReviewSurvei /></ProtectedRoute>} />
                <Route path="*" element={<Navigate to="/dashboard" />} />
              </Routes>
            </main>
          </div>
        </div>
      ) : (
        <Routes>
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="*" element={<Navigate to="/login" />} />
        </Routes>
      )}
    </Router>
  );
}

export default App;
