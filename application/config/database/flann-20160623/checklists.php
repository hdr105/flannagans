<?php 
$conf = array (
		'title' => 'Checklists Manager',
		'limit' => '20',
		'frm_type' => '2',
		'join' =>
		array (
		),
		'order_field' => 'checklists.id',
		'order_type' => 'asc',
		'search_form' =>
		array (
			0 =>
			array (
					'alias' => $this->lang->line('name'),
					'field' => 'checklists.component_name',
			),
			1 =>
			array (
					'alias' => 'Job / Service',
					'field' => 'checklists.group_id',
			),
		),
		'validate' =>
		array (
			'checklists.component_name' =>
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
			'checklists.component_name' =>
			array (
					'alias' => $this->lang->line('name'),
			),
			'checklists.group_id' =>
			array (
					'alias' => 'Job / Service',
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
				'section_title'=>'Checklist Detail',
				'section_view'=>'accordion',
				'section_fields'=>
				array (
					'checklists.component_name' =>
					array (
						'alias' => $this->lang->line('name'),
						'element' =>
						array (
								0 => 'text',
								
						),
					),
					'checklists.group_id' =>
					array (
							'alias' => 'Job / Service',
							'element' =>
						array (
					        0 => 'select',
					        1 =>
				          	array (
					            1 => 'Letter / Official Document',
					            2 => 'Tax Planning',
					            3 => 'Inheritance',
					            4 => 'General Advice',
					            5 => 'Other',
					            6 => 'VAT',
					            7 => 'Payroll',
					            8 => 'Annual Returns',
					            9 => 'Accounts',
					            10 => 'Tax',
				          	),
				        ),
					),
				),
			),
		),
		'elements' =>
		array (
			'checklists.component_name' =>
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
			'checklists.group_id' =>
			array (
					'alias' => 'Job / Service',
					'element' =>
				array (
			        0 => 'select',
			        1 =>
		          	array (
			            1 => 'Letter / Official Document',
			            2 => 'Tax Planning',
			            3 => 'Inheritance',
			            4 => 'General Advice',
			            5 => 'Other',
			            6 => 'VAT',
			            7 => 'Payroll',
			            8 => 'Annual Returns',
			            9 => 'Accounts',
			            10 => 'Tax',
		          	),
		        ),
			),
		),
);