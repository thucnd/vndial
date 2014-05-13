<?php echo $this->Form->create('UserDetail',array('type' => 'post', 'url' => 'updateinfo')); ?>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Address'); ?>
    </label>
    <?php echo $this->Form->input('address',array('label' => false,'value' => $user['User']['address'], 'class' => 'input-xlarge')); ?>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('City'); ?>
    </label>
    <?php echo $this->Form->input('city',array('label' => false, 'value' => $user['User']['city'], 'class' => 'input-xlarge')); ?>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('State'); ?>
    </label>
    <?php echo $this->Form->input('state',array('label' => false, 'value' => $user['User']['state'], 'class' => 'input-xlarge')); ?>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Province'); ?>
    </label>
    <?php echo $this->Form->input('zip',array('label' => false, 'value' => $user['User']['zip'], 'class' => 'input-xlarge')); ?>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Phone number'); ?>
    </label>
    <?php echo $this->Form->input('phonenumber',array('label' => false, 'value' => $user['User']['phonenumber'], 'class' => 'input-xlarge')); ?>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Company name'); ?>
    </label>
    <?php echo $this->Form->input('company_name',array('label' => false, 'value' => $user['User']['company_name'], 'class' => 'input-xlarge')); ?>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Website'); ?>
    </label>
    <?php echo $this->Form->input('company_website',array('label' => false, 'value' => $user['User']['company_website'], 'class' => 'input-xlarge')); ?>
</div>
<?php if(isset($edit)&& $edit) { ?>
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
<input type="hidden" name="edit" id="edit" value="1" />
<?php } ?>
<?php
echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user['User']['user_id']));
echo $this->Form->button('Save details', array('type' => 'submit', 'class' => 'btn btn-primary'));
echo $this->Form->end(); 
?>
