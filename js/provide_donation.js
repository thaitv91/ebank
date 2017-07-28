jQuery(document).ready(function($){
	var _allsecs = new Array();
	var _allsecs2 = new Array();
	var _i18n = {
		weeks: ['week', 'weeks'],
		days: ['day', 'days'],
		hours: ['hour', 'hours'],
		minutes: ['minute', 'mins'],
		seconds: ['second', 'secs']
	};
	$('.approve_remaining_time').each(function(){
		var _rid = $(this).attr('id');
		var _seconds = parseInt($(this).attr('rel'));
		if(_seconds > 0){
			$(this).html(
				remaining2.getString2(_seconds, _i18n, false)
			);
		}
		else{
			$(this).html('<span style="padding-top:10px;">Time Over</span>');
			var div_id = $(this).attr('data_class');
			jQuery('.'+div_id).css("padding-top", "0px");
		}
		_allsecs[_rid] = _seconds;
		_allsecs2[_rid] = _seconds;
	});

	timer = setInterval(function(){
		var now = new Date();
		true_elapsed = Math.round((now.getTime() - _gNow.getTime()) / 1000); 		
		$('.approve_remaining_time').each(function(){
			var _rid = $(this).attr('id');
			_seconds = _allsecs[_rid];
			
			//synchronize
			_diff_sec = _allsecs2[_rid] - _seconds;
			if(_diff_sec < true_elapsed){
				_seconds = _allsecs2[_rid] - true_elapsed;
			}
			if(_seconds > 0){
				$(this).html(
					remaining2.getString2(_seconds, _i18n, false)
				);
				_allsecs[_rid] = --_seconds;
			}
			else{
				$("#too_many_user").hide();
				$("#login_btn").removeAttr("disabled");
				$(this).html('<span style="padding-top:10px;">Time Over</span>');
				var div_id = $(this).attr('data_class');
				jQuery('.'+div_id).css("padding-top", "0px");
			}
		});
	}, 1000);
});


jQuery(document).ready(function($){
	var mdid, pdid, gdid, amount, status;
	var img_field = $("#upload_clone").clone();
	
	$('[data-toggle="tooltip"]').tooltip({
		container : 'body',
	});
	
	$('.hireTable').click(function(){
		$('.'+$(this).attr('value')+'.donate-body-'+$(this).attr('rel')).slideToggle('normal');
	});

	$('.transactionWrap').hide();
	$('.btn-details').click(function () {
		$(this).parents('table').siblings('.transactionWrap').stop(true, false).slideUp('normal');
		$(this).parents('table').next().stop(true, false).slideToggle('normal');
		return false;
	});
	
	/*$('#show_message_box').live("click", function(e){
		e.preventDefault();
		json = $(this).attr('data');
		data = JSON && JSON.parse(json) || $.parseJSON(json);

		mdid = data.mdid;
		
		var spUrl = $(this).attr('src');
		$("#message_div").load(spUrl);
		$("input[name=mdid]").val(mdid);
	});*/
	$('a[id^=show_extend_box]').click(function(){
		json = $(this).attr('data');
		//alert(json);
		//data = JSON && JSON.parse(json) || $.parseJSON(json);
		
		$("input[name=extend_mdid]").val(json);
	});
	$('a[id^=show_report_box]').click(function(){
		json = $(this).attr('data');
		//alert(json);
		data = JSON && JSON.parse(json) || $.parseJSON(json);
		$("input[name=report_uid]").val(data.uid);
		$("input[name=report_uir]").val(data.uir);
		$("input[name=report_invest]").val(data.invest);
		$("input[name=report_mdid]").val(data.mdid);
	});
	$('a[id^=show_report_box_gd]').click(function(){
		json = $(this).attr('data');
		//alert(json);
		data = JSON && JSON.parse(json) || $.parseJSON(json);
		$("input[name=report_uid]").val(data.uid);
		$("input[name=report_uir]").val(data.uir);
		$("input[name=report_invest]").val(data.invest);
		$("input[name=report_mdid]").val(data.mdid);
	});
	$('a[id^=show_confirm_box]').click(function(){
		json = $(this).attr('data');
		data = JSON && JSON.parse(json) || $.parseJSON(json);
		$("input[name=confirm_mdid]").val(data.mdid);
	});
	
	$('a[id^=show_chat_box]').click(function(){
		json = $(this).attr('data');
		//alert(json);
		data = JSON && JSON.parse(json) || $.parseJSON(json);
		$("input[name=chat_uid]").val(data.uid);
		$("input[name=chat_mdid]").val(data.mdid);
		$("input[name=chat_payid]").val(data.paying_id);
		
		/*document.getElementById("uid").innerHTML = data.uid;
		document.getElementById("table_id").innerHTML = data.mdid;
		document.getElementById("paying_id").innerHTML = data.paying_id;*/
		
		//alert(data.mdid);
		var table_id = data.uid;
		var uid = data.mdid;
		var p_id = data.paying_id;
		var msg = $("#message").val();

		var dataString = 's_id='+ table_id + '&r_id='+ uid + '&p_id='+ p_id + '&date='+ date + '&msg='+ msg;
		
		//alert(dataString);
		/*$.ajax({
		  type: 'POST',
          url: 'data/ajaxsubmit.php',
		  data: { s_id: data.uid},
            success: function(data) {
              $("#chat_res").html(result);
			 }
       });*/
		
		$.ajax({
				  type: 'POST',
				  url: 'data/ajaxsubmit.php',
				  data: dataString,
				  cache: false,
				  success: function(data) {
					  
				  $("#chatting").html(data);
				 
				}
		   });
		});
	
	/*$('a[id^=show_forgot_sec_code]').click(function(){
		json = $(this).attr('data');
		data = JSON && JSON.parse(json) || $.parseJSON(json);
		$("input[name=mdid]").val(data.mdid);
	});
	$('a[id^=show_extend_box]').click(function(){
		json = $(this).attr('data');
		//alert(json);
		data = JSON && JSON.parse(json) || $.parseJSON(json);
		$("input[name=extend_mdid]").val(data.mdid);
	});*/
	
	$('a[id^=show_approve_box]').click(function(){
		json = $(this).attr('data');
		data = JSON && JSON.parse(json) || $.parseJSON(json);
		//alert(json);
		var spUrl = $(this).attr('src');
		//alert(spUrl);
		$("input[name=approve_mdid]").val(data.mdid);
		$("input[name=invst_id]").val(data.inv_id);
		//$("#approve_message_div").load("data/box_approve.php");		
	});
	
	$("a[id^=show_image]").click(function(){
		$("#image_div").html("<img alt='' class='img-responsive' src='"+$(this).attr('data')+"'>");
	});

	$("a[id^=show_message_image]").click(function(){
		$("#image_div").html("<img alt='' class='img-responsive' src='"+$(this).attr('data')+"'>");
	});
	
});

