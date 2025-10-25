<?php
/* ======================================
  Filename: CustomPdfExceptionController
  Author: Ameen 
  =======================================
*/

namespace app\Controllers;

class CustomPdfExceptionController extends \Exception {
    protected $details;

    public function __construct($message = "", $code = 0, $previous = null, $details = null) {
        // $previous can be Error or Exception in PHP 7
        parent::__construct($message, $code, $previous);
        $this->details = $details;
    }

    public function getDetails() {
        return $this->details;
    }
}