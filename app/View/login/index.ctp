<div id="element-box" class="login"> 
    <h1>Login</h1>
<?php if ($this->Session->check('Message.flash')){ ?> 
    <div id="msg" ><div class="err_box"><?php echo $this->Session->flash(); ?></div></div>
<?php } ?>
    <form action="/login/exec" method="post" name="login" id="form-login" >
        <div>
            <div style="float:left; width: 150px">
                <label class="style_radio" style="">
                    <?php echo __('Username'); ?>:
                </label>
            </div>
            <div style="float: left">
                <label class="style_textfield" >
                    <input name="user_name" type="text" id="user_name" style="width:300px;" />
                </label>
            </div>
            <div style="clear: both"></div>
        </div>
        
        <br>
        <div>
            <div style="float:left; width: 150px">
                <label class="style_radio" style="">
                    <?php echo __('Password'); ?>:
                </label>
            </div>
            <div style="float: left">
                <label class="style_textfield" >
                    <input name="password" type="password" id="password" style="width:300px;" />
                </label>
            </div>
            <div style="clear: both"></div>
        </div>
        
        <br>
        <div style="float: left; width: 150px">
            &nbsp;
        </div>
        <div style="float: left">
            <a href="javascript:void(0)" class="btn btn-primary" id="btn_login" style="width: 100px;"><i class="icon-lock"></i>&nbsp;<?php echo __('Login'); ?></a>
        </div>
        <div style="clear: both"></div>
        <br>
    </form>

</div>