<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scrud extends Admin_Controller {

//for custom function url
    public function status() {
        require_once APPPATH.'third_party/scrud/cfunctions/Cfunctions.php';
        $Cfunctions = new Cfunctions;
        $cfun = $this->input->get('cfun');
        $Cfunctions->$cfun();

    }
//////////////////////////
    
    public function browse() {
      
        $this->load->model('crud_auth');
        $this->crud_auth->checkBrowsePermission();
        
        $this->load->model('admin/admin_menu');
        $this->load->add_package_path(APPPATH . 'third_party/scrud/');
        
        $var = array();
        $var['main_menu'] = $this->admin_menu->fetch('component');
        
        if(!isset($_GET['com_id'])){
           $comId = 0;
        }else{
           $comId = $this->input->get('com_id');
        }
        
        $this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where('id',$comId);
        $query = $this->db->get();
        $com = $query->row_array();
        
        $_GET['table'] = $com['component_table'];
        
        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId). '/' . $com['component_table'] . '.php')) {
            exit;
        }
        
        $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$comId) . '/' . $com['component_table'] . '.php'));
        
        $conf = unserialize($content);
        
        $hook = Hook::singleton();
        $hook->addFunction('SCRUD_INIT', 'f_scrud_init');
        $hook->addFunction('SCRUD_INIT', 'f_global_access');
        
        $components = array();
        $this->db->select('crud_components.*');
        $this->db->from('crud_components');
        $this->db->join('crud_group_components', 'crud_group_components.id = crud_components.group_id');
        $this->db->where('crud_components.group_id',$com['group_id']);
        $query = $this->db->get();
        $components = $query->result_array();
        $var['components'] = $components;
        if (!empty($components)){
            $conf['theme_path'] = APPPATH.'views/admin/scrud/templates/browse';
        }
        
        // CODE FOR FILTERS STARTS
          $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
          $where= "moduleid=" .$comId . " AND site_id=".$CRUD_AUTH['site_id']." AND (userid=".$CRUD_AUTH['id'] . " OR access=2)";
            $conf['module_filters']=$this->db->query("SELECT * FROM filters WHERE ". $where)->result_array();
        // CODE FOR FILTERS ENDS
          
        $var['conf'] = $conf;

        $this->load->library('crud', array('table' => $com['component_table'], 'conf' => $conf, 'comId'=>$comId));
        $var['content'] = $this->crud->process();
        $var['main_content'] = $this->load->view('admin/scrud/browse', $var, true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();
        
        $this->load->template('layouts/admin/scrud/browse', $var);
    }
    

    public function editorupload(){
    	$CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
    	if (empty($CRUD_AUTH)){
    		exit;
    	}
    	if (isset($_GET['CKEditorFuncNum'])){
	    	require FCPATH.'/application/third_party/scrud/class/FileUpload.php';
	    	$msg = '';                                     // Will be returned empty if no problems
	    	$callback = ($_GET['CKEditorFuncNum']);        // Tells CKeditor which function you are executing
	    	
	    	$fileUpload = new FileUpload();
	    	$fileUpload->uploadDir = __IMAGE_UPLOAD_REAL_PATH__;
	    	$fileUpload->extensions = array('.bmp','.jpeg','.jpg','.png','.gif');
	    	$fileUpload->tmpFileName = $_FILES['upload']['tmp_name'];
	    	$fileUpload->fileName = $_FILES['upload']['name'];
	    	$fileUpload->httpError = $_FILES['upload']['error'];
	    	
	    	if ($fileUpload->upload()) {
	    		$image_url = __MEDIA_PATH__ . "images/".$fileUpload->newFileName;
	    	}
	    	
	    	$error = $fileUpload->getMessage();
	    	if (!empty($error)) {
	    		$msg =  'error : '. implode("\n",$error);
	    	}
	    	$output = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.$image_url .'","'.$msg.'");</script>';
	    	echo $output;
	    	
    	}
    	
    }

    public function config() {
        $this->load->model('crud_auth');
        $this->crud_auth->checkToolManagement();
        
        $var = array();
        $this->load->model('admin/admin_menu');

        $comId = $this->input->get('com_id');
        $this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where('id',$comId);
        $query = $this->db->get();
        $com = $query->row_array();
        $var['com'] = $com;
        $_GET['table'] = $com['component_table'];
        
        $table = $this->input->get('table', true);
        

        $fields = array();
        $sql = "SHOW COLUMNS FROM `" . $table . "`";
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $fields[] = $row;
            }
        }
        $var['fields'] = $fields;

        if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $table . '/' . $table . '.php')) {
            $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $table . '/' . $table . '.php'));
            if (empty($content)) {
                $content = "{}";
            }
        } else {
            $content = "{}";
        }

        $var['crudConfigTable'] = $content;

        $tables = array();
        $query = $this->db->query('SHOW TABLES');
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $tables[] = $row['Tables_in_' . $this->db->database];
            }
        }
        $var['tables'] = $tables;

        // Updates by kamran Sb 30-3-16
        $modules = array();
        $sql = "SELECT * FROM crud_components ORDER BY component_name ASC";
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $modules[] = $row;
            }
        }
        $var['modules'] = $modules;
        //echo "<pre>";print_r($var['modules']);echo "</pre>";
        // Updates by kamran Sb 30-3-16

        $i=0;
        $fieldConfig = array();
        do {

            $filepath = __DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $table . '/' . $i . '.php';
            if (file_exists($filepath)) {
                $content = str_replace("<?php exit; ?>\n", "", file_get_contents($filepath));
                if (!empty($content)) {
                    $fieldConfig[$i] = $content;
                }
            }
            $i++;
        } while(file_exists($filepath));
        /*
        // Original Code
        foreach ($fields as $f) {
            if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $table . '/' . $f['Field'] . '.php')) {
                $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $table . '/' . $f['Field'] . '.php'));
                if (!empty($content)) {
                    $fieldConfig[$f['Field']] = $content;
                }
            }
        }*/
        $var['fieldConfig'] = $fieldConfig;

        $var['main_menu'] = $this->admin_menu->fetch('config');
        $var['main_content'] = $this->load->view('admin/scrud/config', $var, true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->template('layouts/admin/scrud/config', $var);
    }

    public function checklist() {
        $this->load->model('crud_auth');
        $this->crud_auth->checkToolManagement();
        
        $var = array();
        $this->load->model('admin/admin_menu');

        $comId = $this->input->get('chklst_id');
        $this->db->select('*');
        $this->db->from('checklists');
        $this->db->where('id',$comId);
        $query = $this->db->get();
        $com = $query->row_array();
        $var['com'] = $com;

        if (!is_null($com['build_config'])) {
            $content = $com['build_config'];
        }
        $var['crudConfigTable'] = $content;

        if (!is_null($com['section_config'])) {
            $content = $com['section_config'];
            if (!empty($content)) {
                $fieldConfig[0] = $content;
            }
        }

        $var['fieldConfig'] = $fieldConfig;

        $var['main_menu'] = $this->admin_menu->fetch('config');
        $var['main_content'] = $this->load->view('admin/scrud/checklist', $var, true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->template('layouts/admin/scrud/checklist', $var);
    }

    public function getoptions() {
        $var = array();
        $config = $this->input->post('config');
        if (!empty($config)) {
            $crudDao = new ScrudDao($config['table'], $this->db);


            if (isset($config['key']) &&
                    trim($config['key']) != '' &&
                    isset($config['value']) &&
                    trim($config['value']) != '') {
                $params = array();
                $params['fields'] = array($config['key'], $config['value']);
                $rs = $crudDao->find($params);
                if (!empty($rs)) {
                    foreach ($rs as $v) {
                        $var[$v[$config['key']]] = $v[$config['value']];
                    }
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($var);
    }

    public function getfields() {
            $CI =& get_instance();
          $CI->load->library('session');
          $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');

        $table = $this->input->get('table');
        $fields = array();
        $sql = "SHOW COLUMNS FROM `" . $table . "`";
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $fields[] = $row['Field'];
            }
        }

        //CONDITION ARRAY STARTS
          foreach($CRUD_AUTH as $key => $value){
           if(is_array($value)){
            foreach($value as $inkey => $invalue){
             $array[$inkey] = $invalue;
            }
           } else {
            $array[$key] = $value;
           }
          }
  
        $fields['session'] = $array;
        //CONDITION ARRAY END

        header('Content-Type: application/json');
        echo json_encode($fields);
    }

    public function delfile() {
        $this->load->add_package_path(APPPATH . 'third_party/scrud/');
        $comId = $this->input->get('com_id');
        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId) . '/' . $_GET['table'] . '.php')) {
            exit;
        }
        $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId) . '/' . $_GET['table'] . '.php'));
        $conf = unserialize($content);
        $this->load->library('crud', array('table' => $this->input->get('table'), 'conf' => $conf));
        $data = $this->crud->process();
        die($data);
    }

    public function removechecklist() {
        $this->load->model('crud_auth');
        $this->crud_auth->checkToolManagement();

        $chklst_id = $this->input->get('chklst_id');
        if (!empty($chklst_id) && trim($chklst_id) != '') {
            $this->db->query("UPDATE checklists SET config = NULL,build_config = NULL,section_config = NULL WHERE id = ".$chklst_id);
        }
        redirect('/admin/checklist/builder?com_id=87');
    }

    public function removeconfig() {
        $this->load->model('crud_auth');
        $this->crud_auth->checkToolManagement();

        $comId = $this->input->get('com_id');
        if (!empty($comId) && trim($comId) != '') {
            if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId))) {
                removeDir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId));
            }
        }
        redirect('/admin/component/builder?xtype=index');
    }

    public function exportcsv() {
    	$this->load->add_package_path(APPPATH . 'third_party/scrud/');
    	$hook = Hook::singleton();
		$comId = $this->input->get('com_id');
		$conf = array();
    	if (!empty($comId)){
    		$this->db->select('*');
    		$this->db->from('crud_components');
    		$this->db->where('id',$comId);
    		$query = $this->db->get();
    		$com = $query->row_array();
    		$table = $com['component_table'];
    		$_GET['table'] = $com['component_name'];
    		if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId) . '/' . $com['component_table'] . '.php')) {
    			exit;
    		}
    		$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database  . '/' .sha1('com_'.$comId). '/' . $com['component_table'] . '.php'));
    		$conf = unserialize($content);
    	}else{
    		$table = $this->input->get('table');
    		if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' . $table . '.php')) {
    			exit;
    		}
    		switch ($table){
    			case 'crud_users':
    			case 'crud_groups':
    				require __DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' . $table . '.php';
    				break;
    			default:
		    		$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' . $table . '.php'));
		    		$conf = unserialize($content);
    			break;
    		}
    	}
    	
    	$hook->addFunction('SCRUD_INIT', 'f_global_access');
    	
    	
        $this->load->library('crud', array('table' => $table, 'conf' => $conf));
        echo $this->crud->process();
    }

    public function saveconfig() {
        $this->load->model('crud_auth');
        $this->crud_auth->checkToolManagement();
        
        $comId = $this->input->post('com_id');
        $this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where('id',$comId);
        $query = $this->db->get();
        $com = $query->row_array();


        if (!empty($com) && isset($com['component_table'])) {
        
            if (!is_dir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database)) {
                $oldumask = umask(0);
                mkdir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database, 0777);
                umask($oldumask);
            }
            if (!is_dir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId))) {
                $oldumask = umask(0);
                mkdir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId), 0777);
                umask($oldumask);
            }
        
            if (!is_dir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'])) {
                $oldumask = umask(0);
                mkdir(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'], 0777);
                umask($oldumask);
            }
            
            $fields = array();
            $sql = "SHOW COLUMNS FROM `" . $com['component_table'] . "`";
            $query = $this->db->query($sql);
            if (!empty($query)) {
                foreach ($query->result_array() as $row) {
                    $fields[] = $row;
                }
            }
            
//kamran module config backup save
        $p = array(
                'module'=>$comId,
                'user'=>$this_user_id,
                'config_type'=>1,
                'config_string'=>json_encode($_POST['config']),
                'last_updated'=>date('Y-m-d H:i:s'),
            );
            $this->db->insert('module_config_history',$p);
/////////////////////////////
            if (isset($_POST['config'])) {
                if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $com['component_table'] . '.php')) {
                    @unlink(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $com['component_table'] . '.php');
                }
                $oldumask = umask(0);
                file_put_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $com['component_table'] . '.php', "<?php exit; ?>\n" . json_encode($_POST['config']));
                umask($oldumask);
            }
             
            if (isset($_POST['scrud'])) {
                $crud = $_POST['scrud'];
                foreach ($fields as $field) {
                    if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $field['Field'] . '.php')) {
                        @unlink(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $field['Field'] . '.php');
                    }
                }
                foreach ($crud as $f => $v) {
                    $oldumask = umask(0);
                    file_put_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '/' . $f . '.php', "<?php exit; ?>\n" . json_encode($v));
                    umask($oldumask);
                }
            }
        
            $conf = array();
            $conf['title'] = $_POST['config']['table']['crudTitle'];
            $conf['limit'] = $_POST['config']['table']['crudRowsPerPage'];
            $conf['frm_type'] = $_POST['config']['frm_type'];
            $join = array();
        
            if (isset($_POST['config']['join']) && count($_POST['config']['join']) > 0) {
                foreach ($_POST['config']['join'] as $v) {
                    $join[$v['table']] = array($v['type'], $v['table'], $v['currentField'] . ' = ' . $v['targetField']);
                }
            }
        
            $conf['join'] = $join;
        
            if (isset($_POST['config']['table']['crudOrderField'])) {
                $conf['order_field'] = $com['component_table'] . '.' . $_POST['config']['table']['crudOrderField'];
            }
        
            if (isset($_POST['config']['table']['crudOrderType'])) {
                $conf['order_type'] = $_POST['config']['table']['crudOrderType'];
            }
            $validate = array();
            $dataList = array();
            if (isset($_POST['config']['table']['noColumn']) &&
            (int) $_POST['config']['table']['noColumn'] == 1) {
                $dataList['no'] = array('alias' => $this->lang->line('no_'), 'width' => 40, 'align' => 'center', 'format' => '{no}');
            }
            $sections = array();
            foreach ($_POST['scrud'] as $sk => $sv) {
                $secion = array();
                $secion['section_name'] = $sv['section_name'];
                $secion['section_title'] = $sv['section_title'];
                $secion['section_view'] = $sv['section_view'];
                $secion['section_size'] = $sv['section_size']; //given by kamran
                
                foreach ($sv['section_fields'] as $field => $v) {
                    $elements[$com['component_table'] . '.' . $field] = array();
                    $element = array();
                    $element[] = $v['type'];
                    $attributes = array();
                    switch ($v['type']) {
                        case 'checkbox':
                        case 'radio':
                            if (!empty($v['options'])) {
                                $options = array();
                                foreach ($v['options'] as $key => $value) {
                                    $options[$v['values'][$key]] = $value;
                                }
                                $element[] = $options;
                            }
                            break;
                        case 'select':
                            if (!empty($v['multiple'])) {
                                $attributes['multiple'] = $v['multiple'];
                            }
                            $attributes['style'] = 'width:100%';
                            //CONDITION ADDED START
                           $opt['option_condition'] = $v['db_options']['condition'];
                           $opt['option_column'] = $v['db_options']['column'];
                           $opt['option_action'] = $v['db_options']['action'];
                           $opt['option_customtext'] = $v['db_options']['customtext'];
                           //CONDITION ADDED END
                        case 'autocomplete':
                            $attributes['style'] = 'width:100%';
                            if ($v['list_choose'] == 'default') {
                                if (!empty($v['options'])) {
                                    $options = array();
                                    foreach ($v['options'] as $key => $value) {
                                        $options[$key + 1] = $value;
                                    }
                                    $element[] = $options;
                                }
                            } else if ($v['list_choose'] == 'database') {
                                $opt = array();
                                $opt['option_table'] = $v['db_options']['table'];
                                $opt['option_key'] = $v['db_options']['key'];
                                $opt['option_value'] = $v['db_options']['value'];
                                //CONDITION ADDED START
                               $opt['option_condition'] = $v['db_options']['condition'];
                               $opt['option_column'] = $v['db_options']['column'];
                               $opt['option_action'] = $v['db_options']['action'];
                               $opt['option_customtext'] = $v['db_options']['customtext'];
                               //CONDITION ADDED END
                                $element[] = $opt;
                                }
                            break;
                        //HIDDEN OPTIONS
                        case 'hidden':
                            $attributes['value'] = $v['hidden_options']['value'];
                            $attributes['choice'] = $v['hidden_options']['choice'];
                            break;
                        //HIDDEN OPTIONS
                        //CUSTOM FIELDS
                        case 'custom':
                            $attributes['json'] = $v['cfieldsdata']['value'];
                            break;
                        //CUSTOM FIELDS
                        //RELATED MODULE
                        case 'related_module':
                            $related_module = "";
                            if (!empty($v['options']['id'])) {
                                $options = array();
                                $options['id'] = $v['options']['id'];
                                $element[] = $options;
                            }
                            $attributes['style'] = '';
                            break;
                        //RELATED MODULE
                        // MUTLTIPLE REALTED MODULES
                        case 'rm_multiple':
                            $related_module = "";
                            if (!empty($v['options']['id'])) {
                                $options = array();
                                $options['id'] = $v['options']['id'];
                                $element[] = $options;
                            }
                            $attributes['style'] = '';
                        break;
                        case 'notepanel':
                        case 'checklist_panel':
                        case 'text':
                        case 'date':
                        case 'timezone':
                        case 'multiple_add':
                        case 'password':
                            $style = "";
                            if (!empty($v['type_options']['size'])) {
                                $style .= "width:" . $v['type_options']['size'] . ";";
                            }
                            if ($style != "") {
                                $attributes['style'] = $style;
                            }
                            break;
                        case 'datetime':
                            $attributes['style'] = "width:180px;";
                            break;
                        case 'comments':
                        case 'currency':
                        case 'textarea':
                        case 'editor':
                            $style = "width:100%";
                            /*if (!empty($v['type_options']['width'])) {
                                $style .= "width:" . $v['type_options']['width'] . "px;";
                            }
                            if (!empty($v['type_options']['height'])) {
                                $style .= "height:" . $v['type_options']['height'] . "px;";
                            }*/
                            if ($style != "") {
                                $attributes['style'] = $style;
                            }
                            break;
                        case 'image':
                            $attributes['thumbnail'] = "mini";
                            $attributes['width'] = "";
                            $attributes['height'] = "";
                            if (!empty($v['type_options']['thumbnail'])) {
                                $attributes['thumbnail'] = $v['type_options']['thumbnail'];
                            }
                            if (!empty($v['type_options']['img_width'])) {
                                $attributes['width'] = $v['type_options']['img_width'];
                            }
                            if (!empty($v['type_options']['img_height'])) {
                                $attributes['height'] = $v['type_options']['img_height'];
                            }
                            $attributes['style'] = 'display:none;';
                            break;
                        case 'file':
                            $attributes['style'] = "display:none;";
                            break;
                    }
                    //SALMAN EVENTS STARTS
                    if (!empty($v['events'])) {
                        $attributes[$v['events']] = "javascript:".$v['events_action'];
                    }
                    //SALMAN EVENTS STARTS
                    if (!empty($attributes)) {
                        $element[] = $attributes;
                    }
                    //SALMAN ATTACHED FIELD STARTS
                    $checkedlabel=array();
                    if (!empty($v['checkattached'])) {
                        $checkedlabel['attach'] = $v['checkattached'];
                        $checkedlabel['fieldname'] = $v['fieldattached'];
                    }else{
                        $checkedlabel['attach'] = '';
                        $checkedlabel['fieldname'] = '';
                    }
                    if (!empty($checkedlabel)) {
                        $element[] = $checkedlabel;
                    }
                    //SALMAN ATTACHED FIELD end       
                    $tmpField = $field;
                    if (!empty($v['label'])) {
                        $tmpField = $formElements[$com['component_table'] . '.' . $field]['alias'] = $v['label'];
                        $elements[$com['component_table'] . '.' . $field]['alias'] = $v['label'];
                    } else {
                        $formElements[$com['component_table'] . '.' . $field]['alias'] = $v['field'];
                        $elements[$com['component_table'] . '.' . $field]['alias'] = $v['field'];
                    }
            
                    $elements[$com['component_table'] . '.' . $field]['element'] = $element;
                    $formElements[$com['component_table'] . '.' . $field]['element'] = $element;
                
                    $secion['section_fields'] = $formElements;
                    //new validation error format
                    $tmpField = $tmpField ." in ". $secion['section_title'];

                    if (!empty($v['validation'])) {   
                        switch ($v['validation']) {
                            case 'notEmpty':
                                $validate[$com['component_table'] . '.' . $field] = array('rule' => $v['validation'], 'message' => sprintf($this->lang->line('please_enter_value'), $tmpField));
                                
                                break;
                            default :
                                switch ($v['validation']) {
                                    case 'alpha':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_alphabetic_input'), $tmpField);
                                        break;
                                    case 'alphaSpace':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_alphabetic_with_space_input'), $tmpField);
                                        break;
                                    case 'numeric':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_numeric_input'), $tmpField);
                                        break;
                                    case 'alphaNumeric':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_alphan_numeric_input'), $tmpField);
                                        break;
                                    case 'alphaNumericSpace':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_alpha_numeric_with_space_input'), $tmpField);
                                        break;
                                    case 'date':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_valid_date'), $tmpField);
                                        break;
                                    case 'datetime':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_valid_date_time'), $tmpField);
                                        break;
                                    case 'email':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_valid_email'), $tmpField);
                                        break;
                                    case 'ip':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_valid_ip'), $tmpField);
                                        break;
                                    case 'url':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_valid_url'), $tmpField);
                                        break;
                                }
                                $validate[$com['component_table'] . '.' . $field][] = array('rule' => 'notEmpty', 'message' => $tmpMessage);
                                $validate[$com['component_table'] . '.' . $field][] = array('rule' => $v['validation'], 'message' => $tmpMessage);
                                break;
                        }
                    }

                }
                unset($formElements);
                $sections[] = $secion;
            }
            if (isset($_POST['config']['column']['actived']) && count($_POST['config']['column']['actived']) > 0) {
                foreach ($_POST['config']['column']['actived'] as $field) {
                    if (isset($_POST['config']['column']['atrr'][$field])) {
                        $attr = $_POST['config']['column']['atrr'][$field];
                    } else {
                        $attr = array();
                    }
        
                    $tmpField = (strpos($field, '.') === false) ? $com['component_table'] . '.' . $field : $field;
        
                    if (!empty($attr['alias'])) {
                        $dataList[$tmpField]['alias'] = $attr['alias'];
                    } else {
                        $dataList[$tmpField]['alias'] = $field;
                    }
        
                    if (!empty($attr['width'])) {
                        $dataList[$tmpField]['width'] = $attr['width'];
                    }
        
                    if (!empty($attr['align'])) {
                        $dataList[$tmpField]['align'] = $attr['align'];
                    }
        
                    if (!empty($attr['format'])) {
                        $dataList[$tmpField]['format'] = $attr['format'];
                    }
                }
            }
            if (isset($_POST['config']['filter']['actived']) && count($_POST['config']['filter']['actived']) > 0) {
                foreach ($_POST['config']['filter']['actived'] as $field) {
                    $ary = array();
                    if (isset($_POST['config']['filter']['atrr'][$field]) &&
                    isset($_POST['config']['filter']['atrr'][$field]['alias'])) {
                        $ary['alias'] = $_POST['config']['filter']['atrr'][$field]['alias'];
                    }
        
                    $ary['field'] = $com['component_table'] . '.' . $field;
                    $searchForm[] = $ary;
                }
            }
        
            if (!empty($searchForm)) {
                $conf['search_form'] = $searchForm;
            }

            //Add mass edits into json BY KAMRAN SB START
            if (isset($_POST['config']['massedit']['actived']) && count($_POST['config']['massedit']['actived']) > 0) {
                foreach ($_POST['config']['massedit']['actived'] as $field) {
                    $ary = array();
                    if (isset($_POST['config']['massedit']['atrr'][$field]) &&
                    isset($_POST['config']['massedit']['atrr'][$field]['alias'])) {
                        $ary['alias'] = $_POST['config']['massedit']['atrr'][$field]['alias'];
                    }
        
                    $ary['field'] = $com['component_table'] . '.' . $field;
                    $masseidtForm[] = $ary;
                }
            }
            if (!empty($masseidtForm)) {
                $conf['masseidt_form'] = $masseidtForm;
            }
            // end for mass edit json BY KAMRAN SB END
            
            //Add summary into json BY KAMRAN SB START
            if (isset($_POST['config']['summary']['actived']) && count($_POST['config']['summary']['actived']) > 0) {
                foreach ($_POST['config']['summary']['actived'] as $field) {
                    $ary = array();
                    if (isset($_POST['config']['summary']['atrr'][$field]) &&
                    isset($_POST['config']['summary']['atrr'][$field]['alias'])) {
                        $ary['alias'] = $_POST['config']['summary']['atrr'][$field]['alias'];
                    }
        
                    $ary['field'] = $com['component_table'] . '.' . $field;
                    $summaryForm[] = $ary;
                }
            }
            if (!empty($summaryForm)) {
                $conf['summary_form'] = $summaryForm;
            }

            //Add quick create into json
            if (isset($_POST['config']['quickcreate']['actived']) && count($_POST['config']['quickcreate']['actived']) > 0) {
                foreach ($_POST['config']['quickcreate']['actived'] as $field) {
                    $ary = array();
                    if (isset($_POST['config']['quickcreate']['atrr'][$field]) &&
                    isset($_POST['config']['quickcreate']['atrr'][$field]['alias'])) {
                        $ary['alias'] = $_POST['config']['quickcreate']['atrr'][$field]['alias'];
                    }
        
                    $ary['field'] = $com['component_table'] . '.' . $field;
                    $quickcreateForm[] = $ary;
                }
            }
            if (!empty($masseidtForm)) {
                $conf['quickcreate_form'] = $quickcreateForm;
            }
            // end for quick create json
            // end for summary json BY KAMRAN SB END

        
            if (!empty($validate)) {
                $conf['validate'] = $validate;
            }
        
            $width = 50;
            if (!empty($sections)) {
                $format = '<a href="javascript:;" onclick="__view(\'{ppri}\');" class="btn btn-icon-only blue fa fa-search"></a>';
                $format .= ' <a  href="javascript:;" onclick="__edit(\'{ppri}\'); return false;" class="btn btn-icon-only green fa fa-edit"></a>';
                $width += 35;
            }
            $format .= ' <a  href="javascript:;" onclick="__delete(\'{ppri}\'); return false;" class="btn btn-icon-only red fa fa-trash"></a>';
        
            $dataList['action'] = array('alias' => $this->lang->line('actions'), 'format' => $format, 'width' => $width, 'align' => 'center');
        
            if (!empty($dataList)) {
                $conf['data_list'] = $dataList;
            }
        
        
            if (!empty($sections)) {
                $conf['form_elements'] = $sections;
            }
        
            if (!empty($sections)) {
                $conf['elements'] = $sections;
            }
            if(isset($_POST['config']['functions'])){
                $Cfunctions = $_POST['config']['functions'];
               }
                 
               if (!empty($Cfunctions)) {
                    $conf['Cfunctions'] = $Cfunctions;
               }
//kamran config backup save
            $p = array(
                'module'=>$comId,
                'user'=>$this_user_id,
                'config_type'=>2,
                'config_string'=>serialize($conf),
                'last_updated'=>date('Y-m-d H:i:s'),
            );
            $this->db->insert('module_config_history',$p);
/////////////////////////////

            if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '.php')) {
                @unlink(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '.php');
            }
            $oldumask = umask(0);
            file_put_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/'.sha1('com_'.$comId) . '/' . $com['component_table'] . '.php', "<?php exit; ?>\n" . serialize($conf));
            umask($oldumask);
            
            $vfields = array();
            foreach ($fields as $v) {
                $vfields[] = $v['Field'];
            }
            
            if (!in_array('site_id', $vfields)){
                $this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN site_id int(11) NOT NULL DEFAULT 1");
            }
            if (!in_array('eventsfor', $vfields)){
                $this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN eventsfor VARCHAR(255)");
            }
            if (!in_array('created_by', $vfields)){
                $this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN created_by bigint(20)");
            }
            if (!in_array('created', $vfields)){
                $this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN created TIMESTAMP NULL");
            }
            if (!in_array('modified_by', $vfields)){
                $this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN modified_by bigint(20)");
            }
            if (!in_array('modified', $vfields)){
                $this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN modified TIMESTAMP NULL");
            }
            if (!in_array('assigned_to', $vfields)){
                $this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN assigned_to bigint(20)");
            }
            // table number field
            $module_no_field = strtolower($com['component_table']) . 'no';
            if (!in_array($module_no_field, $vfields)){
                $this->db->query("ALTER TABLE `".$com['component_table']."` ADD COLUMN ".$module_no_field." VARCHAR(255)");
            }
        
        }
        $this->db->select('*');
        $this->db->from('crud_module_entity_num');
        $this->db->where('module_id', $com['id']);
        $query = $this->db->get();
        $pre_mod_num = $query->row_array();
        if(empty($pre_mod_num)){  
            $x = 2;
            $newRecordPrefix = substr(strtoupper($com['component_name']), 0, $x);
            $duplicatePrefix = true;
            do {
                $this->db->select('*');
                $this->db->from('crud_module_entity_num');
                $this->db->where('prefix', $newRecordPrefix);
                $query = $this->db->get();
                $prefixAlreadyExist = $query->row_array();
                if(!empty($prefixAlreadyExist)){
                    $x++;
                    $newRecordPrefix = substr(strtoupper($com['component_name']), 0, $x);
                } else {
                    $duplicatePrefix = false;
                }
            } while ($duplicatePrefix);
            $params = array(
                'module_id' => $com['id'],
                'prefix' => $newRecordPrefix,
                'start_id' => 1,
                'curr_id' =>1 
            );
            $this->db->insert('crud_module_entity_num', $params);
        }
    }


    public function savechecklist() {
        $this->load->model('crud_auth');
        $this->crud_auth->checkToolManagement();

        $chklst_id = $this->input->post('chklst_id');
        $this->db->select('*');
        $this->db->from('checklists');
        $this->db->where('id',$chklst_id);
        $query = $this->db->get();
        $com = $query->row_array();

        /*echo "<pre>".print_r($_POST)."</pre>";
        exit;*/

            if (isset($_POST['config'])) {
                $this->db->query("UPDATE checklists SET build_config = '".json_encode($_POST['config'])."' WHERE id = ".$chklst_id);
            }
             
            if (isset($_POST['scrud'])) {
                $crud = $_POST['scrud'];
                foreach ($crud as $f => $v) {
                    $this->db->query("UPDATE checklists SET section_config = '".json_encode($v)."' WHERE id = ".$chklst_id);
                }
            }

        /*if (!empty($com) && isset($com['component_table'])) {*/
        
            
            $validate = array();
            $sections = array();
            foreach ($_POST['scrud'] as $sk => $sv) {
                $secion = array();
                $secion['section_name'] = $sv['section_name'];
                $secion['section_title'] = $sv['section_title'];
                $secion['section_view'] = $sv['section_view'];
                $secion['section_size'] = $sv['section_size']; //given by kamran
                
                foreach ($sv['section_fields'] as $field => $v) {
                    $elements[$com['component_table'] . '.' . $field] = array();
                    $element = array();
                    $element[] = $v['type'];
                    $attributes = array();
                    switch ($v['type']) {
                        case 'checkbox':
                        case 'radio':
                            if (!empty($v['options'])) {
                                $options = array();
                                foreach ($v['options'] as $key => $value) {
                                    $options[$v['values'][$key]] = $value;
                                }
                                $element[] = $options;
                            }
                            break;
                        case 'select':
                            if (!empty($v['multiple'])) {
                                $attributes['multiple'] = $v['multiple'];
                            }
                            $attributes['style'] = 'width:100%';
                            //CONDITION ADDED START
                           $opt['option_condition'] = $v['db_options']['condition'];
                           $opt['option_column'] = $v['db_options']['column'];
                           $opt['option_action'] = $v['db_options']['action'];
                           $opt['option_customtext'] = $v['db_options']['customtext'];
                           //CONDITION ADDED END
                        case 'autocomplete':
                            $attributes['style'] = 'width:100%';
                            if ($v['list_choose'] == 'default') {
                                if (!empty($v['options'])) {
                                    $options = array();
                                    foreach ($v['options'] as $key => $value) {
                                        $options[$key + 1] = $value;
                                    }
                                    $element[] = $options;
                                }
                            } else if ($v['list_choose'] == 'database') {
                                $opt = array();
                                $opt['option_table'] = $v['db_options']['table'];
                                $opt['option_key'] = $v['db_options']['key'];
                                $opt['option_value'] = $v['db_options']['value'];
                                //CONDITION ADDED START
                               $opt['option_condition'] = $v['db_options']['condition'];
                               $opt['option_column'] = $v['db_options']['column'];
                               $opt['option_action'] = $v['db_options']['action'];
                               $opt['option_customtext'] = $v['db_options']['customtext'];
                               //CONDITION ADDED END
                                $element[] = $opt;
                                }
                            break;
                        //HIDDEN OPTIONS
                        case 'hidden':
                            $attributes['value'] = $v['hidden_options']['value'];
                            $attributes['choice'] = $v['hidden_options']['choice'];
                            break;
                        //HIDDEN OPTIONS
                        //CUSTOM FIELDS
                        case 'custom':
                            $attributes['json'] = $v['cfieldsdata']['value'];
                            break;
                        //CUSTOM FIELDS
                        //RELATED MODULE
                        case 'related_module':
                            $related_module = "";
                            if (!empty($v['options']['id'])) {
                                $options = array();
                                $options['id'] = $v['options']['id'];
                                $element[] = $options;
                            }
                            $attributes['style'] = '';
                            break;
                        //RELATED MODULE
                        // MUTLTIPLE REALTED MODULES
                        case 'rm_multiple':
                            $related_module = "";
                            if (!empty($v['options']['id'])) {
                                $options = array();
                                $options['id'] = $v['options']['id'];
                                $element[] = $options;
                            }
                            $attributes['style'] = '';
                        break;
                        case 'notepanel':
                        case 'checklist_panel':
                        case 'text':
                        case 'date':
                        case 'timezone':
                        case 'multiple_add':
                        case 'password':
                            $style = "";
                            if (!empty($v['type_options']['size'])) {
                                $style .= "width:" . $v['type_options']['size'] . ";";
                            }
                            if ($style != "") {
                                $attributes['style'] = $style;
                            }
                            break;
                        case 'datetime':
                            $attributes['style'] = "width:180px;";
                            break;
                        case 'comments':
                        case 'currency':
                        case 'textarea':
                        case 'editor':
                            $style = "width:100%";
                            /*if (!empty($v['type_options']['width'])) {
                                $style .= "width:" . $v['type_options']['width'] . "px;";
                            }
                            if (!empty($v['type_options']['height'])) {
                                $style .= "height:" . $v['type_options']['height'] . "px;";
                            }*/
                            if ($style != "") {
                                $attributes['style'] = $style;
                            }
                            break;
                        case 'image':
                            $attributes['thumbnail'] = "mini";
                            $attributes['width'] = "";
                            $attributes['height'] = "";
                            if (!empty($v['type_options']['thumbnail'])) {
                                $attributes['thumbnail'] = $v['type_options']['thumbnail'];
                            }
                            if (!empty($v['type_options']['img_width'])) {
                                $attributes['width'] = $v['type_options']['img_width'];
                            }
                            if (!empty($v['type_options']['img_height'])) {
                                $attributes['height'] = $v['type_options']['img_height'];
                            }
                            $attributes['style'] = 'display:none;';
                            break;
                        case 'file':
                            $attributes['style'] = "display:none;";
                            break;
                    }
                    //SALMAN EVENTS STARTS
                    if (!empty($v['events'])) {
                        $attributes[$v['events']] = "javascript:".$v['events_action'];
                    }
                    //SALMAN EVENTS STARTS
                    if (!empty($attributes)) {
                        $element[] = $attributes;
                    }
                    $tmpField = $field;
                    if (!empty($v['label'])) {
                        $tmpField = $formElements[$field]['alias'] = $v['label'];
                        $elements[$field]['alias'] = $v['label'];
                    } else {
                        $formElements[$field]['alias'] = $v['field'];
                        $elements[$field]['alias'] = $v['field'];
                    }

                    $elements[$field]['element'] = $element;
                    $formElements[$field]['element'] = $element;
                
                    $secion['section_fields'] = $formElements;

                    if (!empty($v['validation'])) {   
                        switch ($v['validation']) {
                            case 'notEmpty':
                                $validate[$field] = array('rule' => $v['validation'], 'message' => sprintf($this->lang->line('please_enter_value'), $tmpField));
                                
                                break;
                            default :
                                switch ($v['validation']) {
                                    case 'alpha':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_alphabetic_input'), $tmpField);
                                        break;
                                    case 'alphaSpace':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_alphabetic_with_space_input'), $tmpField);
                                        break;
                                    case 'numeric':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_numeric_input'), $tmpField);
                                        break;
                                    case 'alphaNumeric':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_alphan_numeric_input'), $tmpField);
                                        break;
                                    case 'alphaNumericSpace':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_alpha_numeric_with_space_input'), $tmpField);
                                        break;
                                    case 'date':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_valid_date'), $tmpField);
                                        break;
                                    case 'datetime':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_valid_date_time'), $tmpField);
                                        break;
                                    case 'email':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_valid_email'), $tmpField);
                                        break;
                                    case 'ip':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_valid_ip'), $tmpField);
                                        break;
                                    case 'url':
                                        $tmpMessage = sprintf($this->lang->line('please_provide_valid_url'), $tmpField);
                                        break;
                                }
                                $validate[$field][] = array('rule' => 'notEmpty', 'message' => $tmpMessage);
                                $validate[$field][] = array('rule' => $v['validation'], 'message' => $tmpMessage);
                                break;
                        }
                    }

                }
                unset($formElements);
                $sections[] = $secion;
            }
        
            if (!empty($validate)) {
                $conf['validate'] = $validate;
            }
        
            if (!empty($sections)) {
                $conf['form_elements'] = $sections;
            }
        
            if (!empty($sections)) {
                $conf['elements'] = $sections;
            }
        /*
        }
        */
        $this->db->query("UPDATE checklists SET config = '".serialize($conf)."' WHERE id = ".$chklst_id);
        /*echo "<pre>".print_r($_POST)."</pre>";
        exit;*/

    }


}