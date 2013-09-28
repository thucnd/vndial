<?php
if (!isset($edit)) {
    $edit = false;
}
?>
<label class="lbl-required" >
    <?php echo __('Name'); ?>
    <em>*</em>
</label>
<input name="name" type="text" id="name" class="required" style="width:300px;" value="<?php if ($edit) echo $tts['Tts']['name']; ?>"/>
<label class="lbl-note">
    <?php echo __('please fill tts name'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Data'); ?>
    <em>*</em>
</label>
<input name="text_data" type="text" id="text_data" class="required" style="width:300px;" value="<?php if ($edit) echo $tts['Tts']['text_data']; ?>"/>
<label class="lbl-note">
    <?php echo __('please fill text'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Language'); ?>
    <em>*</em>
</label>
<select name="language" id="language" style="width: 120px;">
    <?php foreach($countries as $country) { ?>
        <option value="<?php echo $country['Country']['country_iso']; ?>"
                <?php if($edit) { ?>
                    <?php if($country['Country']['country_iso'] == $tts['Country']['country_iso']) echo 'selected'; ?>
                <?php } ?>
        >
                    <?php echo $country['Country']['country_name']; ?>
        </option>
    <?php } ?>
</select>
<label class="lbl-note">
    <?php echo __('please select language'); ?>
</label>
