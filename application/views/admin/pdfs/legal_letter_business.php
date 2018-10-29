<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Legal Letter for Business</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		font-size: 9pt;
		color: #4F5155;
		font-family: "Arial";
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}
	#elements{
		margin-right:170px;
		height: 230px;
	}
	.col_2{
		width:50%;
		float:left;
	}
	.value{
		margin-bottom: 20px;
	}
	.bm{margin-bottom: 20px;}
	.clear{clear: both;}

	@page :first {
	    background: url("<?=base_url()?>/media/images/flannagans1i.jpg") center  no-repeat; background-size:cover;
	}
	@page {
	    background: url("<?=base_url()?>/media/images/flannagans2i.jpg") center  no-repeat; background-size:cover;
	    margin-top: 150px;
	    margin-left: 60px;
	    margin-bottom: 100px;
	    margin-right: 80px;
	}
	</style>
</head>
<body>

<div id="container">
	<div id='elements'>
		<div class="col_2">
			<?php 
			if($s1==1){
			?>
			<div class="value">
			<?php
				echo $Letter_Title;
			?>
			</div>
			<?php
			}
			if($s3==1 or $s5==1){
			?>
			<div class="value">
			<?php
			if($s3==1){
				echo $Business_Name."<br>";
			}
			if($s5==1){
				echo nl2br($Business_Address);
			}
			?>
			</div>
			<?php
			}
			?>
		</div>
		<div style="width: 48%; float:right;">
			<?php 
			if($s2==1){
			?>
			<div class="value">
			<?php
				if($Letter_Date!='' and $Letter_Date!='1970-01-01' and $Letter_Date!='0000-00-00'){ echo "<strong>Date: </strong>".date("d-m-Y",strtotime($Letter_Date)); }
			?>
			</div>
			<?php
			}
			if($s4==1){
			?>
			<div class="value">
			<?php
				echo "<strong>Our Ref: </strong>".$Our_Ref;
			?>
			</div>
			<?php
			}
			if($s6==1){
			?>
			<div class="value">
			<?php
				echo "<strong>Client ID: </strong>".$Client_ID;
			?>
			</div>
			<?php
			}
			if($s7==1){
			?>
			<div class="value">
			<?php
				echo "<strong>HMRC Ref: </strong>".$HMRC_Ref."<br>";
			?>
			</div>
			<?php
			}
			?>
		</div>
		<div class="clear"></div>
		 
		<?php
		if($s8==1 or $s9==1){
		?>
			<div class="value">
				<strong>Period: </strong>&nbsp;&nbsp;&nbsp;
			<?php
			if($s8==1 and ($Start_Date!='' and $Start_Date!='1970-01-01' and $Start_Date!='0000-00-00')){
				echo date("d-m-Y",strtotime($Start_Date))."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if($s9==1 and ($End_Date!='' and $End_Date!='1970-01-01' and $End_Date!='0000-00-00')){
				echo "To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".date("d-m-Y",strtotime($End_Date));
			}
			?>
			</div>
		<?php
		}
		?>
		<?php
		if($s10==1){
		?>
			<div class="value">
			<?php
				echo "<strong>Subject: </strong>".$Subject;
			?>
			</div>
		<?php
		}
		?>
		<strong>
		<?php
		if($s11==1){
			echo "Dear ".$Dear." ";
		}
		if($s12==1){
			echo ucwords($Name);
		}
		?>
		</strong>

	</div>

	<div id="body">
	<?php if($Letter_Date=='' or $Letter_Date=='1970-01-01' or $Letter_Date=='0000-00-00'){ $Letter_Date=date('d-m-Y'); }?>
		<?=str_replace(array('{LETTER-NAME}', '{BUSINESS-NAME}', '{CURRENT-DATE}', '{CLIENT-ID}'),array($Letter_Title,$Business_Name,$Letter_Date,$Client_ID),$Content)?>
		<br>
		<?php if(trim($Signature_Image)!='' or trim($Contact_Person)!=''){ ?>
		<div class="value">
			Your Sincerely,<br>
			<?php if(trim($Signature_Image)!=''){ ?>
			<img src="<?=base_url()?>/media/images/thumbnail_<?=$Signature_Image?>"><br>
			<?php } ?>
			<?php if(trim($Contact_Person)!=''){ ?>
			(<?=$Contact_Person?>)
			<?php } ?>
		</div>
		<?php } ?>
	</div>
</div>

</body>
</html>