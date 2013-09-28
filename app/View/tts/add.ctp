<form id="tts-form" method="post">
    <div class="content-box" >
        <div class="content-display">
            <blockquote><p><strong><?php echo __('Create new text to speech'); ?></strong></p></blockquote>
            <div id="msg"></div>
            <?php echo $this->element('tts/form'); ?>
        </div>
    </div>
    
    <br>
    <div >
        <a href="javascript:void(0)" class="btn" id="tts-back"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="tts-save"><?php echo __('Save'); ?></a>
    </div>
</form>
<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
<br>

