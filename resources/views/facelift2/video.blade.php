<?php
$paginaTitulo = $video->title . ' - DentalGo';
$padinaDescricao = '';

$tipoTopo = 'topoVermelho';
/*
function array_para_csv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
}

function cabecalho_download_csv($filename) {
    // desabilitar cache
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // forçar download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposição do texto / codificação
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

$videoContent = array();
foreach ($video->productItems as $key => $value) {
    $videoContent[$key]['id'] = $value->id;
    $videoContent[$key]['content'] = $value->content;
}

cabecalho_download_csv($video->title . date("Y-m-d") . ".csv");
echo array_para_csv($videoContent);
die();*/

foreach ($videos as $key => $value) {
    if ($value->id == $video->id) {
        $imagemBanner = $value->cover;
    }
}


$permicao = 7;

if (session()->get('usuarioPermissao') == 'naotem') {
    $modalConteudo = 'espacoParaAssinantes';
} elseif (session()->get('usuarioPermissao') == 'naotemVencido') {
    $dataVencimento = date(session()->get('usuario')->subscription->isValidUntil);
    $dataVencimento = explode('UTC', $dataVencimento);

    $dataAtual = date("Y-m-d");
    if ($dataVencimento[0] >= $dataAtual) {
        $modalConteudo = 'permitido';
    } else {
        $modalConteudo = 'renoveOplano';
    }
} elseif (session()->get('usuarioPermissao') == 'naotemSemPlano') {
    $modalConteudo = 'vamosAssinar';
} elseif (is_array(session()->get('usuarioPermissao'))) {
    if (in_array($permicao, session()->get('usuarioPermissao'))) {
        $modalConteudo = 'permitido';
    } else {
        $modalConteudo = 'espacoParaAssinantes';
    }
} else {
    $modalConteudo = 'espacoParaAssinantes';
}



$briefVideo = explode('™', $video->brief);
$briefVideoTexto = explode('ŧ', strval($briefVideo[0]));

?>

@extends('facelift2.master')

@section('content')

    <!-- Main Page Wrapper for Light Theme Isolation -->
    <div class="premium-light-theme">

        <!-- Hero Banner -->
        <div class="container-fluid produtoTopo videoBanner page-banner"
            style="background-image: url('{{ asset($imagemBanner) }}') !important;">
            <div class="banner-overlay"></div>
            <div class="container containerColecao">
                <div class="row">
                    <div class="col-lg-8 col-md-10 banner-content">
                        <h1 class="banner-title flow-text">{{$video->title}}</h1>
                        <h2 class="banner-subtitle">
                            @foreach ($briefVideoTexto as $bfTexto)
                                {{ $bfTexto }}<br />
                            @endforeach
                        </h2>

                        <div class="banner-meta">
                            <div class="meta-pill">
                                <i class="fa-solid fa-stopwatch"></i>
                                <span>{{$briefVideo[1]}}</span>
                            </div>
                            <div class="meta-pill">
                                <i class="fa-solid fa-file-lines"></i>
                                <span>{{$briefVideo[2]}}</span>
                            </div>
                            <div class="meta-pill highlight">
                                <i class="fa-solid fa-circle-play"></i>
                                <span>{{$briefVideo[3]}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Grid Section -->
        <div class="container content-section">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-header main-header">
                        <h1>{{ $video->title }}</h1>
                        <div class="header-line"></div>
                    </div>
                </div>

                <div class="row card-grid g-4">
                    @foreach ($video->productItems as $key => $video)
                                    <?php
                        if (empty($video->content)) {
                            $hashVideo = '';
                        } else {
                            $hashVideo = explode('/', $video->content);
                            $hashVideo = $hashVideo[2];
                        }
                                                                                                ?>
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-3 video-card-wrapper">
                                        @if($modalConteudo == 'permitido')
                                            <button id="VideoId{{$video->id}}" class="video-card-btn" data-bs-toggle="modal"
                                                data-bs-target="#modalVideo" data-src="{{ $hashVideo }}">
                                        @else
                                                <button class="video-card-btn" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">
                                            @endif
                                                <div class="card-inner">
                                                    <div class="card-image-box">
                                                        <img src="{{ $video->cover }}" class="video-thumb" alt="{{ $video->title }}">
                                                        <div class="hover-overlay">
                                                            <div class="play-icon-circle">
                                                                <i class="fa-solid fa-play"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-info">
                                                        <h4 class="video-item-title">{{ $video->title }}</h4>
                                                        <span class="watch-text">Assistir agora</span>
                                                    </div>
                                                </div>
                                            </button>
                                    </div>
                    @endforeach
                </div>

                <!-- Video Modal -->
                <div class="modal fade" id="modalVideo" tabindex="-1" aria-labelledby="modalVideoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-white">
                        <div class="modal-content">
                            <div class="modal-header-custom">
                                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div class="modal-body p-0">
                                <iframe class="embed-responsive-item" src="{{ route('faceloadingvideo') }}" id="video"
                                    allowscriptaccess="always" allow="autoplay" width="100%" height="500px" frameborder="0"
                                    allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" data-ready="true"
                                    loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End Light Theme Wrapper -->


    <style type="text/css">
        /* Ensure modal is above topbar (z-index 1200) */
        .modal-backdrop {
            z-index: 2050 !important;
        }

        .modal {
            z-index: 2060 !important;
        }

        /* Theme Variables - LIGHT MODE */
        :root {
            --page-bg: #f8f9fa;
            /* Light Gray Background */
            --card-bg: #ffffff;
            --text-primary: #212529;
            /* Dark distinct text */
            --text-secondary: #6c757d;
            --accent-color: #CA1D53;
            /* Vibrant Green */
            --accent-hover: #CA1D53;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            --card-shadow-hover: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        /* Global Reset within wrapper */
        .premium-light-theme {
            font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--page-bg);
            color: var(--text-primary);
            min-height: 100vh;
            width: 100%;
        }

        /* Hero Banner */
        .page-banner {
            position: relative;
            background-size: cover;
            background-position: center;
            min-height: 60vh;
            display: flex;
            align-items: flex-end;
            padding-bottom: 60px;
            margin-bottom: 0;
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Dark gradient is still needed for text visibility on bg images */
            background: linear-gradient(0deg, var(--page-bg) 0%, rgba(0, 0, 0, 0.6) 50%, rgba(0, 0, 0, 0.4) 100%);
            z-index: 1;
        }

        .containerColecao {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .banner-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1rem;
            color: #fff;
            /* Title on banner must remain white */
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .banner-subtitle {
            font-size: 1.25rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 800px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .banner-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .meta-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.9rem;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .meta-pill.highlight {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: #fff;
        }

        /* Section Headers */
        .section-header {
            margin-bottom: 30px;
            position: relative;
        }

        .section-header h3,
        .section-header h1 {
            font-weight: 700;
            color: var(--text-primary);
            /* Dark text for sections */
            margin-bottom: 10px;
        }

        .header-line {
            width: 60px;
            height: 4px;
            background-color: var(--accent-color);
            border-radius: 2px;
        }

        /* Categories Slider */
        .section-categories {
            padding: 40px 0;
            background-color: #fff;
            border-bottom: 1px solid #eee;
        }

        .category-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .slider-card {
            background: #f1f3f5;
            padding: 15px 25px;
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-card:hover {
            background: #fff;
            border-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        .category-name {
            font-weight: 600;
            font-size: 1rem;
            color: var(--text-primary);
        }

        /* Content Section */
        .content-section {
            padding: 60px 0;
        }

        .main-header {
            margin-bottom: 40px;
        }

        .main-header h1 {
            font-size: 2.5rem;
        }

        /* Video Cards Grid */
        .video-card-btn {
            background: none;
            border: none;
            padding: 0;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .card-inner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid #f0f0f0;
        }

        .video-card-btn:hover .card-inner {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow-hover);
            border-color: rgba(0, 210, 106, 0.3);
        }

        .card-image-box {
            position: relative;
            /* Increased aspect ratio for Portraits (approx 3:4) */
            aspect-ratio: 3/4;
            overflow: hidden;
            background-color: #f0f0f0;
            /* Slight gray bg for fill */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .video-thumb {
            width: 100%;
            height: 100%;
            /* KEY FIX: contain ensures the WHOLE image is visible */
            object-fit: contain;
            transition: transform 0.5s ease;
            padding: 5px;
            /* Tiny padding so it doesn't touch edges */
        }

        .video-card-btn:hover .video-thumb {
            transform: scale(1.05);
        }

        .hover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            /* Lighter overlay */
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .video-card-btn:hover .hover-overlay {
            opacity: 1;
        }

        .play-icon-circle {
            width: 50px;
            height: 50px;
            background-color: var(--accent-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            box-shadow: 0 4px 10px rgba(0, 210, 106, 0.4);
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }

        .video-card-btn:hover .play-icon-circle {
            transform: scale(1);
        }

        .card-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .video-item-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .watch-text {
            font-size: 0.8rem;
            color: var(--accent-color);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Modal Customization - Transparent */
        .modal-white .modal-content {
            background-color: transparent !important;
            border: none;
            box-shadow: none;
        }

        .modal-header-custom {
            position: absolute;
            top: -50px;
            right: 0;
            padding: 10px;
            z-index: 10;
            width: 100%;
            display: flex;
            justify-content: flex-end;
            pointer-events: none;
        }

        .btn-close-custom {
            pointer-events: auto;
            background: var(--accent-color);
            border: 2px solid #fff;
            color: #fff;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .btn-close-custom:hover {
            background-color: #fff;
            color: var(--accent-color);
            transform: scale(1.1) rotate(90deg);
            border-color: var(--accent-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .banner-title {
                font-size: 2.2rem;
            }

            .page-banner {
                min-height: 50vh;
            }

            .card-grid .col-6 {
                padding: 0 5px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const videoModal = document.getElementById('modalVideo');
            const videoIframe = document.getElementById('video');

            // Move modal to body to fix stacking context issues
            if (videoModal) {
                document.body.appendChild(videoModal);
            }

            if (videoModal && videoIframe) {
                // Listen for modal show event
                videoModal.addEventListener('show.bs.modal', function (event) {
                    // Get the button that triggered the modal
                    const button = event.relatedTarget;
                    if (button) {
                        // Get the video hash from data-src attribute
                        const videoSrc = button.getAttribute('data-src');
                        if (videoSrc) {
                            // Update iframe src with the video URL using the proper route
                            videoIframe.src = "{{ route('videoplay') }}/" + videoSrc;
                        }
                    }
                });

                // Stop video when modal starts hiding (before animation completes)
                videoModal.addEventListener('hide.bs.modal', function () {
                    videoIframe.src = "";
                });

                // Reset iframe to loading state when modal is fully hidden
                videoModal.addEventListener('hidden.bs.modal', function () {
                    videoIframe.src = "{{ route('loadingvideo') }}";
                });
            }

            // Auto-open video if URL contains video ID (segment 5)
            @if(null !== Request()->segment(5) && $modalConteudo == 'permitido')
                setTimeout(function() {
                    const videoBtn = document.getElementById('VideoId{{ Request()->segment(5) }}');
                    if (videoBtn) {
                        videoBtn.click();
                    }
                }, 100);
            @endif
        });
    </script>
@endsection