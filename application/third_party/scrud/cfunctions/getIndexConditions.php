<?php
    function getIndexConditions($data = array()){
            $CI = & get_instance();
            $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
            global $date_format_convert;
            $this_user_id = $CRUD_AUTH['id'];

            $conditions = '';
            //echo "<pre>";print_r($data);
            switch ($data['comId']) {
                
                case '41' :
                case '42' :
                case '43' :
                case '44' :
                case '45' :
                    
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
                    $conditions = ' ' . $data['table'] . '.legal_entity = '.$legal_entity.' ' ;
                    // $strAnd = 'AND ';
                    //echo "<pre>working: ";print_r($conditions);exit;
                    break;

                case '81':
                   $mc = new ScrudDao('calendar_types', $CI->db);
                   $mcp['fields'] = array('id');
                   $mcp['conditions'] = array('assigned_to='.$this_user_id);
                   $mcrs = $mc->find($mcp);
                   $myCalIds = array();
                    foreach ($mcrs as $ck => $cv) {
                        $myCalIds[] = $cv['id'];
                    }

                    $conditions = ' invite_calendars IN ("'.implode('","', $myCalIds).'") ';

                break;
                case '25':
                   $mc = new ScrudDao('calendar_types', $CI->db);
                   $mcp['fields'] = array('id');
                   $mcp['conditions'] = array('assigned_to='.$this_user_id);
                   $mcrs = $mc->find($mcp);
                   $myCalIds = array();
                    foreach ($mcrs as $ck => $cv) {
                        $myCalIds[] = $cv['id'];
                    }
                   $conditions = ' eventstatus IN ("'.implode('","', $myCalIds).'") ';
                break;
                case '65':
                   $mc = new ScrudDao('crud_users', $CI->db);
                   $conditions = 'id!=1' ;
                break;
                case '32':
                   $mc = new ScrudDao('crud_users', $CI->db);
                   $conditions = "group_id!=1 AND group_id!=5" ;
                break;
                default:
                    # code...
                    break;
            }
            return $conditions;
    }

    

?>