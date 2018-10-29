<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gsearch extends Admin_Controller {

    public function index() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
        $this->load->add_package_path(APPPATH . 'third_party/scrud/');
        $CRUD_AUTH = $this->session->userdata['CRUD_AUTH']; 
        //echo '<pre>';print_r($this->session->userdata['CRUD_AUTH']);exit;
        $var = array();

        $search_key = $this->input->get('search');

        $var['search_key'] = $search_key;

        /*
            Get data from all modules 


        */
        $moduleList = array();

        $excludeModulesID = array( '20' );
        $excludeModulesTitle = array( '' );
        $excludeModulesTable = array( '' );
        
        $this->db->select('id');
        $this->db->from('crud_components');
        $this->db->where_not_in('id',$excludeModulesID);
        $this->db->where_not_in('component_name',$excludeModulesTitle);
        $this->db->where_not_in('component_table',$excludeModulesTable);
        $this->db->order_by('component_table', 'asc');
        $query = $this->db->get();
        $ii=0;
        $modules_arr = $query->result_array();
        $page_content = array();
        //print_r($modules_arr);
        //echo "<pre>"; print_r($modules_arr); echo "</pre>";exit;
        foreach ($modules_arr as  $module_value) {
            //echo "<pre>"; print_r($module_value); echo "</pre>";
            $comId = $module_value['id'];

            $this->db->select('permission_type');
            $this->db->from('crud_permissions');
            $this->db->where('com_id',$comId); 
            $this->db->where('group_id',$CRUD_AUTH['group_id']); 
            $query = $this->db->get();
            $array = $query->result_array();
            $permissions = array_reduce($array, function ($result, $current) {$result[]=current($current); return $result;}, array());
            if (!in_array(4, $permissions)) 
                continue;
            //echo "<pre>"; print_r($permissions); echo "</pre>";

            $this->db->select('*');
            $this->db->from('crud_components');
            $this->db->where('id',$comId); 
            $query = $this->db->get();
            $com = $query->row_array();
            
            $_GET['table'] = $com['component_table'];
            //echo "<pre>"; print_r($com); echo "</pre>";
            //echo $ii++;

            

            
            if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId). '/' . $com['component_table'] . '.php')) {
                exit;
            }
            
            $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$comId) . '/' . $com['component_table'] . '.php'));
            $conf = unserialize($content);
            
            $hook = Hook::singleton();
            $hook->addFunction('SCRUD_INIT', 'f_scrud_init');
            $hook->addFunction('SCRUD_INIT', 'f_global_access');
            
            $components = array();
            $this->db->select('*');
            $this->db->from('crud_components');
            $this->db->join('crud_group_components', 'crud_group_components.id = crud_components.group_id');
            $this->db->where('crud_components.group_id',$com['group_id']);
            
            $query = $this->db->get();
            
            $components = $query->result_array();
            
            $var['components'] = $components;
            //echo "<pre>"; echo($com['component_table']); echo "</pre>";
            $ids=array();
            $fields = array();
            $rs = $this->db->query("SHOW FULL COLUMNS FROM `".$com['component_table']."`");
            if (empty($rs)) {
                throw new Exception($this->db->_error_message());
            }
            if (!empty($rs)) {
                //echo "<pre>"; print_r($rs->result_array()); echo "</pre>";exit;//////////////////
                foreach ($rs->result_array() as $row) {
                   
                   $extype = explode('(', $row['Type']);

                    if (($extype[0] == 'varchar' || $extype[0] == 'text') and $row['Field']!="module") {
                        
                        if(array_key_exists($com['component_table'].'.'.$row['Field'],$conf['data_list']))
                        {   
                            $fields[] = $com['component_table'].'.'.$row['Field'];

                        }
                        

                    }
                    if($row['Key']=='PRI'){
                        $fields[]=$com['component_table'].'.'.$row['Field'];
                    }


                }

            //echo "<pre>"; print_r($fields); echo "</pre>";
            }
            if(count($fields)==0)
                continue;
            $t = implode(",'',", $fields);
               
            //echo "<pre>"; print_r($conf); echo "</pre>";/////////////////////////////////////
            // if(array_key_exists('business.title',$conf['data_list']))
            //     {echo "something"; exit;}

            $_dao = new ScrudDao($com['component_table'],$this->db);
            
            $conditions = ' Concat('.$t.')  like ? AND site_id = ?';
            $strAnd = 'AND ';

        if($comId==41){
            $conditions .= ' ' . $strAnd . ' legal_entity = 1';
        }elseif($comId==42){
            $conditions .= ' ' . $strAnd . ' legal_entity = 2';
        }elseif($comId==43){
            $conditions .= ' ' . $strAnd . ' legal_entity = 3';
        }elseif($comId==44){
            $conditions .= ' ' . $strAnd . ' legal_entity = 4';
        }elseif($comId==45){
            $conditions .= ' ' . $strAnd . ' legal_entity = 5';
        }

        if (!in_array(5, $permissions)){
            $conditions .= ' ' . $strAnd . ' (' . $com['component_table'] . '.created_by = '.$CRUD_AUTH['id'].' or ' . $com['component_table'] . '.assigned_to = '.$CRUD_AUTH['id'].') ' ;
            $strAnd = 'AND ';
        }

            $ps[] = '%' . $search_key . '%';
            $ps[] = $CRUD_AUTH['site_id'];

            $params = array();
            $params['fields'] = $fields;
            $params['conditions'] = array($conditions, $ps);
            //$params['group']=$com['component_table'];
            
            //echo "<pre>"; print_r($ids); echo "</pre>";
            $module_result = $_dao->find($params);
            //print_r($module_result);
            //echo "<pre>"; print_r($module_result); echo "</pre>";
            $page_content[] = array('title'=>$com['component_name'], 'data'=>$module_result, 'conf'=>$conf, 'table'=>$com['component_table'], 'comid'=>$comId);
            //echo "<pre>"; print_r($page_content); echo "</pre>";
            unset($module_result);
            unset($fields);
            unset($ps);
            unset($params);

           
        }
         
//exit;            
        $var['module_data_full'] = $page_content;

          
        //echo "<pre>";print_r($var);exit;
        //echo "<pre>"; print_r($module_result); echo "</pre>";

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