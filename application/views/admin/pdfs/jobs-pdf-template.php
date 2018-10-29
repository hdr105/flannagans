<?php 
global $date_format_convert;
$permissions = $auth->getPermissionType();
$CI = & get_instance();
$lang = $CI->lang;
$c_id = $_GET['com_id'];
$sess_cid = $CI->session->userdata('comid');

$CI->db->select('component_name');
$CI->db->select('component_table');
$CI->db->from('crud_components');
$CI->db->where('id', $c_id );
$query = $CI->db->get();
$pdf_title = $query->row_array();
//$elements = $this->form;

foreach ($this->primaryKey as $f) {
    $ary = explode('.', $f);
    if (isset($_GET['key'][$f]) || isset($key[$ary[0]][$ary[1]])) {
        if (isset($_GET['key'][$f])) {
            $_POST['key'][$ary[0]][$ary[1]] = $_GET['key'][$f];
        }
        $hidden = __hidden('key.' . $f);
    }
}
if($c_id==85){
    if($_GET['key']){
        $CI->db->select('job_sub_category');
        $CI->db->from('jobs');
        $CI->db->where('id',$_GET['key']['checklist.id']);
        $query = $CI->db->get();
        $chk = $query->row_array();
        $chkid = $chk['job_sub_category'];

        $CI->db->select('*');
        $CI->db->from('checklists');
        $CI->db->where('group_id',$chkid);
        $query = $CI->db->get();
        $chk = $query->row_array();
        $this->form = unserialize($chk['config']); 
        $this->form = $this->form['elements'];

        $CI->db->select('form_data');
        $CI->db->from('checklist');
        $CI->db->where('id',$_GET['key']['checklist.id']);
        $query = $CI->db->get();
        $chk = $query->row_array();
        $rs = unserialize($chk['form_data']); 
        if (!empty($rs))
            $_POST = array_merge($_POST, array('data' => $rs));

        //$this->form = json_decode($chk['build_config']); 
        //$this->form = json_decode($chk['section_config'], true); 
    }
}
$elements = $this->form;
$sections = array();
/*echo '<pre>';
print_r($elements);
die;*/
if (!empty($elements)) {
    foreach ($elements as $field => $v) {
        $inner_section = array();
        $inner_section['section_name'] = $v['section_name'];
        $inner_section['section_title'] = $v['section_title'];
        $inner_section['section_view'] = $v['section_view'];
       
        $inner_section['section_html'] = '';
       
        $fields = $v['section_fields'];
        // Start a row
        $inner_section['section_html'] .= '<tr class="row-ali first">';
        $counter = 0;
        $total_fields = count($fields);
        
        foreach ($fields as $fk => $f) {
            if (empty($f['element']))
                continue;

            $e = $f['element'];
            if ($f['alias'] == 'Title') {
                $title_value = generateViewElementView($e,$this->da,$fk,$date_format_convert);
                $pdf_job_title = ($title_value != '' || !empty($title_value)) ? '-'.generateViewElementView($e,$this->da,$fk,$date_format_convert).'-' : '';
            }
            ////////////if block given by kamran
            if ($v['section_size'] == 'full') {
                $section_size = ' col-md-12 ';
                $label_class =  ' hidden ';
                $field_class = ' col-md-12 ';
            } else {
                $section_size = ' col-md-6 ';
                $label_class =  '  ';
                $field_class = ' col-md-8 ';
            }
            /////////////////////////////////

            if (!empty($e) && isset($e[0])) {
                if($e[0]=='related_module' or $e[0]=='editor'){
                    $section_size = ' col-md-12 ';
                    $field_class = ' col-md-12 ';
                }
                if($e[0]=='empty'){
                    $inner_section['section_html'] .= '<td class="'.$section_size.'">';
                    $inner_section['section_html'] .= '<div class="form-group">';
                    $inner_section['section_html'] .= '<label class="control-label col-md-12 '.$label_class.'"></label>';
                    $inner_section['section_html'] .= '<div class="col-md-12 '.$field_class.'">';
                    $inner_section['section_html'] .= generateViewElementView($e,$this->da,$fk,$date_format_convert);
                    ///////////////////////////////////
                    $inner_section['section_html'] .= '</div>';
                    $inner_section['section_html'] .= '</div>';
                    $inner_section['section_html'] .= '</td>';
                
                } else if($e[0]!='hidden'){
                    ////////////if block given by kamran
                    $inner_section['section_html'] .= '<td class="'.$section_size.'">';
                    $inner_section['section_html'] .= '<div class="form-group">';
                    $inner_section['section_html'] .= '<strong><label class="control-label col-md-12 '.$label_class.'">'. $f['alias'].'</label></strong>';
                    $inner_section['section_html'] .= '<div class="col-md-12 '.$field_class.'">';
                    if (empty(generateViewElementView($e,$this->da,$fk,$date_format_convert)) || generateViewElementView($e,$this->da,$fk,$date_format_convert) == '') {
                        $inner_section['section_html'] .= 'N/A';
                    }else{
                        $inner_section['section_html'] .= generateViewElementView($e,$this->da,$fk,$date_format_convert);
                    }
                    
                    ///////////////////////////////////
                    $inner_section['section_html'] .= '</div>';
                    $inner_section['section_html'] .= '</div>';
                    $inner_section['section_html'] .= '</td>';
                } else {
                    $inner_section['section_html'] .= '<div class="col-md-6" style="display:none;">';
                    $inner_section['section_html'] .= '<div class="form-group">';
                    $inner_section['section_html'] .= '<strong><label class="control-label col-md-4"><b>'. $f['alias'].'</b></label></strong>';
                    $inner_section['section_html'] .= '<div class="col-md-8">';
                    $inner_section['section_html'] .= generateViewElementView($e,$this->da,$fk,$date_format_convert);
                    $inner_section['section_html'] .= '</div>';
                    $inner_section['section_html'] .= '</div>';
                    $inner_section['section_html'] .= '</div>';
                    continue;

                }
            }
            if($e[0]=='related_module'){
                $counter++;
            }
            if($counter == 1){
                $inner_section['section_html'] .=  '</tr>';
                //$inner_section['section_html'] .= '<div class="clearfix"></div>';
                $inner_section['section_html'] .=  '<tr class="row-ali 2nd">';
                $counter = 0;
            } else {
                $counter++;
            }
            
        }
        $inner_section['section_html'] .=  '</tr>';
        $sections[] = $inner_section;
        unset($inner_section);
    }
}
$total_sectoins =  count($sections);
$form_html = '';
$tab_li = '';
$tab_main_div = '';
$tab_ul_start = '';
$active_class = '';
// Table UL
$tab_ul_end = '';
$tab_content_div = '';
$tab_content_start = '';
$tab_content_end = '';
$tab_main_div_close = '';
// Test
$test = array();
$scounter = 1;
$tcounter = 1;
foreach ($sections as $sk => $sv) {
    if ($sv['section_view'] == 'outer') {
        $form_html .= '<h3 class="form-section">'.$sv['section_title'].'</h3>';
        $form_html .= $sv['section_html'];
    } elseif ($sv['section_view'] == 'accordion') {
        $tab_content_div .= '
        <table class="form-body">
            <tr class="panel-heading">
                <th colspan="2">
                    <h3 class="panel-title">'.$sv['section_title'].' </h3>
                </th>
            </tr>
                '.$sv['section_html'].'
        </table>';
        $active_class = '';
        $tcounter++;
        // codign for accordtion ends here
    } 
    $scounter++;
}
$form_html .= $tab_content_div;
$bg = base_url()."/media/images/flannagans2i.jpg";
$final = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>'.ucfirst($pdf_title['component_name']).'</title>

    <style type="text/css">

    ::selection{ background-color: #E13300; color: white; }
    ::moz-selection{ background-color: #E13300; color: white; }
    ::webkit-selection{ background-color: #E13300; color: white; }

    body {
        background-color: #fff;
        font-size: 9pt;
        margin-top:300px;
        color: #4F5155;
        font-family: "Arial";
    }
    .col-md-6{
        width:50%;
        padding:10px 15px;
    }
    .col-md-12{
        width:100%;
    }
    th, td {
        border: 1px solid #ddd;
    }
    th {
        background-color: #32c5d2;
        color: white;
        padding: 5px 15px;
        text-align:left;
        border-radius: 5px;
    }
    h3{
        font-weight:normal;
    }
    .form-horizontal .control-label{
        text-align: left;
        font-weight: bold;
        padding-bottom: 5px;
    }
    .clear{clear: both;}
    @page {
        background: url("'. $bg .'") center  no-repeat; background-size:cover;
        margin-top: 150px;
        margin-left: 60px;
        margin-bottom: 100px;
        margin-right: 80px;
    }
    table {
        border-collapse: collapse;
        margin-bottom:10px;
        width:100%;
    }
    </style>
</head>
<body>
'.$hidden;
$final .= str_replace("View All"," ", $form_html);
$final .= '</body></html>';
$pdfFilePath = ucfirst($pdf_title['component_name']).'-'.$pdf_job_title.'-'.date("d-M-y").'.pdf';
$CI->load->library('m_pdf');
header('Content-Type: application/pdf');
    //generate the PDF from the given html
$CI->m_pdf->pdf->WriteHTML($final);
$CI->m_pdf->pdf->Output($pdfFilePath, "D");
?>
<script>
//SHOW ACCORDDIANS
  $(document).ready(function(){ 
   var maindiv = $('#frm_accordion_1').children().children().children().children().children().next().text();
   <?php if($_GET['com_id']==70){
   ?>
   $('#frm_accordion_1').parent().hide(); 
   <?php   
   }
   ?>
   if(maindiv){
    var options = maindiv.split(',');
    $.each(options,function(i){
     var stringdata = options[i].trim();
     if(stringdata=='Accounts'){
      $('#frm_accordion_2').parent().show();
     }

     if(stringdata=='Annual Return'){
      $('#frm_accordion_3').parent().show();
     } 

     if(stringdata=='VAT'){
      $('#frm_accordion_4').parent().show();
     } 

     if(stringdata=='Tax'){
      $('#frm_accordion_5').parent().show();
     } 

     if(stringdata=='Payroll'){
      $('#frm_accordion_6').parent().show();
     }
    });
   }
   
  });
//Related Module Function
    function downloadPDF(jdata){
        var key_value = '<?php echo $_GET['key'][key($_GET['key'])];?>';
        window.location="<?=base_url()?>admin/pdfs?id="+jdata.selected_id+"&bid="+key_value+"&com_id="+jdata.module_id;

    }; 
    function viewPDF(jdata){
        var key_value = '<?php echo $_GET['key'][key($_GET['key'])];?>';
        window.open("<?=base_url()?>admin/pdfs?id="+jdata.selected_id+"&bid="+key_value+"&com_id="+jdata.module_id+"&action=view",'_blank')
    }; 
  
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
                    url: '?com_id='+jData.module_id+'&xtype=summary_view_datalist&xview=1',
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
                    url: '?com_id='+jData.module_id+'&xtype=summary_view_datalist&xview=1',
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
        // Summary View
        // Genereates quick create form content
        function summaryViewContent(jData){
            var content = $("#crudForm").clone(true);
            content.find('.form-body').html('');
            <?php
                $q = $this->queryString;
                $q['xtype'] = 'summary';
                if (isset($q['key']))
                unset($q['key']);
            ?>  //quickcreateform
            $.ajax({
                type: 'GET',
                url: '?com_id='+jData.module_id+'&xtype=summary&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll,
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
                        "info": "Showing _START_ to _END_ of TOTAL records",
                        "infoEmpty": "No records found",
                        "infoFiltered": "(filtered1 from MAX total records)",
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
            var modalClass = 'modal_'+jData.module_id;
            bootbox.dialog({
                className:modalClass,
                message: summaryViewContent(jData),
                title: "Select Record",
                size:"large",
                buttons: {
                        cancel: {
                            label: 'Close',
                            className: 'btn-warning'
                        }/*,
                        quickcreate: {
                            label: 'Select',
                            className: 'btn-success',
                            callback: function (data) {
                                
                                return false;
                            }
                        }*/
                }
            });
        }
    // Summary View Ends
    
    //RELATED MPDULE POPUP HERE STARTS
    function insertRelated(jData){
        quickCreateModal(jData);
    }
    //RELATED MODULE POPUP ENDS
    // Genereates quick create form content
    function quickCreateFormContent(jData){
        var content = $("#crudForm").clone(true);
        content.find('.form-body').html('');
        <?php
            $q = $this->queryString;
            $q['xtype'] = 'quickcreate';
            if (isset($q['key']))
            unset($q['key']);
        ?>  //quickcreateform
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
                $(content).find('.form-body').html(data);
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

    function crudCancel() {
        <?php
        $q = $this->queryString;

        if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45 or $c_id==58 or $c_id==62 or $c_id==63 or $c_id==64 or $c_id==70)
            $q['com_id']=$sess_cid;
        $q['xtype'] = 'index';
        if (isset($q['key']))
            unset($q['key']);
        if (isset($q['bname']))
            unset($q['bname']);
        ?>
        window.location = "?<?php echo http_build_query($q, '', '&'); ?>";
    }
    
    function crudConfirm() {
        <?php
                $q = $this->queryString;
            $q['xtype'] = 'update';
            if (isset($q['xid']))
                unset($q['xid']);
            if(isset($_GET['bname']) and $bname=$_GET['bname'])
                $q['bname'] = $bname;

        ?>
        $('#crudForm').attr({action: '?<?php echo http_build_query($q, '', '&'); ?>'});
        $('#crudForm').submit();
    }
    
    $(document).ready(function() {
        $('title').text('<?php echo $this->title; ?>');
    });
    
    //------------------------------------------------RELATED MODULE BY SALMAN STARTS HERE-------------------------------------------------------------//
    function insertRelatedModule(jData){
        quickCreateModalModule(jData);
    }
    
    function quickCreateModalModule(jData) {
        var modalClass = 'modal_'+jData.module_id;
        bootbox.dialog({
            className:modalClass,
            message: quickCreateFormContentModule(jData),
            buttons: {
                cancel: {
                    label: 'Cancel',
                    className: 'btn-warning'
                },
                quickcreateModule: {
                    label: 'Create ',
                    className: 'btn-success',
                    callback: function (data) {
                        // Serialize the data in the form
                        var frmdata = new FormData($("#quickcreateModule")[0]);
                        var validatorNode = validateform();
                        if(validatorNode==1){
                            var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                            $.ajax({
                                url: actionUrl,
                                type: $("#quickcreateModule").attr("method"),
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
    
    function quickCreateFormContentModule(jData){
        var content = $("#crudForm").clone(true);
        content.find('.form-body').html('');
        <?php
            $q = $this->queryString;
            $q['xtype'] = 'quickcreateModule';
            if (isset($q['key']))
            unset($q['key']);
        ?> 
        //quickcreateModuleform
        $.ajax({
            type: 'GET',
            url: '?com_id='+jData.module_id+'&xtype=quickcreateModule&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll,
            success: function(data) {   
                <?php
                    $q = $this->queryString;
                    $q['src']['p'] = 1;
                    $q['xtype'] = 'quickcreateModuleform';
                    $q['com_id'] = 23;
                    if (isset($q['xid']))
                    unset($q['xid']);
                ?>
                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform';                            
                $(content).css('visibility','visible');
                $(content).attr('id','quickcreateModule');
                $(content).attr('action',actionUrl);
                $(content).find('.form-body').html(data);
            }
        });
        return content ;
    }
    //------------------------------------------------RELATED MODULE BY SALMAN STARTS HERE-------------------------------------------------------------//
    </script>
    <script type="text/javascript">
        jQuery(document).ready(function() {   
            $(".select2, .select2-multiple").select2({
                placeholder: "Select...",
                width: null
            });

            $(".select2-allow-clear").select2({
                allowClear: true,
                placeholder: "Select...",
                width: null
            });

            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
                autoclose: true
            });
        });
        
        
        
    function remoRelModRecord(jData){
        var preSelectedRecords = $('#'+jData.hidden_controll).val();
        var selectedRecords = preSelectedRecords.split(',');
        var index = selectedRecords.indexOf(jData.selected_id);
        if (index >= 0) {
          selectedRecords.splice( index, 1 );
        }
        $('#'+jData.hidden_controll).val(selectedRecords.join());
        var preSelectedRecords = $('#'+jData.hidden_controll).val();
        if(preSelectedRecords==''){
            $('#'+jData.visible_controll).empty();
        }

        for (var i = 0; i < selectedRecords.length; i++) {
            jData.selected_id = selectedRecords[i];
            selectedRecord(jData);
        }   
    }

    //VIEW RELATED DATA START
    function ViewRelModRecord(jData){
        bootbox.dialog({
            message: ViewRelContentModule(jData),
            buttons: {
                cancel: {
                    label: 'Close',
                    className: 'btn-warning'
                }
            }
        });
    }
    
    function ViewRelContentModule(jData){
        var content = $("#crudForm").clone(true);
        content.find('.form-body').html('');
        $.ajax({
            type: 'POST',
            data    : jData,
            url     : 'status?cfun=getModuletableDetails',
            success: function(tablename) {   
                $.ajax({
                    type: 'GET',
                    url: '?com_id='+jData.module_id+'&xtype=viewRelatedModuleData&key['+tablename+'.'+jData.module_key+']='+jData.selected_id,
                    success: function(data) {   
                        var actionUrl = '?com_id='+jData.module_id+'&xtype=view';                            
                        $(content).css('visibility','visible');
                        $(content).attr('id','quickcreateModule');
                        $(content).attr('action',actionUrl);
                        $(content).find('.form-body').html(data);
                    }
                });
            }
        });
        
        return content ;
        
    }
    //VIEW RELATED DATA START
    
    //EDIT RELATED MODULE DATA CODE START
    function EditRelModRecord(jData){
        quickCreateModalModuleEdit(jData);
    }
    function quickCreateModalModuleEdit(jData) {
        if(jData.module_id=='59' || jData.module_id=='60' || jData.module_id=='61' || jData.module_id=='48' || jData.module_id=='49' || jData.module_id=='47'){
            var modalClass = 'modal_'+jData.module_id;
            bootbox.dialog({
                className:modalClass,
                message: quickCreateFormContentModuleEdit(jData),
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreateModule: {
                        label: 'Update ',
                        className: 'btn-success',
                        callback: function (data) {
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var validatorNode = validateform();
                            if(validatorNode==1){
                                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#quickcreateModule").attr("method"),
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
                    },
                    quickcreateModuleDraft: {
                        label: 'Save As Draft ',
                        className: 'btn-success',
                        callback: function (data) {
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                            $.ajax({
                                url: actionUrl,
                                type: $("#quickcreateModule").attr("method"),
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
                            return false;
                        }
                    }
                }
            });
        } else {
            var modalClass = 'modal_'+jData.module_id;
            bootbox.dialog({
                className:modalClass,
                message: quickCreateFormContentModuleEdit(jData),
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreateModule: {
                        label: 'Update ',
                        className: 'btn-success',
                        callback: function (data) {
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var validatorNode = validateform();
                            if(validatorNode==1){
                                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#quickcreateModule").attr("method"),
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
    }

    
    function quickCreateFormContentModuleEdit(jData){
        var content = $("#crudForm").clone(true);
        content.find('.form-body').html('');
        //quickcreateModuleform
        $.ajax({
            type: 'POST',
            data    : jData,
            url     : 'status?cfun=getModuletableDetails',
            success: function(tablename) {   
                $.ajax({
                    type: 'GET',
                    url: '?com_id='+jData.module_id+'&xtype=quickcreateModule&key['+tablename+'.'+jData.module_key+']='+jData.selected_id+'&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll,
                    success: function(data) {   
                        var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform';                            
                        $(content).css('visibility','visible');
                        $(content).attr('id','quickcreateModule');
                        $(content).attr('action',actionUrl);
                        $(content).find('.form-body').html(data);
                    }
                });
            }
        });
        return content ;
    }
    //EDIT RELATED MODULE DATA CODE END
    
    </script>
    <script src="<?php echo base_url(); ?>media/js/mfunctions/mfunctions.js" type="text/javascript"></script>
    <script>
    function __edit() {
        <?php
        $q = $this->queryString;
        $q['xtype'] = 'form';
        ?>
                                window.location = "?<?php echo http_build_query($q, '', '&'); ?>";
                            }
                    function crudBack() {
                        <?php
                        $q = $this->queryString;
                        if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45 or $c_id==58 or $c_id==62 or $c_id==63 or $c_id==64 or $c_id==70)
                            $q['com_id']=$sess_cid;
                        $q['xtype'] = 'index';
                        if (isset($q['key']))
                            unset($q['key']);
                        if (isset($q['bname']))
                            unset($q['bname']);
                        ?>
                        window.location = "?<?php echo http_build_query($q, '', '&'); ?>";
                    }
                    $(document).ready(function() {
                        $('title').html('<?php echo $this->title; ?>');
                    });
    </script>

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



     function acceptInv(){
        var content = $("#crudForm").clone(true);
        content.find('.form-body').html('');
        var actionUrl = '?com_id=81&xtype=accpet_inv';                            
        $(content).css('visibility','visible');
        $(content).attr('id','accpet_inv');
        $(content).attr('action',actionUrl);
        
        content.submit();
    }
</script>
