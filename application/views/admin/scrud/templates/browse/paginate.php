<?php $CI = & get_instance();
$lang = $CI->lang; ?>
<?php
$h = round($this->pageIndex / 2);
if ($h > 2) {
    $f = $this->pageIndex - 2;
    $l = $this->pageIndex + 2;
    $l = ($l > $this->totalPage) ? $this->totalPage : $l;
} else {
    $f = 1;
    $l = 5;
    $l = ($this->totalPage < 5) ? $this->totalPage : $l;
}

$start = ($this->pageIndex-1)*$this->limit+1;
$end = $this->pageIndex*$this->limit;
if($end>$this->totalRecord)
    $end=$this->totalRecord;
?>
    <div class="col-md-4 pull-left" style="padding-top: 15px;">
        <div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">Showing <?=$start?> to <?=$end?> of <?php echo $this->totalRecord; ?> records</div>
    </div>

    <div class="col-md-3 pull-left" style="padding-top: 5px;"><div class="btn-group btn-sm  pull-right">
                <a href="javascript:void();" class="btn btn-sm blue blue" onclick="changeLimit(<?=$this->totalRecord?>);"> Show All 
                </a>
            </div></div>
    <div class="col-md-5 pull-right">
        <div class="dataTables_paginate paging_bootstrap_full_number pull-right" id="sample_1_paginate">
            
            <ul class="pagination" style="visibility: visible;">
        <?php if (!empty($this->results) && (int) $this->totalPage > 1) { ?>
            <?php if ($this->pageIndex > 1 && $this->totalRecord > 0) { ?>
                <li class="prev"><a onclick="paginate(1); return false;" href="#" title="<?php echo $lang->line('first'); ?>"><i class="fa fa-angle-double-left"></i></a></li>
                <li class="prev"><a onclick="paginate(<?php echo $this->pageIndex - 1; ?>); return false;" href="#" title="Prev"><i class="fa fa-angle-left"></i></a></li>
            <?php } else { ?>
                <li class="prev disabled"><a href="#" title="<?php echo $lang->line('first'); ?>"><i class="fa fa-angle-double-left"></i></a></li>
                <li class="prev disabled"><a href="#" title="Prev"><i class="fa fa-angle-left"></i></a></li>
            <?php } ?>
            <?php for ($i = $f; $i <= $l; $i++) { ?>
                <?php if ($this->pageIndex == $i) { ?>
                    <li class="active"><a href="#" onclick="return false;"><?php echo $i; ?></a></li>
                <?php } else { ?>
                    <li><a onclick="paginate(<?php echo $i; ?>); return false;" href="#"><?php echo $i; ?></a></li>
                    <?php } ?>
            <?php } ?>
            <?php if ($this->pageIndex != $this->totalPage && $this->totalRecord > 0) { ?>
                <li class="next"><a onclick="paginate(<?php echo $this->pageIndex + 1; ?>); return false;" href="#" title="Next"><i class="fa fa-angle-right"></i></a></li>
                <li class="next"><a onclick="paginate(<?php echo $this->totalPage; ?>); return false;" href="#" title="<?php echo $lang->line('last'); ?>"><i class="fa fa-angle-double-right"></i></a></li>
            <?php } else { ?>
                <li class="next disabled"><a href="#" title="Next"><i class="fa fa-angle-right"></i></a></li>
                <li class="next disabled"><a href="#" title="<?php echo $lang->line('last'); ?>"><i class="fa fa-angle-double-right"></i></a></li>
            <?php } ?>
        <?php } else { ?>
            <li class="disabled"><a onclick="return false;" href="#">1</a></li>
        <?php } ?>

            </ul>
        </div>
    </div>

<script>
                function paginate(page_index) {
<?php
$q = $this->queryString;
$q['xtype'] = 'index';
if (isset($q['xid']))
    unset($q['xid']);
if (isset($q['src']) && isset($q['src']['p']))
    unset($q['src']['p']);
?>
                    window.location = "?<?php echo http_build_query($q, '', '&'); ?>&src[p]=" + page_index;
                }

                function changeLimit(o) {
<?php
$q = $this->queryString;
$q['xtype'] = 'index';
if (isset($q['xid']))
    unset($q['xid']);
if (isset($q['src']) && isset($q['src']['p']))
    unset($q['src']['p']);
if (isset($q['src']) && isset($q['src']['l']))
    unset($q['src']['l']);
?>
                    //window.location = "?<?php echo http_build_query($q, '', '&'); ?>&src[p]=" + 1 + "&src[l]=" + o.value;
                    window.location = "?<?php echo http_build_query($q, '', '&'); ?>&src[p]=" + 1 + "&src[l]=" + o;
                }
</script>