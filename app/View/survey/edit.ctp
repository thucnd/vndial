<form id="survey-form" method="post">
    <div class="content-box">
        <div class="content-display">
            <blockquote><p><strong><?php echo __('Edit survey'); ?></strong></p></blockquote>
            <div id="msg"></div>
            <?php echo $this->element('survey/form'); ?>
            <input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>" />
        </div>
    </div>
    
    <br>
    <div >
        <a href="javascript:void(0)" class="btn" id="survey-back"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="survey-save"><?php echo __('Save'); ?></a>
    </div>
</form>
<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
<br>

