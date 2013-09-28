<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>
        </title>
    <?php
        for ($i = 0; $i < count($csss); $i++):
            echo $this->Html->css($csss[$i] . ".css");
        endfor;
    
        for ($i = 0; $i < count($javascripts); $i++):
            echo $this->Html->script($javascripts[$i] . ".js");
        endfor;
    ?>
    </head>
    <body>
        <?php echo $this->fetch('content'); ?>
    </body>
</html>
