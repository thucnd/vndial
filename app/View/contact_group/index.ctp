<legend>
    <strong><?php echo __('Groups'); ?></strong>
</legend>
<div class="table-list">
    <div id="alert-msg" class="alert-msg" style="display: none;"></div>
    <?php echo $this->element('tool/form'); ?>
    <div class="bTable"></div>
    <script type="text/javascript">
        controller = $('input#controller').val();
        parseHeader();
    </script>
</div>
<div id="alert-msg" class="alert-msg" style="display: none;"></div>
