<ul class="nav nav-list">
    <li <?php if ($controller === 'admin') echo 'class="active"'; ?>>
        <a href="/admin">
            <i class="icon-dashboard"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <?php if($this->Role->checkPermission('user_view')) { ?>
        <li <?php if ($controller === 'user') echo 'class="active"'; ?>><a href="/user">
            <?php echo $this->Html->image('user.png', array("alt" => "Users", "style" => "padding-right: 5px;")); ?>
            <span><?php echo __('Users'); ?></span>
        </a></li>
    <?php } ?>
        
    <?php if($this->Role->checkPermission('role_view')) { ?>
        <li <?php if ($controller === 'role') echo 'class="active"'; ?>><a href="/role">
            <?php echo $this->Html->image('database_key.png', array("alt" => "Roles", "style" => "padding-right: 0px;")); ?>
            <span><?php echo __('Roles and permissions'); ?></span>
        </a></li>
    <?php } ?>
    
    <?php if($this->Role->checkPermission('gateway_view')) { ?>
        <li <?php if ($controller === 'gateway') echo 'class="active"'; ?>><a href="/gateway">
            <?php echo $this->Html->image('icon_site.png', array("alt" => "Dialer gateways", "style" => "padding-right: 5px;")); ?>
            <span><?php echo __('Dialer gateways'); ?></span>
        </a></li>
    <?php } ?>
    
    <?php if($this->Role->checkPermission('voice_view')) { ?>    
        <li <?php if ($controller === 'setting') echo 'class="active"'; ?>><a href="/setting">
            <?php echo $this->Html->image('voice_setting.png', array("alt" => "Settings", "style" => "padding-right: 5px;")); ?>
            <span><?php echo __('Voice settings'); ?></span>
        </a></li>
   <?php } ?>
<!--    <li <?php if ($controller === 'configure') echo 'class="active"'; ?>><a href="#">
            <?php echo $this->Html->image('changeset.png', array("alt" => "Settings", "style" => "padding-right: 5px;")); ?>
            <span><?php echo __('Settings'); ?></span>
        </a></li>-->
</ul>