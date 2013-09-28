<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(array(
            'login'
            ,'bootstrap'
        ));
        
        echo $this->Html->script(array(
            'jquery-1.7.2.min',
            'common',
            'jquery.validate.min',
            'login'
        ));
        
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="container">
            <div id="">
                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
                COPYRIGHT© VNDIAL CO.,LTD ALL RIGHTS RESERVED.
            </div>
        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
