/*!
* JAXTO javaScript
*/
//jQuery(function(){
	
jQuery(document).ready(function($){
	
	jQuery('.selectpicker').select2({theme: "templete-blue"});
	
	var country_list = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","South Africa","South Korea","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United Arab Emirates","United Kingdom","Uruguay","Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

	
	//-------------------------------
	// Input field
	//-------------------------------
	jQuery('#singleFieldTags').tagit({
		availableTags: keywords_list,
		singleField: true,
		singleFieldNode: jQuery('#mySingleField'),
		allowSpaces: true
	});
	
	//-------------------------------
	// Read only
	//-------------------------------
	jQuery('#readOnlyTags').tagit({
		readOnly: true
	});
	
	
	jQuery( ".cmdSubmitWoData" ).live( "click", function() 
	{
		var email = jQuery.trim(jQuery('#txtemail').val());
		var website=jQuery.trim(jQuery('#txtwebsite').val());
		var username=jQuery.trim(jQuery('#txtusername').val());
		var wp_key=jQuery.trim(jQuery('#txtwc-api-key').val());
		var wo_sec=jQuery.trim(jQuery('#txtwc-api-secret').val());
		
		// Checking Empty Fields
		if (email.length == 0 || website=="" || username=="" || wp_key=="" || wo_sec=="" ) 
		{
			alert('All fields are mandatory');
			return false;
		}
		
		if (validateEmail(email) !==true)
		{
			alert('Bad!! your Email is not valid..');
			jQuery('#txtemail').focus();
			return false;
		}
		
		if (validateUrl(website) !==true) 
		{
			alert('Bad!! your Url is not valid..');
			jQuery('#txtwebsite').focus();
			return false;
		}
		var data = jQuery('#jaxto_wo_setup_form').serialize();
		var formid ='#jaxto_wo_setup_form';
		
		jQuery.ajax({
			url	:ajaxurl,
			data:data + '&action=save_jaxto_wo_data',
			type:'POST',
			dataType: 'json',
			beforeSend: function(){
				jQuery('.cmdSubmitWoData').val('Sending...');
				jQuery('.cmdSubmitWoData').attr('disabled', 'disabled');
			},
			success:function(data)
			{
				if(data.results !==0)
				{
					alert('Thank You! Please fill Store/App Details.');
					jQuery('#row_group_store').css('display','flex');
					jQuery('#row_group_app').css('display','flex');
				}
				else
				{
					alert('Unable to process your request.');
				}
				
				jQuery(".cmdSubmitWoData").css("background","#ddd");
				var e ='<div class="md-ripple-container"><button class="editbutton" data-form="jaxto_wo_setup_form" type="button"> Edit </button></div>';
				jQuery(formid+' #jaxto_form_footer').html(e);
				jQuery(formid+' input').prop('disabled', true);
				jQuery(formid+' label').css('top', '-18px');
				jQuery(formid+' label').css('font-size', '12px');
				
			}
		});
		return false;
	});
	
	
	jQuery( ".cmdSubmitStoreData" ).live( "click", function() 
	{	
		
		var storename 	= jQuery.trim(jQuery('#txtstorename').val());
		var storedesc	=jQuery.trim(jQuery('#txtstoredesc').val());
		var storecategory =jQuery.trim(jQuery('#txtstorecategory').val());
		var deliverylocation =jQuery.trim(jQuery('#txtdeliverylocation').val());
		var storelocation =jQuery.trim(jQuery('#txtstorelocation').val());
		var keywords =jQuery.trim(jQuery('#mySingleField').val());
		var wpnonce =jQuery.trim(jQuery('#_wpnonce').val());
		
		var data = jQuery('#jaxto_store_form').serialize();
		var formid ='#jaxto_store_form';
		// Checking Empty Fields
		if (storename == "" || storedesc=="" || storecategory=="" || deliverylocation=="" || storelocation=="" || keywords=="" || wpnonce =="") 
		{
			alert('All fields are mandatory');
			return false;
		}
		
		jQuery.ajax({
			url	:ajaxurl,
			data:data+'&deliverylocation='+deliverylocation+'&action=save_jaxto_storedetails',
			type:'POST',
			dataType: 'json',
			beforeSend: function(){
				jQuery('.cmdSubmitStoreData').val('Sending...');
				jQuery('.cmdSubmitStoreData').attr('disabled', 'disabled');
			},
			success:function(data)
			{
				//alert(JSON.stringify(data));
				if(data.results !==0)
				{
					alert('Thank You! Details submitted successfully.');
				}
				else
				{
					alert('Unable to process your request.');
				}
				
				var e ='<div class="md-ripple-container"><button class="editbutton" data-form="jaxto_store_form" type="button"> Edit </button></div>';
				jQuery(formid+' #jaxto_form_footer').html(e);
				jQuery(formid+' input').prop('disabled', true);
				jQuery(formid+' label').css('top', '-18px');
				jQuery(formid+' label').css('font-size', '12px');
				jQuery(formid+' select').attr('disabled','disabled');
			},
			error(er)
			{
				//alert(JSON.stringify(er));
			}
		});
		
		return false;
	});
	
	jQuery( ".cmdSubmitAppData" ).live( "click", function() 
	{
		var data = jQuery('#jaxto_app_form').serialize();	
		var formid ='#jaxto_app_form';	
		
		jQuery.ajax({
			url	:ajaxurl,
			data:data+'&action=save_jaxto_appdetails',
			type:'POST',
			dataType: 'json',
			beforeSend: function(){
				jQuery('.cmdSubmitAppData').val('Sending...');
				jQuery('.cmdSubmitAppData').attr('disabled', 'disabled');
			},
			success:function(data)
			{
				//alert(JSON.stringify(data));
				if(data.results !==0)
				{
					alert('Thank You! Details submitted successfully.');
				}
				else
				{
					alert('Unable to process your request.');
				}
				var e ='<button class="editbutton" data-form="jaxto_app_form" type="button"> Edit </button>';
				jQuery(formid+' #jaxto_form_footer').html(e);
				jQuery(formid+' input').prop('disabled', true);
				jQuery(formid+' label').css('top', '-18px');
				jQuery(formid+' label').css('font-size', '12px');
			}
		});
		
		return false;
	});
	
	//tooltip 
	jQuery("#tooltipbox_sec,#tooltipbox_key").click(function() {
		jQuery('html, body').animate({
			scrollTop: jQuery("#apphelp").offset().top
		}, 2000);
	});

	jQuery('#insert-my-media').click(function()
	{
		if (this.window === undefined) {
			this.window = wp.media({
					title: 'Insert a media',
					library: {type: 'image'},
					multiple: false,
					button: {text: 'Insert'}
				});

			var self = this; // Needed to retrieve our variable in the anonymous function below
			this.window.on('select', function() {
					var first = self.window.state().get('selection').first().toJSON();
					//alert(JSON.stringify(first));
					jQuery("#txtlogourl").val(first.url);
					jQuery("#blah").attr("src", first.url);
				});
		}

		this.window.open();
		return false;
	});
	
	
	jQuery( ".editbutton" ).live( "click", function() 
	{
		var formid =jQuery(this).data('form');
		
		jQuery('#'+formid+' input').prop('disabled', false);
		jQuery('#'+formid+' label').css('top', '0');
		jQuery('#'+formid+' label').css('font-size', '15px');
		
		if(formid =='jaxto_wo_setup_form')
		{
			var s ='<input type="submit" value="Update" class="cmdSubmitWoData" id="save-jaxto-settings"/>';
			var c ='<input type="button" data-form="jaxto_wo_setup_form" class="cancelbutton" value="Cancel">';
			
			jQuery('#'+formid+' #jaxto_form_footer').html(s+c);
		}
		else if(formid =='jaxto_store_form')
		{
			var s ='<input type="submit" value="Update" class="cmdSubmitStoreData" id="save-jaxto-settings"/>';
			var c ='<input type="button" data-form="jaxto_store_form" class="cancelbutton" value="Cancel">';
			
			jQuery('#'+formid+' #jaxto_form_footer').html(s+c);
			jQuery('#'+formid+' select').removeAttr('disabled');
		}
		else if(formid =='jaxto_app_form')
		{
			var s ='<input type="submit" value="Update" class="cmdSubmitAppData" id="save-jaxto-settings"/>';
			var c ='<input type="button" data-form="jaxto_app_form" class="cancelbutton" value="Cancel">';
			
			jQuery('#'+formid+' #jaxto_form_footer').html(s+c);
		}
	});
	
	
	jQuery( ".cancelbutton" ).live( "click", function() 
	{
		var formid =jQuery(this).data('form');
		
		jQuery('#'+formid+' input').prop('disabled', true);
	    jQuery('#'+formid+' label').css('top', '-18px');
		jQuery('#'+formid+' label').css('font-size', '12px');
		
		if(formid =='jaxto_wo_setup_form')
		{
			var e ='<div class="md-ripple-container"><button class="editbutton" data-form="jaxto_wo_setup_form" type="button"> Edit </button></div>';
			jQuery('#'+formid+' #jaxto_form_footer').html(e);
		}
		else if(formid =='jaxto_store_form')
		{
			var e ='<div class="md-ripple-container"><button class="editbutton" data-form="jaxto_store_form" type="button"> Edit </button></div>';
			jQuery('#'+formid+' #jaxto_form_footer').html(e);
			jQuery('#'+formid+' select').attr('disabled','disabled');
		}
		else if(formid =='jaxto_app_form')
		{
			var e ='<button class="editbutton" data-form="jaxto_app_form" type="button"> Edit </button>';
			jQuery('#'+formid+' #jaxto_form_footer').html(e);
		}
	});

});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#layoutSetting #blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}


function toggleproviderkeys(idp)
{
	if(typeof jQuery=="undefined")
	{
		alert( "Error: JAXTO require jQuery to be installed on your wordpress in order to work!" );

		return;
	}

	if(jQuery('#jaxto_settings_' + idp + '_enabled').val()==1)
	{
		jQuery('.jaxto_tr_settings_' + idp).show();
	}
	else
	{
		jQuery('.jaxto_tr_settings_' + idp).hide();
		jQuery('.jaxto_div_settings_help_' + idp).hide();
	}

	return false;
}

function toggleproviderhelp(idp)
{
	if(typeof jQuery=="undefined")
	{
		alert( "Error: JAXTO require jQuery to be installed on your wordpress in order to work!" );

		return false;
	}

	jQuery('.jaxto_div_settings_help_' + idp).toggle();

	return false;
}

function validateEmail(email) {
	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	return expr.test(email);
};

function validateUrl(url) {
    return /^(http?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}
