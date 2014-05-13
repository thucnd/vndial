<!--<form id="user-form" method="post">-->
    <div class="page-header position-relative">
        <h1><?php echo __('Edit user'); ?></h></legend>
    </div>
    
    <div id="msg"></div>
    <?php echo $this->element('user/edit'); ?>
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />

<!--    <br>
    <div >
        <a href="javascript:void(0)" class="btn" id="user-back"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn" id="user-save-continue"><?php echo __('Save and continue'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="user-save"><?php echo __('Save'); ?></a>
    </div>
</form>-->
<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
