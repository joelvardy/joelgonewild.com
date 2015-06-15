/**
 * Lightbox
 *
 * Author: Joel Vardy <info@joelvardy.com>
 */
;(function ($, window, document, undefined) {

	function Lightbox() {

		var _this = this;

		$(window).resize($.throttle(50, function () {
            _this.resize();
        }));

	}

	Lightbox.prototype = {

		open: function(url, photoClickCallback) {

			var _this = this;

			var lightboxContainerElement = $('<div class="lightbox-container">');
			this.photoElement = $('<img class="lightbox-photo">');

			this.containerElement = lightboxContainerElement.append(this.photoElement);
			$('body').append(this.containerElement);

			this.containerElement.click(function (event) {
				_this.close();
			});

			if (typeof photoClickCallback === 'function') {
				this.photoElement.click(photoClickCallback);
			}

			_this.update(url);

			this.containerElement.fadeIn(250);

		},

		resize: function() {

			if (this.photoElement.length < 1) return;

			var photoData = this.photoElement.data(),
				spacing = 16;

			var windowAspect = ($(window).width() - (spacing * 2)) / ($(window).height() - (spacing * 2)),
				photoAspect = (parseInt(photoData.width) / parseInt(photoData.height));

			if (windowAspect > photoAspect) {
                this.photoElement.css({
                    height: ($(window).height() - (spacing * 2))+'px',
                    left: Math.floor(($(window).width() - Math.floor(($(window).height() - (spacing * 2)) * photoAspect)) / 2)+'px',
                    top: Math.floor(($(window).height() - ($(window).height() - (spacing * 2))) / 2)+'px'
                });
			} else {
                this.photoElement.css({
                    width: ($(window).width() - (spacing * 2))+'px',
                    left: Math.floor(($(window).width() - ($(window).width() - (spacing * 2))) / 2)+'px',
                    top: Math.floor(($(window).height() - Math.floor(($(window).width() - (spacing * 2)) / photoAspect)) / 2)+'px'
                });
			}

		},

		update: function(url) {

			var _this = this;

			// Load the image
			var image = new Image();
			image.addEventListener('load', function () {

				_this.photoElement.data('width', image.width);
				_this.photoElement.data('height', image.height);

				_this.photoElement.attr('src', image.src);

				_this.resize();

			});
			image.src = url;

		},

		close: function() {

			if (this.containerElement.length < 1) return;

			var _this = this;

			this.containerElement.fadeOut(250, function () {
				_this.containerElement.remove();
			});

		}

	};

	var lightbox = new Lightbox();

	$.fn.lightbox = function (method, url) {
		switch (method) {
			case 'open':
				lightbox.open(url);
				break;
			case 'update':
				lightbox.update(url);
				break;
			case 'close':
				lightbox.close();
				break;
		}
	};

})(jQuery, window, document);
