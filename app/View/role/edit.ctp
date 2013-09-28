<form id="role-form" method="post">
    <legend><strong><?php echo __('Edit role'); ?></strong></legend>
    <div id="msg"></div>
    <?php echo $this->element('role/form'); ?>
    <input type="hidden" name="role_id" id="role_id" value="<?php echo $role_id; ?>" />

    <br>
    <div >
        <a href="javascript:void(0)" class="btn" id="role-back"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="role-save"><?php echo __('Save'); ?></a>
    </div>
</form>
<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
