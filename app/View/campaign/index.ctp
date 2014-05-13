<legend>
    <strong><?php echo __('Campaigns'); ?></strong>
</legend>
<?php if ($this->Session->check('Message.flash')){ ?> 
    <div class="message_box"><?php echo $this->Session->flash(); ?></div>
<?php } ?>
<div id="msg"></div>
<div class="table-list">
    <?php echo $this->element('tool/form'); ?>
    <div class="bTable"></div>
    <script type="text/javascript">
        controller = $('input[type=hidden]#controller').val();
        parseHeader();
    </script>
</div>
