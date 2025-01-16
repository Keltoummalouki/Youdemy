<?php
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    
  error_log("Error: [$errno] $errstr - File: $errfile, Line: $errline", 3, "error_log.txt");

  if (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    echo "An error occurred: $errstr on line $errline in $errfile";
  } else {
    echo "Oops! Something went wrong. Our team has been notified.";
  }

}

set_error_handler("customErrorHandler"); 

echo $undefinedVariable;
?>
