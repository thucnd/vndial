<?php ?>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="/">
                <?php echo $this->Html->image('vndial.png', array("alt" => "Home", "style" => "height: 50px; width: 60px;")); ?>
            </a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li <?php if ($controller === 'frontend' || $controller === '') echo 'class="active"'; ?>><a href="/"><?php echo __('Dashboard'); ?></a></li>
                    <li <?php if ($controller === 'campaign' || $controller === 'recording' || $controller === 'survey' || $controller === 'tts') echo 'class="dropdown active"'; else echo 'class="dropdown"'; ?>>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Voice application'); ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <?php if($this->Role->checkPermission('campaign_view')) { ?>
                            <li >
                                <a href="<?php echo $this->Html->url(array('controller' => 'campaign', 'action' => 'index')); ?>"><?php echo __('Voice campaign'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if($this->Role->checkPermission('recording_view')) { ?>
                            <li >
                                <a href="<?php echo $this->Html->url(array('controller' => 'recording', 'action' => 'index')); ?>"><?php echo __('Audio files'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if($this->Role->checkPermission('survey_view')) { ?>
                            <li >
                                <a href="<?php echo $this->Html->url(array('controller' => 'survey', 'action' => 'index')); ?>"><?php echo __('Survey'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if($this->Role->checkPermission('tts_view')) { ?>
                            <li >
                                <a href="<?php echo $this->Html->url(array('controller' => 'tts', 'action' => 'index')); ?>"><?php echo __('Text to speech'); ?></a>
                            </li>
                        <?php } ?>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Contacts'); ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <?php if($this->Role->checkPermission('contact_group_view')) { ?>
                            <li >
                                <a href="<?php echo $this->Html->url(array('controller' => 'contact_group', 'action' => 'index')); ?>"><?php echo __('Groups'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if($this->Role->checkPermission('contact_view')) { ?>
                            <li >
                                <a href="<?php echo $this->Html->url(array('controller' => 'contact', 'action' => 'index')); ?>"><?php echo __('Contacts'); ?></a>
                            </li>
                        <?php } ?>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Cdr'); ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <?php if($this->Role->checkPermission('call_request_view')) { ?>
                            <li >
                                <?php
                                echo $this->Html->link(
                                        __('Call request'), array(
                                    'controller' => 'call_request',
                                    'action' => 'index')
                                );
                                ?>
                            </li>
                        <?php } ?>
                        <?php if($this->Role->checkPermission('call_report_view')) { ?>
                            <li >
                                <?php
                                echo $this->Html->link(
                                        __('Call report'), array(
                                    'controller' => 'call_report',
                                    'action' => 'index')
                                );
                                ?>
                            </li>
                        <?php } ?>
                        </ul>
                    </li>
                </ul>
                <ul class="nav pull-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->Session->read('User.name'); ?>&nbsp;<b class="caret"></b></a>
                        <ul class="dropdown-menu pull-right">
                            <?php if($this->Role->checkPermission('admin_page')) { ?>
                            <li><a href="/admin"><i class=""></i>  <?php echo __('Administrator'); ?></a></li>
                            <?php } ?>
                            <li><a href="/user/info"><i class=""></i>  <?php echo __('Account settings'); ?></a></li>
                            <li class="divider"></li>
                            <li><a href="/login/logout" ><i class="icon-off"></i> Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
