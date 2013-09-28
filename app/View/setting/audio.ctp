<legend><strong><?php echo __('Audio files settings'); ?></strong></legend>
<div id="msg"></div>
<form id="setting-form" method="post" action="" >
    <div class="line-box">
        <label class="lbl-required" >
            <?php echo __('Recording Directory Path'); ?>
            <em>*</em>
        </label>
        <input name="audio_path" type="text" id="audio_path" class="required" style="width:300px;" value="<?php echo $this->App->getSettingInfo($data, 'audio_path', '/usr/local/files/'); ?>"/>
        <label class="lbl-note">
            <?php echo __("Directory path where all the recording files are available (Do not add a trailing '/')"); ?>
        </label>
    </div>
    <div class="line-box">
        <a href="/setting" class="btn" title="Voice settings"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="setting-save"><?php echo __('Save'); ?></a>
    </div>
</form>
