<legend>
    <strong><?php echo __('Contacts'); ?></strong>
</legend>
<div class="table-list">
    <div id="alert-msg" class="alert-msg" style="display: none;"></div>
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
