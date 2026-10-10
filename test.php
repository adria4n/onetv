<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reproductor OneTV</title>

  <script src="https://cdn.jsdelivr.net/npm/hls.js@1"></script>

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      background: #000;
      color: #fff;
      font-family: Arial, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      padding: 16px 20px;
      font-size: 20px;
      font-weight: bold;
      border-bottom: 1px solid #222;
    }

    main {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 15px;
    }

    .player {
      width: 100%;
      max-width: 1100px;
      background: #000;
    }

    video {
      display: block;
      width: 100%;
      aspect-ratio: 16 / 9;
      background: #000;
      border-radius: 8px;
    }

    #estado {
      color: #aaa;
      font-size: 14px;
      margin-top: 15px;
      text-align: center;
    }
  </style>
</head>

<body>
  <header>OneTV</header>

  <main>
    <div class="player">
      <video id="video"
             controls
             autoplay
             playsinline
             preload="auto">
      </video>
    </div>

    <div id="estado">Conectando con el canal...</div>
  </main>

  <script>
    const video = document.getElementById("video");
    const estado = document.getElementById("estado");

    const url =
      "https://channel01-onlymex.akamaized.net/hls/live/2022749/event01/index.m3u8";

    if (Hls.isSupported()) {
      const hls = new Hls();

      hls.loadSource(url);
      hls.attachMedia(video);

      hls.on(Hls.Events.MANIFEST_PARSED, function () {
        estado.textContent = "Canal listo";
        video.play().catch(() => {
          estado.textContent = "Pulsa Play para comenzar";
        });
      });

      hls.on(Hls.Events.ERROR, function (event, data) {
        if (data.fatal) {
          estado.textContent =
            "No se pudo reproducir el canal. Comprueba el enlace o la conexión.";
          hls.destroy();
        }
      });

    } else if (
      video.canPlayType("application/vnd.apple.mpegurl")
    ) {
      video.src = url;

      video.addEventListener("loadedmetadata", function () {
        estado.textContent = "Canal listo";
        video.play().catch(() => {
          estado.textContent = "Pulsa Play para comenzar";
        });
      });

      video.addEventListener("error", function () {
        estado.textContent = "No se pudo cargar el canal.";
      });

    } else {
      estado.textContent =
        "Tu navegador no es compatible con la reproducción HLS.";
    }
  </script>
</body>
</html>
