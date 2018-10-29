<?php 
$conf = array (
		'title' => $this->lang->line('component_manager'),
		'limit' => '20',
		'frm_type' => '2',
		'join' =>
		array (
		),
		'order_field' => 'crud_components.id',
		'order_type' => 'asc',
		'search_form' =>
		array (
				0 =>
				array (
						'alias' => $this->lang->line('name'),
						'field' => 'crud_components.component_name',
				),
				1 =>
				array (
						'alias' => $this->lang->line('group'),
						'field' => 'crud_components.group_id',
				),
		),
		'validate' =>
		array (
				'crud_components.component_name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('name')),
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
				'crud_components.component_name' =>
				array (
						'alias' => $this->lang->line('name'),
				),
				'crud_components.group_id' =>
				array (
						'alias' => $this->lang->line('group'),
				),
				'crud_components.component_table' =>
				array (
						'alias' => $this->lang->line('table_name'),
				),
				'action' =>
				array (
						'alias' => $this->lang->line('actions'),
						'format' => '<a href="javascript:;" onclick="__view(\'{ppri}\'); return false;" class="btn btn-icon-only blue fa fa-search"></a> <a href="javascript:;" onclick="__edit(\'{ppri}\'); return false;" class="btn btn-icon-only green fa fa-edit"></a> <a href="javascript:;" onclick="__delete(\'{ppri}\'); return false;" class="btn btn-icon-only red fa fa-trash"></a>',
						'width' => 130,
						'align' => 'center',
				),
		),
		'form_elements' =>
		array (
			array (
					'section_name'=>'group_info',
					'section_title'=>'Component Detail',
					'section_view'=>'accordion',
					'section_fields'=>
					array (
						'crud_components.component_name' =>
						array (
								'alias' => $this->lang->line('name'),
								'element' =>
								array (
										0 => 'text',
										
								),
						),
						'crud_components.group_id' =>
						array (
								'alias' => $this->lang->line('group'),
								'element' =>
								array (
										0 => 'select',
										1 =>
										array (
												'option_table' => 'crud_group_components',
												'option_key' => 'id',
												'option_value' => 'name',
										),
								),
						),
					),
			),
		),
		'elements' =>
		array (
				'crud_components.component_name' =>
				array (
						'alias' => $this->lang->line('name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:208px;',
								),
						),
				),
				'crud_components.group_id' =>
				array (
						'alias' => $this->lang->line('group'),
						'element' =>
						array (
								0 => 'select',
								1 =>
								array (
										'option_table' => 'crud_group_components',
										'option_key' => 'id',
										'option_value' => 'name',
								),
						),
				),
		),
);