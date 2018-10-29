<div class="row">&nbsp;</div>
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal">
            <div class="form-body">
                <div id="dataListConfigCommon" style="margin-top: 10px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5"><?php echo $this->lang->line('title'); ?></label>
                                <div class="col-md-7">
                                    <input type="text"   class="form-control" id="crudTitle" name="crud[title]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5"><?php echo $this->lang->line('rows_per_page'); ?></label>
                                <div class="col-md-7">
                                    <input type="text"   class="form-control" name="crud[rows_per_page]" id="crudRowsPerPage" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5"><?php echo $this->lang->line('order_by'); ?></label>
                                <div class="col-md-7">
                                    <div class="col-md-8" style="padding-left: 0;">
                                        <select class="form-control" name="crud[order_field]" id="crudOrderField">
                                            <option value=""></option>
                                            <?php foreach($fields as $f){ ?>
                                             <option value="<?php echo $f['Field']; ?>"><?php echo $f['Field']; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4" style="padding-left: 0; padding-right: 0;">
                                        <select class="form-control col-md-5" name="crud[order_type]" id="crudOrderType">
                                            <option value=""></option>
                                            <option value="asc"><?php echo $this->lang->line('asc');?></option>
                                            <option value="desc"><?php echo $this->lang->line('desc');?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5"><?php echo $this->lang->line('no_column'); ?></label>
                                <div class="col-md-7">
                                    <input type="checkbox" value="1" id="crudNoColumn">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5"><?php echo $this->lang->line('join'); ?></label>
                                <div class="col-md-7">
                                    <div id="dataListJoin" style="margin-bottom: 5px;"></div>
                                    <input type="button" class="btn" value="<?php echo $this->lang->line('add_join'); ?>" id="addJoinButton"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div  class="col-md-12">
                            <div class="tabbable tabbable-tabdrop">
                                <ul id="dataListConfigElement" class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#filter" data-toggle="tab"><?php echo $this->lang->line('filter_elements'); ?></a>
                                    </li>
                                    <li>
                                        <a  data-toggle="tab" href="#column"><?php echo $this->lang->line('column_elements'); ?></a>
                                    </li>
                                    <li>
                                        <a  data-toggle="tab" href="#quickcreate"><?php echo 'Quick Create'; ?></a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab"  href="#massedit"><?php echo 'Mass Edit'; ?></a></a>
                                    </li>
                                    <li>
                                        <a  data-toggle="tab" href="#summary"><?php echo 'Summary View'; ?></a>
                                    </li>
                                </ul>
                                <div id="dataListConfigElementContent"  class="tab-content">
                                    <div class="tab-pane fade in active" id="filter">
                                        <div class="row-fluid">
                                            <div id="filter_container">
                                                <ul class="nav nav-tabs nav-stacked" id="filter_elements"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="column">
                                        <div class="row-fluid">
                                            <div id="column_container">
                                                <ul class="nav nav-tabs nav-stacked" id="column_elements"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="quickcreate">
                                        <div class="row-fluid">
                                            <div id="quickcreate_container">
                                                <ul class="nav nav-tabs nav-stacked" id="quickcreate_elements"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="massedit">
                                        <div class="row-fluid">
                                            <div id="massedit_container">
                                                <ul class="nav nav-tabs nav-stacked" id="massedit_elements"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="summary">
                                        <div class="row-fluid">
                                            <div id="summary_container">
                                                <ul class="nav nav-tabs nav-stacked" id="summary_elements"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script>
        $(function() {
            $( "#filter_elements" ).sortable({forcePlaceholderSize: true,placeholder: "ui-state-highlight"});
            $( "#column_elements" ).sortable({forcePlaceholderSize: true,placeholder: "ui-state-highlight"});
            $( "#quickcreate_elements" ).sortable({forcePlaceholderSize: true,placeholder: "ui-state-highlight"});
            $( "#massedit_elements" ).sortable({forcePlaceholderSize: true,placeholder: "ui-state-highlight"});
            $( "#summary_elements" ).sortable({forcePlaceholderSize: true,placeholder: "ui-state-highlight"});
        });
        </script>
    </div>
</div>