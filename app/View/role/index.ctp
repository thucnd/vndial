<legend><strong><?php echo __('Roles'); ?></strong></legend>
<?php if ($this->Session->check('Message.flash')){ ?> 
    <div class="alert alert-success message_box"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $this->Session->flash(); ?></div>
<?php } ?>
<div class="table-list">
    <?php echo $this->element('tool/form'); ?>
    <div class="bTable"></div>
    <script type="text/javascript">
        controller = $('input[type=hidden]#controller').val();
        parseHeader();
    </script>
</div>

