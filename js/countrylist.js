// Change Your home URL..
home_url = 'http://192.168.1.101/server1/gtab/business_new/';

/* *
 *     fileName - ajax file name to be called by ajax method.
 *     data - pass the infromation(like location-id , location-type) via data variable.
 *     loadDataToDiv - id of the div to which the ajax responce is to be loaded.
 * */
function ajax_call(fileName,data, loadDataToDiv) {
	jQuery("#"+loadDataToDiv).html('<option selected="selected">-- -- -- Loding Data -- -- --</option>');

	//  If you are changing counrty, make the state and city fields blank
	if(loadDataToDiv=='state'){
		jQuery('#city').html('');
		jQuery('#state').html('');                    
	}
	//  If you are changing state, make the city fields blank
	if(loadDataToDiv=='city'){
		jQuery('#city').html('');
	}
	
	jQuery.post(home_url + '/' + fileName + '.php', data, function(result) {
		jQuery('#' + loadDataToDiv).html(result);
	});
}
      