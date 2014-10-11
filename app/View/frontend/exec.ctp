{"status":<?php echo $status; ?>,
"message":"<?php echo $message; ?>"
<?php
if ($errors):
    echo ",\"errors\": [";
    foreach ($errors as $i => $error):
        $emsg = $error;
        if ($i >= 1):
            echo ",";
        endif;
        echo "{\"message\":\"" . $emsg . "\"}";
    endforeach;
    echo "]";
endif;
if ($list):
    echo ",\"data\": " . json_encode($list);
endif;
?>
}