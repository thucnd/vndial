<div class="content-box" >
    <div class="content-tittle" > 
        <?php echo __('Dialer Settings'); ?>
    </div>
    <div class="content-display"> 
        <label class="lbl-required" >
            <?php echo __('Name'); ?>
            <em>*</em>
        </label>
        <label class="style_textfield">
            <input name="gateway_name" type="text" id="gateway_name" style="width:300px;"/>
        </label>
        <br>
        <label class="lbl-note">
            <?php echo __('Gateway name'); ?>
        </label>
        
        <br>
        <label class="lbl-required" >
            <?php echo __('Description '); ?>
        </label>
        <label class="style_textfield_mt">
            <textarea name="gateway_description" id="gateway_description" rows="5"></textarea>
        </label>
        <label class="lbl-note">
            <?php echo __('Gateway provider notes'); ?>
        </label>
        
        <br>
        <label class="lbl-required" >
            <?php echo __('Gateway'); ?>
            <em>*</em>
        </label>
        <label class="style_textfield">
            <input name="gateway" type="text" id="gateway" style="width:300px;"/>
        </label>
        <br>
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
        <label class="style_textfield">
            <input name="gateway_codecs" type="text" id="gateway_codecs" style="width:300px;"/>
        </label>
        <label class="lbl-note">
            <?php echo __('"\'PCMA,PCMU\',\'PCMA,PCMU\'", # Codec string as needed by FS for each gateway separated by comma'); ?>
        </label>
        
        <br>
        <label class="lbl-required" >
            <?php echo __('Gateway timeouts'); ?>
        </label>
        <label class="style_textfield">
            <input name="gateway_timeouts" type="text" id="gateway_timeouts" style="width:300px;"/>
        </label>
        <label class="lbl-note">
            <?php echo __('"10,10", # Seconds to timeout in string for each gateway separated by comma'); ?>
        </label>
        
        <br>
        <label class="lbl-required" >
            <?php echo __('Gateway retries'); ?>
        </label>
        <label class="style_textfield">
            <input name="gateway_retries" type="text" id="gateway_retries" style="width:300px;"/>
        </label>
        <label class="lbl-note">
            <?php echo __('"2,1", # Retry String for Gateways separated by comma, on how many times each gateway should be retried '); ?>
        </label>
        
        <br>
        <label class="lbl-required" >
            <?php echo __('Originate dial string '); ?>
        </label>
        <label class="style_textfield">
            <input name="gateway_originates" type="text" id="gateway_originates" style="width:300px;"/>
        </label>
        <label class="lbl-note">
            <?php echo __('Add Channels Variables : http://wiki.freeswitch.org/wiki/Channel_Variables, ie: bridge_early_media=true,hangup_after_bridge=true'); ?>
        </label>
    </div>
</div>
<br>
<div >
    <a href="javascript:void(0)" class="btn_normal" id="gateway-back"><?php echo __('Back'); ?></a>
    <a href="javascript:void(0)" class="btn_on" id="gateway-save"><?php echo __('Save'); ?></a>
</div>
<br>
