<?php 
$CI = & get_instance();
///////////Condition in Field types////////////
$CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
foreach($CRUD_AUTH as $key => $value){
	if(is_array($value)){
		foreach($value as $inkey => $invalue){
			$$inkey = $invalue;
		}
	} else {
		$$key = $value;
	}
}
///////////////////////////////////////////////////

$key = $CI->input->post('key');
$lang = $CI->lang; 
$c_id = $_GET['com_id'];
?>
<script src="<?=base_url()?>media/ckeditor/ckeditor.js"></script>
<!--MODULE START-->
<style type="text/css">.form-actions {background-color: #fff !important;}</style>
<div class="portlet-body form">
	<?php
		$q = $this->queryString;
		$q['xtype'] = 'confirm';
		if (isset($q['key']))
			unset($q['key']);
	?>
	<!-- BEGIN FORM-->
	<?php
	$elements = $this->form;
	$load_id=0;
	foreach ($this->primaryKey as $f) {
		$ary = explode('.', $f);
		if (isset($_GET['key'][$f]) || isset($key[$ary[0]][$ary[1]])) {
			if (isset($_GET['key'][$f])) {
				$load_id = $_POST['key'][$ary[0]][$ary[1]] = $_GET['key'][$f];
			}
			echo __hidden('key.' . $f);
		}
	}
	?>
	
	<div class="" id="errors_module" style="margin:0 20px;"></div>
	
	<div class="form-body">
	<input type="hidden" name="existing" id="existing">
			<?php
			$elements = $this->form;
			
			//Validation START
			echo "<script> function validateform(){ 
			$('#errors_module').empty();
			$('#errors_module').append('Please Enter Value For ');
			var foreignkey='1';
			";			
			foreach ($elements as $field => $v) {
				$fields = $v['section_fields'];
				foreach ($fields as $fk => $f) {
					$e = $f['element'];
					if(!empty($this->validate[$fk])){
						$data = explode('.',$fk);
						$final = ucwords($data[0]).ucwords($data[1]);
						//for file
						if ($e[0]=='file'){
							echo "if($('#file_data".$final."').val()==''){";
							echo "if($('#del_file_btn_data".$final."').val()!='delete'){";
								echo "$('#errors_module').append($('#del_file_btn_data".$final."').val());";
								echo "$('#errors_module').append('".$f['alias'].", ');";
								echo "foreignkey = 0";
							echo "}";
							echo "}";
							//for all other controls
						} else if ($e[0]=='date'){
							echo "if($('#data".$final." input').val()==''){";
							echo "$('#errors_module').append('".$f['alias'].", ');";
							echo "foreignkey = 0";
							echo "}";
							//for all other controls
						} else {
							echo "if($('#data".$final."').val()==''){";
							echo "$('#errors_module').append('".$f['alias'].", ');";
							echo "foreignkey = 0";
							echo "}";
						}
					}
				}
			}


			echo "if($('#unique_contact').children().val()!=''){";
			echo "var allrecords = $('#existing').val();";
			echo "var fieldname = $('#fieldname').val();";
			echo "var newcontact = $('#unique_contact').children().val();";
			echo "var datareturned = getExistingData(allrecords,newcontact,".$_GET['com_id'].",fieldname);";
			echo "if(datareturned == '0') {";
			echo "$('#errors_module').append('<br />Contact already exists. ');";
			echo "foreignkey = 0;";
			echo "}";
			echo "}";


			echo "var data = $('#errors_module').text().slice(0,-2);";
		    echo "$('#errors_module').addClass('alert alert-error'); $('#errors_module').empty(); $('#errors_module').append('<strong>Error!</strong> '); $('#errors_module').append(data);";

			echo "if(foreignkey != 0) { return 1; } else { return 0; }";
			echo "}; </script>";
			//Validation END
			
			$sections = array();
			if (!empty($elements)) {
				foreach ($elements as $field => $v) {
					$inner_section = array();
					$inner_section['section_name'] = $v['section_name'];
					$inner_section['section_title'] = $v['section_title'];
					$inner_section['section_view'] = $v['section_view'];
					$inner_section['section_html'] = '';
					$fields = $v['section_fields'];
					// Start a row
					$inner_section['section_html'] .= '<div class="row">';
					$counter = 0;

					$total_fields = count($fields);
					foreach ($fields as $fk => $f) {
						if (empty($f['element']))
							continue;
						$e = $f['element'];
						////////////if block given by kamran
						if ($v['section_size'] == 'full') {
							$section_size = ' col-md-12 ';
							$label_class =  ' hidden ';
							$field_class = ' col-md-12 ';
						} else {
							$section_size = ' col-md-6 ';
							$label_class =  '  ';
							$field_class = ' col-md-8 ';
						}
						/////////////////////////////////
						if (!empty($e) && isset($e[0])) {
                            if($e[0]=='related_module' or $e[0]=='editor'){
								$section_size = ' col-md-12 ';
								$field_class = ' col-md-12 ';
							}
							if($e[0]=='empty'){
							   $inner_section['section_html'] .= '<div class="col-md-6">';
							   $inner_section['section_html'] .= '<div class="form-group">';
							   $inner_section['section_html'] .=    '<label class="control-label col-md-4"></label>';
							   $inner_section['section_html'] .=     '<div class="col-md-8">';
							   $inner_section['section_html'] .=   generateFormElementView($e,$this->da,$fk);
							   $inner_section['section_html'] .=     '</div>';
							   $inner_section['section_html'] .= '</div>';
							   $inner_section['section_html'] .= '</div>';
							} else if($e[0]!='hidden'){
								////////////if block given by kamran
                                $unique=explode(".",$fk);
								$inner_section['section_html'] .= '<div class="'.$section_size.'" id="'.$unique[1].'_ID">';
								$inner_section['section_html'] .= '<div class="form-group">';


                                                                            if(array_key_exists('attach', $e[1]))
                                                                                $ev=$e[1];
                                                                            elseif(array_key_exists('attach', $e[2]))
                                                                                $ev=$e[2];
                                                                            elseif(array_key_exists('attach', $e[3]))
                                                                                $ev=$e[3];
                                                                            elseif(array_key_exists('attach', $e[4]))
                                                                                $ev=$e[4];

																			$attach=trim($ev['attach']);

                                                                            if(isset($attach) and $attach=='attached'){
                                                                                $table = explode('.',$fk);
                                                                                if(isset($_GET['key'])){
	                                                                            	$column = explode('.',key($_GET['key']));
                                                                                    $dataforcheckbox = $CI->db->get_where($table[0],array($column[1]=>$_GET['key'][key($_GET['key'])]))->row_array();
                                                                                    if($dataforcheckbox[$ev['fieldname']]==1){
                                                                                        $checked = '<input class="form-control" onclick="changevalues(this.id);" type="checkbox" id="get-data'.ucwords($table[0]).ucwords($ev['fieldname']).'" checked="checked">';
                                                                                        $checked .= '<input type="hidden" id="data'.ucwords($table[0]).ucwords($ev['fieldname']).'" name="data['.$table[0].']['.$ev['fieldname'].']" value="1">';
                                                                                    } else{
                                                                                        $checked = '<input class="form-control" onclick="changevalues(this.id);" type="checkbox" id="get-data'.ucwords($table[0]).ucwords($ev['fieldname']).'">';
                                                                                        $checked .= '<input type="hidden" id="data'.ucwords($table[0]).ucwords($ev['fieldname']).'" name="data['.$table[0].']['.$ev['fieldname'].']" value="0">';
                                                                                    } 
                                                                                } else {
                                                                                    $checked = '<input class="form-control" onclick="changevalues(this.id);" type="checkbox" id="get-data'.ucwords($table[0]).ucwords($ev['fieldname']).'">';
                                                                                    $checked .= '<input type="hidden" id="data'.ucwords($table[0]).ucwords($ev['fieldname']).'" name="data['.$table[0].']['.$ev['fieldname'].']" value="0">';
                                                                                }
                                                                            } else{
                                                                                $checked = '';
                                                                            }
                                                                            $inner_section['section_html'] .=    ' <label class="control-label col-md-12 '.$label_class.'">'.$checked .' '. ucwords(str_replace('_', ' ', $f['alias']))	.'</label>';


								//$inner_section['section_html'] .=    '<label class="control-label col-md-12 '.$label_class.'">'. $f['alias'].'</label>';
								$inner_section['section_html'] .=     '<div class="col-md-12 '.$field_class.'">';
								$inner_section['section_html'] .=   generateFormElementView($e,$this->da,$fk);
								///////////////////////////////////
								$inner_section['section_html'] .=     '</div>';
								$inner_section['section_html'] .= '</div>';
								$inner_section['section_html'] .= '</div>';
							} else {
								$inner_section['section_html'] .= '<div class="col-md-6" style="display:none;">';
								$inner_section['section_html'] .= '<div class="form-group">';
								$inner_section['section_html'] .=    '<label class="control-label col-md-12">'. $f['alias'].'</label>';
								$inner_section['section_html'] .=     '<div class="col-md-12">';
								$inner_section['section_html'] .=   generateFormElementView($e,$this->da,$fk);
								$inner_section['section_html'] .=     '</div>';
								$inner_section['section_html'] .= '</div>';
								$inner_section['section_html'] .= '</div>';
								continue;
							}
						}
						if($e[0]=='related_module'){
							$counter++;
						}                        
						if($counter == 1){
							$inner_section['section_html'] .=  '</div>';
							$inner_section['section_html'] .= '<div class="clearfix"></div>';
							$inner_section['section_html'] .=  '<div class="row">';
							$counter = 0;
						} else {
							$counter++;
						}
					}
					$inner_section['section_html'] .=  '</div>';
					$sections[] = $inner_section;
					unset($inner_section);
				}
			}
			$total_sectoins =  count($sections);
			$form_html = '';
			$tab_li = '';
			$tab_main_div = '';
			$tab_ul_start = '';
			$active_class = '';
			// Table UL
			$tab_ul_end = '';
			$tab_content_div = '';
			$tab_content_start = '';
			$tab_content_end = '';
			$tab_main_div_close = '';
			// Test
			$test = array();
			$scounter = 1;
			$tcounter = 1;
			foreach ($sections as $sk => $sv) {
				if ($sv['section_view'] == 'outer') {
					$form_html .= '<h3 class="form-section">'.$sv['section_title'].'</h3>';
					$form_html .= $sv['section_html'];
				} elseif ($sv['section_view'] == 'accordion') {
					// Codding for accordion
					$toggle_class = '';
					if ($tcounter ==1) {
						$tab_main_div = '<div class="panel-group accordion" id="frm_accordion">';
						$active_class = 'in';
					} else {
						$toggle_class = 'collapsed';
						$active_class = 'collapse';
					}
					$tab_content_div .= '<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle accordion-toggle-styled '.$toggle_class.'" data-toggle="collapse" data-parent="#frm_accordion" href="#frm_accordion_'.$scounter.'"> '.$sv['section_title'].' </a>
							</h4>
						</div>
						<div id="frm_accordion_'.$scounter.'" class="panel-collapse '.$active_class.'">
							<div class="panel-body">
								'.$sv['section_html'].'
							</div>
						</div>
					</div>';
					$last_tab = $scounter - $total_sectoins;
					if ($last_tab== 0) {
						$tab_main_div_close = '</div>';
					}
					$active_class = '';
					$tcounter++;
					// codign for accordtion ends here
				} else if ($sv['section_view'] == 'tabbed') {
					// Coding for tabbed view
					if ($tcounter ==1) {
						$test['counter_is_one'][] = 'yes';
						$tab_main_div = '<div class="tabbable tabbable-tabdrop">';
						$tab_ul_start = '<ul class="nav nav-tabs">';
						$tab_content_start = '<div class="tab-content">';
						$active_class = 'active';

					}
					$test['counter_is_number'][] = $scounter;
					$tab_li .= '<li class="'.$active_class.'"><a href="#'.$sv['section_name'].'" data-toggle="tab">'.$sv['section_title'].'</a></li>';
					$tab_content_div .= '<div class="tab-pane '.$active_class.'" id="'.$sv['section_name'].'">'.$sv['section_html'].'</div>';
					$last_tab = $scounter - $total_sectoins;
					if ($last_tab== 0) {
						$test['counter_is_last'][] = 'yes';
						$tab_content_end = '</div>';
						$tab_ul_end = '</ul>';
						$tab_main_div_close = '</div>';
					}
					$active_class = '';
					$tcounter++;
				}
				$scounter++;
			}
			$form_html .= $tab_main_div;
			$form_html .= $tab_ul_start;
			$form_html .= $tab_li;
			$form_html .= $tab_ul_end;
			$form_html .= $tab_content_start;
			$form_html .= $tab_content_div;
			$form_html .= $tab_content_end;
			$form_html .= $tab_main_div_close;
			echo $form_html;
			?>	
	</div>
</div>
<!--MODULE END-->

<script type="text/javascript">
    jQuery(document).ready(function() {   
		//App.init(); // init metronic core componets
		$(".select2, .select2-multiple").select2({
	        placeholder: "Select...",
	        width: null
	    });

	    $(".select2-allow-clear").select2({
	        allowClear: true,
	        placeholder: "Select...",
	        width: null
	    });


		$('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        orientation: "right",
	        autoclose: true
	    });

		$('.timepicker').timepicker({
	        autoclose: true,
	        showMeridian: false,
	        minuteStep: 1
	    });
	});

	$(".form_datetime").datetimepicker({
	    autoclose:!0,
	    orientation: "right",
	    isRTL:App.isRTL(),
	    format:"dd-mm-yyyy hh:ii:ss",
	    pickerPosition:App.isRTL()?"bottom-right":"bottom-left"
	});

	    //Toggle Password

    (function ($) {
        $.toggleShowPassword = function (options) {
            var settings = $.extend({
                field: "#password",
                control: "#toggle_show_password",
            }, options);

            var control = $(settings.control);
            var field = $(settings.field)

            control.bind('click', function () {
                if (control.is(':checked')) {
                    field.attr('type', 'text');
                } else {
                    field.attr('type', 'password');
                }
            })
        };
    }(jQuery));

    ///////////////
<?php
if(isset($_GET['$c_id'])){
    $table = explode(".",key($_GET['key']));
}else{
    $CI->db->select('component_table');
    $CI->db->from('crud_components');
    $CI->db->where('id',$_GET['com_id']);
    $query = $CI->db->get();
    $table = $query->row_array();
    $table[0] = $table['component_table'];
}
?>
    $.toggleShowPassword({
        field: '#data<?=ucwords($table[0])?>User_password',
        control: '#toggle_data<?=ucwords($table[0])?>User_password'
    }); 



	$( document ).ready(function() {
		if($('#dataLegal_letters_dataLetter_id').val() == ''){
			showdivsbelow('dataLegal_letters_dataLetter_id',0);
			$('input:checkbox').each(function () {
				if($(this).attr('id')){
					var res = $(this).attr('id').split("-"); 
					$(this).attr('checked', 'checked');
					$('#'+res[1]).val('1');
				}
			});
		} else {
			if($('#dataLegal_letters_dataLetter_id').val() != '' && $('#dataLegal_letters_dataLetter_id').val() != undefined ){
				showdivsbelow('dataLegal_letters_dataLetter_id',<?=$load_id?>);
				$('input:checkbox').each(function () {
					if($(this).attr('id')){
						var res = $(this).attr('id').split("-"); 
						if($('#'+res[1]).val()=='0'){
							var id=$(this).attr('id');
							$('#'+id).parent().parent().find('input[type!="checkbox"], textarea, button, select').prop("disabled", true);
						}
					}
				});
			}
		}
	});
</script>
    <script src="<?php echo base_url(); ?>media/js/mfunctions/mfunctions.js" type="text/javascript"></script>
<script>CKEDITOR.replace( 'dataLegal_letters_dataContent',    { toolbar : 'Basic'    });</script>
<style type="text/css">
    .select2-dropdown {  z-index: 10052; }
    .form-control{width:unset;height:unset;display: inline;vertical-align: text-top;}
</style>
