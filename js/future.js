// JavaScript Document


function ContentLoader(IsApply)
{
	 if(IsApply)
	 {
		$("body").prepend("<div class=\"overlay\"></div>");
		$(".overlay").css({
			"position": "absolute", 
			"width": $(document).width(), 
			"height": $(document).height(),
			"z-index": -99999, 
		}).fadeTo(0, 0.8);

		// $("#display_content_area").css("opacity","0.6");
		 $('#loading_div').show();
	 }
	 else
	 {
		 
		$(".overlay").css({
			"position": "absolute", 
			"width": "0px", 
			"height": "0px",
			"z-index": 0, 
		}).fadeTo(0, 0.8);
		
		 $('#loading_div').hide();
		// $("#display_content_area").css("opacity","1");
	 }
}




function CloseChatWindow()
{	
	$('#chat_box').animate({top:-1000,left:500,opacity:'0.5'},"slow");
}

function OpenChatWindow(p,r,s)
{	
	
	CloseChatWindowTennis();
	$.ajax(
	{		 
		url:"ajax_call/chat_slip.php?p="+p+"&r="+r+"&s="+s,
		type: "GET",
		beforeSend:function(req) 
		{	
			ContentLoader(true);
		},
		success:function(response)
		{ 	
			if(response ==100)
			{	
				alert("Please Login Before Chat");
				window.location = "index.php";
			}
			else
			{	
				$("#chatlogContentArea").html(response);
				ContentLoader(false);
				$('#chat_box').animate({top:100,left:500,opacity:'1'},"slow");
			}
		},
		error:function(req,status,error)
		{			 
			 ContentLoader(false);
		}
	 }
	);		
}

function OpenChatWindowTennis(p,r,s)
{	 
	 CloseChatWindow();alert("ram");
	$.ajax(
	{		 
		url:"ajax_call/chat_slip.php?p="+p+"&r="+r+"&s="+s,
		type: "GET",
		beforeSend:function(req) 
		{	
			ContentLoader(true);
		},
		success:function(response)
		{ 	
			if(response ==100)
			{
				window.location = "index.php";
			}
			else
			{
				$("#chatlogContentAreaTennis").html(response);
				ContentLoader(false);
				$('#chat_box_tennis').animate({top:0,left:500,opacity:'1'},"slow");
			}
		},
		error:function(req,status,error)
		{			 
			 ContentLoader(false);
		}
	 }
	);		
}

function CloseChatWindowTennis()
{	 
	$('#chat_box_tennis').animate({top:-1000,left:-0,opacity:'0.5'},"slow");
}



$("#chat_submit").click(function(){
	var s_id = $("#s_id").val();
	var r_id = $("#r_id").val();
	var date = $("#date").val();
	var msg = $("#msg").val();
	// Returns successful data submission message when the entered information is stored in database.
	var dataString = 's_id='+ s_id + '&r_id='+ r_id + '&date='+ date + '&msg='+ msg;
	if(s_id==''||r_id==''||date==''||msg=='')
	{
	alert("Please Fill message!!");
	}
	else
	{
	// AJAX Code To Submit Form.
		$.ajax({
			type: "POST",
			url: "data/ajaxsubmit.php",
			data: dataString,
			cache: false,
			success: function(result){
			$('#msg').val('').empty();
			$("#chat_res").html(result);
			}
		});
	}
	return false;
});

$(document).ready(function(){
$("#update").click(function(){
var s_id = $("#s_id").val();
var r_id = $("#r_id").val();

var date = '';
var msg = '';
// Returns successful data submission message when the entered information is stored in database.
var dataString = 's_id='+ s_id + '&r_id='+ r_id + '&date='+ date + '&msg='+ msg;
if(s_id==''||r_id=='')
{
alert("Please Fill All Fields");
}
else
{
// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: "data/ajaxsubmit.php",
data: dataString,
cache: false,
success: function(result){
$('#msg').val('').empty();
$("#chat_res").html(result);
}
});
}
return false;
});
});

$('#attachment_chat').change(function(){
    var file = this.files[0];
    var id = $(this).attr('data-id');
    var name = file.name;
    var type = file.type;
    var size = file.size;

    var form_data = new FormData();                  
    form_data.append("file", file);

    $.ajax({
        url:'ajax_call/upload.php?id='+id,
        dataType: 'html',
        cache: false,
        contentType: false,
        processData: false,
        type:"POST",            
        data: form_data,
        success:function(data){     
            if(data == 1){
            	$('#alert_id').html("<B style='color:#FF0000;''>Error: Invalid file extension !!</B>");
            }else{
            	$('#img').val(data);
            }
        },
        error: function() {
            alert('Error occured');
        }
    });
});
