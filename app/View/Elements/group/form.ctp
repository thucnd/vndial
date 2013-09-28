<?php 
if (!isset($edit)) {
   $edit = false;
}
?>
<label class="lbl-required" >
    <?php echo __('Name'); ?>
    <em>*</em>
</label>
<input name="name" type="text" id="group_name" class="required" style="width:300px;" value="<?php if($edit) echo $group['ContactGroup']['name']; ?>"/>
<label class="lbl-note">
    <?php echo __('Group name'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Description '); ?>
</label>
<textarea name="description" id="gateway_description" rows="5" style="width:500px;"><?php if($edit) echo $group['ContactGroup']['description']; ?></textarea>
<label class="lbl-note">
    <?php echo __('Group notes'); ?>
</label>

