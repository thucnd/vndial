<form id="contact-form" method="post" action="">
    <div class="content-box" >
        <div class="content-display">
            <blockquote><p><strong><?php echo __('Create new contact'); ?></strong></p></blockquote>
            <?php echo $this->element('contact/form'); ?>
        </div>
    </div>
    <br>
    <div >
        <a href="javascript:void(0)" class="btn" id="contact-back"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn" id="contact-save-continue"><?php echo __('Save and continue'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="contact-save"><?php echo __('Save'); ?></a>
    </div>
</form>

<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
<br>
<div id="alert-msg" class="alert-msg" style="display: none;"></div>
