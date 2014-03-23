<div class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a href="/" class="admin-logo">
                <?php echo $this->Html->image('vndial.png', array("alt" => "Home", "style" => "height: 45px; width: 58px;vertical-align: middle;")); ?>
                VNDIAL ADMIN
            </a>

            <ul class="nav ace-nav pull-right">
                <li class="light-blue user-profile">
                    <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                        <img class="nav-user-photo" src="/themes/images/user.png" alt="Jason's Photo" />
                        <span id="user_info">
                            <small>Welcome,</small>
                            <?php echo $this->Session->read('User.name'); ?>
                        </span>

                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer" id="user_menu">
                        <li>
                            <a href="#">
                                <i class="icon-cog"></i>
                                Settings
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="icon-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="/login/logout">
                                <i class="icon-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

