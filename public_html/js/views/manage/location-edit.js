
$( document ).ready(function() {

	//when changing a value of this location
	$('.tag-value-input .form-control').on('change', function () {
		if( $(this).is(':visible') ) {
			var curr_key = $('.key-to-edit :selected').val();
			var curr_key_label = $('.key-to-edit :selected').html();
			var curr_tag = $('.location-tag-table .location-tag[key="'+ curr_key +'"]');

			if(curr_tag.length < 1) {
				$('table.location-tag-table tr:last').after(
					'<tr class="location-tag" key="'+ curr_key +'" tag-key-id="">'
					+'<td>'+ curr_key_label +'</td>'
					+'<td class="tag-value">'+ $(this).val() +'</td>'
					+'<td><button class="btn btn-default action-change-item" type="button">change</button></td>'
					+'<input class="form-control tag-hidden" name="tag['+ curr_key +']" value="'+ $(this).val() +'" type="hidden">'
					//+'{!! Form::hidden('tag[{{$tag->key]}}]', null, ['class' => "form-control"]) !!}'
					+'</tr>'
					);
			}

			$(curr_tag).find('.tag-value').html( $(this).val() );
			$(curr_tag).find('.tag-hidden').val( $(this).val() );
		}
	});

	//hide value field, until we know what key you want to add/edit
	$('.tag-value-input').hide();

	//when the value changes
	$('select[name="key"]').on('change', function() {
		//console.log( $(this).find('option:selected').attr('input-type') );

		//change value field to appropriate type
		$('.tag-value-input').hide();
		$('.tag-value-input-'+ $(this).find('option:selected').attr('input-type')).show();
		$('input[name="value-type"]').val( $(this).find('option:selected').attr('input-type') );

		//populate with existing value?
		existing = $('.location-tag[key="'+ $(this).find('option:selected').val() +'"]');
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
			$('input[name="tag-key-id"]').val( existing.first().attr('tag-key-id') );
		}
		else {
			$('input[name="tag-key-id"]').val('');
		}

	});

	//if they want to change an existing value
	$('.location-tag-table').on('click', '.action-change-item', function() {
		thekey = $(this).parentsUntil('tr').parent().attr('key');
		$('select[name="key"] option[value="'+ thekey +'"]').prop('selected', true).trigger('change');
	});
});