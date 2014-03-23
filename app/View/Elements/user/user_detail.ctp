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

<?php
echo $this->Form->input('user_id', array('type' => 'hidden','value' => $user['User']['user_id']));
echo $this->Form->button('Save details', array('type' => 'submit', 'class' => 'btn btn-primary'));
echo $this->Form->end(); 
?>
