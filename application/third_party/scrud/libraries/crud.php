<?php

$class_path = dirname(dirname(__FILE__));

require_once $class_path . '/class/Validation.php';
require_once $class_path . '/class/FileUpload.php';
require_once $class_path . '/class/Image.php';
//CUSTOM FUNCTIONS FILE
require_once $class_path . '/cfunctions/Cfunctions.php';
class Crud {

    private $da;
    private $conf;
    private $title = '';
    private $errors = array();
    private $dao;
    private $primaryKey = array();
    private $fields;
    private $conditions = null;
    private $join = array();
    private $fieldsDisplay = array();
    private $fieldsAlias = array();
    private $orderField = '';
    private $orderType = '';
    private $colsWidth = array();
    private $colsCustom = array();
    private $colsAlign = array();
    private $pageIndex = 1;
    private $limit = 20;
    //private $search = 'one_field';
    private $form = array();
    private $elements = array();
    private $validate = array();
    private $data = array();
    private $queryString = array();
    private $table;
    private $fileUpload;
    private $image;
    private $frmType = '1';
    private $globalAccess = false;
    // Passed module ID from controler
    private $comId = 0;
    //CUSTOM FUNCTIONS
    //Summary View BY KAMRAN SB START
    private $summaryDispay = array();
    private $summaryAlias = array();
    private $summaryData = array();
    
    
    private $search = 'one_field';
    //Mass Edit
    private $massedit = 'one_field';
    //Quick Create 
    private $quickcreate = 'one_field';
    //Summary View BY KAMRAN SB END
    //Quick Create Module
    private $quickcreateModule = 'one_field';

    private $CfunctionsArray = array();

    public function __construct($params = array('table' => null, 'conf' => array(),  'comId' => 0)) {
        $class_path = dirname(dirname(__FILE__));

        $CI = & get_instance();
        $this->da = & $CI->db;

        $table = $params['table'];
        $conf = $params['conf'];

        if(!isset($params['comId'])){
           $this->comId = 0;
        } else {
           $this->comId = $params['comId'];
        }


        $hook = Hook::singleton();
        
        if (empty($this->da)) {
            die('DataAccess object is not null.');
        }
        if ($hook->isExisted('SCRUD_INIT')) {
            $conf = $hook->filter('SCRUD_INIT', $conf);
        }

        $conf['theme_path'] = (!empty($conf['theme_path'])) ? $conf['theme_path'] : $class_path . '/templates';
        if (file_exists($conf['theme_path'] . '/template_functions.php')) {
            require_once $conf['theme_path'] . '/template_functions.php';
        } else {
            require_once $class_path . '/templates/template_functions.php';
        }

        $this->fileUpload = new FileUpload();

        $this->image = new Image(__IMAGE_UPLOAD_REAL_PATH__);
	    if (isset($conf['global_access']) && $conf['global_access'] == true) {
        	$this->globalAccess = true;
        }

        // CODE FOR FILTERS STARTS
        if (isset($conf['module_filters'])) {
            $this->module_filters = $conf['module_filters'];
        }
        // CODE FOR FILTERS ENDS

        if (isset($conf['frm_type'])) {
            $this->frmType = $conf['frm_type'];
        }

        if (empty($conf['order_field'])) {
            $conf['order_field'] = '';
        }
        if (empty($conf['order_type'])) {
            $conf['order_type'] = '';
        }

        if (isset($conf['title'])) {
            $this->setTitle($conf['title']);
        }

        if (isset($conf['form_elements'])) {
            $this->formElements($conf['form_elements']);
        }

        if (isset($conf['elements'])) {
            $this->elements($conf['elements']);
        }

        if (isset($conf['search_form'])) {
            $this->searchForm('fields', $conf['search_form']);
        }

        //CHANGES BY KAMRAN SB STARTS
        // Mass edit starts here
        if (isset($conf['masseidt_form'])) {
            $this->massEditForm('fields', $conf['masseidt_form']);
        }
        // Mass edit section ends here
        // Quick Create starts here
        if (isset($conf['quickcreate_form'])) {
            $this->massQuickCreateForm('fields', $conf['quickcreate_form']);
        }
        // Quick Create section ends here
        if (isset($conf['search_form'])) {
            $this->searchForm('fields', $conf['search_form']);
        }

        if (isset($conf['data_list'])) {
            $this->dataList($conf['data_list']);
        }
        // Suimary View section
        if (isset($conf['summary_form'])) {
            $this->summaryView($conf['summary_form']);
        }
        // summary view section ends here
        //CHANGES BY KAMRAN SB ENDS
    

        //custom function by salman
        if (isset($conf['Cfunctions'])) {
             $this->CfunctionsArray = $conf['Cfunctions'];
        }
        //print_r($conf);
        //exit();

        if (isset($conf['validate']) && is_array($conf['validate'])) {
            $this->validate = $conf['validate'];
        }
        if ($hook->isExisted('SCRUD_BEFORE_VALIDATE')) {
            $this->validate = $hook->filter('SCRUD_BEFORE_VALIDATE', $this->validate);
        }

        if (isset($conf['join']) && is_array($conf['join'])) {
            $this->join = $conf['join'];
        }

        $conf['limit_opts'] = (isset($conf['limit_opts']) && is_array($conf['limit_opts'])) ? $conf['limit_opts'] : array();
        //$conf['theme_path'] = (!empty($conf['theme_path'])) ? $conf['theme_path'] : dirname(__FILE__) . '/templates';
        $conf['theme'] = (!empty($conf['theme'])) ? $conf['theme'] : '';
        $conf['color'] = (!empty($conf['color'])) ? $conf['color'] : '';
        $this->table = $conf['table'] = $table;

        $this->dao = new ScrudDao($conf['table'], $this->da);
        $this->conf = $conf;

        $fields = $this->dao->listFields($this->conf['table']);
        foreach ($fields as $v) {
            $this->fields[] = $this->conf['table'] . '.' . $v['Field'];
            if ($v['Key'] == "PRI") {
                $this->primaryKey[] = $this->conf['table'] . '.' . $v['Field'];
            }
        }

        if (!empty($this->conf['join'])) {
            foreach ($this->conf['join'] as $table => $v) {
                $fields = $this->dao->listFields($table);
                foreach ($fields as $v) {
                    $this->fields[] = $table . '.' . $v['Field'];
                }
            }
        }

        $this->dao->p_fields = $this->fields;


        $this->limit = (isset($conf['limit'])) ? $conf['limit'] : 20;
        $data = $CI->input->post('data');
        $this->data = (!empty($data)) ? $data : array();
    }

    //public function join($type, $table, $conditions) {
    //    $this->join[] = array($type, $table, $conditions);
    //}

    public function conditions($conditions) {
        $this->conditions = $conditions;
    }

    private function setTitle($title) {
        $this->title = $title;
    }

    private function fields($fields = array()) {
        $this->fields = $fields;
    }

    private function colsWidth($colsWidth = array()) {
        $this->colsWidth = $colsWidth;
    }

    /**
     * @param $dataList
     */
    private function dataList($dataList = array()) {
        foreach ($dataList as $field => $v) {
            if (isset($field)) {
                $this->fieldsDisplay[] = $field;
            } else {
                continue;
            }
            if (isset($v['alias'])) {
                $this->fieldsAlias[$field] = $v['alias'];
            }
            if (isset($v['width'])) {
                $this->colsWidth[$field] = $v['width'];
            }
            if (isset($v['format'])) {
                $this->colsCustom[$field] = $v['format'];
            }
            if (isset($v['align'])) {
                $this->colsAlign[$field] = $v['align'];
            }
        }
    }


    //CHANGES BY KAMRAN SB START
    private function summaryView($summaryView = array()){
        foreach ($summaryView as $field => $v) {
            if (isset($field)) {
                $this->summaryDispay[] = $v['field'];
            } else {
                continue;
            }
            if (isset($v['alias'])) {
                $this->summaryAlias[$v['field']] = $v['alias'];
            }
        }
    }
    
    private function massEditForm($type = 'one_field', $elements = array()) {
        switch ($type) {
            case 'one_field':
                $this->massedit = 'one_field';
                break;
            case 'fields':
                $this->massedit = $elements;
                break;
        }
    }
    
    private function massQuickCreateForm($type = 'one_field', $elements = array()) {
        switch ($type) {
            case 'one_field':
                $this->quickcreate = 'one_field';
                break;
            case 'fields':
                $this->quickcreate = $elements;
                break;
        }
    }
    //CHANGES BY KAMRAN SB END


    /**
     *
     * @param $type
     * @param $elements
     */
    private function searchForm($type = 'one_field', $elements = array()) {
        switch ($type) {
            case 'one_field':
                $this->search = 'one_field';
                break;
            case 'fields':
                $this->search = $elements;
                break;
        }
    }

    /**
     *
     * @param $form
     */
    private function formElements($form = array()) {
        $this->form = $form;
    }

    private function elements($element = array()) {
        $this->elements = $element;
    }

    /**
     *
     */
    public function getDa() {
        return $this->da;
    }

    /**
     *
     */
    public function process() {
        $CI = & get_instance();
        if (!empty($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $this->queryString);
        }
        if (isset($this->queryString['wp'])) {
            unset($this->queryString['wp']);
        }

        $action = (isset($_GET['xtype'])) ? trim($_GET['xtype']) : '';
        ob_start();
        switch ($action) {
        	case 'index':
                switch ($this->comId) {
                    case '80': //All Calendar
                    case '25': //My Calendar
                        $show = (isset($_GET['show'])) ? trim($_GET['show']) : 'calendar';
                        if ($show == 'calendar') {
                            $this->calendar();
                        } else {
                            $this->index();
                        }
                    break;
                    case '29': // Folder Module
                    case '30': // Document Module
                        $this->folder_directory();
                    break;
                    default:
                        $this->index();
                    break;
                }
            break;
            case 'availabilityForm':
                $this->availabilityform();
                break;
            case 'accpet_inv':
                $this->accpet_inv();
                break;
        	//UPDATES BY KAMRAN SB START
            case 'summary':
                $this->summary();
                break;
            case 'modalform':
                $this->modalform();
                break;
            // Mass edit
            case 'massedit':
                $this->modalmasseditform();
                break;
            // Mass edit ends
            case 'email':
                $this->modalemailpdfform();
                break;
            case 'sendmail':
                $this->modalemailsend();
                break;
            // Quick Create
            case 'quickcreate':
                $this->modalQuickCreateform();
                break;
            // Quick Create
            // Quick Create MODULE
            case 'quickcreateModule':
                $this->modalQuickCreateModuleform();
                break;
            // Quick Create MODULE

            case 'quickcreateform':
                $this->quickCreateForm();
                break;
            case 'quickcreateModuleform':
                $this->quickCreateModuleForm();
                break;
            case 'viewRelatedModuleData':
                $this->viewRelatedModuleData();
                break;
            case 'massupdate':
                $this->massUpdate();
                break;
            case 'massdelete':
                $this->massdelete();
                break;
            //UPDATES BY KAMRAN SB END
        	//UPDATES BY KAMRAN SB START 30-3-16
            //summary data list for adding multiple records into a single record
            case 'summary_view_datalist':
                $this->summary_view_datalist();
                break;
            // summary data list ends here
            //UPDATES BY KAMRAN SB END 30-3-16
            case 'form':
        		$this->form();
        		break;
        	case 'confirm':
                $this->confirm();
                break;
            case 'update':
                $this->update();
                break;
            case 'updateDraft':
                $this->updateDraft();
                break;
            case 'updateChecklist':
                $this->updateChecklist();
                break;
            case 'del':
                $this->del();
                break;
            case 'delFile':
                $this->delFile();
                break;
            case 'delconfirm':
                $this->delConfirm();
                break;
            case 'delchklst':
                $this->delchklst();
                break;
            case 'exportcsv':
            	$this->exportCsv();
            	break;
            case 'exportcsvall':
            	$this->exportcsvall();
            	break;
            case 'view':
                if ($CI->input->get('com_id') == '31') {  //reports view
                    $this->reports();
                } else{
                    $this->view();
                }
                break;
            case 'view_pdf':
                $this->view_pdf();
                break;
            case 'business_summary': //bus_summary
                $busCfunctions = new Cfunctions;  
                $busCfunctions->modalBusinessSummaryView();
                break;
            default:
                $CI->session->unset_userdata('auth_token_xtable');
                $CI->session->unset_userdata('xtable_search_conditions');
                $this->index();
                break;
        }
        $content = ob_get_contents();
        ob_get_clean();

        return $content;
    }

    /**
     *
     */
    private function index() {
        $CI = & get_instance();
        $CI->load->model('crud_auth');
        $auth = $CI->crud_auth;
        $src = $CI->input->post('src');
        if (!empty($src)) {
            if (isset($src['availability_search'])) {
               $this->genCalSearch(); 
            } else {
                $this->genIndexView();
            }
            
        } else {
            $this->genIndexView();
        }
    }
    /**
     *
     */
    public function availabilityform(){
        $CI = & get_instance();
        $xConditions = $CI->session->userdata('xtable_search_conditions');
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
        }
        if (is_file($this->conf['theme_path'] . '/availability_search.php')) {
            require_once $this->conf['theme_path'] . '/availability_search.php';
            exit;
        } else {
            die($this->conf['theme_path'] . '/availability_search.php is not found.');
        }
    }
    /**
     *
     */
    private function genIndexView() {
        $CI = & get_instance();
        $CI->load->model('crud_auth');
        $auth = $CI->crud_auth;
        $src = $CI->input->post('src');
        
        if (!empty($src)){

            /*$_t = new ScrudDao('test_table', $this->da);
            $_tdata['test_info'] = implode(',', $src[$this->conf['table']]);
            $_t->insert($_tdata);*/

            foreach ($src[$this->conf['table']] as $k => $v){
            
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                ($this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'date' or
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'date_simple') && $v != ''){
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                    if (!is_date($v)){
                        $v = '';
                    }
                }
                 
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'datetime' && $v != ''){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                    if (!is_date($v)){
                        $v = '';
                    }
                }
                
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'time' && $v != ''){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }
                
                $_POST['src'][$this->conf['table']][$k] = $v;
                
            }
        }


        if (!empty($this->conf['join'])) {
            foreach ($this->conf['join'] as $tbl => $tmp) {
                if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' . $tbl . '.php')) {
                    $content = unserialize(str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' . $tbl . '.php')));
                    if (!empty($content['form_elements'])) {
                        foreach ($content['form_elements'] as $k => $v) {
                            if (strpos($k, '.') !== false) {
                                $this->form[$k] = $v;
                            }
                        }
                    }
                }
            }
        }
        
        
        $xConditions = $CI->session->userdata('xtable_search_conditions');
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
            $src = $CI->input->post('src');
            unset($src['page']);
        }
        if (!isset($src['page'])) {
            if (isset($_GET['src']['p'])) {
                $_POST['src']['page'] = $_GET['src']['p'];
                $src = $CI->input->post('src');
            }
        }
        if (isset($_GET['src']['l'])) {
            $_POST['src']['limit'] = $_GET['src']['l'];
            $src = $CI->input->post('src');
        }
        $pageIndex = (!empty($src['page'])) ? $src['page'] : 1;
        $this->pageIndex = $pageIndex = ((int) $pageIndex > 0) ? (int) $pageIndex : 1;
        $this->limit = (isset($src['limit'])) ? $src['limit'] : $this->limit;
        $conditions = '';
        $order = '';
        $ps = array();
        $strAnd = '';
        if (is_array($this->search)) {
            foreach ($this->fields as $field) {
                $ary = explode('.', $field);
                if (!empty($src) &&
                isset($src[$ary[0]][$ary[1]]) &&
                $src[$ary[0]][$ary[1]] != '$$__src_r_all_value__$$'
                        ) {
                    if (!is_array($src[$ary[0]][$ary[1]]) && trim($src[$ary[0]][$ary[1]]) != '') {
                        if (isset($this->form[$field]['element'][0]) &&
                        ($this->form[$field]['element'][0] == 'autocomplete' ||
                                $this->form[$field]['element'][0] == 'select')){
                            $conditions .= $strAnd . $field . ' = ? ';
                            $ps[] =  $src[$ary[0]][$ary[1]];
                            $strAnd = 'AND ';
                        }else{
                            $conditions .= $strAnd . $field . ' like ? ';
                            $ps[] = '%' . $src[$ary[0]][$ary[1]] . '%';
                            $strAnd = 'AND ';
                        }
                    } else if (is_array($src[$ary[0]][$ary[1]])) {
                        if (count($src[$ary[0]][$ary[1]]) > 0) {
                            $strOr  = '';
                            $tempConditons = "";
                            foreach ($src[$ary[0]][$ary[1]] as $v) {
                                if (!empty($v)){
                                    $tempConditons .= $strOr . $field . ' like ? ';
                                    $ps[] = '%,' . $v . ',%';
                                    $strOr = ' OR ';
                                }
                            }
                            if ($tempConditons != ""){
                                $conditions .= $strAnd .' ( '.$tempConditons.' ) ';
                                $strAnd = ' AND ';
                            }
                        }
                    }
                }
            }
        } else if ($this->search == 'one_field') {
            if (!empty($src) &&
                    isset($src['one_field']) &&
                    trim($src['one_field']) !== '') {
                $conditions .= "(";
                foreach ($this->fields as $field) {
                    if (!in_array($field, $this->fieldsDisplay))
                        continue;
                    if (trim($src['one_field']) !== '') {
                        $conditions .= $strAnd . $field . ' like ? ';
                        $ps[] = '%' . $src['one_field'] . '%';
                        $strAnd = 'OR ';
                    }
                }
                $conditions .= ")";
                $strAnd = 'AND ';
            }
        }

        if (isset($_GET['src']['o'])) {
            $_POST['src']['order_field'] = $_GET['src']['o'];
            $src = $CI->input->post('src');
        }
        if (isset($_GET['src']['t'])) {
            $_POST['src']['order_type'] = $_GET['src']['t'];
            $src = $CI->input->post('src');
        }
        if (!empty($src['order_field']) && !empty($src['order_type'])) {
            $order .= $src['order_field'] . ' ' . $src['order_type'];
            $this->orderField = trim($src['order_field']);
            $this->orderType = trim(strtolower($src['order_type']));
        } else if (!empty($this->conf['order_field']) && !empty($this->conf['order_type'])) {
            $order .= $this->conf['order_field'] . ' ' . $this->conf['order_type'];
            $this->orderField = trim($this->conf['order_field']);
            $this->orderType = trim(strtolower($this->conf['order_type']));
        }
        if (!empty($this->conditions)) {
            if (is_array($this->conditions)) {
                $conditions .= ' ' . $strAnd . $this->conditions[0] . ' ';
                foreach ($this->conditions[1] as $v) {
                    $ps[] = $v;
                }
                $strAnd = 'AND ';
            } else {
                $conditions .= ' ' . $strAnd . $this->conditions . ' ';
                $strAnd = 'AND ';
            }
        }

if(isset($_GET['flt']) and isset($_GET['fld'])){
    $v1=explode(",",$_GET['flt']);
    $comp=explode(",",$_GET['fld']);
    $oprerator=($_GET['s_all']==1) ? "OR":"AND";
    $aaa=array();
    $v2=array();
    foreach($comp as $va){
        $x=explode('|',$va);
        $aaa[]=$x[1];//type
        $v2[]=$x[0]; //fieldname
    }



    //$v2=explode(",",$_GET['fld']);

    $conditions .= ' '. $strAnd .' (';
    $s = 0;
    for($a=0;$a<count($v2);$a++){
        if($v1[$a]=='')
            continue;

        if($_GET['com_id']==76 && $v2[$a]=='jobs.job_status')
        {
            switch(strtolower($v1[$a])){
                case 'open':
                    $v1[$a]='1';
                    break;
                case 'close':
                    $v1[$a]='2';
                    break;
                case 'in progress':
                    $v1[$a]='3';
                    break;
                case 'on hold':
                    $v1[$a]='4';
                    break;
                default:
                    break;   
            }
        }
        else if($_GET['com_id']==65 || $_GET['com_id']==32)
        {   
            if($v2[$a]=='crud_users.user_status')
            {
                switch(strtolower($v1[$a])){
                    case 'in-active':
                    case 'in active':
                        // echo $v1[$r_index];
                        // echo $r_index;
                        $v1[$a]='0';
                        break;
                    case 'active':
                        // echo $v1[$r_index];
                        $v1[$a]='1';
                        break;
                    default:
                        break;   
                }
            }
        } 


        /*if (DateTime::createFromFormat('d/m/Y', $v1[$a]) != FALSE) {
            $sd = explode('/',$v1[$a]);
            $v1[$a] = $sd[2].'-'.$sd[1].'-'.$sd[0];
        }

        $conditions .=  $v2[$a].' LIKE \'%' . addslashes($v1[$a]).'%\' OR ';*/

        if($aaa[$a]=='date' or $aaa[$a]=='date_simple'){
            //echo "<br/>".$v1[$a]. "<br/>";
            $parseDate=explode('-',$v1[$a]);
            //echo "<br/>"; print_r($parseDate); echo "its dates: <br/>";
            if(count($parseDate)==2){
                $date_range=array();
                foreach($parseDate as $b){  
                    //echo "<br/>";print_r($b);echo "<br/>";
                    $sd = explode('/',$b);
                    $date_range[] = trim($sd[2]," ").'-'.trim($sd[1]," ").'-'.trim($sd[0]," ");
                    //echo "<br/>";print_r($date_range);echo "<br/>";
                }
                 $conditions .=  $v2[$a].' BETWEEN  \'' . $date_range[0].'\' AND \''.$date_range[1].'\' '.$oprerator . ' ';
            }else if(count($parseDate)==1){
                
                    $sd = explode('/',$v1[$a]);
                    $v1[$a] = trim($sd[2]," ").'-'.trim($sd[1]," ").'-'.trim($sd[0]," ");
                
                 $conditions .=  $v2[$a].' LIKE \'%' . addslashes($v1[$a]).'%\' '.$oprerator.' ';
            }else{
                continue;
            }
                
        }else{
            $conditions .=  $v2[$a].' LIKE \'%' . addslashes($v1[$a]).'%\' '.$oprerator.' ';
        }

        $s++;
    }
    //$conditions = substr($conditions, 0, -3);
     //echo "<br/>". $conditions. "<br/>";
    if($oprerator=='AND'){
        $conditions = substr($conditions, 0, -4);
    }else{
        $conditions = substr($conditions, 0, -3);
    }
    if($s!=0){
        $conditions .= ') ';
        $strAnd = 'AND ';
    }
}
//echo $conditions;exit;
        if (!empty($src)) {
            $CI->session->set_userdata('xtable_search_conditions',$CI->input->post('src'));
        }
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        ///////// for checklist //////////
        if($_GET['com_id']==87)
            $this->globalAccess = true;
        //////////////////////////////////

        if ($this->globalAccess == false && 
            !empty($crudAuth) && 
            isset($crudAuth['id']) && 
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
            $conditions .= ' ' . $strAnd . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
            $strAnd = 'AND ';
        }




        if ($_GET['com_id']!=87 and $this->conf['table']!='sites' and $CI->db->field_exists('site_id', $this->conf['table']))
        {
            $conditions .= ' ' . $strAnd . $this->conf['table'] . '.site_id = '.$crudAuth['site_id'].' ' ;
            $strAnd = 'AND ';
        }

        
        //Custom Functions Calls Before view STart
        $this->conf['comId'] = $this->comId;
        $preCfunctions = new Cfunctions;  
        $preCfunctions->beforeIndexList($this->conf);
        
        /*if(!empty($this->CfunctionsArray)){   
            $Cfunctions = new Cfunctions;
            foreach($this->CfunctionsArray as $function_name){
                $func_name = explode(':',$function_name);
                if($func_name[0]=='list-functions')
                $recieve = $Cfunctions->$func_name[1]();
            }
        }
              
        if(isset($recieve)){
            //print_r($recieve);
            $conditions .= ' ' . $strAnd . $recieve.' ' ;
            $strAnd = 'AND ';
        }*/
        ////////////////////////////////////

        //FILTERS CODE STARTS HERE
        if(isset($_GET['f']) && $_GET['f'] != 0){
            $filter_id = $_GET['f'];
            $filter_details = $CI->db->get_where('filters', array('id'=>$filter_id))->row_array();
            $details = json_decode($filter_details['details']);
            $this->fieldsDisplay = explode(',',$details->fields);
            $this->fieldsDisplay[] = 'action';
            
            $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
            if($filter_details['userid'] == $CRUD_AUTH['id']){
                $this->right_access=1;
            }

            if(!empty($details->cond) && isset($crudAuth['site_id'])){
                $conditions .= ' ' . $strAnd . $details->cond.' AND site_id = '. $crudAuth['site_id'] .' ' ;
                $strAnd = 'AND ';
            } else if(!empty($details->cond)){
                $conditions .= ' ' . $strAnd . $details->cond.' ' ;
                $strAnd = 'AND ';
            }
        }
        //FILTERS CODE ENDS HERE

        $preConditions = new Cfunctions;  
        $preCond = $preConditions->getIndexConditions($this->conf);
        if ($preCond != '') {
            $conditions .= ' ' . $strAnd . $preCond.' ' ;
        }

    

        $params = array();
        $params['fields'] = $this->fields;
        $params['join'] = $this->join;
        $params['found_rows'] = true;
        $params['limit'] = $this->limit;
        $params['page'] = $pageIndex;
        $params['conditions'] = array($conditions, $ps);
        $params['order'] = $order;

        $this->results = $this->dao->find($params);
        $this->dao->p_fields = array();
        $this->totalRecord = $this->dao->foundRows();
        $this->totalPage = ceil($this->totalRecord / $this->limit);
        $fields = array();

        if (!empty($this->fieldsDisplay)) {
            $fields = $this->fieldsDisplay;
        } else {
            $fields = $this->fields;
        }

        if (is_file($this->conf['theme_path'] . '/index.php')) {
            require_once $this->conf['theme_path'] . '/index.php';
        } else {
            die($this->conf['theme_path'] . '/index.php is not found.');
        }
    }
    
    /**
     *
     */
    private function genCalSearch() {
        $CI = & get_instance();
        $CI->load->model('crud_auth');
        $auth = $CI->crud_auth;
        $src = $CI->input->post('src');

        if (!empty($src)){

            /*$_t = new ScrudDao('test_table', $this->da);
            $_tdata['test_info'] = implode(',', $src[$this->conf['table']]);
            $_t->insert($_tdata);*/

            foreach ($src[$this->conf['table']] as $k => $v){
            
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                ($this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'date' or
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'date_simple') && $v != ''){
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                    if (!is_date($v)){
                        $v = '';
                    }
                }
                 
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'datetime' && $v != ''){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                    if (!is_date($v)){
                        $v = '';
                    }
                }
                
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'time' && $v != ''){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                 }
                
                $_POST['src'][$this->conf['table']][$k] = $v;
                
            }
        }


        if (!empty($this->conf['join'])) {
            foreach ($this->conf['join'] as $tbl => $tmp) {
                if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' . $tbl . '.php')) {
                    $content = unserialize(str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' . $tbl . '.php')));
                    if (!empty($content['form_elements'])) {
                        foreach ($content['form_elements'] as $k => $v) {
                            if (strpos($k, '.') !== false) {
                                $this->form[$k] = $v;
                            }
                        }
                    }
                }
            }
        }
        
        
        $xConditions = $CI->session->userdata('xtable_search_conditions');
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
            $src = $CI->input->post('src');
            unset($src['page']);
        }
        if (!isset($src['page'])) {
            if (isset($_GET['src']['p'])) {
                $_POST['src']['page'] = $_GET['src']['p'];
                $src = $CI->input->post('src');
            }
        }
        if (isset($_GET['src']['l'])) {
            $_POST['src']['limit'] = $_GET['src']['l'];
            $src = $CI->input->post('src');
        }
        $pageIndex = (!empty($src['page'])) ? $src['page'] : 1;
        $this->pageIndex = $pageIndex = ((int) $pageIndex > 0) ? (int) $pageIndex : 1;
        $this->limit = (isset($src['limit'])) ? $src['limit'] : $this->limit;
        $conditions = '';
        $order = '';
        $ps = array();
        $strAnd = '';
        if (is_array($this->search)) {
            foreach ($this->fields as $field) {
                $ary = explode('.', $field);
                if (!empty($src) &&
                isset($src[$ary[0]][$ary[1]]) &&
                $src[$ary[0]][$ary[1]] != '$$__src_r_all_value__$$'
                        ) {
                    if (!is_array($src[$ary[0]][$ary[1]]) && trim($src[$ary[0]][$ary[1]]) != '') {
                        if (isset($this->form[$field]['element'][0]) &&
                        ($this->form[$field]['element'][0] == 'autocomplete' ||
                                $this->form[$field]['element'][0] == 'select')){
                            $conditions .= $strAnd . $field . ' = ? ';
                            $ps[] =  $src[$ary[0]][$ary[1]];
                            $strAnd = 'AND ';
                        }else{
                            $conditions .= $strAnd . $field . ' like ? ';
                            $ps[] = '%' . $src[$ary[0]][$ary[1]] . '%';
                            $strAnd = 'AND ';
                        }
                    } else if (is_array($src[$ary[0]][$ary[1]])) {
                        if (count($src[$ary[0]][$ary[1]]) > 0) {
                            $strOr  = '';
                            $tempConditons = "";
                            foreach ($src[$ary[0]][$ary[1]] as $v) {
                                if (!empty($v)){
                                    $tempConditons .= $strOr . $field . ' like ? ';
                                    $ps[] = '%,' . $v . ',%';
                                    $strOr = ' OR ';
                                }
                            }
                            if ($tempConditons != ""){
                                $conditions .= $strAnd .' ( '.$tempConditons.' ) ';
                                $strAnd = ' AND ';
                            }
                        }
                    }
                }
            }
        } else if ($this->search == 'one_field') {
            if (!empty($src) &&
                    isset($src['one_field']) &&
                    trim($src['one_field']) !== '') {
                $conditions .= "(";
                foreach ($this->fields as $field) {
                    if (!in_array($field, $this->fieldsDisplay))
                        continue;
                    if (trim($src['one_field']) !== '') {
                        $conditions .= $strAnd . $field . ' like ? ';
                        $ps[] = '%' . $src['one_field'] . '%';
                        $strAnd = 'OR ';
                    }
                }
                $conditions .= ")";
                $strAnd = 'AND ';
            }
        }

        if (isset($_GET['src']['o'])) {
            $_POST['src']['order_field'] = $_GET['src']['o'];
            $src = $CI->input->post('src');
        }
        if (isset($_GET['src']['t'])) {
            $_POST['src']['order_type'] = $_GET['src']['t'];
            $src = $CI->input->post('src');
        }
        if (!empty($src['order_field']) && !empty($src['order_type'])) {
            $order .= $src['order_field'] . ' ' . $src['order_type'];
            $this->orderField = trim($src['order_field']);
            $this->orderType = trim(strtolower($src['order_type']));
        } else if (!empty($this->conf['order_field']) && !empty($this->conf['order_type'])) {
            $order .= $this->conf['order_field'] . ' ' . $this->conf['order_type'];
            $this->orderField = trim($this->conf['order_field']);
            $this->orderType = trim(strtolower($this->conf['order_type']));
        }
        if (!empty($this->conditions)) {
            if (is_array($this->conditions)) {
                $conditions .= ' ' . $strAnd . $this->conditions[0] . ' ';
                foreach ($this->conditions[1] as $v) {
                    $ps[] = $v;
                }
                $strAnd = 'AND ';
            } else {
                $conditions .= ' ' . $strAnd . $this->conditions . ' ';
                $strAnd = 'AND ';
            }
        }

        if (!empty($src)) {
            $CI->session->set_userdata('xtable_search_conditions',$CI->input->post('src'));
        }
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        if ($this->globalAccess == false && 
            !empty($crudAuth) && 
            isset($crudAuth['id']) && 
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
            $conditions .= ' ' . $strAnd . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
            $strAnd = 'AND ';
        }

        if($this->conf['table']=='business'){
            if(isset($_GET['com_id']) && $_GET['com_id']==41){
                    $legal_entity = 1 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==42){
                    $legal_entity = 2 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==43){
                    $legal_entity = 3 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==44){
                    $legal_entity = 4 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==45){
                    $legal_entity = 5 ;
            }
            $conditions .= ' ' . $strAnd . $this->conf['table'] . '.legal_entity = '.$legal_entity.' ' ;
            $strAnd = 'AND ';
        }

        if ($this->conf['table']!='sites' and $CI->db->field_exists('site_id', $this->conf['table']))
        {
            $conditions .= ' ' . $strAnd . $this->conf['table'] . '.site_id = '.$crudAuth['site_id'].' ' ;
            $strAnd = 'AND ';
        }

        
      /*  //Custom Functions Calls Before view STart
        if(!empty($this->CfunctionsArray)){   
            $Cfunctions = new Cfunctions;
            foreach($this->CfunctionsArray as $function_name){
                $func_name = explode(':',$function_name);
                if($func_name[0]=='list-functions')
                $recieve = $Cfunctions->$func_name[1]();
            }
        }
              
        if(isset($recieve)){
            //print_r($recieve);
            $conditions .= ' ' . $strAnd . $recieve.' ' ;
            $strAnd = 'AND ';
        }
        ////////////////////////////////////*/

        //FILTERS CODE STARTS HERE
        if(isset($_GET['f']) && $_GET['f'] != 0){
            $filter_id = $_GET['f'];
            $filter_details = $CI->db->get_where('filters', array('id'=>$filter_id))->row_array();
            $details = json_decode($filter_details['details']);
            $this->fieldsDisplay = explode(',',$details->fields);
            $this->fieldsDisplay[] = 'action';

            if(!empty($details->cond) && isset($crudAuth['site_id'])){
                $conditions .= ' ' . $strAnd . $details->cond.' AND site_id = '. $crudAuth['site_id'] .' ' ;
                $strAnd = 'AND ';
            } else if(!empty($details->cond)){
                $conditions .= ' ' . $strAnd . $details->cond.' ' ;
                $strAnd = 'AND ';
            }
        }
        //FILTERS CODE ENDS HERE

        $params = array();
        $params['fields'] = $this->fields;
        $params['join'] = $this->join;
        $params['found_rows'] = true;
        $params['limit'] = $this->limit;
        $params['page'] = $pageIndex;
        $params['conditions'] = array($conditions, $ps);
        $params['order'] = $order;
        $this->results = $src;
        //$this->results = $this->dao->find($params);
        $this->dao->p_fields = array();
        $this->totalRecord = $this->dao->foundRows();
        $this->totalPage = ceil($this->totalRecord / $this->limit);
        $fields = array();

        if (!empty($this->fieldsDisplay)) {
            $fields = $this->fieldsDisplay;
        } else {
            $fields = $this->fields;
        }

        if (is_file($this->conf['theme_path'] . '/calsearch.php')) {
            require_once $this->conf['theme_path'] . '/calsearch.php';
        } else {
            die($this->conf['theme_path'] . '/calsearch.php is not found.');
        }
    }


    private function calendar() {
        $CI = & get_instance();
        $CI->load->model('crud_auth');
        $auth = $CI->crud_auth;
        $src = $CI->input->post('src');
        
        if (!empty($src)){

            /*$_t = new ScrudDao('test_table', $this->da);
            $_tdata['test_info'] = implode(',', $src[$this->conf['table']]);
            $_t->insert($_tdata);*/

            foreach ($src[$this->conf['table']] as $k => $v){
            
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                ($this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'date' or
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'date_simple') && $v != ''){
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                    if (!is_date($v)){
                        $v = '';
                    }
                }
                 
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'datetime' && $v != ''){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                    if (!is_date($v)){
                        $v = '';
                    }
                }
                
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'time' && $v != ''){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }
                
                $_POST['src'][$this->conf['table']][$k] = $v;
                
            }
        }


        if (!empty($this->conf['join'])) {
            foreach ($this->conf['join'] as $tbl => $tmp) {
                if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' . $tbl . '.php')) {
                    $content = unserialize(str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' . $tbl . '.php')));
                    if (!empty($content['form_elements'])) {
                        foreach ($content['form_elements'] as $k => $v) {
                            if (strpos($k, '.') !== false) {
                                $this->form[$k] = $v;
                            }
                        }
                    }
                }
            }
        }
        
        
        $xConditions = $CI->session->userdata('xtable_search_conditions');
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
            $src = $CI->input->post('src');
            unset($src['page']);
        }
        if (!isset($src['page'])) {
            if (isset($_GET['src']['p'])) {
                $_POST['src']['page'] = $_GET['src']['p'];
                $src = $CI->input->post('src');
            }
        }
        if (isset($_GET['src']['l'])) {
            $_POST['src']['limit'] = $_GET['src']['l'];
            $src = $CI->input->post('src');
        }
        $pageIndex = (!empty($src['page'])) ? $src['page'] : 1;
        $this->pageIndex = $pageIndex = ((int) $pageIndex > 0) ? (int) $pageIndex : 1;
        $this->limit = (isset($src['limit'])) ? $src['limit'] : $this->limit;
        $conditions = '';
        $order = '';
        $ps = array();
        $strAnd = '';
        if (is_array($this->search)) {
            foreach ($this->fields as $field) {
                $ary = explode('.', $field);
                if (!empty($src) &&
                isset($src[$ary[0]][$ary[1]]) &&
                $src[$ary[0]][$ary[1]] != '$$__src_r_all_value__$$'
                        ) {
                    if (!is_array($src[$ary[0]][$ary[1]]) && trim($src[$ary[0]][$ary[1]]) != '') {
                        if (isset($this->form[$field]['element'][0]) &&
                        ($this->form[$field]['element'][0] == 'autocomplete' ||
                                $this->form[$field]['element'][0] == 'select')){
                            $conditions .= $strAnd . $field . ' = ? ';
                            $ps[] =  $src[$ary[0]][$ary[1]];
                            $strAnd = 'AND ';
                        }else{
                            $conditions .= $strAnd . $field . ' like ? ';
                            $ps[] = '%' . $src[$ary[0]][$ary[1]] . '%';
                            $strAnd = 'AND ';
                        }
                    } else if (is_array($src[$ary[0]][$ary[1]])) {
                        if (count($src[$ary[0]][$ary[1]]) > 0) {
                            $strOr  = '';
                            $tempConditons = "";
                            foreach ($src[$ary[0]][$ary[1]] as $v) {
                                if (!empty($v)){
                                    $tempConditons .= $strOr . $field . ' like ? ';
                                    $ps[] = '%,' . $v . ',%';
                                    $strOr = ' OR ';
                                }
                            }
                            if ($tempConditons != ""){
                                $conditions .= $strAnd .' ( '.$tempConditons.' ) ';
                                $strAnd = ' AND ';
                            }
                        }
                    }
                }
            }
        } else if ($this->search == 'one_field') {
            if (!empty($src) &&
                    isset($src['one_field']) &&
                    trim($src['one_field']) !== '') {
                $conditions .= "(";
                foreach ($this->fields as $field) {
                    if (!in_array($field, $this->fieldsDisplay))
                        continue;
                    if (trim($src['one_field']) !== '') {
                        $conditions .= $strAnd . $field . ' like ? ';
                        $ps[] = '%' . $src['one_field'] . '%';
                        $strAnd = 'OR ';
                    }
                }
                $conditions .= ")";
                $strAnd = 'AND ';
            }
        }

        if (isset($_GET['src']['o'])) {
            $_POST['src']['order_field'] = $_GET['src']['o'];
            $src = $CI->input->post('src');
        }
        if (isset($_GET['src']['t'])) {
            $_POST['src']['order_type'] = $_GET['src']['t'];
            $src = $CI->input->post('src');
        }
        if (!empty($src['order_field']) && !empty($src['order_type'])) {
            $order .= $src['order_field'] . ' ' . $src['order_type'];
            $this->orderField = trim($src['order_field']);
            $this->orderType = trim(strtolower($src['order_type']));
        } else if (!empty($this->conf['order_field']) && !empty($this->conf['order_type'])) {
            $order .= $this->conf['order_field'] . ' ' . $this->conf['order_type'];
            $this->orderField = trim($this->conf['order_field']);
            $this->orderType = trim(strtolower($this->conf['order_type']));
        }
        if (!empty($this->conditions)) {
            if (is_array($this->conditions)) {
                $conditions .= ' ' . $strAnd . $this->conditions[0] . ' ';
                foreach ($this->conditions[1] as $v) {
                    $ps[] = $v;
                }
                $strAnd = 'AND ';
            } else {
                $conditions .= ' ' . $strAnd . $this->conditions . ' ';
                $strAnd = 'AND ';
            }
        }

        if (!empty($src)) {
            $CI->session->set_userdata('xtable_search_conditions',$CI->input->post('src'));
        }
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        if ($this->globalAccess == false && 
            !empty($crudAuth) && 
            isset($crudAuth['id']) && 
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
            $conditions .= ' ' . $strAnd . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
            $strAnd = 'AND ';
        }

        if($this->conf['table']=='business'){
            if(isset($_GET['com_id']) && $_GET['com_id']==41){
                    $legal_entity = 1 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==42){
                    $legal_entity = 2 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==43){
                    $legal_entity = 3 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==44){
                    $legal_entity = 4 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==45){
                    $legal_entity = 5 ;
            }
            $conditions .= ' ' . $strAnd . $this->conf['table'] . '.legal_entity = '.$legal_entity.' ' ;
            $strAnd = 'AND ';
        }

        if ($this->conf['table']!='sites' and $CI->db->field_exists('site_id', $this->conf['table']))
        {
            $conditions .= ' ' . $strAnd . $this->conf['table'] . '.site_id = '.$crudAuth['site_id'].' ' ;
            $strAnd = 'AND ';
        }

        
       /* //Custom Functions Calls Before view STart
        if(!empty($this->CfunctionsArray)){   
            $Cfunctions = new Cfunctions;
            foreach($this->CfunctionsArray as $function_name){
                $func_name = explode(':',$function_name);
                if($func_name[0]=='list-functions')
                $recieve = $Cfunctions->$func_name[1]();
            }
        }
              
        if(isset($recieve)){
            //print_r($recieve);
            $conditions .= ' ' . $strAnd . $recieve.' ' ;
            $strAnd = 'AND ';
        }
        ////////////////////////////////////*/

        //FILTERS CODE STARTS HERE
        if(isset($_GET['f']) && $_GET['f'] != 0){
            $filter_id = $_GET['f'];
            $filter_details = $CI->db->get_where('filters', array('id'=>$filter_id))->row_array();
            $details = json_decode($filter_details['details']);
            $this->fieldsDisplay = explode(',',$details->fields);
            $this->fieldsDisplay[] = 'action';

            if(!empty($details->cond) && isset($crudAuth['site_id'])){
                $conditions .= ' ' . $strAnd . $details->cond.' AND site_id = '. $crudAuth['site_id'] .' ' ;
                $strAnd = 'AND ';
            } else if(!empty($details->cond)){
                $conditions .= ' ' . $strAnd . $details->cond.' ' ;
                $strAnd = 'AND ';
            }
        }
        //FILTERS CODE ENDS HERE
        $this->conf['comId'] = $this->comId;
        $preConditions = new Cfunctions;  
        $preCond = $preConditions->getIndexConditions($this->conf);
        if ($preCond != '') {
            $conditions .= ' ' . $strAnd . $preCond.' ' ;
        }
        $params = array();
        $params['fields'] = $this->fields;
        $params['join'] = $this->join;
        $params['found_rows'] = true;
        //$params['limit'] = $this->limit;
        //$params['page'] = $pageIndex;
        $params['conditions'] = array($conditions, $ps);
        $params['order'] = $order;

        $this->results = $this->dao->find($params);
        $this->dao->p_fields = array();
        $this->totalRecord = $this->dao->foundRows();
        $this->totalPage = ceil($this->totalRecord / $this->limit);
        $fields = array();

        if (!empty($this->fieldsDisplay)) {
            $fields = $this->fieldsDisplay;
        } else {
            $fields = $this->fields;
        }

        if (is_file($this->conf['theme_path'] . '/calendar.php')) {
            require_once $this->conf['theme_path'] . '/calendar.php';
        } else {
            die($this->conf['theme_path'] . '/calendar.php is not found.');
        }
    }

    
    public function modalform(){
    	$CI = & get_instance();
    	$xConditions = $CI->session->userdata('xtable_search_conditions');
    	$src = $CI->input->post('src');
    	if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
    	}
    	if (is_file($this->conf['theme_path'] . '/search_form.php')) {
    		require_once $this->conf['theme_path'] . '/search_form.php';
    		exit;
    	} else {
    		die($this->conf['theme_path'] . '/search_form.php is not found.');
    	}
    }

//UPDATES BY KAMRAN SB START
    public function summary(){
        $CI = & get_instance();
        $this->summaryData = array(
                'module_id'=>$CI->input->get('com_id'),
                'module_key' => $CI->input->get('module_key'),
                'module_value' => $CI->input->get('module_value'),
                'hidden_controll' => $CI->input->get('hidden_controll'),
                'visible_controll' => $CI->input->get('visible_controll'),
            );

        if (!empty($src)){

           

            foreach ($src[$this->conf['table']] as $k => $v){
            
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                ($this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'date' or
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'date_simple') && $v != ''){
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                    if (!is_date($v)){
                        $v = '';
                    }
                }
                 
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'datetime' && $v != ''){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                    if (!is_date($v)){
                        $v = '';
                    }
                }
                
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'time' && $v != ''){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }
                
                $_POST['src'][$this->conf['table']][$k] = $v;
                
            }
        }

        $xConditions = $CI->session->userdata('xtable_search_conditions');
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
            $src = $CI->input->post('src');
            unset($src['page']);
        }
        if (!isset($src['page'])) {
            if (isset($_GET['src']['p'])) {
                $_POST['src']['page'] = $_GET['src']['p'];
                $src = $CI->input->post('src');
            }
        }
        if (isset($_GET['src']['l'])) {
            $_POST['src']['limit'] = $_GET['src']['l'];
            $src = $CI->input->post('src');
        }
        $pageIndex = (!empty($src['page'])) ? $src['page'] : 1;
        $this->pageIndex = $pageIndex = ((int) $pageIndex > 0) ? (int) $pageIndex : 1;
        $this->limit = (isset($src['limit'])) ? $src['limit'] : $this->limit;
        $conditions = '';
        $order = '';
        $ps = array();
        $strAnd = '';
        if (is_array($this->search)) {
            foreach ($this->fields as $field) {
                $ary = explode('.', $field);
                if (!empty($src) &&
                isset($src[$ary[0]][$ary[1]]) &&
                $src[$ary[0]][$ary[1]] != '$$__src_r_all_value__$$'
                        ) {
                    if (!is_array($src[$ary[0]][$ary[1]]) && trim($src[$ary[0]][$ary[1]]) != '') {
                        if (isset($this->form[$field]['element'][0]) &&
                        ($this->form[$field]['element'][0] == 'autocomplete' ||
                                $this->form[$field]['element'][0] == 'select')){
                            $conditions .= $strAnd . $field . ' = ? ';
                            $ps[] =  $src[$ary[0]][$ary[1]];
                            $strAnd = 'AND ';
                        }else{
                            $conditions .= $strAnd . $field . ' like ? ';
                            $ps[] = '%' . $src[$ary[0]][$ary[1]] . '%';
                            $strAnd = 'AND ';
                        }
                    } else if (is_array($src[$ary[0]][$ary[1]])) {
                        if (count($src[$ary[0]][$ary[1]]) > 0) {
                            $strOr  = '';
                            $tempConditons = "";
                            foreach ($src[$ary[0]][$ary[1]] as $v) {
                                if (!empty($v)){
                                    $tempConditons .= $strOr . $field . ' like ? ';
                                    $ps[] = '%,' . $v . ',%';
                                    $strOr = ' OR ';
                                }
                            }
                            if ($tempConditons != ""){
                                $conditions .= $strAnd .' ( '.$tempConditons.' ) ';
                                $strAnd = ' AND ';
                            }
                        }
                    }
                }
            }
        } else if ($this->search == 'one_field') {
            if (!empty($src) &&
                    isset($src['one_field']) &&
                    trim($src['one_field']) !== '') {
                $conditions .= "(";
                foreach ($this->fields as $field) {
                    if (!in_array($field, $this->summaryDispay))
                        continue;
                    if (trim($src['one_field']) !== '') {
                        $conditions .= $strAnd . $field . ' like ? ';
                        $ps[] = '%' . $src['one_field'] . '%';
                        $strAnd = 'OR ';
                    }
                }
                $conditions .= ")";
                $strAnd = 'AND ';
            }
        }

        if (isset($_GET['src']['o'])) {
            $_POST['src']['order_field'] = $_GET['src']['o'];
            $src = $CI->input->post('src');
        }
        if (isset($_GET['src']['t'])) {
            $_POST['src']['order_type'] = $_GET['src']['t'];
            $src = $CI->input->post('src');
        }
        if (!empty($src['order_field']) && !empty($src['order_type'])) {
            $order .= $src['order_field'] . ' ' . $src['order_type'];
            $this->orderField = trim($src['order_field']);
            $this->orderType = trim(strtolower($src['order_type']));
        } else if (!empty($this->conf['order_field']) && !empty($this->conf['order_type'])) {
            $order .= $this->conf['order_field'] . ' ' . $this->conf['order_type'];
            $this->orderField = trim($this->conf['order_field']);
            $this->orderType = trim(strtolower($this->conf['order_type']));
        }
        if (!empty($this->conditions)) {
            if (is_array($this->conditions)) {
                $conditions .= ' ' . $strAnd . $this->conditions[0] . ' ';
                foreach ($this->conditions[1] as $v) {
                    $ps[] = $v;
                }
                $strAnd = 'AND ';
            } else {
                $conditions .= ' ' . $strAnd . $this->conditions . ' ';
                $strAnd = 'AND ';
            }
        }

        if (!empty($src)) {
            $CI->session->set_userdata('xtable_search_conditions',$CI->input->post('src'));
        }
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        if ($this->globalAccess == false && 
            !empty($crudAuth) && 
            isset($crudAuth['id']) && 
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                $conditions .= ' ' . $strAnd .' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
                $strAnd = 'AND ';
        }
            $conditions .= $strAnd . $CI->input->get('condition') ;
            $strAnd = ' AND ';

        $params = array();
        $params['fields'] = $this->fields;
        //$params['join'] = $this->join;
        $params['found_rows'] = true;
        //$params['limit'] = $this->limit;
        $params['page'] = $pageIndex;
    if(trim($conditions)!='null')
        $params['conditions'] = array($conditions, $ps);
    else
        $params['conditions'] = '';
        $params['order'] = $order;
        $this->results = $this->dao->find($params);
        $this->dao->p_fields = array();
        $this->totalRecord = $this->dao->foundRows();
        $this->totalPage = ceil($this->totalRecord / $this->limit);
        $fields = array();

        if (!empty($this->summaryDispay)) {
            $fields = $this->summaryDispay;
        } else {
            $fields = $this->fields;
        }

        if (is_file($this->conf['theme_path'] . '/summary_view.php')) {
            require_once $this->conf['theme_path'] . '/summary_view.php';
            exit;
        } else {
            die($this->conf['theme_path'] . '/summary_view.php is not found.');
        }
    }

    /**
     *Reports
     */
    private function reports() {
        $CI = & get_instance();
        $CI->load->model('crud_auth');
        $auth = $CI->crud_auth;
       

        

        if (isset($_GET['key'])) {
            $hook = Hook::singleton();
            if ($hook->isExisted('SCRUD_VIEW_FORM')) {
                $this->form = $hook->filter('SCRUD_VIEW_FORM', $this->form);
            }
            $params = array();
            $strCon = "";
            $aryVal = array();
            $_tmp = "";
            foreach ($this->primaryKey as $f) {
                $strCon .= $_tmp . " " . $f . ' = ?';
                $_tmp = " AND ";
                $aryVal[] = $_GET['key'][$f];
            }
            $crudAuth = $CI->session->userdata('CRUD_AUTH');
            if ($this->globalAccess == false &&
            !empty($crudAuth) &&
            in_array($this->conf['table'] . '.created_by', $this->fields) ){
                $strCon .= ' ' . $_tmp . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' ' ;
                $_tmp = 'AND ';
            }
            
            $params['fields'] = $this->fields;
            $params['join'] = $this->join;
            $params['conditions'] = array($strCon, $aryVal);
            $rs = $this->dao->findFirst($params);
            
            
        
        }
        
        $condArray = array();

        $condArray = explode('^', $rs[$this->table]['conditions']);
        $condField = explode('|', $condArray[0]);

        
        $f = explode(',', $rs[$this->table]['selected_fileds']);
        $fields = array();
        foreach ($f as $fk => $fv) {
            $field = explode('|', $fv);
            $fields[] = $field[0];
        }
        

        $modules = explode(',', $rs[$this->table]['related_modules']);
        
        $CI->db->select('id,component_table');
        $CI->db->from('crud_components');
        $CI->db->where_in('id',$modules);
        $query = $CI->db->get();
        $rq = $query->result_array();
        $modulesArr = array();
        foreach ($rq as $key => $value) {
            $modulesArr[$value['id']] = $value['component_table'];
        }
        
        $this->table = $modulesArr[$modules[0]];
        
        $this->fields = $fields;
        

        $joins = array();
        $modulesToJoin = $modules;
        unset($modulesToJoin[0]);
        $c = 1;
        foreach ($modulesToJoin as $key => $value) {
            /// GET RELATED FIELDS
            $preKey = $key - 1;
            $CI->db->select('*');
            $CI->db->from('related_module_fields');
            $CI->db->where('related_module', $modulesArr[$modules[$preKey]]    );
            $CI->db->where('module_name', $modulesArr[$modulesToJoin[$key]] );
            $query = $CI->db->get();
            $rmf = $query->result_array();   
            $joinOn = $rmf[0]['related_module'].'.'.$rmf[0]['related_module_field'].' = '.$rmf[0]['module_name'].'.'.$rmf[0]['module_field'];
            /// END GETTIGN RELATED FIELD
            $joins[$modulesArr[$modules[$key]]] = array('INNER',$modulesArr[$modules[$key]],$joinOn);
            $c++;
        }
        $this->join = $joins;
        /*echo $this->table;
        echo '<pre>';
        print_r($this->fields);
        echo '<pre>';
        print_r($this->conf['join']);*/
        //exit();
        
        $fieldsAlias = array();
        $form = array();
        foreach ($modulesArr as $key => $value) {
            if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' .sha1('com_'.$key). '/' . $value . '.php')) {

            } else {

                $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database. '/' .sha1('com_'.$key) . '/' . $value . '.php'));
                $conf = unserialize($content);

                foreach ($conf['form_elements'] as $fk => $fv) {
                    if (in_array($fk, $fields)) {
                        $fieldsAlias[$fk] = $fv['alias'];
                        $form[$fk] = $fv;
                    }
                }
            }
        
            
        }
    $this->fieldsAlias = $fieldsAlias;
       $this->form = $form;
        if (!empty($this->join)) {
            foreach ($this->join as $tbl => $tmp) {
                if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' . $tbl . '.php')) {
                    $content = unserialize(str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' . $tbl . '.php')));
                    if (!empty($content['form_elements'])) {
                        foreach ($content['form_elements'] as $k => $v) {
                            if (strpos($k, '.') !== false) {
                                $this->form[$k] = $v;
                            }
                        }
                    }
                }
            }
        }
        
        $xConditions = $CI->session->userdata('xtable_search_conditions');
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
            $src = $CI->input->post('src');
            unset($src['page']);
        }
        if (!isset($src['page'])) {
            if (isset($_GET['src']['p'])) {
                $_POST['src']['page'] = $_GET['src']['p'];
                $src = $CI->input->post('src');
            }
        }
        if (isset($_GET['src']['l'])) {
            $_POST['src']['limit'] = $_GET['src']['l'];
            $src = $CI->input->post('src');
        }
        $pageIndex = (!empty($src['page'])) ? $src['page'] : 1;
        $this->pageIndex = $pageIndex = ((int) $pageIndex > 0) ? (int) $pageIndex : 1;
        $this->limit = (isset($src['limit'])) ? $src['limit'] : $this->limit;
        $conditions = '';
        $order = '';
        $ps = array();
        $strAnd = '';
        if (is_array($this->search)) {
            foreach ($this->fields as $field) {
                $ary = explode('.', $field);
                if (!empty($src) &&
                isset($src[$ary[0]][$ary[1]]) &&
                $src[$ary[0]][$ary[1]] != '$$__src_r_all_value__$$'
                        ) {
                    if (!is_array($src[$ary[0]][$ary[1]]) && trim($src[$ary[0]][$ary[1]]) != '') {
                        if (isset($this->form[$field]['element'][0]) &&
                        ($this->form[$field]['element'][0] == 'autocomplete' ||
                                $this->form[$field]['element'][0] == 'select')){
                            $conditions .= $strAnd . $field . ' = ? ';
                            $ps[] =  $src[$ary[0]][$ary[1]];
                            $strAnd = 'AND ';
                        }else{
                            $conditions .= $strAnd . $field . ' like ? ';
                            $ps[] = '%' . $src[$ary[0]][$ary[1]] . '%';
                            $strAnd = 'AND ';
                        }
                    } else if (is_array($src[$ary[0]][$ary[1]])) {
                        if (count($src[$ary[0]][$ary[1]]) > 0) {
                            $strOr  = '';
                            $tempConditons = "";
                            foreach ($src[$ary[0]][$ary[1]] as $v) {
                                if (!empty($v)){
                                    $tempConditons .= $strOr . $field . ' like ? ';
                                    $ps[] = '%,' . $v . ',%';
                                    $strOr = ' OR ';
                                }
                            }
                            if ($tempConditons != ""){
                                $conditions .= $strAnd .' ( '.$tempConditons.' ) ';
                                $strAnd = ' AND ';
                            }
                        }
                    }
                }
            }
        } else if ($this->search == 'one_field') {
            if (!empty($src) &&
                    isset($src['one_field']) &&
                    trim($src['one_field']) !== '') {
                $conditions .= "(";
                foreach ($this->fields as $field) {
                    if (!in_array($field, $this->fieldsDisplay))
                        continue;
                    if (trim($src['one_field']) !== '') {
                        $conditions .= $strAnd . $field . ' like ? ';
                        $ps[] = '%' . $src['one_field'] . '%';
                        $strAnd = 'OR ';
                    }
                }
                $conditions .= ")";
                $strAnd = 'AND ';
            }
        }

        if (isset($_GET['src']['o'])) {
            $_POST['src']['order_field'] = $_GET['src']['o'];
            $src = $CI->input->post('src');
        }
        if (isset($_GET['src']['t'])) {
            $_POST['src']['order_type'] = $_GET['src']['t'];
            $src = $CI->input->post('src');
        }
        if (!empty($src['order_field']) && !empty($src['order_type'])) {
            $order .= $src['order_field'] . ' ' . $src['order_type'];
            $this->orderField = trim($src['order_field']);
            $this->orderType = trim(strtolower($src['order_type']));
        } else if (!empty($this->conf['order_field']) && !empty($this->conf['order_type'])) {
            $order .= $this->conf['order_field'] . ' ' . $this->conf['order_type'];
            $this->orderField = trim($this->conf['order_field']);
            $this->orderType = trim(strtolower($this->conf['order_type']));
        }
        if (!empty($this->conditions)) {
            if (is_array($this->conditions)) {
                $conditions .= ' ' . $strAnd . $this->conditions[0] . ' ';
                foreach ($this->conditions[1] as $v) {
                    $ps[] = $v;
                }
                $strAnd = 'AND ';
            } else {
                $conditions .= ' ' . $strAnd . $this->conditions . ' ';
                $strAnd = 'AND ';
            }
        }

        if (!empty($src)) {
            $CI->session->set_userdata('xtable_search_conditions',$CI->input->post('src'));
        }
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        if ($this->globalAccess == false && 
            !empty($crudAuth) && 
            isset($crudAuth['id']) && 
            in_array($this->conf['table'] . '.created_by', $this->fields) ){
            $conditions .= ' ' . $strAnd . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' ' ;
            $strAnd = 'AND ';
        }
        /// REPORT CONDITIONS SECTION
                switch (strtolower($condArray[1])) {
                    case 'e':
                            $conditions .=  ' '.$strAnd . '   '.$condField[0].'  = ? ';
                            $ps[] = $condArray[2];
                            
                        break;
                     case 'n':
                             $conditions .=  ' '.$strAnd . '   '.$condField[0].'  <> ? ';
                            $ps[] = $condArray[2];
                        break;
                     case 's':
                             $conditions .=  ' '.$strAnd . '   '.$condField[0].'  LIKE "'.$condArray[2].'%" ';
                             
                        break;
                     case 'ew':
                            $conditions .= ' '.$strAnd . '   '.$condField[0].' LIKE "%'.$condArray[2].'"  ';
                        break;                                    
                     case 'c':
                            $conditions .= ' '.$strAnd . '   '.$condField[0].' LIKE "%'.$condArray[2].'%"  ';
                        break;
                     case 'k':
                             $conditions .= ' '.$strAnd . '   '.$condField[0].' NOT LIKE ? ';
                            $ps[] = $condArray[2];
                        break;
                     case 'y':
                            $conditions .= ' ('.$condField[0].' IS NULL OR '.$condField[0].' = "") ';
                        break;
                    case 'ny':
                        $conditions .= ' ('.$condField[0].' IS NULL OR '.$condField[0].' <> "") ';
                        
                        break;             
                    default:
                        # code...
                        break;
                }

        /*switch ($this->conf['table']) {
            case 'calendar':
                $strAnd = '';
                if ($conditions != '') {
                    $strAnd = 'AND ';
                }
                        $conditions .=  ' '.$strAnd . '  ( created_by  = ?  OR assigned_to  = ? )';
                        $ps[] = $this->this_user;
                        $ps[] = $this->this_user;

SELECT SQL_CALC_FOUND_ROWS organisations.name,sites.name,dampers.barcode,damper_test.date_tested FROM `organisations`  INNER JOIN sites ON organisations.id = sites.organisation  INNER JOIN dampers ON sites.id = dampers.site  INNER JOIN damper_test ON dampers.barcode = damper_test.dampers     ORDER BY reports.id desc  LIMIT 0,20




                break;
            case 'crud_histories':
                if ($conditions != '') {
                    $strAnd = 'AND ';
                }
                        $conditions .=  ' '.$strAnd . '   history_action  = ? ';
                        $ps[] = 'delete';
                break;        
            default:
                # code...
                break;
        }*/

        
        $this->dao = new ScrudDao($this->table, $this->da);

        $params = array();
        $params['fields'] = $this->fields;
        $params['join'] = $this->join;
        $params['found_rows'] = true;
        $params['limit'] = $this->limit;
        $params['page'] = $pageIndex;
        $params['conditions'] = array($conditions, $ps);
        //$params['order'] = $order;


        /*$_t = new ScrudDao('test', $this->da);
        $_tdata['ttext'] = implode(',', $this->relatedDataInfo['relatedKey']);
        $_t->insert($_tdata);*/

        $this->fieldsDisplay = $this->fields;

        $this->results = $this->dao->find($params);
        $this->dao->p_fields = array();
        $this->totalRecord = $this->dao->foundRows();
        $this->totalPage = ceil($this->totalRecord / $this->limit);
        $fields = array();



        if (!empty($this->fieldsDisplay)) {
            $fields =  $this->fieldsDisplay;

        } else {
            $fields = $this->fields;
        }

        if (is_file($this->conf['theme_path'] . '/reports.php')) {
            require_once $this->conf['theme_path'] . '/reports.php';
        } else {
            die($this->conf['theme_path'] . '/reports.php is not found.');
        }
    }


    ///////nauman code starts here////////////////////////
    public function modalemailsend(){
        $CI = & get_instance();
        // echo '<pre>';
         // echo $_POST['email_id_data'];
        // echo json_encode($_GET);
         // exit;
        // // //$_GET['response']='some';
        //  echo '<pre>';print_r($_FILES);//exit;
        // // $_GET['xtype']='index';
        // print_r($_POST);
        // exit;

        $ids=explode(',',$_POST['email_id_data']);
        $email_id_data=array();
        $emailsForResponse=array();
       if($_GET['com_id']==41||$_GET['com_id']==42||$_GET['com_id']==43||$_GET['com_id']==44||$_GET['com_id']==45){
            
            if(count($ids)==1)
            {   $CI->db->select('title,user_email');
                $CI->db->from($_GET['table']);
                $CI->db->where('id',$_POST['email_id_data']);
                $query= $CI->db->get();
            }else{
                $str= "SELECT title,user_email FROM " . $_GET['table'] ." WHERE id IN ( ";
                //$str= "id IN ( ";
                $c=0;
                foreach($ids as $s_id){
                    $str.=" $s_id ";
                    if((count($ids)-1)!=$c){
                        $str.=" , ";
                    }
                    $c++;
                }
                $str.=" )";
                $query=$CI->db->query($str);
            }

            $result=$query->result_array();
            $emails='';
            $coun=0;
            //echo json_encode($result);exit;
            foreach ($result as $res){
                $email_id_data[]=array('email'=>$res['user_email'],
                                        'name'=>$res['title']);
                
                $emailsForResponse[$res['user_email']]=$res['title'];
                $emails.=$res['user_email'];
                if((count($result)-1)!=$coun)
                {   
                    $emails.=",";
                }
                $coun++;
            }
       }else if($_GET['com_id']==28){


        if(count($ids)==1)
            {   $CI->db->select('First_Name,Last_Name,Primary_Email');
                $CI->db->from($_GET['table']);
                $CI->db->where('id',$_POST['email_id_data']);
                $query= $CI->db->get();
            }else{
                $str= "SELECT First_Name,Last_Name,Primary_Email FROM " . $_GET['table'] ." WHERE id IN ( ";
                //$str= "id IN ( ";
                $c=0;
                foreach($ids as $s_id){
                    $str.=" $s_id ";
                    if((count($ids)-1)!=$c){
                        $str.=" , ";
                    }
                    $c++;
                }
                $str.=" )";
                $query=$CI->db->query($str);
            }

            $result=$query->result_array();
            $emails='';
            $coun=0;
            //echo json_encode($result);exit;
            foreach ($result as $res){
                $email_id_data[]=array('email'=>$res['Primary_Email'],
                                        'name'=>$res['First_Name']. " ". $res['Last_Name']);
                $emailsForResponse[$res['Primary_Email']]=$res['First_Name']. " ". $res['Last_Name'];
                $emails.=$res['Primary_Email'];
                if((count($result)-1)!=$coun)
                {   
                    $emails.=",";
                }
                $coun++;
            }





       }
       //////////////////
       if(isset($_POST['data']['email']['cc'])&&$_POST['data']['email']['cc']!='')
            {
                //$emailAddresses[$num]=
                $cc_Addresses2=explode(',',$_POST['data']['email']['cc']);
                
                
                foreach($cc_Addresses2 as $ccc){
                   $emailsForResponse[$ccc]="cc Email";
                }
            }
       //////////////////
        //echo json_encode($emailsForResponse);exit;
        if($_GET['com_id']==29){

        $CI->db->select('file');
        $CI->db->from('crm_documents');
        $CI->db->where('id',$_POST['file']);
        $query= $CI->db->get();
        $result=$query->row_array();
        
        $file=$result['file'];
        $filepathn=FCPATH . "media\\files\\".$file;
        $filepath=str_replace('\\','/',$filepathn);
        }
        //echo $filepath; exit;

        /*$file=array('name'=>$_FILES['file_data']['name']['email'],
            'temp_name'=>$_FILES['file_data']['tmp_name']['email']['attached_document'],
            'error'=>$_FILES['file_data']['error']['email']['attached_document']
        );*/    
    
        
        /*$email_array=array(
                'to'=>$_POST['data']['email']['to'],
                'cc'=>$_POST['data']['email']['cc'],
                'subject'=>$_POST['data']['email']['subject'],
                'body'=>$_POST['data']['email']['body'],
                'attached_document'=>$file
                );*/


            require_once FCPATH . 'application/third_party/scrud/class/PHPMailer/class.phpmailer.php';
            $mail = new PHPMailer(true);
            //////////////////////////
            $settingKey = sha1('general');

            $var = array();
            $errors = array();
            $var['setting_key'] = $settingKey;

            $CI->db->select('*');
            $CI->db->from('crud_settings');
            $CI->db->where('setting_key',$settingKey);
            $query = $CI->db->get();
            $setting = $query->row_array();
            $setting = unserialize($setting['setting_value']);
                    
            if ((int)$setting['disable_registration'] == 1){
                exit;
            }
            if (isset($setting['require_email_activation']) && (int)$setting['require_email_activation'] == 1){
                        $CI->db->select('*');
                        $CI->db->from('crud_settings');
                        $CI->db->where('setting_key',sha1('new_user'));
                        $query = $CI->db->get();
                        $newUserEmail = $query->row_array();
                        $newUserEmail = unserialize($newUserEmail['setting_value']);
            
                if ((int)$setting['enable_smtp'] == 1){
                    $mail->IsSMTP();
                    if (isset($setting['smtp_auth']) && !empty($setting['smtp_auth'])){
                        $mail->SMTPSecure = $setting['smtp_auth'];
                    }
                    $mail->Host       = $setting['smtp_host']; // SMTP server
                    $mail->Port       = $setting['smtp_port'];  // set the SMTP port for the GMAIL server
                    if ((int)$setting['enable_smtp_auth'] == 1){
                        $mail->SMTPAuth   = true;                  // enable SMTP authentication
                        $mail->Username   = $setting['smtp_account']; // SMTP account username
                        $mail->Password   = $setting['smtp_password'];        // SMTP account password
                    }
                }
                //$emailAddresses
                $emailAddresses1=explode(',',$_POST['data']['email']['to']);
                //echo json_encode($emailAddresses1);exit;
                //$num=count($emailAddresses);
                //$_POST['data']['email']['cc'];
                if(isset($_POST['data']['email']['cc'])&&$_POST['data']['email']['cc']!='')
                {
                    //$emailAddresses[$num]=
                    $cc_Addresses2=explode(',',$_POST['data']['email']['cc']);
                    $emailAddresses=array_merge($emailAddresses1,$cc_Addresses2);
                    //echo json_encode($emailAddresses);exit;
                }else{
                    $emailAddresses=$emailAddresses1;
                }
                //echo json_encode($emailAddresses);exit;
                $errors=array();
                $count_email=0;
                $total_email=count($emailAddresses);
                foreach($emailAddresses as $emailAddress){
                    try{
                        if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL) === false){
                            $errors['errors'][]=array('msg'=>"$emailAddress : Email Address is Invalid.",
                                                        'response'=>"In Valid Email Address.",
                                                        'email'=>$emailAddress,
                                                        'name'=>$emailsForResponse[$emailAddress]);
                            continue;

                            
                        }
                        $mail->AddAddress($emailAddress);
                        $mail->SetFrom($setting['email_address'], $CI->lang->line('company_name'));
                        $mail->Subject = $_POST['data']['email']['subject'];
                        // $mail->AddStringAttachment($emailAttachment, $filename = $pdfFilePath,
                        //   $encoding = 'base64',
                        //   $type = 'application/pdf');
                        if($_GET['com_id']!=29){
                            if (isset($_FILES['file_data']['name']['email']) &&
                                $_FILES['file_data']['error']['email']['attached_document'] == UPLOAD_ERR_OK) {
                                $mail->AddAttachment($_FILES['file_data']['tmp_name']['email']['attached_document'],
                                                     $_FILES['file_data']['name']['email']['attached_document']);
                            }
                        }else{
                            $mail->AddAttachment($filepath,
                                                     $file);
                        }

                        $mail->MsgHTML("*** File attached! Please see the attached File.");
                        //$body='To view the message, please use an HTML compatible email viewer!';
                        if(isset($_POST['data']['email']['body'])&& $_POST['data']['email']['body']!="")
                        $mail->Body = $_POST['data']['email']['body'];
                        //$mail->AltBody = $body;
                        $mail->Send();
                        $count_email++;
                        $mail->ClearAddresses();

                        //$arr['response']='Mail Sent';
                        //$arr['message']='Mail has been sent on ' . $emailAddressForPdf;
                        //echo json_encode($arr);
                        //echo "its working";
                    }catch (phpmailerException $e) {
                        $errors['errors'][]=array('msg'=>"Failed to send email on: " . $emailAddress,
                                                    'response'=>$e->errorMessage(),
                                                    'email'=>$emailAddress,
                                                    'name'=>$emailsForResponse[$emailAddress] 
                                                    );
                        // $errors[]['response']=$e->errorMessage();
                        //exit;
                        //echo $e->errorMessage();
                    } catch (Exception $e) {
                         $errors['errors'][]=array('msg'=>"Failed to send email on: " . $emailAddress,
                                                    'response'=>$e->getMessage(),
                                                    'email'=>$emailAddress,
                                                    'name'=>$emailsForResponse[$emailAddress]
                                                    );
                  
                    }
                    
                }
                        
           

            }
            
            

        $errors['total_email']=$total_email;
        $errors['count_email']=$count_email;
        header('Content-Type: application/json');
        $errors['yes']=1;
        echo json_encode($errors);
        //$this->ajaxReturn['errors']=$errors;
        exit;

        
    }
    //////////nauman code ends here///////////////////////

    ///////nauman code starts here////////////////////////
    public function modalemailpdfform(){
        $CI = & get_instance();
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
        }
        $id_str=$_GET['id'];
        $ids=explode(',',$_GET['id']);
        $email_id_data=array();
       if($_GET['com_id']==41||$_GET['com_id']==42||$_GET['com_id']==43||$_GET['com_id']==44||$_GET['com_id']==45){
            
            if(count($ids)==1)
            {   $CI->db->select('title,user_email');
                $CI->db->from($_GET['table']);
                $CI->db->where('id',$_GET['id']);
                $query= $CI->db->get();
            }else{
                $str= "SELECT title,user_email FROM " . $_GET['table'] ." WHERE id IN ( ";
                //$str= "id IN ( ";
                $c=0;
                foreach($ids as $s_id){
                    $str.=" $s_id ";
                    if((count($ids)-1)!=$c){
                        $str.=" , ";
                    }
                    $c++;
                }
                $str.=" )";
                $query=$CI->db->query($str);
            }

            $result=$query->result_array();
            $emails='';
            $coun=0;
            foreach ($result as $res){
                $email_id_data[]=array('email'=>$res['user_email'],
                                        'name'=>$res['title']);
                $emails.=$res['user_email'];
                if((count($result)-1)!=$coun)
                {   
                    $emails.=",";
                }
                $coun++;
            }
       }else if($_GET['com_id']==28){

        /////////////////
        if(count($ids)==1)
            {   $CI->db->select('First_Name,Last_Name,Primary_Email');
                $CI->db->from($_GET['table']);
                $CI->db->where('id',$_GET['id']);
                $query= $CI->db->get();
            }else{
                $str= "SELECT First_Name,Last_Name,Primary_Email FROM " . $_GET['table'] ." WHERE id IN ( ";
                //$str= "id IN ( ";
                $c=0;
                foreach($ids as $s_id){
                    $str.=" $s_id ";
                    if((count($ids)-1)!=$c){
                        $str.=" , ";
                    }
                    $c++;
                }
                $str.=" )";
                $query=$CI->db->query($str);
            }

            $result=$query->result_array();
            $emails='';
            $coun=0;
            //echo json_encode($result);exit;
            foreach ($result as $res){
                $email_id_data[]=array('email'=>$res['Primary_Email'],
                                        'name'=>$res['First_Name']. " ". $res['Last_Name']);
                
                $emails.=$res['Primary_Email'];
                if((count($result)-1)!=$coun)
                {   
                    $emails.=",";
                }
                $coun++;
            }

        ///////////////////


       }

         if (is_file($this->conf['theme_path'] . '/emailpdf_form.php')) {
            require_once $this->conf['theme_path'] . '/emailpdf_form.php';
            exit;
        } else {
            die($this->conf['theme_path'] . '/emailpdf_form.php is not found.');
        }



    }
    //////////nauman code ends here///////////////////////
    /// Mass Edits
    public function modalmasseditform(){
        $CI = & get_instance();
        $xConditions = $CI->session->userdata('xtable_search_conditions');
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
        }
        if (is_file($this->conf['theme_path'] . '/massedit_form.php')) {
            require_once $this->conf['theme_path'] . '/massedit_form.php';
            exit;
        } else {
            die($this->conf['theme_path'] . '/massedit_form.php is not found.');
        }
    }
    // Mass Edit ends
     /// Mass Edits
    public function modalQuickCreateform(){
        $CI = & get_instance();
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        $this_user_id = $crudAuth['id'];
        $hook = Hook::singleton();
        $this->summaryData = array(
                'module_id' => $CI->input->get('com_id'),
                'module_key' => $CI->input->get('module_key'),
                'module_value' => $CI->input->get('module_value'),
                'hidden_controll' => $CI->input->get('hidden_controll'),
                'visible_controll' => $CI->input->get('visible_controll'),
                'pre_selected' => $CI->input->get('pre_selected'),
                'key' => $CI->input->get('key')
            );
        if (isset($this->summaryData['key'])) {
            $xConditions = $CI->session->userdata('xtable_search_conditions');
            $src = $CI->input->post('src');
            if (empty($src) && !empty($xConditions)) {
                $_POST['src'] = $xConditions;
            }
            if ($hook->isExisted('SCRUD_EDIT_FORM')) {
                $this->form = $hook->filter('SCRUD_EDIT_FORM', $this->form);
            }
            $params = array();
            $strCon = "";
            $aryVal = array();
            $_tmp = "";
            foreach ($this->primaryKey as $f) {
                $strCon .= $_tmp . " " . $f . ' = ?';
                $_tmp = " AND ";
                $aryVal[] = $this->summaryData['key'][$f];
            }
            $crudAuth = $CI->session->userdata('CRUD_AUTH');
            if ($this->globalAccess == false &&
            !empty($crudAuth) &&
            in_array($this->conf['table'] . '.created_by', $this->fields) &&
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
                $_tmp = 'AND ';
            }
            $params['fields'] = $this->fields;
            $params['join'] = $this->join;
            $params['conditions'] = array($strCon, $aryVal);
            $rs = $this->dao->findFirst($params);
            
            if (!empty($rs)){
                $_POST = array_merge($_POST, array('data' => $rs));
            } else {//calendar
                $psrs = array();
                if (!empty($this->summaryData['pre_selected'])) {
                    $ps = explode('|', $this->summaryData['pre_selected']);
                    foreach ($ps as $key => $value) {
                        $v = explode('=', $value);
                        $psrs[$v[0]] = $v[1];
                    }
                }
                if (!empty($psrs)) {
                    if (in_array($this->conf['table'].'.assigned_to', $this->fields)) {
                        $psrs['assigned_to'] = $this_user_id;
                    }
                    $rs[$this->conf['table']] = $psrs;
                    $_POST = array_merge($_POST, array('data' => $rs));
                }
                
            }
        }
        
        if (is_file($this->conf['theme_path'] . '/quickcreate_form.php')) {
            require_once $this->conf['theme_path'] . '/quickcreate_form.php';
            exit;
        } else {
            die($this->conf['theme_path'] . '/quickcreate_form.php is not found.');
        }
    }
    // Mass Edit ends
    /// QUICK CREATE MODULE 
    public function modalQuickCreateModuleform(){
        $CI = & get_instance();
        $hook = Hook::singleton();
        $this->summaryData = array(
                'module_id' => $CI->input->get('com_id'),
                'module_key' => $CI->input->get('module_key'),
                'module_value' => $CI->input->get('module_value'),
                'hidden_controll' => $CI->input->get('hidden_controll'),
                'visible_controll' => $CI->input->get('visible_controll'),
                'pre_selected' => $CI->input->get('pre_selected'),
                'key' => $CI->input->get('key')
            );
        if (isset($this->summaryData['key'])) {
            $xConditions = $CI->session->userdata('xtable_search_conditions');
            $src = $CI->input->post('src');
            if (empty($src) && !empty($xConditions)) {
                $_POST['src'] = $xConditions;
            }
            if ($hook->isExisted('SCRUD_EDIT_FORM')) {
                $this->form = $hook->filter('SCRUD_EDIT_FORM', $this->form);
            }
            $params = array();
            $strCon = "";
            $aryVal = array();
            $_tmp = "";
            foreach ($this->primaryKey as $f) {
                $strCon .= $_tmp . " " . $f . ' = ?';
                $_tmp = " AND ";
                $aryVal[] = $this->summaryData['key'][$f];
            }
            $crudAuth = $CI->session->userdata('CRUD_AUTH');
            if ($this->globalAccess == false &&
            !empty($crudAuth) &&
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
                $_tmp = 'AND ';
            }
            $params['fields'] = $this->fields;
            $params['join'] = $this->join;
            $params['conditions'] = array($strCon, $aryVal);
            $rs = $this->dao->findFirst($params);
            if (!empty($rs)){
                $_POST = array_merge($_POST, array('data' => $rs));
            }
        }
        
        if (is_file($this->conf['theme_path'] . '/quickcreate_form_related.php')) {
            require_once $this->conf['theme_path'] . '/quickcreate_form_related.php';
            exit;
        } else {
            die($this->conf['theme_path'] . '/quickcreate_form_related.php is not found.');
        }
    }

    private function accpet_inv(){
        $CI = & get_instance();
        $key = $CI->input->post('key');
        $crudAuth = $CI->session->userdata('CRUD_AUTH'); 
        $this_user_id = $crudAuth['id'];

        $tbl = '';
        $id = 0;
        foreach ($key as $k => $v) {
            $tbl = $k;
            $id = $v['id'];
        }
        
        $cal = new ScrudDao('cal_invitations', $CI->db);   
        $caltp['conditions'] = array('id='.$id);
        $ctrs = $cal->find($caltp);
   
        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
        $moduleEntityParam['module_id'] = 25;
        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

        $c = new ScrudDao('calendar',$CI->db);
        $cp = $ctrs[0];
        $cp['id'] = $moduleEntityId;
        $cp['eventstatus'] = $ctrs[0]['invite_calendars'];
        $c->insert($cp);
        
        $dc = new ScrudDao('cal_invitations', $CI->db);
        $dcp['conditions'] = array('id='.$id);
        $dc->remove($dcp);
        
        $q = $this->queryString;
        $q['xtype'] = 'index';
        $q['com_id'] = 25;
        if (isset($q['key']))
            unset($q['key']);
        if (isset($q['auth_token']))
            unset($q['auth_token']);
        if (isset($Q['accpet_inv']))
            unset($q['accpet_inv']); 
        header("Location: ?" . http_build_query($q, '', '&'));
       
    }
 
/// QUICK CREATE MODULE
    /**
    * Quick create function
    */
    private function quickCreateForm() {

        $CI = & get_instance();
        $key = $CI->input->post('key');
        $auth_token = $CI->input->post('auth_token');
        $hook = Hook::singleton();
        $moduleId = $this->comId;
        $this->summaryData = array(
                'module_id' => $CI->input->get('com_id'),
                'module_key' => $CI->input->get('module_key'),
                'module_value' => $CI->input->get('module_value'),
                'hidden_controll' => $CI->input->get('hidden_controll'),
                'visible_controll' => $CI->input->get('visible_controll')

        );
        
        
        $sectionCounter = 0;
        foreach ($this->data[$this->conf['table']] as $k => $v){
            
            foreach ($this->conf['form_elements'] as $value){
                
                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && 
                    ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'date' or
                 $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'date_simple')){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                }

                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'datetime'){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'time'){
                    //echo "<pre>";print_r($v);return 0;exit;////
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                /*if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'password'){
                     $v = sha1($v);
                }*/
                if ($v!='' && isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'password'){
                     $v = sha1($v);
                }elseif($v=='' && isset($_GET[key][$this->conf['table'].'.id']) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'password'){
                    $CI->db->select($k);
                    $CI->db->from($this->conf['table']);
                    $CI->db->where('id',$_GET[key][$this->conf['table'].'.id']);
                    $query = $CI->db->get();
                    $busi = $query->row_array();
                    if (!empty($busi))
                        $v = $busi[user_password];
                }

                //FIle Uploaded STart
                if (isset($value['section_fields'][$this->conf['table'].'.'.$k])){
                    $field = $this->conf['table'].'.'.$k;
                   switch ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][0]) {

                  case 'image':
                   $tmpfields = explode('.', $field);

                   $this->fileUpload->uploadDir = __IMAGE_UPLOAD_REAL_PATH__;
                   $this->fileUpload->extensions = $CI->config->item('imageExtensions');
                   $this->fileUpload->tmpFileName =$_FILES['img_data']['tmp_name'][$this->conf['table']][$k];
                   $this->fileUpload->fileName = $_FILES['img_data']['name'][$this->conf['table']][$k];
                     
                   $this->fileUpload->httpError = $_FILES['img_data']['error'][$this->conf['table']][$k];
                   

                   if ($this->fileUpload->upload()) {
                    $v = $_FILES['img_data']['name'][$this->conf['table']][$k] = $this->fileUpload->newFileName;
                    if (isset($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]) && isset($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]['thumbnail'])) {
                     switch ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]['thumbnail']) {
                      case 'mini':
                       $this->image->miniThumbnail($this->fileUpload->newFileName);
                       break;
                      case 'small':
                       $this->image->smallThumbnail($this->fileUpload->newFileName);
                       break;
                      case 'medium':
                       $this->image->mediumThumbnail($this->fileUpload->newFileName);
                       break;
                      case 'large':
                       $this->image->largeThumbnail($this->fileUpload->newFileName);
                       break;
                      default :
                       $this->image->miniThumbnail($this->fileUpload->newFileName);
                       break;
                     }
                    } else {
                     $this->image->miniThumbnail($this->fileUpload->newFileName);
                    }
                    
                    $width = (isset($elements[1]['width']))?$elements[1]['width']:'';
                    $height = (isset($elements[1]['height']))?$elements[1]['height']:'';
                    $fix = 'width';
                    if ($width != '' || $height != ''){
                     $this->image->newWidth = '';
                     $this->image->newHeight = '';
                     $this->image->pre = '';
                     if ($width == ''){
                      $fix = 'height';
                     }
                     $this->image->resize($this->fileUpload->newFileName,$width,$height,$fix);
                    }
                   }
                   $error = $this->fileUpload->getMessage();
                   if (!empty($error)) {
                    $this->errors[$field] = $error;
                    $this->data[$field] = "no error";
                   }
                   break;
                  case 'file':
                   $tmpfields = explode('.', $field);
                   
                   $this->fileUpload->uploadDir = __FILE_UPLOAD_REAL_PATH__;
                   $this->fileUpload->extensions = $CI->config->item('fileExtensions');
                   $this->fileUpload->tmpFileName = $_FILES['file_data']['tmp_name'][$this->conf['table']][$k];
                   $this->fileUpload->fileName = $_FILES['file_data']['name'][$this->conf['table']][$k];
                   
                   $this->fileUpload->httpError = $_FILES['file_data']['error'][$this->conf['table']][$k];


                   
                   if ($this->fileUpload->upload()) {
                    $v = $_FILES['file_data']['name'][$this->conf['table']][$k] = $this->fileUpload->newFileName;
                   }
                   $error = $this->fileUpload->getMessage();
                   if (!empty($error)) {
                    $this->errors[$field] = $error;
                    $this->data[$field] = "no error";
                   }
                   break;
                 }
                }
                //FIle Uploaded STart
                if (is_array($v)){
                    $this->data[$this->conf['table']][$k] = ','.implode(',', $v).',';
                }else{
                    $this->data[$this->conf['table']][$k] = $v;
                }
            }
        }
        
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        
        $historyDao = new ScrudDao('crud_histories', $CI->db);
        $history = array();
        $history['user_id'] = (isset($crudAuth['id']))?$crudAuth['id']:0;
        $history['site_id'] = (isset($crudAuth['site_id']))?$crudAuth['site_id']:0;
        $history['com_id'] = (isset($_GET['com_id']))?$_GET['com_id']:0;
        $history['user_name'] = (isset($crudAuth['user_name']))?$crudAuth['user_name']:'';
        $history['history_table_name'] = $this->conf['table'];
        $history['history_date_time'] = date("Y-m-d H:i:s");
        
    ///////////////////////////////////////////////////////////////////////////
        //my error custom function for business setup with login id n email check//
        ///////////////////////////////////////////////////////////////////////////
        $q = $this->queryString;
        //if(key($q['key'])=='business.id' or key($q['key'])=='crud_users.id' or key($q['key'])=='user_groups.id')
        if(key($q['key']))
            $my_id = $q['key'][key($q['key'])];
        else
            $my_id = 0;
        $par = array('id'=>$my_id);
        $Cfunctions = new Cfunctions;
        if($Cfunctions->validateClient($par)){
            $this->errors['my_error'][]=$Cfunctions->validateClient($par);
        }
        ///////////////////////////////////////////////////////////////////////////

        //if (count($_POST) > 0 && $this->validate() && $auth_token == $CI->session->userdata('auth_token_xtable')) {
        if (count($_POST) > 0 && $this->validate()) {
            
            if ($hook->isExisted('SCRUD_BEFORE_SAVE')) {
                $this->data = $hook->filter('SCRUD_BEFORE_SAVE', $this->data);
            }
            $editFlag = false;
            foreach ($this->primaryKey as $f) {
                $ary = explode('.', $f);
                if (isset($key[$ary[0]][$ary[1]])) {
                    $editFlag = true;

                } else {
                    $editFlag = false;
                    break;
                }
            }
            $this->ajaxReturn['editFlag'] = $editFlag;
            if ($editFlag) {
                /*if(!empty($this->CfunctionsArray)){   
                    $Cfunctions = new Cfunctions;
                    foreach($this->CfunctionsArray as $function_name){
                        $func_name = explode(':',$function_name);
                        if($func_name[0]=='edit-pre-functions')
                        $Cfunctions->$func_name[1]();
                    }
                }*/
                $params = array();
                $strCon = "";
                $aryVal = array();
                $_tmp = "";
                foreach ($this->primaryKey as $f) {
                    $ary = explode('.', $f);
                    $strCon .= $_tmp . $f . ' = ?';
                    $_tmp = " AND ";
                    $aryVal[] = $key[$ary[0]][$ary[1]];
                  }
                if ($this->globalAccess == false &&
                !empty($crudAuth) &&
                in_array($this->conf['table'] . '.created_by', $this->fields) && 
                in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                    $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
                    $_tmp = 'AND ';
                }

                $params = array($strCon, $aryVal);

                ///////////////////////
                $beforeUpdate = new Cfunctions;
                $this->data['comId'] = $this->comId;
                $this->data['module_name'] = $this->conf['title'];
                $this->data['table'] = $this->conf['table']; 
                $this->data['id'] = $params[1][0];
                $this->data['fieldtype'] = $this->conf['form_elements'];
                $this->data['user_id'] = $crudAuth['id'];
                $beforeUpdate->beforeUpdateRecord($this->data);
                ///////////////////////

                try {
                    if ($hook->isExisted('SCRUD_BEFORE_UPDATE')) {
                        $this->data = $hook->filter('SCRUD_BEFORE_UPDATE', $this->data);
                    }
                    if (in_array($this->conf['table'] . '.site_id', $this->fields) and !isset($this->data[$this->conf['table']]['site_id'])){
                        $this->data[$this->conf['table']]['site_id'] = $crudAuth['site_id'];
                    }
                    if (in_array($this->conf['table'] . '.Status', $this->fields) and !isset($this->data[$this->conf['table']]['Status'])){
                        $this->data[$this->conf['table']]['Status'] = 'Active';
                    }

                    if (in_array($this->conf['table'] . '.modified_by', $this->fields)){
                        $this->data[$this->conf['table']]['modified_by'] = $crudAuth['id'];
                    }
                    
                    if (in_array($this->conf['table'] . '.modified', $this->fields)){
                        $this->data[$this->conf['table']]['modified'] = date('Y-m-d H:i:s');
                    }
                    
                    $this->dao->update($this->data[$this->conf['table']], $params);

                    $tmpData = $this->data[$this->conf['table']];
                    foreach ($this->primaryKey as $f) {
                        $ary = explode('.', $f);
                        $tmpData[$ary[1]] = $_POST['key'][$ary[0]][$ary[1]];
                    }
                    
                    $history['history_data'] = json_encode($tmpData);
                    $history['history_action'] = 'update';
                    $historyDao->insert($history);
                    
                    if ($hook->isExisted('SCRUD_COMPLETE_SAVE')) {
                        $hook->execute('SCRUD_COMPLETE_SAVE', $this->data);
                    }
                    if ($hook->isExisted('SCRUD_COMPLETE_UPDATE')) {
                        $hook->execute('SCRUD_COMPLETE_UPDATE', $this->data);
                    }
                    
                    //Date Functions
                    $update_id = $params[1][0];
                    if(isset($_POST['calendar_data']) && $_POST['calendar_data'] && $update_id){
                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array(); 
                        $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                        $explo = explode(',',$entry_data[0]['eventsfor']);
                        foreach($explo as $val){
                            $exploded = explode('-',$val);
                            if(isset($exploded[1])){
                                $CI->db->delete('calendar', array('id' => $exploded[1]));
                            }
                        }
                        if($module_data[0]['component_table'] != 'calendar'){
                            $final_array = '';
                            ////
                            if(!empty($module_data)){
                                $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                               
                                $explo = explode(',',$entry_data[0]['eventsfor']);
                                foreach($explo as $val){
                                    //////////////////
                                    $exploded = explode('|',$val);
                                    $subject = new Cfunctions;
                                    $temp_val = $subject->findSubject($module_data[0], $exploded[0]);
                                    if(isset($temp_val)&& $temp_val!=""){
                                        $CI->db->delete('calendar', array('subject' => $temp_val));
                                        $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                    }
                                //////////////// 
                                }
                            }
                            ////
                            foreach($_POST['calendar_data'][$module_data[0]['component_table']] as $key => $cal_entry_save){

                                //Tariq changes
                                //relaced this line
                                //$data['subject']= ucwords($_POST['data'][$module_data[0]['component_table']]['title']) . " - " . ucwords(str_replace("_"," ",$key));
                                $subject = new Cfunctions;
                                $data['subject']= $subject->findSubject($module_data[0], $key);
                                ///////////////////////////

                                $CI->db->where('subject',$data['subject']);
                                $CI->db->delete('calendar');

                                $v = $_POST['data'][$module_data[0]['component_table']][$key];
                                if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                                    $v = str_replace('/','-',$v);
                                }
                                if(!empty($v)){
                                    $v = str2mysqltime($v,'Y-m-d');
                                }

                                $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                $moduleEntityParam['module_id'] =  $module_data[0]['id'];
                                $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                                $data['id']=$moduleEntityId;

                                $data['related_module']= $module_data[0]['id'];
                                $data['activitytype']= 0;
                                $data['date_start']= $data['due_date']= $v;
                                $data['time_start']= '';
                                $data['time_end']= '';
                                $data['sendnotification']= 'Yes';
                                $data['duration_hours']= '1';
                                $data['duration_minutes']= '1';
                                $data['status']= '1';
                                // eventstatus = calendar type
                                $data['eventstatus']= $_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                $data['priority']= '';
                                $data['location']= '';
                                $data['notime']= '';
                                $data['visibility']= '1';
                                $data['recurringtype']= '';
                                $data['invite_calendars']= ",".$_POST['calander_for_data'][$module_data[0]['component_table']][$key].",";
                                $data['created_by']= $crudAuth['id'];
                                if($this->data[$this->conf['table']]['assigned_to'])
                                    $data['assigned_to']= $this->data[$this->conf['table']]['assigned_to'];
                                else
                                    $data['assigned_to']= $crudAuth['id'];
                                $data['created']= date('Y-m-d H:i:s');
                                $data['site_id']= $crudAuth['site_id'];
                                
                                $calendar = $CI->db->insert('calendar',$data);
                                $event_id = $CI->db->insert_id();
                                //////////////////////
                                $CI->db->select('assigned_to');
                                $CI->db->from('calendar_types');
                                $CI->db->where('id',$_POST['calander_for_data'][$module_data[0]['component_table']][$key]);
                                
                                $varr=$CI->db->get()->result_array()['0']['assigned_to'];
                                if($varr!= $data['assigned_to']){
                                    $data['assigned_to']=$varr;
                                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                    $moduleEntityParam['module_id'] = $moduleId;
                                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                    $data['eventstatus']=$_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                    $data['id']=$moduleEntityId;
                                    //$data['eventstatus']='';

                                    $CI->db->insert('calendar',$data);
                                    //echo "<pre>";print_r($data);exit;
                                
                                }
                                ///////////////////////////////
                                $final_array .= $key."|".$event_id.",";
                            }
                            
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $update_id);
                            $CI->db->update($module_data[0]['component_table'], $updatedata); 
                        }
                    } else {

                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array();

                        if(!empty($module_data)){
                            $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                            $explo = explode(',',$entry_data[0]['eventsfor']);
                            foreach($explo as $val){
                                //////////////////
                                
                                $exploded = explode('|',$val);
                                $subject = new Cfunctions;
                                $temp_val = $subject->findSubject($module_data[0], $exploded[0]);

                                $CI->db->delete('calendar', array('subject' => $temp_val));
                                $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                ////////////////
                            }
                            $final_array = '';
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $update_id);
                            $CI->db->update($module_data[0]['component_table'], $updatedata);
                        }
                    }
                    //Date Functions
                    //Custom Functions Calls AFTER EDIT START
                    $par = array('id'=>$update_id, 'data'=>$_POST);
                    /*if(!empty($this->CfunctionsArray)){   
                        $Cfunctions = new Cfunctions;
                        foreach($this->CfunctionsArray as $function_name){
                            $func_name = explode(':',$function_name);
                            if($func_name[0]=='edit-post-functions')
                            $Cfunctions->$func_name[1]($par);
                        }
                    }
                    //Custom Functions Calls AFTER EDIT END*/

                    $afterUpdate = new Cfunctions;
                    $this->data['comId'] = $this->comId;
                    $this->data['module_name'] = $this->conf['title'];
                    $this->data['table'] = $this->conf['table']; 
                    $this->data['id'] = $update_id;
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $this->data['user_id'] = $crudAuth['id'];
                    $afterUpdate->afterUpdateRecord($this->data);
                    //COMMENTS FUNCTIONS START
                    if(!empty($par)){
                        $Cfunctions = new Cfunctions;
                        $Cfunctions->customsetcomments($par);
                    }
                    //COMMENTS FUNCTIONS END
                    //header("Location: ?" . http_build_query($q, '', '&'));
                } catch (Exception $e) {
                    $this->errors['__NO_FIELD__'][] = $e->getMessage();
                    $this->ajaxReturn['errors'] = $e->getMessage();
                }
            } else {
               /// if to create new record
                $this->data['comId'] = $this->comId;
                $this->data['table'] = $this->conf['table']; 
                $this->data['business_name'] = $CI->session->userdata('bus_name');
                $this->data['user_id'] = $crudAuth['id'];
                $this->data['fieldtype'] = $this->conf['form_elements'];
                $beforeInsert = new Cfunctions;
                $beforeInsert->beforeInsertNewRecord($this->data);

                try {
                    if ($hook->isExisted('SCRUD_BEFORE_INSERT')) {
                        $this->data = $hook->filter('SCRUD_BEFORE_INSERT', $this->data);
                    }
                    if (in_array($this->conf['table'] . '.site_id', $this->fields) and !isset($this->data[$this->conf['table']]['site_id'])){
                        $this->data[$this->conf['table']]['site_id'] = $crudAuth['site_id'];
                    }
                    if (in_array($this->conf['table'] . '.created_by', $this->fields)){
                        $this->data[$this->conf['table']]['created_by'] = $crudAuth['id'];
                    }
                    if (in_array($this->conf['table'] . '.created', $this->fields)){
                        $this->data[$this->conf['table']]['created'] = date('Y-m-d H:i:s');
                    }
                    

                    if ($moduleId ==0) {
                        $moduleEntityId = $this->dao->insert($this->data[$this->conf['table']]);
                        $this->summaryData['selected_id'] = $moduleEntityId;
                    } else {
                        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                        $moduleEntityParam['module_id'] = $moduleId;
                        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                        $this->data[$this->conf['table']]['id'] = $moduleEntityId;
                        $this->dao->insert($this->data[$this->conf['table']]);
                        $this->summaryData['selected_id'] = $moduleEntityId;
                    }
                    

                    // Genereate ID for new reocord
                    $this->data['comId'] = $this->comId;
                    $this->data['table'] = $this->conf['table']; 
                    $this->data['business_name'] = $CI->session->userdata('bus_name');
                    $this->data['user_id'] = $crudAuth['id'];
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $afterInsert = new Cfunctions;
                    $afterInsert->afterInsertNewRecord($this->data);
                    
                    $f = ($this->summaryData['module_value'] == "") ? "" : $this->summaryData['module_value'];
                    $this->ajaxReturn['module_value_filed'] = $f;
                    if ($f != "") {
                        $newData = new ScrudDao($this->conf['table'],$CI->db);
                        $p['fields'] = array($f,'Last_Name');
                        $p['conditions'] = array('id="'.$moduleEntityId.'"');
                        $nrs = $newData->find($p);

                        if($this->summaryData['module_id']==28)
                            $this->summaryData['record_view_value'] = $nrs[0]['First_Name'].' '.$nrs[0]['Last_Name'];
                        else
                            $this->summaryData['record_view_value'] = $nrs[0][$this->summaryData['module_value']];

                    }
                    

                    /// Assign all variables to return data
                    $this->ajaxReturn['return_data'] = $this->summaryData;

                    

                    $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                    $params['fields'] = array('id,module_id','prefix','curr_id');
                    $params['conditions'] = array('module_id="'.$moduleId.'"');
                    $params['order'] =  array('id');
                    $rs = $modNum->find($params);
                    
                    if(!empty($rs)){
                        $rs = $rs[0];

                        $moduleTable = $this->conf['table'];
                        $moduleTableField = $moduleTable . 'no';
                        $newId =  $rs['curr_id'];
                        $newModuleId = $rs['prefix'] . $newId;
                        
                        $this->data[$this->conf['table']][$moduleTableField] = $newModuleId;

                        $updateMod = new ScrudDao($this->conf['table'], $CI->db);
                        $updateMod->update(array($moduleTableField=>$newModuleId), array('id='.$moduleEntityId));
                        $updateCurrentId = $newId+1;
                        $modNum->update(array('curr_id'=>$updateCurrentId),array('id='.$rs['id']));
                    }
                    
                    $history['history_data'] = json_encode($this->data[$this->conf['table']]);
                    $history['history_action'] = 'add';
                    $historyDao->insert($history);

                    if ($hook->isExisted('SCRUD_COMPLETE_SAVE')) {
                        $hook->execute('SCRUD_COMPLETE_SAVE', $this->data);
                    }
                    if ($hook->isExisted('SCRUD_COMPLETE_INSERT')) {
                        $hook->execute('SCRUD_COMPLETE_INSERT', $this->data);
                    }


                    //header("Location: ?" . http_build_query($q, '', '&'));
                    

                } catch (Exception $e) {
                    $this->errors['__NO_FIELD__'][] = $e->getMessage();
                    $this->ajaxReturn['errors'] = $e->getMessage();
                }
                $CI->session->unset_userdata('xtable_search_conditions');
               /// end fo code to create new record 
            }

            
                
            
        } else {
            $errors = array();
            if (!empty($this->errors)) {
                foreach ($this->errors as $key => $value) {
                    $this->ajaxReturn['errors'][] = array($key,$value);
                }
            }
            
            if ($auth_token != $CI->session->userdata('auth_token_xtable')) {
                $this->errors['auth_token'][] = 'Auth token does not exist.';
                $this->ajaxReturn['errors'] = 'Auth token does not exist.';
            }
            
        }
        
        $this->modalMessages();
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function modalMessages(){
        $CI = & get_instance();
        $xConditions = $CI->session->userdata('xtable_search_conditions');
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
        }
        if (is_file($this->conf['theme_path'] . '/messages.php')) {
            require_once $this->conf['theme_path'] . '/messages.php';
            exit;
        } else {
            die($this->conf['theme_path'] . '/messages.php is not found.');
        }
    }
    

/**
    * Quick create function
    */
    private function quickCreateModuleForm() {
        $CI = & get_instance();
        $key = $CI->input->post('key');
        $auth_token = $CI->input->post('auth_token');
        $hook = Hook::singleton();
        $moduleId = $this->comId;
        
        $sectionCounter = 0;
        foreach ($this->data[$this->conf['table']] as $k => $v){
            foreach ($this->conf['form_elements'] as $value){
                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && 
                    ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'date' or
                 $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'date_simple')){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                }

                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'datetime'){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'time'){
                    //echo "<pre>";print_r($v);return 0;exit;////
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                /*if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'password'){
                     $v = sha1($v);
                }*/
                if ($v!='' && isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'password'){
                     $v = sha1($v);
                }elseif($v=='' && isset($_GET[key][$this->conf['table'].'.id']) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'password'){
                    $CI->db->select($k);
                    $CI->db->from($this->conf['table']);
                    $CI->db->where('id',$_GET[key][$this->conf['table'].'.id']);
                    $query = $CI->db->get();
                    $busi = $query->row_array();
                    if (!empty($busi))
                        $v = $busi[user_password];
                }

                //FIle Uploaded STart
                if (isset($value['section_fields'][$this->conf['table'].'.'.$k])){
                    $field = $this->conf['table'].'.'.$k;
                   switch ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][0]) {
                        case 'image':
                            $tmpfields = explode('.', $field);
                            $this->fileUpload->uploadDir = __IMAGE_UPLOAD_REAL_PATH__;
                            $this->fileUpload->extensions = $CI->config->item('imageExtensions');
                            $this->fileUpload->tmpFileName =$_FILES['img_data']['tmp_name'][$this->conf['table']][$k];
                            $this->fileUpload->fileName = $_FILES['img_data']['name'][$this->conf['table']][$k];
                           
                            $this->fileUpload->httpError = $_FILES['img_data']['error'][$this->conf['table']][$k];

                            if ($this->fileUpload->upload()) {
                                $v = $_FILES['img_data']['name'][$this->conf['table']][$k] = $this->fileUpload->newFileName;
                                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]) && isset($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]['thumbnail'])) {
                                    switch ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]['thumbnail']) {
                                        case 'mini':
                                            $this->image->miniThumbnail($this->fileUpload->newFileName);
                                            break;
                                        case 'small':
                                            $this->image->smallThumbnail($this->fileUpload->newFileName);
                                            break;
                                        case 'medium':
                                            $this->image->mediumThumbnail($this->fileUpload->newFileName);
                                            break;
                                        case 'large':
                                            $this->image->largeThumbnail($this->fileUpload->newFileName);
                                            break;
                                        default :
                                            $this->image->miniThumbnail($this->fileUpload->newFileName);
                                            break;
                                    }
                                } else {
                                    $this->image->miniThumbnail($this->fileUpload->newFileName);
                                }
                                
                                $width = (isset($elements[1]['width']))?$elements[1]['width']:'';
                                $height = (isset($elements[1]['height']))?$elements[1]['height']:'';
                                $fix = 'width';
                                if ($width != '' || $height != ''){
                                    $this->image->newWidth = '';
                                    $this->image->newHeight = '';
                                    $this->image->pre = '';
                                    if ($width == ''){
                                        $fix = 'height';
                                    }
                                    $this->image->resize($this->fileUpload->newFileName,$width,$height,$fix);
                                }
                            }
                            $error = $this->fileUpload->getMessage();
                            if (!empty($error)) {
                                $this->errors[$field] = $error;
                                $this->data[$field] = "no error";
                            }
                            break;
                        case 'file':
                            $tmpfields = explode('.', $field);
                            $this->fileUpload->uploadDir = __FILE_UPLOAD_REAL_PATH__;
                            $this->fileUpload->extensions = $CI->config->item('fileExtensions');
                            $this->fileUpload->tmpFileName = $_FILES['file_data']['tmp_name'][$this->conf['table']][$k];
                            $this->fileUpload->fileName = $_FILES['file_data']['name'][$this->conf['table']][$k];
                            
                            $this->fileUpload->httpError = $_FILES['file_data']['error'][$this->conf['table']][$k];
                            if ($this->fileUpload->upload()) {
                                $v = $_FILES['file_data']['name'][$this->conf['table']][$k] = $this->fileUpload->newFileName;
                            }
                            $error = $this->fileUpload->getMessage();
                            if (!empty($error)) {
                                $this->errors[$field] = $error;
                                $this->data[$field] = "no error";
                            }
                            break;
                    }
                }
                //FIle Uploaded STart
                if (is_array($v)){
                    $this->data[$this->conf['table']][$k] = ','.implode(',', $v).',';
                }else{
                    $this->data[$this->conf['table']][$k] = $v;
                }
            }
        }
        
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        
        $historyDao = new ScrudDao('crud_histories', $CI->db);
        $history = array();
        $history['user_id'] = (isset($crudAuth['id']))?$crudAuth['id']:0;
        $history['site_id'] = (isset($crudAuth['site_id']))?$crudAuth['site_id']:1;
        $history['com_id'] = (isset($_GET['com_id']))?$_GET['com_id']:0;
        $history['user_name'] = (isset($crudAuth['user_name']))?$crudAuth['user_name']:'';
        $history['history_table_name'] = $this->conf['table'];
        $history['history_date_time'] = date("Y-m-d H:i:s");

        ///////////////////////////////////////////////////////////////////////////
        //my error custom function for business setup with login id n email check//
        ///////////////////////////////////////////////////////////////////////////
        $q = $this->queryString;
        //if(key($q['key'])=='business.id' or key($q['key'])=='crud_users.id' or key($q['key'])=='user_groups.id')
        if(key($q['key']))
            $my_id = $q['key'][key($q['key'])];
        else
            $my_id = 0;
        $par = array('id'=>$my_id);
        $Cfunctions = new Cfunctions;
        if($Cfunctions->validateClient($par)){
            $this->errors['my_error'][]=$Cfunctions->validateClient($par);
        }
        ///////////////////////////////////////////////////////////////////////////
        
        //if (count($_POST) > 0 && $auth_token == $CI->session->userdata('auth_token_xtable')) {
        if (count($_POST) > 0) {
            if ($hook->isExisted('SCRUD_BEFORE_SAVE')) {
                $this->data = $hook->filter('SCRUD_BEFORE_SAVE', $this->data);
            }
            $editFlag = false;
            foreach ($this->primaryKey as $f) {
                $ary = explode('.', $f);
                if (isset($key[$ary[0]][$ary[1]])) {
                    $editFlag = true;
                } else {
                    $editFlag = false;
                    break;
                }
            }
            $q = $this->queryString;
            $q['xtype'] = 'index';
            if (isset($q['key']))
                unset($q['key']);
            
            if ($editFlag) {
              /*  //Custom Functions Calls Before Edit STart
                if(!empty($this->CfunctionsArray)){   
                    $Cfunctions = new Cfunctions;
                    foreach($this->CfunctionsArray as $function_name){
                        $func_name = explode(':',$function_name);
                        if($func_name[0]=='edit-pre-functions')
                        $Cfunctions->$func_name[1]();
                    }
                }*/
                //Custom Functions Calls Before Edit END
                $params = array();
                $strCon = "";
                $aryVal = array();
                $_tmp = "";
                foreach ($this->primaryKey as $f) {
                    $ary = explode('.', $f);
                    $strCon .= $_tmp . $f . ' = ?';
                    $_tmp = " AND ";
                    $aryVal[] = $key[$ary[0]][$ary[1]];
                }
                if ($this->globalAccess == false &&
                !empty($crudAuth) &&
                in_array($this->conf['table'] . '.created_by', $this->fields) && 
                in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                    $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
                    $_tmp = 'AND ';
                }
                $params = array($strCon, $aryVal);
                $this->data['comId'] = $this->comId;
                $this->data['table'] = $this->conf['table']; 
                $this->data['business_name'] = $CI->session->userdata('bus_name');
                $this->data['user_id'] = $params[1][0];
                $this->data['user_id'] = $crudAuth['id'];
                $this->data['fieldtype'] = $this->conf['form_elements'];
                $beforeUpdate = new Cfunctions;
                $beforeUpdate->beforeUpdateRecord($this->data);
                try {
                    if ($hook->isExisted('SCRUD_BEFORE_UPDATE')) {
                        $this->data = $hook->filter('SCRUD_BEFORE_UPDATE', $this->data);
                    }
                    if (in_array($this->conf['table'] . '.Status', $this->fields) and !isset($this->data[$this->conf['table']]['Status']) and isset( $_GET['status'])){
                        $this->data[$this->conf['table']]['Status'] = $_GET['status'];
                    }
                    if(($moduleId=='59' or $moduleId=='60' or $moduleId=='61' or $moduleId=='48' or $moduleId=='49' or $moduleId=='47' or $moduleId==58 or $moduleId==62 or $moduleId==63 or $moduleId==64 or $moduleId==70 or $moduleId==74 or $moduleId==75 ) and isset( $_GET['status'])){
                        $this->data['business']['Status'] =  $_GET['status'];
                    }

                    if (in_array($this->conf['table'] . '.site_id', $this->fields) and !isset($this->data[$this->conf['table']]['site_id'])){
                        $this->data[$this->conf['table']]['site_id'] = $crudAuth['site_id'];
                    }
                    
                    if (in_array($this->conf['table'] . '.modified_by', $this->fields)){
                        $this->data[$this->conf['table']]['modified_by'] = $crudAuth['id'];
                    }
                    if (in_array($this->conf['table'] . '.modified', $this->fields)){
                        $this->data[$this->conf['table']]['modified'] = date('Y-m-d H:i:s');
                    }
                    
                    $this->dao->update($this->data[$this->conf['table']], $params);
                    //exit;

                    $tmpData = $this->data[$this->conf['table']];
                    foreach ($this->primaryKey as $f) {
                        $ary = explode('.', $f);
                        $tmpData[$ary[1]] = $_POST['key'][$ary[0]][$ary[1]];
                    }
                    
                    $history['history_data'] = json_encode($tmpData);
                    $history['history_action'] = 'update';
                    $historyDao->insert($history);
                    
                    if ($hook->isExisted('SCRUD_COMPLETE_SAVE')) {
                        $hook->execute('SCRUD_COMPLETE_SAVE', $this->data);
                    }
                    if ($hook->isExisted('SCRUD_COMPLETE_UPDATE')) {
                        $hook->execute('SCRUD_COMPLETE_UPDATE', $this->data);
                    }

                    //Date Functions
                    $update_id = $params[1][0];
                    if(isset($_POST['calendar_data']) && $_POST['calendar_data'] && $update_id){
                        //print_r($_POST);exit;
                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array(); 
                        $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                        $explo = explode(',',$entry_data[0]['eventsfor']);
                        foreach($explo as $val){
                            $exploded = explode('-',$val);
                            if(isset($exploded[1])){
                                $CI->db->delete('calendar', array('id' => $exploded[1]));
                            }
                        }
                        if($module_data[0]['component_table'] != 'calendar'){
                            $final_array = '';
                            ////
                            if(!empty($module_data)){
                                $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                               
                                $explo = explode(',',$entry_data[0]['eventsfor']);
                                foreach($explo as $val){
                                    //////////////////
                                    $exploded = explode('|',$val);
                                    $subject = new Cfunctions;
                                    $temp_val = $subject->findSubject($module_data[0], $exploded[0]);
                                    if(isset($temp_val)&& $temp_val!=""){
                                        $CI->db->delete('calendar', array('subject' => $temp_val));
                                        $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                    }
                                //////////////// 
                                }
                            }
                            ////
                            foreach($_POST['calendar_data'][$module_data[0]['component_table']] as $key => $cal_entry_save){
                                if(!isset($_POST['data'][$module_data[0]['component_table']]['title'])){
                                    $data['subject']= ucwords(str_replace("_"," ",$key));
                                } else {
                                                                    //Tariq changes
                                //relaced this line
                                //$data['subject']= ucwords($_POST['data'][$module_data[0]['component_table']]['title']) . " - " . ucwords(str_replace("_"," ",$key));
                                $subject = new Cfunctions;
                                $data['subject']= $subject->findSubject($module_data[0], $key);
                                ///////////////////////////

                                }

                                $CI->db->where('subject',$data['subject']);
                                $CI->db->delete('calendar');
                                
                                $v = $_POST['data'][$module_data[0]['component_table']][$key];
                                if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                                    $v = str_replace('/','-',$v);
                                }
                                if(!empty($v)){
                                    $v = str2mysqltime($v,'Y-m-d');
                                }

                                $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                $moduleEntityParam['module_id'] =  $module_data[0]['id'];
                                $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                                $data['id']=$moduleEntityId;

                                $data['related_module']= $module_data[0]['id'];
                                $data['activitytype']= 0;
                                $data['date_start']= $data['due_date']= $v;
                                $data['time_start']= '';
                                $data['time_end']= '';
                                $data['sendnotification']= 'Yes';
                                $data['duration_hours']= '1';
                                $data['duration_minutes']= '1';
                                $data['status']= '1';
                                // eventstatus = calendar type
                                $data['eventstatus']= $_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                $data['priority']= '';
                                $data['location']= '';
                                $data['notime']= '';
                                $data['visibility']= '1';
                                $data['recurringtype']= '';
                                $data['invite_calendars']= ",".$_POST['calander_for_data'][$module_data[0]['component_table']][$key].",";
                                $data['created_by']= $crudAuth['id'];
                                if($this->data[$this->conf['table']]['assigned_to'])
                                    $data['assigned_to']= $this->data[$this->conf['table']]['assigned_to'];
                                else
                                    $data['assigned_to']= $crudAuth['id'];
                                $data['created']= date('Y-m-d H:i:s');
                                $data['site_id']= $crudAuth['site_id'];
                                
                                $calendar = $CI->db->insert('calendar',$data);
                                $event_id = $CI->db->insert_id();
                                //////////////////////
                                $CI->db->select('assigned_to');
                                $CI->db->from('calendar_types');
                                $CI->db->where('id',$_POST['calander_for_data'][$module_data[0]['component_table']][$key]);
                                
                                $varr=$CI->db->get()->result_array()['0']['assigned_to'];
                                if($varr!= $data['assigned_to']){
                                    $data['assigned_to']=$varr;
                                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                    $moduleEntityParam['module_id'] = $moduleId;
                                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                    $data['eventstatus']=$_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                    $data['id']=$moduleEntityId;
                                    //$data['eventstatus']='';

                                    $CI->db->insert('calendar',$data);
                                    //echo "<pre>";print_r($data);exit;
                                
                                }
                                ///////////////////////////////
                                $final_array .= $key."|".$event_id.",";
                            }
                            
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $update_id);
                            $CI->db->update($module_data[0]['component_table'], $updatedata);
                        }
                    } else {

                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array();

                        if(!empty($module_data)){
                            $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                            $explo = explode(',',$entry_data[0]['eventsfor']);
                            foreach($explo as $val){
                                //////////////////
                                
                                $exploded = explode('|',$val);
                                $subject = new Cfunctions;
                                $temp_val = $subject->findSubject($module_data[0], $exploded[0]);

                                $CI->db->delete('calendar', array('subject' => $temp_val));
                                $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                ////////////////
                            }
                            $final_array = '';
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $update_id);
                            $CI->db->update($module_data[0]['component_table'], $updatedata);
                        }
                    }
                    //Date Functions
                    
                    //Custom Functions Calls AFTER EDIT START
                    $par = array('id'=>$update_id, 'data'=>$_POST);
                    /*if(!empty($this->CfunctionsArray)){   
                        $Cfunctions = new Cfunctions;
                        foreach($this->CfunctionsArray as $function_name){
                            $func_name = explode(':',$function_name);
                            if($func_name[0]=='edit-post-functions')
                            $Cfunctions->$func_name[1]($par);
                        }
                    }*/
                    //Custom Functions Calls AFTER EDIT END
                    $afterUpdate = new Cfunctions;
                    $this->data['comId'] = $this->comId;
                    $this->data['module_name'] = $this->conf['title'];
                    $this->data['table'] = $this->conf['table']; 
                    $this->data['id'] = $update_id;
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $this->data['user_id'] = $crudAuth['id'];
                    $this->data['business_name'] = $CI->session->userdata('bus_name');
                    $afterUpdate->afterUpdateRecord($this->data);
                     //COMMENTS FUNCTIONS START
                    if(!empty($par)){
                        $Cfunctions = new Cfunctions;
                        $Cfunctions->customsetcomments($par);
                    }
                    //COMMENTS FUNCTIONS END  

                        //JSON FOR QUICK CREAT START
                    if($update_id){
                        if($CI->input->get('module_key')) $module_key = $CI->input->get('module_key'); else  $module_key ='';
                        if(isset($this->data[$this->conf['table']][$CI->input->get('module_value')])) $module_value = $this->data[$this->conf['table']][$CI->input->get('module_value')]; else  $module_value ='';
                        
                        echo json_encode(
                            array(
                                'module_id'=>$moduleId,
                                'selected_id'=>$update_id,
                                'module_key' => $module_key,
                                'module_value' => $module_value,
                                'hidden_controll' => $CI->input->get('hidden_controll'),
                                'visible_controll' => $CI->input->get('visible_controll'),
                            )
                        );
                    }else{
                        echo json_encode(
                            array(
                                'module_id'=>$moduleId,
                                'selected_id'=>$update_id,
                                'module_key' => $module_key,
                                'module_value' => $module_value,
                                'hidden_controll' => $CI->input->get('hidden_controll'),
                                'visible_controll' => $CI->input->get('visible_controll'),
                            )
                        );
                    }
                    exit;
                    //JSON FOR QUICK CREAT END
                } catch (Exception $e) {
                    $this->errors['__NO_FIELD__'][] = $e->getMessage();
                    if (is_file($this->conf['theme_path'] . '/form.php')) {
                        require_once $this->conf['theme_path'] . '/form.php';
                    } else {
                        die($this->conf['theme_path'] . '/form.php is not found.');
                    }
                }
            } else {
                try {
                    /////////////////nauman starts here////////////////////////
                    $beforeInsert = new Cfunctions;
                    $this->data['comId'] = $this->comId;
                    $this->data['module_name'] = $this->conf['title'];
                    $this->data['table'] = $this->conf['table']; 
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $this->data['user_id'] = $crudAuth['id'];
                    $this->data['business_name'] = $CI->session->userdata('bus_name');
                    $beforeInsert->beforeInsertNewRecord($this->data);
                    ///////////////nauman ends here/////////////////
                    /*//Custom Functions Calls BEFORE ADD FUNCTION START
                    if(!empty($this->CfunctionsArray)){   
                        $Cfunctions = new Cfunctions;
                        foreach($this->CfunctionsArray as $function_name){
                            $func_name = explode(':',$function_name);
                            if($func_name[0]=='add-pre-functions')
                                $Cfunctions->$func_name[1]();
                        }
                    }
                    //Custom Functions Calls BEFORE ADD FUNCTION END*/
                    if ($hook->isExisted('SCRUD_BEFORE_INSERT')) {
                        $this->data = $hook->filter('SCRUD_BEFORE_INSERT', $this->data);
                    }
                    if (in_array($this->conf['table'] . '.site_id', $this->fields) and !isset($this->data[$this->conf['table']]['site_id'])){
                        $this->data[$this->conf['table']]['site_id'] = $crudAuth['site_id'];
                    }
                    if (in_array($this->conf['table'] . '.created_by', $this->fields)){
                        $this->data[$this->conf['table']]['created_by'] = $crudAuth['id'];
                    }
                    if (in_array($this->conf['table'] . '.created', $this->fields)){
                        $this->data[$this->conf['table']]['created'] = date('Y-m-d H:i:s');
                    }
                    

                    if ($moduleId ==0) {
                        $moduleEntityId = $this->dao->insert($this->data[$this->conf['table']]);
                    } else {
                        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                        $moduleEntityParam['module_id'] = $moduleId;
                        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                        $this->data[$this->conf['table']]['id'] = $moduleEntityId;
                        $this->dao->insert($this->data[$this->conf['table']]);
                    }
                    
                    // Genereate ID for new reocord
                    

                    

                    $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                    $params['fields'] = array('id,module_id','prefix','curr_id');
                    $params['conditions'] = array('module_id="'.$moduleId.'"');
                    $params['order'] =  array('id');
                    $rs = $modNum->find($params);
                    
                    if(!empty($rs)){
                        $rs = $rs[0];

                        $moduleTable = $this->conf['table'];
                        $moduleTableField = $moduleTable . 'no';
                        $newId =  $rs['curr_id'];
                        $newModuleId = $rs['prefix'] . $newId;
                        
                        $this->data[$this->conf['table']][$moduleTableField] = $newModuleId;

                        $updateMod = new ScrudDao($this->conf['table'], $CI->db);
                        $updateMod->update(array($moduleTableField=>$newModuleId), array('id='.$moduleEntityId));
                        $updateCurrentId = $newId+1;
                        $modNum->update(array('curr_id'=>$updateCurrentId),array('id='.$rs['id']));
                    }
                    
                    $history['history_data'] = json_encode($this->data[$this->conf['table']]);
                    $history['history_action'] = 'add';
                    $historyDao->insert($history);

                    if ($hook->isExisted('SCRUD_COMPLETE_SAVE')) {
                        $hook->execute('SCRUD_COMPLETE_SAVE', $this->data);
                    }
                    if ($hook->isExisted('SCRUD_COMPLETE_INSERT')) {
                        $hook->execute('SCRUD_COMPLETE_INSERT', $this->data);
                    }
                    
                    //Date Functions
                    if(isset($_POST['calendar_data'])){
                        //print_r($_POST);exit;
                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array(); 
                        if($module_data[0]['component_table'] != 'calendar'){
                            $final_array = '';
                            ////
                            if(!empty($module_data)){
                                $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                               
                                $explo = explode(',',$entry_data[0]['eventsfor']);
                                foreach($explo as $val){
                                    //////////////////
                                    $exploded = explode('|',$val);
                                    $subject = new Cfunctions;
                                    $temp_val = $subject->findSubject($module_data[0], $exploded[0]);
                                    if(isset($temp_val)&& $temp_val!=""){
                                        $CI->db->delete('calendar', array('subject' => $temp_val));
                                        $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                    }
                                //////////////// 
                                }
                            }
                            ////
                            foreach($_POST['calendar_data'][$module_data[0]['component_table']] as $key => $cal_entry_save){
                                
                                /*Tariq changes
                                *relaced this line

                                if(!isset($_POST['data'][$module_data[0]['component_table']]['title'])){
                                    $data['subject']= ucwords(str_replace("_"," ",$key));
                                } else {
                                    $data['subject']= ucwords($_POST['data'][$module_data[0]['component_table']]['title']) . " - " . ucwords(str_replace("_"," ",$key));
                                }
                                */
                                $subject = new Cfunctions;
                                $data['subject']= $subject->findSubject($module_data[0], $key);
                                ///////////////////////////

                                $CI->db->where('subject',$data['subject']);
                                $CI->db->delete('calendar');

                                $v = $_POST['data'][$module_data[0]['component_table']][$key];
                                if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                                    $v = str_replace('/','-',$v);
                                }
                                if(!empty($v)){
                                    $v = str2mysqltime($v,'Y-m-d');
                                }

                                $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                $moduleEntityParam['module_id'] =  $module_data[0]['id'];
                                $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                                $data['id']=$moduleEntityId;

                                $data['related_module']= $module_data[0]['id'];
                                $data['activitytype']= 0;
                                $data['date_start']= $data['due_date']= $v;
                                $data['time_start']= '';
                                $data['time_end']= '';
                                $data['sendnotification']= 'Yes';
                                $data['duration_hours']= '1';
                                $data['duration_minutes']= '1';
                                $data['status']= '1';
                                // eventstatus = calendar type
                                $data['eventstatus']= $_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                $data['priority']= '';
                                $data['location']= '';
                                $data['notime']= '';
                                $data['visibility']= '1';
                                $data['recurringtype']= '';
                                $data['invite_calendars']= ",".$_POST['calander_for_data'][$module_data[0]['component_table']][$key].",";
                                $data['created_by']= $crudAuth['id'];
                                if($this->data[$this->conf['table']]['assigned_to'])
                                    $data['assigned_to']= $this->data[$this->conf['table']]['assigned_to'];
                                else
                                    $data['assigned_to']= $crudAuth['id'];
                                $data['created']= date('Y-m-d H:i:s');
                                $data['site_id']= $crudAuth['site_id'];
                                
                                $calendar = $CI->db->insert('calendar',$data);
                                $event_id = $CI->db->insert_id();
                                //////////////////////
                                $CI->db->select('assigned_to');
                                $CI->db->from('calendar_types');
                                $CI->db->where('id',$_POST['calander_for_data'][$module_data[0]['component_table']][$key]);
                                
                                $varr=$CI->db->get()->result_array()['0']['assigned_to'];
                                if($varr!= $data['assigned_to']){
                                    $data['assigned_to']=$varr;
                                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                    $moduleEntityParam['module_id'] = $moduleId;
                                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                    $data['eventstatus']=$_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                    $data['id']=$moduleEntityId;
                                    //$data['eventstatus']='';

                                    $CI->db->insert('calendar',$data);
                                    //echo "<pre>";print_r($data);exit;
                                
                                }
                                ///////////////////////////////
                                $final_array .= $key."|".$event_id.",";
                            }
                            
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $moduleEntityId);
                            $CI->db->update($module_data[0]['component_table'], $updatedata); 
                        }
                    }
                    //Date Functions
                    //Custom Functions Calls AFTER ADD FUNCTION START
                    /*$par = array('id'=>$moduleEntityId, 'data'=>$_POST);
                    if(!empty($this->CfunctionsArray)){   
                        $Cfunctions = new Cfunctions;
                        foreach($this->CfunctionsArray as $function_name){
                            $func_name = explode(':',$function_name);
                            if($func_name[0]=='add-post-functions')
                                $Cfunctions->$func_name[1]($par);
                        }
                    }*/
                    //Custom Functions Calls AFTER ADD FUNCTION END

                     //////////////////nauman start here/////////////////////////
                    $afterInsert = new Cfunctions;
                    $this->data['comId'] = $this->comId;
                    $this->data['module_name'] = $this->conf['title'];
                    $this->data['table'] = $this->conf['table']; 
                    $this->data['id'] = $moduleEntityId;
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $this->data['user_id'] = $crudAuth['id'];
                    $this->data['business_name'] = $CI->session->userdata('bus_name');
                    $afterInsert->afterInsertNewRecord($this->data);
                //////////////////nauman ends here//////////////////////////////////
                    //COMMENTS FUNCTIONS START
                    if(!empty($par)){
                        $Cfunctions = new Cfunctions;
                        $Cfunctions->customsetcomments($par);
                    }
                    //COMMENTS FUNCTIONS END

                    //JSON FOR QUICK CREAT START
                    if($moduleEntityId){
                        if($CI->input->get('module_key')) $module_key = $CI->input->get('module_key'); else  $module_key ='';
                        if(isset($this->data[$this->conf['table']][$CI->input->get('module_value')])) $module_value = $this->data[$this->conf['table']][$CI->input->get('module_value')]; else  $module_value ='';
                        
                        echo json_encode(
                            array(
                                'module_id'=>$moduleId,
                                'selected_id'=>$moduleEntityId,
                                'module_key' => $module_key,
                                'module_value' => $module_value,
                                'hidden_controll' => $CI->input->get('hidden_controll'),
                                'visible_controll' => $CI->input->get('visible_controll'),
                            )
                        );
                    }else{
                        echo json_encode(
                            array(
                                'module_id'=>$moduleId,
                                'selected_id'=>'failed',
                                'module_key' => $module_key,
                                'module_value' => $module_value,
                                'hidden_controll' => $CI->input->get('hidden_controll'),
                                'visible_controll' => $CI->input->get('visible_controll'),
                            )
                        );
                    }
                    exit;
                    //JSON FOR QUICK CREAT END
                    //header("Location: ?" . http_build_query($q, '', '&'));
                } catch (Exception $e) {
                    $this->errors['__NO_FIELD__'][] = $e->getMessage();
                    if (is_file($this->conf['theme_path'] . '/form.php')) {
                        require_once $this->conf['theme_path'] . '/form.php';
                    } else {
                        die($this->conf['theme_path'] . '/form.php is not found.');
                    }
                }

                $CI->session->unset_userdata('xtable_search_conditions');
            }
        } else {
            if ($auth_token != $CI->session->userdata('auth_token_xtable')) {
                $this->errors['auth_token'][] = 'Auth token does not exist.';
            }
            if (is_file($this->conf['theme_path'] . '/form.php')) {
                require_once $this->conf['theme_path'] . '/form.php';
            } else {
                die($this->conf['theme_path'] . '/form.php is not found.');
            }
        }
    }
    

/// RELATED MODULE VIEW MODULE 
    public function viewRelatedModuleData(){
        $CI = & get_instance();
        $hook = Hook::singleton();
        $this->summaryData = array(
                'module_id' => $CI->input->get('com_id'),
                'module_key' => $CI->input->get('module_key'),
                'module_value' => $CI->input->get('module_value'),
                'hidden_controll' => $CI->input->get('hidden_controll'),
                'visible_controll' => $CI->input->get('visible_controll'),
                'pre_selected' => $CI->input->get('pre_selected'),
                'key' => $CI->input->get('key')
            );
        if (isset($this->summaryData['key'])) {
            $xConditions = $CI->session->userdata('xtable_search_conditions');
            $src = $CI->input->post('src');
            if (empty($src) && !empty($xConditions)) {
                $_POST['src'] = $xConditions;
            }
            if ($hook->isExisted('SCRUD_EDIT_FORM')) {
                $this->form = $hook->filter('SCRUD_EDIT_FORM', $this->form);
            }
            $params = array();
            $strCon = "";
            $aryVal = array();
            $_tmp = "";
            foreach ($this->primaryKey as $f) {
                $strCon .= $_tmp . " " . $f . ' = ?';
                $_tmp = " AND ";
                $aryVal[] = $this->summaryData['key'][$f];
            }
            $crudAuth = $CI->session->userdata('CRUD_AUTH');
            if ($this->globalAccess == false &&
            !empty($crudAuth) &&
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
                $_tmp = 'AND ';
            }
            $params['fields'] = $this->fields;
            $params['join'] = $this->join;
            $params['conditions'] = array($strCon, $aryVal);
            $rs = $this->dao->findFirst($params);
            if (!empty($rs)){
                $_POST = array_merge($_POST, array('data' => $rs));
            }
        }
        
        if (is_file($this->conf['theme_path'] . '/view_related_module.php')) {
            require_once $this->conf['theme_path'] . '/view_related_module.php';
            exit;
        } else {
            die($this->conf['theme_path'] . '/view_related_module.php is not found.');
        }
    }
    /// RELATED MODULE VIEW MODULE 

    /**
    * Mass edit section start 
    */
    private function massUpdate() {
        $CI = & get_instance();
        $key = $CI->input->post('key');
        $auth_token = $CI->input->post('auth_token');
        $hook = Hook::singleton();
        $moduleId = $this->comId;
        
        $sectionCounter = 0;
        $selids = $CI->input->post('selected_records_hdn');


        

        $ids = explode(',', $selids);
        foreach ($ids as $thisID) {
            $key = $thisID;
            foreach ($this->data[$this->conf['table']] as $k => $v){

                if (isset($this->conf['form_elements'][$sectionCounter]['section_fields'][$this->conf['table'].'.'.$k]) && 
                    ($this->conf['form_elements'][$sectionCounter]['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'date' or
                 $this->conf['form_elements'][$sectionCounter]['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'date_simple')){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                }
                
                if (isset($this->conf['form_elements'][$sectionCounter]['section_fields'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$sectionCounter]['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'datetime'){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                if (isset($this->conf['form_elements'][$sectionCounter]['section_fields'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$sectionCounter]['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'time'){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                if (is_array($v)){
                    $this->data[$this->conf['table']][$k] = ','.implode(',', $v).',';
                }else if($v!=''){
                    $this->data[$this->conf['table']][$k] = $v;
                }else
                    unset($this->data[$this->conf['table']][$k]);
                $sectionCounter++;
            }
            
            $crudAuth = $CI->session->userdata('CRUD_AUTH');
            
            $historyDao = new ScrudDao('crud_histories', $CI->db);
            $history = array();
            $history['user_id'] = (isset($crudAuth['id']))?$crudAuth['id']:0;
            $history['site_id'] = (isset($crudAuth['site_id']))?$crudAuth['site_id']:1;
            $history['com_id'] = (isset($_GET['com_id']))?$_GET['com_id']:0;
            $history['user_name'] = (isset($crudAuth['user_name']))?$crudAuth['user_name']:'';
            $history['history_table_name'] = $this->conf['table'];
            $history['history_date_time'] = date("Y-m-d H:i:s");
            
            //if (count($_POST) > 0 && $auth_token == $CI->session->userdata('auth_token_xtable')) {
            if (count($_POST) > 0) {
                if ($hook->isExisted('SCRUD_BEFORE_SAVE')) {
                    $this->data = $hook->filter('SCRUD_BEFORE_SAVE', $this->data);
                }
                
                $editFlag = true;
                $q = $this->queryString;
                $q['xtype'] = 'index';
                if (isset($q['key']))
                    unset($q['key']);

                if ($editFlag) {

                    $params = array();
                    $strCon = "";
                    $aryVal = array();
                    $_tmp = "";
                    foreach ($this->primaryKey as $f) {
                        $ary = explode('.', $f);
                        $strCon .= $_tmp . $f . ' = ?';
                        $_tmp = " AND ";
                        $aryVal[] = $thisID;
                    }
                    /*if ($this->globalAccess == false &&
                    !empty($crudAuth) &&
                    in_array($this->conf['table'] . '.created_by', $this->fields) ){
                        $strCon .= ' ' . $_tmp . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' ' ;
                        $_tmp = 'AND ';
                    }*/
                    $params = array($strCon, $aryVal);

                    try {
                        if ($hook->isExisted('SCRUD_BEFORE_UPDATE')) {
                            $this->data = $hook->filter('SCRUD_BEFORE_UPDATE', $this->data);
                        }
                        if (in_array($this->conf['table'] . '.modified_by', $this->fields)){
                            $this->data[$this->conf['table']]['modified_by'] = $crudAuth['id'];
                        }
                        
                        if (in_array($this->conf['table'] . '.modified', $this->fields)){
                            $this->data[$this->conf['table']]['modified'] = date('Y-m-d H:i:s');
                        }
                        
                        $this->dao->update($this->data[$this->conf['table']], $params);

                        $tmpData = $this->data[$this->conf['table']];
                        foreach ($this->primaryKey as $f) {
                            $ary = explode('.', $f);
                            $tmpData[$ary[1]] = $thisID;
                        }
                        
                        $history['history_data'] = json_encode($tmpData);
                        $history['history_action'] = 'update';
                        $historyDao->insert($history);
                        
                        if ($hook->isExisted('SCRUD_COMPLETE_SAVE')) {
                            $hook->execute('SCRUD_COMPLETE_SAVE', $this->data);
                        }
                        if ($hook->isExisted('SCRUD_COMPLETE_UPDATE')) {
                            $hook->execute('SCRUD_COMPLETE_UPDATE', $this->data);
                        }
                        
                        header("Location: ?" . http_build_query($q, '', '&'));
                    } catch (Exception $e) {
                        $this->errors['__NO_FIELD__'][] = $e->getMessage();
                        if (is_file($this->conf['theme_path'] . '/form.php')) {
                            require_once $this->conf['theme_path'] . '/form.php';
                        } else {
                            die($this->conf['theme_path'] . '/form.php is not found.');
                        }
                    }
                } 
            } else {
                if ($auth_token != $CI->session->userdata('auth_token_xtable')) {
                    $this->errors['auth_token'][] = 'Auth token does not exist.';
                }
                if (is_file($this->conf['theme_path'] . '/form.php')) {
                    require_once $this->conf['theme_path'] . '/form.php';
                } else {
                    die($this->conf['theme_path'] . '/form.php is not found.');
                }
            }
        } // End of for loop for ids

        
    }
    /*** Mass edit section end */

    /**
    * Mass delete section start 
    */
    private function massdelete() {
        $CI = & get_instance();
        $hook = Hook::singleton();
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        $selids = $CI->input->post('selected_records_hdn');
        
        $ids = explode(',', $selids);
        foreach ($ids as $thisID) {
            $key = $thisID;
        
            $historyDao = new ScrudDao('crud_histories', $CI->db);
            $history = array();
            $history['user_id'] = (isset($crudAuth['id']))?$crudAuth['id']:0;
            $history['site_id'] = (isset($crudAuth['site_id']))?$crudAuth['site_id']:1;
            $history['com_id'] = (isset($_GET['com_id']))?$_GET['com_id']:0;
            $history['user_name'] = (isset($crudAuth['user_name']))?$crudAuth['user_name']:'';
            $history['history_table_name'] = $this->conf['table'];
            $history['history_date_time'] = date("Y-m-d H:i:s");
            
            if ($_POST['auth_token'] == $CI->session->userdata('auth_token_xtable')) {
                $params = array();
                $strCon = "";
                $aryVal = array();
                $_tmp = "";
                foreach ($this->primaryKey as $f) {
                    $strCon .= $_tmp . " " . $f . ' = ?';
                    $_tmp = " AND ";
                    $aryVal[] = $key;
                }
                $crudAuth = $CI->session->userdata('CRUD_AUTH');
                if ($this->globalAccess == false &&
                !empty($crudAuth) &&
                in_array($this->conf['table'] . '.created_by', $this->fields) && 
                in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                    $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
                    $_tmp = 'AND ';
                }
                
                $params = array($strCon, $aryVal);
                
                $tmpData = $this->dao->findFirst(array('conditions'=>$params));
                if (!empty($tmpData)){
                    $this->dao->remove($params);
                    if ($hook->isExisted('SCRUD_COMPLETE_DELETE')) {
                        $hook->execute('SCRUD_COMPLETE_DELETE', $tmpData);
                    }
                    
                    $history['history_data'] = json_encode($tmpData[$this->conf['table']]);
                    $history['history_action'] = 'delete';
                    $historyDao->insert($history);
                }
                
            }
        }
        $q = $this->queryString;
        $q['xtype'] = 'index';
        if (isset($q['key']))
            unset($q['key']);
        if (isset($q['auth_token']))
            unset($q['auth_token']);
        header("Location: ?" . http_build_query($q, '', '&'));
    }
    /*** Mass delete section end */

    //UPDATES BY KAMRAN
    public function summary_view_datalist(){
        $CI = & get_instance();
        $CI->load->model('crud_auth');
        $auth = $CI->crud_auth;
        $this->summaryData = array(
                'module_id' => $CI->input->post('module_id'),
                'module_key' => $CI->input->post('module_key'),
                'module_value' => $CI->input->post('module_value'),
                'hidden_controll' => $CI->input->post('hidden_controll'),
                'visible_controll' => $CI->input->post('visible_controll'),
                'selected_id' => $CI->input->post('selected_id'),
            );
        $conditionsIds = implode(',', array_filter($this->summaryData['selected_id']));
        $this->summaryData['selected_id'] = $conditionsIds;
        if (!empty($src)){
            foreach ($src[$this->conf['table']] as $k => $v){
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                ($this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'date' or
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'date_simple') && $v != ''){
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                    if (!is_date($v)){
                        $v = '';
                    }
                }
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'datetime' && $v != ''){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                    if (!is_date($v)){
                        $v = '';
                    }
                }
                if (isset($this->conf['form_elements'][$this->conf['table'].'.'.$k]) &&
                $this->conf['form_elements'][$this->conf['table'].'.'.$k]['element'][0] == 'time' && $v != ''){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }
                $_POST['src'][$this->conf['table']][$k] = $v; 
            }
        }
        $xConditions = $CI->session->userdata('xtable_search_conditions');
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
            $src = $CI->input->post('src');
            unset($src['page']);
        }
        if (!isset($src['page'])) {
            if (isset($_GET['src']['p'])) {
                $_POST['src']['page'] = $_GET['src']['p'];
                $src = $CI->input->post('src');
            }
        }
        if (isset($_GET['src']['l'])) {
            $_POST['src']['limit'] = $_GET['src']['l'];
            $src = $CI->input->post('src');
        }
        $pageIndex = (!empty($src['page'])) ? $src['page'] : 1;
        $this->pageIndex = $pageIndex = ((int) $pageIndex > 0) ? (int) $pageIndex : 1;
        $this->limit = (isset($src['limit'])) ? $src['limit'] : $this->limit;
        $conditions = '';
        $order = '';
        $ps = array();
        $strAnd = '';
        if (is_array($this->search)) {
            foreach ($this->fields as $field) {
                $ary = explode('.', $field);
                if (!empty($src) &&
                isset($src[$ary[0]][$ary[1]]) &&
                $src[$ary[0]][$ary[1]] != '$$__src_r_all_value__$$'
                        ) {
                    if (!is_array($src[$ary[0]][$ary[1]]) && trim($src[$ary[0]][$ary[1]]) != '') {
                        if (isset($this->form[$field]['element'][0]) &&
                        ($this->form[$field]['element'][0] == 'autocomplete' ||
                                $this->form[$field]['element'][0] == 'select')){
                            $conditions .= $strAnd . $field . ' = ? ';
                            $ps[] =  $src[$ary[0]][$ary[1]];
                            $strAnd = 'AND ';
                        }else{
                            $conditions .= $strAnd . $field . ' like ? ';
                            $ps[] = '%' . $src[$ary[0]][$ary[1]] . '%';
                            $strAnd = 'AND ';
                        }
                    } else if (is_array($src[$ary[0]][$ary[1]])) {
                        if (count($src[$ary[0]][$ary[1]]) > 0) {
                            $strOr  = '';
                            $tempConditons = "";
                            foreach ($src[$ary[0]][$ary[1]] as $v) {
                                if (!empty($v)){
                                    $tempConditons .= $strOr . $field . ' like ? ';
                                    $ps[] = '%,' . $v . ',%';
                                    $strOr = ' OR ';
                                }
                            }
                            if ($tempConditons != ""){
                                $conditions .= $strAnd .' ( '.$tempConditons.' ) ';
                                $strAnd = ' AND ';
                            }
                        }
                    }
                }
            }
        } else if ($this->search == 'one_field') {
            if (!empty($src) &&
                    isset($src['one_field']) &&
                    trim($src['one_field']) !== '') {
                $conditions .= "(";
                foreach ($this->fields as $field) {
                    if (!in_array($field, $this->summaryDispay))
                        continue;
                    if (trim($src['one_field']) !== '') {
                        $conditions .= $strAnd . $field . ' like ? ';
                        $ps[] = '%' . $src['one_field'] . '%';
                        $strAnd = 'OR ';
                    }
                }
                $conditions .= ")";
                $strAnd = 'AND ';
            }
        }
        if (isset($_GET['src']['o'])) {
            $_POST['src']['order_field'] = $_GET['src']['o'];
            $src = $CI->input->post('src');
        }
        if (isset($_GET['src']['t'])) {
            $_POST['src']['order_type'] = $_GET['src']['t'];
            $src = $CI->input->post('src');
        }
        if (!empty($src['order_field']) && !empty($src['order_type'])) {
            $order .= $src['order_field'] . ' ' . $src['order_type'];
            $this->orderField = trim($src['order_field']);
            $this->orderType = trim(strtolower($src['order_type']));
        } else if (!empty($this->conf['order_field']) && !empty($this->conf['order_type'])) {
            $order .= $this->conf['order_field'] . ' ' . $this->conf['order_type'];
            $this->orderField = trim($this->conf['order_field']);
            $this->orderType = trim(strtolower($this->conf['order_type']));
        }
        if (!empty($this->conditions)) {
            if (is_array($this->conditions)) {
                $conditions .= ' ' . $strAnd . $this->conditions[0] . ' ';
                foreach ($this->conditions[1] as $v) {
                    $ps[] = $v;
                }
                $strAnd = 'AND ';
            } else {
                $conditions .= ' ' . $strAnd . $this->conditions . ' ';
                $strAnd = 'AND ';
            }
        }
        if (!empty($src)) {
            $CI->session->set_userdata('xtable_search_conditions',$CI->input->post('src'));
        }
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        if ($this->globalAccess == false && 
            !empty($crudAuth) && 
            isset($crudAuth['id']) && 
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                $conditions .= ' ' . $strAnd . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
            $strAnd = 'AND ';
        }
        if (!empty($conditionsIds)) {
            $conditions .= ' ' . $strAnd . $this->conf['table'] .'.'. $this->summaryData['module_key'] . ' IN(' . $conditionsIds. ') ';
        }
        $params = array();
        $params['fields'] = $this->fields;
        //$params['join'] = $this->join;
        $params['found_rows'] = true;
        //$params['limit'] = $this->limit;
        $params['page'] = $pageIndex;
        $params['conditions'] = array($conditions, $ps);
        $params['order'] = $order;
        $this->results = $this->dao->find($params);
        $this->dao->p_fields = array();
        $this->totalRecord = $this->dao->foundRows();
        $this->totalPage = ceil($this->totalRecord / $this->limit);
        $fields = array();
        if (!empty($this->summaryDispay)) {
            $fields = $this->summaryDispay;
        } else {
            $fields = $this->fields;
        }
        if (is_file($this->conf['theme_path'] . '/summary_view_datalist.php')) {
            require_once $this->conf['theme_path'] . '/summary_view_datalist.php';
            exit;
        } else {
            die($this->conf['theme_path'] . '/summary_view_datalist.php is not found.');
        }
    }

/////////////////////
    /**
     * 
     */
    private function exportCsv() {
        $CI = & get_instance();
        $xConditions = $CI->session->userdata('xtable_search_conditions');
        $src = $CI->input->post('src');
        if (empty($src) && !empty($xConditions)) {
            $_POST['src'] = $xConditions;
            $src = $CI->input->post('src');
            unset($_POST['src']['page']);
        }
        $conditions = '';
        $order = '';
        $ps = array();
        $strAnd = '';
        if (is_array($this->search)) {
            foreach ($this->fields as $field) {
                $ary = explode('.', $field);
                if (!empty($src) &&
                        isset($src[$ary[0]][$ary[1]]) &&
                        !is_array($src[$ary[0]][$ary[1]]) && trim($src[$ary[0]][$ary[1]]) != '') {
                    $conditions .= $strAnd . $field . ' like ? ';
                    $ps[] = '%' . $src[$ary[0]][$ary[1]] . '%';
                    $strAnd = 'AND ';
                }
            }
        } else if ($this->search == 'one_field') {
            if (trim($src['one_field']) !== '') {
                $conditions .= "(";
                foreach ($this->fields as $field) {
                    if (!in_array($field, $this->fieldsDisplay))
                        continue;
                    if (trim($src['one_field']) !== '') {
                        $conditions .= $strAnd . $field . ' like ? ';
                        $ps[] = '%' . $src['one_field'] . '%';
                        $strAnd = 'OR ';
                    }
                }
                $conditions .= ")";
                $strAnd = 'AND ';
            }
        }

        if (isset($_GET['src']['o'])) {
            $_POST['src']['order_field'] = $_GET['src']['o'];
            $src = $CI->input->post('src');
        }
        if (isset($_GET['src']['t'])) {
            $_POST['src']['order_type'] = $_GET['src']['t'];
            $src = $CI->input->post('src');
        }
        if (!empty($src['order_field']) && !empty($src['order_type'])) {
            $order .= $src['order_field'] . ' ' . $src['order_type'];
            $this->orderField = trim($src['order_field']);
            $this->orderType = trim(strtolower($src['order_type']));
        } else if (!empty($this->conf['order_field']) && !empty($this->conf['order_type'])) {
            $order .= $this->conf['order_field'] . ' ' . $this->conf['order_type'];
            $this->orderField = trim($this->conf['order_field']);
            $this->orderType = trim(strtolower($this->conf['order_type']));
        }
        if (!empty($this->conditions)) {
            if (is_array($this->conditions)) {
                $conditions .= ' ' . $strAnd . $this->conditions[0] . ' ';
                foreach ($this->conditions[1] as $v) {
                    $ps[] = $v;
                }
                $strAnd = 'AND ';
            } else {
                $conditions .= ' ' . $strAnd . $this->conditions . ' ';
                $strAnd = 'AND ';
            }
        }

        if (!empty($src)) {
            $CI->session->set_userdata('xtable_search_conditions', $CI->input->post('src'));
        }
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        if ($this->globalAccess == false && 
            !empty($crudAuth) && 
            isset($crudAuth['id']) && 
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
            $conditions .= ' ' . $strAnd . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
            $strAnd = 'AND ';
        }

        if($this->conf['table']=='business'){
            if(isset($_GET['com_id']) && $_GET['com_id']==41){
                    $legal_entity = 1 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==42){
                    $legal_entity = 2 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==43){
                    $legal_entity = 3 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==44){
                    $legal_entity = 4 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==45){
                    $legal_entity = 5 ;
            }
            $conditions .= ' ' . $strAnd . $this->conf['table'] . '.legal_entity = '.$legal_entity.' ' ;
            $strAnd = 'AND ';
        }

        if ($this->conf['table']!='sites' and $CI->db->field_exists('site_id', $this->conf['table']))
        {
            $conditions .= ' ' . $strAnd . $this->conf['table'] . '.site_id = '.$crudAuth['site_id'].' ' ;
            $strAnd = 'AND ';
        }

        

        /*//Custom Functions Calls Before view STart
        if(!empty($this->CfunctionsArray)){   
            $Cfunctions = new Cfunctions;
            foreach($this->CfunctionsArray as $function_name){
                $func_name = explode(':',$function_name);
                if($func_name[0]=='list-functions')
                $recieve = $Cfunctions->$func_name[1]();
            }
        }
              
        if(isset($recieve)){
            //print_r($recieve);
            $conditions .= ' ' . $strAnd . $recieve.' ' ;
            $strAnd = 'AND ';
        }
        ////////////////////////////////////*/

////// filtered data export
if(isset($_GET['flt']) and isset($_GET['fld'])){
    $v1=explode(",",$_GET['flt']);
    $comp=explode(",",$_GET['fld']);
    $oprerator=($_GET['s_all']==1) ? "OR":"AND";
    $aaa=array();
    $v2=array();
    foreach($comp as $va){
        $x=explode('|',$va);
        $aaa[]=$x[1];//type
        $v2[]=$x[0]; //fieldname
    }



    //$v2=explode(",",$_GET['fld']);

    $conditions .= ' '. $strAnd .' (';
    $s = 0;
    for($a=0;$a<count($v2);$a++){
        if($v1[$a]=='')
            continue;

        if($_GET['com_id']==76 && $v2[$a]=='jobs.job_status')
        {
            switch(strtolower($v1[$a])){
                case 'open':
                    $v1[$a]='1';
                    break;
                case 'close':
                    $v1[$a]='2';
                    break;
                case 'in progress':
                    $v1[$a]='3';
                    break;
                case 'on hold':
                    $v1[$a]='4';
                    break;
                default:
                    break;   
            }
        }
        else if($_GET['com_id']==65 || $_GET['com_id']==32)
        {   
            if($v2[$a]=='crud_users.user_status')
            {
                switch(strtolower($v1[$a])){
                    case 'in-active':
                    case 'in active':
                        // echo $v1[$r_index];
                        // echo $r_index;
                        $v1[$a]='0';
                        break;
                    case 'active':
                        // echo $v1[$r_index];
                        $v1[$a]='1';
                        break;
                    default:
                        break;   
                }
            }
        } 


        /*if (DateTime::createFromFormat('d/m/Y', $v1[$a]) != FALSE) {
            $sd = explode('/',$v1[$a]);
            $v1[$a] = $sd[2].'-'.$sd[1].'-'.$sd[0];
        }

        $conditions .=  $v2[$a].' LIKE \'%' . addslashes($v1[$a]).'%\' OR ';*/

        if($aaa[$a]=='date' or $aaa[$a]=='date_simple'){
            //echo "<br/>".$v1[$a]. "<br/>";
            $parseDate=explode('-',$v1[$a]);
            //echo "<br/>"; print_r($parseDate); echo "its dates: <br/>";
            if(count($parseDate)==2){
                $date_range=array();
                foreach($parseDate as $b){  
                    //echo "<br/>";print_r($b);echo "<br/>";
                    $sd = explode('/',$b);
                    $date_range[] = trim($sd[2]," ").'-'.trim($sd[1]," ").'-'.trim($sd[0]," ");
                    //echo "<br/>";print_r($date_range);echo "<br/>";
                }
                 $conditions .=  $v2[$a].' BETWEEN  \'' . $date_range[0].'\' AND \''.$date_range[1].'\' '.$oprerator . ' ';
            }else if(count($parseDate)==1){
                
                    $sd = explode('/',$v1[$a]);
                    $v1[$a] = trim($sd[2]," ").'-'.trim($sd[1]," ").'-'.trim($sd[0]," ");
                
                 $conditions .=  $v2[$a].' LIKE \'%' . addslashes($v1[$a]).'%\' '.$oprerator.' ';
            }else{
                continue;
            }
                
        }else{
            $conditions .=  $v2[$a].' LIKE \'%' . addslashes($v1[$a]).'%\' '.$oprerator.' ';
        }

        $s++;
    }
    //$conditions = substr($conditions, 0, -3);
     //echo "<br/>". $conditions. "<br/>";
    if($oprerator=='AND'){
        $conditions = substr($conditions, 0, -4);
    }else{
        $conditions = substr($conditions, 0, -3);
    }
    if($s!=0){
        $conditions .= ') ';
        $strAnd = 'AND ';
    }
}
//echo $conditions;exit;
///////////////////////////

////// Selected records ////

        $selids = $CI->input->get('sel_rec');
        
        $ids = explode(',', $selids);
        if(isset($selids) and $selids!=''){
            $conditions .= ' '. $strAnd .' (';
            foreach ($ids as $thisID) {
                $conditions .= "id=".$thisID." OR ";
            }
            $conditions = substr($conditions, 0, -3);
            $conditions .= ') ';
            $strAnd = 'AND ';
        }

 
////////////////////////////
        $crudAuth = $CI->session->userdata('CRUD_AUTH');
	    if ($this->globalAccess == false &&
            !empty($crudAuth) &&
            in_array($this->conf['table'] . '.created_by', $this->fields)  && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
            $conditions .= ' ' . $strAnd . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
        	$strAnd = 'AND ';
        }

        $params = array();
        $params['fields'] = $this->fields;
        $params['join'] = $this->join;
        $params['conditions'] = array($conditions, $ps);
        $params['order'] = $order;

        $this->results = $this->dao->find($params);
        $fields = array();
        if (!empty($this->fieldsDisplay)) {
            $fields = $this->fieldsDisplay;
        } else {
            $fields = $this->fields;
        }

        if (is_file($this->conf['theme_path'] . '/csv.php')) {
            require_once $this->conf['theme_path'] . '/csv.php';
        } else {
            die($this->conf['theme_path'] . '/csv.php is not found.');
        }
    }

    
    public function exportcsvall(){
    	$CI = & get_instance();

	    $conditions = '';
        $strAnd = '';
	    $crudAuth = $CI->session->userdata('CRUD_AUTH');
    	if ($this->globalAccess == false &&
    	!empty($crudAuth) &&
    	in_array($this->conf['table'] . '.created_by', $this->fields)  && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
            $conditions .= ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
    	}

        if($this->conf['table']=='business'){
            if(isset($_GET['com_id']) && $_GET['com_id']==41){
                    $legal_entity = 1 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==42){
                    $legal_entity = 2 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==43){
                    $legal_entity = 3 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==44){
                    $legal_entity = 4 ;
            }elseif(isset($_GET['com_id']) && $_GET['com_id']==45){
                    $legal_entity = 5 ;
            }
            $conditions .= ' ' . $strAnd . $this->conf['table'] . '.legal_entity = '.$legal_entity.' ' ;
            $strAnd = 'AND ';
        }

        if ($this->conf['table']!='sites' and $CI->db->field_exists('site_id', $this->conf['table']))
        {
            $conditions .= ' ' . $strAnd . $this->conf['table'] . '.site_id = '.$crudAuth['site_id'].' ' ;
            $strAnd = 'AND ';
        }

        

     /*   //Custom Functions Calls Before view STart
        if(!empty($this->CfunctionsArray)){   
            $Cfunctions = new Cfunctions;
            foreach($this->CfunctionsArray as $function_name){
                $func_name = explode(':',$function_name);
                if($func_name[0]=='list-functions')
                $recieve = $Cfunctions->$func_name[1]();
            }
        }
              
        if(isset($recieve)){
            //print_r($recieve);
            $conditions .= ' ' . $strAnd . $recieve.' ' ;
            $strAnd = 'AND ';
        }
        ////////////////////////////////////
*/
    	
    	$params = array();
    	$params['fields'] = $this->fields;
    	$params['join'] = $this->join;
    	$params['conditions'] = array($conditions,array());
    	
    	$this->results = $this->dao->find($params);
    	$fields = array();
    	$fields = $this->fields;
    	 
    	if (is_file($this->conf['theme_path'] . '/csv.php')) {
    		require_once $this->conf['theme_path'] . '/csv.php';
    	} else {
    		die($this->conf['theme_path'] . '/csv.php is not found.');
    	}
    }
    
    /**
     *
     */
    private function form() {
    	$CI = & get_instance();
        $hook = Hook::singleton();
        if (isset($_GET['key'])) {
            if ($hook->isExisted('SCRUD_EDIT_FORM')) {
                $this->form = $hook->filter('SCRUD_EDIT_FORM', $this->form);
            }

            $params = array();
            $strCon = "";
            $aryVal = array();
            $_tmp = "";
            foreach ($this->primaryKey as $f) {
                $strCon .= $_tmp . " " . $f . ' = ?';
                $_tmp = " AND ";
                $aryVal[] = $_GET['key'][$f];
            }
            $crudAuth = $CI->session->userdata('CRUD_AUTH');
            if ($this->globalAccess == false &&
            !empty($crudAuth) &&
            in_array($this->conf['table'] . '.created_by', $this->fields)  && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
            	$_tmp = 'AND ';
            }
            
            $params['fields'] = $this->fields;
            $params['join'] = $this->join;
            $params['conditions'] = array($strCon, $aryVal);
            $rs = $this->dao->findFirst($params);

            //Custom Functions Calls Before Edit Form load
            $this->conf['comId'] = $this->comId;
            $preCfunctions = new Cfunctions;  
            $preCfunctions->beforeEditForm($this->conf);
            //////////////////////////////////////////////

            if (!empty($rs)){
            	$_POST = array_merge($_POST, array('data' => $rs));
                //echo "<pre>"; print_r($_POST);
            }else{
            	$q = $this->queryString;
            	$q['xtype'] = 'index';
            	if (isset($q['key']))
            		unset($q['key']);
            	if (isset($q['auth_token']))
            		unset($q['auth_token']);
            	header("Location: ?" . http_build_query($q, '', '&'));
            }
        } else {
            if ($hook->isExisted('SCRUD_ADD_FORM')) {
                $this->form = $hook->filter('SCRUD_ADD_FORM', $this->form);
            }
            //Custom Functions Calls Before Add Form load
            $this->conf['comId'] = $this->comId;
            $preCfunctions = new Cfunctions;  
            $preCfunctions->beforeAddForm($this->conf);
            //////////////////////////////////////////////
        }

        if (is_file($this->conf['theme_path'] . '/form.php')) {
            require_once $this->conf['theme_path'] . '/form.php';
        } else {
            die($this->conf['theme_path'] . '/form.php is not found.');
        }
    }

    /**
     *
     */
    private function confirm() {
        $CI = & get_instance();
        $hook = Hook::singleton();
        $key = $CI->input->post('key');
        $auth_token = $CI->input->post('auth_token');
        if (!empty($key)) {
            if ($hook->isExisted('SCRUD_EDIT_CONFIRM')) {
                $this->form = $hook->filter('SCRUD_EDIT_CONFIRM', $this->form);
            }
        } else {
            if ($hook->isExisted('SCRUD_ADD_CONFIRM')) {
                $this->form = $hook->filter('SCRUD_ADD_CONFIRM', $this->form);
            }
        }
        foreach ($this->form as $field => $v) {
            $elements = (isset($v['element'])) ? $v['element'] : array();
            switch ($elements[0]) {
                case 'image':
                    $tmpfields = explode('.', $field);
                    $this->fileUpload->uploadDir = __IMAGE_UPLOAD_REAL_PATH__;
                    $this->fileUpload->extensions = $CI->config->item('imageExtensions');
                    $this->fileUpload->tmpFileName = $_FILES['img_data']['tmp_name'][$tmpfields[0]][$tmpfields[1]];
                    $this->fileUpload->fileName = $_FILES['img_data']['name'][$tmpfields[0]][$tmpfields[1]];
                    if (empty($this->data[$tmpfields[0]][$tmpfields[1]])){
                    	$this->data[$tmpfields[0]][$tmpfields[1]] = $_FILES['img_data']['name'][$tmpfields[0]][$tmpfields[1]];
                    }
                    $this->fileUpload->httpError = $_FILES['img_data']['error'][$tmpfields[0]][$tmpfields[1]];

                    if ($this->fileUpload->upload()) {
                        $this->data[$field] = $_POST['data'][$tmpfields[0]][$tmpfields[1]] = $this->fileUpload->newFileName;
                        if (isset($elements[1]) && isset($elements[1]['thumbnail'])) {
                            switch ($elements[1]['thumbnail']) {
                                case 'mini':
                                    $this->image->miniThumbnail($this->fileUpload->newFileName);
                                    break;
                                case 'small':
                                    $this->image->smallThumbnail($this->fileUpload->newFileName);
                                    break;
                                case 'medium':
                                    $this->image->mediumThumbnail($this->fileUpload->newFileName);
                                    break;
                                case 'large':
                                    $this->image->largeThumbnail($this->fileUpload->newFileName);
                                    break;
                                default :
                                    $this->image->miniThumbnail($this->fileUpload->newFileName);
                                    break;
                            }
                        } else {
                            $this->image->miniThumbnail($this->fileUpload->newFileName);
                        }
                        
                        $width = (isset($elements[1]['width']))?$elements[1]['width']:'';
                        $height = (isset($elements[1]['height']))?$elements[1]['height']:'';
                        $fix = 'width';
                        if ($width != '' || $height != ''){
                        	$this->image->newWidth = '';
                        	$this->image->newHeight = '';
                        	$this->image->pre = '';
                        	if ($width == ''){
                        		$fix = 'height';
                        	}
                        	$this->image->resize($this->fileUpload->newFileName,$width,$height,$fix);
                        }
                    }
                    $error = $this->fileUpload->getMessage();
                    if (!empty($error)) {
                        $this->errors[$field] = $error;
                        $this->data[$field] = "no error";
                    }
                    break;
                case 'file':
                    $tmpfields = explode('.', $field);
                    $this->fileUpload->uploadDir = __FILE_UPLOAD_REAL_PATH__;
                    $this->fileUpload->extensions = $CI->config->item('fileExtensions');
                    $this->fileUpload->tmpFileName = $_FILES['file_data']['tmp_name'][$tmpfields[0]][$tmpfields[1]];
                    $this->fileUpload->fileName = $_FILES['file_data']['name'][$tmpfields[0]][$tmpfields[1]];
                    if (empty($this->data[$tmpfields[0]][$tmpfields[1]])){
                    	$this->data[$tmpfields[0]][$tmpfields[1]] = $_FILES['file_data']['name'][$tmpfields[0]][$tmpfields[1]];
                    }
                    $this->fileUpload->httpError = $_FILES['file_data']['error'][$tmpfields[0]][$tmpfields[1]];
                    if ($this->fileUpload->upload()) {
                        $this->data[$field] = $_POST['data'][$tmpfields[0]][$tmpfields[1]] = $this->fileUpload->newFileName;
                    }
                    $error = $this->fileUpload->getMessage();
                    if (!empty($error)) {
                        $this->errors[$field] = $error;
                        $this->data[$field] = "no error";
                    }
                    break;
            }
        }
        if (count($_POST) > 0 && $this->validate()) {
            if (is_file($this->conf['theme_path'] . '/confirm.php')) {
                require_once $this->conf['theme_path'] . '/confirm.php';
            } else {
                die($this->conf['theme_path'] . '/confirm.php is not found.');
            }
        } else {
            $key = $CI->input->post('key');
            if (!empty($key)) {
                if ($hook->isExisted('SCRUD_EDIT_FORM')) {
                    $this->form = $hook->filter('SCRUD_EDIT_FORM', $this->form);
                }
            } else {
                if ($hook->isExisted('SCRUD_ADD_FORM')) {
                    $this->form = $hook->filter('SCRUD_ADD_FORM', $this->form);
                }
            }
            if (is_file($this->conf['theme_path'] . '/form.php')) {
                require_once $this->conf['theme_path'] . '/form.php';
            } else {
                die($this->conf['theme_path'] . '/form.php is not found.');
            }
        }
    }

    /**
     *
     */
    private function update() {
        $CI = & get_instance();
        $key = $CI->input->post('key');
        $auth_token = $CI->input->post('auth_token');
        $hook = Hook::singleton();
        $moduleId = $this->comId;

        foreach ($this->data[$this->conf['table']] as $k => $v){
            foreach ($this->conf['form_elements'] as $value){
                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && 
                    ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'date' or
                 $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'date_simple')){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                }

                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'datetime'){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'time'){
                    //echo "<pre>";print_r($v);return 0;exit;////
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                if ($v!='' && isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'password'){
                     $v = sha1($v);
                }elseif($v=='' && isset($_GET[key][$this->conf['table'].'.id']) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'password'){
                    $CI->db->select($k);
                    $CI->db->from($this->conf['table']);
                    $CI->db->where('id',$_GET[key][$this->conf['table'].'.id']);
                    $query = $CI->db->get();
                    $busi = $query->row_array();
                    if (!empty($busi))
                        $v = $busi[user_password];
                }

                //FIle Uploaded STart
            if (isset($value['section_fields'][$this->conf['table'].'.'.$k])){
               switch ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][0]) {
                    case 'image':
                        $tmpfields = explode('.', $field);
                        $this->fileUpload->uploadDir = __IMAGE_UPLOAD_REAL_PATH__;
                        $this->fileUpload->extensions = $CI->config->item('imageExtensions');
                        $this->fileUpload->tmpFileName =$_FILES['img_data']['tmp_name'][$this->conf['table']][$k];
                        $this->fileUpload->fileName = $_FILES['img_data']['name'][$this->conf['table']][$k];
                       
                        $this->fileUpload->httpError = $_FILES['img_data']['error'][$this->conf['table']][$k];

                        if ($this->fileUpload->upload()) {
                            $v = $_FILES['img_data']['name'][$this->conf['table']][$k] = $this->fileUpload->newFileName;
                            if (isset($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]) && isset($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]['thumbnail'])) {
                                switch ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]['thumbnail']) {
                                    case 'mini':
                                        $this->image->miniThumbnail($this->fileUpload->newFileName);
                                        break;
                                    case 'small':
                                        $this->image->smallThumbnail($this->fileUpload->newFileName);
                                        break;
                                    case 'medium':
                                        $this->image->mediumThumbnail($this->fileUpload->newFileName);
                                        break;
                                    case 'large':
                                        $this->image->largeThumbnail($this->fileUpload->newFileName);
                                        break;
                                    default :
                                        $this->image->miniThumbnail($this->fileUpload->newFileName);
                                        break;
                                }
                            } else {
                                $this->image->miniThumbnail($this->fileUpload->newFileName);
                            }
                            
                            $width = (isset($elements[1]['width']))?$elements[1]['width']:'';
                            $height = (isset($elements[1]['height']))?$elements[1]['height']:'';
                            $fix = 'width';
                            if ($width != '' || $height != ''){
                                $this->image->newWidth = '';
                                $this->image->newHeight = '';
                                $this->image->pre = '';
                                if ($width == ''){
                                    $fix = 'height';
                                }
                                $this->image->resize($this->fileUpload->newFileName,$width,$height,$fix);
                            }
                        }
                        $error = $this->fileUpload->getMessage();
                        if (!empty($error)) {
                            $this->errors[$field] = $error;
                            $this->data[$field] = "no error";
                        }
                        break;
                    case 'file':
                        $tmpfields = explode('.', $field);
                        $this->fileUpload->uploadDir = __FILE_UPLOAD_REAL_PATH__;
                        $this->fileUpload->extensions = $CI->config->item('fileExtensions');
                        $this->fileUpload->tmpFileName = $_FILES['file_data']['tmp_name'][$this->conf['table']][$k];
                        $this->fileUpload->fileName = $_FILES['file_data']['name'][$this->conf['table']][$k];
                        
                        $this->fileUpload->httpError = $_FILES['file_data']['error'][$this->conf['table']][$k];
                        if ($this->fileUpload->upload()) {
                            $v = $_FILES['file_data']['name'][$this->conf['table']][$k] = $this->fileUpload->newFileName;
                        }
                        $error = $this->fileUpload->getMessage();
                        if (!empty($error)) {
                            $this->errors[$field] = $error;
                            $this->data[$field] = "no error";
                        }
                        break;
                }
            }
                //FIle Uploaded STart
                if (is_array($v)){
                    $this->data[$this->conf['table']][$k] = ','.implode(',', $v).',';
                }else{
                    $this->data[$this->conf['table']][$k] = $v;
                }
            }
        }

        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        
        $historyDao = new ScrudDao('crud_histories', $CI->db);
        $history = array();
        $history['user_id'] = (isset($crudAuth['id']))?$crudAuth['id']:0;
        $history['site_id'] = (isset($crudAuth['site_id']))?$crudAuth['site_id']:1;
        $history['com_id'] = (isset($_GET['com_id']))?$_GET['com_id']:0;
        $history['user_name'] = (isset($crudAuth['user_name']))?$crudAuth['user_name']:'';
        $history['history_table_name'] = $this->conf['table'];
        $history['history_date_time'] = date("Y-m-d H:i:s");

        ///////////////////////////////////////////////////////////////////////////
        //my error custom function for business setup with login id n email check//
        ///////////////////////////////////////////////////////////////////////////
        $q = $this->queryString;
        //if(key($q['key'])=='business.id' or key($q['key'])=='crud_users.id' or key($q['key'])=='user_groups.id')
        if(key($q['key']))
            $my_id = $q['key'][key($q['key'])];
        else
            $my_id = 0;
        $par = array('id'=>$my_id);
        $Cfunctions = new Cfunctions;
        if($Cfunctions->validateClient($par)){
            $this->errors['my_error'][]=$Cfunctions->validateClient($par);
        }
        ///////////////////////////////////////////////////////////////////////////

        //if (count($_POST) > 0 && $this->validate() && $auth_token == $CI->session->userdata('auth_token_xtable')) {
        if (count($_POST) > 0 && $this->validate()) {
            if ($hook->isExisted('SCRUD_BEFORE_SAVE')) {
                $this->data = $hook->filter('SCRUD_BEFORE_SAVE', $this->data);
            }
            $editFlag = false;
            foreach ($this->primaryKey as $f) {
                $ary = explode('.', $f);
                if (isset($key[$ary[0]][$ary[1]])) {
                    $editFlag = true;
                } else {
                    $editFlag = false;
                    break;
                }
            }
            $q = $this->queryString;
            $q['xtype'] = 'index';
            if (isset($q['key']))
                unset($q['key']);

            if ($editFlag) {
                /*//Custom Functions Calls Before Edit STart
                if(!empty($this->CfunctionsArray)){   
                    $Cfunctions = new Cfunctions;
                    foreach($this->CfunctionsArray as $function_name){
                        $func_name = explode(':',$function_name);
                        if($func_name[0]=='edit-pre-functions')
                        $Cfunctions->$func_name[1]();
                    }
                }*/
                ////////////////////////////////////

                $params = array();
                $strCon = "";
                $aryVal = array();
                $_tmp = "";
                foreach ($this->primaryKey as $f) {
                    $ary = explode('.', $f);
                    $strCon .= $_tmp . $f . ' = ?';
                    $_tmp = " AND ";
                    $aryVal[] = $key[$ary[0]][$ary[1]];
                }
                if ($this->globalAccess == false &&
                !empty($crudAuth) &&
                in_array($this->conf['table'] . '.created_by', $this->fields) && 
                in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                    $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
                    $_tmp = 'AND ';
                }
                $params = array($strCon, $aryVal);
                ////////calling before Update function//////////////////////
                $beforeUpdate = new Cfunctions;
                $this->data['comId'] = $this->comId;
                $this->data['module_name'] = $this->conf['title'];
                $this->data['table'] = $this->conf['table']; 
                $this->data['id'] = $params[1][0];
                $this->data['fieldtype'] = $this->conf['form_elements'];
                $this->data['user_id'] = $crudAuth['id'];
                $this->data['business_name'] = $CI->session->userdata('bus_name');
                $beforeUpdate->beforeUpdateRecord($this->data);
                /////////////////////
                try {
                    if ($hook->isExisted('SCRUD_BEFORE_UPDATE')) {
                        $this->data = $hook->filter('SCRUD_BEFORE_UPDATE', $this->data);
                    }
                    if (in_array($this->conf['table'] . '.site_id', $this->fields) and !isset($this->data[$this->conf['table']]['site_id'])){
                        $this->data[$this->conf['table']]['site_id'] = $crudAuth['site_id'];
                    }
                    if (in_array($this->conf['table'] . '.Status', $this->fields) and !isset($this->data[$this->conf['table']]['Status'])){
                        $this->data[$this->conf['table']]['Status'] = 'Active';
                    }
                    /*if($moduleId==41 or $moduleId==42 or $moduleId==43 or $moduleId==44 or $moduleId==45 or $moduleId==58 or $moduleId==62 or $moduleId==63 or $moduleId==64 or $moduleId==70 or $moduleId==74 or $moduleId==75){
                            $updatedata = array('Status' => 'Active');
                            $CI->db->where('id', $my_id);
                            $CI->db->update('business', $updatedata);
                    }*/
                    
                    if (in_array($this->conf['table'] . '.modified_by', $this->fields)){
                        $this->data[$this->conf['table']]['modified_by'] = $crudAuth['id'];
                    }
                    if (in_array($this->conf['table'] . '.modified', $this->fields)){
                        $this->data[$this->conf['table']]['modified'] = date('Y-m-d H:i:s');
                    }
                    $this->dao->update($this->data[$this->conf['table']], $params);
                    //exit;
                    
                    //KAMRAN SERVICE FUNCTION
                    $afterInsert = new Cfunctions;
                    $this->data['comId'] = $this->comId;
                    $this->data['module_name'] = $this->conf['title'];
                    $this->data['table'] = $this->conf['table']; 
                    $this->data['id'] = $params[1][0];
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $this->data['user_id'] = $crudAuth['id'];
                    $this->data['business_name'] = $CI->session->userdata('bus_name');
                    $afterInsert->afterUpdateRecord($this->data);
                    /////////////////////
                    


                    $tmpData = $this->data[$this->conf['table']];
                    foreach ($this->primaryKey as $f) {
                        $ary = explode('.', $f);
                        $tmpData[$ary[1]] = $_POST['key'][$ary[0]][$ary[1]];
                    }
                    
                    $history['history_data'] = json_encode($tmpData);
                    $history['history_action'] = 'update';
                    $historyDao->insert($history);
                    
                    if ($hook->isExisted('SCRUD_COMPLETE_SAVE')) {
                        $hook->execute('SCRUD_COMPLETE_SAVE', $this->data);
                    }
                    if ($hook->isExisted('SCRUD_COMPLETE_UPDATE')) {
                        $hook->execute('SCRUD_COMPLETE_UPDATE', $this->data);
                    }

                    //Date Functions
                    $update_id = $params[1][0];
                    if(isset($_POST['calendar_data']) && $_POST['calendar_data'] && $update_id){
                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array(); 
                        $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                        $explo = explode(',',$entry_data[0]['eventsfor']);
                        foreach($explo as $val){
                            $exploded = explode('-',$val);
                            if(isset($exploded[1])){
                                $CI->db->delete('calendar', array('id' => $exploded[1]));
                            }
                        }
                        if($module_data[0]['component_table'] != 'calendar'){
                            $final_array = '';
                            ////
                            if(!empty($module_data)){
                                $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                               
                                $explo = explode(',',$entry_data[0]['eventsfor']);
                                foreach($explo as $val){
                                    //////////////////
                                    $exploded = explode('|',$val);
                                    $subject = new Cfunctions;
                                    $temp_val = $subject->findSubject($module_data[0], $exploded[0]);
                                    if(isset($temp_val)&& $temp_val!=""){
                                        $CI->db->delete('calendar', array('subject' => $temp_val));
                                        $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                    }
                                //////////////// 
                                }
                            }
                            ////
                            foreach($_POST['calendar_data'][$module_data[0]['component_table']] as $key => $cal_entry_save){
                                                                //Tariq changes
                                //relaced this line
                                //$data['subject']= ucwords($_POST['data'][$module_data[0]['component_table']]['title']) . " - " . ucwords(str_replace("_"," ",$key));
                                $subject = new Cfunctions;
                                $data['subject']= $subject->findSubject($module_data[0], $key);
                                ///////////////////////////

                                $CI->db->where('subject',$data['subject']);
                                $CI->db->delete('calendar');

                                $v = $_POST['data'][$module_data[0]['component_table']][$key];
                                if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                                    $v = str_replace('/','-',$v);
                                }
                                if(!empty($v)){
                                    $v = str2mysqltime($v,'Y-m-d');
                                }

                                $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                $moduleEntityParam['module_id'] =  $module_data[0]['id'];
                                $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                                $data['id']=$moduleEntityId;

                                $data['related_module']= $module_data[0]['id'];
                                $data['activitytype']= 0;
                                $data['date_start']= $data['due_date']= $v;
                                $data['time_start']= '';
                                $data['time_end']= '';
                                $data['sendnotification']= 'Yes';
                                $data['duration_hours']= '1';
                                $data['duration_minutes']= '1';
                                $data['status']= '1';
                                // eventstatus = calendar type
                                $data['eventstatus']= $_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                $data['priority']= '';
                                $data['location']= '';
                                $data['notime']= '';
                                $data['visibility']= '1';
                                $data['recurringtype']= '';
                                $data['invite_calendars']= ",".$_POST['calander_for_data'][$module_data[0]['component_table']][$key].",";
                                $data['created_by']= $crudAuth['id'];
                                if($this->data[$this->conf['table']]['assigned_to'])
                                    $data['assigned_to']= $this->data[$this->conf['table']]['assigned_to'];
                                else
                                    $data['assigned_to']= $crudAuth['id'];
                                
                                $data['created']= date('Y-m-d H:i:s');
                                $data['site_id']= $crudAuth['site_id'];
                                
                                $calendar = $CI->db->insert('calendar',$data);
                                $event_id = $CI->db->insert_id();
                                //////////////////////
                                $CI->db->select('assigned_to');
                                $CI->db->from('calendar_types');
                                $CI->db->where('id',$_POST['calander_for_data'][$module_data[0]['component_table']][$key]);
                                
                                $varr=$CI->db->get()->result_array()['0']['assigned_to'];
                                if($varr!= $data['assigned_to']){
                                    $data['assigned_to']=$varr;
                                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                    $moduleEntityParam['module_id'] = $moduleId;
                                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                    $data['eventstatus']=$_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                    $data['id']=$moduleEntityId;
                                    //$data['eventstatus']='';

                                    $CI->db->insert('calendar',$data);
                                    //echo "<pre>";print_r($data);exit;
                                
                                }
                                ///////////////////////////////
                                $final_array .= $key."|".$event_id.",";
                            }
                            
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $update_id);
                            $CI->db->update($module_data[0]['component_table'], $updatedata); 
                        }
                    } else {

                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array();

                        if(!empty($module_data)){
                            $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                            $explo = explode(',',$entry_data[0]['eventsfor']);
                            foreach($explo as $val){
                                //////////////////
                                
                                $exploded = explode('|',$val);
                                $subject = new Cfunctions;
                                $temp_val = $subject->findSubject($module_data[0], $exploded[0]);

                                $CI->db->delete('calendar', array('subject' => $temp_val));
                                $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                ////////////////
                            }
                            $final_array = '';
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $update_id);
                            $CI->db->update($module_data[0]['component_table'], $updatedata);
                        }
                    }
                    //Date Functions

                    //Custom Functions Calls AFTER EDIT START
                    /*$par = array('id'=>$update_id, 'data'=>$_POST);
                    if(!empty($this->CfunctionsArray)){   
                        $Cfunctions = new Cfunctions;
                        foreach($this->CfunctionsArray as $function_name){
                            $func_name = explode(':',$function_name);
                            if($func_name[0]=='edit-post-functions')
                            $Cfunctions->$func_name[1]($par);
                        }
                    }*/
                    //Custom Functions Calls AFTER EDIT END

                    //COMMENTS FUNCTIONS START
                    if(!empty($par)){
                        $Cfunctions = new Cfunctions;
                        $Cfunctions->customsetcomments($par);
                    }
                    //COMMENTS FUNCTIONS END
                    $CI->session->set_flashdata('msg', 'Record is updated successfully');
//echo $v."<pre>";print_r($data);exit;
                    if($moduleId==41 or $moduleId==42 or $moduleId==43 or $moduleId==44 or $moduleId==45 or $moduleId==58 or $moduleId==62 or $moduleId==63 or $moduleId==64 or $moduleId==70 or $moduleId==74){
                        $q = $this->queryString;
                        $q['xtype']='form';
                    }
                    if($q['com_id'] == 30)
                        $q['com_id'] = 29;
                    
                        //redirect(base_url().'index.php/admin/scrud/browse?'.http_build_query($q, '', '&'),'refresh');
                    header("Location: ?" . http_build_query($q, '', '&'));

                } catch (Exception $e) {
                    $this->errors['__NO_FIELD__'][] = $e->getMessage();
                    if (is_file($this->conf['theme_path'] . '/form.php')) {
                        require_once $this->conf['theme_path'] . '/form.php';
                    } else {
                        die($this->conf['theme_path'] . '/form.php is not found.');
                    }
                }
            } else {
                    $beforeInsert = new Cfunctions;
                    $this->data['comId'] = $this->comId;
                    $this->data['module_name'] = $this->conf['title'];
                    $this->data['table'] = $this->conf['table']; 
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $this->data['user_id'] = $crudAuth['id'];
                    $this->data['business_name'] = $CI->session->userdata('bus_name');
                    $beforeInsert->beforeInsertNewRecord($this->data);
                try {

                    /*//Custom Functions Calls BEFORE ADD FUNCTION START
                    if(!empty($this->CfunctionsArray)){   
                        $Cfunctions = new Cfunctions;
                        foreach($this->CfunctionsArray as $function_name){
                            $func_name = explode(':',$function_name);
                            if($func_name[0]=='add-pre-functions')
                                $Cfunctions->$func_name[1]();
                        }
                    }
                    //Custom Functions Calls BEFORE ADD FUNCTION END*/

                    if ($hook->isExisted('SCRUD_BEFORE_INSERT')) {
                        $this->data = $hook->filter('SCRUD_BEFORE_INSERT', $this->data);
                    }
                    if (in_array($this->conf['table'] . '.site_id', $this->fields) and !isset($this->data[$this->conf['table']]['site_id'])){
                        $this->data[$this->conf['table']]['site_id'] = $crudAuth['site_id'];
                    }
                    if (in_array($this->conf['table'] . '.Status', $this->fields) and !isset($this->data[$this->conf['table']]['Status'])){
                        $this->data[$this->conf['table']]['Status'] = 'Active';
                    }
                    if (in_array($this->conf['table'] . '.created_by', $this->fields)){
                        $this->data[$this->conf['table']]['created_by'] = $crudAuth['id'];
                    }
                    if (in_array($this->conf['table'] . '.created', $this->fields)){
                        $this->data[$this->conf['table']]['created'] = date('Y-m-d H:i:s');
                    }
                    

                    if ($moduleId ==0) {
                        $moduleEntityId = $this->dao->insert($this->data[$this->conf['table']]);
                    } else {
                        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                        $moduleEntityParam['module_id'] = $moduleId;
                        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                        $this->data[$this->conf['table']]['id'] = $moduleEntityId;
                        $this->dao->insert($this->data[$this->conf['table']]);
                    }
                    
                    // Genereate ID for new reocord
                    
                    $afterInsert = new Cfunctions;
                    $this->data['comId'] = $this->comId;
                    $this->data['module_name'] = $this->conf['title'];
                    $this->data['table'] = $this->conf['table']; 
                    $this->data['id'] = $moduleEntityId;
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $this->data['user_id'] = $crudAuth['id'];
                    $this->data['business_name'] = $CI->session->userdata('bus_name');
                    $afterInsert->afterInsertNewRecord($this->data);
                    

                    $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                    $params['fields'] = array('id,module_id','prefix','curr_id');
                    $params['conditions'] = array('module_id="'.$moduleId.'"');
                    $params['order'] =  array('id');
                    $rs = $modNum->find($params);
                    
                    if(!empty($rs)){
                        $rs = $rs[0];

                        $moduleTable = $this->conf['table'];
                        $moduleTableField = $moduleTable . 'no';
                        $newId =  $rs['curr_id'];
                        $newModuleId = $rs['prefix'] . $newId;
                        
                        $this->data[$this->conf['table']][$moduleTableField] = $newModuleId;

                        $updateMod = new ScrudDao($this->conf['table'], $CI->db);
                        $updateMod->update(array($moduleTableField=>$newModuleId), array('id='.$moduleEntityId));
                        $updateCurrentId = $newId+1;
                        $modNum->update(array('curr_id'=>$updateCurrentId),array('id='.$rs['id']));
                    }
                    
                    $history['history_data'] = json_encode($this->data[$this->conf['table']]);
                    $history['history_action'] = 'add';
                    $historyDao->insert($history);

                    if ($hook->isExisted('SCRUD_COMPLETE_SAVE')) {
                        $hook->execute('SCRUD_COMPLETE_SAVE', $this->data);
                    }
                    if ($hook->isExisted('SCRUD_COMPLETE_INSERT')) {
                        $hook->execute('SCRUD_COMPLETE_INSERT', $this->data);
                    }



                    //Date Functions
                    if(isset($_POST['calendar_data'])){
                        //print_r($_POST);exit;
                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array(); 
                        if($module_data[0]['component_table'] != 'calendar'){
                            $final_array = '';
                            ////
                            if(!empty($module_data)){
                                $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                               
                                $explo = explode(',',$entry_data[0]['eventsfor']);
                                foreach($explo as $val){
                                    //////////////////
                                    $exploded = explode('|',$val);
                                    $subject = new Cfunctions;
                                    $temp_val = $subject->findSubject($module_data[0], $exploded[0]);
                                    if(isset($temp_val)&& $temp_val!=""){
                                        $CI->db->delete('calendar', array('subject' => $temp_val));
                                        $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                    }
                                //////////////// 
                                }
                            }
                            ////
                            foreach($_POST['calendar_data'][$module_data[0]['component_table']] as $key => $cal_entry_save){
                                                                //Tariq changes
                                //relaced this line
                                //$data['subject']= ucwords($_POST['data'][$module_data[0]['component_table']]['title']) . " - " . ucwords(str_replace("_"," ",$key));
                                $subject = new Cfunctions;
                                $data['subject']= $subject->findSubject($module_data[0], $key);
                                ///////////////////////////

                                $CI->db->where('subject',$data['subject']);
                                $CI->db->delete('calendar');

                                $v = $_POST['data'][$module_data[0]['component_table']][$key];
                                if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                                    $v = str_replace('/','-',$v);
                                }
                                if(!empty($v)){
                                    $v = str2mysqltime($v,'Y-m-d');
                                }

                                $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                $moduleEntityParam['module_id'] =  $module_data[0]['id'];
                                $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                                $data['id']=$moduleEntityId;

                                $data['related_module']= $module_data[0]['id'];
                                $data['activitytype']= 0;
                                $data['date_start']= $data['due_date']= $v;
                                $data['time_start']= '';
                                $data['time_end']= '';
                                $data['sendnotification']= 'Yes';
                                $data['duration_hours']= '1';
                                $data['duration_minutes']= '1';
                                $data['status']= '1';
                                // eventstatus = calendar type
                                $data['eventstatus']= $_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                $data['priority']= '';
                                $data['location']= '';
                                $data['notime']= '';
                                $data['visibility']= '1';
                                $data['recurringtype']= '';
                                $data['invite_calendars']= ",".$_POST['calander_for_data'][$module_data[0]['component_table']][$key].",";
                                $data['created_by']= $crudAuth['id'];
                                if($this->data[$this->conf['table']]['assigned_to'])
                                    $data['assigned_to']= $this->data[$this->conf['table']]['assigned_to'];
                                else
                                    $data['assigned_to']= $crudAuth['id'];
                                $data['created']= date('Y-m-d H:i:s');
                                $data['site_id']= $crudAuth['site_id'];
                                
                                $calendar = $CI->db->insert('calendar',$data);
                                $event_id = $CI->db->insert_id();
                                //////////////////////
                                $CI->db->select('assigned_to');
                                $CI->db->from('calendar_types');
                                $CI->db->where('id',$_POST['calander_for_data'][$module_data[0]['component_table']][$key]);
                                
                                $varr=$CI->db->get()->result_array()['0']['assigned_to'];
                                if($varr!= $data['assigned_to']){
                                    $data['assigned_to']=$varr;
                                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                    $moduleEntityParam['module_id'] = $moduleId;
                                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                    $data['eventstatus']=$_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                    $data['id']=$moduleEntityId;
                                    //$data['eventstatus']='';

                                    $CI->db->insert('calendar',$data);
                                    //echo "<pre>";print_r($data);exit;
                                
                                }
                                ///////////////////////////////
                                $final_array .= $key."|".$event_id.",";
                            }
                            
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $moduleEntityId);
                            $CI->db->update($module_data[0]['component_table'], $updatedata); 
                        }
                    }
                    //Date Functions

                    /*//Custom Functions Calls AFTER ADD FUNCTION START
                    $par = array('id'=>$moduleEntityId, 'data'=>$_POST);
                    if(!empty($this->CfunctionsArray)){   
                        $Cfunctions = new Cfunctions;
                        foreach($this->CfunctionsArray as $function_name){
                            $func_name = explode(':',$function_name);
                            if($func_name[0]=='add-post-functions')
                                $Cfunctions->$func_name[1]($par);
                        }
                    }
                    //Custom Functions Calls AFTER ADD FUNCTION END*/
                   

                    //COMMENTS FUNCTIONS START
                    if(!empty($par)){
                        $Cfunctions = new Cfunctions;
                        $Cfunctions->customsetcomments($par);
                    }
                    //COMMENTS FUNCTIONS END

                    /*echo $moduleId;
                    exit;*/

                    $CI->session->set_flashdata('msg', 'Record is updated successfully');

                    if($moduleId==41 or $moduleId==42 or $moduleId==43 or $moduleId==44 or $moduleId==45){
                        $q = $this->queryString;
                        $q['xtype']='form';
                        $q['key']['business.id']=$moduleEntityId;
                    }
                    if($q['com_id'] == 30)
                        $q['com_id'] = 29;


                        header("Location: ?" . http_build_query($q, '', '&'));
                } catch (Exception $e) {
                    $this->errors['__NO_FIELD__'][] = $e->getMessage();
                    if (is_file($this->conf['theme_path'] . '/form.php')) {
                        require_once $this->conf['theme_path'] . '/form.php';
                    } else {
                        die($this->conf['theme_path'] . '/form.php is not found.');
                    }
                }

                $CI->session->unset_userdata('xtable_search_conditions');
            }
        } else {
            if ($auth_token != $CI->session->userdata('auth_token_xtable')) {
                $this->errors['auth_token'][] = 'Auth token does not exist.';
            }
            if (is_file($this->conf['theme_path'] . '/form.php')) {
                require_once $this->conf['theme_path'] . '/form.php';
            } else {
                die($this->conf['theme_path'] . '/form.php is not found.');
            }
        }
    }

//Draft Update
    /**
     *
     */
    private function updateDraft() {
        $CI = & get_instance();
        $key = $CI->input->post('key');
        $auth_token = $CI->input->post('auth_token');
        $hook = Hook::singleton();
        $moduleId = $this->comId;

        foreach ($this->data[$this->conf['table']] as $k => $v){
            foreach ($this->conf['form_elements'] as $value){
                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && 
                    ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'date' or
                 $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'date_simple')){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                }

                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'datetime'){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                if (isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'time'){
                    //echo "<pre>";print_r($v);return 0;exit;////
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                if ($v!='' && isset($value['section_fields'][$this->conf['table'].'.'.$k]) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'password'){
                     $v = sha1($v);
                }elseif($v=='' && isset($_GET[key][$this->conf['table'].'.id']) && $value['section_fields'][$this->conf['table'].'.'.$k]['element'][0] == 'password'){
                    $CI->db->select($k);
                    $CI->db->from($this->conf['table']);
                    $CI->db->where('id',$_GET[key][$this->conf['table'].'.id']);
                    $query = $CI->db->get();
                    $busi = $query->row_array();
                    if (!empty($busi))
                        $v = $busi[user_password];
                }

                //FIle Uploaded STart
            if (isset($value['section_fields'][$this->conf['table'].'.'.$k])){
               switch ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][0]) {
                    case 'image':
                        $tmpfields = explode('.', $field);
                        $this->fileUpload->uploadDir = __IMAGE_UPLOAD_REAL_PATH__;
                        $this->fileUpload->extensions = $CI->config->item('imageExtensions');
                        $this->fileUpload->tmpFileName =$_FILES['img_data']['tmp_name'][$this->conf['table']][$k];
                        $this->fileUpload->fileName = $_FILES['img_data']['name'][$this->conf['table']][$k];
                       
                        $this->fileUpload->httpError = $_FILES['img_data']['error'][$this->conf['table']][$k];

                        if ($this->fileUpload->upload()) {
                            $v = $_FILES['img_data']['name'][$this->conf['table']][$k] = $this->fileUpload->newFileName;
                            if (isset($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]) && isset($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]['thumbnail'])) {
                                switch ($value['section_fields'][$this->conf['table'].'.'.$k]['element'][1]['thumbnail']) {
                                    case 'mini':
                                        $this->image->miniThumbnail($this->fileUpload->newFileName);
                                        break;
                                    case 'small':
                                        $this->image->smallThumbnail($this->fileUpload->newFileName);
                                        break;
                                    case 'medium':
                                        $this->image->mediumThumbnail($this->fileUpload->newFileName);
                                        break;
                                    case 'large':
                                        $this->image->largeThumbnail($this->fileUpload->newFileName);
                                        break;
                                    default :
                                        $this->image->miniThumbnail($this->fileUpload->newFileName);
                                        break;
                                }
                            } else {
                                $this->image->miniThumbnail($this->fileUpload->newFileName);
                            }
                            
                            $width = (isset($elements[1]['width']))?$elements[1]['width']:'';
                            $height = (isset($elements[1]['height']))?$elements[1]['height']:'';
                            $fix = 'width';
                            if ($width != '' || $height != ''){
                                $this->image->newWidth = '';
                                $this->image->newHeight = '';
                                $this->image->pre = '';
                                if ($width == ''){
                                    $fix = 'height';
                                }
                                $this->image->resize($this->fileUpload->newFileName,$width,$height,$fix);
                            }
                        }
                        $error = $this->fileUpload->getMessage();
                        if (!empty($error)) {
                            $this->errors[$field] = $error;
                            $this->data[$field] = "no error";
                        }
                        break;
                    case 'file':
                        $tmpfields = explode('.', $field);
                        $this->fileUpload->uploadDir = __FILE_UPLOAD_REAL_PATH__;
                        $this->fileUpload->extensions = $CI->config->item('fileExtensions');
                        $this->fileUpload->tmpFileName = $_FILES['file_data']['tmp_name'][$this->conf['table']][$k];
                        $this->fileUpload->fileName = $_FILES['file_data']['name'][$this->conf['table']][$k];
                        
                        $this->fileUpload->httpError = $_FILES['file_data']['error'][$this->conf['table']][$k];
                        if ($this->fileUpload->upload()) {
                            $v = $_FILES['file_data']['name'][$this->conf['table']][$k] = $this->fileUpload->newFileName;
                        }
                        $error = $this->fileUpload->getMessage();
                        if (!empty($error)) {
                            $this->errors[$field] = $error;
                            $this->data[$field] = "no error";
                        }
                        break;
                }
            }
                //FIle Uploaded STart
                if (is_array($v)){
                    $this->data[$this->conf['table']][$k] = ','.implode(',', $v).',';
                }else{
                    $this->data[$this->conf['table']][$k] = $v;
                }
            }
        }

        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        
        $historyDao = new ScrudDao('crud_histories', $CI->db);
        $history = array();
        $history['user_id'] = (isset($crudAuth['id']))?$crudAuth['id']:0;
        $history['site_id'] = (isset($crudAuth['site_id']))?$crudAuth['site_id']:1;
        $history['com_id'] = (isset($_GET['com_id']))?$_GET['com_id']:0;
        $history['user_name'] = (isset($crudAuth['user_name']))?$crudAuth['user_name']:'';
        $history['history_table_name'] = $this->conf['table'];
        $history['history_date_time'] = date("Y-m-d H:i:s");

        ///////////////////////////////////////////////////////////////////////////
        //my error custom function for business setup with login id n email check//
        ///////////////////////////////////////////////////////////////////////////
        $q = $this->queryString;
        //if(key($q['key'])=='business.id' or key($q['key'])=='crud_users.id')
        if(key($q['key']))
            $my_id = $q['key'][key($q['key'])];
        else
            $my_id = 0;
        $par = array('id'=>$my_id);
        $Cfunctions = new Cfunctions;
        if($Cfunctions->validateClient($par)){
            $this->errors['my_error'][]=$Cfunctions->validateClient($par);
        }
        ///////////////////////////////////////////////////////////////////////////

        //if (count($_POST) > 0 && $auth_token == $CI->session->userdata('auth_token_xtable')) {
        if (count($_POST) > 0) {
            if ($hook->isExisted('SCRUD_BEFORE_SAVE')) {
                $this->data = $hook->filter('SCRUD_BEFORE_SAVE', $this->data);
            }
            $editFlag = false;
            foreach ($this->primaryKey as $f) {
                $ary = explode('.', $f);
                if (isset($key[$ary[0]][$ary[1]])) {
                    $editFlag = true;
                } else {
                    $editFlag = false;
                    break;
                }
            }
            $q = $this->queryString;
            $q['xtype'] = 'index';
            if (isset($q['key']))
                unset($q['key']);

            if ($editFlag) {
                /*//Custom Functions Calls Before Edit STart
                if(!empty($this->CfunctionsArray)){   
                    $Cfunctions = new Cfunctions;
                    foreach($this->CfunctionsArray as $function_name){
                        $func_name = explode(':',$function_name);
                        if($func_name[0]=='edit-pre-functions' and $func_name[1]!='autocreateClient')
                        $Cfunctions->$func_name[1]();
                    }
                }
                ////////////////////////////////////*/

                $params = array();
                $strCon = "";
                $aryVal = array();
                $_tmp = "";
                foreach ($this->primaryKey as $f) {
                    $ary = explode('.', $f);
                    $strCon .= $_tmp . $f . ' = ?';
                    $_tmp = " AND ";
                    $aryVal[] = $key[$ary[0]][$ary[1]];
                }
                if ($this->globalAccess == false &&
                !empty($crudAuth) &&
                in_array($this->conf['table'] . '.created_by', $this->fields) && 
                in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                    $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
                    $_tmp = 'AND ';
                }
                $params = array($strCon, $aryVal);
                //////nauman starts here/////////
                $beforeUpdate = new Cfunctions;
                $this->data['comId'] = $this->comId;
                $this->data['module_name'] = $this->conf['title'];
                $this->data['table'] = $this->conf['table']; 
                $this->data['id'] = $params[1][0];
                $this->data['fieldtype'] = $this->conf['form_elements'];
                $this->data['user_id'] = $crudAuth['id'];
                $this->data['business_name'] = $CI->session->userdata('bus_name');
                $beforeUpdate->beforeUpdateRecord($this->data);
                ////////nauman ends here//////////////////
                try {
                    if ($hook->isExisted('SCRUD_BEFORE_UPDATE')) {
                        $this->data = $hook->filter('SCRUD_BEFORE_UPDATE', $this->data);
                    }
                    if (in_array($this->conf['table'] . '.site_id', $this->fields) and !isset($this->data[$this->conf['table']]['site_id'])){
                        $this->data[$this->conf['table']]['site_id'] = $crudAuth['site_id'];
                    }
                    if (in_array($this->conf['table'] . '.Status', $this->fields and !isset($this->data[$this->conf['table']]['Status']))){
                        $this->data[$this->conf['table']]['Status'] = 'Draft';
                    }
                    if($moduleId=='59' or $moduleId=='60' or $moduleId=='61' or $moduleId=='48' or $moduleId=='49' or $moduleId=='47' or $moduleId==58 or $moduleId==62 or $moduleId==63 or $moduleId==64 or $moduleId==70 or $moduleId==74 or $moduleId==75){
                            $updatedata = array('Status' => 'Draft');
                            $CI->db->where('id', $my_id);
                            $CI->db->update('business', $updatedata);
                    }
                    if (in_array($this->conf['table'] . '.modified_by', $this->fields)){
                        $this->data[$this->conf['table']]['modified_by'] = $crudAuth['id'];
                    }
                    if (in_array($this->conf['table'] . '.modified', $this->fields)){
                        $this->data[$this->conf['table']]['modified'] = date('Y-m-d H:i:s');
                    }
                    
                    $this->dao->update($this->data[$this->conf['table']], $params);
                    //exit;

                    $tmpData = $this->data[$this->conf['table']];
                    foreach ($this->primaryKey as $f) {
                        $ary = explode('.', $f);
                        $tmpData[$ary[1]] = $_POST['key'][$ary[0]][$ary[1]];
                    }
                    
                    $history['history_data'] = json_encode($tmpData);
                    $history['history_action'] = 'update';
                    $historyDao->insert($history);
                    
                    if ($hook->isExisted('SCRUD_COMPLETE_SAVE')) {
                        $hook->execute('SCRUD_COMPLETE_SAVE', $this->data);
                    }
                    if ($hook->isExisted('SCRUD_COMPLETE_UPDATE')) {
                        $hook->execute('SCRUD_COMPLETE_UPDATE', $this->data);
                    }

                    //Date Functions
                    $update_id = $params[1][0];
                    if(isset($_POST['calendar_data']) && $_POST['calendar_data'] && $update_id){
                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array(); 
                        $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                        $explo = explode(',',$entry_data[0]['eventsfor']);
                        foreach($explo as $val){
                            $exploded = explode('-',$val);
                            if(isset($exploded[1])){
                                $CI->db->delete('calendar', array('id' => $exploded[1]));
                            }
                        }
                        if($module_data[0]['component_table'] != 'calendar'){
                            $final_array = '';
                            ////
                            if(!empty($module_data)){
                                $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                               
                                $explo = explode(',',$entry_data[0]['eventsfor']);
                                foreach($explo as $val){
                                    //////////////////
                                    $exploded = explode('|',$val);
                                    $subject = new Cfunctions;
                                    $temp_val = $subject->findSubject($module_data[0], $exploded[0]);
                                    if(isset($temp_val)&& $temp_val!=""){
                                        $CI->db->delete('calendar', array('subject' => $temp_val));
                                        $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                    }
                                //////////////// 
                                }
                            }
                            ////
                            foreach($_POST['calendar_data'][$module_data[0]['component_table']] as $key => $cal_entry_save){
                                                                //Tariq changes
                                //relaced this line
                                //$data['subject']= ucwords($_POST['data'][$module_data[0]['component_table']]['title']) . " - " . ucwords(str_replace("_"," ",$key));
                                $subject = new Cfunctions;
                                $data['subject']= $subject->findSubject($module_data[0], $key);
                                ///////////////////////////

                                $CI->db->where('subject',$data['subject']);
                                $CI->db->delete('calendar');

                                $v = $_POST['data'][$module_data[0]['component_table']][$key];
                                if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                                    $v = str_replace('/','-',$v);
                                }
                                if(!empty($v)){
                                    $v = str2mysqltime($v,'Y-m-d');
                                }

                                $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                $moduleEntityParam['module_id'] =  $module_data[0]['id'];
                                $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                                $data['id']=$moduleEntityId;

                                $data['related_module']= $module_data[0]['id'];
                                $data['activitytype']= 0;
                                $data['date_start']= $data['due_date']= $v;
                                $data['time_start']= '';
                                $data['time_end']= '';
                                $data['sendnotification']= 'Yes';
                                $data['duration_hours']= '1';
                                $data['duration_minutes']= '1';
                                $data['status']= '1';
                                // eventstatus = calendar type
                                $data['eventstatus']= $_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                $data['priority']= '';
                                $data['location']= '';
                                $data['notime']= '';
                                $data['visibility']= '1';
                                $data['recurringtype']= '';
                                $data['eventstatus']= ",".$_POST['calander_for_data'][$module_data[0]['component_table']][$key].",";
                                $data['created_by']= $crudAuth['id'];
                                if($this->data[$this->conf['table']]['assigned_to'])
                                    $data['assigned_to']= $this->data[$this->conf['table']]['assigned_to'];
                                else
                                    $data['assigned_to']= $crudAuth['id'];
                                $data['created']= date('Y-m-d H:i:s');
                                $data['site_id']= $crudAuth['site_id'];
                                
                                $calendar = $CI->db->insert('calendar',$data);
                                $event_id = $CI->db->insert_id();
                                //////////////////////
                                $CI->db->select('assigned_to');
                                $CI->db->from('calendar_types');
                                $CI->db->where('id',$_POST['calander_for_data'][$module_data[0]['component_table']][$key]);
                                
                                $varr=$CI->db->get()->result_array()['0']['assigned_to'];
                                if($varr!= $data['assigned_to']){
                                    $data['assigned_to']=$varr;
                                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                    $moduleEntityParam['module_id'] = $moduleId;
                                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                    $data['eventstatus']=$_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                    $data['id']=$moduleEntityId;
                                    //$data['eventstatus']='';

                                    $CI->db->insert('calendar',$data);
                                    //echo "<pre>";print_r($data);exit;
                                
                                }
                                ///////////////////////////////
                                $final_array .= $key."|".$event_id.",";
                            }
                            
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $update_id);
                            $CI->db->update($module_data[0]['component_table'], $updatedata); 
                        }
                    } else {

                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array();

                        if(!empty($module_data)){
                            $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                            $explo = explode(',',$entry_data[0]['eventsfor']);
                            foreach($explo as $val){
                                //////////////////
                                
                                $exploded = explode('|',$val);
                                $subject = new Cfunctions;
                                $temp_val = $subject->findSubject($module_data[0], $exploded[0]);

                                $CI->db->delete('calendar', array('subject' => $temp_val));
                                $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                ////////////////
                            }
                            $final_array = '';
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $update_id);
                            $CI->db->update($module_data[0]['component_table'], $updatedata);
                        }
                    }
                    //Date Functions

                   /* //Custom Functions Calls AFTER EDIT START
                    $par = array('id'=>$update_id, 'data'=>$_POST);
                    if(!empty($this->CfunctionsArray)){   
                        $Cfunctions = new Cfunctions;
                        foreach($this->CfunctionsArray as $function_name){
                            $func_name = explode(':',$function_name);
                            if($func_name[0]=='edit-post-functions' and $func_name[1]!='autocreateClient')
                            $Cfunctions->$func_name[1]($par);
                        }
                    }
                    //Custom Functions Calls AFTER EDIT END*/
                    //////nauman starts here/////////
                    $afterUpdate = new Cfunctions;
                    $this->data['comId'] = $this->comId;
                    $this->data['module_name'] = $this->conf['title'];
                    $this->data['table'] = $this->conf['table']; 
                    $this->data['id'] = $update_id;
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $this->data['user_id'] = $crudAuth['id'];
                    $this->data['business_name'] = $CI->session->userdata('bus_name');
                    $afterUpdate->afterUpdateRecord($this->data);
                    ////////nauman ends here//////////////////
                    //COMMENTS FUNCTIONS START
                    if(!empty($par)){
                        $Cfunctions = new Cfunctions;
                        $Cfunctions->customsetcomments($par);
                    }
                    //COMMENTS FUNCTIONS END

                    $CI->session->set_flashdata('msg', 'Record is updated successfully');

                    if($moduleId==41 or $moduleId==42 or $moduleId==43 or $moduleId==44 or $moduleId==45 or $moduleId==58 or $moduleId==62 or $moduleId==63 or $moduleId==64 or $moduleId==70 or $moduleId==74){
                        $q = $this->queryString;
                        $q['xtype']='form';
                    }
                        //redirect(base_url().'index.php/admin/scrud/browse?'.http_build_query($q, '', '&'),'refresh');
                    header("Location: ?" . http_build_query($q, '', '&'));
                } catch (Exception $e) {
                    $this->errors['__NO_FIELD__'][] = $e->getMessage();
                    if (is_file($this->conf['theme_path'] . '/form.php')) {
                        require_once $this->conf['theme_path'] . '/form.php';
                    } else {
                        die($this->conf['theme_path'] . '/form.php is not found.');
                    }
                }
            } else {
                try {

                    /*//Custom Functions Calls BEFORE ADD FUNCTION START
                    if(!empty($this->CfunctionsArray)){   
                        $Cfunctions = new Cfunctions;
                        foreach($this->CfunctionsArray as $function_name){
                            $func_name = explode(':',$function_name);
                            if($func_name[0]=='add-pre-functions' and $func_name[1]!='autocreateClient')
                                $Cfunctions->$func_name[1]();
                        }
                    }
                    //Custom Functions Calls BEFORE ADD FUNCTION END*/

                    //////nauman starts here/////////
                    $beforeInsert = new Cfunctions;
                    $this->data['comId'] = $this->comId;
                    $this->data['module_name'] = $this->conf['title'];
                    $this->data['table'] = $this->conf['table']; 
                    
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $this->data['user_id'] = $crudAuth['id'];
                    $this->data['business_name'] = $CI->session->userdata('bus_name');
                    $beforeInsert->beforeInsertNewRecord($this->data);
                    ////////nauman ends here//////////////////

                    if ($hook->isExisted('SCRUD_BEFORE_INSERT')) {
                        $this->data = $hook->filter('SCRUD_BEFORE_INSERT', $this->data);
                    }
                    if (in_array($this->conf['table'] . '.site_id', $this->fields) and !isset($this->data[$this->conf['table']]['site_id'])){
                        $this->data[$this->conf['table']]['site_id'] = $crudAuth['site_id'];
                    }
                    if (in_array($this->conf['table'] . '.Status', $this->fields) and !isset($this->data[$this->conf['table']]['Status']) ){
                        $this->data[$this->conf['table']]['Status'] = 'Draft';
                    }
                    if($moduleId=='59' or $moduleId=='60' or $moduleId=='61' or $moduleId=='48' or $moduleId=='49' or $moduleId=='47' or $moduleId==58 or $moduleId==62 or $moduleId==63 or $moduleId==64 or $moduleId==70 or $moduleId==74 or $moduleId==75){
                            $updatedata = array('Status' => 'Draft');
                            $CI->db->where('id', $my_id);
                            $CI->db->update('business', $updatedata);
                    }
                    if (in_array($this->conf['table'] . '.created_by', $this->fields)){
                        $this->data[$this->conf['table']]['created_by'] = $crudAuth['id'];
                    }
                    if (in_array($this->conf['table'] . '.created', $this->fields)){
                        $this->data[$this->conf['table']]['created'] = date('Y-m-d H:i:s');
                    }
                    

                    if ($moduleId ==0) {
                        $moduleEntityId = $this->dao->insert($this->data[$this->conf['table']]);
                    } else {
                        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                        $moduleEntityParam['module_id'] = $moduleId;
                        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                        $this->data[$this->conf['table']]['id'] = $moduleEntityId;
                        $this->dao->insert($this->data[$this->conf['table']]);
                    }
                    
                    // Genereate ID for new reocord
                    

                    

                    $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                    $params['fields'] = array('id,module_id','prefix','curr_id');
                    $params['conditions'] = array('module_id="'.$moduleId.'"');
                    $params['order'] =  array('id');
                    $rs = $modNum->find($params);
                    
                    if(!empty($rs)){
                        $rs = $rs[0];

                        $moduleTable = $this->conf['table'];
                        $moduleTableField = $moduleTable . 'no';
                        $newId =  $rs['curr_id'];
                        $newModuleId = $rs['prefix'] . $newId;
                        
                        $this->data[$this->conf['table']][$moduleTableField] = $newModuleId;

                        $updateMod = new ScrudDao($this->conf['table'], $CI->db);
                        $updateMod->update(array($moduleTableField=>$newModuleId), array('id='.$moduleEntityId));
                        $updateCurrentId = $newId+1;
                        $modNum->update(array('curr_id'=>$updateCurrentId),array('id='.$rs['id']));
                    }
                    
                    $history['history_data'] = json_encode($this->data[$this->conf['table']]);
                    $history['history_action'] = 'add';
                    $historyDao->insert($history);

                    if ($hook->isExisted('SCRUD_COMPLETE_SAVE')) {
                        $hook->execute('SCRUD_COMPLETE_SAVE', $this->data);
                    }
                    if ($hook->isExisted('SCRUD_COMPLETE_INSERT')) {
                        $hook->execute('SCRUD_COMPLETE_INSERT', $this->data);
                    }



                    //Date Functions
                    if(isset($_POST['calendar_data'])){
                        //print_r($_POST);exit;
                        $module_data = $CI->db->get_where('crud_components',array('id'=>$moduleId))->result_array(); 
                        if($module_data[0]['component_table'] != 'calendar'){
                            $final_array = '';
                            ////
                            if(!empty($module_data)){
                                $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$update_id))->result_array(); 
                               
                                $explo = explode(',',$entry_data[0]['eventsfor']);
                                foreach($explo as $val){
                                    //////////////////
                                    $exploded = explode('|',$val);
                                    $subject = new Cfunctions;
                                    $temp_val = $subject->findSubject($module_data[0], $exploded[0]);
                                    if(isset($temp_val)&& $temp_val!=""){
                                        $CI->db->delete('calendar', array('subject' => $temp_val));
                                        $CI->db->delete('cal_invitations', array('subject' => $temp_val));
                                    }
                                //////////////// 
                                }
                            }
                            ////
                            foreach($_POST['calendar_data'][$module_data[0]['component_table']] as $key => $cal_entry_save){
                                                                //Tariq changes
                                //relaced this line
                                //$data['subject']= ucwords($_POST['data'][$module_data[0]['component_table']]['title']) . " - " . ucwords(str_replace("_"," ",$key));
                                $subject = new Cfunctions;
                                $data['subject']= $subject->findSubject($module_data[0], $key);
                                ///////////////////////////

                                $CI->db->where('subject',$data['subject']);
                                $CI->db->delete('calendar');

                                $v = $_POST['data'][$module_data[0]['component_table']][$key];
                                if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                                    $v = str_replace('/','-',$v);
                                }
                                if(!empty($v)){
                                    $v = str2mysqltime($v,'Y-m-d');
                                }

                                $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                $moduleEntityParam['module_id'] =  $module_data[0]['id'];
                                $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                                $data['id']=$moduleEntityId;

                                $data['related_module']= $module_data[0]['id'];
                                $data['activitytype']= 0;
                                $data['date_start']= $data['due_date']= $v;
                                $data['time_start']= '';
                                $data['time_end']= '';
                                $data['sendnotification']= 'Yes';
                                $data['duration_hours']= '1';
                                $data['duration_minutes']= '1';
                                $data['status']= '1';
                                // eventstatus = calendar type
                                $data['eventstatus']= $_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                $data['priority']= '';
                                $data['location']= '';
                                $data['notime']= '';
                                $data['visibility']= '1';
                                $data['recurringtype']= '';
                                $data['invite_calendars']= ",".$_POST['calander_for_data'][$module_data[0]['component_table']][$key].",";
                                $data['created_by']= $crudAuth['id'];
                                if($this->data[$this->conf['table']]['assigned_to'])
                                    $data['assigned_to']= $this->data[$this->conf['table']]['assigned_to'];
                                else
                                    $data['assigned_to']= $crudAuth['id'];
                                $data['created']= date('Y-m-d H:i:s');
                                $data['site_id']= $crudAuth['site_id'];
                                
                                $calendar = $CI->db->insert('calendar',$data);
                                $event_id = $CI->db->insert_id();
                                //////////////////////
                                $CI->db->select('assigned_to');
                                $CI->db->from('calendar_types');
                                $CI->db->where('id',$_POST['calander_for_data'][$module_data[0]['component_table']][$key]);
                                
                                $varr=$CI->db->get()->result_array()['0']['assigned_to'];
                                if($varr!= $data['assigned_to']){
                                    $data['assigned_to']=$varr;
                                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                    $moduleEntityParam['module_id'] = $moduleId;
                                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                    $data['eventstatus']=$_POST['calander_for_data'][$module_data[0]['component_table']][$key];
                                    $data['id']=$moduleEntityId;
                                    //$data['eventstatus']='';

                                    $CI->db->insert('calendar',$data);
                                    //echo "<pre>";print_r($data);exit;
                                
                                }
                                ///////////////////////////////
                                $final_array .= $key."|".$event_id.",";
                            }
                            
                            $updatedata = array('eventsfor' => $final_array);
                            $CI->db->where('id', $moduleEntityId);
                            $CI->db->update($module_data[0]['component_table'], $updatedata); 
                        }
                    }
                    //Date Functions

                    /*//Custom Functions Calls AFTER ADD FUNCTION START
                    $par = array('id'=>$moduleEntityId, 'data'=>$_POST);
                    if(!empty($this->CfunctionsArray)){   
                        $Cfunctions = new Cfunctions;
                        foreach($this->CfunctionsArray as $function_name){
                            $func_name = explode(':',$function_name);
                            if($func_name[0]=='add-post-functions' and $func_name[1]!='autocreateClient')
                                $Cfunctions->$func_name[1]($par);
                        }
                    }
                    //Custom Functions Calls AFTER ADD FUNCTION END*/
                    //////nauman starts here/////////
                    $afterInsert = new Cfunctions;
                    $this->data['comId'] = $this->comId;
                    $this->data['module_name'] = $this->conf['title'];
                    $this->data['table'] = $this->conf['table']; 
                    $this->data['id'] = $moduleEntityId;
                    $this->data['fieldtype'] = $this->conf['form_elements'];
                    $this->data['user_id'] = $crudAuth['id'];
                    $this->data['business_name'] = $CI->session->userdata('bus_name');
                    $afterInsert->afterInsertNewRecord($this->data);
                    ////////nauman ends here//////////////////

                    //COMMENTS FUNCTIONS START
                    if(!empty($par)){
                        $Cfunctions = new Cfunctions;
                        $Cfunctions->customsetcomments($par);
                    }
                    //COMMENTS FUNCTIONS END


                    /*echo $moduleId;
                    exit;*/

                    $CI->session->set_flashdata('msg', 'Record is updated successfully');
                    if($moduleId==41 or $moduleId==42 or $moduleId==43 or $moduleId==44 or $moduleId==45){
                        $q = $this->queryString;
                        $q['xtype']='form';
                        $q['key']['business.id']=$moduleEntityId;
                    }

                        header("Location: ?" . http_build_query($q, '', '&'));
                } catch (Exception $e) {
                    $this->errors['__NO_FIELD__'][] = $e->getMessage();
                    if (is_file($this->conf['theme_path'] . '/form.php')) {
                        require_once $this->conf['theme_path'] . '/form.php';
                    } else {
                        die($this->conf['theme_path'] . '/form.php is not found.');
                    }
                }

                $CI->session->unset_userdata('xtable_search_conditions');
            }
        } else {
            if ($auth_token != $CI->session->userdata('auth_token_xtable')) {
                $this->errors['auth_token'][] = 'Auth token does not exist.';
            }
            if (is_file($this->conf['theme_path'] . '/form.php')) {
                require_once $this->conf['theme_path'] . '/form.php';
            } else {
                die($this->conf['theme_path'] . '/form.php is not found.');
            }
        }
    }

//Checklist Update
    /**
     *
     */

    private function updateChecklist() {
        $CI = & get_instance();
        $key = $CI->input->post('key');
        $auth_token = $CI->input->post('auth_token');
        $hook = Hook::singleton();
        $moduleId = $this->comId;
        $theme_path = $this->conf['theme_path'];

        if($_GET['key']){
            $CI->db->select('chklst_id');
            $CI->db->from('checklist');
            $CI->db->where('id',$_GET['key']['checklist.id']);
            $query = $CI->db->get();
            $chk = $query->row_array();
            $chkid = $chk['chklst_id'];
        }else{
            $chkid = 1;
        }
        $CI->db->select('*');
        $CI->db->from('checklists');
        $CI->db->where('id',$chkid);
        $query = $CI->db->get();
        $chk = $query->row_array();
        $this->conf = unserialize($chk['config']); 
        //$this->conf = $this->form['elements'];
        //$this->form = json_decode($chk['build_config']); 
        //$this->form = json_decode($chk['section_config'], true); 


        foreach ($this->data as $k => $v){
            foreach ($this->conf['form_elements'] as $value){
                if (isset($value['section_fields'][$k]) && 
                    ($value['section_fields'][$k]['element'][0] == 'date' or
                 $value['section_fields'][$k]['element'][0] == 'date_simple')){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    if(!empty($v)){
                        $v = str2mysqltime($v,'Y-m-d');
                    }
                }

                if (isset($value['section_fields'][$k]) && $value['section_fields'][$k]['element'][0] == 'datetime'){
                    if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                        $v = str_replace('/','-',$v);
                    }
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                if (isset($value['section_fields'][$k]) && $value['section_fields'][$k]['element'][0] == 'time'){
                    $v = str2mysqltime($v,'Y-m-d H:i:s');
                }

                if (is_array($v)){
                    $this->data[$k] = ','.implode(',', $v).',';
                }else{
                    $this->data[$k] = $v;
                }
            }
        }

        $crudAuth = $CI->session->userdata('CRUD_AUTH');
        
        $historyDao = new ScrudDao('crud_histories', $CI->db);
        $history = array();
        $history['user_id'] = (isset($crudAuth['id']))?$crudAuth['id']:0;
        $history['site_id'] = (isset($crudAuth['site_id']))?$crudAuth['site_id']:1;
        $history['com_id'] = 85;
        $history['user_name'] = (isset($crudAuth['user_name']))?$crudAuth['user_name']:'';
        $history['history_table_name'] = 'checklist';
        $history['history_date_time'] = date("Y-m-d H:i:s");


        //if (count($_POST) > 0 && $this->validate() && $auth_token == $CI->session->userdata('auth_token_xtable')) {
        if (count($_POST) > 0 && $this->validate()) {
            if ($hook->isExisted('SCRUD_BEFORE_SAVE')) {
                $this->data = $hook->filter('SCRUD_BEFORE_SAVE', $this->data);
            }
            $editFlag = false;
                if (isset($_GET['key'])) {
                    $editFlag = true;
                } else {
                    $editFlag = false;
                    //break;
                }
            $q = $this->queryString;
            $q['xtype'] = 'form';

            if ($editFlag) {

                $update_id = $_GET['key']['checklist.id'];
                try {
                    if ($hook->isExisted('SCRUD_BEFORE_UPDATE')) {
                        $this->data = $hook->filter('SCRUD_BEFORE_UPDATE', $this->data);
                    }
                                        

                    $CI->db->query("UPDATE checklist SET form_data='".serialize($this->data)."' WHERE id=".$update_id);
                    //exit;
                    
                    if ($hook->isExisted('SCRUD_COMPLETE_SAVE')) {
                        $hook->execute('SCRUD_COMPLETE_SAVE', $this->data);
                    }
                    if ($hook->isExisted('SCRUD_COMPLETE_UPDATE')) {
                        $hook->execute('SCRUD_COMPLETE_UPDATE', $this->data);
                    }

                    //COMMENTS FUNCTIONS START
                    $par = array('id'=>$update_id, 'data'=>$_POST);
                    if(!empty($par)){
                        $Cfunctions = new Cfunctions;
                        $Cfunctions->customsetcomments($par);
                    }
                    //COMMENTS FUNCTIONS END
                    $CI->session->set_flashdata('msg', 'Record is updated successfully');

                        //redirect(base_url().'index.php/admin/scrud/browse?'.http_build_query($q, '', '&'),'refresh');
                    header("Location: ?" . http_build_query($q, '', '&'));

                } catch (Exception $e) {
                    $this->errors['__NO_FIELD__'][] = $e->getMessage();
                    if (is_file($theme_path . '/form.php')) {
                        require_once $theme_path . '/form.php';
                    } else {
                        die($theme_path . '/form.php is not found.');
                    }
                }
            } 
        } else {
            if ($auth_token != $CI->session->userdata('auth_token_xtable')) {
                $this->errors['auth_token'][] = 'Auth token does not exist.';
            }
            if (is_file($theme_path . '/form.php')) {
                require_once $theme_path . '/form.php';
            } else {
                die($theme_path . '/form.php is not found.');
            }
        }
    }


    private function delConfirm() {
    	$CI = & get_instance();
        if (isset($_GET['key'])) {
        	$hook = Hook::singleton();
        	if ($hook->isExisted('SCRUD_CONFRIM_DELETE_FORM')) {
        		$this->form = $hook->filter('SCRUD_CONFRIM_DELETE_FORM', $this->form);
        	}
            $params = array();
            $strCon = "";
            $aryVal = array();
            $_tmp = "";
            foreach ($this->primaryKey as $f) {
                $strCon .= $_tmp . " " . $f . ' = ?';
                $_tmp = " AND ";
                $aryVal[] = $_GET['key'][$f];
            }
            
            $crudAuth = $CI->session->userdata('CRUD_AUTH');
            
            if ($this->globalAccess == false &&
            !empty($crudAuth) &&
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
            	$_tmp = 'AND ';
            }
            
            $params['fields'] = $this->fields;
            $params['join'] = $this->join;
            $params['conditions'] = array($strCon, $aryVal);
            $rs = $this->dao->findFirst($params);
            if (!empty($rs)){
	            $_POST = array_merge($_POST, array('data' => $rs));
	
	            if (is_file($this->conf['theme_path'] . '/delete_confirm.php')) {
	                require_once $this->conf['theme_path'] . '/delete_confirm.php';
	            }
            }else{
            	$q = $this->queryString;
            	$q['xtype'] = 'index';
            	if (isset($q['key']))
            		unset($q['key']);
            	if (isset($q['auth_token']))
            		unset($q['auth_token']);
            	header("Location: ?" . http_build_query($q, '', '&'));
            }
        } else {
            $q = $this->queryString;
            $q['xtype'] = 'index';
            if (isset($q['key']))
                unset($q['key']);
            if (isset($q['auth_token']))
                unset($q['auth_token']);
            header("Location: ?" . http_build_query($q, '', '&'));
        }
    }

    /**
     *
     */
    private function del() {
        $CI = & get_instance();
        $hook = Hook::singleton();
        $crudAuth = $CI->session->userdata('CRUD_AUTH');

        $historyDao = new ScrudDao('crud_histories', $CI->db);
        $history = array();
        $history['user_id'] = (isset($crudAuth['id']))?$crudAuth['id']:0;
        $history['site_id'] = (isset($crudAuth['site_id']))?$crudAuth['site_id']:1;
        $history['com_id'] = (isset($_GET['com_id']))?$_GET['com_id']:0;
        $history['user_name'] = (isset($crudAuth['user_name']))?$crudAuth['user_name']:'';
        $history['history_table_name'] = $this->conf['table'];
        $history['history_date_time'] = date("Y-m-d H:i:s");
        
        if($_GET['com_id']==87){
            $CI->db->query("DELETE FROM checklists WHERE id = ".$_GET['key']['checklists.id']);
        }else if (isset($_GET['key']) && $_GET['auth_token'] == $CI->session->userdata('auth_token_xtable')) {
            $params = array();
            $strCon = "";
            $aryVal = array();
            $_tmp = "";
            foreach ($this->primaryKey as $f) {
                $strCon .= $_tmp . " " . $f . ' = ?';
                $_tmp = " AND ";
                $aryVal[] = $_GET['key'][$f];
            }
            $crudAuth = $CI->session->userdata('CRUD_AUTH');
            if ($this->globalAccess == false &&
            !empty($crudAuth) &&
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
            	$_tmp = 'AND ';
            }
            
            $params = array($strCon, $aryVal);
            
            $tmpData = $this->dao->findFirst(array('conditions'=>$params));
            if (!empty($tmpData)){
                //Cfunction
                    $afterdel = new Cfunctions;
                    $afterdel->beforeDelRecord($this->conf['table']);
                ////////////
	            $this->dao->remove($params);


                $afteredel = new Cfunctions;
                $afteredel->afterDelRecord($this->conf['table']);

	            
	            if ($hook->isExisted('SCRUD_COMPLETE_DELETE')) {
	            	$hook->execute('SCRUD_COMPLETE_DELETE', $tmpData);
	            }
	            
	            $history['history_data'] = json_encode($tmpData[$this->conf['table']]);
	            $history['history_action'] = 'delete';
	            $historyDao->insert($history);
            }else{
            	$q = $this->queryString;
            	$q['xtype'] = 'index';
            	if (isset($q['key']))
            		unset($q['key']);
                if($q['com_id'] == 30)
                    $q['com_id'] = 29;
            	if (isset($q['auth_token']))
            		unset($q['auth_token']);
            	header("Location: ?" . http_build_query($q, '', '&'));
            }
            
        }
        $q = $this->queryString;
        $q['xtype'] = 'index';
        if (isset($q['key']))
            unset($q['key']);
        if($q['com_id'] == 30)
            $q['com_id'] = 29;

        if (isset($q['auth_token']))
            unset($q['auth_token']);
        header("Location: ?" . http_build_query($q, '', '&'));
    }

    private function delFile() {
        $CI = & get_instance();
        $src = $CI->input->post('src');
        if (isset($_GET['fileType']) && $_GET['fileType'] == 'img') {
            $this->fileUpload->uploadDir = __IMAGE_UPLOAD_REAL_PATH__;
        } else {
            $this->fileUpload->uploadDir = __FILE_UPLOAD_REAL_PATH__;
        }

        $_POST['src']['field'] = str_replace('data.', '', $src['field']);
        $src = $CI->input->post('src');
        if (isset($src['field']) &&
                is_file($this->fileUpload->uploadDir . $src['file'])) {
            $params = array();
            $strCon = "";
            $aryVal = array();
            $_tmp = "";
            foreach ($this->primaryKey as $f) {
                $strCon .= $_tmp . " " . $f . ' = ?';
                $_tmp = " AND ";
                $aryVal[] = $_GET['key'][$f];
            }
            $params['fields'] = $this->fields;
            $params['join'] = $this->join;
            $params['conditions'] = array($strCon, $aryVal);
            $rs = $this->dao->findFirst($params);
            $ary = explode('.', $src['field']);
            if (!empty($rs)) {
                if (trim($rs[$ary[0]][$ary[1]]) == trim($src['file'])) {
                    $data = array();
                    $data[$ary[1]] = '';
                    $this->dao->update($data, $params['conditions']);
                    $this->fileUpload->delFile(trim($src['file']));
                    $this->fileUpload->delFile('thumbnail_' . trim($src['file']));
                }
            }
        }
    }

    /**
     *
     * Enter description here ...
     */
    private function view() {
    	$CI = & get_instance();
        $CI->load->model('crud_auth');
        $auth = $CI->crud_auth;
    	
        if (isset($_GET['key'])) {
        	$hook = Hook::singleton();
        	if ($hook->isExisted('SCRUD_VIEW_FORM')) {
        		$this->form = $hook->filter('SCRUD_VIEW_FORM', $this->form);
        	}
            $params = array();
            $strCon = "";
            $aryVal = array();
            $_tmp = "";
            foreach ($this->primaryKey as $f) {
                $strCon .= $_tmp . " " . $f . ' = ?';
                $_tmp = " AND ";
                $aryVal[] = $_GET['key'][$f];
            }
            $crudAuth = $CI->session->userdata('CRUD_AUTH');
            if ($this->globalAccess == false &&
            !empty($crudAuth) &&
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
            	$_tmp = 'AND ';
            }
            
            $params['fields'] = $this->fields;
            $params['join'] = $this->join;
            $params['conditions'] = array($strCon, $aryVal);
            $rs = $this->dao->findFirst($params);
            if (!empty($rs)){
	            $_POST = array_merge($_POST, array('data' => $rs));
	
	            if (is_file($this->conf['theme_path'] . '/view.php')) {
	                require_once $this->conf['theme_path'] . '/view.php';
	            }
            }else{
            	$q = $this->queryString;
            	$q['xtype'] = 'index';
            	if (isset($q['key']))
            		unset($q['key']);
            	if (isset($q['auth_token']))
            		unset($q['auth_token']);
            	header("Location: ?" . http_build_query($q, '', '&'));
            }
        } else {
            $q = $this->queryString;
            $q['xtype'] = 'index';
            if (isset($q['key']))
                unset($q['key']);
            if (isset($q['auth_token']))
                unset($q['auth_token']);
            header("Location: ?" . http_build_query($q, '', '&'));
        }
    }



    /**
     *
     * View and download pdf by Aliraza ...
     */
    private function view_pdf() {
        $CI = & get_instance();
        $CI->load->model('crud_auth');
        $auth = $CI->crud_auth;
        if (isset($_GET['key'])) {
            $hook = Hook::singleton();
            if ($hook->isExisted('SCRUD_VIEW_FORM')) {
                $this->form = $hook->filter('SCRUD_VIEW_FORM', $this->form);
            }
            $params = array();
            $strCon = "";
            $aryVal = array();
            $_tmp = "";
            foreach ($this->primaryKey as $f) {
                $strCon .= $_tmp . " " . $f . ' = ?';
                $_tmp = " AND ";
                $aryVal[] = $_GET['key'][$f];
            }
            $crudAuth = $CI->session->userdata('CRUD_AUTH');
            if ($this->globalAccess == false &&
            !empty($crudAuth) &&
            in_array($this->conf['table'] . '.created_by', $this->fields) && 
            in_array($this->conf['table'] . '.assigned_to', $this->fields) ){
                $strCon .= ' ' . $_tmp . ' (' . $this->conf['table'] . '.created_by = '.$crudAuth['id'].' or ' . $this->conf['table'] . '.assigned_to = '.$crudAuth['id'].') ' ;
                $_tmp = 'AND ';
            }
            
            $params['fields'] = $this->fields;
            $params['join'] = $this->join;
            $params['conditions'] = array($strCon, $aryVal);

            $rs = $this->dao->findFirst($params);
            if (isset($_GET['key']['checklist.id'])) {
                $CI->db->select('form_data');
                $CI->db->from('checklist');
                $CI->db->where('id', $_GET['key']['checklist.id'] );
                $query = $CI->db->get();
                $value_result = unserialize($query->first_row()->form_data);
                $rs['data'] = $value_result;

                $CI->db->select('config');
                $CI->db->from('checklists');
                $CI->db->where('id', 2);
                $query = $CI->db->get();
                $fields_result = unserialize($query->first_row()->config);
                $this->form = $fields_result['form_elements'];
             }

            if (!empty($rs)){
                $_POST = array_merge($_POST, array('data' => $rs));
                require_once FCPATH.'application/views/admin/pdfs/jobs-pdf-template.php';
                exit;
            }else{
                $q = $this->queryString;
                $q['xtype'] = 'index';
                if (isset($q['key']))
                    unset($q['key']);
                if (isset($q['auth_token']))
                    unset($q['auth_token']);
                header("Location: ?" . http_build_query($q, '', '&'));
            }
        } else {
            $q = $this->queryString;
            $q['xtype'] = 'index';
            if (isset($q['key']))
                unset($q['key']);
            if (isset($q['auth_token']))
                unset($q['auth_token']);
            header("Location: ?" . http_build_query($q, '', '&'));
        }
    }

    private function validate() {
        $hook = Hook::singleton();
        foreach ($this->validate as $k => $v) {
            if (isset($v['rule'])) {
                $this->_validate($k, $v);
            } else {
                foreach ($v as $k1 => $v1) {
                    $this->_validate($k, $v1);
                }
            }
        }
        if ($hook->isExisted('SCRUD_VALIDATE')) {
            $this->errors = $hook->filter('SCRUD_VALIDATE', $this->errors);
        }

        return (count($this->errors) > 0) ? false : true;
    }

    private function _validate($k, $v) {
        $ary = explode('.', $k);
        $validation = Validation::singleton();
        if ($v['rule'] == 'notEmpty') {
            $v['required'] = true;
        }
        if (isset($v['required']) && $v['required'] === true) {
            if (@!$validation->notEmpty($this->data[$ary[0]][$ary[1]])) {
                $this->errors[$k][] = $v['message'];
            } else {
                if (!is_array($v['rule'])) {
                    if (trim($v['rule']) != '') {
                        if (!$validation->{$v['rule']}($this->data[$ary[0]][$ary[1]])) {
                            $this->errors[$k][] = $v['message'];
                        }
                    }
                } else {
                    if (trim($v['rule'][0]) != '') {
                        $params = array($this->data[$ary[0]][$ary[1]]);
                        foreach ($v['rule'] as $value) {
                            if ($value == $v['rule'][0])
                                continue;
                            $params[] = $value;
                        }
                        if (!call_user_func_array(array($validation, $v['rule'][0]), $params)) {
                            $this->errors[$k][] = $v['message'];
                        }
                    }
                }
            }
        } else if (!empty($this->data[$ary[0]][$ary[1]])) {
            if (!is_array($v['rule'])) {
                if (trim($v['rule']) != '') {
                    if (!$validation->{$v['rule']}($this->data[$ary[0]][$ary[1]])) {
                        $this->errors[$k][] = $v['message'];
                    }
                }
            } else {
                if (trim($v['rule'][0]) != '') {
                    $params = array($this->data[$ary[0]][$ary[1]]);
                    foreach ($v['rule'] as $value) {
                        if ($value == $v['rule'][0])
                            continue;
                        $params[] = $value;
                    }
                    if (!call_user_func_array(array($validation, $v['rule'][0]), $params)) {
                        $this->errors[$k][] = $v['message'];
                    }
                }
            }
        }
    }

    /**
     *
     * Enter description here ...
     */
    private function getToken() {
        $CI = & get_instance();
        $auth = $CI->session->userdata('auth_token_xtable');
        if (empty($auth)) {
            $string = 'HTTP_USER_AGENT=' . $_SERVER['HTTP_USER_AGENT'];
            $string .= 'time=' . time();
            $auth = md5($string);
            $CI->session->set_userdata('auth_token_xtable', $auth);
        } else {
            $auth = $CI->session->userdata('auth_token_xtable');
        }

        return $auth;
    }

    /**
     * Written by AliRaza
     * Load folder dir view
     * @return [void] 
     */
    private function folder_directory()
    {
        $CI = & get_instance();
        $Cfunctions = new Cfunctions;
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
        $CI->load->model('crud_auth');
        $auth = $CI->crud_auth;
        require_once $this->conf['theme_path'] . '/folder_dir.php';
    }

}
