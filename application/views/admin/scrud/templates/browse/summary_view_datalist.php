<?php 
	$permissions = $auth->getPermissionType();
	$elements = $this->elements; 
	$CI = & get_instance();
	$_m = new ScrudDao('crud_components', $this->da);
	$_p['fields'] = array('id','component_name');
	$_p['conditions'] = array('id="'.$_GET['com_id'].'"');
	$mrs = $_m->find($_p);
		global $date_format_convert;

?>
<div id="summary_view_container">
	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption">
				<?php echo $mrs[0]['component_name']; ?> 
			</div>
		</div>
		<div class="portlet-body">
			<div>
				<table class="table table-striped table-bordered table-hover ">
					<thead>
						<tr>
							<?php foreach ($fields as $k => $field) { 
								$fieldname = explode('.', $field);
								$fieldnameAlias = ucwords(str_replace('_', ' ', $fieldname[1]));
								if (in_array($field, $this->fields)) { ?>
									<th><?php echo htmlspecialchars((isset($this->summaryAlias[$field])) ? $this->summaryAlias[$field] : $fieldnameAlias); ?></th>
								<?php } else { ?>
									<th><?php echo htmlspecialchars((isset($this->summaryAlias[$field])) ? $this->summaryAlias[$field] : $fieldnameAlias); ?></th>
								<?php } ?>
							<?php } ?>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
								if (!empty($this->results)) {
									$s = array();
									foreach ($this->fields as $field) {
										$s[] = '{' . $field . '}';
									}
								$s[] = '{ppri}';
								$s[] = '{no}';
								$offset = ($this->pageIndex - 1) * $this->limit;
								
								$formFields = array();
								foreach ($this->form as $key => $value) {
									foreach ($value['section_fields'] as $key => $value) {
										$formFields[$key] = $value;
									}
								}

								foreach ($this->results as $result) {
									if(isset($result['business']['title']))
										$bname=$result['business']['title'];

									$r = array();

								foreach ($this->fields as $k => $field) {
									$__value = '';
									$__aryField = explode('.', $field);
									if (count($__aryField) > 1) {
										$__tmp = $result;
										foreach ($__aryField as $key => $value) {
											if (is_array($__tmp[$value])) {
												$__tmp = $__tmp[$value];
											} else {
												$__value = $__tmp[$value];
											}
										}
									} else if (count($__aryField) == 1) {
										$__value = $result[$field];
									}
									
									if (isset($formFields[$field]) && isset($formFields[$field]['element'][0])) {
										switch (trim(strtolower($formFields[$field]['element'][0]))) {
											case 'radio':
											case 'autocomplete':
											case 'select':
												$e = $formFields[$field]['element'];
												$options = array();
												$params = array();
												if (isset($e[1]) && !empty($e[1])) {
													if (array_key_exists('option_table', $e[1])) {
														if (array_key_exists('option_key', $e[1]) &&
															array_key_exists('option_value', $e[1])) {
																$_dao = new ScrudDao($e[1]['option_table'], $CI->db);

																if ($e[1]['option_table'] == 'crud_users') {
																	$params['fields'] = array($e[1]['option_key'], 'user_first_name', 'user_las_name');
																} else if ($e[1]['option_table'] == 'contact') {
																	$params['fields'] = array($e[1]['option_key'], 'First_Name', 'Last_Name');
																} else {
																	$params['fields'] = array($e[1]['option_key'], $e[1]['option_value']);
																}
																//CUSTOM CONDITIONS STARTS HERE
																if(isset($e[1]['option_condition']) && isset($e[1]['option_column']) && isset($e[1]['option_action'])){
																	$condition = $e[1]['option_condition'];
																	$column = $e[1]['option_column'];
																	$action = $e[1]['option_action'];
																	if($condition!=0 && $condition!=''){
																		$cond_final = $column . $action . $condition;
																		$params['condition']=$cond_final;
																	}
																} 
																//CUSTOM CONDITIONS ENDS HERE
															$rs = $_dao->find($params);
															if (!empty($rs)) {
																foreach ($rs as $v) {
																	if ($e[1]['option_table'] == 'crud_users') {
																		$options[$v[$e[1]['option_key']]] = ucwords($v['user_first_name']) . ' ' . ucwords($v['user_las_name']);
																	} elseif ($e[1]['option_table'] == 'contact') {
																		$options[$v[$e[1]['option_key']]] = ucwords($v['First_Name']) . ' ' . ucwords($v['Last_Name']);
																	} else {
																		$options[$v[$e[1]['option_key']]] = $v[$e[1]['option_value']];
																	}
																}
															}
														}
													} else {
														$options = $e[1];
													}
												}
												$formFields[$field]['element'][1] = $options;
												if (isset($formFields[$field]['element'][1]) && !empty($formFields[$field]['element'][1]) && is_array($formFields[$field]['element'][1]) && !empty($formFields[$field]['element'][1][$__value])) {
													$r[] = htmlspecialchars($formFields[$field]['element'][1][$__value]);
												} else {
													$r[] = '';
												}
												break;
											case 'editor':
												$r[] = $__value;
												break;
											case 'checkbox':
												$value = explode(',', $__value);
												if (!empty($value) && is_array($value) && count($value) > 0) {
													$tmp = array();
													foreach ($value as $k1 => $v1) {
														if (isset($formFields[$field]['element'][1][$v1])) {
															$tmp[] = $formFields[$field]['element'][1][$v1];
														}
													}
													$value = implode(', ', $tmp);
												} else {
													$value = '';
												}
												$r[] = htmlspecialchars($value);
												break;
											case 'textarea':
												$r[] = nl2br(htmlspecialchars($__value));
											break;
											default:
												$r[] = htmlspecialchars($__value);
											break;
										}
									} else {
										$r[] = htmlspecialchars($__value);
									}
								}
								$offset++;
								$ppri = "";
								$_tmp = "";
								foreach ($this->primaryKey as $f) {
									$__value = '';
									$__aryField = explode('.', $f);
									if (count($__aryField) > 1) {
										$__tmp = $result;
										foreach ($__aryField as $key => $value) {
											if (is_array($__tmp[$value])) {
												$__tmp = $__tmp[$value];
											} else {
												$__value = $__tmp[$value];
											}
										}
									} else if (count($__aryField) == 1) {
										$__value = $result[$f];
									}
									$this->summaryData["selected_id"] = $__value;
									$ppri .= $_tmp . 'key[' . $f . ']=' . htmlspecialchars($__value);
									$_tmp = '&';
								}
								$r[] = $ppri;
								$r[] = $offset;
								?>
								<tr class="odd gradeX">
									<?php foreach ($fields as $field) { ?>
									<td>
										<?php if (isset($this->colsCustom[$field])) { ?>
											<?php echo str_replace($s, $r, $this->colsCustom[$field]); ?>
										<?php } else { ?>
										<?php
											$__value = '';
											$__aryField = explode('.', $field);
											if (count($__aryField) > 1) {
												$__tmp = $result;
												foreach ($__aryField as $key => $value) {
													if (is_array($__tmp[$value])) {
														$__tmp = $__tmp[$value];
													} else {
														if($value=='legal_entity'){
															switch($__tmp[$value]){
																case '1':
																	$__value='Sole Trader';
																	break;
																case '2':
																	$__value='Partnership';
																	break;
																case '3':
																	$__value='Limited Company';
																	break;
																case '4':
																	$__value='Limited Liabilities';
																	break;
																case '5':
																	$__value='Charities';
																	break;
															}
														}else
															$__value = $__tmp[$value];
														}
													}
												} else if (count($__aryField) == 1) {
													$__value = $result[$field];
												}
												if (isset($formFields[$field]) && isset($formFields[$field]['element'][0])) {
													switch (trim(strtolower($formFields[$field]['element'][0]))) {
														case 'radio':
														case 'autocomplete':
														case 'select':
															$e = $formFields[$field]['element'];
															$options = array();
															$params = array();
															if (isset($e[1]) && !empty($e[1])) {
																if (array_key_exists('option_table', $e[1])) {
																	if (array_key_exists('option_key', $e[1]) &&
																		array_key_exists('option_value', $e[1])) {
																		$_dao = new ScrudDao($e[1]['option_table'], $CI->db);
																		if ($e[1]['option_table'] == 'crud_users') {
																			$params['fields'] = array($e[1]['option_key'], 'user_first_name', 'user_las_name');
																		} else {
																			$params['fields'] = array($e[1]['option_key'], $e[1]['option_value']);
																		}
																		$rs = $_dao->find($params);
																		if (!empty($rs)) {
																			$rs = $rs[$e[1]['option_table']];
																			foreach ($rs as $v) {
																				if ($e[1]['option_table'] == 'crud_users') {
																					$options[$v[$e[1]['option_key']]] = ucwords($v['user_first_name']) . ' ' . ucwords($v['user_las_name']);
																				} else {
																					$options[$v[$e[1]['option_key']]] = $v[$e[1]['option_value']];
																				}
																			}
																		}
																	}
																} else {
																	$options = $e[1];
																}
															}
															$formFields[$field]['element'][1] = $options;
															if (array_key_exists(2, $formFields[$field]['element']) and array_key_exists('multiple', $formFields[$field]['element'][2])) {
																$mkvarr = explode(',', $__value);
																$values_as_string = array();
																foreach ($mkvarr as $key => $value) {
																	if (!empty($value) && $value != '') {
																		$values_as_string[] = nl2br(htmlspecialchars($formFields[$field]['element'][1][$value]));
																	}

																}
																echo implode(',', $values_as_string);

															}else if (isset($formFields[$field]['element'][1]) && !empty($formFields[$field]['element'][1]) && is_array($formFields[$field]['element'][1]) && !empty($formFields[$field]['element'][1][$__value])) {
																echo nl2br(htmlspecialchars($formFields[$field]['element'][1][$__value]));
															}
															break;
													case 'editor':
														echo $__value;
														break;
													case 'checkbox':
														$value = explode(',', $__value);
														if (!empty($value) && is_array($value) && count($value) > 0) {
															$tmp = array();
															foreach ($value as $k1 => $v1) {
																if (isset($formFields[$field]['element'][1][$v1])) {
																	$tmp[] = $formFields[$field]['element'][1][$v1];
																}
															}
															$value = implode(', ', $tmp);
														} else {
															$value = '';
														}
														echo htmlspecialchars($value);
														break;
													case 'currency':
														$_curt = new ScrudDao('currencies', $this->da);
														$cpt = array();
														$cpt['conditions'] = array('currency_status="3"');
														$cpt_res = $_curt->find($cpt);
														echo nl2br(htmlspecialchars($cpt_res[0]['currency_symbol'].' '.$__value));
														break;
													case 'textarea':
														echo nl2br(htmlspecialchars($__value));
														break;
													case 'file':
														if (file_exists(FCPATH . '/media/files/' . $__value)) {
															echo '<a href="' . base_url() . 'index.php/admin/download?file=' . $__value . '">' . $__value . '</a>';
														} else {
															echo $__value;
														}
														break;
													case 'image':
														if (file_exists(__IMAGE_UPLOAD_REAL_PATH__ . '/thumbnail_' . $__value)) {
															echo "<img src='" . __MEDIA_PATH__ . "images/thumbnail_" . $__value . "' />";
														} else if (__IMAGE_UPLOAD_REAL_PATH__ . '/mini_thumbnail_' . $__value) {
															echo "<img src='" . __MEDIA_PATH__ . "images/mini_thumbnail_" . $__value . "' />";
														} else {
															echo '';
														}
														break;
													case 'date':
														if (is_date($__value)){
															echo date($date_format_convert[__DATE_FORMAT__],strtotime($__value));
														}else{
															echo '';
														}
														break;
													case 'datetime':
														if (is_date($__value)){
															echo date($date_format_convert[__DATE_FORMAT__] .' H:i:s',strtotime($__value));
														}else{
															echo '';
														}
														break;
													default:
														echo nl2br(htmlspecialchars($__value));
														break;
												}
											} else {
												echo nl2br(htmlspecialchars($__value));
											}
										} ?>
									</td>
							<?php 
							} 
							$html='<td>';
                            if (in_array(1, $permissions)){
	                            if ($this->summaryData['module_id']==75)
									$html .= '<a href="javascript:;"  class="btn btn-icon-only blue viewRelatedModuleRecords" onclick=\'viewPDF('.json_encode($this->summaryData).');\' ><i class="fa fa-search"></i></a>';
								else
									$html .= '<a href="javascript:;"  class="btn btn-icon-only blue viewRelatedModuleRecords" onclick=\'ViewRelModRecord('.json_encode($this->summaryData).');\' ><i class="fa fa-search"></i></a>';
							}
                            if (in_array(2, $permissions) and (!isset($_GET['xview']) or $_GET['xview']!=1))
								$html .= '<a href="javascript:;"  class="btn btn-icon-only green viewRelatedModuleRecords" onclick=\'EditRelModRecord('.json_encode($this->summaryData).');\' ><i class="fa fa-pencil"></i></a>';
                            if (in_array(3, $permissions) and (!isset($_GET['xview']) or $_GET['xview']!=1))
								$html .= '<a href="javascript:;"  class="btn btn-icon-only red delRelatedModuleRecords" onclick=\'remoRelModRecord('.json_encode($this->summaryData).');\' ><i class="fa fa-trash"></i></a>';

                            if ($this->summaryData['module_id']==75)
								$html .= '<a href="javascript:;"  class="btn btn-icon-only default" onclick=\'downloadPDF('.json_encode($this->summaryData).');\' ><i class="fa fa-download"></i></a>';
							//////////////nauman code starts here /////////////////////
					        if ($this->summaryData['module_id']==75)
					        	$html.= '<a href="javascript:;" class="btn btn-icon-only black" onclick=\'emailLegalLetter('.json_encode($this->summaryData).');\'> <i class="fa fa-envelope" aria-hidden="true"></i></a>';
					        //////////////nauman code ends here//////////////////////////////////
							$html.='</td>';
								echo $html;
								?>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>