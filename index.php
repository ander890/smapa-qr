<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Scanner Demo</title>
</head>
<body>
<style>
    hr {
        margin-top: 32px;
    }
    input[type="file"] {
        display: block;
        margin-bottom: 16px;
    }
    div {
        margin-bottom: 16px;
    }
    #flash-toggle {
        display: none;
    }
    .myVideo {
        position: fixed;
        right: 0;
        bottom: 0;
        min-width: 100%;
        min-height: 100%;
    }

</style>
<h1></h1>
<div>
    <video id="qr-video" class="myVideo"></video>
</div>
<span id="cam-qr-result"></span>
<br>
<b></b>
<span id="cam-qr-result-timestamp"></span>


<script type="module">
    import QrScanner from "./qr-scanner.min.js";
    QrScanner.WORKER_PATH = './qr-scanner-worker.min.js';

    const video = document.getElementById('qr-video');
    const camQrResult = document.getElementById('cam-qr-result');
    const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');

    function setResult(label, result) {
        window.location = "https://scan.dvlprs.xyz/result.php?q="+result;
        scanner.stop();
        label.textContent = "REDIRECTING";
        //camQrResultTimestamp.textContent = new Date().toString();
        //label.style.color = 'teal';
        //clearTimeout(label.highlightTimeout);
        //label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
    }

    // ####### Web Cam Scanning #######

    QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

    const scanner = new QrScanner(video, result => setResult(camQrResult, result), error => {
        camQrResult.textContent = error;
        camQrResult.style.color = 'inherit';
    });
    scanner.start().then(() => {
        scanner.hasFlash().then(hasFlash => {
            camHasFlash.textContent = hasFlash;
            if (hasFlash) {
                flashToggle.style.display = 'inline-block';
                flashToggle.addEventListener('click', () => {
                    scanner.toggleFlash().then(() => flashState.textContent = scanner.isFlashOn() ? 'on' : 'off');
                });
            }
        });
    });

    // for debugging
    window.scanner = scanner;

    document.getElementById('show-scan-region').addEventListener('change', (e) => {
        const input = e.target;
        const label = input.parentNode;
        label.parentNode.insertBefore(scanner.$canvas, label.nextSibling);
        scanner.$canvas.style.display = input.checked ? 'block' : 'none';
    });

    document.getElementById('inversion-mode-select').addEventListener('change', event => {
        scanner.setInversionMode(event.target.value);
    });

    document.getElementById('start-button').addEventListener('click', () => {
        scanner.start();
    });

    document.getElementById('stop-button').addEventListener('click', () => {
        scanner.stop();
    });

    scanner.start();


    // ####### File Scanning #######

</script>
</body>
</html>