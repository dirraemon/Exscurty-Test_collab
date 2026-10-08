<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $exam->title ?? 'Halaman Ujian' }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin-top: 0;
        }

        .exam-info {
            color: #555;
        }

        .timer {
            background: #222;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .questions,
        .webcam {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        .question {
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .question h3 {
            margin-top: 0;
        }

        .answer {
            margin: 10px 0;
        }

        .webcam-box {
            width: 100%;
            height: 250px;
            background: #222;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            overflow: hidden;
        }

        .webcam-box video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .camera-status {
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        .submit-button {
            margin-top: 20px;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background: #198754;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-button:hover {
            background: #157347;
        }
    </style>
</head>

<body>

<div class="container">

    {{-- Informasi Ujian --}}
    <div class="header">

        <h1>
            {{ $exam->title ?? 'Ujian Peserta' }}
        </h1>

        @if($exam)

            <p class="exam-info">
                {{ $exam->description ?? 'Tidak ada deskripsi ujian.' }}
            </p>

            <p class="exam-info">
                Durasi:
                {{ $exam->duration_minutes ?? 0 }} menit
            </p>

        @else

            <p class="exam-info">
                Belum ada data ujian.
            </p>

        @endif

    </div>


    {{-- Countdown Timer --}}
    <div class="timer">
        <span id="timer">00:00:00</span>
    </div>


    <div class="content">

        {{-- Bagian Soal --}}
        <div class="questions">

            <h2>Soal Ujian</h2>


            {{-- Soal 1 --}}
            <div class="question">

                <h3>
                    1. Apa fungsi utama dari sistem operasi?
                </h3>

                <div class="answer">
                    <label>
                        <input type="radio" name="question1" value="A">
                        A. Mengelola sumber daya komputer
                    </label>
                </div>

                <div class="answer">
                    <label>
                        <input type="radio" name="question1" value="B">
                        B. Membuat desain grafis
                    </label>
                </div>

                <div class="answer">
                    <label>
                        <input type="radio" name="question1" value="C">
                        C. Membuat koneksi internet
                    </label>
                </div>

                <div class="answer">
                    <label>
                        <input type="radio" name="question1" value="D">
                        D. Menghapus semua data komputer
                    </label>
                </div>

            </div>


            {{-- Soal 2 --}}
            <div class="question">

                <h3>
                    2. Manakah yang termasuk perangkat input?
                </h3>

                <div class="answer">
                    <label>
                        <input type="radio" name="question2" value="A">
                        A. Monitor
                    </label>
                </div>

                <div class="answer">
                    <label>
                        <input type="radio" name="question2" value="B">
                        B. Keyboard
                    </label>
                </div>

                <div class="answer">
                    <label>
                        <input type="radio" name="question2" value="C">
                        C. Speaker
                    </label>
                </div>

                <div class="answer">
                    <label>
                        <input type="radio" name="question2" value="D">
                        D. Printer
                    </label>
                </div>

            </div>


            {{-- Soal 3 --}}
            <div class="question">

                <h3>
                    3. Apa kepanjangan dari CPU?
                </h3>

                <div class="answer">
                    <label>
                        <input type="radio" name="question3" value="A">
                        A. Central Processing Unit
                    </label>
                </div>

                <div class="answer">
                    <label>
                        <input type="radio" name="question3" value="B">
                        B. Computer Processing User
                    </label>
                </div>

                <div class="answer">
                    <label>
                        <input type="radio" name="question3" value="C">
                        C. Central Program Utility
                    </label>
                </div>

                <div class="answer">
                    <label>
                        <input type="radio" name="question3" value="D">
                        D. Computer Program Unit
                    </label>
                </div>

            </div>

        </div>


        {{-- Bagian Webcam --}}
        <div class="webcam">

            <h2>Webcam</h2>

            <div class="webcam-box">
                <video id="webcam" autoplay playsinline></video>
            </div>

            <div id="status" class="camera-status">
                Menghubungkan ke kamera...
            </div>

            <button
                class="submit-button"
                type="button"
                onclick="submitExam()"
            >
                Kumpulkan Jawaban
            </button>

        </div>

    </div>

</div>


{{-- Countdown Timer --}}
<script>
    let timeRemaining = 60;

    const timerElement = document.getElementById('timer');

    const timerInterval = setInterval(function () {

        let hours = Math.floor(timeRemaining / 3600);
        let minutes = Math.floor((timeRemaining % 3600) / 60);
        let seconds = timeRemaining % 60;

        timerElement.textContent =
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');

    if (timeRemaining <= 0) {
        clearInterval(timerInterval);
        alert('Waktu ujian telah habis. Jawaban akan dikumpulkan otomatis.');
        submitExam();
        return;
}

        timeRemaining--;

    }, 1000);
</script>


{{-- Webcam --}}
<script>

    const videoElement = document.getElementById('webcam');

    const statusElement = document.getElementById('status');

    let mediaStream = null;


    async function startCamera() {

        try {

            statusElement.innerText =
                "Meminta izin akses webcam...";


            mediaStream =
                await navigator.mediaDevices.getUserMedia({

                    video: {
                        width: 1280,
                        height: 720
                    },

                    audio: false

                });


            videoElement.srcObject = mediaStream;


            statusElement.innerText =
                "Kamera berhasil terhubung!";

            statusElement.style.color =
                "green";


        } catch (error) {

            console.error(
                "Gagal mengakses kamera:",
                error
            );


            statusElement.innerText =
                "Gagal mengakses kamera. Periksa izin atau koneksi webcam.";

            statusElement.style.color =
                "red";

        }

    }


    window.addEventListener('load', function () {

        startCamera();

    });

</script>


{{-- Submit Ujian --}}
<script>
    function submitExam() {

        const confirmation = confirm(
            'Apakah Anda yakin ingin mengumpulkan jawaban ujian?'
        );

        if (!confirmation) {
            return;
        }

        // Hentikan timer jika sedang berjalan
        if (typeof timerInterval !== 'undefined') {
            clearInterval(timerInterval);
        }

        // Hentikan webcam
        if (typeof mediaStream !== 'undefined' && mediaStream) {
            mediaStream.getTracks().forEach(function(track) {
                track.stop();
            });

            if (typeof videoElement !== 'undefined') {
                videoElement.srcObject = null;
            }
        }

        alert('Jawaban ujian berhasil dikumpulkan.');

        const submitButton = document.querySelector('.submit-button');

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerText = 'Ujian Telah Dikumpulkan';
        }
    }
</script>

</script>

</body>
</html>