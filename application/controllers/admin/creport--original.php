<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Creport extends Admin_Controller {

    public function index() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');

        $var = array();

        $var['data'] = $this->relatedModFieldList();
        

        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/reports/custom_reports',$var,true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/custom_reports', $var); 

    }
    public function view() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');

        $var = array();

        $sql = "SELECT 
        sites.name AS sitesname,
        sites.location AS siteslocation, 
        dampers.barcode AS dampersbarcode,
        dampers.duct_dimen AS dampersduct_dimen,
        damper_test.damper_accessible AS 
        damper_accessible, 
        damper_test.date_tested AS date_tested, 
        damper_test.image AS image, 
        damper_test.completion_remarks AS defects 
        FROM sites 
        INNER JOIN dampers ON dampers.site = sites.id 
        INNER JOIN damper_test ON damper_test.site = sites.id 
        WHERE sites.name LIKE 'a%' ";


        $data = array();
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $var['data'] = $data;
        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/reports/creport',$var,true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/creport', $var); 

    }
    public function allpdf(){
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
        $var = array();

        $filter_1       = $this->input->post('filter_1');
        $cond_1         = $this->input->post('cond_1');
        $cond_val_1     = $this->input->post('cond_val_1');

        $filter_2       = $this->input->post('filter_2');
        $cond_2         = $this->input->post('cond_2');
        $cond_val_2     = $this->input->post('cond_val_2');

        $filter_3       = $this->input->post('filter_3');
        $cond_3         = $this->input->post('cond_3');
        $cond_val_3     = $this->input->post('cond_val_3');

        $dfrom          = $this->input->post('dfrom');
        $dto            = $this->input->post('dto');

        $conditions = '';

        if (!empty($filter_1) && !empty($cond_val_1)) {
            $ex1 = explode(',', $filter_1);
           $conditions .= "  " . $ex1[2] . " = " . $cond_val_1 . " ";
        }

        if (!empty($filter_2) && !empty($cond_val_2)) {
            $ex2 = explode(',', $filter_2);
            if ($conditions != '') {
                $conditions .= " AND " . $ex2[2] . " = " . $cond_val_2 . " ";
            } else {
                $conditions .= "  " . $ex2[2] . " = " . $cond_val_2 . " ";
            }
           
        }

        if (!empty($filter_3) && !empty($cond_val_3)) {
            $ex3 = explode(',', $filter_3);
           if ($conditions != '') {
               $conditions .= "  AND " . $ex3[2] . " = " . $cond_val_3 . " ";
           } else {
                $conditions .= "  " . $ex3[2] . " = " . $cond_val_3 . " ";
           }
        }

        if (!empty($dfrom)) {
            if (!empty($dto)) {
                $ndfrom = date("Y-m-d", strtotime($dfrom));
                $ndto = date("Y-m-d", strtotime($dto));
                if ($conditions != '') {
                   
                    
                    $conditions .= " AND date_tested BETWEEN '".$ndfrom."' AND '".$ndto."' ";
                } else {
                    $conditions .= "  date_tested BETWEEN '".$ndfrom."' AND '".$ndto."' ";
                }
                $originalDate = $ndfrom;
                $newDate = date("d/m/Y", strtotime($originalDate));
                $var['dfrom'] = $newDate;

                $originalDate = $ndto;
                $newDate = date("d/m/Y", strtotime($originalDate));
                $var['dto'] = $newDate;
            } 
        }

        if ($conditions != '') {
            $conditions = " WHERE " . $conditions;
        }

        



        $sql = "SELECT 
        damper_test.damper_accessible, 
        damper_test.date_tested , 
        damper_test.completion_remarks, 
        sites.organisation, 
        sites.name , 
        sites.location , 
        dampers.barcode , 
        dampers.duct_dimen , 
        dampers.image 
        FROM damper_test 
        INNER JOIN sites ON sites.id = damper_test.site 
        INNER JOIN dampers ON dampers.barcode = damper_test.dampers " . $conditions;
        //. " GROUP BY dampers.barcode ";

       /* $var['sql'] = $sql;
        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/reports/custom_reports',$var,true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/custom_reports', $var); 




*/
        $rmex = array('site','dampers','damper_test');
        $rm = array();
        foreach ($rmex as $key => $value) {
                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_table',$value);
            
                $query = $this->db->get();
                $relatedModule = $query->result_array();

                

                if (!empty($relatedModule)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$relatedModule[0]['id']). '/' . $relatedModule[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$relatedModule[0]['id']) . '/' . $relatedModule[0]['component_table'] . '.php'));
                    
                    $relatedModuleConf = unserialize($content);
                    $rm[] = $relatedModuleConf['form_elements'];

                  
                    
                                
                } //form_elements
        }                
        
        $auto_fields = array();

        foreach($rm as $irk => $irv) {

            foreach ($irv as $ik => $iv) {
                $local_arr = array();
                if ($iv['element'][0] == 'select' || $iv['element'][0] == 'autocomplete') {

                        $ii = explode('.', $ik);
                        
                        $auto_fields[$ii[1]] = $iv['element'][1];
                   
                    
                }
            }
        }



        $data = array();
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        ///////////////////////
        $fdata = array();
                                    foreach ($data as $dk => $dv) {
                                        $tmp_array = array();
                                        foreach ($dv as $key => $value) {
                                            if (array_key_exists($key, $auto_fields)) {
                                                if (array_key_exists('option_table', $auto_fields[$key])) {

                                                    $this->db->select('*');
                                                    $this->db->from($auto_fields[$key]['option_table']);
                                                    $this->db->where($auto_fields[$key]['option_key'],$value);
                                                    $query = $this->db->get();
                                                    $rdata = $query->row_array();

                                                    if ($auto_fields[$key]['option_table'] == 'crud_users') {
                                                        $vv = ucwords($rdata['user_first_name']) . ' ' . ucwords($rdata['user_las_name']);
                                                    } elseif ($auto_fields[$key]['option_table'] == 'contact') {
                                                        $vv = ucwords($rdata['First_Name']) . ' ' . ucwords($rdata['Last_Name']);
                                                    } else {
                                                        $vv = $rdata[$auto_fields[$key]['option_value']];
                                                    }

                                                    $tmp_array[$key] = $vv;
                                                    
                                                } else {
                                                    $tmp_array[$key] = $auto_fields[$key][$value];
                                                    
                                                }
                                                
                                            } else {
                                                $tmp_array[$key] = $value;
                                                
                                            }
                                            
                                        }
                                        $fdata[$dk] = $tmp_array;
                                        unset($tmp_array);
                                    }
        ///////////////////////////////


        $var['sql'] = $sql;


        $this->db->select('*');
        $this->db->from('organisations');
        $this->db->where('id',$fdata[0]['organisation']);
        $module_query = $this->db->get();
        $organisation = $module_query->row_array();

        $var['organisation'] = $organisation;
        $var['auto_fields'] = $auto_fields;
        $var['data'] = $fdata;
        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/reports/creport',$var,true);

        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();


        $file_name = date('mdY') . "_test_results_lists.pdf";
        $pdfFilePath = FCPATH."downloads/reports/".$file_name;

        if (file_exists($pdfFilePath)) {
            $x = 1; 

            do {
                $file_name = date('mdY').'_test_results_lists_'.$x . ".pdf";
                $pdfFilePath = FCPATH."downloads/reports/".$file_name;
                $x++;
            } while (file_exists($pdfFilePath));
        }
        $data['page_title'] = 'Report'; // pass data to the view
         
        if (file_exists($pdfFilePath) == FALSE)
        {
            ini_set('memory_limit','64M'); // boost the memory limit if it's low <img class="emoji" draggable="false" alt="😉" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $html = $var['main_content']; // render the view into HTML
             
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetWatermarkText('Crated', 0.5);
            $pdf->SetMargins(5,5,5);
            $pdf->_setPageSize('A4');

            $pdf->WriteHTML($html); 
			
            $titlePage = '<div class="header" style="width:100.5%; ">
            <table width="100%" border="0px;" style="margin-left:-3px; margin-right:-3px;">
            <tr>
                <td class="vendorListHeading" width="150" height="43" style="color:#FFF; padding:0px 20px; background-color:#e2242c!important; font-size:12px;">'.date('F d, Y').'
                </td>
                <td class="vendorListHeading1" style="color:#FFF; padding:10px 20px; background-color:#000!important;">Automatic Smoke and Mechanical Fire Damper Testing Report
                </td>
                </tr>
            </table></div><div style="background:url(http://testcrm.cormeton.co.uk/n/media/images/bg-report.jpg) no-repeat top center; background-size:100% 100%; background-position:0px 100%">
            <page size="A4">
                <div class="contentss">
                        <div class="logobig" style="text-align:center; margin-top:70px;">
                            <img src="'.base_url().'/media/images/big-logo.png" alt="logo" style="margin-top:100px;">
                        </div>
                    </div>
                    <div class="after-logo-txt" style="text-align:center; margin-top:30px;">
                        <h1 style="font-weight:normal;font-size:39px; color:#FFF;">Fire & <span style="color:#e2242c; font-size:39px; font-weight:bold;">Smoke Damper</span></h1>
                        <h1 style="font-weight:normal;font-size:39px; color:#FFF;">Test & Inspection <span style="color:#e2242c; font-size:39px; font-weight:bold;">Report</span></h1>
                    </div>
                    <div class="last-txt" style="margin-top:106px;">
                        <h3 style="color:#FFF; font-size:25px;  text-align:center; font-weight:normal;">PREMISES: '.$data[0]['name'].'
            </h3>
            <h3 style="color:#FFF; font-size:25px; text-align:center; font-weight:normal;">
            CUSTOMER:   '.$organisation['name'].'</h3>
            <h3 style="color:#FFF; font-size:25px; text-align:center; font-weight:normal;">FOR THE PERIOD: ('.$var['dfrom'].' - '.$var['dto'].')</h3>
                    </div>
					
                    <div class="footer" style="padding-top:10px;width:100%; height:33px; margin-top:40px; background:#e2242c; position:absolute; bottom:0px;"><p style="text-align:center; color:#FFF; line-height:10px;">Cormeton Electronics Ltd, Unit 6 Jupiter Court, North Shields, NE29 7SN<p></div>
            </page>
            </div>';    


            
$pdf->WriteHTML($titlePage);
            $pdf->WriteHTML('<pagebreak resetpagenum="0" pagenumstyle="A" />',2);

            $headSection = '<page size="A4"><div class="header" style="padding-top:50px;"><table width="100%" border="0" style="margin-left:-3px;margin-right:-3px;"><tr><td class="vendorListHeading" width="150" height="43" style="color:#FFF; padding:0px 20px; background-color:#e2242c!important;">'.date('F d, Y').'</td><td class="vendorListHeading1" style="color:#FFF; padding:10px 20px; background-color:#000!important;">Automatic Smoke and Mechanical Fire Damper Testing Report</td></tr><tr>
            <td colspan="2">
<table width="100%"><tr>
                <td style="padding:10px 20px;"><img src="'.base_url().'/media/images/logo-cormeton.jpg" alt="cormeton"></td>
                <td align="center" style="padding:10px 20px;color:#e2242c;"><h1 style="width:96%;font-size:25px text-align:left; ">'.date('F d').' Damper Inspection Overview (All Results)</h1></td>
  </tr></table>
            </td>
            </tr></table></div>';
            
            $footSection = '<div class="footer"><p>Cormeton Electronics Ltd, Unit 6 Jupiter Court, North Shields, NE29 7SN<p></div></div>';


            $pageSection = '<h1>Page 1</h1>';

            $recordKeyCounter = 0;
            $recordPerPgaeCouner = 0;

            $pageHtml = '';
            $totalRecords = count($fdata);
            $finalSection = '';

            $footerHtml = '<div class="footer" style="padding-top:5px;"><p>Cormeton Electronics Ltd, Unit 6 Jupiter Court, North Shields, NE29 7SN<p></div>';
            $pdf->SetHTMLFooter($footerHtml);
            $pdf->SetFooter($footerHtml);
            $resetVars = false;

            $tblTitles = '<div class="contents"><table width="99%" align="center">
                <tr class="contentareatr" style="background:#cacaca; border:1px solid #cacaca">
                    <td>Ref No</td>
                    <td>Date </td>
                    <td>Location</td>
                    <td>Pass/Fail</td>
                    <td>Defects</td>
                    <td>Photos </td>
               </tr>';
            $tblBottom = '</table></div></page>';

            foreach ($fdata as $key => $value) {
                        $imgUrl = '';
                        $fbr = str_replace("[", "", $value['image']);
                        $sbr = str_replace("]", "", $fbr);

                        $data = 'data:image/jpeg;base64,' . $sbr;

                        $image_name = date('mdY') . ".pdf";
                        $image_path = FCPATH."downloads/reports/".$image_name;

                        if (file_exists($image_path)) {
                              $x = 1; 

                          do {
                              $image_name = date('mdY').'_'.$x . ".pdf";
                                $image_path = FCPATH."downloads/reports/".$image_name;
                              $x++;
                          } while (file_exists($image_path));
                        }

                        list($type, $data) = explode(';', $data);
                        list(, $data)      = explode(',', $data);
                        $data = base64_decode($data);

                        if (!file_exists($image_path)) {
                          file_put_contents($image_path, $data);
                        }
                      
                        if (!empty($sbr)) {
                          $imgUrl =  '&nbsp;<img width="50" src="'.base_url()."downloads/reports/".$image_name.'"/>';
                        } 

                $pageHtml .= '<tr>
                    <td>'.$value['barcode'].'</td>
                    <td>'.date("d-m-Y", strtotime($value['date_tested'])).'</td>
                    <td>'.$value['location'].'</td>
                    <td>'.$value['damper_accessible'].'</td>
                    <td>'.$value['duct_dimen'].'</td>
                    <td>'.$imgUrl.'</td>
               </tr>';


            if ($totalRecords <= 9) {
                if (($recordPerPgaeCouner+1) ==$totalRecords) {
                    $finalSection = $headSection.$tblTitles.$pageHtml.$tblBottom;
                    $pdf->WriteHTML($finalSection); 
                    $pdf->WriteHTML('<pagebreak resetpagenum="0" pagenumstyle="A" />',1);
                    $resetVars = true;
                }
                
            } else {
                if ($recordPerPgaeCouner ==8) {
                    $finalSection = $headSection.$tblTitles.$pageHtml.$tblBottom;
                    $pdf->WriteHTML($finalSection); 
                    $pdf->WriteHTML('<pagebreak resetpagenum="0" pagenumstyle="A" />',1);
                    $resetVars = true;
                } 
               
                
                if ($resetVars == true) {
                    $recordPerPgaeCouner = 0;
                    $pageHtml = '';
                    $finalSection = '';
                    $resetVars = false;
                }

            }
            $recordPerPgaeCouner++;
                
                
            }
           
           
            
            $pdf->Output($pdfFilePath, 'F'); 
        }
         
        redirect(base_url() . "downloads/reports/".$file_name);

        //$this->load->view('layouts/admin/creport', $var);
        
    }
    public function export() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');

        $var = array();

        $sql = "SELECT sites.name AS sitesname,sites.location AS siteslocation, dampers.barcode AS dampersbarcode,dampers.duct_dimen AS dampersduct_dimen,damper_test.damper_accessible AS damper_accessible, damper_test.date_tested AS date_tested, damper_test.image AS image, damper_test.completion_remarks AS defects FROM sites INNER JOIN dampers ON dampers.site = sites.id INNER JOIN damper_test ON damper_test.site = sites.id WHERE sites.name LIKE 'a%' ";
        $data = array();
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $var['data'] = $data;

        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/reports/creport',$var,true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $file_name = date('mdY') . ".pdf";
        $pdfFilePath = FCPATH."downloads/reports/".$file_name;

        if (file_exists($pdfFilePath)) {
        	$x = 1; 

			do {
			    $file_name = date('mdY').'_'.$x . ".pdf";
        		$pdfFilePath = FCPATH."downloads/reports/".$file_name;
			    $x++;
			} while (file_exists($pdfFilePath));
        }
        $data['page_title'] = 'Report'; // pass data to the view
         
        if (file_exists($pdfFilePath) == FALSE)
        {
            ini_set('memory_limit','64M'); // boost the memory limit if it's low <img class="emoji" draggable="false" alt="😉" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $html = $var['main_content']; // render the view into HTML
             
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetWatermarkText('Crated', 0.5);
            $pdf->SetMargins(5,5,5);
            $pdf->_setPageSize('A4');
            $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img class="emoji" draggable="false" alt="😉" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output($pdfFilePath, 'F'); // save to file because we can
        }
         
        redirect("http://localhost/cor/downloads/reports/".$file_name);

        

    }
    function relatedModFieldList(){
        
        $modules_tbls = array(
        		'sites',
        		'dampers',
        		'damper_test'
        	);

       

        foreach ($modules_tbls as $key => $value) {

                
                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_name',$value);
            
                $query = $this->db->get();
                $modDetail = $query->result_array();

                if (!empty($modDetail)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$modDetail[0]['id']). '/' . $modDetail[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$modDetail[0]['id']) . '/' . $modDetail[0]['component_table'] . '.php'));
                    
                    $moduleConf = unserialize($content);

                                
                } //form_elements
                $moduleFields[$key]['moduleName'] = $value;

                $fieldAlias = array();
                foreach ($moduleConf['form_elements'] as $fkey => $fvalue) {
                    $fieldAlias[] = array($fvalue['alias'],$fvalue['element'][0],$fkey);
                }

                $moduleFields[$key]['moduleInfo'] = $fieldAlias;
        }

        $moduleFields = array(
                'Organisation,autocomplete,sites.organisation'=>'Organisations',
                'Site,autocomplete,dampers.site'=>'Sites'
            );   

        return json_encode($moduleFields);

    }
    function creport2(){
    	$this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');

        $var = array();

        $filter_1       = $this->input->post('filter_1');
        $cond_1         = $this->input->post('cond_1');
        $cond_val_1     = $this->input->post('cond_val_1');

        $filter_2       = $this->input->post('filter_2');
        $cond_2         = $this->input->post('cond_2');
        $cond_val_2     = $this->input->post('cond_val_2');

        $filter_3       = $this->input->post('filter_3');
        $cond_3         = $this->input->post('cond_3');
        $cond_val_3     = $this->input->post('cond_val_3');

        $dfrom          = $this->input->post('dfrom');
        $dto            = $this->input->post('dto');

        $conditions = '';

        if (!empty($filter_1) && !empty($cond_val_1)) {
            $ex1 = explode(',', $filter_1);
           $conditions .= "  " . $ex1[2] . " = " . $cond_val_1 . " ";
        }

        if (!empty($filter_2) && !empty($cond_val_2)) {
            $ex2 = explode(',', $filter_2);
            if ($conditions != '') {
                $conditions .= " AND " . $ex2[2] . " = " . $cond_val_2 . " ";
            } else {
                $conditions .= "  " . $ex2[2] . " = " . $cond_val_2 . " ";
            }
           
        }

        if (!empty($filter_3) && !empty($cond_val_3)) {
            $ex3 = explode(',', $filter_3);
           if ($conditions != '') {
               $conditions .= "  AND " . $ex3[2] . " = " . $cond_val_3 . " ";
           } else {
                $conditions .= "  " . $ex3[2] . " = " . $cond_val_3 . " ";
           }
        }

        if (!empty($dfrom)) {
            if (!empty($dto)) {
                $ndfrom = date("Y-m-d", strtotime($dfrom));
                $ndto = date("Y-m-d", strtotime($dto));
                if ($conditions != '') {
                   
                    
                    $conditions .= " AND date_tested BETWEEN '".$ndfrom."' AND '".$ndto."' ";
                } else {
                    $conditions .= "  date_tested BETWEEN '".$ndfrom."' AND '".$ndto."' ";
                }
                $originalDate = $ndfrom;
                $newDate = date("d/m/Y", strtotime($originalDate));
                $var['dfrom'] = $newDate;

                $originalDate = $ndto;
                $newDate = date("d/m/Y", strtotime($originalDate));
                $var['dto'] = $newDate;
            } 
        }

        if ($conditions != '') {
            $conditions = " WHERE " . $conditions;
        }

        $sql = "SELECT 
        sites.organisation,
        sites.name ,
        sites.location , 
        dampers.barcode ,
        dampers.type ,
        dampers.duct_shape ,
        dampers.duct_dimen ,
        dampers.image,
        damper_test.damper_accessible ,
        damper_test.damper_operated_correctly ,
        damper_test.damper_cleaned ,
        damper_test.damper_reset_correctly ,
        damper_test.further_action_required ,
        damper_test.date_tested , 
        damper_test.engineer_name ,
        
        damper_test.completion_remarks ,
        damper_test.remedial_work_undertaken , 
        damper_test.further_action_required ,
        damper_test.parts_used ,
        damper_test.remarks 


        FROM damper_test 
        INNER JOIN sites ON sites.id = damper_test.site 
        INNER JOIN dampers ON dampers.barcode = damper_test.dampers " . $conditions;
        //. " GROUP BY dampers.barcode ";
        
        $data = array();
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }





$rmex = array('site','dampers','damper_test');
        $rm = array();
        foreach ($rmex as $key => $value) {
                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_table',$value);
            
                $query = $this->db->get();
                $relatedModule = $query->result_array();

                

                if (!empty($relatedModule)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$relatedModule[0]['id']). '/' . $relatedModule[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$relatedModule[0]['id']) . '/' . $relatedModule[0]['component_table'] . '.php'));
                    
                    $relatedModuleConf = unserialize($content);
                    $rm[] = $relatedModuleConf['form_elements'];

                  
                    
                                
                } //form_elements
        }                
        
        $auto_fields = array();

        foreach($rm as $irk => $irv) {

            foreach ($irv as $ik => $iv) {
                $local_arr = array();
                if ($iv['element'][0] == 'select' || $iv['element'][0] == 'autocomplete') {

                        $ii = explode('.', $ik);
                        
                        $auto_fields[$ii[1]] = $iv['element'][1];
                   
                    
                }
            }
        }



///////////////////////
        $fdata = array();
                                    foreach ($data as $dk => $dv) {
                                        $tmp_array = array();
                                        foreach ($dv as $key => $value) {
                                            if (array_key_exists($key, $auto_fields)) {
                                                if (array_key_exists('option_table', $auto_fields[$key])) {

                                                    $this->db->select('*');
                                                    $this->db->from($auto_fields[$key]['option_table']);
                                                    $this->db->where($auto_fields[$key]['option_key'],$value);
                                                    $query = $this->db->get();
                                                    $rdata = $query->row_array();

                                                    if ($auto_fields[$key]['option_table'] == 'crud_users') {
                                                        $vv = ucwords($rdata['user_first_name']) . ' ' . ucwords($rdata['user_las_name']);
                                                    } elseif ($auto_fields[$key]['option_table'] == 'contact') {
                                                        $vv = ucwords($rdata['First_Name']) . ' ' . ucwords($rdata['Last_Name']);
                                                    } else {
                                                        $vv = $rdata[$auto_fields[$key]['option_value']];
                                                    }

                                                    $tmp_array[$key] = $vv;
                                                    
                                                } else {
                                                    $tmp_array[$key] = $auto_fields[$key][$value];
                                                    
                                                }
                                                
                                            } else {
                                                $tmp_array[$key] = $value;
                                                
                                            }
                                            
                                        }
                                        $fdata[$dk] = $tmp_array;
                                        unset($tmp_array);
                                    }
        ///////////////////////////////        


        
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_8'). '/dampers.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_8'). '/dampers.php'));
                    
                    $moduleConf = unserialize($content);

                    

                                
       $this->db->select('*');
        $this->db->from('organisations');
        $this->db->where('id',$fdata[0]['organisation']);
        $module_query = $this->db->get();
        $organisation = $module_query->row_array();
        $var['organisation'] = $organisation;
       	$var['dconfig'] = $moduleConf;

        $var['data'] = $fdata;
        $var['sql'] = $sql;
        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/reports/creport2',$var,true);
        
        
        $file_name = date('mdY') . "_test_results_lists.pdf";
        $pdfFilePath = FCPATH."downloads/reports/".$file_name;

        if (file_exists($pdfFilePath)) {
            $x = 1; 

            do {
                $file_name = date('mdY').'_test_results_individual_'.$x . ".pdf";
                $pdfFilePath = FCPATH."downloads/reports/".$file_name;
                $x++;
            } while (file_exists($pdfFilePath));
        }
        $data['page_title'] = 'Report'; // pass data to the view
         
        if (file_exists($pdfFilePath) == FALSE)
        {
            ini_set('memory_limit','64M'); 
            $html = $var['main_content']; // render the view into HTML
             
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetWatermarkText('', 0.5);
            $pdf->SetMargins(5,0,0,0);
            $pdf->_setPageSize('A4');
            /*$headerHtml = '<div class="header"><table width="100%" border="0" style="margin-left:-3px;margin-right:-3px;"><tr><td class="vendorListHeading" width="150" height="43" style="color:#FFF; padding:0px 20px; background-color:#e2242c!important;">'.date('F d, Y').'</td><td class="vendorListHeading1" style="color:#FFF; padding:10px 20px; background-color:#000!important;">Automatic Smoke and Mechanical Fire Damper Testing Report</td></tr></table></div>';
            $pdf->SetHTMLHeader($headerHtml);
            $pdf->SetHeader($headerHtml);
            $footerHtml = '<div class="footer" style="padding-top:20px; margin-bottom:50px;"><p>Cormeton Electronics Ltd, Unit 6 Jupiter Court, North Shields, NE29 7SN<p></div>';
            $pdf->SetHTMLFooter($footerHtml);
            $pdf->SetFooter($footerHtml);*/
            $pdf->WriteHTML($html); 
            $titlePage = '<div class="header" style="width:100.5%; ">
            <table width="100%" border="0px;" style="margin-left:-3px; margin-right:-3px;">
            <tr>
                <td class="vendorListHeading" width="150" height="43" style="color:#FFF; padding:0px 20px; background-color:#e2242c!important; font-size:12px;">'.date('F d, Y').'
                </td>
                <td class="vendorListHeading1" style="color:#FFF; padding:10px 20px; background-color:#000!important;">Automatic Smoke and Mechanical Fire Damper Testing Report
                </td>
                </tr>
            </table></div><div style="background:url(http://testcrm.cormeton.co.uk/n/media/images/bg-report.jpg) no-repeat top center; background-size:100% 100%; background-position:0px 100%">
            <page size="A4">
                <div class="contentss">
                        <div class="logobig" style="text-align:center; margin-top:70px;">
                            <img src="'.base_url().'/media/images/big-logo.png" alt="logo" style="margin-top:100px;">
                        </div>
                    </div>
                    <div class="after-logo-txt" style="text-align:center; margin-top:30px;">
                        <h1 style="font-weight:normal;font-size:39px; color:#FFF;">Fire & <span style="color:#e2242c; font-size:39px; font-weight:bold;">Smoke Damper</span></h1>
                        <h1 style="font-weight:normal;font-size:39px; color:#FFF;">Test & Inspection <span style="color:#e2242c; font-size:39px; font-weight:bold;">Report</span></h1>
                    </div>
                    <div class="last-txt" style="margin-top:106px;">
                        <h3 style="color:#FFF; font-size:25px;  text-align:center; font-weight:normal;">PREMISES: '.$data[0]['name'].'
            </h3>
            <h3 style="color:#FFF; font-size:25px; text-align:center; font-weight:normal;">
            CUSTOMER:   '.$organisation['name'].'</h3>
            <h3 style="color:#FFF; font-size:25px; text-align:center; font-weight:normal;">FOR THE PERIOD: ('.$var['dfrom'].' - '.$var['dto'].')</h3>
                    </div>
                    
                    <div class="footer" style="padding-top:10px;width:100%; height:33px; margin-top:40px; background:#e2242c; position:absolute; bottom:0px;"><p style="text-align:center; color:#FFF; line-height:10px;">Cormeton Electronics Ltd, Unit 6 Jupiter Court, North Shields, NE29 7SN<p></div>
            </page>
            </div>';     // Title pages ends
            $pdf->WriteHTML($titlePage);
            $pdf->WriteHTML('<pagebreak resetpagenum="0" pagenumstyle="A" />',2);

            $headSection = '<div class="header" style="padding-top:50px;"><table width="100%" border="0" style="margin-left:-3px;margin-right:-3px;"><tr><td class="vendorListHeading" width="150" height="43" style="color:#FFF; padding:0px 20px; background-color:#e2242c!important;">'.date('F d, Y').'</td><td class="vendorListHeading1" style="color:#FFF; padding:10px 20px; background-color:#000!important;">Automatic Smoke and Mechanical Fire Damper Testing Report</td></tr><tr>
            <td colspan="2">
<table width="100%"><tr>
                <td style="padding:10px 20px;"><img src="'.base_url().'/media/images/logo-cormeton.jpg" alt="cormeton"></td>
                <td align="center" style="padding:10px 20px;color:#e2242c;"><h1 style="width:96%;font-size:25px text-align:left; ">'.date('F d').' Damper Inspection Overview (All Results)</h1></td>
  </tr></table>
            </td>
            </tr></table></div>';
            
            $footSection = '<div class="footer"><p>Cormeton Electronics Ltd, Unit 6 Jupiter Court, North Shields, NE29 7SN<p></div></div>';


            $pageSection = '<h1>Page 1</h1>';

            $recordKeyCounter = 0;
            $recordPerPgaeCouner = 0;

            $pageHtml = '';
            $totalRecords = count($fdata);
            $finalSection = '';

            $footerHtml = '<div class="footer" style="padding-top:5px;"><p>Cormeton Electronics Ltd, Unit 6 Jupiter Court, North Shields, NE29 7SN<p></div>';
            $pdf->SetHTMLFooter($footerHtml);
            $pdf->SetFooter($footerHtml);
            $resetVars = false;
            foreach ($fdata as $key => $value) {
                        $imgUrl = '';
                        $fbr = str_replace("[", "", $value['image']);
                        $sbr = str_replace("]", "", $fbr);

                        $data = 'data:image/jpeg;base64,' . $sbr;

                        $image_name = date('mdY') . ".pdf";
                        $image_path = FCPATH."downloads/reports/".$image_name;

                        if (file_exists($image_path)) {
                              $x = 1; 

                          do {
                              $image_name = date('mdY').'_'.$x . ".pdf";
                                $image_path = FCPATH."downloads/reports/".$image_name;
                              $x++;
                          } while (file_exists($image_path));
                        }

                        list($type, $data) = explode(';', $data);
                        list(, $data)      = explode(',', $data);
                        $data = base64_decode($data);

                        if (!file_exists($image_path)) {
                          file_put_contents($image_path, $data);
                        }
                      
                        if (!empty($sbr)) {
                          $imgUrl =  '&nbsp;<img width="50" src="'.base_url()."downloads/reports/".$image_name.'"/>';
                        } 

                $pageHtml .= ' <div class="table-wrap tabs" style="margin-bottom:5px;" id="tab<?php echo $th;?>">
  <div class="table-row1">
  <div class="location">LOCATION</div>
  <div class="location-data"  style="float:left;width:85.1%;  border:1px dotted #CCC; border-right:0px; padding-left:5px; height:27px; line-height:27px;" >
  '.$value['location'].'</div>
  </div> 
  <div class="table-row2">
            <div class="table-col1">
              <div class="tblrow">
                <div class="location">
                    REF NO
                 </div>
                 <div class="inner-col1" style="width:80px; font-size:11px!important; float:left; border:1px dotted #ccc;height:28px;">
                    '.$value['barcode'].'
                 </div>
                 <div class="inner-col2" style="width:100px; float:left; border:1px dotted #ccc; height:27px;">
                    DATE TESTED
                 </div>
                 <div class="inner-col3" style="width:90px; float:left; border:1px dotted #ccc;height:27px;">
                    '.date("d-m-Y", strtotime($value['date_tested'])).'
                 </div>
                 <div class="inner-col4" style="width:100px; float:left; border:1px dotted #ccc;height:27px;">
                      GROUP
                 </div>
                 <div class="inner-col5" style="width:87px; float:left; border:1px dotted #ccc;height:28px;">
                    '.$value['type'].'
                 </div>
              </div>
              <div class="tblrow">
                <div class="location">
                    TYPE
                 </div>
                   <div class="inner-col1" style="width:80px; float:left; border:1px dotted #ccc;height:27px;">
                    '.$value['type'].'
                 </div>
                 <div class="inner-col2" style="width:100px; float:left; border:1px dotted #ccc;height:27px;">
                    DUCT TYPE
                 </div>
                 <div class="inner-col3" style="width:90px; float:left; border:1px dotted #ccc;height:27px;">
                        '.$value['duct_shape'].'
                 </div>
                 <div class="inner-col4" style="width:100px; float:left; border:1px dotted #ccc;height:27px;">
                    DUCT SIZE
                 </div>
                 <div class="inner-col5" style="width:87px; float:left; border:1px dotted #ccc;height:27px;">
                    '.$value['duct_dimen'].'
                 </div>
              </div>
              <div class="tblrow">
                <div class="rowtable-col1" style="width:242px; text-align:center; line-height:27px; float:left; border:1px dotted #CCC;height:27px;">
                    <strong>INSPECTION REPORT</strong>
                </div>
                <div class="rowtable-col2" style="width:123px; text-align:center; line-height:27px;float:left;border:1px dotted #CCC;height:27px;">
                    <strong>ENGINEER</strong>
                </div>
                <div class="rowtable-col3" style="float:left; text-align:center; width:187px;border:1px dotted #CCC; height:27px; line-height:27px">
                   '.$value['engineer_name'].'
                </div>
              </div>
              <div class="tblrow">
                <div class="rowtable-col4"  style="float:left; width:80px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px">
                    ACCESSIBLE
                </div>
                    <div class="rowtable-col5" style="float:left; width:30px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px">
                    '.$value['damper_accessible'].'
                    </div>
                        <div class="rowtable-col4"  style="float:left; width:80px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px">
                    OPERATED
                </div>
                    <div class="rowtable-col5" style="float:left; width:30px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px">
                    '.$value['damper_operated_correctly'].'
                    </div>
                        <div class="rowtable-col4"  style="float:left; width:80px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px">
                    CLEANED
                </div>
                    <div class="rowtable-col5" style="float:left; width:30px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px">
                    '.$value['damper_cleaned'].'
                    </div>
                        <div class="rowtable-col4"  style="float:left; width:71px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px">
                    RESET
                </div>
                    <div class="rowtable-col5" style="float:left; width:30px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px">
                    '.$value['damper_reset_correctly'].'
                    </div>
                   <div class="rowtable-col4"  style="float:left; width:71px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px">
                    
                </div>
                    <div class="rowtable-col5" style="float:left; width:37px; text-align:center;border:1px dotted #CCC; height:29px; line-height:28px">
                    </div>
              </div>
              <div class="tblrow">
                <div class="rowtable-cols1" style="float:left; text-align:center; width:194px;border:1px dotted #CCC; height:27px; line-height:27px">
                    REMEDIAL WORK UNDERTAKEN
                </div>
                <div class="rowtable-col5" style="float:left; width:30px; text-align:center;border:1px dotted #CCC; height:29px; line-height:27px">
               '.$value['remedial_work_undertaken'].'
                    </div>
              <div class="rowtable-cols3" style="float:left; width:329px;border:1px dotted #CCC; height:27px; line-height:30px">
                </div>
              </div>
            </div>
           <div class="tablecol2 photo">
            '.$imgUrl.'
           </div>            
         
 </div>
 <div class="tblrow" style="float:left; width:100%; border:1px dotted #CCC; height:27px;">
        <div class="rowtable-cols1" style="float:left; text-align:center; width:194px;border:1px dotted #CCC; height:28px; 
        line-height:28px;">
                    FURTHER ACTION REQUIRED 
                </div>
                    <div class="rowtable-col5" style="float:left; width:30px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px; padding:2px 0px; ">
                   '.$value['further_action_required'].'
                    </div>
              
             <div class="colrowlast">
                
             </div>      
             
<div class="rowtable-cols1" style="float:left; text-align:center; width:194px;border:1px dotted #CCC; height:27px; line-height:27px">
PARTS USED
 </div>  
        <div class="rowtable-col5" style="float:left; width:80px; text-align:center;border:1px dotted #CCC; height:27px; line-height:27px; padding:2px 0px;">
        '.$value['parts_used'].'
                    </div>
              
             <div class="colrowlast" style="width:387px">
                
             </div>   
            <div class="rowtable-cols1" style="float:left; text-align:center; width:194px;border:1px dotted #CCC; height:27px; line-height:27px">
REMARKS
 </div>   
 <div style="float:left; width:70.3%; border:1px dotted #CCC; height:28px; ">
    <span style="margin-left:10px;">'.$value['remarks'].'</span>
 </div>    
        
 </div>

</div>'.$recordPerPgaeCouner;


            if ($totalRecords <= 3) {
                if (($recordPerPgaeCouner+1) ==$totalRecords) {
                    $finalSection = $headSection.$pageHtml;
                    $pdf->WriteHTML($finalSection); 
                    $pdf->WriteHTML('<pagebreak resetpagenum="0" pagenumstyle="A" />',1);
                    $resetVars = true;
                }
                
            } else {
                if ($recordPerPgaeCouner ==2) {
                    $finalSection = $headSection.$pageHtml;
                    $pdf->WriteHTML($finalSection); 
                    $pdf->WriteHTML('<pagebreak resetpagenum="0" pagenumstyle="A" />',1);
                    $resetVars = true;
                } 
               
                
                if ($resetVars == true) {
                    $recordPerPgaeCouner = 0;
                    $pageHtml = '';
                    $finalSection = '';
                    $resetVars = false;
                }

            }
            $recordPerPgaeCouner++;
                
                
            }
           
           
            
            $pdf->Output($pdfFilePath, 'F'); 
        }
         
        redirect(base_url() . "downloads/reports/".$file_name);
        //$this->load->view('layouts/admin/creport', $var);
    }
    function field_data(){
        $this->load->model('crud_auth');
        $moduleData = $this->input->post('data'); 
        $moduleSplit = explode('.', $moduleData);

                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_table',$moduleSplit[0]);
            
                $query = $this->db->get();
                $modDetail = $query->result_array();

                $moduleConf = array();
                if (!empty($modDetail)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$modDetail[0]['id']). '/' . $modDetail[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$modDetail[0]['id']) . '/' . $modDetail[0]['component_table'] . '.php'));
                    
                    $moduleConf = unserialize($content);

                                
                } //form_elements

                $filedInfo = $moduleConf['form_elements'][$moduleData]['element'][1];
                $output = array();
                if (isset($filedInfo['option_table'])) {
                    
                    $sql = "SELECT * FROM ".$filedInfo['option_table'];
                    $query = $this->db->query($sql);
                    $mdata = array();
                    
                    if (!empty($query)) {
                        foreach ($query->result_array() as $row) {

                            if ($filedInfo['option_table'] == 'crud_users') {
                                                                    // if crud user
                                $output[] = $row[$filedInfo['option_key']].'|'.ucwords($row['user_first_name']) . ' ' . ucwords($row['user_las_name']);
                            } else if($filedInfo['option_table'] == 'contact') {
                                $output[] = $row[$filedInfo['option_key']].'|'.ucwords($row['First_Name']) . ' ' . ucwords($row['Last_Name']);
                            } else {
                                $output[] = $row[$filedInfo['option_key']].'|'.$row[$filedInfo['option_value']];
                            }


                                
                        }
                    }

                    
                } else {
                    foreach ($filedInfo as $key => $value) {

                        $kk = explode('.', $key);

                       

                        $output[] = $key.'|'.$value;

                    }
                    
                }
                echo json_encode(($output));

    }
} 
