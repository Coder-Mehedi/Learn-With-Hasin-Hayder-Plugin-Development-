var frame, gframe;

;(function($) {
	$(document).ready(function() {
		let image_url = $('#omb_image_url').val();
		if(image_url) {
			$('#image-container').html(`<img src='${image_url}'>`);
		}

		let images_url = $('#omb_images_url').val();
		images_url = images_url ? images_url.split(';') : [];
		images_url.map(_image_url => {
			$('#images-container').append(`<img src='${_image_url}'>`);
		})

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
				let attachment = frame.state().get('selection').first().toJSON();
				console.log(attachment);
				$('#omb_image_id').val(attachment.id);
				$('#omb_image_url').val(attachment.url);
				$('#image-container').html(`<img src='${attachment.url}'>`);
				
			})

			frame.open();
			return false;
		});


		$('#upload_images').on('click', function() {
			if(gframe) {
				gframe.open();
				return false;
			}
			gframe = wp.media({
				title: 'Upload Images',
				button: {
					text: 'Select Images'
				},
				multiple: true
			});

			gframe.on('select', function() {
				let image_ids = []
				let image_url = []

				let attachments = gframe.state().get('selection').toJSON();
				console.log(attachments);
				
				$('#images-container').html('')
				attachments.map(attachment => {
					image_ids.push(attachment.id)
					image_url.push(attachment.sizes.full.url)

					$('#images-container').append(`<img src='${attachment.sizes.full.url}'>`);
				})
				$('#omb_images_id').val(image_ids.join(";"));
				$('#omb_images_url').val(image_url.join(";"));
				
			})

			gframe.open();
			return false;
		})
	})
})(jQuery)