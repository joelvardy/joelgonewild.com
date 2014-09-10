$(function () {

	// Very simple, but better than nothing
	var screenSize = 'mobile';
	if ($(window).width() > 800) {
		screenSize = 'desktop';
	}

	$('div.gallery').each(function (index, galleryElement) {

		var imageCount = $('img', galleryElement).length,
			imagesLoaded = 0;

		$(galleryElement).addClass('images-'+imageCount);

		$('img', galleryElement).each(function (index, imageElement) {

			var imageSlug = $(imageElement).data('slug'),
				imagePath = window.location.pathname+'/'+imageSlug+'/';

			// Rmeove placeholder image element
			$(imageElement).remove();

			// Load the image
			var image = new Image();
			image.addEventListener('load', function () {

				imagesLoaded++;

				console.log('Image loaded', image.width, image.height);

				var photoElement = $('<a class="photo" href="'+imagePath+(screenSize === 'mobile' ? 1200 : 2400)+'"><img src="'+image.src+'" /></a>');
				$(galleryElement).append(photoElement);

				if (imageCount === imagesLoaded) {
					$(galleryElement).addClass('loaded');
				}

			});
			image.src = imagePath+(screenSize === 'mobile' ? 600 : 1200);

		});

	});

});
