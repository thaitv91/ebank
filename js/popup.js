 function Provide_help_Term() {
            $('.provide_term').fadeIn('slow');
        }
        function Provide_help_Term_Next() {

            var input = document.getElementById("chkterm");
            var isChecked = input.checked;

            if (isChecked) {
                $('.provide_term').fadeOut();
                $('.deposite_amount').fadeIn('slow');
            }
            else {
                $('#spnterms').text('Accept Terms And Condition');
            }

        }
		
		
        function close_popup() {
            $('.panel-tool-close').parents('.window').fadeOut();
        }
        function Get_Help() {
            //var mid = document.getElementById("txtvalue").value;
           /* $.ajax({
                type: "POST",
                url: "home.aspx/GrowthWallet",
                contentType: "application/json; charset=utf-8",
                data: "",
                dataType: "json",
                success: function (data) {
                    $('#spangwallet').text(data.d);
                }
            });*/
			 $('.gethelp').fadeIn('slow');
			
			}
			
			function getsub_detail() {
            //var mid = document.getElementById("txtvalue").value;
           /* $.ajax({
                type: "POST",
                url: "home.aspx/GrowthWallet",
                contentType: "application/json; charset=utf-8",
                data: "",
                dataType: "json",
                success: function (data) {
                    $('#spangwallet').text(data.d);
                }
            });*/
			 $('.subdetail').fadeIn('slow');
			
			}
                function get_messge() {
            //var mid = document.getElementById("txtvalue").value;
           /* $.ajax({
                type: "POST",
                url: "home.aspx/GrowthWallet",
                contentType: "application/json; charset=utf-8",
                data: "",
                dataType: "json",
                success: function (data) {
                    $('#spangwallet').text(data.d);
                }
            });*/
			 $('.message').fadeIn('slow');
			
			} 
			function get_detail() {
            //var mid = document.getElementById("txtvalue").value;
           /* $.ajax({
                type: "POST",
                url: "home.aspx/GrowthWallet",
                contentType: "application/json; charset=utf-8",
                data: "",
                dataType: "json",
                success: function (data) {
                    $('#spangwallet').text(data.d);
                }
            });*/
			 $('.detail').fadeIn('slow');
			
			}
			
			function commited() {
            var input = document.getElementById("submit_amount");
            var isChecked = input.checked;

            if (isChecked) {
                $('.deposite_amount').fadeOut();
                $('.deposit_success').fadeIn('slow');
				$('#msg_submit').text('Success');
            }
            else {
                $('#msg_submit').text('Error');
            }
            /*var ctype = document.getElementById("ContentPlaceHolder1_lblctype").innerHTML
            var amount = $('#ContentPlaceHolder1_txtamount').val();
            var codeno = $('#txtcodeno').val();

            if (amount != "") {
                if (codeno != "") {
                    if (ctype == 'INR') {
                        if (parseFloat(amount) % 1000 == 0) {
                            if (parseFloat(amount) >= 1000 && parseFloat(amount) <= 300000) {
                                $('#errormsg').text('');
                            }
                            else {
                                $('#errormsg').text('Please Enter Valid INR Amount between 1000-300000');
                            }
                        }
                        else {
                            $('#errormsg').text('Please Enter Valid INR Amount Multiply By 1000 INR');
                        }
                    }
                    else {
                        if (parseFloat(amount) % 10 == 0) {
                            if (parseFloat(amount) >= 20 && parseFloat(amount) <= 5000) {
                                $('#errormsg').text('');
                            }
                            else {
                                $('#errormsg').text('Please Enter Valid USD Amount between 20-5000');
                            }
                        }
                        else {
                            $('#errormsg').text('Please Enter Valid Deposit USD amount Multiply By 10 USD');
                        }
                    }
                    var emsg = $('#errormsg').text();
                    if (emsg == "") {
                        $.ajax({
                            type: "POST",
                            url: "home.aspx/CommitMember",
                            contentType: "application/json; charset=utf-8",
                            data: "{gtype:'" + $('#ContentPlaceHolder1_ddlg').val() + "',code:'" + codeno + "',amt:'" + $('#ContentPlaceHolder1_txtamount').val() + "',type:'" + document.getElementById("ContentPlaceHolder1_lblctype").innerHTML + "'}",
                            dataType: "json",
                            success: function (data) {
                                if (data.d != "OK") {
                                    $('#errormsg').text(data.d);
                                }
                                else {
                                    $('.deposite_amount').fadeOut();
                                    getdata();
                                    withdrawfunc();
                                    mesg('Commitment', 'Successfully Commitment');
                                }
                            }
                        });
                    }
                }
                else {
                    $('#errormsg').text('Please Enter SMS Code');
                }
            }
            else {
                $('#errormsg').text('Please Enter Amount');
            }
            $('.load').fadeOut();*/
        }
		
		