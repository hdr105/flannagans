<?php $CI = & get_instance();
$CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
$this_user_id = $CRUD_AUTH['id'];
foreach($CRUD_AUTH as $key => $value){
 if(is_array($value)){
  foreach($value as $inkey => $invalue){
   $$inkey = $invalue;
  }
 } else {
  $$key = $value;
 }
}
?>
<?php
global $date_format_convert;
$permissions = $auth->getPermissionType();
$comId = $CI->input->get('com_id');
$clsWidth = 50;
foreach ($this->colsCustom as $k => $v) {
	if ($k == 'action') {
		$matches = array();
		preg_match_all('/<a[^>]*>([^<]*)<\/a>/iU', $this->colsCustom['action'], $matches);
		
		if (!in_array(2, $permissions)) {
			unset($matches[0][1]);
		}
		
		if (!in_array(3, $permissions)) {
			unset($matches[0][2]);
		}
		
		$clsWidth = $clsWidth* count($matches[0]);
		$this->colsCustom[$k] = implode(' ', $matches[0]);
	}
}

foreach ($this->colsWidth as $k => $v) {
	if ($k == 'action') {
		$this->colsWidth[$k] =  $clsWidth;
	}
}

?>
<?php if (!empty($this->form)) { 


    ?>

                    <!-- BEGIN DASHBOARD STATS 1-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="row">
                                        <div class="col-md-6">
                                        
                                        </div>
                                        <div class="col-md-6">
                                            <div class="btn-group pull-right">
                                                    <button id="sample_editable_1_new" class="btn btn-sm blue  blue" onclick="newRecord();"> <?php echo $CI->lang->line('add'); ?>
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    
                                    <?php
                                    $q = $this->queryString;
                                    $q['src']['p'] = 1;
                                    $q['xtype'] = 'index';
                                    if (isset($q['xid']))
                                        unset($q['xid']);

                                    ?>
                                    <form method="post" action="?<?php echo http_build_query($q, '', '&'); ?>" id="table" class="form-horizontal">
                                    <?php //require dirname(__FILE__) . '/search_form.php'; ?>
            <input type="hidden" name="src[page]" id="srcPage" value="<?php echo $this->pageIndex; ?>"/>
            <input type="hidden" name="src[limit]" id="srcLimit" value="<?php echo $this->limit; ?>"/>
            <input type="hidden" name="src[order_field]" id="srcOrder_field" value="<?php echo $this->orderField; ?>"/>
            <input type="hidden" name="src[order_type]" id="srcOrder_type" value="<?php echo $this->orderType; ?>"/>
            <input type="hidden" name="selected_records_hdn" value="" />

<input type="hidden" name="auth_token" id="auth_token" value="<?php echo $this->getToken(); ?>"/>
    <?php
    
    ?>
                                    <table class="table table-striped table-bordered table-hover  " >
                                        <thead>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <?php
                                                $sDate = $this->results['calendar']['date_start'];
                                                $eDate = $this->results['calendar']['due_date'];
                                                $date1 = new DateTime($sDate);
                                                $date2 = new DateTime($eDate);
                                                $diff = $date1->diff($date2);
                                                

                                                $users = $this->results['calendar']['eventstatus'];
                                                $mc = new ScrudDao('calendar_types',$CI->db);
                                                $mcp['fields'] = array('id');
                                                $mcp['conditions'] = array('assigned_to = ? ANd status = ? ', array($this_user_id,3));
                                                $mcprs = $mc->find($mcp);
                                                $my_calendar_id = $mcprs[0]['id'];

                                                foreach ($users as $key => $value) {

                                                    $c = new ScrudDao('calendar_types',$CI->db);
                                                    $cp['fields'] = array('name','assigned_to');
                                                    $cp['conditions'] = 'id='.$value;
                                                    $crs = $c->find($cp);
                                                    
                                                    $o = new ScrudDao('crud_users',$CI->db);
                                                    $op['fields'] = array('user_first_name','user_las_name');
                                                    $op['conditions'] = 'id='.$crs[0]['assigned_to'];
                                                    $ors = $o->find($op);
                                                    $fn = ucwords($ors[0]['user_first_name']).' '.ucwords($ors[0]['user_las_name']);
                                                    echo '<th>' .$crs[0]['name'] .' ('.$fn.')'. '</th>';
                                                }
                                                ?>
                                                <th style="width: 20px !important;">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i=0; $i < $diff->days ; $i++) { 

                                                    

                                                    $thisDate =  '';
                                                    if (is_date($sDate)){
                                                                $thisDate = date($date_format_convert[__DATE_FORMAT__],strtotime($sDate. ' + '.$i.' days'));
                                                    }else{
                                                                    $thisDate =  '';
                                                    }
                                                ?>
                                            
                                                <tr id="row_<?php echo $i; ?>">
                                                <td><?php 
                                                
                                               $dbDate = '';
                                               if (is_date($sDate)){
                                                                $dbDate = date($date_format_convert[__DB_DATE_FORMAT__],strtotime($sDate. ' + '.$i.' days'));
                                                }else{
                                                                    $dbDate =  '';
                                                }
                                                   echo $thisDate;
                                                 ?></td>
                                                <?php
                                                    foreach ($users as $key => $value) {
                                                    ?>
                                                    <td>
                                                        <?php
                                                       
                                                            $e = new ScrudDao('calendar',$CI->db);
                                                            $ep['fields'] = array('subject','time_start','time_end');
                                                            $ep['conditions'] = 'eventstatus = "'.$value.'" AND date_start="'.$dbDate . '"';
                                                            $rs = $e->find($ep);
                                                            
                                                            foreach ($rs as $rk => $rv) {
                                                            ?>

                                                            <?php
                                                                echo '<p>';
                                                                    echo '<strong>' .$rv['subject']. '</strong>';
                                                                    echo '<br>';
                                                                    echo 'Starts at: ' .$rv['time_start'];
                                                                    echo '<br>';
                                                                    echo 'Ends at: ' .$rv['time_end'];
                                                                echo '</p>';
                                                            }
                                                        ?>
                                                    </td>

                                                    <?php
                                                }
                                                ?>
                                                <td><a href="javascript:;" onclick="insertRelated('<?php echo $i; ?>');" class="btn btn-icon-only blue " ><i class="fa fa-calendar"></i></a></td>
                                                <input type="hidden" name="presel[start_date]" value="<?php echo $thisDate; ?>">
                                                <input type="hidden" name="presel[calendar_id]" value="<?php echo implode(',', $users); ?>">
                                                <input type="hidden" name="presel[my_calendar_id]" value="<?php echo $my_calendar_id; ?>">
                                                </tr>
                                            <?php
                                            }
                                            ?>   
                                        </tbody>
                                        
                                    </table>
                                    
                                    </form>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <!-- END OF ROW -->
                    <div class="clearfix"></div>
                    <!-- END DASHBOARD STATS 1-->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            
        </div>
        <!-- END CONTAINER -->
<?php } ?>
    <script>
    /*$('#select_all').on('change',function(){
        if($('#select_all').is(':checked')) {
            $('input[name="selected_records"]').each(function(){
                alert($(this).val());
            });
        }
        else {
         alert('off');
        }
    });*/
    function insertRelated(id){
        var preSel = [];
        preSel['start_date'] = $("#row_"+id).find("input[name='presel[start_date]']").val();
        preSel['calendar_id'] = $("#row_"+id).find("input[name='presel[calendar_id]']").val();
        preSel['my_calendar_id'] = $("#row_"+id).find("input[name='presel[my_calendar_id]']").val();
        var pre_selected = 'date_start='+preSel['start_date']+'|invite_calendars='+preSel['calendar_id']+'|eventstatus='+preSel['my_calendar_id'];
        var jData = {};
        jData['module_id'] = '<?php echo $_GET['com_id']; ?>';
        jData['module_key'] = 'id';
        jData['module_value'] = 'subject';
        jData['hidden_controll'] = '';
        jData['visible_controll'] = '';
        jData['pre_selected'] = pre_selected;
        //console.log(jData);
        quickCreateModal(jData);

    }
    function searchFormContent(){
        var content = $("#table").clone(true);
        content.find('.dataTables_wrapper').remove();
        <?php
            $q = $this->queryString;
            $q['xtype'] = 'modalform';
            if (isset($q['key']))
            unset($q['key']);
        ?>  
        $.ajax({
            type: 'GET',
            url: '?<?php echo http_build_query($q, '', '&'); ?>',
            success: function(data) {                                
                $(content).css('visibility','visible');
                $(content).attr('id','search');
                
                $(content).html(data);
            }
        });
        return content ;
    }
    function searchModal() {
        bootbox.dialog({
            message: searchFormContent(),
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
    function massEdithFormContent(){
        
        var content = $("#table").clone();
        content.find('.dataTables_wrapper').remove();
        <?php
            $q = $this->queryString;
            $q['xtype'] = 'massedit';
            if (isset($q['key']))
            unset($q['key']);
        ?>  
        $.ajax({
            type: 'GET',
            url: '?<?php echo http_build_query($q, '', '&'); ?>',
            success: function(data) {   

                <?php
                    $q = $this->queryString;
                    $q['src']['p'] = 1;
                    $q['xtype'] = 'massupdate';
                    if (isset($q['xid']))
                    unset($q['xid']);
                ?>
                var actionUrl = '?<?php echo http_build_query($q, '', '&'); ?>';

                $(content).css('visibility','visible');
                $(content).attr('id','massedit');
                $(content).attr('action',actionUrl);
                
                $(content).append(data);
            }
        });
        
        return content ;
    }
    function massEditModal() {
        var recordIds = [];
        $('input[name="selected_records"]').each(function(){
            if ($(this).is(':checked')) {
                recordIds.push($(this).val());
            }  
        });
        var selected_ids = recordIds.join();
        $('input[name="selected_records_hdn"]').val(selected_ids);

        bootbox.dialog({
            message: massEdithFormContent(),
            title: "Update!",
            buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    update: {
                        label: 'Update ',
                        className: 'btn-success',
                        callback: function (data) {
                            $('#massedit').submit();
                            return false;
                        }
                    }
            }
        });
    }
    // Genereates quick create form content
    function quickCreateFormContent(jData){
        
        var content = $("#table").clone(true);
        content.find('table').remove();
        <?php
            $q = $this->queryString;
            $q['xtype'] = 'quickcreate';
            if (isset($q['key']))
            unset($q['key']);
        ?>  //quickcreateform
        $.ajax({
            type: 'GET',
            url: '?com_id='+jData.module_id+'&xtype=quickcreate&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll+'&pre_selected='+jData.pre_selected,
            success: function(data) {   
                <?php
                    $q = $this->queryString;
                    $q['src']['p'] = 1;
                    $q['xtype'] = 'quickcreateform';
                    $q['com_id'] = 23;
                    if (isset($q['xid']))
                    unset($q['xid']);
                ?>
                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateform';                            
                $(content).css('visibility','visible');
                $(content).attr('id','quickcreate');
                $(content).attr('action',actionUrl);
                $(content).append($('<div clas="form-body"></div>').html(data));
            }
        });
        return content ;
    }
    function quickCreateModal(jData) {
        console.log(jData);
        var modalClass = 'modal_' + jData.module_id;
        bootbox.dialog({
            message: quickCreateFormContent(jData),
            title: "Quick Create Form!",
            className:modalClass,
            size:"large",
            buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreate: {
                        label: 'Create ',
                        className: 'btn-success',
                        callback: function (data) {
                            var url = '<?php echo base_url(); ?>admin/scrud/browse?com_id='+jData.module_id+'&xtype=quickcreateform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll;
                            var frmdata = new FormData($("#quickcreate")[0]);
                                
                            $.ajax({
                                    url: url,
                                    type: $("#quickcreate").attr("method"),
                                    dataType: "JSON",
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (data, status)
                                    {
                                       
                                        //selectedRecord(data.return_data);
                                        
                                        $('.'+modalClass).modal('hide');
                                        location.href = '<?php echo base_url(); ?>'+'admin/scrud/browse?com_id=25';
                                    },
                                    error: function (xhr, desc, err)
                                    {


                                    }
                            });        

                            return false;
                        }
                    }
            }
        });
    }

                    function newRecord() {
<?php
$q = $this->queryString;
$q['xtype'] = 'form';
if (isset($q['key']))
    unset($q['key']);
?>
                        window.location = "?<?php echo http_build_query($q, '', '&'); ?>";
                    }

                    function __view(id) {
<?php
$q = $this->queryString;
$q['xtype'] = 'view';
if (isset($q['key']))
    unset($q['key']);
?>
                        window.location = "?<?php echo http_build_query($q, '', '&'); ?>&" + id;
                    }

                    function __edit(id) {
<?php
$q = $this->queryString;
$q['xtype'] = 'form';
if (isset($q['key']))
    unset($q['key']);
?>
                        window.location = "?<?php echo http_build_query($q, '', '&'); ?>&" + id;
                    }

                    function __delete(id) {
<?php
$q = $this->queryString;
$q['xtype'] = 'delconfirm';
if (isset($q['key']))
    unset($q['key']);
?>
                        window.location = "?<?php echo http_build_query($q, '', '&'); ?>&" + id;
                    }

                    function order(field) {
                        var oldField = document.getElementById('srcOrder_field').value;
                        var oldType = document.getElementById('srcOrder_type').value;
<?php
$q = $this->queryString;
$q['xtype'] = 'index';
if (isset($q['key']))
    unset($q['key']);
?>
                        var url = "?<?php echo http_build_query($q, '', '&'); ?>";
                        url += "&src[o]=" + field;
                        if (field == oldField) {
                            if (oldType == 'asc') {
                                url += "&src[t]=desc"
                            } else {
                                url += "&src[t]=asc"
                            }
                        } else {
                            url += "&src[t]=asc"
                        }
                        window.location = url;
                    }
                    $(document).ready(function() {
                        $('title').html('<?php echo $this->title; ?>');
                        //$('table > tbody > tr').each(function(){
                        //$($(this).find('td:last > input').get(0)).hide();
                        //$($(this).find('td:last > input').get(1)).hide();
                        //$($(this).find('td:last > input').get(2)).hide();
                        //});
                    });
</script>
<iframe src="" id="crudIframe" height="0" width="0" style="width: 0px; line-height:0px; height: 0px; border: 0px; padding: 0px; margin: 0px; display:none;"></iframe>
<script>
            function crudSearch() {
                document.getElementById('srcPage').value = 1;
                document.getElementById('search').submit();
            }
            function crudExport(){
        $('#crudIframe').attr({src:'<?php echo base_url(); ?>index.php/admin/scrud/exportcsv?com_id=<?php echo $comId; ?>&xtype=exportcsv'});
    }
    function crudExportAll() {
        $('#crudIframe').attr({src: '<?php echo base_url(); ?>index.php/admin/scrud/exportcsv?com_id=<?php echo $comId; ?>&xtype=exportcsvall'});
    }
</script>