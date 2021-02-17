function select_state(){
	
	var countryId = $('#country_id').val();
	$.ajax({

		url  : SITEURL + 'admin/states-list',
		data : { "country_id" : countryId },
		dataType : "JSON",
		headers: headers,

		success : function (res){

			var options = '<option value="">Select State</option>';

			if (res.code === 200) {

				for (var i = 0; i < res.result.length; i++) {

					options = options + '<option value="'+res.result[i].id+'" sId="'+res.result[i].id+'">'+res.result[i].state_name+'</option>';
				} 
			}
			$("#state_id").html(options);

		},
		error: function(error) {

			$("#state_id").html('<option value="">States not found</option>');
			$("#city_id").html('<option value="">States not found</option>');
			$("#area_id").html('<option value="">Area not found</option>');

		}
	})
}

function select_city(){

	var stateId = $('#state_id').val();
    //alert(stateId);
    $.ajax({

    	url  : SITEURL + 'admin/cities-list',
    	data : { "state_id" : stateId },
    	dataType : "JSON",
    	headers: headers,

    	success : function (res){

    		var options = '<option value="">Select City</option>';

    		if (res.code === 200) {

    			for (var i = 0; i < res.result.length; i++) {

    				options = options + '<option value="'+res.result[i].id+'" sId="'+res.result[i].id+'">'+res.result[i].city_name+'</option>';
    			} 
    		}
    		$("#city_id").html(options);

    	},
    	error: function(error) {

    		$("#city_id").html('<option value="">States not found</option>');
    		$("#area_id").html('<option value="">Area not found</option>');

    	}
    })
}

function select_area(){
	
	var cityId = $('#city_id').val();
	$.ajax({

		url  : SITEURL + 'admin/areas-list',
		data : { "city_id" : cityId },
		dataType : "JSON",
		headers: headers,

		success : function (res){
			
			var options = '<option value="">Select Area</option>';

			if (res.code === 200) {

				for (var i = 0; i < res.result.length; i++) {
					
					options = options + '<option value="'+res.result[i].id+'" sId="'+res.result[i].id+'">'+res.result[i].area_name+'</option>';
				} 
			}
			$("#area_id").html(options);

		},
		error: function(error) {

			$("#area_id").html('<option value="">Area not found</option>');
			
		}
	})
}

