<?php
$paginaTitulo = $colecao[0]->title . ' - DentalGo';
$pageDescription = '';

$tipoTopo = 'topoAzul';

// --- DATA PREPARATION & MAPPINGS ---
// Normalize variables
$todasColecoes = $colecoes;
$recebidoC = $colecao; // This seems to be an array of collection details
$colecoes = collect($colecao[1])->sortBy('count')->reverse()->toArray(); // The magazines

$currentCollectionId = $colecao[0]->id;

// Logic for redirection (legacy)
// if ($currentCollectionId == '79') {
//     echo "<script>window.location.href = 'https://www.dentalgo.com.br/';</script>";
// }

// Map Collection ID -> Authors Link
$authorLinks = [
    5 => 'https://clinicalorthodontics.net/instrucoesaosautores',
    6 => 'https://dpjo.net/instrucoesaosautores',
    67 => 'https://orofacialharmony.net/instrucoesaosautores',
    4 => 'https://clinicaldentistry.net/instrucoesaosautores',
    1 => 'https://jbcoms.net/instrucoesaosautores',
    2 => 'https://dpendodontics.com/instrucoesaosautores',
    50 => 'https://www.brazilianperiodontology.com/instrucoesaosautores',
];
$currentAuthorLink = $authorLinks[$currentCollectionId] ?? null;

// Get the latest magazine for buttons logic
$latestMagazine = $ultimaRevista[0]->productItems[0] ?? null;
// Note: original code looped $ultimaRevista[0]->productItems but seemingly only took the first valid one with @break
// depending on ID. We will simplify to check the first one or logic that matches.
// Original code had a foreach but broke immediately after finding one.

$linguagem = request('language') ?? 'pt';
?>
@extends('facelift2.master')

@section('content')

    <style>
        /* Scoped Styles for Collection Page */
        .banner-collection {
            background: linear-gradient(135deg, #1e1e24 0%, #2b2b36 100%);
            color: white;
            padding: 60px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .banner-collection::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image: url('{{ asset("facelift2/img/texture-dots.png") }}');
            /* Optional texture */
            opacity: 0.05;
            pointer-events: none;
        }

        .publication-badge {
            font-family: 'Raleway', sans-serif;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-bottom: 24px;
            display: inline-block;
            border-bottom: 2px solid #d21d5b;
            padding-bottom: 5px;
        }

        .official-logos img {
            height: 60px;
            width: auto;
            margin-right: 15px;
            margin-bottom: 15px;
            transition: transform 0.2s;
        }

        .official-logos img:hover {
            transform: scale(1.05);
        }

        .cover-image {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            border-radius: 12px;
            transform: perspective(1000px) rotateY(-5deg);
            transition: transform 0.5s ease;
            max-height: 450px;
            width: auto;
        }

        .cover-image:hover {
            transform: perspective(1000px) rotateY(0deg) scale(1.02);
        }

        .action-buttons .btn {
            border-radius: 50px;
            padding: 12px 30px;
            font-feature-settings: "tnum";
            font-variant-numeric: tabular-nums;
            font-weight: 600;
            margin-right: 15px;
            margin-bottom: 15px;
        }

        .partner-logos {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            align-items: center;
            justify-content: flex-start;
        }

        .partner-logos img {
            max-height: 40px;
            width: auto;
            opacity: 0.7;
            transition: opacity 0.3s;
            filter: brightness(0) invert(1);
            /* Ensure white logos */
        }

        .partner-logos img:hover {
            opacity: 1;
        }

        /* Grid Styles */
        .year-heading {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 4rem;
            color: #333333;
            margin-top: 60px;
            margin-bottom: 30px;
            position: relative;
            z-index: 0;
        }

        .year-heading::after {
            /* Stylish underline */
            content: '';
            display: block;
            width: 60px;
            height: 6px;
            background: #d21d5b;
            margin-left: 5px;
        }

        .card-magazine {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            height: 100%;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card-magazine:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .partner-logos {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 10px !important;
                margin-top: 20px !important;
                padding: 0 10px !important;
            }

            /* Target the links wrapping the images */
            .partner-logos a {
                display: flex !important;
                justify-content: center;
                align-items: center;
                max-width: 30% !important;
                /* Force 3 per row */
                margin-bottom: 5px !important;
            }

            .partner-logos img {
                max-height: 25px !important;
                width: auto !important;
                max-width: 100% !important;
                object-fit: contain !important;
                margin: 0 !important;
                opacity: 0.9;
            }

            .banner-collection {
                text-align: center;
                padding: 40px 0;
            }

            .cover-image {
                transform: none;
                margin-top: 30px;
                max-height: 250px;
            }

            /* ... existing mobile styles ... */
            .official-logos {
                justify-content: center;
                display: flex;
                flex-wrap: wrap;
            }

            .year-heading {
                font-size: 3rem;
                text-align: center;
            }

            .year-heading::after {
                margin: 0 auto;
            }

            .btn-lang {
                padding: 6px 14px;
                /* Increased mobile padding */
                font-size: 0.8rem;
                /* Increased mobile font size */
            }
        }

        .card-magazine img.cover {
            width: 100%;
            height: auto;
            display: block;
        }

        .card-magazine .card-body {
            padding: 15px;
        }

        .magazine-title {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0;
            line-height: 1.4;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .banner-collection {
                text-align: center;
                padding: 40px 0;
            }

            .cover-image {
                transform: none;
                margin-top: 30px;
                max-height: 350px;
            }

            .official-logos {
                justify-content: center;
                display: flex;
                flex-wrap: wrap;
            }

            .partner-logos {
                justify-content: center;
            }

            .year-heading {
                font-size: 3rem;
                text-align: center;
            }

            .year-heading::after {
                margin: 0 auto;
            }
        }

        /* Language Badge Styles */
        .lang-badges-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .btn-lang {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #555;
            font-size: 0.9rem;
            /* Increased from 0.75rem */
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-lang:hover {
            background-color: #fff;
            border-color: #d21d5b;
            color: #d21d5b;
            box-shadow: 0 4px 12px rgba(210, 29, 91, 0.15);
            transform: translateY(-2px);
        }

        .btn-lang img {
            height: 16px;
            /* Increased from 12px */
            width: auto;
            opacity: 0.85;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {

            /* ... existing mobile styles ... */
            .btn-lang {
                padding: 6px 14px;
                /* Increased mobile padding */
                font-size: 0.8rem;
                /* Increased mobile font size */
            }
        }
    </style>

    <!-- HERO SECTION -->
    <div class="banner-collection" style="margin-top: 20px;">
        <div class="container position-relative">
            <div class="row align-items-center">

                <!-- Left Info Column -->
                <div class="col-12 col-md-7 col-lg-6 order-2 order-md-1">

                    @if($currentCollectionId == '5')
                        <div class="mb-4">
                            <span class="publication-badge">{{__("messages.PUBLICACAOOficial")}}</span>
                            <div class="official-logos">
                                <a href="https://abor.org.br/" target="_blank">
                                    <img src="{{ asset('imagens/Facelift/SELOS/seloaboradaptdado.fw.png') }}" alt="ABOR">
                                </a>
                                <a href="https://www.alado.org/" target="_blank">
                                    <img src="{{ asset('imagens/Facelift/SELOS/seloaladoadaptdado.fw.png') }}" alt="ALADO">
                                </a>
                            </div>
                        </div>
                    @endif

                    <h1 class="display-4 fw-bold mb-3">{{ $colecao[0]->title }}</h1>
                    <!-- If there's a description you can uncomment this
                                <p class="lead text-white-50 mb-4">{{ $pageDescription = '';}}</p>
                                -->

                    <div class="action-buttons mt-4">
                        @if($latestMagazine && isset($latestMagazine->data->corpo))
                            <!-- Corpo Editorial Button -->
                            <button type="button" class="btn btn-outline-light" data-bs-toggle="modal"
                                data-bs-target="#leiaCapitulo{{ $latestMagazine->id }}">
                                <i class="bi bi-people-fill me-2"></i> {{__("messages.BOTAOCorpoEditorial")}}
                            </button>

                            <!-- Authors Button -->
                            @if($currentAuthorLink)
                                <a href="{{ $currentAuthorLink }}" target="_blank" class="btn btn-danger text-white border-0"
                                    style="background-color: #d21d5b;">
                                    <i class="bi bi-pencil-square me-2"></i> {{__("messages.BOTAOParaautores")}}
                                </a>
                            @endif
                        @endif
                    </div>

                </div>

                <!-- Right Image Column -->
                @if($recebidoC[0]->id == 80 || $recebidoC[0]->id == 79) <!-- JIAP e JCDAM sem logo -->
                    <div class="col-12 col-md-5 col-lg-6 order-1 order-md-2 text-center mb-5 mb-md-0">
                        <!-- <img src="{{ $recebidoC[0]->cover }}" class="cover-image img-fluid" alt="Capa da Coleção"> -->
                    </div>
                @else
                    <div class="col-12 col-md-5 col-lg-6 order-1 order-md-2 text-center mb-5 mb-md-0">
                        <img src="{{ $recebidoC[0]->cover }}" class="cover-image img-fluid" alt="Capa da Coleção">
                    </div>
                @endif

            </div>

            <!-- PARTNERS SECTION (Inside Banner) -->
            <div class="partner-logos">

                @if($currentCollectionId == '5') <!-- Clinical -->
                    <a href="https://www.id-logical.com/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/id-logicalbranca.fw.png') }}" alt="Id Logical" /></a>
                    <a href="https://www.easy3d.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/easy-3d-branco.fw.png') }}" alt="Easy3D" /></a>
                    <a href="https://www.morelli.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/logo_transparentebrancamorelli.fw.png') }}" alt="Morelli" /></a>
                    <a href="https://www.dolphinimaging.com/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/dolphin-logo-branca.fw.png') }}" alt="Dolphin" /></a>
                    <a href="https://www.orthometric.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/logobrancaorthometric.fw (1).png') }}" alt="Orthometric" /></a>

                @elseif($currentCollectionId == '4') <!-- Estetica -->
                    <a href="https://www.dentsplysirona.com/pt-br" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/corp-logo-branca-dentsply-sirona-logo.fw.png') }}"
                            alt="Dentsply" /></a>
                    <a href="https://fgmdentalgroup.com/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/LOGO_FGMbranca.fw.png') }}" alt="FGM" /></a>
                    <a href="https://cvdentus.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/cvdentusbranca.png') }}" alt="CVDentus" /></a>

                @elseif($currentCollectionId == '2')
                    <a href="https://www.biologix.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/biologix.fw.png') }}" alt="Biologix" /></a>

                @elseif($currentCollectionId == '1')
                    <a href="https://www.traumec.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/logo-traumec.png') }}" alt="Traumec" /></a>

                @elseif($currentCollectionId == '50')
                    <a href="http://curaprox.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/Curaprox-logo-branca.jpg') }}" alt="Curaprox" /></a>
                    <a href="https://www.colgate.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/Colgate-Logo-branca.fw.png') }}" alt="Colgate" /></a>
                    <a href="https://www.gumbrand.com/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/GUM-Logo-branca.fw.png') }}" alt="GUM" /></a>
                    <a href="https://www.bionnovation.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/bionnovation.fw.png') }}" alt="Bionnovation" /></a>
                    <a href="https://www.oralb.com.br/pt-br" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/oral-b.fw.png') }}" alt="OralB" /></a>
                    <a href="https://plenum.bio/" target="_blank"><img src="{{ asset('imagens/siteRevista/plenum.fw.png') }}"
                            alt="Plenum" /></a>
                    <a href="https://www.geistlich.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/Geistlich.fw.png') }}" alt="Geistlich" /></a>
                    <a href="https://cvdentus.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/cvdentusbranca.png') }}" alt="CVDentus" /></a>

                @elseif($currentCollectionId == '6')
                    <a href="https://www.orthometric.com.br/" target="_blank"><img
                            src="{{ asset('imagens/siteRevista/logobrancaorthometric.fw (1).png') }}" alt="Orthometric" /></a>
                @endif

            </div>
        </div>
    </div>

    <!-- MAGAZINES GRID -->
    <div class="container py-5">
        @foreach ($colecoes as $keyAno => $colecaof)
            <div class="row">
                <div class="col-12">
                    <h3 class="year-heading">{{ $keyAno }}</h3>
                </div>

                @foreach ($colecaof as $key => $revista)
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <article class="card-magazine h-100 d-flex flex-column">
                            @php
                                // Default link (usually PT or first available)
                                $defaultLang = in_array('pt', $revista->availableLanguages) ? 'pt' : $revista->availableLanguages[0];
                                $defaultUrl = route('facerevista') . '/' . $revista->id . '/' . str_replace(' ', '-', $revista->title) . '/' . Request()->segment(3) . '?language=' . $defaultLang;
                             @endphp

                            <!-- Linked Cover Image -->
                            <a href="{{ $defaultUrl }}" class="position-relative d-block overflow-hidden"
                                title="{{ $revista->title }}">
                                <img src="{{ $revista->cover }}" class="cover" alt="{{ $revista->title }}">

                                <!-- Logos overlay (Specific logic for Clinical > 2023) -->
                                @if($keyAno >= '2023' && ($currentCollectionId == '5'))
                                    <div class="position-absolute bottom-0 start-0 w-100 p-2 d-flex justify-content-between align-items-end"
                                        style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                        <img src="{{ asset('imagens/Facelift/logo_abor.png') }}"
                                            style="height: 20px; @if($linguagem == 'es') display:none; @endif">
                                        <img src="{{ asset('imagens/Facelift/logo-aladosemfundo.png') }}" style="height: 20px;">
                                    </div>
                                @endif
                            </a>

                            <div class="card-body d-flex flex-column flex-grow-1">
                                <a href="{{ $defaultUrl }}" class="text-decoration-none text-dark">
                                    <h1 class="magazine-title text-truncate-2-lines flex-grow-1" title="{{ $revista->title }}">
                                        {{ $revista->title }}
                                    </h1>
                                </a>

                                <!-- Language Buttons -->
                                <div class="lang-badges-container">
                                    @foreach($revista->availableLanguages as $lang)
                                        @php
                                            $flag = $lang == 'pt' ? 'pt.png' : ($lang == 'es' ? 'esp.png' : 'ing.png');
                                            $label = $lang == 'pt' ? 'PT' : ($lang == 'es' ? 'ES' : 'EN');
                                            $url = route('facerevista') . '/' . $revista->id . '/' . str_replace(' ', '-', $revista->title) . '/' . Request()->segment(3) . '?language=' . $lang;
                                        @endphp
                                        <a href="{{ $url }}" class="btn-lang" title="Ler em {{ $label }}">
                                            <img src="{{ asset('imagens/bandeiras/' . $flag) }}" alt="{{ $label }}">
                                            <span>{{ $label }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        </article>
                    </div>
                @endforeach

                <!-- ADS (Publicidade) for 2024 / ID 5 or 4 or 50 -->
                @if($keyAno == '2024' && in_array($currentCollectionId, ['5', '4', '50', '6']))
                    @include('facelift2.partials.ads_carousel', ['collectionId' => $currentCollectionId])
                @endif

            </div>
        @endforeach
    </div>


    <!-- MODAL FOR PDF (Reusable) -->
    <!-- We generate modals for the latest magazine chapters if applicable -->
    @foreach ($ultimaRevista[0]->productItems as $item)
        @if(isset($item->data->corpo) && $item->data->corpo == 'editorial')
            <div class="modal fade" id="leiaCapitulo{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content overflow-hidden" style="border-radius: 20px;">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title fw-bold text-dark">{{ $item->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0" style="height: 85vh;">
                            <div id="adobe-dc-view{{$item->id}}" class="w-100 h-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <!-- SCRIPTS -->
    <script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
    <script type="text/javascript">
        document.addEventListener("adobe_dc_view_sdk.ready", function () {
            @foreach ($ultimaRevista[0]->productItems as $item)
                @if(isset($item->data->corpo) && $item->data->corpo == 'editorial')
                    // Bind event to button
                    var btn = document.querySelector('[data-bs-target="#leiaCapitulo{{ $item->id }}"]');
                    if (btn) {
                        btn.addEventListener('click', function () {
                            showPDF('{{ $item->content }}', 'adobe-dc-view{{$item->id}}', '{{ $item->title }}.pdf');
                        });
                    }
                @endif
            @endforeach
                    });

        function showPDF(url, divId, fileName) {
            var adobeDCView = new AdobeDC.View({
                clientId: "509e95046c654d969e54d6c182aceba0",
                locale: "pt-BR",
                divId: divId
            });
            adobeDCView.previewFile({
                content: { promise: fetch(url).then(r => r.arrayBuffer()) },
                metaData: { fileName: fileName }
            }, {
                embedMode: "SIZED_CONTAINER",
                showDownloadPDF: true,
                showPrintPDF: true,
                showAnnotationTools: true
            });
        }
    </script>

@endsection