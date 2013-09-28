<form id="campaign-form" method="post" action="">
    <div class="content-box" >
        <div class="content-display">
            <blockquote><p><strong><?php echo __('Edit campaign'); ?></strong></p></blockquote>
            <div id="msg"></div>
            <?php echo $this->element('campaign/form'); ?>
            <input type="hidden" name="campaign_id" id="campaign_id" value="<?php echo $campaign_id; ?>" />
        </div>
    </div>
    <br>
    <div >
        <a href="javascript:void(0)" class="btn" id="campaign-back"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="campaign-save"><?php echo __('Save'); ?></a>
    </div>
</form>

<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
<br>

