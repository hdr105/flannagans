<?php 


$this->validate=array
	(
		'email.cc' => array
			(
				'rule'=>'email',
				'message'=>'Please enter valid email Address in CC.'
			),
		'email.subject'=>array
			(
				'rule'=>'notEmpty',
				'message'=>'Please enter the value for Subject.'
			),
		'email.body'=>array
			(
				'rule'=>'notEmpty',
				'message'=>'Please enter the value for Body.'
			)

	);
	

$this->form=array
(
    0 => array
        (
            'section_name' => 'email',
            'section_title' => 'Send Email',
            'section_view' => 'accordion',
            'section_size' => 'default',
            'section_fields' => array
                (
                    'email.to' => array
                        (
                            'alias' => 'TO :',
                            'element' => array
                                (
                                    0 => 'text',
                                    1 => array
                                        (
                                            'style' => 'width:210;'
                                        ),

                                    2 => array
                                        (
                                            'attach' => '',
                                            'fieldname' => ''
                                        )

                                )

                        ),

                        'email.cc' => array
                        (
                            'alias' => 'CC :',
                            'element' => array
                                (
                                    0 => 'text',
                                    1 => array
                                        (
                                            'style' => 'width:210;'
                                        ),

                                    2 => array
                                        (
                                            'attach' => '',
                                            'fieldname' => ''
                                        )

                                )

                        ),

                        'email.subject' => array
                        (
                            'alias' => 'Subject :',
                            'element' => array
                                (
                                    0 => 'text',
                                    1 => array
                                        (
                                            'style' => 'width:210;'
                                        ),

                                    2 => array
                                        (
                                            'attach' => '',
                                            'fieldname' => ''
                                        )

                                )

                        ),

						'email.body' => array
                        (
                            'alias' => 'Body',
                            'element' => array
                                (
                                    0 => 'editor',
                                    1 => array
                                        (
                                            'style' => 'width:100%;'
                                        ),

                                    2 => array
                                        (
                                            'attach' =>'' ,
                                            'fieldname' => ''
                                        )

                                )

                        )

                   

                )

        )

);?>

<?php if($_GET['com_id']!=29){
	$this->form[0]['section_fields']['email.attached_document']=array
                        (
                            'alias' => 'Add Document',
                            'element' => array
                                (
                                    0 => 'file',
                                    1 => array
                                        (
                                            'style' => 'display:none;'
                                        ),

                                    2 => array
                                        (
                                            'attach' =>'', 
                                            'fieldname' =>'' 
                                        )

                                )

                        );

}

?>
<?php //require_once(base_url(). 'application/views/admin/scrud/tamplates/quickcreate_form.php');?>
<?php //require_once($this->conf['theme_path'].'/quickcreate_form.php');?>


<?php 
$elements = $this->elements; 
$CI = & get_instance();
$formFields = array();

//echo json_encode($emails);exit;
// echo "<pre>";
// print_r($this->form);
// exit;
foreach ($this->form as $key => $value) {
	foreach ($value['section_fields'] as $key => $value) {
		$formFields[$key] = $value;
	}
}
	


 //echo "<pre>";print_r($formFields);//exit;
$quickCreateFields=array();
 foreach($formFields as $kk => $vv){
 	$c=explode('.',$kk);
$quickCreateFields[]=array('alias'=>$vv['alias'],
						'field'=>$c[1]);
 }

//echo "<pre>";print_r($quickCreateFields);//exit;
// $quickCreateFields = array();
// foreach ($this->quickcreate as $fk => $fv) {
//     if (isset($formFields[$fv['field']])) {
//         $quickCreateFields[$fv['field']] = $formFields[$fv['field']];
//     }
// }

//Validation START
/* echo "<script> function validateform(){ 
	$('#errors').empty();
	$('#errors').append('Please Enter Value For ');
	var foreignkey='1';
	";
foreach ($this->quickcreate as $fk => $fv) {
    if (isset($formFields[$fv['field']])) {
        $quickCreateFields[$fv['field']] = $formFields[$fv['field']];
		if(!empty($this->validate[$fv['field']])){
			$data = explode('.',$fv['field']);
			$final = ucwords($data[0]).ucwords($data[1]);
			echo "if($('#data".$final."').val()==''){";
				echo "$('#errors').append('".$this->quickcreate[$fk]['alias'].", ');";
				echo "foreignkey = 0";
			echo "}";
		}
    }
}
echo "var data = $('#errors').text().slice(0,-2);";
echo "$('#errors').addClass('alert alert-error'); $('#errors').empty(); $('#errors').append('<strong>Error!</strong> '); $('#errors').append(data);";

echo "if(foreignkey != 0) { return 1; } else { return 0; }";
echo "}; </script>"; */
//Validation END
?>
	<div id="quickcreate_form_container">
	<div class="" id="errors" style="margin:0 20px;"></div>
		<?php 


		// foreach ($this->primaryKey as $f) {
  //                 $ary = explode('.', $f);
  //                 if (isset($this->summaryData['key'][$f]) || isset($key[$ary[0]][$ary[1]])) {
  //                     if (isset($this->summaryData['key'][$f])) {
  //                         $_POST['key'][$ary[0]][$ary[1]] = $this->summaryData['key'][$f];
  //                         $rid = $_GET['key'][$f];
  //                     }
  //                     echo __hidden('key.' . $f);
  //                 }
  //             }
              
		if (is_array($formFields)) {
				foreach ($formFields  as $fk => $fv) { ?>
					<div class="form-group " style="margin: 20px;">
						<label for="crudTitle" class="col-md-12">
							<?php echo $fv['alias'];// echo (!empty($v['alias'])) ? $v['alias'] : $field; ?>
							 </label>
						<div class="col-md-12">
							<?php
								$e = $fv['element'];
                                
								echo generateFormElementView($e,$this->da,$fk);
							?>
						</div>
					</div>
			<?php
				}
			} else if ($this->search == 'one_field') {
				$attributes = array();
				echo __text('data.one_field', $attributes);
			} ?>
	</div>
<style>
 input[type="text"] { width: 100%;}
</style>
<script type="text/javascript">

<?php
if(isset($email_id_data)){
	// $email_arr='';
	// $cc=0;
	// foreach($email_id_data as $data_email){
		
	// 	if(isset($data_email['email'])&&$data_email['email']!=''){	
	// 		$email_arr.=$data_email['email'];
	// 		if((count($email_id_data)-1)!=$cc)
	// 		{
	// 			$email_arr.=",";
	// 		}
	// 	}
	// 		$cc++;
	// }


   
}else{
   
}
?>
	//console.log('<?=$file?>');
   $('[name="data[email][to]"]').val('<?=$emails?>'); 
   if($('[name="data[email][to]"]').val().length!==0)
   {
   		$('[name="data[email][to]"]').attr('readonly', true);
   }
   $('[name="data[email][to]"]').attr('required', true);
var element='<input type="hidden" name="email_id_data" value="<?php echo $id_str;?>" >';
	console.log(element);
  	$('#sendmail').append(element);

    if(<?=$_GET['com_id']?>===29){
    var fl_nm_agre=$('.jstree-clicked').html();
    var n= fl_nm_agre.indexOf('</i>');
    n=(n*1)+4;
    var fl=fl_nm_agre.substr(n,fl_nm_agre.length);
    //console.log(fl);
    $('#quickcreate_form_container').append('<div class="form-group " style="margin: 20px;"><label class="col-md-12">File Attacted: </label><div class="col-md-12"><a href="<?=base_url()."media/files/"?>'+ fl +'" target="_blank" style="color:#f00; text-decoration:none;">'+ fl +'</a></div></div>');

 }


</script>

<style type="text/css">
    .select2-dropdown, .select2-search__field {  z-index: 10052; }

</style>
<script>CKEDITOR.replace('dataEmailBody');</script>
