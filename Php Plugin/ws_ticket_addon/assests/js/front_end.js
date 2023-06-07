jQuery(document).ready(function($) {
	
  $("input:radio[name='radio']").on('click',function(e){


      // $('.details').css('background-color', 'white');
      $('.details').removeClass("ripple-btn-primary");
      $(this).closest('.details').addClass("ripple-btn-primary");
      

      // $(this).closest('.details').css('background-color', 'black');

      $(this).closest('.details').find('a').trigger('click');

      
    });

    
       
       
$("a.alt.wc-forward.wp-element-button").on('click',function(e){
  e.preventDefault();

  if ($("#eh_crm_ticket_form")[0].checkValidity())
  {

    if( $("input:radio[name='radio']").is(":checked"))
    {
    var origin=window.location.href;
    // var origin   = window.location.origin;

    // alert(origin);
  
  var email=$('#request_email').val();
//   var subject=$('#request_title').val();
		

		
  var subject=$('select[name=field_FV97] option').filter(':selected').text();
		
		
  var des=$('#request_description').val();
  var fname=$('#field_WF76').val();
  var lname=$('#field_KR99').val();
  var phone=$('#field_CW54').val();
	  
  url=origin+'checkout?email='+email+'&fname='+fname+'&lname='+lname+'&phone='+phone+'&subject='+subject+'&des='+des;
  window.location.href = url;
  }
  else
  {
    alert('Please Select Services');
  }
}
  else
  {
  //Validate Form
  $("#eh_crm_ticket_form")[0].reportValidity();
  e.preventDefault();
  }

});


   });
