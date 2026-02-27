<?php
$id = Request()->segment(2);
$hash = Request()->input('h');
?>
<body>
    @if($hash == null)
        <div data-vimeo-id="{{ $id }}" data-vimeo-watch-later="false" data-vimeo-responsive="true" data-vimeo-autoplay="true" id="handstick"></div>
    @else
        <div data-vimeo-url="https://player.vimeo.com/video/{{ $id }}?h={{ $hash }}" data-vimeo-watch-later="false" data-vimeo-responsive="true" data-vimeo-autoplay="true" id="playertwo"></div>
    @endif
</body>

<style type="text/css">
    body{
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100vh;
    }
</style>

<script src="https://player.vimeo.com/api/player.js"></script>
<script>

    const options = {
        autoplay: true,
        loop: true,
        responsive: true,
        background: false,
        watch-later: false
    };
    // If you want to control the embeds, you’ll need to create a Player object.
    // You can pass either the `<div>` or the `<iframe>` created inside the div.
    const handstickPlayer = new Vimeo.Player('handstick', options);
    handstickPlayer.on('play', function() {
        console.log('played the handstick video!');
    });

    const playerTwoPlayer = new Vimeo.Player('playertwo', options);
    playerTwoPlayer.on('play', function() {
        console.log('played the player 2.0 video!');
    });
</script>
