<form id="campaign-form" method="post" action="">
    <div class="content-box" >
        <div class="content-display">
            <blockquote><p><strong><?php echo __('Create new campaign'); ?></strong></p></blockquote>
            <div id="msg"></div>
            <?php echo $this->element('campaign/form'); ?>
        </div>
    </div>
    <br>
    <div >
        <a href="javascript:void(0)" class="btn" id="campaign-back"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn" id="campaign-save-continue"><?php echo __('Save and continue'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="campaign-save"><?php echo __('Save'); ?></a>
    </div>
</form>
<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
<br>

