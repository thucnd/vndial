<form id="gateway-form" method="post" action="">
    <legend><strong><?php echo __('Create Dialer Setting'); ?></strong></legend>
    <div id="msg"></div>
    <?php echo $this->element('gateway/form'); ?>
    <br>
    <div >
        <a href="javascript:void(0)" class="btn" id="gateway-back"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn" id="gateway-save-continue"><?php echo __('Save and continue'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary"class="btn btn-primary" id="gateway-save"><?php echo __('Save'); ?></a>
    </div>
</form>

<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
<br>
<div id="alert-msg" class="alert-msg" style="display: none;"></div>
