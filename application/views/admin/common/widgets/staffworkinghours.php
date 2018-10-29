<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];


$postdata = http_build_query(
array(
        'operation' => 'staff_working_hours',
        'this_user_id'=>$this_user_id,
        'auth_token' =>$auth
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
                                        <span class="caption-subject font-red bold uppercase">Staff working Hours</span>
                                       
                                    </div>
                                    <div class="actions">
                                          <a  class="btn  green btn-circle btn-sm" href="<?php echo base_url(); ?>admin/profile/work_history?com_id=41">View More</a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> User </th>
                                                    <th>Date</th>
                                                    <th> Working Time </th>
                                                    <th> Lunch Time </th>
                                                    <th> Break Time </th>
                                                    <th> Meeting Time </th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            for($i = date('d'); $i >= 1; $i--){
                    $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                 }
$count = 0;
                foreach($dates as $date){
                 $result_working = $this->db->query("select u.id AS userid, CONCAT(u.user_first_name,' ', u.user_las_name) AS user_name, sum(case when status = 'working' then time_spent else 0 end) as working_time, sum(case when status = 'lunch' then time_spent else 0 end) as lunch_time, sum(case when status = 'break' then time_spent else 0 end) as break_time, sum(case when status = 'meeting' then time_spent else 0 end) as meeting_time from crud_users as u left join users_work_log as t on u.id = t.user_id WHERE time_start != '00:00:00' AND dated='".$date."' ".$user ." AND u.site_id = '".$CRUD_AUTH['site_id']."' AND u.group_id NOT IN (1,5) group by u.user_name LIMIT 5");

               //  echo $this->db->last_query() . '<br>';
                 foreach($result_working->result_array() as $results){
                  $count++;
                  $total_time = $results['working_time'] + $results['lunch_time'] + $results['break_time'];

                  if ($CRUD_AUTH['group']['dashboard'] == 1 ) {
                   echo "<tr><td>".$results['user_name']."</td><td>".date('d-m-Y',strtotime($date))."</td><td>".gmdate("H:i:s", $results['working_time'] - $results['meeting_time'])."</td><td>".gmdate("H:i:s", $results['lunch_time'])."</td><td>".gmdate("H:i:s", $results['break_time'])."</td><td>".gmdate("H:i:s", $results['meeting_time'])."</td><td>".gmdate("H:i:s", $total_time)."</td></tr>";
               } else if ($results['userid'] == $this_user_id) {
                   echo "<tr><td>".$results['user_name']."</td><td>".date('d-m-Y',strtotime($date))."</td><td>".gmdate("H:i:s", $results['working_time'] - $results['meeting_time'])."</td><td>".gmdate("H:i:s", $results['lunch_time'])."</td><td>".gmdate("H:i:s", $results['break_time'])."</td><td>".gmdate("H:i:s", $results['meeting_time'])."</td><td>".gmdate("H:i:s", $total_time)."</td></tr>";
               }
                  
                 }
                }
                                            /*
                                                foreach ($r->result as $key => $value) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $value->username; ?></td>
                                                       <td><?php echo  gmdate("H:i:s", $value->working_time); ?></td>
                                                        <td><?php echo $value->lunch_time; ?></td>
                                                        <td><?php echo $value->break_time; ?></td>
                                                        <td><?php echo $value->meeting_time; ?></td>
                                                    </tr>
                                                    <?php
                                                }*/
                                            ?>
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>

  