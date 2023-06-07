jQuery(document).ready(function($) {
  $('#billing_custom_field').val('');
  
  //

   // Get the "Total" row
  

// Call the function to add the row
// addCustomRow();

  // 

 

  // $('.woocommerce-table__delivery_date').hide();
  // 
  $('#lpac-dps-order-type').on('change', function() {
  if ($('#lpac-dps-order-type').prop('checked')) {
    console.log('Checkbox is checked');
    $('#billing_custom_field').val('DoorDash');

    // 


    // 
  } else {
    $('#custom_field_fee').val('');
    $('#custom_field_delivery_time').val('');
    $('#billing_custom_field').val('');
  }
});

  if ($('body').hasClass('woocommerce-checkout')) {
    // Clear input values on page load/refresh
    $('#billing_phone').val('');
    $('#billing_email').val('');
    $('#billing_first_name').val('');
    $('#billing_last_name').val('');
    $('#billing_address_1').val('');
    $('#billing_address_2').val('');
    $('#billing_city').val('');
    $('#billing_postcode').val('');
    $('#billing_distance').val('');

   
    // 
   
     
  // Call the function to add the row
	
  //

  $.ajax ({
    type: 'POST',
    url: myAjax.ajaxurl,
    data: {
      'action': 'custom_shipping_fee_update',
    },
    success: function(result) {
        for(var i =0; i<2; i++){
          $(document.body).trigger('update_checkout');
        }
      },
  });
  }

  // 

 

  // 
    
  function enableCustomShippingMethod(callback) {
    var zipcode = $('#billing_postcode').val();
    var billing_city = $('#billing_city').val();
    var billing_address_1 = $('#billing_address_1').val();
    var billing_state = $('select[name=billing_state] option').filter(':selected').text();
    var orderTotal = parseFloat($('.order-total .woocommerce-Price-amount').text().replace(/[^0-9.-]+/g, ''));
    var fee = 0;
  
    var ajaxSettings = {
      type: 'POST',
      dataType: 'json',
      url: myAjax.ajaxurl,
      data: {
        action: 'get_kiosk_id',
      },
      success: function(response) {
        var kioskId = response.data.kioskId;
        var password = response.data.password;
        var innerAjaxSettings = {
          type: 'POST',
          dataType: 'json',
          url: myAjax.ajaxurl,
          data: {
            action: 'get_estimate',
            password: password,
            kioskId: kioskId,
            dropoff_address: {
              city: billing_city,
              state: billing_state,
              street: billing_address_1,
              unit: '',
              zip_code: zipcode
            },
            order_value: orderTotal
          },
          success: function(response) {
            fee = response.data.DoorDash.fee;
            var date_time = response.data.DoorDash.delivery_time;
            var fees = parseFloat(fee / 100);
  
            var o_type = $('.lpac-dps-current-order-type').text()

      
            $('#custom_field_fee').val(fees);
            $('#custom_field_delivery_time').val(date_time);
            console.log(billing_city);
          
            if (callback && typeof callback === 'function') {
              callback();
            }
          }
        };
  
        $.ajax(innerAjaxSettings);
      }
    };
  
    $.ajax(ajaxSettings);
  }
  
  function enables() {
    var enable;
    var fees = parseFloat($('#custom_field_fee').val());
  
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: myAjax.ajaxurl,
      data: {
        action: 'custom_shipping_validation',
      },
      success: function(response) {
        var range = response.data.area_range;
        var morder = response.data.minimum_order;
        var maximumDistance = parseFloat(range);
        // var distance = 1;
        var distance = $('#billing_distance').val();
        var orderTotal = parseFloat($('.order-total .woocommerce-Price-amount').text().replace(/[^0-9.-]+/g, ''));
  
        var date_time = $('#custom_field_delivery_time').val();
  
        var o_type = $('.lpac-dps-current-order-type').text()
      
        if (distance < maximumDistance && orderTotal > morder && !isNaN(fees)) {
          enable = true;
 
          // 

          function addCustomRow() {
            // Create the new row HTML
            var newRowHtml = '<tr class="custom-row">';
            newRowHtml += '<th scope="row">Estimated Delivery</th>';
            newRowHtml += '<td>'+date_time+'</td>';
            newRowHtml += '</tr>';
        
            // Insert the new row before the "Total" row
            $('.woocommerce-checkout-review-order-table tr.order-total').before(newRowHtml);
        }
        
        // Call the function to add the row
        addCustomRow();
        
        // Listen for dynamic updates on the checkout page
        $(document).on('updated_checkout', function() {
            addCustomRow();
        });

          // 
  
  
        } else {
          enable = false;
          if (o_type=='Delivery') {
          alert('Dropoff address not within service area or minimum order less, order amount must be greater than ' + morder + '.');
          }
        }
  
        // console.log(enable);
        // console.log()
  
        $.ajax ({
          type: 'POST',
          url: myAjax.ajaxurl,
          data: {
            'action': 'enable_custom_shipping_method',
            'enable': enable ? 'yes' : 'no',
            'fee': fees,
          },
          success: function(result) {
              console.log(typeof(fees));
              console.log("status"+enable);
            
              for(var i =0; i<2; i++){
                $(document.body).trigger('update_checkout');
              }
            },
        });
      }
    });
  }
  
  function updateDistance(zipCode) {
    $.ajax({
      url: myAjax.ajaxurl,
      method: 'POST',
      data: {
        action: 'update_distance',
        zip_code: zipCode
      },
      success: function(response) {
        $('#billing_distance').val(response);
        displayDistance(response);
        enableCustomShippingMethod(function() {
          enables();
        });
      },
      error: function(xhr, status, error) {
        console.log('Error:', error);
      },
    });
  }
  
  function displayDistance(distance) {
    // Update or display the distance value wherever needed
    // console.log('Distance:', distance);
    // You can modify this function to update the value in any other element on the page
  }
  
  $('#billing_postcode').on('change', function() {
    var zipCode = $(this).val();
    updateDistance(zipCode);
    
    
  });

  // $('#billing_postcode').trigger('change');


// 




// 


  // 
  
  var order_id;
  var oid
  
  $(".custom-class").click(function(e) {
    e.preventDefault();
    order_id = $(this).parent().parent().parent().attr("id").split("post-")[1];
    // alert(order_id);
    oid = parseInt(order_id);
              // if ( "'. $order->get_status() .'" !== "completed" ) {
                  tb_show("My Dialog", "#TB_inline?width=600&height=550&inlineId=custom-modal-dialog");
              // }
              return false;
          });
          // 
          $(".cancel-order-button").click(function() {
              var data = {
                  action: "cancel_order_status",
                  order_id: oid
              };

              // 

              $.ajax({
                type: 'POST',
                dataType: 'json',
                url: myAjax.ajaxurl,
                data: {
                  action: 'get_kiosk_id',
                },
                success: function(response) {
                  // Call the API with the retrieved kioskId
                  var kioskId = response.data.kioskId;

                  $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: myAjax.ajaxurl,
                    data: {
                    action: 'cancel_order',
                    wo_id: oid,
                    kioskId: kioskId,
                    },
                  success: function(response) {
                  }
                });
              }
              });

              // 
              jQuery.post(ajaxurl, data, function(response) {
                  // reload the page to show the updated order status
                  location.reload();
              });
          });
          // 
  
    
          var $section = $('<section>').addClass('popup');
          var $content = $('<div>').addClass('popup__content');
          var $closeBtn = $('<div>').addClass('close').append($('<span>'), $('<span>'));
          var $button = $('<button>').addClass('popup__button').text('Okk');
          var $dateInput = $('<input>').attr('type', 'datetime-local').attr('id', 'delivery_date');
          var $dateLabel = $('<label>').attr('for', 'delivery_date').text('Select Delivery Date');


// Add the text content and button to the popup
$content.text('Extra Fees May Be Occur That Should Barred By Your End, Customer Will Not Responsible For This');
$content.append($('<br>'),$dateLabel, $dateInput, $('<br>'), $button);
$content.append($button);

// Assemble the elements and append to the body
$content.append($closeBtn);
$section.append($content);
$('body').append($section);
    
var utcDateTime
// Add input event listener to date time input element
$dateInput.on('input', function() {
// Get the selected date and time as a Unix timestamp in milliseconds
var selectedTimestamp = $dateInput[0].valueAsNumber;

// alert(oid);

// Convert the Unix timestamp to UTC format
var date = new Date(selectedTimestamp);
var year = date.getUTCFullYear();
var month = date.getUTCMonth() + 1;
var day = date.getUTCDate();
var hours = date.getUTCHours();
var minutes = date.getUTCMinutes();
var seconds = date.getUTCSeconds();
var milliseconds = date.getUTCMilliseconds();
utcDateTime = year + '-' + pad(month) + '-' + pad(day) + 'T' + pad(hours) + ':' + pad(minutes) + ':' + pad(seconds) + '.' + pad(milliseconds, 6) + 'Z';

// Log the UTC date time value
console.log(utcDateTime);
// alert(utcDateTime);
});

// Helper function to pad numbers with leading zeros
function pad(num, size) {
var s = num + "";
while (s.length < size) {
s = "0" + s;
}
return s;
}

$("#recalculate-fee-button").click(function(e) {
  console.log("Button clicked");
  $(".popup").fadeIn(500);
  $("#TB_window").hide();
  $("#TB_overlay").hide();
   
});

$(".close").click(function(e) {
  $(".popup").fadeOut(500);
  location.reload(true);
});
 
  

    
      $(".popup__button").click(function() {
        
        var bfee;
        var afee;

        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: myAjax.ajaxurl,
          data: {
            action: 'get_kiosk_id',
          },
          success: function(response) {
            // Call the API with the retrieved kioskId
            var kioskId = response.data.kioskId;
        $.ajax({
        type: 'POST',
        dataType: 'json',
        url: myAjax.ajaxurl,
        data: {
        action: 'recalculating',
        wo_id: oid,
        kioskId: kioskId,
        delivery_time: utcDateTime,
        },
      success: function(response) {
      afee = response.data.fee;
// Call the second Ajax request inside the success function of the first one
        $.ajax({
        type: 'POST',
        dataType: 'json',
        url: myAjax.ajaxurl,
        data: {
        action: 'get_recal_estimate',
        wo_id: oid,
        kioskId: kioskId,
        },
      success: function(response) {
      bfee = response.data.fee;
     // Calculate tfee inside the success function of the second Ajax request
      // var tfee = afee - bfee;
      var tfee = afee;
    // Save tfee to a custom field in the WordPress order
      $.ajax({
      type: 'POST',
      dataType: 'json',
      url: myAjax.ajaxurl,
      data: {
      action: 'save_tfee',
      wo_id: oid,
      tfee: tfee
    },
    success: function(response) {
      console.log('tfee saved to custom field');

      // Update the order total on the WordPress admin dashboard

    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error(textStatus, errorThrown);
    }
  });
},
error: function(jqXHR, textStatus, errorThrown) {
  console.error(textStatus, errorThrown);
}
});
},
error: function(jqXHR, textStatus, errorThrown) {
console.error(textStatus, errorThrown);
}
});

},
error: function(error) {
// Handle the error
console.log(error);
}
});
// 
location.reload(true);
});        
});
// });