<legend>
<h2><?php echo __('Account settings'); ?></h2>
</legend>

<?php if ($this->Session->check('Message.flash')){ ?> 
    <div class="message_box"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $this->Session->flash(); ?></div>
<?php } ?>
<div class="user-details">
    <ul id="userTab" class="nav nav-tabs">
        <li <?php if($tab==1) echo 'class="active"'; ?>>
            <a data-toggle="tab" href="#details"><?php echo __('User details'); ?></a>
        </li>
        <li <?php if($tab==2) echo 'class="active"'; ?>>
            <a data-toggle="tab" href="#password"><?php echo __('Password'); ?></a>
        </li>
    </ul>
    <div id="userTabContent" class="tab-content">
        <div id="details" class="tab-pane fade <?php if($tab==1) echo 'in active'; ?>">
            <?php echo $this->element('user/user_detail'); ?>
        </div>
        <div id="password" class="tab-pane fade <?php if($tab==2) echo 'in active'; ?>">
            <?php echo $this->element('user/user_password'); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    controller = $('input[type=hidden]#controller').val();
</script>
