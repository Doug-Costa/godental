<div id="animationWindow">
</div>

<style type="text/css">
	body {
	 background-color: #333333;
	 overflow: hidden;
	 text-align: center;
	}

	body,
	html {
	 height: 100%;
	 width: 100%;
	 margin: 0;
	 padding: 0;
	}

	#animationWindow {
	 width: 100%;
	 height: 100%;
	}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/4.10.1/bodymovin.min.js" ></script> 

<script type="text/javascript">
	var select = function(s) {
		return document.querySelector(s);
	},
	selectAll = function(s) {
	   return document.querySelectorAll(s);
	}, 
	animationWindow = select('#animationWindow'),    
    animData = {
    wrapper: animationWindow,
    animType: 'svg',
    loop: true,
    prerender: true,
    autoplay: true,
    path: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/play_fill_loader.json',
  	rendererSettings: {
    	//context: canvasContext, // the canvas context
    	//scaleMode: 'noScale',
    	//clearCanvas: false,
    	//progressiveLoad: false, // Boolean, only svg renderer, loads dom elements when needed. Might speed up initialization for large number of elements.
    	//hideOnTransparent: true //Boolean, only svg renderer, hides elements when opacity reaches 0 (defaults to true)
	}   
	}, anim;
	anim = bodymovin.loadAnimation(animData);
	anim.addEventListener('DOMLoaded', onDOMLoaded);
	anim.setSpeed(8);

	function onDOMLoaded(e){
	 
	 anim.addEventListener('complete', function(){});
	}

	ScrubBodymovinTimeline(anim)
</script>

