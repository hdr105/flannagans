<?php exit; ?>
a:12:{s:5:"title";s:12:"My Documents";s:5:"limit";s:2:"20";s:8:"frm_type";s:1:"2";s:4:"join";a:0:{}s:11:"search_form";a:4:{i:0;a:2:{s:5:"alias";s:7:"Subject";s:5:"field";s:21:"crm_documents.subject";}i:1;a:2:{s:5:"alias";s:11:"Folder Name";s:5:"field";s:25:"crm_documents.folder_name";}i:2;a:2:{s:5:"alias";s:4:"File";s:5:"field";s:18:"crm_documents.file";}i:3;a:2:{s:5:"alias";s:6:"Status";s:5:"field";s:20:"crm_documents.status";}}s:13:"masseidt_form";a:2:{i:0;a:2:{s:5:"alias";s:11:"Folder Name";s:5:"field";s:25:"crm_documents.folder_name";}i:1;a:2:{s:5:"alias";s:6:"Status";s:5:"field";s:20:"crm_documents.status";}}s:12:"summary_form";a:5:{i:0;a:2:{s:5:"alias";s:7:"Subject";s:5:"field";s:21:"crm_documents.subject";}i:1;a:2:{s:5:"alias";s:11:"Folder Name";s:5:"field";s:25:"crm_documents.folder_name";}i:2;a:2:{s:5:"alias";s:4:"File";s:5:"field";s:18:"crm_documents.file";}i:3;a:2:{s:5:"alias";s:6:"Status";s:5:"field";s:20:"crm_documents.status";}i:4;a:2:{s:5:"alias";s:7:"Version";s:5:"field";s:30:"crm_documents.document_version";}}s:16:"quickcreate_form";a:4:{i:0;a:2:{s:5:"alias";s:7:"Subject";s:5:"field";s:21:"crm_documents.subject";}i:1;a:2:{s:5:"alias";s:11:"Folder Name";s:5:"field";s:25:"crm_documents.folder_name";}i:2;a:2:{s:5:"alias";s:4:"File";s:5:"field";s:18:"crm_documents.file";}i:3;a:2:{s:5:"alias";s:6:"Status";s:5:"field";s:20:"crm_documents.status";}}s:8:"validate";a:5:{s:21:"crm_documents.subject";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:35:"Please enter the value for Subject.";}s:25:"crm_documents.folder_name";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:39:"Please enter the value for Folder Name.";}s:25:"crm_documents.assigned_to";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:39:"Please enter the value for Assigned To.";}s:18:"crm_documents.file";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:32:"Please enter the value for File.";}s:20:"crm_documents.status";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:34:"Please enter the value for Status.";}}s:9:"data_list";a:6:{s:29:"crm_documents.crm_documentsno";a:1:{s:5:"alias";s:7:"Doc No.";}s:21:"crm_documents.subject";a:1:{s:5:"alias";s:7:"Subject";}s:18:"crm_documents.file";a:1:{s:5:"alias";s:4:"File";}s:25:"crm_documents.folder_name";a:1:{s:5:"alias";s:11:"Folder Name";}s:20:"crm_documents.status";a:1:{s:5:"alias";s:6:"Status";}s:6:"action";a:4:{s:5:"alias";s:7:"Actions";s:6:"format";s:328:"<a href="javascript:;" onclick="__view('{ppri}');" class="btn btn-icon-only blue fa fa-search"></a> <a  href="javascript:;" onclick="__edit('{ppri}'); return false;" class="btn btn-icon-only green fa fa-edit"></a> <a  href="javascript:;" onclick="__delete('{ppri}'); return false;" class="btn btn-icon-only red fa fa-trash"></a>";s:5:"width";i:85;s:5:"align";s:6:"center";}}s:13:"form_elements";a:1:{i:0;a:5:{s:12:"section_name";s:8:"document";s:13:"section_title";s:8:"Document";s:12:"section_view";s:9:"accordion";s:12:"section_size";s:7:"default";s:14:"section_fields";a:8:{s:21:"crm_documents.subject";a:2:{s:5:"alias";s:7:"Subject";s:7:"element";a:3:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:10:"width:210;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:25:"crm_documents.folder_name";a:2:{s:5:"alias";s:11:"Folder Name";s:7:"element";a:4:{i:0;s:6:"select";i:1;a:7:{s:12:"option_table";s:11:"doc_folders";s:10:"option_key";s:2:"id";s:12:"option_value";s:11:"folder_name";s:16:"option_condition";N;s:13:"option_column";N;s:13:"option_action";N;s:17:"option_customtext";N;}i:2;a:1:{s:5:"style";s:10:"width:100%";}i:3;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:25:"crm_documents.assigned_to";a:2:{s:5:"alias";s:11:"Assigned To";s:7:"element";a:4:{i:0;s:6:"select";i:1;a:7:{s:12:"option_table";s:10:"crud_users";s:10:"option_key";s:2:"id";s:12:"option_value";s:13:"user_las_name";s:16:"option_condition";s:7:"site_id";s:13:"option_column";s:7:"site_id";s:13:"option_action";s:1:"=";s:17:"option_customtext";s:27:"group_id!=1 AND group_id!=5";}i:2;a:1:{s:5:"style";s:10:"width:100%";}i:3;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:25:"crm_documents.description";a:2:{s:5:"alias";s:11:"Description";s:7:"element";a:3:{i:0;s:8:"textarea";i:1;a:1:{s:5:"style";s:10:"width:100%";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:18:"crm_documents.file";a:2:{s:5:"alias";s:4:"File";s:7:"element";a:3:{i:0;s:4:"file";i:1;a:1:{s:5:"style";s:13:"display:none;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:20:"crm_documents.status";a:2:{s:5:"alias";s:6:"Status";s:7:"element";a:4:{i:0;s:6:"select";i:1;a:2:{i:1;s:6:"Active";i:2;s:8:"Inactive";}i:2;a:1:{s:5:"style";s:10:"width:100%";}i:3;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:30:"crm_documents.document_version";a:2:{s:5:"alias";s:16:"Document Version";s:7:"element";a:3:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:10:"width:210;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:28:"crm_documents.related_record";a:2:{s:5:"alias";s:14:"Related Record";s:7:"element";a:3:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:10:"width:210;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}}}}s:8:"elements";a:1:{i:0;a:5:{s:12:"section_name";s:8:"document";s:13:"section_title";s:8:"Document";s:12:"section_view";s:9:"accordion";s:12:"section_size";s:7:"default";s:14:"section_fields";a:8:{s:21:"crm_documents.subject";a:2:{s:5:"alias";s:7:"Subject";s:7:"element";a:3:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:10:"width:210;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:25:"crm_documents.folder_name";a:2:{s:5:"alias";s:11:"Folder Name";s:7:"element";a:4:{i:0;s:6:"select";i:1;a:7:{s:12:"option_table";s:11:"doc_folders";s:10:"option_key";s:2:"id";s:12:"option_value";s:11:"folder_name";s:16:"option_condition";N;s:13:"option_column";N;s:13:"option_action";N;s:17:"option_customtext";N;}i:2;a:1:{s:5:"style";s:10:"width:100%";}i:3;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:25:"crm_documents.assigned_to";a:2:{s:5:"alias";s:11:"Assigned To";s:7:"element";a:4:{i:0;s:6:"select";i:1;a:7:{s:12:"option_table";s:10:"crud_users";s:10:"option_key";s:2:"id";s:12:"option_value";s:13:"user_las_name";s:16:"option_condition";s:7:"site_id";s:13:"option_column";s:7:"site_id";s:13:"option_action";s:1:"=";s:17:"option_customtext";s:27:"group_id!=1 AND group_id!=5";}i:2;a:1:{s:5:"style";s:10:"width:100%";}i:3;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:25:"crm_documents.description";a:2:{s:5:"alias";s:11:"Description";s:7:"element";a:3:{i:0;s:8:"textarea";i:1;a:1:{s:5:"style";s:10:"width:100%";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:18:"crm_documents.file";a:2:{s:5:"alias";s:4:"File";s:7:"element";a:3:{i:0;s:4:"file";i:1;a:1:{s:5:"style";s:13:"display:none;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:20:"crm_documents.status";a:2:{s:5:"alias";s:6:"Status";s:7:"element";a:4:{i:0;s:6:"select";i:1;a:2:{i:1;s:6:"Active";i:2;s:8:"Inactive";}i:2;a:1:{s:5:"style";s:10:"width:100%";}i:3;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:30:"crm_documents.document_version";a:2:{s:5:"alias";s:16:"Document Version";s:7:"element";a:3:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:10:"width:210;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:28:"crm_documents.related_record";a:2:{s:5:"alias";s:14:"Related Record";s:7:"element";a:3:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:10:"width:210;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}}}}}