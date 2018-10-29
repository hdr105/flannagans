<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];


$postdata = http_build_query(
array(
        'operation' => 'client_due_fee',
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
                                    <div class="caption">
                                        <i class="icon-cursor font-purple"></i>
                                        <span class="caption-subject font-purple bold uppercase">Due Client Fee</span>
                                    </div>
                                    <!-- <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm btn-circle green easy-pie-chart-reload">
                                             View Detail </a>
                                    </div> -->
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="easy-pie-chart">
                                                <div class="number transactions" data-percent="<?php echo $r->result->fee_over_due_lw?> ">
                                                    <span>+<?php echo $r->result->fee_over_due_lw?></span>% <canvas height="75" width="75"></canvas></div>
                                                    Over Due
                                                <!-- <a class="title" href="javascript:;"> Over Due
                                                    <i class="icon-arrow-right"></i>
                                                </a> -->
                                            </div>
                                        </div>
                                        <div class="margin-bottom-10 visible-sm"> </div>
                                        <div class="col-md-6">
                                            <div class="easy-pie-chart">
                                                <div class="number visits" data-percent="<?php echo $r->result->fee_rec_lw?>">
                                                    <span>+<?php echo $r->result->fee_rec_lw?></span>% <canvas height="75" width="75"></canvas></div>
                                                     Received
                                                <!-- <a class="title" href="javascript:;"> Received
                                                    <i class="icon-arrow-right"></i>
                                                </a> -->
                                            </div>
                                        </div>
                                      
                                       <div class="col-md-12">
                                        <div class="portlet-body">
                                    
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> Client </th>
                                                    <th> FEE </th>
                                                    <th> Due Date </th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($r->result->last_week_fee_detials as $key => $value) {

                                            
                                            ?>
                                            <tr>
                                                <td>
                                                <?php echo $value->title; ?>
                                                </td>
                                                <td>
                                                   <?php 



$this->db->select('currency_symbol');
$this->db->from('currencies');
$this->db->where('currency_status',3);
$query = $this->db->get();
$cur = $query->row_array();

echo $cur['currency_symbol'] . ' ';
echo $value->Agreed_Fee;  ?>
                                                </td>
                                                
                                                <td> 
                                                <?php    
                                                if (is_date($value->Agreed_Fee_Date)){
                                                    echo date($date_format_convert[__DATE_FORMAT__],strtotime($value->Agreed_Fee_Date));
                                                    }else{
                                                        echo '';
                                                    }
                                                    //echo $value->expected_end_date;
                                                ?>
                                                </td>
                                               
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                          
                                        </tbody></table><?=$r->result->query?>
                                    </div>
                                </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
<script type="text/javascript">
    $('.easy-pie-chart .number.transactions').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 3,
                barColor: App.getBrandColor('yellow')
            });

            $('.easy-pie-chart .number.visits').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 3,
                barColor: App.getBrandColor('green')
            });

            $('.easy-pie-chart .number.bounce').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 3,
                barColor: App.getBrandColor('red')
            });

            $('.easy-pie-chart-reload').click(function() {
                $('.easy-pie-chart .number').each(function() {
                    var newValue = Math.floor(100 * Math.random());
                    $(this).data('easyPieChart').update(newValue);
                    $('span', this).text(newValue);
                });
            });
</script>
  