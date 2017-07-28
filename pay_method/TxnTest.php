
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>My Merchant Check Out Page</title>
<meta name="GENERATOR" content="Evrsoft First Page">
<script type="text/javascript">
  function calculateCheckSum(){  
    document.forms[0].action = 'CheckSum';
  	document.forms[0].submit();
  }
 
	function assignChecksum() {
		var order = document.getElementById("orderid");
		var orderId = order.value + parseInt(Math.random() * 1000000);
		order.value = orderId;
	}
	function payInIframe(){
        document.getElementsByTagName("form")[0].target = "myiframe";
        document.getElementsByName('myiframe')[0].style.display = "block";
        
        Paytm = {
        	payment_response : null
        };
        
        checkForPaymentResponse(function(res){
        	document.getElementById('payment-response-msg').innerHTML = "Payment response : " + res;
        });
        
        function checkForPaymentResponse(callback){
        	var cb = callback;
        	var sid = setInterval(function(){
        		if(Paytm.payment_response){
        			cb(Paytm.payment_response);
        			clearInterval(sid);
        		}
        	}, 200)
        };

	}
</script>
</head>
<body onLoad="javascript:assignChecksum();">
<iframe name="myiframe" style="display:none;float: right;width: 640px;height: 600px;margin-right: 2%;"></iframe>	
<h1> Merchant Check Out Page</h1>
	<!--<form method="post" action="http://10.0.20.125:18080/oltp-web/processTransaction"> -->
<form method="post" action="pgRedirect.php">
		<table border="1">
			<tbody>
				<tr>
					<th>S.No</th>
					<th>Label</th>
					<th>Value</th>
				</tr>
				<tr>
					<td>1</td>
					<td><label>CheckSum ::*</label></td>
					<td><input type="hidden" id="CHECKSUMHASH" tabindex="1" maxlength="12" size="10" value=""  name="CHECKSUMHASH" autocomplete="off"></td>
				</tr>
				<tr>
					<td>2</td>
					<td><label>ORDER_ID::*</label></td>
					<td><input id="orderid" tabindex="1" maxlength="20" size="20"
						name="ORDER_ID" autocomplete="off"
						value="ORDER48886">
					</td>
				</tr>
				<tr>
					<td>2</td>
					<td><label>THEME::*</label></td>
					<td><input id="THEME" tabindex="1" maxlength="20" size="20"	name="THEME" autocomplete="off" 	value="merchant">
					</td>
				</tr>
				<tr>
					<td>2</td>
					<td><label>WEBSITE::*</label></td>
					<td><input id="WEBSITE" tabindex="1" maxlength="20" size="20"	name="WEBSITE" autocomplete="off" 	value="http://ecocapitalfx.com/">
					</td>
				</tr>
 <tr>
                                        <td>2</td>
                                        <td><label>Login theme::*</label></td>
                                        <td><input id="THEME" tabindex="1" maxlength="20" size="20"     name="LOGIN_THEME" autocomplete="off"         value="">
                                        </td>
                                </tr>

				<tr>
					<td>3</td>
					<td><label>CUSTID ::*</label></td>
					<td><input id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value='RajeshHDFC'></td>
				</tr>
				<tr>
					<td>4</td>
					<td><label>MID ::*</label></td>
					<td><input id="MID" tabindex="1" maxlength="20" size="20"
						name="MID" autocomplete="off"
						value="klbGlV59135347348753" >
					</td>
				</tr>
				<tr>
					<td>5</td>
					<td><label>INDUSTRY_TYPE_ID ::</label></td>
				<td><input id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail"></td>
				</tr>
				<tr>
					<td>6</td>
					<td><label>Channel ::</label></td>
					<td><input id="CHANNEL_ID" tabindex="4" maxlength="12"
						size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
					</td>
				</tr>
				<!-- <tr>
					<td>7</td>
					<td><label>Cust_DOB ::</label></td>
					<td><input id=tail"DOB" tabindex="5" maxlength="12" size="12" name="DOB" autocomplete="off" value="04/12/1980"></td>
				</tr> -->
				<tr>
					<td>8</td>
					<td><label>txnAmount</label></td>
					<td><input title="TXN_AMOUNT" tabindex="10"
						type="text" name="TXN_AMOUNT"
						value="1">
					</td>
				</tr>
				<tr>
					<td>9</td>

					<td><label>AUTH_MODE</label></td>

					<td><input title="Is Email Id Verified" tabindex="10"
						type="text" name="AUTH_MODE"
						value="3D">
					</td>
				</tr>
				<tr>
					<td>10</td>
					<td><label>Web site ::</label></td>
					<td><input id="WEBSITE" title="Web Site Name" tabindex="10"
						type="text" name="WEBSITE" value="retail">
					</td>
				</tr>
<tr>	<td>9</td>	
					<td><label>SSO TOKEN</label></td>

					<td><input title="SSO_TOKEN" tabindex="100"
						type="text" name="SSO_TOKEN"
						value="">
						
					</td>
				</tr>
				
				<tr>
					<td>1o</td>
                                        <td><label>Token Type:</label></td>
                                        <td>
						<select name="TOKEN_TYPE">
							 <option value="OAUTH">OAUTH</option>
                                            		<option value="SSO">SSO</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>11</td>
					<td><label>PAYMENT_MODE::*</label></td>
					<td><select name="PAYMENT_TYPE_ID">
							<option value="CC"
								>Credit
								Card</option>
							<option value="DC"
								>Debit
								Card</option>
							<option value="NB"
								>Net
								Banking</option>
<option value="PPI"
								>Wallet</option>
<option value="ATM"  >ATM Cards</option>
<option value="COD">COD</option>				
	</select>
					
				<!-- <tr>
					<td>22</td>
					<td><label>ORDER_DETAILS ::</label></td>
					<td><input dir="rtl" id="ORDER_DETAILS"
						title="Is Email Id Verified" tabindex="10" type="text"
						name="ORDER_DETAILS" value="ORDERDETAILS">
					</td>
				</tr> 
				<tr>
					<td>23</td>
					<td><label>Comments ::</label></td>
					<td><input id="COMMENTS" title="Is Email Id Verified"
						tabindex="10" type="text" name="COMMENTS" value="COMMENTS">
					</td>
				</tr>
				-->
<tr>
                                        <td>27</td>
                                        <td><label>PAYMENT_MODE_ONLY ::*</label></td>
                                         <td><input id="selbank" title="PAYMENT_MODE_ONLY" tabindex="10"
size="35" maxlength="50" name="PAYMENT_MODE_ONLY" value="CC"
type="text">
                                        </td>
                                </tr>

				<tr>
					<td>27</td>
					<td><label>BANK NAME ::*</label></td>
					 <td><input id="selbank" title="BANKCODE" tabindex="10"	size="35" maxlength="50" type="text" name="BANK_CODE"
						value="ICICI">
					</td> 
				</tr>


<tr>
					<td>12</td>
					<td><label>EMAIL ::*</label></td>
					<td><input id="EMAIL" tabindex="9" maxlength="50" size="50"	name="EMAIL" autocomplete="off" value="testone@tarangtech.com">
					</td>
				</tr>

                                <tr>
                                        <td>9</td>

                                        <td><label>MOBILE_NO ::</label></td>

                                        <td><input id="MOBILE_NO" tabindex="6" maxlength="14" size="14"  name="MOBILE_NO" value=""></td>
                                </tr>



				<!-- <tr>
					<td>9</td>

					<td><label>PAN_CARD ::</label></td>

					<td><input id="PAN_CARD" tabindex="6" maxlength="12" size="12"	name="PAN_CARD" autocomplete="off" value="PAN12334"></td>
				</tr>

				<tr>
					<td>10</td>

					<td><label>Driving License ::</label></td>

					<td><input id="DL_NUMBER" tabindex="7" maxlength="12" size="12" name="DL_NUMBER" autocomplete="off" value="DL12334">
					</td>
				</tr>

				<tr>
					<td>11</td>
					<td><label>MOBILE_NO::*</label></td>

					<td><input id="MSISDN" tabindex="8" maxlength="12" size="12" name="MSISDN" autocomplete="off" value="9986713209"></td>
				</tr>
				<tr>
					<td>12</td>
					<td><label>EMAIL ::*</label></td>
					<td><input id="EMAIL" tabindex="9" maxlength="50" size="50"	name="EMAIL" autocomplete="off" value="testone@tarangtech.com">
					</td>
				</tr>
				<tr>
					<td>13</td>
					<td><label>Verified By</label></td>
					<td><input id="VERIFIED_BY" tabindex="9" maxlength="50"	size="50" name="VERIFIED_BY" value="Bond"></td>
				</tr>
				<tr>
					<td>14</td>
					<td><label>Is Email Id Verified? ::*</label></td>
					<td><input id="ISEMAILVERIFIED" title="Is Email Id Verified" type="checkbox" name="ISEMAILVERIFIED" checked></td>
				</tr>
				<tr>
					<td>15</td>
					<td><label>Address One</label></td>
					<td><input id="ADDRESS_1" title="Is Email Id Verified"	tabindex="10" type="text" name="ADDRESS_1" value="56"></td>
				</tr>
				<tr>
					<td>16</td>

					<td><label>Address Two</label></td>

					<td><input id="ADDRESS_2" title="Is Email Id Verified"	tabindex="10" type="text" name="ADDRESS_2" value="1st A cross">
					</td>
				</tr>
				<tr>
					<td>17</td>
					<td><label>City</label></td>
					<td><input id="CITY" title="Is Email Id Verified" tabindex="10" type="text" name="CITY" value="BANGALORE"></td>
				</tr>
				<tr>
					<td>18</td>
					<td><label>STATE</label></td>
					<td><input id="STATE" title="Is Email Id Verified"
						tabindex="10" type="text" name="STATE" value="KARNATAKA">
					</td>
				</tr>
				<tr>
					<td>19</td>

					<td><label>pincode</label></td>

					<td><input id="PINCODE" title="Is Email Id Verified"	tabindex="10" type="text" name="PINCODE" value="560048"></td>
				</tr>
				<!-- <tr>
					<td>26</td>
					<td><label>CheckSumOrder</label>
					</td>
					<td><textarea rows="6" cols="50" name="checkSumOrder"	id="checkSumOrder">Order_Id</textarea>
					</td>
				</tr> -->
				<tr>
					<td>26</td>
					<td><label>Merchant Key</label>
					</td>
					<td><input title="merchantKey" tabindex="10"
						type="text" name="merchantKey"
						value="M3dOwFqXl6o#&CD2umqCW@7NlH0qyDA2">
					</td>
				</tr>
		<!--	 <tr>
					<td>28</td>
					<td><label>Merchant Callback</label>
					</td>
					<td><input  tabindex="10"
						type="text" name="CALLBACK_URL">
					</td>
				</tr> -->
<tr>
					<td>29</td>
					<td><label>Promocode</label>
					</td>
					<td><input  tabindex="10"
						type="text" name="PROMO_CAMP_ID" />
					</td>
				</tr>
<tr>
					<td>30</td>
					<td><label>Request Type</label>
					</td>
					<td><input  tabindex="10"
						type="text" name="REQUEST_TYPE" value="DEFAULT"/>
					</td>
				</tr>
<tr>
					<td>31</td>
					<td><label>Subscription ID</label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBSCRIPTION_ID" value="12344555" />
					</td>
				</tr>
<tr>
					<td>32</td>
					<td><label>Subscription Service ID</label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBS_SERVICE_ID" value="abcd1234" />
					</td>
				</tr>
<tr>
					<td>33</td>
					<td><label>Subscription Amount Type</label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBS_AMOUNT_TYPE" value="VARIABLE"/>
					</td>
				</tr>		
<tr>
					<td>34</td>
					<td><label>Subscription Max Amount </label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBS_MAX_AMOUNT" value="100"/>
					</td>
				</tr>
<tr>
					<td>35</td>
					<td><label>Subscription Frequency </label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBS_FREQUENCY" value="1"/>
					</td>
				</tr>
<tr>
					<td>36</td>
					<td><label>Subscription Frequency Unit </label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBS_FREQUENCY_UNIT" value="MONTH" />
					</td>
				</tr>
<!--<tr>
					<td>37</td>
					<td><label>Subscription Start Date </label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBS_START_DATE" value="2014-11-15"/>
					</td>
				</tr>	
<tr>
					<td>38</td>
					<td><label>Subscription Grace Days </label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBS_GRACE_DAYS" value="5"/>
					</td>
				</tr> -->
<tr>
					<td>39</td>
					<td><label>Subscription Retry Enabled </label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBS_ENABLE_RETRY" value="0"/>
					</td>
				</tr>	
<!--<tr>
					<td>40</td>
					<td><label>Subscription Retry Count </label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBS_RETRY_COUNT" value="5"/>
					</td>
				</tr> -->
<tr>
					<td>41</td>
					<td><label>Subscription Expiry Date </label>
					</td>
					<td><input  tabindex="10"
						type="text" name="SUBS_EXPIRY_DATE" value="2016-12-01"/>
					</td>
				</tr>		
				<tr>
					<td></td>
					<td><input value="Pay in Iframe" type="submit" onClick="javascript:payInIframe();"></td>
					<td><input name="pay-btn" value="Pay" type="submit"	onclick="javascript:processTransaction();"></td>
					<td><!--<input value="CalculateChecksum" type="button"	onclick="javascript:calculateCheckSum();"> --></td>
				</tr>
			</tbody>
		</table>
		* - Mandatory Fields
	</form>
	<select name="selAcct" onChange="return Android.showLog('onchange!')"><option selected="selected">- Select An Account -</option><option value="00441140237633  " >00441140237633   - DLF PHASE I</option></select>
</body>
</html>

