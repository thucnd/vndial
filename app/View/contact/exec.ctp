{"status":<?php echo $status; ?>,
"message":"<?php echo $message; ?>",
"count":
<?php
if (isset($tblHeader)) {
    echo count($tblHeader);
} else {
    echo 0;
}
?>

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
if ($tblHeader):
    echo ",\"results\": " . json_encode($tblHeader);
endif;
?>
}