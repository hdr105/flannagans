<?php 
$conf = array (
		'title' => $this->lang->line('user_manager'),
		'limit' => '20',
		'frm_type' => '2',
		'join' =>
		array (
		),
		'order_field' => 'crud_users.user_name',
		'order_type' => 'asc',
		'search_form' =>
		array (
				0 =>
				array (
						'alias' => $this->lang->line('user_name'),
						'field' => 'crud_users.user_name',
				),
				1 =>
				array (
						'alias' => $this->lang->line('group'),
						'field' => 'crud_users.group_id',
				),
				2 =>
				array (
						'alias' => $this->lang->line('first_name'),
						'field' => 'crud_users.user_first_name',
				),
				3 =>
				array (
						'alias' => $this->lang->line('last_name'),
						'field' => 'crud_users.user_las_name',
				),
				4 =>
				array (
						'alias' => $this->lang->line('email'),
						'field' => 'crud_users.user_email',
				),
		),
		'validate' =>
		array (
				'crud_users.user_name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('user_name')),
				),
				'crud_users.user_password' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('user_password')),
				),
				'crud_users.user_email' =>
				array (
						0 =>
						array (
								'rule' => 'notEmpty',
								'message' => sprintf($this->lang->line('please_provide_valid_email'), $this->lang->line('email')),
						),
						1 =>
						array (
								'rule' => 'email',
								'message' => sprintf($this->lang->line('please_provide_valid_email'), $this->lang->line('email')),
						),
				),
				'crud_users.user_first_name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('first_name')),
				),
				'crud_users.user_las_name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('last_name')),
				),
		),
		'data_list' =>
		array (
				'no' =>
				array (
						'alias' => $this->lang->line('no_'),
						'width' => '30',
						'align' => 'center',
						'format' => '{no}',
				),
				
				
				'crud_users.user_first_name' =>
				array (
						'alias' => $this->lang->line('first_name'),
						'width' => '210',
				),
				'crud_users.user_las_name' =>
				array (
						'alias' => $this->lang->line('last_name'),
						'width' => '210',
				),
				
				'crud_users.group_id' =>
				array (
						'alias' => $this->lang->line('group'),
						'width' => '60',
						'align' => 'center',
				),
				'crud_users.site_id' =>
				array (
						'alias' => 'Site',
						'width' => '60',
						'align' => 'center',
				),
				'crud_users.user_status' =>
				array (
						'alias' => $this->lang->line('status'),
						'width' => '60',
						'align' => 'center',
				),
				'action' =>
				array (
						'alias' => $this->lang->line('actions'),
						'format' => '<a href="javascript:;" onclick="__view(\'{ppri}\');" class="btn btn-icon-only blue fa fa-search"></a> <a  href="javascript:;" onclick="__edit(\'{ppri}\'); return false;" class="btn btn-icon-only green fa fa-edit"></a> <a  href="javascript:;" onclick="__delete(\'{ppri}\'); return false;" class="btn btn-icon-only red fa fa-trash"></a>',
						'width' => '250',
						'align' => 'center',
				),
		),
		'form_elements' =>
		array (
			array (
				'section_name'=>'basic_info',
				'section_title'=>'Basic Information',
				'section_view'=>'accordion',
				'section_fields'=>
					array (
						'crud_users.user_name' =>
						array (
								'alias' => $this->lang->line('user_name'),
								'element' =>
								array (
										0 => 'text',
										1 =>
										array (
												'style' => 'width:100%;',
										),
								),
						),
						'crud_users.user_password' =>
						array (
								'alias' => $this->lang->line('user_password'),
								'element' =>
								array (
										0 => 'password',
										1 =>
										array (
												'style' => 'width:100%;',
										),
								),
						),
						'crud_users.group_id' =>
						array (
								'alias' => $this->lang->line('group'),
								'element' =>
								array (
										0 => 'autocomplete',
										1 =>
										array (
												'option_table' => 'crud_groups',
												'option_key' => 'id',
												'option_value' => 'group_name'
										),
										2 =>
										array (
												'style' => 'width:100%;',
										),
								),
						),
						'crud_users.site_id' =>
						array (
								'alias' => $this->lang->line('site'),
								'element' =>
								array (
										0 => 'select',
										1 =>
										array (
												'option_table' => 'sites',
												'option_key' => 'id',
												'option_value' => 'sitename',
										),
										/*2 =>
										array (
												 'multiple' => 'multiple', 
										),*/								
								),
						),
						'crud_users.user_status' =>
						array (
								'alias' => $this->lang->line('status'),
								'element' =>
								array (
										0 => 'radio',
										1 =>
										array (
												1 => $this->lang->line('active'),
												0 => $this->lang->line('inactive'),
										),
								),
						),
					),
		
			),
			array (
					'section_name'=>'other_info',
					'section_title'=>'Other Info',
					'section_view'=>'accordion',
					'section_fields'=>
					array (
						'crud_users.user_first_name' =>
						array (
								'alias' => $this->lang->line('first_name'),
								'element' =>
								array (
										0 => 'text',
										1 =>
										array (
												'style' => 'width:100%;',
										),
								),
						),
						'crud_users.user_las_name' =>
						array (
								'alias' => $this->lang->line('last_name'),
								'element' =>
								array (
										0 => 'text',
										1 =>
										array (
												'style' => 'width:100%;',
										),
								),
						),
						'crud_users.user_email' =>
						array (
								'alias' => $this->lang->line('email'),
								'element' =>
								array (
										0 => 'text',
										1 =>
										array (
												'style' => 'width:100%;',
										),
								),
						),
						
						/*'crud_users.user_info' =>
						array (
								'alias' => $this->lang->line('user_information'),
								'element' =>
								array (
										0 => 'editor',
										1 =>
										array (
												'style' => 'height:210px;width:100%;',
										),
								),
						),*/
					),
				),
			
		),
		'elements' =>
		array (
				'crud_users.user_name' =>
				array (
						'alias' => $this->lang->line('user_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:210px;',
								),
						),
				),
				'crud_users.user_password' =>
				array (
						'alias' => $this->lang->line('user_password'),
						'element' =>
						array (
								0 => 'password',
								1 =>
								array (
										'style' => 'width:210px;',
								),
						),
				),
				'crud_users.group_id' =>
				array (
						'alias' => $this->lang->line('group'),
						'element' =>
						array (
								0 => 'select',
								1 =>
								array (
										'option_table' => 'crud_groups',
										'option_key' => 'id',
										'option_value' => 'group_name',
								),
						),
				),
				'crud_users.site_id' =>
				array (
						'alias' => $this->lang->line('site'),
						'element' =>
						array (
								0 => 'select',
								1 =>
								array (
										'option_table' => 'sites',
										'option_key' => 'id',
										'option_value' => 'sitename',
								),
								/*2 =>
								array (
										 'multiple' => 'multiple', 
								),*/								
						),
				),
				'crud_users.user_email' =>
				array (
						'alias' => $this->lang->line('email'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:210px;',
								),
						),
				),
				'crud_users.user_first_name' =>
				array (
						'alias' => $this->lang->line('first_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:390px;',
								),
						),
				),
				'crud_users.user_las_name' =>
				array (
						'alias' => $this->lang->line('last_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:390px;',
								),
						),
				),
				'crud_users.user_status' =>
				array (
						'alias' => $this->lang->line('status'),
						'element' =>
						array (
								0 => 'radio',
								1 =>
								array (
										1 => $this->lang->line('active'),
										0 => $this->lang->line('inactive'),
								),
						),
				),
				/*'crud_users.user_info' =>
				array (
						'alias' => $this->lang->line('user_information'),
						'element' =>
						array (
								0 => 'editor',
						),
				),*/
		),
);