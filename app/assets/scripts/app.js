$(function () {


	// Very simple, but better than nothing
	var screenSize = 'mobile';
	if ($(window).width() > 800) {
		screenSize = 'desktop';
	}


	$(document).keyup(function (event) {
		if (event.keyCode == 27) {
			$('body').lightbox('close');
		}
	});


	$('.photo.hero').each(function (index, heroPhotoElement) {

		var imagePath = $(heroPhotoElement).data('path');

		// Load the image
		var image = new Image();
		image.addEventListener('load', function () {

			$(heroPhotoElement).css('background-image', 'url('+image.src+')');
			$(heroPhotoElement).addClass('loaded');

		});
		image.src = imagePath+'/'+(screenSize === 'mobile' ? 600 : 1200)+'.jpg';

	});


	$('div.gallery').each(function (index, galleryElement) {

		var imageCount = $('img', galleryElement).length,
			imagesLoaded = 0;

		$(galleryElement).addClass('images-'+imageCount);

		$('img', galleryElement).each(function (index, imageElement) {

			var imageSlug = $(imageElement).data('slug'),
				imagePath = window.location.pathname+'/'+imageSlug;

			// Rmeove placeholder image element
			$(imageElement).remove();

			// Load the image
			var image = new Image();
			image.addEventListener('load', function () {

				imagesLoaded++;

				var photoElement = $('<a class="photo" href="'+imagePath+'/'+(screenSize === 'mobile' ? 1200 : 2400)+'.jpg"><img src="'+image.src+'" /></a>');
				$(galleryElement).append(photoElement);

				photoElement.click(function () {
					$('body').lightbox('open', $(this).attr('href'));
					return false;
				});

				if (imageCount === imagesLoaded) {
					$(galleryElement).addClass('loaded');
				}

			});
			image.src = imagePath+'/'+(screenSize === 'mobile' ? 600 : 1200)+'.jpg';

		});

	});


});
