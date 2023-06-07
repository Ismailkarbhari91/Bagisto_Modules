jQuery(document).ready(function($) {

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] === sParam) {
                return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };

    var email = getUrlParameter('email');
    var subject=getUrlParameter('subject');
    var des=getUrlParameter('des');
	var fname=getUrlParameter('fname');
	var lname=getUrlParameter('lname');
	var phone=getUrlParameter('phone');
	

   
    $('#billing_email').val(email);
	 $('#billing_first_name').val(fname);
	 $('#billing_last_name').val(lname);
	 $('#billing_phone').val(phone);
    $('#custom_field_name').val(subject);
    $('#custom_field_name1').val(des);
   
    
});