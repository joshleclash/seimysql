NewsScroller = function (id,speed) {

	var self  = this;
	var container = document.getElementById(id);
	var boxheight = container.style.height.replace('px','');
	var heighttmp = container.scrollHeight;
	var height = parseInt(container.scrollHeight);
	var _timer;
	
	//Duplicamos el contenido del div para que se haga el efecto de marquesina.
	container.innerHTML =  container.innerHTML +  container.innerHTML; 
	
	this.scrollSpeed = (parseInt(speed)>0) ? speed : 30;
	
	this.doScroll = function () { 
		if(container.scrollTop>height) {
			//Reiniciamos El Scroll
			container.scrollTop=1;
		}else{
		container.scrollTop=container.scrollTop+1;		
		}
	};
	
	this.start = function() {
		_timer = window.setInterval(self.doScroll, this.scrollSpeed);
	};
		
	this.stop = function () { 
		if (_timer) window.clearInterval(_timer);
	};
	this.start();
};