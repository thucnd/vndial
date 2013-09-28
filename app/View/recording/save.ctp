{
"status":<?php echo $status; ?>,
"message":"<?php echo $message; ?>"
<?php
if ($errors):
        echo ",\"errors\": [";
        for ($i=0;$i<count($errors);$i++):
                $emsg = $errors[$i];
                if( $i >=1 ):
                        echo ","; 
                endif;
                echo "{\"message\":\"".$emsg ."\"}"; 
        endfor;
        echo "]";
endif;
?>
}