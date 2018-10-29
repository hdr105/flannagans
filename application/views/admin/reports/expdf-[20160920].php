<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Report</title>

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
        background: url("<?=base_url()?>media/images/flannagans2i.jpg") center  no-repeat; background-size:cover;
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
                            <h1 class="page-header"> <?=$rname?> </h1>
                            <i>Total Records:<?=count($result_data)?></i>
							<table class="table table-striped table-bordered table-hover table-condensed flip-content" >
							<?php
                               //echo $sql; exit;
                            // echo "<pre>";
                            // print_r($result_data);
                            // exit;
                                $r_size = $rtdFields_size;
                                $p_size = $pmFields_size;

								if (!empty($fields_lbs)) 
                                {
                                    ?>
                                        <tr>
                                            <?php
                                                foreach ($fields_lbs as $lk => $lv) {
                                                    foreach ($lv as $fdkey => $fdvalue) {
                                                        echo '<th>' . $fdvalue . '</th>';
                                                    }
                                                }
                                            ?>  
                                        </tr>
                                        
                                    <?php
                                }


								if (!empty($result_data)) {

                                    /////////// check how many related modeules data is present at each record ///////////////////////
                                    $da = array();
                                    foreach ($result_data as $key => $value) {
                                        foreach ($value as $key1 => $value1) {
                                            
                                            if(is_array($value1))
                                            {
                                                $da[] = count($value1);
                                            }
                                        }
                                    }

                                    $new_array = array();
                                    $u=0;
                                    $v=0;
                                    foreach ($result_data as $key => $value) {
                                        foreach ($value as $key1 => $value1) {
                                            if(is_array($value1))
                                            {
                                                $new_array[$u][$v] = count($value1);
                                                $v++;
                                                if($v == count($rel_fields))
                                                {
                                                    $u++;
                                                    $v=0;
                                                }
                                            }
                                        }
                                    }
//////////////////////////////////////////////////////////////////////////////////////////

                                    if( count($rel_fields) == 1 || empty($rel_fields) )
                                    {
                                        foreach ($result_data as $dkey => $dvalue) {

                                            $count = $da[$dkey];
                                            echo "<tr>";
                                            $str = '';

                                            foreach ($dvalue as $dk => $dv) {

                                                if ( ! is_array($dv) )
                                                {
                                                    if(isset($dv) && trim($dv) != "")
                                                    {
                                                        $str .="<td>".$dv."</td>";
                                                    }
                                                    else
                                                    {
                                                        $str .= "<td>-</td>";
                                                    }
                                                    
                                                }
                                                else if ( is_array($dv) )
                                                {   
                                                    foreach ($dv as $key => $value) {

                                                        if( !empty($value) )
                                                        {
                                                            foreach ($value as $vkey => $vvalue) {
                                                                if(isset($vvalue) && trim($vvalue) != "")
                                                                {
                                                                    $str.="<td>".$vvalue."</td>";
                                                                }
                                                                else
                                                                {
                                                                    $str .= "<td>-</td>";
                                                                }
                                                            }
                                                            $str.="</tr><tr>";
                                                            $count = $count - 1;
                                                            if($count>0)
                                                            {   
                                                                for ($j=0;$j<$p_size;$j++)
                                                                {
                                                                    $str .="<td></td>";
                                                                }
                                                                $count--;
                                                            }
                                                        }
                                                        else
                                                        {
                                                            for($i=0 ; $i<$rtdFields_size ; $i++) 
                                                            {
                                                                $str .="<td>-</td>";
                                                            }
                                                        }                                         }
                                                }
                                            }
                                            echo $str."</tr>";
                                        }
                                    }
                                    else
                                    {
                                        //$flag = 'false';
                                        foreach($result_data as $resk => $resval)
                                        {   
                                            for($z=0 ; $z<max($new_array[$resk]) ; $z++)
                                            {
                                                echo "<tr>";
                                                $str = '';

                                                foreach ($resval as $rkey => $rvalue) {

                                                    $rv = $rvalue[$z];
                                                    $l=0;
                                                    
                                                    if(! is_array($rvalue))
                                                    {
                                                        $str .= $rvalue ;
                                                    }

                                                    else if(is_array($rvalue) && !empty($rv))
                                                    {
                                                        foreach ($rv as $k => $v) {

                                                            if(isset($rv[$k]) && trim($rv[$k]) != "")
                                                            {
                                                                $str .= "<td>".$rv[$k]."</td>";
                                                                $flag ='true';
                                                            }
                                                            else
                                                            {
                                                                $str .= "<td> - </td>";
                                                            }
                                                            
                                                        }
                                                        
                                                    }
                                                    /*else if($flag == 'true')
                                                    {
                                                        echo "when flag true 1 : ".$rel_fields[$tables[$rkey]];
                                                        for($i=0 ; $i< count($rel_fields[$tables[$rkey]]) ; $i++)
                                                        {
                                                            $str .= "<td>-</td>";
                                                        }
                                                    }*/
                                                    else if(is_array($rvalue) && empty($rv))
                                                    {
                                                        //echo " else 2 : ".$rel_fields[$tables[$rkey]];
                                                        for($i=0 ; $i< count($rel_fields[$tables[$rkey]]) ; $i++)
                                                        {
                                                            $str .= "<td>-</td>";
                                                        }
                                                    }
                                                    
                                                }
                                                //$flag ='false';
                                                echo $str."</tr>";
                                            }
                                        }
                                    }
                                }
                           
							?>
							</table>
</body>
</html>