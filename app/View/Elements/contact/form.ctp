<?php
if (!isset($edit)) {
    $edit = false;
}
?>
<label class="lbl-required" >
    <?php echo __('First name'); ?>
    <em>*</em>
</label>
<input name="first_name" type="text" id="first_name" class="required" style="width:300px;" value="<?php if ($edit) echo $contact['Contact']['first_name']; ?>"/>
<label class="lbl-note">
    <?php echo __('Please fill first name'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Last Name'); ?>
    <em>*</em>
</label>
<input name="last_name" type="text" id="last_name" class="required" style="width:300px;" value="<?php if ($edit) echo $contact['Contact']['last_name']; ?>"/>
<label class="lbl-note">
    <?php echo __('Please fill last name'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Company'); ?>
</label>
<input name="company" type="text" id="company" style="width:300px;" value="<?php if ($edit) echo $contact['Contact']['company']; ?>"/>
<label class="lbl-note">
    <?php echo __('Please fill company'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Address'); ?>
</label>
<input name="address" type="text" id="address" style="width:300px;" value="<?php if ($edit) echo $contact['Contact']['address']; ?>"/>
<label class="lbl-note">
    <?php echo __('Please fill address'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Phone'); ?>
    <em>*</em>
</label>
<input name="phone" type="text" id="address" class="required" style="width:300px;" value="<?php if ($edit) echo $contact['Contact']['phone']; ?>"/>
<label class="lbl-note">
    <?php echo __('Please fill phone'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Email'); ?>
</label>
<input name="email" type="text" id="address" style="width:300px;" value="<?php if ($edit) echo $contact['Contact']['email']; ?>"/>
<label class="lbl-note">
    <?php echo __('Please fill email'); ?>
</label>

<br>
<label class="lbl-required" >
    <?php echo __('Group'); ?>
    <em>*</em>
</label>
<select name="group_id" id="group_id" style="width: 120px;">
    <?php foreach($groups as $group) { ?>
        <option value="<?php echo $group['ContactGroup']['group_id']; ?>"
                <?php if($edit) { ?>
                    <?php if($group['ContactGroup']['group_id'] == $contact['Contact']['group_id']) echo 'selected'; ?>
                <?php } ?>
        >
                    <?php echo $group['ContactGroup']['name']; ?>
        </option>
    <?php } ?>
</select>
<label class="lbl-note">
    <?php echo __('Please select group'); ?>
</label>