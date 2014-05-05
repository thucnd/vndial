<legend><strong><?php echo __('Users'); ?></strong></legend>
<?php if ($this->Session->check('Message.flash')){ ?> 
    <div class="message_box"><?php echo $this->Session->flash(); ?></div>
<?php } ?>
<div class="table-list">
    <div class="toolbar-box">
        <spa id="tool-btn-new" class="toolbar-btn">
            <img width="25" height="25" alt="Smiley face" src="../img/btn_plus.png">
        </spa>
        <spa id="tool-btn-delete" class="toolbar-btn">
            <img width="25" height="25" alt="Smiley face" src="../img/btn_delete.png">
        </spa>
    </div>
    <div class="bTable"></div>
    <script type="text/javascript">
        controller = $('input[type=hidden]#controller').val();
        parseHeader();
    </script>
</div>

