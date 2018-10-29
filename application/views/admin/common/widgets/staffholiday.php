<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];


$postdata = http_build_query(
array(
        'operation' => 'staffholiday',
        'this_user_id'=>$this_user_id,
        'auth_token' =>$auth,
        'site_id'=>$CRUD_AUTH['site_id'],
        'dashboard'=>$CRUD_AUTH['group']['dashboard'],
    )
);
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
$context  = stream_context_create($opts);
$result = file_get_contents(base_url().'index.php/webservices/', false, $context);
$r = json_decode($result);


?>

<div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Staff Holidays Requests </span>
                                       
                                    </div>
                                    <div class="actions">
                                        
                                            
                                                <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=77"  class="btn  green  btn-circle btn-sm active">View More</a>
                                         
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> Name </th>
                                                    <th> Job </th>
                                                    <th> Duration </th>
                                                    <th> Request </th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($r->result as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php
                        $this->db->select('user_first_name,user_las_name');
                        $this->db->from('crud_users');
                        $this->db->where('id',$value->assigned_to);
                        $query = $this->db->get();
                        $user = $query->row_array();
                        $uf = ucwords($user['user_first_name']).' '.ucwords($user['user_las_name']);
                                                    echo $uf;

                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
$jobs = array();
$sql = "SELECT * FROM `jobs` WHERE assigned_to = '".$value->assigned_to."' LIMIT 1";
$query = $this->db->query($sql);
if (!empty($query)) {
                        foreach ($query->result_array() as $row) {
                            $jobs[] = $row;
                        }
                    }
                    $sdate = $jobs[0]['expected_start_date'];
                    if (is_date($sdate)){
                                                    $sdate =  date($date_format_convert[__DATE_FORMAT__],strtotime($sdate));
                                                    }else{
                                                        $sdate =  '';
                                                    }
                    echo '<b>'.$jobs[0]['title'] . '</b> - ' . $sdate ;
                                                        ?>

                    
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $date1 = new DateTime($value->Start_Date);
                                                $date2 = new DateTime($value->End_Date);
                                                $diff = $date1->diff($date2);
                                                echo ($diff->days+1) .' Days';
                                                        ?>
                                                    </td>
                                                    <td>
                                                       <a  href="<?php echo base_url(); ?>admin/scrud/browse?com_id=77&xtype=form&key[holiday_request.id]=<?php echo $value->id; ?>" class="btn  green  btn-circle btn-sm " >View</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            
                                          
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>

  