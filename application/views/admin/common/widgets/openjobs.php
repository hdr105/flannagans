<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];



$postdata = http_build_query(
array(
        'operation' => 'open_jobs',
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
                                        <span class="caption-subject font-red bold uppercase">Open Jobs</span>
                                        
                                    </div>
                                    <div class="actions">
                                          <a  class="btn  green btn-circle btn-sm" href="<?php echo base_url(); ?>admin/scrud/browse?com_id=76">View More</a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                <script type="text/javascript">
                                    var week_count_all = [];
                                                    <?php
                                                        foreach ($r->result->week_count_all as $ck => $c) {
                                                            ?>
                                                            var val = '<?php echo $c->count; ?>';
                                                           
                                                            week_count_all.push(val);
                                                           
                                                            <?php
                                                        }
                                                    ?>
                                </script>
                                    <div class="row number-stats margin-bottom-30">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="stat-left">
                                                <div class="stat-chart">
                                                    <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                    <div id="open_jobs_all"><canvas width="113" height="55" style="display: inline-block; width: 113px; height: 55px; vertical-align: top;"></canvas></div>
                                                    <script type="text/javascript">
                                                    var c = [];
                                                    <?php
                                                        foreach ($r->result->weeks_count as $key => $value) {
                                                            ?>
                                                                c.push('<?php echo $value; ?>');
                                                            <?php
                                                        }
                                                    ?>
                                                        $("#open_jobs_all").sparkline(c, {
                                                            type: 'bar',
                                                            width: '100',
                                                            barWidth: 5,
                                                            height: '55',
                                                            barColor: '#35aa47',
                                                            negBarColor: '#e02222'
                                                        });
                                                    </script>
                                                </div>
                                                <div class="stat-number">
                                                    <div class="title"> Total </div>
                                                    <div class="number"> <?php echo $r->result->weeks_count_no; ?> </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th colspan="4"> JOB </th>
                                                    <th> STATUS </th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                             <?php
                                                foreach ($r->result->open_jobs as $key => $value) {
                                                    
                                                    ?>
                                                    <tr class="uppercase">
                                                        <td colspan="4"> <?php echo $value->title; ?> </td>
                                                        <td>  <span class="bold theme-font"><?php 

                                                    $job_status = array(
                                                        '1'=>'Open',
                                                        '2'=>'Close',
                                                        '3'=>'In Progress',
                                                        '4'=> 'On Hold',
                                                    );
                                                    echo $job_status[$value->job_status];
                                                   

                                                       

                                                        ?></span> </td>
                                                      
                                                    </tr>
                                                    <?php
                                                }
                                            ?>
                                            
                                         
                                        </tbody></table>
                                    </div>
                            </div>

  