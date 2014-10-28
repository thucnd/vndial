<?php
$start_date = date("Y-m-d", $_SERVER['REQUEST_TIME']);
$end_date = date("Y-m-d", $_SERVER['REQUEST_TIME']);
?>
<div class="well">
    <div class="line-box">
        <?php echo $this->Form->button('Today', array('type' => 'button', 'class' => 'btn btn-info', 'id' => 'report-today')); ?>
        <?php echo $this->Form->button('Yesterday', array('type' => 'button', 'class' => 'btn btn-info', 'id' => 'report-yesterday')); ?>
        <?php echo $this->Form->button('This month', array('type' => 'button', 'class' => 'btn btn-info', 'id' => 'report-this-month')); ?>
    </div>
    <div class="line-box">
        <div class="input-append date " id="start_at" data-date="" data-date-format="yyyy-mm-dd">
            <input type="text" class="span2" id="start_date" name="start_date"  value="<?php echo $start_date; ?>"/>
            <span class="add-on">
                <i class="icon-calendar"></i>
            </span>
        </div>   

        <div class="input-append date" id="stop_at" data-date="" data-date-format="yyyy-mm-dd">
            <input type="text" class="span2" id="stop_date" name="stop_date" value="<?php echo $end_date; ?>"/>
            <span class="add-on">
                <i class="icon-calendar"></i>
            </span>
        </div>
    </div>  
    <div class="line-box">
        <?php echo $this->Form->button('Search', array('type' => 'button', 'class' => 'btn btn-primary', 'id' => 'report-search')); ?>
    </div>
</div>