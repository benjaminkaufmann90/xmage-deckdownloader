'use strict';

addEventListener('load', function() {

	const bgImages = document.getElementsByClassName('bgImages')[0];
	const bgImageUrls = [
		'assets/img/bg-1.jpg',
		'assets/img/bg-2.jpg',
		'assets/img/bg-3.jpg',
		'assets/img/bg-4.jpg',
		'assets/img/bg-5.jpg',
		'assets/img/bg-6.jpg',
	];
	let bgImageIndex = 0;
	
	bgImageUrls.forEach((function(url, idx) {
		const bgImage = document.createElement('div');
		bgImage.setAttribute('class', 'bgImages-bgImage');
		bgImage.id = url;
		if(idx === 0) {
			bgImage.style.opacity = 1;
			bgImage.style.zIndex = 1;
		} else if(idx === 1) {
			bgImage.style.opacity = 0;
			bgImage.style.zIndex = 2;
		}
		bgImage.style.backgroundImage = 'url(' + url + ')';
		bgImages.appendChild(bgImage);
	}).bind(this));

	setInterval((function() {
		bgImageUrls.forEach((function(url) {
			if(url !== bgImageUrls[bgImageIndex]) {
				document.getElementById(url).style.zIndex = 0;
				document.getElementById(url).style.opacity = 0;
			} else {
				document.getElementById(url).style.zIndex = 1;
			}
		}).bind(this));
		bgImageIndex = bgImageIndex + 1 >= bgImageUrls.length ? 0 : bgImageIndex + 1;
		document.getElementById(bgImageUrls[bgImageIndex]).style.zIndex = 2;
		document.getElementById(bgImageUrls[bgImageIndex]).style.opacity = 1;
		console.log(bgImageIndex, bgImageUrls[bgImageIndex]);
	}).bind(this), 5000);
}, false);