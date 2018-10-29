<?php 
global $date_format_convert;
$CI = & get_instance();
$lang = $CI->lang;
$c_id = $_GET['com_id'];
$sess_cid = $CI->session->userdata('comid');
?>
	<div class="portlet-body form">
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
						if ($v['section_size'] == 'full') {
							$section_size = ' col-md-12 ';
							$label_class =  ' hidden ';
							$field_class = ' col-md-12 ';
						} else {
							$section_size = ' col-md-6 ';
							$label_class =  '  ';
							$field_class = ' col-md-8 ';
						}
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
								$inner_section['section_html'] .=   generateViewElementView($e,$this->da,$fk,$date_format_convert);
							   $inner_section['section_html'] .=     '</div>';
							   $inner_section['section_html'] .= '</div>';
							   $inner_section['section_html'] .= '</div>';
							
							} else if($e[0]!='hidden'){
								$inner_section['section_html'] .= '<div class="'.$section_size.'">';
								$inner_section['section_html'] .= '<div class="form-group">';
								////////////////////////
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
											$inner_section['section_html'] .=    '<label class="control-label col-md-12 '.$label_class.'">'. ucwords(str_replace('_', ' ', $f['alias'])).'</label>';
											$inner_section['section_html'] .=     '<div class="col-md-12 '.$field_class.'">';
											$inner_section['section_html'] .=   generateViewElementView($e,$this->da,$fk,$date_format_convert);
											$inner_section['section_html'] .=     '</div>';
								        } 
								    }
								} else{
									$inner_section['section_html'] .=    '<label class="control-label col-md-12 '.$label_class.'">'. ucwords(str_replace('_', ' ', $f['alias'])).'</label>';
									$inner_section['section_html'] .=     '<div class="col-md-12 '.$field_class.'">';
									$inner_section['section_html'] .=   generateViewElementView($e,$this->da,$fk,$date_format_convert);
									$inner_section['section_html'] .=     '</div>';
								}
								///////////////////////
								$inner_section['section_html'] .= '</div>';
								$inner_section['section_html'] .= '</div>';
							} else {
								$inner_section['section_html'] .= '<div class="col-md-6" style="display:none;">';
								$inner_section['section_html'] .= '<div class="form-group">';
								$inner_section['section_html'] .=    '<label class="control-label col-md-4"><b>'. $f['alias'].'</b></label>';
								$inner_section['section_html'] .=     '<div class="col-md-8">';
								$inner_section['section_html'] .=   generateViewElementView($e,$this->da,$fk,$date_format_convert);
								$inner_section['section_html'] .=     '</div>';
								$inner_section['section_html'] .= '</div>';
								$inner_section['section_html'] .= '</div>';
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
			$tab_ul_end = '';
			$tab_content_div = '';
			$tab_content_start = '';
			$tab_content_end = '';
			$tab_main_div_close = '';
			$test = array();
			$scounter = 1;
			$tcounter = 1;
			foreach ($sections as $sk => $sv) {
				if ($sv['section_view'] == 'outer') {
					$form_html .= '<h3 class="form-section">'.$sv['section_title'].'</h3>';
					$form_html .= $sv['section_html'];
				} elseif ($sv['section_view'] == 'accordion') {
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
				} else if ($sv['section_view'] == 'tabbed') {
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