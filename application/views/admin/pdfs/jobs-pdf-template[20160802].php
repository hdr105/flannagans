<?php 
global $date_format_convert;
$permissions = $auth->getPermissionType();
$CI = & get_instance();
$lang = $CI->lang;
$c_id = $_GET['com_id'];
$sess_cid = $CI->session->userdata('comid');

$elements = $this->form;
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
//echo $form_html;
$bg = base_url()."/media/images/flannagans2i.jpg";
$final = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Jobs</title>

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
$final .= $form_html;
$final .= '</body></html>';
$pdfFilePath = 'a.pdf';
$CI->load->library('m_pdf');
header('Content-Type: application/pdf');
	//generate the PDF from the given html
$CI->m_pdf->pdf->WriteHTML($final);
$CI->m_pdf->pdf->Output($pdfFilePath, "D");
?>