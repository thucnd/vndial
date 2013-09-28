<legend><strong><?php echo __('Plivo settings'); ?></strong></legend>
<div id="msg"></div>

<form id="setting-form" method="post" action="" >
    <div class="line-box">
        <label class="lbl-required" >
            <?php echo __('Application Root'); ?>
            <em>*</em>
        </label>
        <input name="broadcast_app_root" type="text" id="broadcast_app_root" class="required" style="width:300px;" value="<?php echo $this->App->getSettingInfo($data, 'broadcast_app_root', 'http://127.0.0.1'); ?>"/>
        <label class="lbl-note">
            <?php echo __("e.g. Application root address (including 'http://')"); ?>
        </label>
    </div>


    <div class="line-box">
        <label class="lbl-required" >
            <?php echo __('Plivo Server Address'); ?>
            <em>*</em>
        </label>

        <input name="plivo_address" type="text" id="plivo_address" class="required" style="width:300px;" value="<?php echo $this->App->getSettingInfo($data, 'plivo_address', '127.0.0.1'); ?>"/>

        <label class="lbl-note">
            <?php echo __("Plivo Rest server IP address"); ?>
        </label>
    </div>

    <div class="line-box">
        <label class="lbl-required" >
            <?php echo __('Server Port'); ?>
            <em>*</em>
        </label>

        <input name="plivo_port" type="text" id="plivo_port" class="required" style="width:300px;" value="<?php echo $this->App->getSettingInfo($data, 'plivo_port', '8088'); ?>"/>

        <label class="lbl-note">
            <?php echo __("Port number for Plivo Rest API"); ?>
        </label>
    </div>

    <div class="line-box">
        <label class="lbl-required" >
            <?php echo __('Account ID'); ?>
            <em>*</em>
        </label>

        <input name="plivo_account" type="text" id="plivo_account" class="required" style="width:300px;" value="<?php echo $this->App->getSettingInfo($data, 'plivo_account', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'); ?>"/>

        <label class="lbl-note">
            <?php echo __("Username for Plivo Rest API"); ?>
        </label>
    </div>

    <div class="line-box">
        <label class="lbl-required" >
            <?php echo __('Authentication Token'); ?>
            <em>*</em>
        </label>

        <input name="plivo_password" type="text" id="plivo_password" class="required" style="width:300px;" value="<?php echo $this->App->getSettingInfo($data, 'plivo_password', 'YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY'); ?>"/>

        <label class="lbl-note">
            <?php echo __("Password for Plivo Rest API"); ?>
        </label>
    </div>

    <div class="line-box">
        <a href="/setting/" class="btn" cltitle="Voice settings"><?php echo __('Back'); ?></a>
        <a href="javascript:void(0)" class="btn btn-primary" id="setting-save"><?php echo __('Save'); ?></a>
    </div>
</form>