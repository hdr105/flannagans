<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gsearch extends Admin_Controller {

    public function index() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
        $this->load->add_package_path(APPPATH . 'third_party/scrud/');
        
        $var = array();

        $search_key = $this->input->get('search');

        $var['search_key'] = $search_key;


        /*
            Get data from all modules 


        */
        $moduleList = array();

        $excludeModulesID = array( '0' );
        $excludeModulesTitle = array( '' );
        $excludeModulesTable = array( '' );
        
        $this->db->select('id');
        $this->db->from('crud_components');
        $this->db->where_not_in('id',$excludeModulesID);
        $this->db->where_not_in('component_name',$excludeModulesTitle);
        $this->db->where_not_in('component_table',$excludeModulesTable);
        $query = $this->db->get();

        $modules_arr = $query->result_array();
        $page_content = array();
        //print_r($modules_arr);
        foreach ($modules_arr as  $module_value) {
            $comId = $module_value['id'];
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
            
            $fields = array();
            $rs = $this->db->query("SHOW FULL COLUMNS FROM `".$com['component_table']."`");
            if (empty($rs)) {
                throw new Exception($this->db->_error_message());
            }
            if (!empty($rs)) {
                foreach ($rs->result_array() as $row) {
                   
                   $extype = explode('(', $row['Type']);
                    
                    if ($extype[0] == 'varchar' || $extype[0] == 'text') {
                        $fields[] = $com['component_table'].'.'.$row['Field'];
                    }
                    
                }
            }
            if(count($fields)==0)
                continue;
            $t = implode(",'',", $fields);
               
            
            $_dao = new ScrudDao($com['component_table'],$this->db);
            
            $conditions = ' Concat('.$t.')  like ? AND site_id = ?';
            $ps[] = '%' . $search_key . '%';
            $ps[] = $this->session->userdata('CRUD_AUTH')['site_id'];

            $params = array();
            $params['fields'] = $fields;
            $params['conditions'] = array($conditions, $ps);
            $module_result = $_dao->find($params);
        //print_r($module_result);
            
            $page_content[] = array('title'=>$com['component_name'], 'data'=>$module_result, 'conf'=>$conf, 'table'=>$com['component_table'], 'comid'=>$comId);
            unset($module_result);
            unset($fields);
            unset($ps);
            unset($params);

           
        }
         
//exit;            
        $var['module_data_full'] = $page_content;

          
        //echo "<pre>";print_r($var);exit;
        
        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/common/gsearch',$var,true);

        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->template('layouts/admin/gsearch', $var);
        //$this->load->view('layouts/admin/gsearch', $var);
    }
    public function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }
    
    

}