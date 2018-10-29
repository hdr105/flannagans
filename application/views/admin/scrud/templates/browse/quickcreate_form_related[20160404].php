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
$keyval0 = '';
$keyval1 = '';
$keyval2 = '';
$keyval3 = '';
$keyval4 = '';
$keyval5 = '';
if((isset($_GET['key']['business.id']) && $keyid = $_GET['key']['business.id']) or (isset($_GET['key']['forms.id']) && $keyid = $_GET['key']['forms.id']) or (isset($_GET['key']['codes.id']) && $keyid = $_GET['key']['codes.id']) or (isset($_GET['key']['compliance.id']) && $keyid = $_GET['key']['compliance.id']) or (isset($_GET['key']['services.id']) && $keyid = $_GET['key']['services.id']) or (isset($_GET['key']['business_fee.id']) && $keyid = $_GET['key']['business_fee.id'])){
    $keyval0 = "&key[business.id]=".$keyid;
    $keyval1 = "&key[forms.id]=".$keyid;
    $keyval2 = "&key[codes.id]=".$keyid;
    $keyval3 = "&key[compliance.id]=".$keyid;
    $keyval4 = "&key[services.id]=".$keyid;
    $keyval5 = "&key[business_fee.id]=".$keyid;
}
?>
<!--MODULE START-->
<div class="portlet-title">
<?php
if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45 or $c_id==58 or $c_id==62 or $c_id==63 or $c_id==64){
?>
	<div class="pull-left">
		<a href="<?=base_url(); ?>admin/scrud/browse?com_id=41&xtype=form<?=$keyval0?>" class="btn btn-sm <?php if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?>">Business Setup</a>
		<a href="<?=base_url(); ?>admin/scrud/browse?com_id=58&xtype=form<?=$keyval1?>" class="btn btn-sm <?php if($c_id=='58'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval1==''){ ?> disabled<?php } ?>">Forms</a>
		<a href="<?=base_url(); ?>admin/scrud/browse?com_id=63&xtype=form<?=$keyval2?>" class="btn btn-sm <?php if($c_id=='63'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval2==''){ ?> disabled<?php } ?>">Codes</a>
		<a href="<?=base_url(); ?>admin/scrud/browse?com_id=62&xtype=form<?=$keyval3?>" class="btn btn-sm <?php if($c_id=='62'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval3==''){ ?> disabled<?php } ?>">Compliance Section</a>
		<a href="<?=base_url(); ?>admin/scrud/browse?com_id=&xtype=form<?=$keyval4?>" class="btn btn-sm <?php if($c_id==''){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval4==''){ ?> disabled<?php } ?>">Services</a>
		<a href="<?=base_url(); ?>admin/scrud/browse?com_id=64&xtype=form<?=$keyval5?>" class="btn btn-sm <?php if($c_id=='64'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval5==''){ ?> disabled<?php } ?>">Fee Setup</a>
	</div>
<?php } ?>
</div>
<div class="portlet-body form">
	<?php if($c_id==62){ ?>
	<ul class="nav nav-tabs">
		<li <?php if($c_id=='62'){ ?>class="active"<?php } ?>>
			<a href="http://localhost/man/index.php/admin/scrud/browse?com_id=62&xtype=form<?=$keyval3?>"> Money Laundering Check </a>
		</li>
		<li <?php if($c_id==''){ ?>class="active"<?php } ?>>
			<a href="http://localhost/man/index.php/admin/scrud/browse?com_id=&xtype=form<?=$keyval3?>"> Legal Letters </a>
		</li>
	</ul>
	<div class="clearfix"> </div>
	<?php } if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45){ ?>
	<ul class="nav nav-tabs">
		<li <?php if($c_id=='41'){ ?>class="active"<?php } ?>>
			<a href="http://localhost/man/index.php/admin/scrud/browse?com_id=41&xtype=form<?=$keyval0?>"> Sole Trader </a>
		</li>
		<li <?php if($c_id=='42'){ ?>class="active"<?php } ?>>
			<a href="http://localhost/man/index.php/admin/scrud/browse?com_id=42&xtype=form<?=$keyval0?>"> Partnership </a>
		</li>
		<li <?php if($c_id=='43'){ ?>class="active"<?php } ?>>
			<a href="http://localhost/man/index.php/admin/scrud/browse?com_id=43&xtype=form<?=$keyval0?>"> Limited Company </a>
		</li>
		<li <?php if($c_id=='44'){ ?>class="active"<?php } ?>>
			<a href="http://localhost/man/index.php/admin/scrud/browse?com_id=44&xtype=form<?=$keyval0?>"> Limited Liabilities Company </a>
		</li>
		<li <?php if($c_id=='45'){ ?>class="active"<?php } ?>>
			<a href="http://localhost/man/index.php/admin/scrud/browse?com_id=45&xtype=form<?=$keyval0?>"> Charities </a>
		</li>
	</ul>
	<div class="clearfix"> </div>
	<?php } ?>
	<?php
		$q = $this->queryString;
		$q['xtype'] = 'confirm';
		if (isset($q['key']))
			unset($q['key']);
	?>
	<!-- BEGIN FORM-->
	<?php
	$elements = $this->form;
	foreach ($this->primaryKey as $f) {
		$ary = explode('.', $f);
		if (isset($_GET['key'][$f]) || isset($key[$ary[0]][$ary[1]])) {
			if (isset($_GET['key'][$f])) {
				$_POST['key'][$ary[0]][$ary[1]] = $_GET['key'][$f];
			}
			echo __hidden('key.' . $f);
		}
	}
	?>
	<?php if (!empty($this->errors)) { ?>
	<div class="alert alert-error">
	<button data-dismiss="alert" class="close" type="button">×</button>
	<?php foreach ($this->errors as $error) { ?>
		<?php if (count($error) > 0) { ?>
			<strong>Error!</strong>
			<?php echo implode('<br />', $error); ?>
			<br />
		<?php } ?>
	<?php } ?>
	</div>
	<?php } ?>
	
	<div class="form-body">
			<?php
			$elements = $this->form;
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
							if($e[0]=='related_module'){
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
								$inner_section['section_html'] .= '<div class="'.$section_size.'">';
								$inner_section['section_html'] .= '<div class="form-group">';
								$inner_section['section_html'] .=    '<label class="control-label col-md-12 '.$label_class.'">'. $f['alias'].'</label>';
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
			orientation: "left",
			autoclose: true
		});
	});
</script>
<style type="text/css">
    .select2-dropdown {  z-index: 10052; }
</style>