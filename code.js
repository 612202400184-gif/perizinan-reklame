import data from './mockData.json';

export const fetchPengajuan = async () => {
  return new Promise((resolve) => setTimeout(() => resolve(data.pengajuan), 500)); // Simulasi delay
};

export const submitPengajuan = async (form) => {
  // Simulasi submit (update mockData)
  console.log('Submitted:', form);
};
