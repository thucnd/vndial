<form id="role-form" method="post">
    <legend><strong><?php echo __('Create new role'); ?></strong></legend>
    <div id="msg"></div>
    <?php echo $this->element('role/form'); ?>
    <br>
    <div >
        <a href="javascript:void(0)" class="btn" id="role-back"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="role-save"><?php echo __('Save'); ?></a>
    </div>
</form>
<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
