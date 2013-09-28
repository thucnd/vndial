<?php
if (!isset($edit)) {
    $edit = false;
}
?>

<legend><strong><small><?php echo __('Survey Question Information'); ?></small></strong></legend>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Question'); ?>
        <em>*</em>
    </label>
    <input name="question" type="text" id="question" class="required" value="<?php if ($edit) echo $survey['Survey']['question']; ?>"/>
    <label class="lbl-note">
        <?php echo __('Enter your question'); ?>
    </label>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Description '); ?>
    </label>
    <textarea name="description" id="description" rows="5"  style="width:500px;"><?php if ($edit) echo $survey['Survey']['description']; ?></textarea>
</div>

<div class="line-box">
    <label class="lbl-required" >
        <?php echo __('Audio files'); ?>
        <em>*</em>
    </label>
    <select name="recording_id" id="recording_id" class="input-medium">
        <?php foreach ($recordings as $value) { ?>
            <option value="<?php echo $value['Recording']['recording_id']; ?>"
            <?php if ($edit) { ?>
                <?php if (intval($value['Recording']['recording_id']) === intval($survey['Survey']['recording_id'])) { ?>        
                    <?php echo "selected"; ?>
                <?php } ?>
            <?php } ?>
                    >
                        <?php echo $value['Recording']['name']; ?>
            </option>
        <?php } ?>
    </select>
</div>

<legend><strong><small><?php echo __('Survey respones'); ?></small></strong></legend>

<div style="cursor: pointer;" id="add_response">
    <a href="#myModal" data-toggle="modal">
        <?php echo $this->Html->image('btn_add.png', array("alt" => "add")); ?>
    </a>
</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="form-close">×</button>
        <h3 id="myModalLabel">Create new repones</h3>
    </div>
    <div class="modal-body">
        <div class="line-box">
            <div class="row">
                <div class="span2">
                    <label class="lbl-required" ><?php echo __('Survey type'); ?></label>
                </div>
                <div class="span3 clearfix">
                    <select name="survey_type_id" id="survey_type_id" >
                        <option value="0"><?php echo __('Get repones'); ?></option>
                        <option value="1"><?php echo __('Transfer call'); ?></option>
                        <option value="2"><?php echo __('Recording'); ?></option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="span2">
                    <label class="lbl-required" ><?php echo __('Digit'); ?></label>
                </div>
                <div class="span3 clearfix">
                    <select name="digit_id" id="digit_id" >
                        <?php for ($i = 0; $i < 10; $i++) { ?>
                            <option value="<?php echo $i ?>"><?php echo __('Key') . ' ' . $i; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="span2">
                    <label class="lbl-required" ><?php echo __('Digit value'); ?></label>
                </div>
                <div class="span3 clearfix">
                    <input name="digit_value" type="text" id="digit_value" class="required"/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer" id ="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true" id="repone-close">Close</button>
        <button class="btn btn-primary" data-dismiss="modal" id="repone-save">Save</button>
        <button class="btn btn-primary" data-dismiss="modal" id="repone-update" style="display: none;">Update</button>
    </div>
</div>

<br>
<div id="repone-data">
<?php
if($edit) {
    $surveyType = array("Get repones", "Transfer call", "Recording");
    foreach ($survey['Response'] as $response) {
        $jsonData = array();
        $jsonData['response_id'] = $response['response_id'];
        $jsonData['key_digit'] = $response['key_digit'];
        $jsonData['survey_type'] = $response['survey_type'];
        $jsonData['key_value'] = $response['key_value'];
        echo '<div id = "row_' . $response['key_digit'] . '" class="line-box"><div style="display:none;" id = "key_' . $response['key_digit'] . '">' . json_encode($jsonData) . '</div><strong>Key ' . $response['key_digit'] . ':</strong>   Survey type: ' . $surveyType[$response['key_digit']] . ' , Digit value: ' . $response['key_value'] . '   <a href="#myModal" data-toggle="modal" onClick="edit(' . $response['key_digit'] . ')"><i class="icon-edit"></i></a><a style="cursor: pointer;" onClick="remove(' . $response['key_digit'] . ')"><i class="icon-remove"></i></a></div>';
    }
}
?>
</div>
