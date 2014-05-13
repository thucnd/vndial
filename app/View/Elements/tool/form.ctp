<?php if($this->Role->checkPermission($controller.'_edit')) { ?>
    <div class="toolbar-box">
        <spa id="tool-btn-new" class="toolbar-btn">
            <img width="25" height="25" alt="Smiley face" src="../img/btn_plus.png">
        </spa>
        <spa id="tool-btn-delete" class="toolbar-btn">
            <img width="25" height="25" alt="Smiley face" src="../img/btn_delete.png">
        </spa>
    </div>
<?php } ?>