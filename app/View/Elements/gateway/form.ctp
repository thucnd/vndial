<?php 
if (!isset($edit)) {
   $edit = false;
}
?>
<label class="lbl-required" >
    <?php echo __('Name'); ?>
    <em>*</em>
</label>
<input name="name" type="text" id="name" class="required" style="width:300px;" value="<?php if($edit) echo $gateway['Gateway']['name']; ?>"/>
<label class="lbl-note">
    <?php echo __('Gateway name'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Description '); ?>
</label>
<textarea name="description" id="gateway_description" rows="5" style="width:500px;"><?php if($edit) echo $gateway['Gateway']['description']; ?></textarea>
<label class="lbl-note">
    <?php echo __('Gateway provider notes'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Gateway'); ?>
    <em>*</em>
</label>
<input name="gateways" type="text" id="gateway" class="required" style="width:300px;" value="<?php if($edit) echo $gateway['Gateway']['gateways']; ?>"/>
<label class="lbl-note">
    <?php echo __('Example : "sofia/gateway/myprovider/" or 2 for failover "sofia/gateway/myprovider/, user/"'); ?>
</label>
<label class="lbl-note">
    <?php echo __('Gateway string to try dialing separated by comma. First in list will be tried first'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Gateway codecs'); ?>
</label>
<input name="gateway_codecs" type="text" id="gateway_codecs" style="width:300px;" value="<?php if($edit) echo $gateway['Gateway']['gateway_codecs']; ?>"/>
<label class="lbl-note">
    <?php echo __('"\'PCMA,PCMU\',\'PCMA,PCMU\'", # Codec string as needed by FS for each gateway separated by comma'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Gateway timeouts'); ?>
</label>
<input name="gateway_timeouts" type="text" id="gateway_timeouts" style="width:300px;" value="<?php if($edit) echo $gateway['Gateway']['gateway_timeouts']; ?>"/>
<label class="lbl-note">
    <?php echo __('"10,10", # Seconds to timeout in string for each gateway separated by comma'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Gateway retries'); ?>
</label>
<input name="gateway_retries" type="text" id="gateway_retries" style="width:300px;" value="<?php if($edit) echo $gateway['Gateway']['gateway_retries']; ?>"/>
<label class="lbl-note">
    <?php echo __('"2,1", # Retry String for Gateways separated by comma, on how many times each gateway should be retried '); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Originate dial string '); ?>
</label>
<input name="gateway_originates" type="text" id="gateway_originates" style="width:300px;" value="<?php if($edit) echo $gateway['Gateway']['gateway_originates']; ?>"/>
<label class="lbl-note">
    <?php echo __('Add Channels Variables : http://wiki.freeswitch.org/wiki/Channel_Variables, ie: bridge_early_media=true,hangup_after_bridge=true'); ?>
</label>

