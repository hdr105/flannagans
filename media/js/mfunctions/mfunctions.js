//Function to save comments in the form where located
	function postComments(jData){
		if($('#'+jData.control_id).val()==''){
			$( ".error_comments-"+jData.control_id ).empty();
			$( ".error_comments-"+jData.control_id ).append( '<p style="color:red;">Please Enter Comments</p>' );
		}else {
			jData['comments'] = $('#'+jData.control_id).val();
			$.ajax({
				type: 'POST',
				data: jData,
				url: 'status?cfun=setcomments',
				success: function(data) {   
					$( ".comments-"+jData.control_id ).prepend(data);
					$('#'+jData.control_id).val('');
					$( ".error_comments-"+jData.control_id ).empty();
				}
			});
		}
	}

//Function to save comments in the form where located
 function getComments(jData){
  $.ajax({
   type: 'POST',
   data: jData,
   url: 'status?cfun=setcommentspopup',
   success: function(data) {   
    bootbox.alert(data);
   }
  });
 }
	//Function to show hide the divs on conditions
	//divDisplaySet(['date_added_sage','comment_sage'],['allhide','1','allshow'],this.id);
	//divDisplaySet(['date_added_iris','comment_iris'],['allhide','1','allshow'],this.id);
	//divDisplaySet(['date_added_kashflow','comment_kashflow'],['allhide','1','allshow'],this.id);
	//divDisplaySet(['Code_1','Date_Received_1','Comments_1','post_1'],['allhide','2','allshow'],this.id);
	//divDisplaySet(['Date_Requested','Date_Paid','Comments_other'],['allhide','allshow'],this.id);
	//divDisplaySet(['Date_issued_wife','Payment_Date_in_Bank','Comments_wife'],['allhide','allshow'],this.id);
	//divDisplaySet(['Date_issued_kids','Payment_Date_in_Bank_kids','Comments_kids'],['allhide','allshow'],this.id);
	//divDisplaySet(['Acc_Name','Acc_Address','Acc_Email','Acc_Phone','Acc_Fax','Acc_Website','Due_Date'],['allshow','allhide'],this.id);
	//divDisplaySet(['Letter_Title','	Letter_Date','Business_Name','Our_Ref','Business_Address','Client_ID','HMRC_Ref','Start_Date','End_Date',],['allshow','allhide'],this.id);
  
	function divDisplaySet(fields,condition,id){
		$.each(condition, function( index, value ) {
			//alert($('#'+id).val()+' -- '+index);
			if(index == $('#'+id).val()){
				if(value=='allhide'){
					$.each(fields, function( index_fields, value_fields ) {
						if(value_fields+'_ID'){
							document.getElementById(value_fields+'_ID').style.display="none";
							$('#'+value_fields+'_ID').find('input, textarea, button, select').prop("disabled", true);
						}
					});
				} else if(value=='allshow'){
					$.each(fields, function( index_fields, value_fields ) {
						if(value_fields+'_ID'){
							document.getElementById(value_fields+'_ID').style.display="block";
							$('#'+value_fields+'_ID').find('input, textarea, button, select').prop("disabled", false);
						}
					});
				} else {
					$.each(fields, function( index_fields, value_fields ) {
						if(value_fields+'_ID'){
							document.getElementById(value_fields+'_ID').style.display="none";
							$('#'+value_fields+'_ID').find('input, textarea, button, select').prop("disabled", true);
						}
					});

					$.each(fields, function( index_fields, value_fields ) {
						//alert(index_fields+' -- '+value);
						if(value == index_fields){
							if(value_fields+'_ID'){
								document.getElementById(value_fields+'_ID').style.display="block";
								$('#'+value_fields+'_ID').find('input, textarea, button, select').prop("disabled", false);
							}
						}/* else {
							if(fields[index-1]+'_ID'){
								document.getElementById(fields[index-1]+'_ID').style.display="none";
								$('#'+fields[index-1]+'_ID').find('input, textarea, button, select').prop("disabled", true);
							}
						}*/
					});
				}
			}
		});
	}


	$( document ).ready(function() {
  // Get all the inputs into an array...
		var $inputs = $('.form-body :input');
		$inputs.each(function (index){
			var datastring = $(this).attr('onclick');
			if(datastring != undefined){
				if(datastring.indexOf('divDisplaySet')){
					var radioname = $(this).attr('id');
					if(radioname){
						if(document.getElementById(radioname).checked){
							if($('#'+radioname).attr('type')=='checkbox'){
								var counter = parseInt($('#'+radioname).val())+1;
								//$('#frm_accordion_'+counter).show();
								$('#frm_accordion_'+counter).parent().toggle();
								$('#frm_accordion_'+counter).parent().find('input, textarea, button, select').prop("disabled", false);
							} else {
								$('#'+radioname).click();
							}
						}
					}
				}
			}
		});
	});

	// Kamran
	    $(document).ready(function(){
        $allRadios = $('input[type="radio"]');
       $allRadios.each(function(){
            var thisRadio = $(this).attr('name');
            var checked = false;
            var toClick;
            $('input[name="'+thisRadio+'"]').each(function(){
                var checkChecked = $(this).is(':checked');
                if(checkChecked){ checked = true;}
                var thisValue = $(this).val();
                if (thisValue =='0') {
                    toClick = $(this);
                }
            });
            if (!checked) {
                toClick.trigger('click');
                toClick.attr('checked',true);
                toClick.parent().addClass('checked');
            }
       });
        
    });
	// Kamran

	function GetQueryStringParams(sParam){
	    var sPageURL = window.location.search.substring(1);
	    var sURLVariables = sPageURL.split('&');
	    for (var i = 0; i < sURLVariables.length; i++) 
	    {
	        var sParameterName = sURLVariables[i].split('=');
	        if (sParameterName[0] == sParam) 
	        {
	            return sParameterName[1];
	        }
	    }
	}

	//toggleAccordian(this.value);
	function toggleAccordian(id){
		$( ".panel-default:eq( "+id+" )" ).toggle();
		if ( document.getElementById('dataServicesServi'+id).checked )
			$(".panel-default:eq( "+id+" )").find('input, textarea, button, select').prop("disabled", false);
		else
			$(".panel-default:eq( "+id+" )").find('input, textarea, button, select').prop("disabled", true);
	}

	var com_id = GetQueryStringParams('com_id');
	if(com_id==70){
		var numItems = $('.panel-default').length;
		$('.panel-default').slice(1).find('input, textarea, button, select').prop("disabled", true);
		$('.panel-default').slice(1).hide();
	}



	function changevalues(id){
		var res = id.split("-"); 
		if($('#'+id).prop("checked") == true){
			$('#uniform-'+id).parent().parent().find('input, textarea, button, select').prop("disabled", false);
			$('#'+id).parent().parent().find('input, textarea, button, select').prop("disabled", false);
			$('#'+res[1]).prop("disabled", false);
			$('#'+id).prop("disabled", false);
			$('#'+res[1]).val('1');
		} else {
			$('#uniform-'+id).parent().parent().find('input, textarea, button, select').prop("disabled", true);
			$('#'+id).parent().parent().find('input, textarea, button, select').prop("disabled", true);
			$('#'+res[1]).prop("disabled", false);
			$('#'+id).prop("disabled", false);
			$('#'+res[1]).val('0');
		}
	}

function check_calendar(id, control_id){
	if( !$('#'+id).has('option').length > 0 ) {
		var strAlertSuccess = '<div class="alert alert-danger" style="position: fixed; right:10px;  z-index: 99999; top: 10%; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;"><button data-dismiss="alert" class="close" type="button">×</button>There is no calendar in the list.</div>';
		var alertSuccess = $(strAlertSuccess).appendTo('body');
		alertSuccess.show();
		setTimeout(function(){ 
			alertSuccess.remove();
		},2000);
		$('#'+control_id).attr('checked', false);
	}
}


change_job_category_onload('dataJobsJob_category');
show_job_accordians_onload('dataJobsJob_sub_category');

//onchange, change_job_category(this.id);
function change_job_category(id){
	var job_type = $('#'+id).val();
	$('#section_4').hide();	
	if(job_type == 1){
		$('#dataJobsJob_sub_category')
		.find('option')
		.remove()
		.end()
		.append('<option value=""></option><option value="1">Letter/Official Document</option><option value="2">Tax Planning</option><option value="3">Inheritance</option><option value="4">General Advice</option><option value="5">Other</option>');
		$('#dataJobsJob_sub_category').val('');
	} else if(job_type == 2){
		$('#dataJobsJob_sub_category')
		.find('option')
		.remove()
		.end()
		.append('<option value="6">VAT</option><option value="7">Payroll</option><option value="8">Annual Returns</option><option value="9">Accounts</option><option value="10">Tax</option><option value="11">CT600</option><option value="12">Self Assessment</option>');
		$('#dataJobsJob_sub_category').val('');

	}

	$(".select2, .select2-multiple").select2({
        placeholder: "Select...",
        width: null
    });

    $(".select2-allow-clear").select2({
        allowClear: true,
        placeholder: "Select...",
        width: null
    });
}

//onchange, show_job_accordians(this.id);
function show_job_accordians(id){
	if($('#dataJobsBusiness').val()!=''){
		var job_sub_type = $('#'+id).val();
		var service_name = $("#"+id+" option[value='"+job_sub_type+"']").text();
		$('#section_4 > div > h4 > a').text(service_name+' Status');
		$('#Paperwork_Requested_Date_ID > div > label').text('Paperwork Requested Date');
		$('#Paperwork_Received_Date_ID > div > label').text('Paperwork Received Date');
		$('#Communication_Method_ID > div > label').text('Communication Method');
		$('#section_4').hide();

		var service;

		if(job_sub_type == 6){
			$('#section_4').show();
			$('#Service_Date_ID > div > label').text(service_name+' QE Date');
			hideDivs(['Service_Ceasure_Date']);
			service=3;
			$.get(window.location.protocol + "//" + window.location.host + "/man/admin/scrud/status?cfun=setJobDetails&bid="+$('#dataJobsBusiness').val()+"&service="+service, function(data, status){
	        	var data = jQuery.parseJSON(data);
	        	$('#dataJobsExpected_start_date > input').val(data.expected_start_date);
	        	$('#dataJobsExpected_end_date > input').val(data.expected_end_date);
	        	$('#dataJobsService_Date > input').val(data.qe_date);
	        	$('#dataJobsDue_Date > input').val(data.expected_end_date);
	    	});
		} else if(job_sub_type == 7){
			$('#section_4').show();
			$('#Service_Date_ID > div > label').text(service_name+' Service Start Date');
			$('#Paperwork_Requested_Date_ID > div > label').text('Information Received Date');
			$('#Paperwork_Received_Date_ID > div > label').text('Wage Slips Supplied Date');
			hideDivs(['Amount_Due','Current_Payment_Method','Date_Client_Informed','Actual_Submission_Date']);
			service=5;
			$.get(window.location.protocol + "//" + window.location.host + "/man/admin/scrud/status?cfun=setJobDetails&bid="+$('#dataJobsBusiness').val()+"&service="+service, function(data, status){
	        	var data = jQuery.parseJSON(data);
	        	$('#dataJobsExpected_start_date > input').val(data.expected_start_date);
	        	$('#dataJobsExpected_end_date > input').val(data.expected_end_date);
	        	$('#dataJobsService_Date > input').val(data.staging_date);
	        	$('#dataJobsDue_Date > input').val(data.expected_end_date);
	        	$('#dataJobsService_Ceasure_Date > input').val(data.service_ceasor_date);
	    	});
		} else if(job_sub_type == 8){
			$('#section_4').show();
			$('#Service_Date_ID > div > label').text(service_name+' Date');
			hideDivs(['Amount_Due','Current_Payment_Method']);
			service=2;
			$.get(window.location.protocol + "//" + window.location.host + "/man/admin/scrud/status?cfun=setJobDetails&bid="+$('#dataJobsBusiness').val()+"&service="+service, function(data, status){
	        	var data = jQuery.parseJSON(data);
	        	$('#dataJobsExpected_start_date > input').val(data.expected_start_date);
	        	$('#dataJobsExpected_end_date > input').val(data.expected_end_date);
	        	$('#dataJobsService_Date > input').val(data.actual_submission_date);
	        	$('#dataJobsDue_Date > input').val(data.due_date);
	        	$('#dataJobsService_Ceasure_Date > input').val(data.service_ceasor_date);
	    	});
		} else if(job_sub_type == 9){
			$('#section_4').show();
			$('#Service_Date_ID > div > label').text(service_name+' Date');
			$('#Communication_Method_ID > div > label').text('Date Client Signed The Accounts');
			hideDivs(['Amount_Due','Current_Payment_Method','Service_Ceasure_Date']);
			service=1;
			$.get(window.location.protocol + "//" + window.location.host + "/man/admin/scrud/status?cfun=setJobDetails&bid="+$('#dataJobsBusiness').val()+"&service="+service, function(data, status){
	        	var data = jQuery.parseJSON(data);
	        	$('#dataJobsExpected_start_date > input').val(data.expected_start_date);
	        	$('#dataJobsExpected_end_date > input').val(data.expected_end_date);
	        	$('#dataJobsService_Date > input').val(data.year_end_date);
	        	$('#dataJobsDue_Date > input').val(data.due_date);
	        	$('#dataJobsService_Ceasure_Date > input').val(data.service_ceasor_date);
	    	});
		} else if(job_sub_type == 10){
			$('#section_4').show();
			$('#Service_Date_ID > div > label').text(service_name+' Date');
			hideDivs(['Amount_Due','Current_Payment_Method','Service_Ceasure_Date']);
			service=4;
			$.get(window.location.protocol + "//" + window.location.host + "/man/admin/scrud/status?cfun=setJobDetails&bid="+$('#dataJobsBusiness').val()+"&service="+service, function(data, status){
	        	var data = jQuery.parseJSON(data);
	        	$('#dataJobsExpected_start_date > input').val(data.expected_start_date);
	        	$('#dataJobsExpected_end_date > input').val(data.expected_end_date);
	        	$('#dataJobsService_Date > input').val(data.tax_year_date);
	        	$('#dataJobsDue_Date > input').val(data.due_date);
	    	});
		}

	}else{
		alert("Please select any Business first!!!");
	}
}
function hideDivs(id){
	var showids= ['Amount_Due','Current_Payment_Method','Date_Client_Informed','Actual_Submission_Date','Service_Ceasure_Date'];
	$.each(showids, function( index, value ) {
		$('#'+value+'_ID').find('input, textarea, button, select').prop("disabled", false);
		$('#'+value+'_ID').show();
	});
	$.each(id, function( index, value ) {
		$('#'+value+'_ID').find('input, textarea, button, select').prop("disabled", true);
		$('#'+value+'_ID').hide();
	});
}

function selectBusiness(){
	change_job_category('dataJobsJob_category');
}

function change_job_category_onload(id){
	var job_type = $('#'+id).val();
	var preselected = $('#dataJobsJob_sub_category').val();
	if(job_type == 1){
		$('#dataJobsJob_sub_category')
		.find('option')
		.remove()
		.end()
		.append('<option value=""></option><option value="1">Letter / Official Document </option><option value="2">Tax Planning</option><option value="3">Inheritance</option><option value="4">General Advice</option><option value="5">Other</option>');
		$('#dataJobsJob_sub_category').val(preselected);
	} else if(job_type == 2){
		$('#dataJobsJob_sub_category')
		.find('option')
		.remove()
		.end()
		.append('<option value="6">VAT</option><option value="7">Payroll</option><option value="8">Annual Returns</option><option value="9">Accounts</option><option value="10">Tax</option><option value="11">CT600</option><option value="12">Self Assessment</option>');
		$('#dataJobsJob_sub_category').val(preselected);
	} else {
		$('#dataJobsJob_sub_category')
		.find('option')
		.remove()
		.end();
	}
}

//onchange, show_job_accordians(this.id);
function show_job_accordians_onload(id){
	var job_sub_type = $('#'+id).val();
	var service_name = $("#"+id+" option[value='"+job_sub_type+"']").text();

	if(job_sub_type <= 5){
		$('#section_4').hide();
	} else if(job_sub_type >= 6 && job_sub_type <=10) {
		$('#section_4 > div > h4 > a').text(service_name+' Status');
		$('#Paperwork_Requested_Date_ID > div > label').text('Paperwork Requested Date');
		$('#Paperwork_Received_Date_ID > div > label').text('Paperwork Received Date');
		$('#Communication_Method_ID > div > label').text('Communication Method');		
	}

	if(job_sub_type == 6){
		$('#section_4').show();
		$('#Service_Date_ID > div > label').text(service_name+' QE Date');
		hideDivs(['Service_Ceasure_Date']);
	} else if(job_sub_type == 7){
		$('#section_4').show();
		$('#Service_Date_ID > div > label').text(service_name+' Service Start Date');
		$('#Paperwork_Requested_Date_ID > div > label').text('Information Received Date');
		$('#Paperwork_Received_Date_ID > div > label').text('Wage Slips Supplied Date');
		hideDivs(['Amount_Due','Current_Payment_Method','Date_Client_Informed','Actual_Submission_Date']);
	} else if(job_sub_type == 8){
		$('#section_4').show();
		$('#Service_Date_ID > div > label').text(service_name+' Date');
		hideDivs(['Amount_Due','Current_Payment_Method']);
	} else if(job_sub_type == 9){
		$('#section_4').show();
		$('#Service_Date_ID > div > label').text(service_name+' Date');
		$('#Communication_Method_ID > div > label').text('Date Client Signed The Accounts');
		hideDivs(['Amount_Due','Current_Payment_Method','Service_Ceasure_Date']);
	} else if(job_sub_type == 10){
		$('#section_4').show();
		$('#Service_Date_ID > div > label').text(service_name+' Date');
		hideDivs(['Amount_Due','Current_Payment_Method','Service_Ceasure_Date']);
	}
}