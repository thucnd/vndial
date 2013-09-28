<?php
if (!isset($edit)) {
    $edit = false;
}
?>
<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Role name'); ?>
        <em>*</em>
    </label>
    <input name="role_name" type="text" id="role_name" class="required" value="<?php if ($edit) echo $role['Role']['role_name']; ?>"/>
    <label class="lbl-note">
        <?php echo __('Please fill role name'); ?>
    </label>
</div>

<legend><?php echo __('Permissions'); ?></legend>
<?php foreach ($permissions as $r_key => $r_value) { ?>
    <div class="well well-small">
        <blockquote>
            <strong><?php echo __($r_key); ?></strong>
        </blockquote>
        <ul class="inline">
            <?php foreach ($r_value as $key => $value) { ?>
                <li>
                   <input type="checkbox" name="chkRole[]" id="chkRole[]" <?php if($edit && in_array($key,$chkPermissions)) echo 'checked';?> value="<?php echo __($key); ?>"><span class="lbl"> <?php echo __($value); ?></span>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<a id="role_check_all" style="cursor: pointer;" >Check all</a> |
<a id="role_uncheck_all" style="cursor: pointer;" >Uncheck all</a>
<br>
