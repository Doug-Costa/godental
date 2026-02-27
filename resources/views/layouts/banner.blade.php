<div class="container-fluid bannerHome <?php if(isset($tipoBanner)){ echo $tipoBanner; } ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('imagens/note.png') }}" style="width: 100%;">
            </div>
        </div>
    </div>
</div>

<!--
<iframe src="https://www.youtube.com/embed/HBpeTYlJADU?controls=0&autoplay=1&mute=1&playsinline=1&playlist=HBpeTYlJADU&loop=1">
 </iframe>


 <style>
     
    .video-container{
  width: 100vw;
  height: 100vh;
}
    
iframe {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 100vw;
  height: 100vh;
  transform: translate(-50%, -50%);
}

@media (min-aspect-ratio: 16/9) {
  .video-container iframe {
    /* height = 100 * (9 / 16) = 56.25 */
    height: 56.25vw;
  }
}
    
@media (max-aspect-ratio: 16/9) {
  .video-container iframe {
    /* width = 100 / (9 / 16) = 177.777777 */
    width: 177.78vh;
  }
}

#text{
  position: absolute;
  color: #FFFFFF;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}

footer{
    z-index: 999999;
    position: fixed;
    bottom: 0;
}
 </style>}
-->