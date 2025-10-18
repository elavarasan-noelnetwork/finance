<?php

namespace app\models;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
use core\MysqliDb;

Model::autoload();

class Model{  

    public static $db;
    protected $dbTable;

    public static function autoload(){
        if(empty(self::$db)){
            self::$db = new MysqliDb (DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
        }
        
    }

    public function get($where='',$limit=null,$coloumns='*',$order_by="",$group_by=""){

        if(!empty($where)){

            // This if condition added by elavarasan
            if(is_array($where)){
                foreach($where as $_Akey => $_Aval){
                    Model::$db->where($_Akey,$_Aval);              
                }
            }else{
                Model::$db->where($where);      
            }
        }    


        if(!empty($order_by)){
            $orders = explode(",",$order_by);
            foreach($orders as $order){
                if(empty($order)) continue;
                $part = explode(" ",trim($order));
                if(!empty($part[0]) && !empty($part[1])){
                    Model::$db->orderBy($part[0],$part[1]);   
                }else{
                    Model::$db->orderBy($part[0],"asc");
                }
            }            
        }  
           
        if(!empty($group_by)){
             Model::$db->groupBy($group_by);
        }       
        
        /* echo "<pre>";
        print_r(Model::$db);die; */
        
        $x =  Model::$db->get($this->dbTable,$limit,$coloumns);

        //echo Model::$db->getLastQuery();die;
        
        return $x;

    }

    public function getOne($where='',$coloumns='*'){
        $rs =  $this->get($where,[0,1],$coloumns);
        return !empty($rs[0]) ? $rs[0] : [];
    }

    public function insert($data){
        try {
            return Model::$db->insert ($this->dbTable, $data);
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                return "Error: Email already exists.";
            } else {
                return "Database Error: " . $e->getMessage();
            }
        } catch(Exception $e){
            return "Database Error: " . $e->getMessage();
        }
        
    }

    public function update($data,$where){

        try {
            if (empty($data)) {
                return false; // prevent invalid SQL
            }

            if (empty($where)) {
                return false; // safety: avoid updating all rows
            }

            if(is_array($where)){
                foreach($where as $_Akey => $_Aval){
                    Model::$db->where($_Akey,$_Aval);              
                }
            }else{
                Model::$db->where($where);      
            }
            //Model::$db->where($where);
            return Model::$db->update ($this->dbTable, $data);

        } 
        catch (\Throwable $e) {
            return false;
        }

    }

    public function delete($where){
        if(empty($where)){
            echo "no object found to delete";
            return;
        }
        if(is_array($where)){
            foreach($where as $_Akey => $_Aval){
                Model::$db->where($_Akey,$_Aval);              
            }
        }else{

            Model::$db->where($where);      
        }
        return Model::$db->delete ($this->dbTable);
    }

    

}
