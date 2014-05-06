<?php
if (!isset($edit)) {
    $edit = false;
}
?>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Username'); ?>
        <em>*</em>
    </label>
    <input name="username" type="text" id="username" class="required" <?php if ($edit) echo 'readonly'; ?>   value="<?php if ($edit) echo $user['User']['username']; ?>" autocomplete="off"/>
    <label class="lbl-note">
        <?php echo __('Required. 30 characters or fewer. Letters, digits'); ?>
    </label>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Password'); ?>
        <em>*</em>
    </label>
    <input name="password" type="password" id="password" class="required" value="" autocomplete="off"/>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Password confirm'); ?>
        <em>*</em>
    </label>
    <input name="repassword" type="password" id="repassword" class="required" value="" autocomplete="off"/>
</div>

<legend></legend>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Address'); ?>
    </label>
    <input class="input-xlarge" name="address" type="text" id="address" value="<?php if ($edit) echo $user['User']['address']; ?>"/>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('City'); ?>
    </label>
    <input class="input-xlarge" name="city" type="text" id="city" value="<?php if ($edit) echo $user['User']['city']; ?>"/>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('State'); ?>
    </label>
    <input class="input-xlarge" name="state" type="text" id="state" value="<?php if ($edit) echo $user['User']['state']; ?>"/>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Province'); ?>
    </label>
    <input class="input-xlarge" name="zip" type="text" id="zip" value="<?php if ($edit) echo $user['User']['zip']; ?>"/>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Phone number'); ?>
    </label>
    <input class="input-xlarge" name="phonenumber" type="text" id="phonenumber" value="<?php if ($edit) echo $user['User']['phonenumber']; ?>"/>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Company name'); ?>
    </label>
    <input class="input-xlarge" name="company_name" type="text" id="company_name" value="<?php if ($edit) echo $user['User']['company_name']; ?>"/>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Website'); ?>
    </label>
    <input class="input-xlarge" name="company_website" type="text" id="company_website" value="<?php if ($edit) echo $user['User']['company_website']; ?>"/>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Role'); ?>
        <em>*</em>
    </label>
    <select name="role" id="role" class="input-medium">
        <?php foreach ($roles as $role) { ?>
            <?php if(intval($role['Role']['role_id']) == SUPPER_ADMIN && !$edit) {continue; }?>
            <?php if(intval($user['User']['role']) != SUPPER_ADMIN && intval($role['Role']['role_id']) == SUPPER_ADMIN ) {continue; }?>
            <option value="<?php echo $role['Role']['role_id']; ?>" <?php if(intval($user['User']['role']) == intval($role['Role']['role_id'])){ echo 'selected';} ?>>
                <?php echo $role['Role']['role_name']; ?>
            </option>
        <?php } ?>
    </select>
</div>

<legend></legend>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Gateway'); ?>
        <em>*</em>
    </label>
    <select name="gateway_id" id="gateway_id" class="input-medium">
        <?php foreach ($gateways as $gateway) { ?>            
            <option value="<?php echo $gateway['Gateway']['gateway_id']; ?>" <?php if(intval($user['User']['gateway_id']) == intval($gateway['Gateway']['gateway_id'])){ echo 'selected';} ?>>
                <?php echo $gateway['Gateway']['name']; ?>
            </option>
        <?php } ?>
    </select>
</div>