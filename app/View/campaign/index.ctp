<legend>
    <strong><?php echo __('Campaigns'); ?></strong>
</legend>
<?php if ($this->Session->check('Message.flash')){ ?> 
    <div class="message_box"><?php echo $this->Session->flash(); ?></div>
<?php } ?>
<div id="msg"></div>
<div class="table-list">
    <table class="vndial-table" style="display: none"></table>
    <script type="text/javascript">
        controller = $('input[type=hidden]#controller').val();
        parseHeader();
    </script>
</div>
