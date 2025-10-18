<?php

namespace core;

Class View{

    public static function render($path,$data=[],$html=true){

        if(count($data) > 0){
            extract($data);
            unset($data);
        }        



        if(!file_exists(APP_DIR."/"."template/".$path.".php")){
            echo "No View files exist in template : ".$path;
        }
        if(!$html){
            ob_start();
        }
        require(APP_DIR."/"."template/".$path.".php");
        if(!$html){
            return ob_get_clean();
        }
    }

}
