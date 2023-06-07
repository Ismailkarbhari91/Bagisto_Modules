jQuery(document).ready(function($) {
  	var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
		return typeof sParameterName[1] === undefined ? true :
		decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
	};
	
	var email = getUrlParameter('title');
	
	// localStorage.setItem("mytime", email);
	// var x = localStorage.getItem("mytime");
	// alert(x);

	var settings = {
  	// "url": "https://ns3.icashout.io/apnabazar/wp-json/area/v1/website_all",
    "url": "http://localhost/multisite_plugin//wp-json/area/v1/website_all",
  	"method": "POST",
  	"timeout": 0,
	};

	$.ajax(settings).done(function (response) {
//   	console.log(response);

  	var r = response;

  	var i;
  	var pageURL = $(location).attr("href");
    var input = '';
	for (i = 0; i < r.data.length; ++i) {
        
    var title = r.data[i][0]['title'];
    var url = r.data[i][0]['url'] +"/";
    var pincode = r.data[i][0]['pincode'];
    var address = r.data[i][0]['address'];
    console.log(address + pincode);
	var array_url = [url];
	console.log(array_url);
    input += "<div class='t'><div class='flex'><h5 class='htitle'>"+title+"</h5></div> <div class='v'><a href='"+url+'?title='+title+"' id='aref' class='aref'>Select Location</a></div></div><div class='adress'><h5>"+address+","+pincode+"</h5></div>";
		
		if(jQuery.inArray(pageURL, array_url) !== -1)
			{
				$(".popup").show();
			}
	}
// 		console.log(array_url);
	$(".apend").html(input);
	});
	
	var pageURL = $(location).attr("href");
    if (pageURL.includes('?'))
    {
    $(".popup").fadeOut(500);
            
    }
//     else if (pageURL == "https://ns3.icashout.io/apnabazar/") {
//     $(".popup").fadeOut(500);
//     } 
// 	 else if (pageURL == "https://ns3.icashout.io/apnabazar/products/") {
//     $(".popup").show();
//     } 
	if (pageURL.includes('?'))
	{
	$(".btnchange").html(email);
	}	
	else{
  	$(".btnchange").html("Order Online");
	}

    $("#test").on('keyup',function(e){
     e.preventDefault();
        
     titles = $('#test').val();

     var settings = {
            // "url": "https://ns3.icashout.io/apnabazar/wp-json/area/v1/website_like",
            "url": "http://localhost/multisite_plugin//wp-json/area/v1/website_like",
            "method": "POST",
            "timeout": 0,
            "headers": {
              "Content-Type": "application/json"
            },
            "data": JSON.stringify({
              "name": titles
            }),
      };
          
          $.ajax(settings).done(function (response) {
            var r = response;
            console.log(r);
            var i;
            var input = '';
        for (i = 0; i < r.data.length; ++i) {
                var title = r.data[i][0]['title'];
                var url = r.data[i][0]['url']+"/";
                var pincode = r.data[i][0]['pincode'];
                var address = r.data[i][0]['address'];
                console.log(address + pincode);
                input += "<div class='t'><div class='flex'><h5 class='htitle'>"+title+"</h5></div> <div class='v'><a href='"+url+'?title='+title+"' id='aref' class='aref'>Select Location</a></div></div><div class='adress'><h5>"+address+","+pincode+"</h5></div>";
		
        }
        $(".apend").html(input);
        });
    });


    $(".btnchange").click(function() {
        $(".popup").fadeIn(500);

        var origin   = wnm_custom.base_url;

        var settings = {
          // "url": "https://ns3.icashout.io/apnabazar/wp-json/area/v1/website_all",
          "url": "http://localhost/multisite_plugin//wp-json/area/v1/website_all",
          "method": "POST",
          "timeout": 0,
        };
        
        $.ajax(settings).done(function (response) {
//           console.log(response);

          	var r = response;
          	var i;
            var input = '';
        for (i = 0; i < r.data.length; ++i) {
                var title = r.data[i][0]['title'];
                var url = r.data[i][0]['url']+"/";
                var pincode = r.data[i][0]['pincode'];
                var address = r.data[i][0]['address'];
                console.log(address + pincode);
                // console.log(url);
                
                input += "<div class='t'><div class='flex'><h5 class='htitle'>"+title+"</h5></div> <div class='v'><a href='"+url+'?title='+title+"' id='aref' class='aref'>Select Location</a></div></div><div class='adress'><h5>"+address+","+pincode+"</h5></div>";
		
        }
        $(".apend").html(input);
        });
      });
      $(".close").click(function() {
        $(".popup").fadeOut(500);
        var order = "Order Online";
        window.location.href = "https://ns3.icashout.io/apnabazar/";
      });
});
  