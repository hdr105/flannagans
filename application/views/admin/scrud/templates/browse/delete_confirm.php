<?php 
global $date_format_convert;
$CI = & get_instance();
$lang = $CI->lang; ?>

<div class="portlet light bordered">
                                            <div class="portlet-title">
                                                
                                                <div class="pull-right">
                                                    <a href="javascript:;" onclick="crudBack();" class="btn btn-sm blue "> <i class="icon-arrow-left"></i>  <?php echo $CI->lang->line('back');?>
                                                    </a>
                                                    <a class="btn btn-sm red " onclick="crudDelete('<?php echo http_build_query(array('key' => $_GET['key']), '', '&'); ?>');" > &nbsp; <?php echo $lang->line('delete'); ?> &nbsp; </a>
                                                </div> 
                                            </div>
                                            <div class="portlet-body form">
                                            <form method="post" action="" id="crudForm" <?php if ($this->frmType == '2') { ?>class="form-horizontal"<?php } ?>>

                                            <?php
              $elements = $this->form;
              foreach ($this->primaryKey as $f) {
                  $ary = explode('.', $f);
                  if (isset($_GET['key'][$f]) || isset($key[$ary[0]][$ary[1]])) {
                      if (isset($_GET['key'][$f])) {
                          $_POST['key'][$ary[0]][$ary[1]] = $_GET['key'][$f];
                      }
                      echo __hidden('key.' . $f);
                  }
              }
              ?>
              <?php if (!empty($this->errors)) { ?>
            <div class="alert alert-error">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <?php foreach ($this->errors as $error) { ?>
                    <?php if (count($error) > 0) { ?>
                        <strong>Error!</strong>
                        <?php echo implode('<br />', $error); ?>
                        <br />
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
<div class="form-body">

                                                        <?php
                                                        $elements = $this->form;
                                                        $sections = array();
                                                        
                                                        if (!empty($elements)) {
                                                            foreach ($elements as $field => $v) {
                                                                $inner_section = array();

                                                                $inner_section['section_name'] = $v['section_name'];
                                                                $inner_section['section_title'] = $v['section_title'];
                                                                $inner_section['section_view'] = $v['section_view'];
                                                               
                                                                $inner_section['section_html'] = '';
                                                               
                                                                $fields = $v['section_fields'];
                                                                // Start a row
                                                                $inner_section['section_html'] .= '<div class="row">';
                                                                $counter = 0;
                                                                $total_fields = count($fields);
                                                                foreach ($fields as $fk => $f) {
                                                                    if (empty($f['element']))
                                                                        continue;

                                                                    $e = $f['element'];

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
                                                                        if($e[0]=='related_module'){
                                                                            $section_size = ' col-md-12 ';
                                                                            $field_class = ' col-md-12 ';
                                                                        }
                                                                        if($e[0]=='empty'){
                                                                           $inner_section['section_html'] .= '<div class="col-md-6">';
                                                                           $inner_section['section_html'] .= '<div class="form-group">';
                                                                           $inner_section['section_html'] .=    '<label class="control-label col-md-4"></label>';
                                                                           $inner_section['section_html'] .=     '<div class="col-md-8">';
                                                                            $inner_section['section_html'] .=   generateViewElementView($e,$this->da,$fk,$date_format_convert);
                                                                           $inner_section['section_html'] .=     '</div>';
                                                                           $inner_section['section_html'] .= '</div>';
                                                                           $inner_section['section_html'] .= '</div>';
                                                                        
                                                                        } else if($e[0]!='hidden'){
                                                                            /*$inner_section['section_html'] .= '<div class="col-md-6">';
                                                                            $inner_section['section_html'] .= '<div class="form-group">';
                                                                            $inner_section['section_html'] .=    '<label class="control-label col-md-4"><b>'. $f['alias'].'</b></label>';
                                                                            $inner_section['section_html'] .=     '<div class="col-md-8" style="padding:8px 0 0 0;">';
                                                                            $inner_section['section_html'] .=   generateViewElementView($e,$this->da,$fk,$date_format_convert);
                                                                            $inner_section['section_html'] .=     '</div>';
                                                                            $inner_section['section_html'] .= '</div>';
                                                                            $inner_section['section_html'] .= '</div>';
*/

                                                                            ////////////if block given by kamran
                                                                            $inner_section['section_html'] .= '<div class="'.$section_size.'">';
                                                                            $inner_section['section_html'] .= '<div class="form-group">';
                                                                            $inner_section['section_html'] .=    '<label class="control-label col-md-12 '.$label_class.'">'. $f['alias'].'</label>';
                                                                            $inner_section['section_html'] .=     '<div class="col-md-12 '.$field_class.'">';
                                                                            $inner_section['section_html'] .=   generateViewElementView($e,$this->da,$fk,$date_format_convert);
                                                                            ///////////////////////////////////
                                                                            $inner_section['section_html'] .=     '</div>';
                                                                            $inner_section['section_html'] .= '</div>';
                                                                            $inner_section['section_html'] .= '</div>';
                                                                        } else {
                                                                            $inner_section['section_html'] .= '<div class="col-md-6" style="display:none;">';
                                                                            $inner_section['section_html'] .= '<div class="form-group">';
                                                                            $inner_section['section_html'] .=    '<label class="control-label col-md-4"><b>'. $f['alias'].'</b></label>';
                                                                            $inner_section['section_html'] .=     '<div class="col-md-8">';
                                                                            $inner_section['section_html'] .=   generateViewElementView($e,$this->da,$fk,$date_format_convert);
                                                                            $inner_section['section_html'] .=     '</div>';
                                                                            $inner_section['section_html'] .= '</div>';
                                                                            $inner_section['section_html'] .= '</div>';

                                                                        }
                                                                    }

                                                                    if($e[0]=='related_module'){
                                                                        $counter++;
                                                                    }                        

                                                                    if($counter == 1){
                                                                        $inner_section['section_html'] .=  '</div>';
                                                                        $inner_section['section_html'] .= '<div class="clearfix"></div>';
                                                                        $inner_section['section_html'] .=  '<div class="row">';
                                                                        $counter = 0;
                                                                    } else {
                                                                        $counter++;
                                                                    }
                                                                    
                                                                }
                                                                $inner_section['section_html'] .=  '</div>';
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
                                                                // Codding for accordion
                                                                $toggle_class = '';
                                                                if ($tcounter ==1) {
                                                                    $tab_main_div = '<div class="panel-group accordion" id="frm_accordion">';
                                                                    $active_class = 'in';
                                                                } else {
                                                                    $toggle_class = 'collapsed';
                                                                    $active_class = 'collapse';
                                                                }
                                                                $tab_content_div .= '<div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <h4 class="panel-title">
                                                                            <a class="accordion-toggle accordion-toggle-styled '.$toggle_class.'" data-toggle="collapse" data-parent="#frm_accordion" href="#frm_accordion_'.$scounter.'"> '.$sv['section_title'].' </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="frm_accordion_'.$scounter.'" class="panel-collapse '.$active_class.'">
                                                                        <div class="panel-body">
                                                                            '.$sv['section_html'].'
                                                                        </div>
                                                                    </div>
                                                                </div>';
                                                                $last_tab = $scounter - $total_sectoins;
                                                                if ($last_tab== 0) {
                                                                    $tab_main_div_close = '</div>';
                                                                }
                                                                $active_class = '';
                                                                $tcounter++;
                                                                // codign for accordtion ends here
                                                            } else if ($sv['section_view'] == 'tabbed') {
                                                                // Coding for tabbed view
                                                                if ($tcounter ==1) {
                                                                    $test['counter_is_one'][] = 'yes';
                                                                    $tab_main_div = '<div class="tabbable tabbable-tabdrop">';
                                                                    $tab_ul_start = '<ul class="nav nav-tabs">';
                                                                    $tab_content_start = '<div class="tab-content">';
                                                                    $active_class = 'active';
                                                                }
                                                                $test['counter_is_number'][] = $scounter;
                                                                $tab_li .= '<li class="'.$active_class.'"><a href="#'.$sv['section_name'].'" data-toggle="tab">'.$sv['section_title'].'</a></li>';
                                                                $tab_content_div .= '<div class="tab-pane '.$active_class.'" id="'.$sv['section_name'].'">'.$sv['section_html'].'</div>';
                                                                $last_tab = $scounter - $total_sectoins;
                                                                if ($last_tab== 0) {
                                                                    $test['counter_is_last'][] = 'yes';
                                                                    $tab_content_end = '</div>';
                                                                    $tab_ul_end = '</ul>';
                                                                    $tab_main_div_close = '</div>';
                                                                }
                                                                $active_class = '';
                                                                $tcounter++;
                                                            }
                                                            $scounter++;
                                                        }
                                                        $form_html .= $tab_main_div;
                                                            $form_html .= $tab_ul_start;
                                                                $form_html .= $tab_li;
                                                            $form_html .= $tab_ul_end;
                                                            $form_html .= $tab_content_start;
                                                                $form_html .= $tab_content_div;
                                                            $form_html .= $tab_content_end;
                                                        $form_html .= $tab_main_div_close;
                                                        echo $form_html;
                                                        ?>

                                                    </div>
                                            </form>
                                        </div>
                                    </div>
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




    function crudBack(){
<?php
$q = $this->queryString;
$q['xtype'] = 'index';
if (isset($q['key']))
    unset($q['key']);
if($q['com_id'] ==30)
    $q['com_id']=29;        

?>
        window.location = "?<?php echo http_build_query($q, '', '&'); ?>";
    }
    function crudDelete(id){
<?php
$q = $this->queryString;
$q['xtype'] = 'del';
if (isset($q['key']))
    unset($q['key']);
?>
        window.location = "?<?php echo http_build_query($q, '', '&'); ?>&auth_token=<?php echo $this->getToken(); ?>&"+id;
    }
    $(document).ready(function(){
        $('title').html('<?php echo $this->title; ?>');
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
    </script>
    <script src="<?php echo base_url(); ?>media/js/mfunctions/mfunctions.js" type="text/javascript"></script>
</div>
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
