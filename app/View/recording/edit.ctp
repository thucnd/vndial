<form id="recording-form" method="post" action="/recording/save" enctype="multipart/form-data" onsubmit="return AIM.submit(this, {'onStart': startCallback, 'onComplete': completeCallback})">
    <div class="content-box" >
        <div class="content-display">
            <blockquote><p><strong><?php echo __('Edit audio file'); ?></strong></p></blockquote>
            <div id="msg"></div>
            <?php echo $this->element('recording/form'); ?>
            <input type="hidden" name="recording_id" id="recording_id" value="<?php echo $recording_id; ?>" />
        </div>
    </div>
    
    <br>
    <div >
        <a href="javascript:void(0)" class="btn" id="recording-back"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="recording-save"><?php echo __('Save'); ?></a>
    </div>
</form>

<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
<br>
<div id="alert-msg" class="alert-msg" style="display: none;"></div>
