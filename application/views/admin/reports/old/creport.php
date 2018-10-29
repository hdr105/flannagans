<page size="A4">
  <div class="header">
<div class="header">
            <table width="100%">
            <tr>
                <td class="vendorListHeading" width="150" height="43" style="color:#FFF; padding:0px 20px; background-color:#e2242c!important; font-size:12px;"><?php echo date('F d, Y')?>
                </td>
                <td class="vendorListHeading1" style="color:#FFF; padding:10px 20px; background-color:#000!important;">Automatic Smoke and Mechanical Fire Damper Testing Report
                </td>
                </tr>
            </table></div>
  
      <table width="100%">
            <tr>
            <td colspan="2">
                <table width="100%">
                  <tr>
                    <td style="padding:10px 20px;"><img src="<?php echo base_url(); ?>/media/images/logo-cormeton.jpg" alt="cormeton"></td>
                    <td align="center" style="padding:10px 20px;color:#e2242c;"><h1 style="width:96%;font-size:25px text-align:left; "><?php echo date('F d'); ?> Damper Inspection Overview (All Results)</h1></td>
                  </tr>
                </table>
            </td>
            </tr>
        </table>
    </div>
      <div class="contents">
        <table width="99%" align="center">
            	<tr class="contentareatr" style="background:#cacaca; border:1px solid #cacaca">
                	<td>Ref No</td>
                    <td>Date </td>
                    <td>Location</td>
                    <td>Pass/Fail</td>
                    <td>Defects</td>
                    <td>Photos </td>
               </tr>
              <?php 
                foreach ($data as $key => $value) { 
                  ?>
                <tr>
                    <td><?php echo $value['barcode']; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($value['date_tested'])); ?></td>
                    <td><?php echo $value['location']; ?></td>
                    <td><?php echo $value['damper_accessible']; ?></td>
                    <td><?php echo $value['duct_dimen']; ?></td>
                    <td><?php 
                      $imgArr = explode(',', $value['image'] );
                      //foreach ($imgArr as $ikey => $ivalue) {
                        $fbr = str_replace("[", "", $ivalue);
                        $sbr = str_replace("]", "", $fbr);

                        $data = 'data:image/jpeg;base64,' . $value['image'];

                        //$file_name = $value['barcode'] .'-'. $value['date_tested'] . '.jpg';


                        $file_name = $value['barcode'] .'_'. $value['date_tested']  . ".jpg";
                        $pdfFilePath = FCPATH."downloads/reports/".$file_name;

                        if (file_exists($pdfFilePath)) {
                            $x = 1; 

                            do {
                                $file_name = $value['barcode'] .'_'. $value['date_tested'].'_'.$x . ".jpg";
                                $pdfFilePath = FCPATH."downloads/reports/".$file_name;
                                $x++;
                            } while (file_exists($pdfFilePath));
                        }


                        //$pdfFilePath = FCPATH."downloads/reports/".$file_name;

                        list($type, $data) = explode(';', $data);
                        list(, $data)      = explode(',', $data);
                        $data = base64_decode($data);

                        if (!file_exists($pdfFilePath)) {
                          file_put_contents($pdfFilePath, $data);
                        }
                      
                        if (file_exists($pdfFilePath)) {
                          echo '&nbsp;<img width="50" src="'.base_url()."downloads/reports/".$file_name.'"/>';
                        } 
                      //}
                   
                      //echo base_url()."downloads/reports/".$file_name;

                    ?></td>
               </tr>
              <?php   } ?>
</table>
</div> 
</page>
<style>
body {
  background: white; 
  font-family: 'Lato', sans-serif;
}
.contents table, .contents table tr td{ border:1px solid #cacaca; height:27px;}
.contents table{border-collapse: collapse;} 
.contents table .contentareatr td{border:1px solid #FFF }
tr.contentareatr {height:27px; border:1px solid #cacaca!important}
.contents tr td{padding:5px 10px;}
.contents tr:nth-child(odd) {
    background-color: #f2f2f2;
}
tr.contentareatr {height:27px; border:1px solid #cacaca!important}

      
page[size="A4"] {
  background: white;
  width: 21cm;
  height: 29.7cm;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  border: 1px solid grey;
  position:relative;
}
.footer{ width:100%; height:43px; background:#e2242c; position:absolute; bottom:0px;}
.footer p{ text-align:center; color:#FFF; line-height:10px;}
@media print {
  .footer{ position:absolute; bottom:10px;}
  .footer p{line-height:10px;}
  body, page[size="A4"] {
    margin: 0;
    box-shadow: 0;
  }
 .contentareatr {background-color: #cacaca !important;
    -webkit-print-color-adjust: exact; } 
.contents tr:nth-child(odd) {
    background-color: #f2f2f2;
     -webkit-print-color-adjust: exact; 
} 
  .footer{ width:100%; height:43px; background:#e2242c;}
  td.vendorListHeading {
    background-color: #e2242c !important;
    -webkit-print-color-adjust: exact; 
}
td.vendorListHeading1{
  background-color: #000 !important;
    -webkit-print-color-adjust: exact; 
  }
.footer {
  background-color: #e2242c !important;
    -webkit-print-color-adjust: exact;
  }
}
</style>