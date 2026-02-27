<?php
// Verifica se o parâmetro "url" foi passado na query string
$audio_url = isset($_GET['url']) ? $_GET['url'] : null;

// Se não houver URL, exibe uma mensagem de erro
if (!$audio_url) {
    die("Erro: Nenhum áudio foi especificado.");
}
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$is_iphone = stripos($user_agent, 'iPhone') !== false || stripos($user_agent, 'iPad') !== false || stripos($user_agent, 'iPod') !== false;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Audio Visualizer Example</title>
<style>
body {
    margin: 0;
}

.vz-wrapper {
    position: relative;
    height: 100vh;
    width: 100%;
    /*background: -webkit-gradient(radial, center center, 0, center center, 460, from(#396362), to(#000000));
    background: -webkit-radial-gradient(circle, #396362, #000000);
    background: -moz-radial-gradient(circle, #396362, #000000);
    background: -ms-radial-gradient(circle, #396362, #000000);
    box-shadow: inset 0 0 160px 0 #000;*/
    cursor: pointer;
}

.vz-wrapper.-canvas {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    height: initial;
    width: initial;
    background: transparent;
    box-shadow: none;
}

@media screen and (min-width: 420px) {
    .vz-wrapper {
        /*box-shadow: inset 0 0 200px 60px #000;*/
    }
}
</style>
</head>

<body>
    <?php if ($is_iphone === true): ?>
         <!-- Se for iPhone, exibe apenas o player padrão -->
        <audio controls autoplay>
            <source src="<?php echo htmlspecialchars($audio_url, ENT_QUOTES, 'UTF-8'); ?>" type="audio/mpeg">
            Seu navegador não suporta o elemento de áudio.
        </audio>

        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                color: white;
                font-family: Arial, sans-serif;
                margin: 0;
            }
            .player-container {
                text-align: center;
                padding: 20px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                width: 90%;
                max-width: 500px;
            }
            audio {
                width: 100%;
                max-width: 400px;
            }
        </style>

    <?php else: ?>
         <div class="vz-wrapper">
                <audio id="myAudio" src="<?php echo htmlspecialchars($audio_url, ENT_QUOTES, 'UTF-8'); ?>" data-author="DentalGo" data-title="GoTalks"></audio>

                <div class="vz-wrapper -canvas" style="border:1px red;">
                    <canvas id="myCanvas" width="800" height="400">PLAY</canvas>
                </div>
            </div>
        <script src="https://dentalgo.com.br/audioplayer/visualizer.js"></script>
    <?php endif; ?>
</body>
</html>
