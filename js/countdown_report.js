jQuery(document).ready(function($){
	var _allsecs = new Array();
	var _allsecs2 = new Array();
	var _i18n = {
		weeks: ['week', 'weeks'],
		days: ['day', 'days'],
		hours: ['hour', 'hours'],
		minutes: ['minute', 'minutes'],
		seconds: ['second', 'seconds']
	};
	$('.approve_remaining_time').each(function(){
		var _rid = $(this).attr('id');
		var id_user = $(this).attr('data_id');
		var time    = $(this).attr('data_time');
		var mode    = $(this).attr('mode');
		var _seconds = parseInt($(this).attr('rel'));
		if(_seconds > 0){
			$(this).html(
				remaining.getString(_seconds, _i18n, false)
			);
		}
		else{
			
	        //$('.alert-report').html('<i class="fa fa-exclamation-triangle fa-2x pull-left" aria-hidden="true"></i> <strong>This account being blocked!</strong>');
		}
		_allsecs[_rid] = _seconds;
		_allsecs2[_rid] = _seconds;
	});

	timer = setInterval(function(){
		var now = new Date();
		true_elapsed = Math.round((now.getTime() - _gNow.getTime()) / 1000); 		
		$('.approve_remaining_time').each(function(){
			var id_user = $(this).attr('data_id');
			var time    = $(this).attr('data_time');
			var mode    = $(this).attr('mode');
			var _rid = $(this).attr('id');
			_seconds = _allsecs[_rid];
			
			//synchronize
			_diff_sec = _allsecs2[_rid] - _seconds;
			if(_diff_sec < true_elapsed){
				_seconds = _allsecs2[_rid] - true_elapsed;
			}
			if(_seconds > 0){
				$(this).html(
					remaining.getString(_seconds, _i18n, false)
				);
				_allsecs[_rid] = --_seconds;
			}
			else{
				//$('.alert-report').html('<i class="fa fa-exclamation-triangle fa-2x pull-left" aria-hidden="true"></i> <strong>This account being blocked!</strong>');
			}
		});
	}, 1000);
});


