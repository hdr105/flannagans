<?php 
global $date_format_convert;
$CI = & get_instance();
$key = $CI->input->post('key');
$lang = $CI->lang; 
?>
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <!-- <div class="caption">

                                                    <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=32" class="btn btn-sm green"><?php echo $CI->lang->line('users');?>
                                                    </a>
                                                     <a href="<?php echo base_url(); ?>admin/user/group" class="btn btn-sm green"><?php echo $CI->lang->line('groups');?>
                                                    </a>
                                                     <a href="<?php echo base_url(); ?>admin/user/permission" class="btn btn-sm green"><?php echo $CI->lang->line('permissions');?>
                                                    </a>
                                                    
                                                </div> -->
                                                <div class="pull-right">
                <a class="btn"  onclick="crudBack();">   <i class="icon-arrow-left"></i>  <?php echo $lang->line('back'); ?>  &nbsp; </a>
                <a class="btn btn-info" onclick="__edit();" > &nbsp;  <i class="icon-edit icon-white"></i>  <?php echo $lang->line('edit');?> &nbsp; </a>
                                                    </a>
                                                </div> 
                                            </div>
    <div class="portlet-body form">
    <?php
    $q = $this->queryString;
    $q['xtype'] = 'confirm';
    if (isset($q['key']))
        unset($q['key']);
    ?>
    <!-- BEGIN FORM-->
    <form method="post" action="?<?php echo http_build_query($q, '', '&'); ?>"  enctype="multipart/form-data"
          id="crudForm" style="padding: 0; margin: 0;" <?php if ($this->frmType == '2') { ?>class="form-horizontal"<?php } ?> >
          <input type="hidden" name="auth_token" id="auth_token" value="<?php echo $this->getToken(); ?>"/>
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
                                                                    if (!empty($e) && isset($e[0])) {
                                                                        $inner_section['section_html'] .= '<div class="col-md-6">';
                                                                        $inner_section['section_html'] .= '<div class="form-group">';
                                                                        $inner_section['section_html'] .=    '<label class="control-label col-md-12">'. $f['alias'].'</label>';
                                                                        $inner_section['section_html'] .=     '<div class="col-md-12">';
                                                                        $inner_section['section_html'] .=   generateViewElementView($e,$this->da,$fk,$date_format_convert);
                                                                        $inner_section['section_html'] .=     '</div>';
                                                                        $inner_section['section_html'] .= '</div>';
                                                                        $inner_section['section_html'] .= '</div>';
                                                                    }
                                                                    if($counter == 1){
                                                                        $inner_section['section_html'] .=  '</div>';
                                                                        $inner_section['section_html'] .=  '<div class="row">';
                                                                        $counter = 0;
                                                                        continue;
                                                                    }
                                                                    $counter++;
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
                                                <!-- END FORM-->
                                            </div>
                                        </div>
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
$q['xtype'] = 'index';
if (isset($q['key']))
    unset($q['key']);
?>
                        window.location = "?<?php echo http_build_query($q, '', '&'); ?>";
                    }
                    $(document).ready(function() {
                        $('title').html($('h2').html());
                    });
    </script>
</div>