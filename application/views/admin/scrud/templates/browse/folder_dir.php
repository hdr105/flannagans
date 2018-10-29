<?php $CI = & get_instance();
$CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
foreach($CRUD_AUTH as $key => $value){
 if(is_array($value)){
  foreach($value as $inkey => $invalue){
   $$inkey = $invalue;
  }
 } else {
  $$key = $value;
 }
}
        

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
// //Custom Functions Calls For LIST VIEW START
// if(!empty($this->CfunctionsArray)){   
//     $Cfunctions = new Cfunctions;
//     foreach($this->CfunctionsArray as $function_name){
//         $func_name = explode(':',$function_name);
//         if($func_name[0]=='list-functions')
//             $Cfunctions->$func_name[1]();
//     }
// }
// //Custom Functions Calls For LIST VIEW START

$keyval0 = '';
$keyval1 = '';
$keyval2 = '';
$keyval3 = '';
$keyval4 = '';
$keyval5 = '';
if(isset($_GET['key']['business.id']) && $keyid = $_GET['key']['business.id']){
    $keyval0 = "&key[business.id]=".$keyid;
    $keyval1 = "&key[forms.bid]=".$keyid;
    $keyval2 = "&key[codes.bid]=".$keyid;
    $keyval3 = "&key[compliance.bid]=".$keyid;
    $keyval4 = "&key[services.bid]=".$keyid;
    $keyval5 = "&key[fee.bid]=".$keyid;
}
?>
<?php if (!empty($this->form)) { ?>

                    <!-- BEGIN DASHBOARD STATS 1-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="pull-left">
                                        
                                                <div class="btn-group">
                                                    <button class="btn btn-sm green  dropdown-toggle" data-toggle="dropdown">Tools
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                    <?php if (!empty($this->results)) { ?>
                                                        <li>
                                                            <a href="javascript:;" onclick="crudExport();">
                                                                <i class="fa fa-file-excel-o"></i> <?php echo $CI->lang->line('export_csv');?> </a>
                                                        </li>
                                                    <?php } else { ?>
                                                        <li>
                                                            <a href="javascript:;" class=" disabled" onclick="crudExport();">
                                                                <i class="fa fa-file-excel-o"></i> <?php echo $CI->lang->line('export_csv');?> </a>
                                                        </li>
                                                    <?php } ?>
                                                        <li>
                                                            <a href="javascript:;" onclick="crudExportAll();">
                                                                <i class="fa fa-file-excel-o"></i> <?php echo $CI->lang->line('export_csv_all');?> </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class=" pull-right">
                                                <?php
                                                if (in_array(1, $auth->getPermissionType('29'))) {
                                                ?>
                                                <button id="sample_editable_1_new" class="btn btn-sm blue  blue" onclick="newRecord();"> <?php echo $CI->lang->line('add'); ?> Folder
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <?php }?>
                                                <?php if (in_array(1, $auth->getPermissionType('30'))) { ?>
                                                <a href="<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=30&xtype=form" id="sample_editable_1_new" class="btn btn-sm blue  blue" onclick="newRecord();"> <?php echo $CI->lang->line('add'); ?> Document
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
<!-- ////////////////////////////////////////////  -->                                   
                                    <?php
                                    $q = $this->queryString;
                                    $q['src']['p'] = 1;
                                    $q['xtype'] = 'index';
                                    if (isset($q['xid']))
                                        unset($q['xid']);
                                    ?>
                                    <form method="post" action="?<?php echo http_build_query($q, '', '&'); ?>" id="table"  class="form-horizontal">
                                    <?php //require dirname(__FILE__) . '/search_form.php'; ?>
                                        <input type="hidden" name="src[page]" id="srcPage" value="<?php echo $this->pageIndex; ?>"/>
                                        <input type="hidden" name="src[limit]" id="srcLimit" value="<?php echo $this->limit; ?>"/>
                                        <input type="hidden" name="src[order_field]" id="srcOrder_field" value="<?php echo $this->orderField; ?>"/>
                                        <input type="hidden" name="src[order_type]" id="srcOrder_type" value="<?php echo $this->orderType; ?>"/>
                                        <input type="hidden" name="selected_records_hdn" value="" />
                                        <input type="hidden" name="auth_token" id="auth_token" value="<?php echo $this->getToken(); ?>"/>


                                        


                                    
                                    </form>
                                    
                                    
                                    
        
                                
                                
                            
        <?php } ?>
                                    
    <div class="row">
                                    <div class="col-md-12">
                                    <?php 
                                        //GET ALL FOLDER DIRECTORIES
                                            $folder_data = $Cfunctions->get_folder_dir($CRUD_AUTH['id']);
                                            // echo '<pre>';
                                            // print_r($folder_data);
                                            // die;
                                        ?>
                                        <div class="portlet box">
                                            
                                            <div class="portlet-body">
                                            /
                                                <?php echo '<div id="cTree">'. $Cfunctions->array2jstree($folder_data) .'</div>'; ?>
                                            </div>
                                        </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                 <div class="clearfix"></div>
                    <!-- END DASHBOARD STATS 1-->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            
        </div>
        <!-- END CONTAINER -->
        <script>
        //New Script START
        function massDelFormContent(){
            var content = $("#table").clone();
            content.find('.dataTables_wrapper').remove();
            <?php
                $q = $this->queryString;
                $q['src']['p'] = 1;
                $q['xtype'] = 'massdelete';
                if (isset($q['xid']))
                unset($q['xid']);
            ?>
            var actionUrl = '?<?php echo http_build_query($q, '', '&'); ?>';
            $(content).css('visibility','visible');
            $(content).attr('id','massdelete');
            $(content).attr('action',actionUrl);            
            $(content).append('<p>Are you sure want to delete selected records?</p>');
            return content ;
        }
        
        function massDelModal(){
            var recordIds = [];
            $('input[name="selected_records"]').each(function(){
                if ($(this).is(':checked')) {
                    recordIds.push($(this).val());
                }  
            });
            var selected_ids = recordIds.join();
            if (selected_ids == '') {
                bootbox.alert("Please select at least one record.", function() {
                  
                });
            } else {
                $('input[name="selected_records_hdn"]').val(selected_ids);
                bootbox.dialog({
                    message: massDelFormContent(),
                    title: "Delete!",
                    buttons: {
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-warning'
                        },
                        update: {
                            label: 'Yes ',
                            className: 'btn-success',
                            callback: function (data) {
                                $('#massdelete').submit();
                                return false;
                            }
                        }
                    }
                }); 
                
            }
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
            if (selected_ids == '') {
                bootbox.alert("Please select at least one record.", function() {
                  
                });
            } else {
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
        }
        // GET JSON FROM DATA START
  function selectedRecordArray(jsondata) {
   $.each(jsondata, function (i, elem) {
    selectedRecordquickcreate(elem);
   });
  }
  // GET JSON FROM DATA END

        /*$('data[business][sage]').click(function(){
            var thisVal = $(this).val();
            //var rowId = $('dataBusinessDate_added_sage').parent().parent().parent().parent().parent().attr("id");
            alert(thisVal);
        });*/
        /**/
        //CHNAGES BY KAMRAN SAB START
        function selectedRecord(data){
            if (data.module_value == '') {
                showRelatedTabularData(data)
            } else {
                var recordId = data.selected_id;
                var recordValue = $('input[name="record_viewfield_'+data.selected_id+'"]').val();
                $('#'+data.hidden_controll).val(recordId);
                $('#'+data.visible_controll).val(recordValue);
                $('.modal_'+data.module_id).modal('hide');
            }
            
        }
        
        function showRelatedTabularData(jData){
            
            if($('#'+jData.hidden_controll).val()){
                var preSelectedRecords = $('#'+jData.hidden_controll).val();
                var selectedRecords = preSelectedRecords.split(',');
                selectedRecords.push(jData.selected_id);
                $('#'+jData.hidden_controll).val(selectedRecords.join());
                $.ajax({
                    type: 'POST',
                    url: '?com_id='+jData.module_id+'&xtype=summary_view_datalist',
                    data:{module_id:jData.module_id, module_key:'id', module_value:'', hidden_controll:jData.hidden_controll, visible_controll:jData.visible_controll, selected_id:selectedRecords},
                    success: function(data) {       
                        $('#'+jData.visible_controll).html(data);
                        //$('.'+modalClass).modal('hide');
                    }
                });
                
                var uniqueNames = [];
                $.each(selectedRecords, function(i, el){
                    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                });
                $('#'+jData.hidden_controll).val(uniqueNames.join());
            } else {
                var selectedRecords = [];
                selectedRecords.push(jData.selected_id);
                $('#'+jData.hidden_controll).val(selectedRecords.join());
                $.ajax({
                    type: 'POST',
                    url: '?com_id='+jData.module_id+'&xtype=summary_view_datalist',
                    data:{module_id:jData.module_id, module_key:'id', module_value:'', hidden_controll:jData.hidden_controll, visible_controll:jData.visible_controll, selected_id:selectedRecords},
                    success: function(data) { 
                        $('#'+jData.visible_controll).append(data);
                        console.log(data);                 
                         //$('.'+modalClass).modal('hide');
                    }
                });
                var uniqueNames = [];
                $.each(selectedRecords, function(i, el){
                    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                });
                $('#'+jData.hidden_controll).val(uniqueNames.join());
            }
        }

        
        function summaryView(jData){
            summaryViewModal(jData);
        }
        
        function summaryViewContent(jData){
            var content = $("#table").clone(true);
            content.find('.dataTables_wrapper').html('');
            <?php
                $q = $this->queryString;
                $q['xtype'] = 'summary';
                if (isset($q['key']))
                unset($q['key']);
            ?>  //quickcreateform
            $.ajax({
                type: 'GET',
                url: '?com_id='+jData.module_id+'&xtype=summary&module_key='+jData.module_key+'&module_value='+jData.module_value+'&condition='+jData.condition+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll,
                success: function(data) {   
                    <?php
                        $q = $this->queryString;
                        $q['src']['p'] = 1;
                        $q['xtype'] = 'summary';
                        $q['com_id'] = 'id';
                        if (isset($q['xid']))
                        unset($q['xid']);
                    ?>
                    var actionUrl = '?com_id='+jData.module_id+'&xtype=summary';                             
                    $(content).css('visibility','visible');
                    $(content).attr('id','quickcreate');
                    $(content).attr('action',actionUrl);
                    $(content).append('<div class="form-body"></div>');
                    $(content).find('.form-body').html(data);
                    
                    var table = $('#dtbl_'+jData.hidden_controll);
                    table.dataTable({
                    // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "No data available in table",
                        "info": "Showing _START_ to _END_ of _TOTAL_ records",
                        "infoEmpty": "No records found",
                        "infoFiltered": "(filtered1 from _MAX_ total records)",
                        "lengthMenu": "Show _MENU_",
                        "search": "Search:",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "previous":"Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },
                    "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                    
                    "columnDefs": [ {
                        "targets": 0,
                        "orderable": false,
                        "searchable": false
                    }],

                    "lengthMenu": [
                        [5, 15, 20, -1],
                        [5, 15, 20, "All"] // change per page values here
                    ],
                    // set the initial value
                    "pageLength": 5,            
                    "pagingType": "bootstrap_full_number",
                    "columnDefs": [{  // set default column settings
                        'orderable': false,
                        'targets': [0],
                        "autoWidth":true
                    }, {
                        "searchable": true,
                        "targets": [0]
                    }],
                    "order": [
                        [0, "asc"]
                    ] // set first column as a default sort by asc
                });
                // Apply the search

                }
            });
            return content ;
        }
        
        function summaryViewModal(jData) {
            var modalClass = 'modal_' + jData.module_id;
            bootbox.dialog({
                message: summaryViewContent(jData),
                title: "Select Record",
                className:modalClass,
                size:"large",
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreate: {
                        label: 'Select',
                        className: 'btn-success',
                        callback: function (data) {
                            
                            return false;
                        }
                    }
                }
            });
        }
        
    //RELATED MPDULE POPUP HERE STARTS
    function insertRelated(jData){
        quickCreateModal(jData);
    }
    //RELATED MODULE POPUP ENDS
    // Genereates quick create form content
    function quickCreateFormContent(jData){
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
                url: '?com_id='+jData.module_id+'&xtype=quickcreate&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll,
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
                    $(content).append(data);
                }
            });
            return content ;
    }
    function quickCreateModal(jData) {
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
                                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#quickcreate").attr("method"),
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) { 
                                        console.log(response);
                                        selectedRecordquickcreate(JSON.parse(response));
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
    
    function selectedRecordquickcreate(data){
        if (data.module_value == '') {
            showRelatedTabularData(data)
        } else {
            var recordId = data.selected_id;//Sbah Changes here
            var recordValue = data.module_value;
            $('#'+data.hidden_controll).val(recordId);
            $('#'+data.visible_controll).val(recordValue);
             //$('.'+modalClass).modal('hide');
             console.log(data);
        }
    }
    //CHNAGES BY KAMRAN SAB END
        function delRecordsl(){  
            var recordIds = [];
            $('input[name="selected_record"]:checked').each(function(){
                recordIds.push($(this).val());  
            });
            if (recordIds.length ===0 ) {
                var strAlertSuccess = '<div class="alert alert-danger" style="position: fixed; left:40%;  top:50%; width:300px; height:60px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">' +
                '<button data-dismiss="alert" class="close" type="button">×</button>' +
                'Please select at least one record.' +
                '</div>';
                var alertSuccess = $(strAlertSuccess).appendTo('body');
                alertSuccess.show();

                 setTimeout(function(){ 
                    alertSuccess.remove();
                },5000);
            } else {
                var prompt = confirm("Are you sure to delete selected records?");
                if (prompt) {
                    var selected_ids = recordIds.join();
                    $('#selected_ids').val(selected_ids);
                    
                    document.getElementById('massdelete').submit();
                }
            } 
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
        function __editdoc(id) {
            <?php
            $q = $this->queryString;
            $q['com_id'] = '30';
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

        function __deletedoc(id) {
            <?php
            $q = $this->queryString;
            $q['com_id'] = '30';
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
    <style type="text/css">
        .modal-dialog{
            width:600px;
        }
    </style>
        <script src="<?php echo base_url(); ?>media/js/mfunctions/mfunctions.js" type="text/javascript"></script>
<style>
.FixedHeightContainer
    {
        max-height: 150px;
        padding:10px;
        overflow:auto;
        background:#fff;
    }
</style>
<script>
    //Toggle Password

    (function ($) {
        $.toggleShowPassword = function (options) {
            var settings = $.extend({
                field: "#password",
                control: "#toggle_show_password",
            }, options);

            var control = $(settings.control);
            var field = $(settings.field)

            control.bind('click', function () {
                if (control.is(':checked')) {
                    field.attr('type', 'text');
                } else {
                    field.attr('type', 'password');
                }
            })
        };
    }(jQuery));

    ///////////////
<?php
if(isset($_GET['$c_id'])){
    $table = explode(".",key($_GET['key']));
}else{
    $CI->db->select('component_table');
    $CI->db->from('crud_components');
    $CI->db->where('id',$_GET['com_id']);
    $query = $CI->db->get();
    $table = $query->row_array();
    $table[0] = $table['component_table'];
}
?>
    $.toggleShowPassword({
        field: '#data<?=ucwords($table[0])?>User_password',
        control: '#toggle_data<?=ucwords($table[0])?>User_password'
    }); 


 

    //Unique data in Related Module
    function getExistingData(existcontact,newcontact,com_id,field){
        var resp = null;
        $.ajax({
            type: 'POST',
            'async': false,
            data : { exists : existcontact, newcontact : newcontact, com_id:com_id, field:field },
            url: 'status?cfun=getDetails',
            success: function(data) {   
                resp = data;
            }
        });
        return resp;
    };    

    //FILTERS STARTS
    $('#filters').change(function() {
        // set the window's location property to the value of the option the user has selected
        var new_filter = $('#filters option:selected').val();
        if (new_filter == 'new') {
            window.location = '<?php echo base_url(); ?>index.php/admin/filters?comid='+<?php echo $comId; ?>;
        } else {
            window.location = "?<?php echo http_build_query($q, '', '&'); ?>&f="+new_filter;
        }
    });  
 //FILTERS ENDS
</script>
 <script>
    $('#cTree').jstree({
           "types" : {
            "default" : {
              "icon" : "fa fa-folder icon-state-warning"
            },
          },
          "contextmenu":{         
                "items": customMenu
            },
            "plugins" : [ "contextmenu", "sort",  "state", "dnd", "types" ]
        
});
//Related Module Function
function downloadPDF(jdata){
    var key_value = '<?php echo $_GET['key'][key($_GET['key'])];?>';
    window.location="<?=base_url()?>admin/pdfs?id="+jdata.selected_id+"&bid="+key_value+"&com_id="+jdata.module_id;

}; 
function customMenu($node) {
    var tree = $("#cTree").jstree(true);
    var items = {
    <?php if (in_array(2, $permissions)) { ?>
       "View": {
            "separator_before": false,
            "separator_after": false,
            "label": "View",
            "action": function (obj) { 
                if (JSON.stringify($node['data']['jstree']['file_name'])) {
                    var file_name = JSON.stringify($node['data']['jstree']['file_name']);
                    //window.location="<?=base_url()?>media/files/"+file_name.replace(/\"/g, "");
                    window.open("<?=base_url()?>media/files/"+file_name.replace(/\"/g, ""),'_blank')
                }
                if (JSON.stringify($node['data']['jstree']['file_orginal_id'])) {
                    var key_value = '<?php echo $_GET['key'][key($_GET['key'])];?>';
                    var file_name = JSON.stringify($node['data']['jstree']['file_orginal_id']);
                    window.open("<?=base_url()?>admin/pdfs?id="+file_name+"="+key_value+"&com_id=75&action=view",'_blank');
                    //window.location="<?=base_url()?>admin/pdfs?id="+file_name+"="+key_value+"&com_id=75";
                }
            }
        },
    "Edit": {
        "separator_before": false,
        "separator_after": false,
        "label": "Edit",
        "action": function (obj) { 
            console.log(JSON.stringify($node));
            if (JSON.stringify($node['data']['jstree']['file_id'])) {
                var com_id = JSON.stringify($node['data']['jstree']['file_id']);
                __editdoc('key[crm_documents.id]='+com_id);
            }
            if (JSON.stringify($node['data']['jstree']['folder_id'])) {
                var com_id = JSON.stringify($node['data']['jstree']['folder_id']);
                __edit('key[doc_folders.id]='+com_id);
            }
        }
    },
    <?php } ?>
    <?php if (in_array(3, $permissions)) { ?>
    "Delete": {
        "separator_before": false,
        "separator_after": false,
        "label": "Delete",
        "action": function (obj) { 
            console.log(JSON.stringify($node));
            if (JSON.stringify($node['data']['jstree']['file_id'])) {
                var com_id = JSON.stringify($node['data']['jstree']['file_id']);
                __deletedoc('key[crm_documents.id]='+com_id);
            }
            if (JSON.stringify($node['data']['jstree']['folder_id'])) {
                var com_id = JSON.stringify($node['data']['jstree']['folder_id']);
                __delete('key[doc_folders.id]='+com_id);
            }
        }
    },
    <?php } ?>
    "Email": {
        "separator_before": false,
        "separator_after": false,
        "label": "Email",
        "action": function (obj) { 
            //console.log(JSON.stringify($node));
            if (JSON.stringify($node['data']['jstree']['file_id'])) {
                var com_id = JSON.stringify($node['data']['jstree']['file_id']);
                __mail(com_id);
            }
        }
    }
    };
    return items;
}
////////////////nauman starts//////////////////
         function __mail(id) {

               
                console.log(id);

                var modalClass= 'modal_'+'<?=$_GET['com_id']?>';
                bootbox.dialog({
                    className:modalClass,
                    message: emailFormContent(id),
                    title: "Email Sending!",
                    buttons: {
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-warning'
                        },
                        update: {
                        label: 'Send Email ',
                        className: 'btn-success',
                        callback: function (data) {
                            var ckContent = $('.cke_contents iframe').contents().find('body').html();
                            $('#dataEmailBody').val(ckContent);
                            //Serialize form data
                            var frmdata = new FormData($("#sendmail")[0]);
                            frmdata.append('file',id);
                            console.log(frmdata);
                                <?php
                                    $q = $this->queryString;
                                    //$q['src']['p'] = 1;
                                    $q['xtype'] = 'sendmail';
                                    if (isset($q['xid']))
                                    unset($q['xid']);
                                ?>
                                var actionUrl = '?<?php echo http_build_query($q, '', '&'); ?>';
                                $('#loading').show();
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#sendmail").attr("method"),
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) { 

                                        console.log( response);
                                        //var datas=JSON.parse(response);
                                        //console.log('its errors');
                                        //console.log(response['errors']);
                                        console.log(response.errors);
                                        $('#loading').hide();
                                        if(response.errors!=undefined){
                                          
                                            var failed=(response.total_email*1)-(response.count_email*1);
                                            var feedback="<p>Total <b>"+response.total_email+"</b> are requested to be sent.</p><br/>";
                                            feedback+="<p> <b>"+failed+"</b> emails could not be sent.</p><br/>";
                                            $.each(response.errors,function(k,v){
                                                console.log('message: '+v.msg);
                                                console.log('response: '+v.response);
                                                console.log('email: '+ v.email);
                                                console.log('name: '+v.name);

                                                feedback+="<i>"+v.name+" ";
                                                feedback+="( "+ v.email + ")</i>";
                                                feedback+="<br/>";
                                             

                                            });
                                          
                                            $('#quickcreate_form_container').html();
                                            $('#quickcreate_form_container').html(feedback);

                                        }else if(response.yes!=undefined){
                                             var msgmail="Email has been sent.";
                                            var strAlertSuccess = '<div class="alert alert-info" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;"><button data-dismiss="alert" class="close" type="button">×</button>'+msgmail+'</div>';
                                            var alertSuccess = $(strAlertSuccess).appendTo('body');
                                            alertSuccess.show();
                                            setTimeout(function(){ 
                                            alertSuccess.remove();
                                            },5000);
                                            $('.'+modalClass).modal('hide');
                                        }else{
                                            var msgmail="Email sending Failed.";
                                            $('#errors').attr('class','alert alert-danger');
                                            $('#errors').html(msgmail);
                                           
                                        }
                                        
                                        return false;                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                       console.log(textStatus, errorThrown);
                                    }
                                });
                                //$('.'+modalClass).modal('hide');
                            //}
                            return false;   
                            }
                        }
       


                    }
                });

        }
        ////////////////nauman ends//////////////////
        /////////////nauman code starts here////////////////////
        function emailFormContent(id){
                    //console.log("form emailFormContent: "+id);
                    var content = $("#table").clone();
                    content.find('.dataTables_wrapper').remove();
                    content.find('.table').remove();
                    content.find('.row').remove();
                    <?php
                        $q = $this->queryString;
                        $q['xtype'] = 'email';
                       
                    ?>
           
            $.ajax({
                type: 'GET',
                data : { id : id },
                url: '?<?php echo http_build_query($q, '', '&'); ?>',
                success: function(data) {   
                    //console.log(data);
                    <?php
                        $q = $this->queryString;
                        //$q['src']['p'] = 1;
                        $q['xtype'] = 'sendmail';
                        if (isset($q['xid']))
                        unset($q['xid']);
                    ?>
                    var actionUrl = '?<?php echo http_build_query($q, '', '&'); ?>';

                    //$(content).css('visibility','visible');
                    $(content).attr('id','sendmail');
                    $(content).attr('action',actionUrl);
                    $(content).append(data);
                }
            });
            return content ;
        }
////////////////////nauman code ends here///////////////////////
</script>