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
<?php $CI = & get_instance();?>
                            <h2 class="page-header"> <?=$rname?> </h2>
                            <i> Total Records: <?php echo count($data);?></i>
							<table class="table table-striped table-bordered table-hover table-condensed flip-content" >
							<?php
								if (!empty($fields_lbs)) {
									?>
										<tr>
											<?php
												foreach ($fields_lbs as $lk => $lv) {
													echo '<th>' . $lv . '</th>';
												}
											?>	
										</tr>
									<?php
								}


								if (!empty($data)) {
									foreach ($data as $dk => $dv) {
										echo '<tr>';
										foreach ($dv as $key => $value) {
											echo '<td>' . $value . '</td>';
										}
										echo '</tr>';
									}
								}
							?>
							</table>
</body>
</html>						