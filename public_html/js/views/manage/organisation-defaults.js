
$( document ).ready(function() {

	//hide value field, until we know what key you want to add/edit
	$('.tag-value-input').hide();

	//remove used keys from the add-drop down - depreciated, on(value change) sets value for editing
	/*
	$('.default-row').each(function() {
		$('select[name="key"]').find('option[value="'+ $(this).attr('key') +'"]').attr('disabled','disabled');
	});
	*/

	//when the value changes
	$('select[name="key"]').on('change', function() {
		//console.log( $(this).find('option:selected').attr('input-type') );

		//change value field to appropriate type
		$('.tag-value-input').hide();
		$('.tag-value-input-'+ $(this).find('option:selected').attr('input-type')).show();
		$('input[name="value-type"]').val( $(this).find('option:selected').attr('input-type') );

		//populate with existing default?
		existing = $('.default-row[key="'+ $(this).find('option:selected').val() +'"]');
		//find the relevant value field and populate it?
		switch($(this).find('option:selected').attr('input-type')) {
			case 'boolean':
				$('.tag-value-input-boolean select option:selected').removeAttr('selected');
				if( existing.length > 0 ) {
					$('.tag-value-input-boolean select').find('option[value="'+ existing.first().find('.tag-value').text() +'"]')
						.attr('selected', 'selected');
				}
				break;
			case 'website':
				$('.tag-value-input-website input').val('');
				if( existing.length > 0 ) {
					$('.tag-value-input-website input').val(existing.first().find('.tag-value').text());
				}
			default:
				$('.tag-value-input-text input').val('');
				if( existing.length > 0 ) {
					$('.tag-value-input-text input').val(existing.first().find('.tag-value').text());
				}
		}
		//are we editing a value?
		if( existing.length > 0 ) {
			$('input[name="id"]').val( existing.first().attr('tag-key-id') );
		}
		else {
			$('input[name="id"]').val('');
		}

	});

	//if they want to change an existing value
	$('.action-change-item').on('click', function() {
		thekey = $(this).parentsUntil('tr').parent().attr('key');
		$('select[name="key"] option[value="'+ thekey +'"]').prop('selected', true).trigger('change');
	});
});