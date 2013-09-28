<?php
if (!isset($edit)) {
    $edit = false;
   $start_date =  date ("Y-m-d", $_SERVER['REQUEST_TIME']);
   $start_time = date ("H:i:s", $_SERVER['REQUEST_TIME']);
   $end_date =  date ("Y-m-d", $_SERVER['REQUEST_TIME']);
   $end_time = date ("H:i:s", $_SERVER['REQUEST_TIME']);
} else {
   $start_date =  date('Y-m-d',strtotime($campaign['Campaign']['start_at']));
   $start_time = date('H:i:s',strtotime($campaign['Campaign']['start_at']));
   $end_date =  date('Y-m-d',strtotime($campaign['Campaign']['stop_at']));
   $end_time = date('H:i:s',strtotime($campaign['Campaign']['stop_at']));
}

?>
<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Name'); ?>
        <em>*</em>
    </label>
    <input name="name" type="text" id="name" class="required" style="width:300px;" value="<?php if ($edit) echo $campaign['Campaign']['name']; ?>"/>
    <label class="lbl-note">
        <?php echo __('Please fill campaign name'); ?>
    </label>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Description '); ?>
    </label>
    <textarea name="description" id="description" rows="5" style="width:500px;"><?php if ($edit) echo $campaign['Campaign']['description']; ?></textarea>
    <label class="lbl-note">
        <?php echo __('Voice campaign description'); ?>
    </label>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Caller name'); ?>
        <em>*</em>
    </label>
    <input name="caller" type="text" id="caller" style="width:300px;" value="<?php if ($edit) echo $campaign['Campaign']['caller']; ?>"/>
    <label class="lbl-note">
        <?php echo __('Outbound caller-Name Application'); ?>
    </label>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Status'); ?>
    </label>
    <?php $arrStatus = array(1 => __('START'), 2 => __('PAUSED'), 3 => __('STOP')); ?>
    <select name="status" id="status" class="input-small">
        <?php foreach ($arrStatus as $key => $value) { ?>
            <option value="<?php echo $key; ?>" <?php if( $edit && $key == $campaign['Campaign']['status']) echo 'selected'; ?>><?php echo $value; ?></option>
        <?php } ?>
    </select>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Start time'); ?>
        <em>*</em>
    </label>
    Date:&nbsp;&nbsp;&nbsp;
    <div class="input-append date " id="start_at" data-date="" data-date-format="yyyy-mm-dd">
        <input type="text" readonly class="span2" id="start_date" name="start_date"  value="<?php echo $start_date; ?>"/>
        <span class="add-on">
            <i class="icon-calendar"></i>
        </span>
    </div>
    &nbsp;&nbsp;&nbsp;Time:&nbsp;&nbsp;&nbsp;
    <div class="input-append bootstrap-timepicker">
        <input id="start_time" name="start_time" type="text" class="input-small" value="<?php echo $start_time; ?>">
        <span class="add-on"><i class="icon-time"></i></span>
    </div>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('End time'); ?>
        <em>*</em>
    </label>
    Date:&nbsp;&nbsp;&nbsp;
    <div class="input-append date" id="stop_at" data-date="" data-date-format="yyyy-mm-dd">
        <input type="text" class="span2" id="stop_date" name="stop_date" readonly value="<?php echo $end_date; ?>"/>
        <span class="add-on">
            <i class="icon-calendar"></i>
        </span>
    </div>
    &nbsp;&nbsp;&nbsp;Time:&nbsp;&nbsp;&nbsp;
    <div class="input-append bootstrap-timepicker">
        <input id="end_time" name="end_time" type="text" class="input-small" value="<?php echo $end_time; ?>">
        <span class="add-on"><i class="icon-time"></i></span>
    </div>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('A-leg'); ?>
        <em>*</em>
    </label>
    <select name="a_leg" id="a_leg" class="input-medium">
        <?php foreach ($gateways as  $gateway) { ?>
            <option value="<?php echo $gateway['Gateway']['gateway_id']; ?>" <?php if( $edit && $gateway['Gateway']['gateway_id'] == $campaign['Campaign']['a_leg']) echo 'selected'; ?>><?php echo $gateway['Gateway']['name']; ?></option>
        <?php } ?>
    </select>
    <label class="lbl-note">
        <?php echo __('Select outbound gateway'); ?>
    </label>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Campaign type'); ?>
        <em>*</em>
    </label>
    <?php $arrType = array(1 => __('Play audio'), 2 => __('Survey'), 3 => __('Text to speech')); ?>
    <select name="camp_type_id" id="camp_type_id" class="input-medium">
        <?php foreach ($arrType as $key => $value) { ?>
            <option value="<?php echo $key; ?>" <?php if( $edit && $key == $campaign['Campaign']['camp_type_id']) echo 'selected'; ?>><?php echo $value; ?></option>
        <?php } ?>
    </select>
    <label class="lbl-note">
        <?php echo __('Select campaign type'); ?>
    </label>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Data'); ?>
        <em>*</em>
    </label>
    <?php $arrType = array(1 => __('Play audio'), 2 => __('Survey'), 3 => __('Text to speech')); ?>
    <select name="app_type_id" id="app_type_id" class="input-medium">
        <?php foreach ($data as  $value) { ?>
            <option value="<?php echo $value['key']; ?>" <?php if( $edit && $value['key'] == $campaign['Campaign']['app_type_id']) echo 'selected'; ?>><?php echo $value['name']; ?></option>
        <?php } ?>
    </select>
    <label class="lbl-note">
        <?php echo __('Select select data'); ?>
    </label>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Phone book'); ?>
        <em>*</em>
    </label>
    <select name="group_id" id="group_id"  multiple="multiple" size="10" class="input-xlarge">
        <?php foreach ($groups as  $group) { ?>
            <option value="<?php echo $group['ContactGroup']['group_id']; ?>" <?php if( $edit && $group['ContactGroup']['group_id'] == $campaign['Campaign']['group_id']) echo 'selected'; ?>><?php echo $group['ContactGroup']['name']; ?></option>
        <?php } ?>
    </select>
</div>
