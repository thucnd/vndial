<legend>
    <strong><?php echo __('Survey'); ?></strong>
</legend>
<?php if ($this->Session->check('Message.flash')){ ?> 
    <div class="alert alert-success message_box"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $this->Session->flash(); ?></div>
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
        controller = $('input#controller').val();
        parseHeader();
    </script>
</div>
