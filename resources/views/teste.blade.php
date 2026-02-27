<?php
$tipoTopo = 'topoPreto';
$assinar = 0;

?>
@extends('layouts.master')

@section('content')


<?php

$api_key = 'AIzaSyAMMoFYnpvb-nUmOENIXJ3jT3A_erdRYjY'; // Substitua pela sua chave de API do YouTube
$channel_id = 'UCEB6NcSxH25Z0sopxQqSq4w'; // Substitua pelo ID do seu canal
$playlist_id = 'PL8z5qaJBzyoTrU5sHUDQuU8-4aR2xqLxK';

$api_url = "https://www.googleapis.com/youtube/v3/playlistItems?key=$api_key&playlistId=$playlist_id&part=snippet&maxResults=10";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response);
$videos = $data->items;


?>

 <style>
    .video {
        position: relative;
        overflow: hidden;
    }

    .video img {
        transition: transform 0.3s;
    }

    .video .preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .video:hover img {
        transform: scale(1.1);
    }

    .video:hover .preview-overlay {
        opacity: 1;
    }
</style>
<div class="row">
    <?php foreach ($videos as $index => $video): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?php echo $video->snippet->thumbnails->medium->url; ?>" class="card-img-top" alt="Thumbnail">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $video->snippet->title; ?></h5>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal<?php echo $index; ?>">
                        Assistir
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="videoModal<?php echo $index; ?>" tabindex="-1" aria-labelledby="videoModalLabel<?php echo $index; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="videoModalLabel<?php echo $index; ?>"><?php echo $video->snippet->title; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="ratio ratio-16x9">
                            <iframe id="videoPlayer<?php echo $index; ?>" src="https://www.youtube.com/embed/<?php echo $video->snippet->resourceId->videoId; ?>?enablejsapi=1" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


@foreach ($videos[0]->id->productItems as $key => $videosCat)
    <div class="container-fluid">
        <div class="row videos">
            <div class="col-sm-12"> 
                <a href="{{ route('video')}}/{{ $videos->id }}" style="color: transparent;">
                    <h3>{{ $videosCat->title }} <small style="font-size: 13px;"> {{__("messages.conteudoVideosVeja")}}  <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i></small></h3>
                </a>
            </div><hr>
            @foreach (array_slice($videos->productItems, 0, 6) as $video)
            <div class="col-6 col-md-2 card-margin">
                <a href="{{ route('video')}}/{{ $videos->id }}/{{ str_replace(' ', '-', $video->title) }}/{{ $video->id }}">
                    <img src="{{ $video->cover}}" style="width: 100%;" class="videoImagemMain">
                </a>
            </div>
            @endforeach
        </div>
    </div>
@endforeach



<script src="https://www.youtube.com/iframe_api"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modals = document.querySelectorAll('.modal');

        modals.forEach(function (modal) {
            modal.addEventListener('shown.bs.modal', function () {
                var iframe = modal.querySelector('iframe');
                iframe.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
            });

            modal.addEventListener('hidden.bs.modal', function () {
                var iframe = modal.querySelector('iframe');
                iframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
            });
        });
    });
</script>


@endsection