var frame;

;(function($) {
	$(document).ready(function() {
		$('#upload_image').on('click', function() {
			if(frame) {
				frame.open();
				return false;
			}
			frame = wp.media({
				title: 'Upload Image',
				button: {
					text: 'Select Image'
				},
				multiple: false
			});

			frame.on('select', function() {
				var attachment = frame.state().get('selection').first().toJSON();
				console.log(attachment);
				$('#omb_image_id').val(attachment.id);
				$('#omb_image_url').val(attachment.sizes.medium.url);
				$('#image-container').html(`<img src='${attachment.sizes.medium.url}'>`);
				
			})

			frame.open();
			return false;
		})
	})
})(jQuery)