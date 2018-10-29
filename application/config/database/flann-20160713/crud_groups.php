<?php 
$conf = array (
		'title' => $this->lang->line('group_manager'),
		'limit' => '20',
		'frm_type' => '2',
		'join' =>
		array (
		),
		'order_field' => 'crud_groups.group_name',
		'order_type' => 'asc',
		'search_form' =>
		array (
				0 =>
				array (
						'alias' => $this->lang->line('group_name'),
						'field' => 'crud_groups.group_name',
				),
				1 =>
				array (
						'alias' => $this->lang->line('description'),
						'field' => 'crud_groups.group_description',
				),
		),
		'validate' =>
		array (
				'crud_groups.group_name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('group_name')),
				),
		),
		'data_list' =>
		array (
				'no' =>
				array (
						'alias' => $this->lang->line('no_'),
						'width' => 40,
						'align' => 'center',
						'format' => '{no}',
				),
				'crud_groups.group_name' =>
				array (
						'alias' => $this->lang->line('group_name'),
				),
				'action' =>
				array (
						'alias' => $this->lang->line('actions'),
						'format' => '<a href="javascript:;" onclick="__view(\'{ppri}\');" class="btn btn-icon-only blue fa fa-search"></a> <a  href="javascript:;" onclick="__edit(\'{ppri}\'); return false;" class="btn btn-icon-only green fa fa-edit"></a> <a  href="javascript:;" onclick="__delete(\'{ppri}\'); return false;" class="btn btn-icon-only red fa fa-trash"></a>',
						'width' => 130,
						'align' => 'center',
				),
		),
		'form_elements' =>
		array (
			array (
					'section_name'=>'group_info',
					'section_title'=>'User Role Details',
					'section_view'=>'accordion',
					'section_fields'=>
					array (
						'crud_groups.group_name' =>
						array (
								'alias' => $this->lang->line('group_name'),
								'element' =>
								array (
										0 => 'text',
										1 =>
										array (
												'style' => 'width:100%;',
										),
								),
						),
						'crud_groups.dashboard' =>
						array (
								'alias' => 'Related Dashboard',
								'element' =>
								array (
								    0 => 'radio',
								    1 => 
								    array (
								       1 => 'Admin Dashboard',
								       2 => 'User Dashboard',
								       3 => 'Client Dashboard',
								    ),

								),
						),
						'crud_groups.group_description' =>
						array (
								'alias' => $this->lang->line('description'),
								'element' =>
								array (
										0 => 'editor',
										1 =>
										array (
												'style' => 'height:210px;width:100%;',
										),
								),
						),
					),
			),
		),
		'elements' =>
		array (
				'crud_groups.group_name' =>
				array (
						'alias' => $this->lang->line('group_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:650px;',
								),
						),
				),
				'crud_groups.dashboard' =>
				array (
						'alias' => 'Related Dashboard',
						'element' =>
						array (
						    0 => 'radio',
						    1 => 
						    array (
						       1 => 'Admin Dashboard',
						       2 => 'User Dashboard',
						       3 => 'Client Dashboard',
						    ),

						),
				),
				'crud_groups.group_description' =>
				array (
						'alias' => $this->lang->line('description'),
						'element' =>
						array (
								0 => 'editor',
						),
				),
		),
);