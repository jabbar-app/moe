<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-D">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Presensi: {{ $attendanceList->event_name }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    #camera-container {
      position: relative;
      width: 320px;
      /* Sesuaikan ukuran */
      height: 240px;
      /* Sesuaikan ukuran */
      margin: auto;
      border: 1px solid #ccc;
      background-color: #f0f0f0;
    }

    #videoElement {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transform: scaleX(-1);
      /* Mirroring kamera depan */
    }

    #capturedImage {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transform: scaleX(-1);
      /* Mirroring juga untuk konsistensi */
    }

    .emoticon-display {
      font-size: 5rem;
      /* Ukuran emoticon besar */
      text-align: center;
      margin-bottom: 1rem;
    }

    .loader {
      border: 5px solid #f3f3f3;
      /* Light grey */
      border-top: 5px solid #3498db;
      /* Blue */
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin: 20px auto;
      display: none;
      /* Hidden by default */
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body class="bg-gray-100 py-8">
  <div class="container mx-auto max-w-lg bg-white p-6 md:p-8 rounded-lg shadow-xl">
    <h1 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-2">Presensi Kegiatan</h1>
    <h2 class="text-xl md:text-2xl text-center text-blue-600 mb-6">{{ $attendanceList->event_name }}</h2>

    @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Oops! Ada kesalahan:</strong>
        <ul class="mt-1 list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form id="checkinForm" action="{{ route('checkin.store', $token) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="displayed_emoticon" value="{{ $selectedEmoticon }}">
      <input type="hidden" name="status_at_checkin" value="{{ $currentStatusName }}">

      <div class="mb-4">
        <label for="participant_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" name="participant_name" id="participant_name" value="{{ old('participant_name') }}"
          required
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
      </div>

      <div class="mb-6">
        <label for="team_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Tim/Instansi (Opsional)</label>
        <input type="text" name="team_name" id="team_name" value="{{ old('team_name') }}"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
      </div>

      <div class="mb-4 text-center">
        <p class="text-gray-700 text-lg">Tirukan emoticon ini untuk selfie:</p>
        <div class="emoticon-display" id="emoticonToMatch">{{ $selectedEmoticon }}</div>
      </div>

      <div id="camera-container" class="mb-4">
        <video id="videoElement" autoplay playsinline></video>
        <canvas id="canvasElement" style="display:none;"></canvas> <img id="capturedImage" src="#"
          alt="Captured Image" style="display:none;" />
      </div>
      <input type="hidden" name="selfie_image_data" id="selfie_image_data">

      <div class="flex flex-col sm:flex-row justify-center items-center gap-3 mt-2 mb-6">
        <button type="button" id="startButton"
          class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Mulai Kamera
        </button>
        <button type="button" id="captureButton" disabled
          class="w-full sm:w-auto bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50">
          Ambil Foto
        </button>
        <button type="button" id="retakeButton" style="display:none;"
          class="w-full sm:w-auto bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Ulangi Foto
        </button>
      </div>

      <div class="loader" id="loader"></div>

      <button type="submit" id="submitButton" disabled
        class="w-full bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50">
        Kirim Presensi
      </button>
    </form>
  </div>

  <script>
    const video = document.getElementById('videoElement');
    const canvas = document.getElementById('canvasElement');
    const capturedImage = document.getElementById('capturedImage');
    const selfieImageDataInput = document.getElementById('selfie_image_data');

    const startButton = document.getElementById('startButton');
    const captureButton = document.getElementById('captureButton');
    const retakeButton = document.getElementById('retakeButton');
    const submitButton = document.getElementById('submitButton');
    const loader = document.getElementById('loader');
    const checkinForm = document.getElementById('checkinForm');

    let stream;

    startButton.addEventListener('click', async () => {
      try {
        stream = await navigator.mediaDevices.getUserMedia({
          video: {
            facingMode: "user"
          },
          audio: false
        });
        video.srcObject = stream;
        video.style.display = 'block';
        capturedImage.style.display = 'none';
        captureButton.disabled = false;
        startButton.style.display = 'none';
        retakeButton.style.display = 'none';
        submitButton.disabled = true;
      } catch (err) {
        console.error("Error accessing camera: ", err);
        alert("Tidak bisa mengakses kamera. Pastikan Anda memberikan izin.");
      }
    });

    captureButton.addEventListener('click', () => {
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      const context = canvas.getContext('2d');
      // Flip horizontally for mirroring
      context.translate(canvas.width, 0);
      context.scale(-1, 1);
      context.drawImage(video, 0, 0, canvas.width, canvas.height);

      const imageDataURL = canvas.toDataURL('image/jpeg', 0.8); // Kompresi ke JPEG
      selfieImageDataInput.value = imageDataURL;

      capturedImage.src = imageDataURL;
      video.style.display = 'none';
      capturedImage.style.display = 'block';

      captureButton.style.display = 'none';
      retakeButton.style.display = 'inline-block';
      submitButton.disabled = false;

      // Stop camera stream
      if (stream) {
        stream.getTracks().forEach(track => track.stop());
      }
    });

    retakeButton.addEventListener('click', () => {
      video.style.display = 'block';
      capturedImage.style.display = 'none';
      capturedImage.src = "#";
      selfieImageDataInput.value = '';

      captureButton.style.display = 'inline-block';
      retakeButton.style.display = 'none';
      submitButton.disabled = true;

      // Restart camera
      if (stream) { // If stream was stopped, restart it
        navigator.mediaDevices.getUserMedia({
            video: {
              facingMode: "user"
            },
            audio: false
          })
          .then(newStream => {
            stream = newStream;
            video.srcObject = stream;
          })
          .catch(err => {
            console.error("Error restarting camera: ", err);
            alert("Tidak bisa mengakses kamera. Pastikan Anda memberikan izin.");
          });
      }
    });

    checkinForm.addEventListener('submit', function() {
      submitButton.disabled = true;
      loader.style.display = 'block';
    });
  </script>
</body>

</html>
