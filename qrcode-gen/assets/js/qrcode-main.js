/*
* @Author: mehedi
* @Date:   2019-09-16 14:05:13
* @Last Modified by:   mehedi
* @Last Modified time: 2019-09-16 15:43:02
*/
;(function($) {
	$(document).ready(function() {
		let current_value = $('#qrcode_toggle').val();
		$('#toggle1').minitoggle();
		if(current_value == 1) {
			$('#toggle1 .minitoggle').addClass('active');
		}

		$('#toggle1').on("toggle", function(e){
        if (e.isActive)
            $("#qrcode_toggle").val(1);
        else
            $("#qrcode_toggle").val(0);
    });
	})
})(jQuery);