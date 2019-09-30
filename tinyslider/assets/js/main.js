/*
* @Author: Coder-Mehedi
* @Date:   2019-09-17 14:13:13
* @Last Modified by:   Coder-Mehedi
* @Last Modified time: 2019-09-29 15:50:43
*/
;(function($) {
	$(document).ready(function() {
		var slider = tns({
			container: '.slider',
			speed: 300,
			autoPlayTimeout: 3000,
			items: 1,
			autoplay: true,
			autoHeight: true,
			controls: false,
			nav: false,
			autoplayButtonOutput: false
		})
	});
})(jQuery);