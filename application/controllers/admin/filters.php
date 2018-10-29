<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Filters extends Admin_Controller {
	// Call Index Page START
    public function index() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
        $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
        $var = array();
        $var['u'] = $CRUD_AUTH;
        $moduleList = array();

        $excludeModulesID = array( '59','61','48','49','47','1','3' );
		$excludeModulesTitle = array( '' );
        $excludeModulesTable = array( '' );
        
		$this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where_not_in('id',$excludeModulesID);
        $this->db->where_not_in('component_name',$excludeModulesTitle);
        $this->db->where_not_in('component_table',$excludeModulesTable);
        $query = $this->db->get();
		
		foreach($query->result_array() as $modId){
			if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$modId['id']). '/' . $modId['component_table'] . '.php')) {
				exit;
			}
			$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$modId['id']) . '/' . $modId['component_table'] . '.php'));
			$conf[$modId['id']] = unserialize($content);
		}
		
		$var['coms'] = $conf;
        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/common/filters',$var,true);
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();
        $this->load->template('layouts/admin/filters', $var);
    }
	// Call Index Page START
	
	// Get Field Names in AJAX CALL START
	public function get_fields(){
        $selectedModule = $this->input->post('moduleName');
		$moduleFields = array();
		$this->db->select('*');
        $this->db->from('crud_components');
		$this->db->where('id',$selectedModule);
		$query = $this->db->get();
		$mainModule = $query->result_array();

		if (!empty($mainModule)) {
			if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$mainModule[0]['id']). '/' . $mainModule[0]['component_table'] . '.php')) {
				exit;
			}
			$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$mainModule[0]['id']) . '/' . $mainModule[0]['component_table'] . '.php'));
			$mainModuleConf = unserialize($content);
		}
		
		/* $mainFieldAlias = array();
		foreach($mainModuleConf['form_elements'] as $mfkey => $mfvalue){
			foreach($mfvalue['section_fields'] as $mdatakey => $mdatavalue){
				$mainFieldAlias[] = array(ucwords($mdatavalue['alias']),$mdatavalue['element'][0],$mdatakey);
			}	
		} */
		
		$mainFieldAlias = array();
		foreach($mainModuleConf['form_elements'] as $mfkey => $mfvalue){
			foreach($mfvalue['section_fields'] as $mdatakey => $mdatavalue){
				foreach($mainModuleConf['search_form'] as $mfsfkey => $mfsfvalue){
					if($mdatakey == $mfsfvalue['field']){
						if(isset($mfsfvalue['alias'])){
					       $mainFieldAlias[] = array(ucwords($mfsfvalue['alias']),$mdatavalue['element'][0],$mdatakey);
					    } else {
					       $mainFieldAlias[] = array(ucwords($mdatavalue['alias']),$mdatavalue['element'][0],$mdatakey);
					    }
					}
				}
			}	
		}
		
		/* $mainFieldAlias = array();
		foreach($mainModuleConf['search_form'] as $mfkey => $mfvalue){
			$mainFieldAlias[] = array(ucwords($mfvalue['alias']),$mfvalue['field'],$mfkey);
		} */
		
		
		$moduleFields[0]['moduleName'] = $mainModule[0]['component_name'];
		$moduleFields[0]['moduleInfo'] = $mainFieldAlias;
		echo json_encode(array('module'=>$mainModule, 'fields'=>$moduleFields));
	}
	// Get Field Names in AJAX CALL END

	//GET FIELD DATA START
	function field_data(){
        $this->load->model('crud_auth');
        $moduleData = $this->input->post('data'); 
        $moduleSplit = explode('.', $moduleData);
		

		$this->db->select('*');
		$this->db->from('crud_components');
		$this->db->where('component_table',$moduleSplit[0]);
		$query = $this->db->get();
		
		$modDetail = $query->row_array();
		
		$moduleConf = array();
		if (!empty($modDetail)) {
			if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$modDetail['id']). '/' . $modDetail['component_table'] . '.php')) {
				exit;
			}
			$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$modDetail['id']) . '/' . $modDetail['component_table'] . '.php'));
			$moduleConf = unserialize($content);
		}
		
		for($i=0;$i<=count($moduleConf['form_elements']);$i++){
			if(isset($moduleConf['form_elements'][$i]['section_fields'][$moduleData]['element'][1])){
				$filedInfo = $moduleConf['form_elements'][$i]['section_fields'][$moduleData]['element'][1];
			}
		}
		
		$output = array();
		/*if (isset($filedInfo['option_table'])) {
			$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
			foreach($CRUD_AUTH as $key => $value){
				if(is_array($value)){
					foreach($value as $inkey => $invalue){
						$$inkey = $invalue;
					}
				} else {
					$$key = $value;
				}
			}*/
			/*if(isset($filedInfo['option_condition']) && isset($filedInfo['option_column']) && isset($filedInfo['option_action'])){
				$sql = "SELECT * FROM ".$filedInfo['option_table'] . ' WHERE ' . $filedInfo['option_column'] . $filedInfo['option_action'] . $$filedInfo['option_condition'];
				if($filedInfo['option_customtext']){
					$sql .= ' AND '.$filedInfo['option_customtext'];
				}
			} else if(isset($filedInfo['option_customtext'])){
				$sql = "SELECT * FROM ".$filedInfo['option_table'] . ' WHERE ' . $filedInfo['option_customtext'];
			} else {
				$sql = "SELECT * FROM ".$filedInfo['option_table'];
			}
			echo json_encode($sql);exit;
			$query = $this->db->query($sql);*/

			///////////////////////
		if (isset($filedInfo['option_table']))
        {
            $sql = "SELECT * FROM ".$filedInfo['option_table'];

            if(isset($filedInfo['option_condition']) and $filedInfo['option_condition']!='')
            {
                $wh = " WHERE ";
                $cond1 =$filedInfo['option_condition']." ".$filedInfo['option_action']." ".$CRUD_AUTH[$filedInfo['option_column']]." ";
                $op = " AND ";
            }
            if(isset($filedInfo['option_customtext']) and $filedInfo['option_customtext']!=''){
                $wh = " WHERE ";
                $cond2 = $filedInfo['option_customtext'];
            }else
                $op = " ";

            
            $sql .= $wh.$cond1.$op.$cond2;
        ////faheem changes end ////
            
            $query = $this->db->query($sql);
			///////////////////////
			$mdata = array();
			// echo json_encode($sql);exit;
			if (!empty($query)) {
				foreach ($query->result_array() as $row) {
					if ($filedInfo['option_table'] == 'crud_users') {
						$output[] = $row[$filedInfo['option_key']].'|'.ucwords($row['user_first_name']) . ' ' . ucwords($row['user_las_name']);
					} else if($filedInfo['option_table'] == 'contact') {
						$output[] = $row[$filedInfo['option_key']].'|'.ucwords($row['First_Name']) . ' ' . ucwords($row['Last_Name']);
					} else {
						$output[] = $row[$filedInfo['option_key']].'|'.$row[$filedInfo['option_value']];
					}
				}
			}
		} else {
			foreach ($filedInfo as $key => $value) {
				$kk = explode('.', $key);
				$output[] = $key.'|'.$value;
			}
		}
		echo json_encode(($output));
    }
	//GET FIELD DATA END
	
    // to get related modules
    public function get_related(){
        $moduleName = $this->input->post('moduleName');
        $relatedModules = array();
        $this->db->select('*');
        $this->db->from('related_module_fields');
        $this->db->where('related_module',$moduleName);
        $query = $this->db->get();
        $relatedModules = $query->result_array();
        $relatedModuleDetails = array();

        if (!empty($relatedModules)) {
            foreach ($relatedModules as $key => $module) {
                $this->db->select('*');
                $this->db->from('crud_components');
                $this->db->where('component_table',$module['module_name']);
                $query = $this->db->get();
                $modDetail = $query->result_array();
                /* Get Field list of realted module with labels */
                if (!empty($modDetail)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$modDetail[0]['id']). '/' . $modDetail[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$modDetail[0]['id']) . '/' . $modDetail[0]['component_table'] . '.php'));
                    $moduleConf = unserialize($content);
                }                
                //* Get field list of related module with field labels */
                $relatedModules[$key] = $modDetail[0]['component_name'];
                //$relatedModules[$key]['moduleInfo'] = $moduleConf;
            }
        }
        echo json_encode($moduleName);
    }

    function save_filter(){
		$this->load->model('crud_auth');
        $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
        //echo "<pre>"; print_r($_POST);exit;
		$fname = $this->input->post('fname');
		$comid = $this->input->post('comid');
		$details = $this->input->post('details');
		$f_default= $this->input->post('f_default');
		$f_access= $this->input->post('f_access');
		//echo json_encode("its: ".$f_access);exit;
		$params =  array(
			'name'=>$fname,
			'userid'=>$CRUD_AUTH['id'],
			'site_id'=>$CRUD_AUTH['site_id'],
			'moduleid'=>$comid,
			'details'=>$details,
			'access'=>$f_access
		);
		
		if(isset($_POST['f_id'])){
			$this->db->where('id', $_POST['f_id']);
			$this->db->update('filters', $params); 
			$fid=$_POST['f_id'];
		}else {
			 $this->db->insert('filters', $params); 
			 $fid = $this->db->insert_id();

		}
		
		
		if($f_default == "true"){
		
			$this->db->where('crud_user',$CRUD_AUTH['id']);
			$this->db->from('filters_crud_users');
			$query=$this->db->get();
			if($query->num_rows() > 0){
				
			 	//$pp = array('filter_id',$fid);
			 	//echo json_encode($CRUD_AUTH['id']);exit;
			 	//$this->db->where('crud_user',$CRUD_AUTH['id']);
				//$this->db->update('filters_crud_users',$pp,array('crud_user'=>$CRUD_AUTH['id']));
				$x="update filters_crud_users set filter_id = ".$fid. " where crud_user=".$CRUD_AUTH['id'];
				$this->db->query($x);
				
			}else{
				
				$filter_params=array('crud_user'=>$CRUD_AUTH['id'],
					'filter_id'=>$fid);
				// echo json_encode($filter_params) ;exit;
				$this->db->insert("filters_crud_users",$filter_params);
			}
		}
		 
		echo json_encode($fid);
		
	}


    function relatedModFieldList(){
        $selectedModule = $this->input->post('selectedModule');
       // $relatedModules = $this->input->post('relatedModules');
        $ex_rm = explode(',', $relatedModules);
        $moduleFields = array();
		$this->db->select('*');
		$this->db->from('crud_components');
		$this->db->where('component_table',$selectedModule);
		$query = $this->db->get();
		$mainModule = $query->result_array();

		if (!empty($mainModule)) {
			if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$mainModule[0]['id']). '/' . $mainModule[0]['component_table'] . '.php')) {
						exit;
			}
			$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$mainModule[0]['id']) . '/' . $mainModule[0]['component_table'] . '.php'));
			
			$mainModuleConf = unserialize($content);
		} //form_elements
		$mainFieldAlias = array();
		foreach ($mainModuleConf['form_elements'] as $mfkey => $mfvalue) {
			$mainFieldAlias[] = array($mfvalue['alias'],$mfvalue['element'][0],$mfkey);
		}
		$moduleFields[0]['moduleName'] = $mainModule[0]['component_name'];
		$moduleFields[0]['moduleInfo'] = $mainFieldAlias;
        echo json_encode(array('res'=>$moduleFields));
    }

    public function saveReport(){
        $json = $this->input->post('jsonData');
        $data = json_decode($json);
        $mod= array();
		foreach ($json as $key => $value) {
			# code...
		$mod = json_decode($value);
		}
		//echo $json_encode;
        $param = array();
        $param['rname'] = $json['report_name'];
        $param['main_module'] = $json['sel_module'];
        $param['related_modules'] = $json['related_modules'];
        $param['selected_fileds'] = implode(',', $json['module_fields']);
        $groupby = array();
        foreach ($json['groupby'] as $gk => $gv) {
            $groupby[] = implode(',', $gv);
        }
        $param['group_n_order'] = implode(',', $groupby) ; // mul dim arr
        $conditions = array();
        foreach ($json['conditions'] as $ck => $cv) {
            $conditions[] = implode(',', $cv);
        }
        $param['conditions'] = implode('|', $conditions) ;// mul dim arr
        $insert_id = $this->db->insert('reports', $param);
        $ret = array(
                'param'=>$param,                
                'jval'=>$json['report_name'],
                'insert_id'=>$insert_id
        );
        echo json_encode(($ret));
    }

    public function get_filed_options(){
        $selectedModule = $this->input->post('field_info');
        $vars = explode('|', $selectedModule);
        $module_info = explode('.', $vars[0]);
        $module = array();
        $this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where('component_table',$module_info[0]);
        $query = $this->db->get();
        $module = $query->result_array();
        if (!empty($module)) {
			if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$module[0]['id']). '/' . $module[0]['component_table'] . '.php')) {
						exit;
			}
			$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$module[0]['id']) . '/' . $module[0]['component_table'] . '.php'));
			$mainModuleConf = unserialize($content);
        } //form_elements
        $mainFieldAlias = array();
        foreach ($mainModuleConf['form_elements'] as $mfkey => $mfvalue) {
            if ($vars[0] == $mfkey) {
                if ($mfvalue['element'][0] == 'autocomplete') {
                    if (array_key_exists('option_table', $mfvalue['element'][1])) {
                            $related_data = array();
                            $this->db->select('*');
                            $this->db->from($mfvalue['element'][1]['option_table']);                            
                            $query = $this->db->get();
                            $related_data = $query->result_array();
                        if ($mfvalue['element'][1]['option_table'] == 'contact') {
                            foreach ($related_data as $rk => $rv) {
                                $mainFieldAlias[] =array(
                                    'key'=>$rv[$mfvalue['element'][1]['option_key']],
                                    'value'=>ucwords($rv['First_Name']) . ' ' . ucwords($rv['Last_Name'])
                                    );
                            }
                        } else if($mfvalue['element'][1]['option_table'] == 'crud_users'){
                            foreach ($related_data as $rk => $rv) {
                                $mainFieldAlias[] = array(
                                        'key'   => $rv[$mfvalue['element'][1]['option_key']],
                                        'value' => ucwords($rv['user_first_name']) . ' ' . ucwords($rv['user_las_name'])
                                    );
                            }
                        } else {
                            foreach ($related_data as $rk => $rv) {
                                $mainFieldAlias[] =  array(
									'key'=>$rv[$mfvalue['element'][1]['option_key']],
									'value'=>$rv[$mfvalue['element'][1]['option_value']]
								);
                            }
                        }
                    } else {
                        foreach ($mfvalue['element'][1] as $k => $v) {
                            $mainFieldAlias[] =  array(
								'key'=>$k,
								'value'=>$v
							);
                        }
                    }
                }
            }
        }
        echo json_encode($mainFieldAlias);
    }
	function existing_filter(){
		$query = $this->db->get_where('filters',array('name'=>$_POST['filter_name'], 'moduleid'=>$_POST['comid']));
		print_r($query->num_rows);
	}
	
	function delete(){
		$this->db->delete('filters', array('id' => $_GET['f']));
		$this->db->delete('filters_crud_users', array('filter_id' => $_GET['f']));
		redirect(base_url().'index.php/admin/scrud/browse?com_id='.$_GET['comid'],'refresh');

	}
    
}