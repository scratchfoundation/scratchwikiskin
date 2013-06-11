/*

Scratch Wiki Skin script

*/

//get the element from an id, with functions to write, add, show, hide, addclass, delclass
function el(id) {
	var h = document.getElementById(id);

	//if no element exists with that id, return null
	if(!h){
		return h;
	}
	
	h.write = function(o) {this.innerHTML = o;};
	h.add = function(o) {this.innerHTML += o;};
	h.show = function(o) {this.style.display = 'block';};
	h.hide = function(o) {this.style.display = 'none';};
	h.addclass = function(c) {this.className+=' '+c;this.className=this.className.trim();};
	h.delclass = function(c) {this.className=this.className.replace(c,'').replace('  ',' ').trim();};
	
	return h;
}


window.onload = function() {
	
	//when pencil icon clicked, display dropdown 
	el('pagefctbtn').onclick = function() {
		if (el('pagefctdropdown').style.display!='block') {
			el('pagefctbtn').addclass('open');
			el('pagefctdropdown').show();
		} else {
			el('pagefctbtn').delclass('open');
			el('pagefctdropdown').hide();
		}
	}
	
	//when mouse moved away, hide dropdown
	el('pagefctdropdown').onmouseout = function(e) {
		if (!e) var e = window.event;
		if (!e.toElement) e.toElement = e.relatedTarget;
		if (' ul li img a'.indexOf(e.toElement.tagName.toLowerCase())<0) {
			el('pagefctbtn').delclass('open');
			el('pagefctdropdown').hide();
		}
	}

	//if user is logged in and toggle is showing, add dropdown functions
	if(el('userfcttoggle')){
		//if username toggle clicked, display dropdown
		el('userfcttoggle').onclick = function() {
		
			if (el('userfctdropdown').style.display!='block') {
				el('userfcttoggle').addclass('open');
				el('userfctdropdown').show();
			} else {
				el('userfcttoggle').delclass('open');
				el('userfctdropdown').hide();
			}	
		}

		//when mouse moved away, hide dropdown		
		el('userfctdropdown').onmouseout = function(e) {
			if (!e) var e = window.event;
			if (!e.toElement) e.toElement = e.relatedTarget;
			if (' ul li img a'.indexOf(e.toElement.tagName.toLowerCase())<0) {
			el('userfcttoggle').delclass('open');
			el('userfctdropdown').hide();
		}
		
	};
	}
	
	
	
	
}
/*
function showpersonallinks() {
	document.getElementById('scratchpersonallinks').style.visibility = 'visible';
	document.getElementById('scratchpersonallinks').style.display = 'block';
}
function hidepersonallinks() {
	document.getElementById('scratchpersonallinks').style.visibility = 'hidden';
	document.getElementById('scratchpersonallinks').style.display = 'none';
}
*/

/*
//google analytics
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-3792496-2']);
_gaq.push(['_trackPageview']);

(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
*/
