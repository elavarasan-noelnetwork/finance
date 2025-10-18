<?php

spl_autoload_register(function ($class_name) {
//    if (str_starts_with($class_name, "WP_") || "CleanRegex/Pattern") {
//      return;
//    }
    $filename = APP_DIR."/".str_replace('\\',"/",$class_name) . '.php';

    if (file_exists($filename)) {
      include $filename;
    }
});
