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
		var mode = $(this).attr('mode');
		var time    = $(this).attr('data_time');
		var _seconds = parseInt($(this).attr('rel'));
		if(_seconds > 0){
			$(this).html(
				remaining.getString(_seconds, _i18n, false)
			);
		}
		else{
			//$(this).html('Time Over');

			//block user
			$.ajax({
                url : "/ajax_call/block.php",
                type : "post",
                dateType:"html",
                data : 'id='+id_user+'&mode='+mode+'&time='+time,
                success : function (result){
                    $('#button_action'+id_user).html(result);
                    //location.reload(); 
                }
            });
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
			var mode = $(this).attr('mode');
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
				// $("#too_many_user").hide();
				// $("#login_btn").removeAttr("disabled");
				// $(this).html('Time Over');

				//block user
				$.ajax({
                    url : "/ajax_call/block.php",
                    type : "post",
                    dateType:"html",
                    data : 'id='+id_user+'&mode='+mode+'&time='+time,
                    success : function (result){
                        $('#button_action'+id_user).html(result);
                        //location.reload(); 
                    }
                });
			}
		});
	}, 1000);
});


