<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Presensi Berhasil!</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 md:p-12 rounded-lg shadow-xl text-center max-w-md mx-auto">
    <svg class="w-16 h-16 md:w-24 md:h-24 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor"
      viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <h1 class="text-2xl md:text-3xl font-bold text-green-600 mb-3">Presensi Berhasil!</h1>
    <p class="text-gray-700 text-lg mb-6">
      {{ session('successMessage', 'Terima kasih, kehadiran Anda telah tercatat.') }}
    </p>
    <p class="text-sm text-gray-500">
      Anda bisa menutup halaman ini.
    </p>
  </div>
</body>

</html>
