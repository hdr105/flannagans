<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];


if($CRUD_AUTH['group']['dashboard']==1){



?>

           <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo base_url(); ?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                        <div class="pull-right setingicon" style="padding-top:15px;">
                            <a href="#"><i class="icon-settings fa-2x"></i></a>
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Dashboard 
                        <small>dashboard & statistics</small>
                    </h3>
                    <div class="row">
                    
                        <div class="col-md-6 col-sm-6" id="openjobs"></div>
                        <div class="col-md-6 col-sm-6" id="deadlines"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 col-sm-6" id="staffholiday"></div>
                         <div class="col-md-6 col-sm-6" id="dueclientfee"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 col-sm-6" id="staffonbreak"></div>
                          <div class="col-md-6 col-sm-6" id="jobassignedtoeachstaff"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" id="staffworkinghours"></div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
<script type="text/javascript">
    $(document).ready(function(){
        var this_user = '<?php echo $this_user_id; ?>';
        getOpenJobs();
        deadlines();
        staffholiday();
        dueclientfee();
        staffonbreak();
        jobassignedtoeachstaff();
        staffworkinghours();
        function getOpenJobs() {
          $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/openjobs',
                success: function(data) {    
                   $('#openjobs').html(data);
                }
            });
        }
        function deadlines(){
         $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/deadlines',
                success: function(data) {    
                   $('#deadlines').html(data);
                }
            });   
        }
        function staffholiday(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffholiday',
                success: function(data) {    
                   $('#staffholiday').html(data);
                }
            }); 
        }
        function dueclientfee(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/dueclientfee',
                success: function(data) {    
                   $('#dueclientfee').html(data);
                }
            }); 
        }
        function staffonbreak(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffonbreak',
                success: function(data) {    
                   $('#staffonbreak').html(data);
                }
            });
        }
        function jobassignedtoeachstaff(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/jobassignedtoeachstaff',
                success: function(data) {    
                   $('#jobassignedtoeachstaff').html(data);
                }
            });
        }
        function staffworkinghours(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffworkinghours',
                success: function(data) {    
                   $('#staffworkinghours').html(data);
                }
            });
        }
        // auto updated
        setInterval(function(){
            getOpenJobs();
            deadlines();
            staffholiday();
            dueclientfee();
            staffonbreak();
            jobassignedtoeachstaff();
            staffworkinghours();
        }, 10000);


    });
</script>
<?php
}elseif($CRUD_AUTH['group']['dashboard']==2){
?>

            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->

                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.html">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                       <div class="pull-right setingicon" style="padding-top:15px;">
                            <a href="#"><i class="icon-settings fa-2x"></i></a>
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Dashboard 
                        <small>dashboard & statistics</small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->

                     <div class="row">
                    
                        <div class="col-md-6 col-sm-6" id="openjobs"></div>
                        <div class="col-md-6 col-sm-6" id="deadlines"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 col-sm-6">
                            <div class="portlet light calendar bordered">
                                <div class="portlet-title ">
                                    <div class="caption">
                                        <i class="icon-calendar font-green-sharp"></i>
                                        <span class="caption-subject font-green-sharp bold uppercase">Feeds</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="calendar_data">
                                        <div id="external-events"></div>
                                        <div id="calendar" class="has-toolbar"> </div>
                                    </div>
                                </div>
                            </div>
                         </div>
                         <div class="col-md-6 col-sm-6" id="dueclientfee"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 col-sm-6" id="available_holidays"></div>
                          <div class="col-md-6 col-sm-6" id="jobassignedtoeachstaff"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" id="staffworkinghours"></div>
                    </div>
                    
                  
                   
                  
                   
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <script type="text/javascript">
                
                    $(document).ready(function(){
                        $.ajax({
                            url: '<?php echo base_url(); ?>'+'webservices',
                            type: 'POST',
                            data: {operation:'lega_letters_list'},
                            success: function (response) { 
                                //var data = JSON.parse(response);
                                var d = response.result;
                                var html = '';
                                for (var i = 0; i < d.length; i++) {
                                    html = html + '<tr>'+
                                    '<td>'+
                                    d[i].letter_name+
                                    '</td>'+
                                    '<td>'+
                                    d[i].folder_name+
                                    '</td>'+
                                    '</tr>';
                                    
                                }
                                console.log(html);
                                $('#legal_letters_data').html(html)
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                    });
            </script>
            <script type="text/javascript">
    $(document).ready(function(){
        var this_user = '<?php echo $this_user_id; ?>';
        getOpenJobs();
        deadlines();
        staffholiday();
        dueclientfee();
        available_holidays();
        jobassignedtoeachstaff();
        staffworkinghours();
        function available_holidays(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/available_holidays',
                success: function(data) {    
                   $('#available_holidays').html(data);
                }
            });
        }
        function getOpenJobs() {
          $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/openjobs',
                success: function(data) {    
                   $('#openjobs').html(data);
                }
            });
        }
        function deadlines(){
         $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/deadlines',
                success: function(data) {    
                   $('#deadlines').html(data);
                }
            });   
        }
        function staffholiday(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffholiday',
                success: function(data) {    
                   $('#staffholiday').html(data);
                }
            }); 
        }
        function dueclientfee(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/dueclientfee',
                success: function(data) {    
                   $('#dueclientfee').html(data);
                }
            }); 
        }
        function staffonbreak(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffonbreak',
                success: function(data) {    
                   $('#staffonbreak').html(data);
                }
            });
        }
        function jobassignedtoeachstaff(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/jobassignedtoeachstaff',
                success: function(data) {    
                   $('#jobassignedtoeachstaff').html(data);
                }
            });
        }
        function staffworkinghours(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffworkinghours',
                success: function(data) {    
                   $('#staffworkinghours').html(data);
                }
            });
        }
        // auto updated
        setInterval(function(){
            getOpenJobs();
            deadlines();
            staffholiday();
            dueclientfee();
            available_holidays();
            jobassignedtoeachstaff();
            staffworkinghours();
        }, 10000);


    });
</script>
<?php
}elseif($CRUD_AUTH['group']['dashboard']==3){
?>
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.html">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Dashboard
                        <small>dashboard & statistics</small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <div class="row">
						<div class="col-md-6 col-sm-6" id="openDates"></div>
						<div class="col-md-6 col-sm-6" id="dueclientfee"></div>
                    </div>
                    <div class="row">
						<div class="col-md-6 col-sm-6" id="openServices"></div>
						<div class="col-md-6 col-sm-6" id="openTax"></div>
                        <!--<div class="col-md-6 col-sm-6">
                         <div class="col-md-6 col-sm-6" id="openServices"></div>
                         <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Taxation Dues</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> JOB </th>
                                                    <th> Client</th>
                                                    <th> Status </th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<tr>
													<td> Accounts Management </td>
													<td> Goldfield </td>
													<td> On Hold </td>
												</tr>
											</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
<script type="text/javascript">
    $(document).ready(function(){
        var this_user = '<?php echo $this_user_id; ?>';
        getServices();
        getDates();
		dueclientfee();
        openTax();

        function getServices() {
          $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/openServices',
                success: function(data) {    
                   $('#openServices').html(data);
                }
            });
        }
		
		function getDates() {
          $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/openDates',
                success: function(data) {    
                   $('#openDates').html(data);
                }
            });
        }
        
		function openTax() {
          $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/openTax',
                success: function(data) {    
                   $('#openTax').html(data);
                }
            });
        }

        function dueclientfee(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/dueclientfee',
                success: function(data) {    
                   $('#dueclientfee').html(data);
                }
            }); 
        }

        // auto updated
        setInterval(function(){
            getServices();
            getDates();
			dueclientfee();
            openTax();
        }, 10000);


    });
</script>
<?php
}
                $myCalIds = array();
                $sql = "SELECT * FROM calendar_types WHERE assigned_to = " . $this_user_id;
                $query = $this->db->query($sql);
                if (!empty($query)) {
                    foreach ($query->result_array() as $row) {
                        $myCalIds[] = $row['id'];
                    }
                }

        $calenars = array();
        $sql = 'SELECT * FROM calendar WHERE eventstatus IN ("'.implode('","', $myCalIds).'") ';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $calenars[] = $row;
            }
        }
        //print_r($calenars);

?>

                                <form method="post" action="?com_id=25&show=list" id="table" class="form-horizontal">
                                    <?php //require dirname(__FILE__) . '/search_form.php'; ?>
            <input type="hidden" name="src[page]" id="srcPage" value="1"/>
            <input type="hidden" name="src[limit]" id="srcLimit" value="9000"/>
            <input type="hidden" name="src[order_field]" id="srcOrder_field" value="calendar.id"/>
            <input type="hidden" name="src[order_type]" id="srcOrder_type" value="desc"/>
            <input type="hidden" name="selected_records_hdn" value="" />

            <input type="hidden" name="auth_token" id="auth_token" value=""/>

                                  <div class="row">
                                  </div>
                                  </form>
<script type="text/javascript">
    function availabilitySearch(){
        bootbox.dialog({
            message: availabilityFormContent(),
            title: "Search!",
            buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    search: {
                        label: 'Search ',
                        className: 'btn-success',
                        callback: function (data) {
                            crudSearch();
                            return false;
                        }
                    }
            }
        });
    }
    function availabilityFormContent(){
        var content = $("#table").clone(true);
        content.find('.row').html('');
        <?php
            $q = $this->queryString;
            $q['xtype'] = 'availabilityForm';
            if (isset($q['key']))
            unset($q['key']);
        ?>  
        $.ajax({
            type: 'GET',
            url: '?<?php echo http_build_query($q, '', '&'); ?>',
            success: function(data) {                                
                $(content).css('visibility','visible');
                $(content).attr('id','search');
                
                $(content).find('.row').html(data);
            }
        });
        return content ;
    }

   
     //RELATED MPDULE POPUP HERE STARTS
   function insertRelated(jData){
        quickCreateModal(jData);
    }
    //RELATED MODULE POPUP ENDS
    // Genereates quick create form content
    function quickCreateFormContent(jData){
        var content = $("#table").clone(true);
        content.find('.row').html('');
        var keyVal = '';
        if (jData.key != undefined) {
            keyVal = jData.key;
        }
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>'+'index.php/admin/scrud/browse?com_id='+jData.module_id+'&xtype=quickcreate'+keyVal+'&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll+'&pre_selected='+jData.pre_selected,
            success: function(data) {   
               
                var actionUrl = '<?php echo base_url(); ?>'+'index.php/admin/scrud/browse?com_id='+jData.module_id+'&xtype=quickcreateform';                            
                $(content).css('visibility','visible');
                $(content).attr('id','quickcreate');
                $(content).attr('action',actionUrl);
                $(content).find('.row').html(data);
            }
        });
        return content ;
    }
    function quickCreateModal(jData) {
        console.log('create model');
        console.log(jData);
        var modalClass = 'modal_'+jData.module_id;
        bootbox.dialog({
            className:modalClass,
            message: quickCreateFormContent(jData),
            title: "Quick Create Form!",
            buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreate: {
                        label: 'Create ',
                        className: 'btn-success',
                        callback: function (data) {
                            //Serialize form data
                            var frmdata = new FormData($("#quickcreate")[0]);
                            var validatorNode = validateform();
                            if(validatorNode==1){
                                var actionUrl = '<?php echo base_url(); ?>'+'index.php/admin/scrud/browse?com_id='+jData.module_id+'&xtype=quickcreateform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#quickcreate").attr("method"),
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) { 
                                        console.log(response);
                                        location.href = '<?php echo base_url(); ?>'+'admin/dashboard';
                                        //selectedRecordquickcreate(JSON.parse(response));
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                       console.log(textStatus, errorThrown);
                                    }
                                });
                                $('.'+modalClass).modal('hide');
                            }
                            return false;   
                        }
                    }
            }
        });
    }
String.prototype.capFirstChar = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}
$(document).ready(function() {
                        var data = [];
                        <?php
                            foreach ($calenars as $key => $value) {
                                $calendar = $value;

                                ?>
                                var cal = {};
                                cal['id'] = '<?php echo $calendar['id']; ?>';
                                cal['title'] = '<?php echo $calendar['subject']; ?>';
                                cal['start_date'] = '<?php echo $calendar['date_start']; ?>';
                                cal['end_date'] = '<?php echo $calendar['due_date']; ?>';
                                cal['start_time'] = '<?php echo $calendar['time_start']; ?>';
                                cal['end_time'] = '<?php echo $calendar['time_end']; ?>';
                                cal['backgroundColor'] = '#333333';
                                
                                data.push(cal);
                                <?php
                            }
                        ?>
                           console.log(data);
                        AppCalendar.init(data); 
                        $('title').html('<?php echo $this->title; ?>');
                        
                    });
</script>