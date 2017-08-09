jQuery(document).ready(function ($) {

	$(document).ready(function () {
	    $('#selectall').click(function () {
	        $('.prstselect').prop('checked', this.checked);
	    });

	    $('.prstselect').change(function () {
	        var check = ($('.prstselect').filter(":checked").length == $('.prstselect').length);
	        $('#selectall').prop("checked", check);
	    });
	});

});