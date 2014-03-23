<?php echo $this->Form->create('UserPassword',array('type' => 'post', 'url' => 'updatepassword')); ?>
<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Old password'); ?>
        <em>*</em>
    </label>
    <?php echo $this->Form->password('old_password',array('label' => false, 'class' => 'input-xlarge')); ?>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Password'); ?>
        <em>*</em>
    </label>
    <?php echo $this->Form->password('password',array('label' => false, 'class' => 'input-xlarge')); ?>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Password confirm'); ?>
        <em>*</em>
    </label>
    <?php echo $this->Form->password('repassword',array('label' => false, 'class' => 'input-xlarge')); ?>
</div>
<?php
echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user['User']['user_id']));
echo $this->Form->button('Save password', array('type' => 'submit', 'class' => 'btn btn-primary'));
echo $this->Form->end(); 
?>
