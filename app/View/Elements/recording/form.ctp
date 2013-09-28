<?php 
if (!isset($edit)) {
   $edit = false;
}
?>
<label class="lbl-required" >
    <?php echo __('Recording name'); ?>
    <em>*</em>
</label>
<input name="name" type="text" id="name" class="required" style="width:300px;" value="<?php if($edit) echo $recording['Recording']['name']; ?>"/>
<label class="lbl-note">
    <?php echo __('please fill recording name'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Description '); ?>
</label>
<textarea name="description" id="description" rows="5"  style="width:500px;"><?php if($edit) echo $recording['Recording']['description']; ?></textarea>
<label class="lbl-note">
    <?php echo __('Audio files notes'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Upload file'); ?>
    <em>*</em>
</label>
<input id="audio_path" type="file" name="audio_path" style="width:500px;"/>
<label class="lbl-note">
    <?php echo __('Please upload your audio files'); ?>
</label>