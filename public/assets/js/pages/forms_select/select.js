
// Select2
$(function() {
	$('.select2-demo').each(function() {
		$(this)
			.wrap('<div class="position-relative"></div>')
			.select2({
				placeholder: 'Select value',
				dropdownParent: $(this).parent()
			});
	})
});
