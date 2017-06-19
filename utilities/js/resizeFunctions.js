var resizeFunctions = (function(resizeFunctions){

	resizeFunctions.functions = {
		initialActions: initialActions,
		resizeActions: resizeActions,
		setRemainingHeight: setRemainingHeight,
		initialResize: initialResize
	}

	return resizeFunctions

	function isMobile(){
		var isMobile = false;
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			isMobile = true;
		}
		console.log('is mobile: ' + isMobile);
		return isMobile;
	}

	function initialActions(){
		setRemainingHeight(0);
		initialResize();
		resizeActions();
	}

	function resizeActions(){

		if(!isMobile()){
			$( window ).resize(function() {
				//setRemainingHeight();
				adjustBackgroundImage(900, 1.75);
				console.log('Resized');
			});
		}else{
			window.addEventListener('orientationchange', resizeFunctions.functions.initialResize);
		}
	}

	function initialResize(){
		$(document).ready(function(){
			if(!isMobile()){
				adjustBackgroundImage(900, 1.75);
			}else{
				adjustBackgroundImageForMobile(900, 1.75);
			}
		
		});
	}


	function adjustBackgroundImage(transitionWidth, transitionHeightMultiplier){
		var h = window.innerHeight;
		var w = window.innerWidth;

		$('.fill-remaining-space').each(function(i, val){
			setBackgroundImageHeightAndWidth(transitionWidth, transitionHeightMultiplier, val, h, w);
		});

		
	}

	function setBackgroundImageHeightAndWidth(transitionWidth, transitionHeightMultiplier, val, h, w){
		var newH = '100vh';
		var newW = '100vw';
		if(w < transitionWidth){
			if(val.style.width != transitionWidth){
				val.style.width = transitionWidth;
				val.style.height = '100vh';
			}
		}else if(w >= transitionWidth){
			setBaseBackgroundDimensions(val);
		}

		if(w >= transitionHeightMultiplier * h){ // show background color
			val.style.height = h + (w - (transitionHeightMultiplier * h));
			if(!isMobile()){
				val.style.marginTop = (h - parseInt(val.style.height))/2 - 50;
				console.log(val.style.marginTop);
			}
		}

		val.style.backgroundSize = val.style.width + ' ' + val.style.height;

	}

	function adjustBackgroundImageForMobile(transitionWidth, transitionHeightMultiplier){
		var h = window.innerHeight;
		var w = window.innerWidth;

		if(w >= h){
			adjustBackgroundImage(transitionWidth, transitionHeightMultiplier);
		}else{
			$('.fill-remaining-space').each(function(i, val){
				val.style.height = '100vh';
				val.style.backgroundSize = '150vh 100vh';
			});
		}
	}

	function setBaseBackgroundDimensions(val){
			val.style.width = '100vw';
			val.style.height = '100vh';
	}

	function setRemainingHeight(heightExcluded){
		var h = window.innerHeight;
		$('.fill-remaining-space').each(function(i, val){
			val.style.height = h - heightExcluded;
			val.style.backgroundSize = "100vw " + val.style.height;
		});
	}
})(resizeFunctions || []);