<?php
$conf = array (
		'title' => $this->lang->line('group_component_manager'),
		'limit' => '20',
		'frm_type' => '2',
		'join' =>
		array (
		),
		'order_field' => 'crud_group_components.id',
		'order_type' => 'asc',
		'search_form' =>
		array (
				0 =>
				array (
						'alias' => $this->lang->line('name'),
						'field' => 'crud_group_components.name',
				),
		),
		'validate' =>
		array (
				'crud_group_components.name' =>
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
				'crud_group_components.name' =>
				array (
						'alias' => $this->lang->line('name'),
				),
				'action' =>
				array (
						'alias' => $this->lang->line('actions'),
						'format' => '<a href="javascript:;" onclick="__view(\'{ppri}\'); return false;" class="btn btn-icon-only blue fa fa-search"></a> <a  onclick="__edit(\'{ppri}\'); return false;" class="btn btn-icon-only green fa fa-edit"></a> <a onclick="__delete(\'{ppri}\'); return false;" class="btn btn-icon-only red fa fa-trash"></a>',
						'width' => 130,
						'align' => 'center',
				),
		),
		'form_elements' =>
		array (
			array (
					'section_name'=>'group_info',
					'section_title'=>'Role Details',
					'section_view'=>'accordion',
					'section_fields'=>
					array (
						'crud_group_components.name' =>
						array (
								'alias' => $this->lang->line('name'),
								'element' =>
								array (
										0 => 'text',
										
										
								),
						),
						'crud_group_components.description' =>
						array (
								'alias' => $this->lang->line('description'),
								'element' =>
								array (
										0 => 'textarea',
								),
						),
						'crud_group_components.type' =>
					      array (
					        'alias' => $this->lang->line('status'),
					        'element' =>
					        array (
					          0 => 'select',
					          1 =>
					          array (
					            0 => 'Visible & Active',
					            1 => 'Hidden  & Active',
					            2 => 'InActive',
					          ),
					        ),
					      ),
					)
			),
		),
		'elements' =>
		array (
				'crud_group_components.name' =>
				array (
						'alias' => $this->lang->line('name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:410px;',
								),
						),
				),
				'crud_group_components.description' =>
				array (
						'alias' => $this->lang->line('description'),
						'element' =>
						array (
								0 => 'editor',
						),
				),
		),
);