jQuery(document).ready(function($){
	var url_local = "https://"+window.location.host;
	var _allsecs = new Array();
	var _allsecs2 = new Array();
	var _i18n = {
		weeks: ['week', 'weeks'],
		days: ['day', 'days'],
		hours: ['hour', 'hours'],
		minutes: ['minute', 'minutes'],
		seconds: ['second', 'seconds']
	};
	$('.repd_remaining_time').each(function(){
		var _rid = $(this).attr('id');
		var id_user = $(this).attr('data_id');
		var id_repd = $(this).attr('data_gd');
		var _seconds = parseInt($(this).attr('rel'));
		if(_seconds > 0){
			$(this).html(
				remaining.getString(_seconds, _i18n, false)
			);
		}
		else{
	        $.ajax({
                url : url_local+"/ajax_call/auto_frozen.php",
                type : "post",
                dateType:"html",
                data : 'id='+id_user+'&repd='+id_repd,
                success : function (result){
                    //location.reload(); 
					$(this).html('<p>Over Time</p>');
                }
            });
		}
		_allsecs[_rid] = _seconds;
		_allsecs2[_rid] = _seconds;
	});

	timer = setInterval(function(){
		var now = new Date();
		true_elapsed = Math.round((now.getTime() - _gNow.getTime()) / 1000); 		
		$('.repd_remaining_time').each(function(){
			var id_user = $(this).attr('data_id');
			var _rid = $(this).attr('id');
			var id_repd = $(this).attr('data_gd');
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
				$.ajax({
                url : url_local+"/ajax_call/auto_frozen.php",
                type : "post",
                dateType:"html",
                data : 'id='+id_user+'&repd='+id_repd,
                success : function (result){
                    //location.reload(); 
					$(this).html('<p>Over Time</p>');
                }
            });
			}
		});
	}, 1000);
});


