<?php

namespace app\models;
use app\models\Model;


class ExampleModel extends Model {

    /* 
    //Table name of the model 
    protected $dbTable = "table_example";

    public function get_users($email_string){
        //To use other tables from the Exmple Model

        //Join Example
        Model::$db->join("users_info B", "A.id = B.user_id", "LEFT");

        // Where Example
        Model::$db->where("A.user_email IN ({$email_string}) AND B.country='IN' ");
        // or DB::where('id', 7)->where('title', 'MyTitle'); 

        // Having Example 
        Model::$db->having(" MAX(B.age) = 2 ");
        //or DB::having('MAX(B.age)', 2 , "=")  

        // rder By Example
        Model::$db->orderBy("A.name","asc");

        
        // Return the result data array
        // DB::get("table",[$from,$offset],select_fileds)
        
        // Example

        // To get all rows
        // DB::get("table",null,select_fileds)

        // To get from 10th record to 15th record
        // DB::get("table",[10,5],select_fileds)

        // To get a single record
        // DB::getOne("table",select_fileds)
        // DB::getOne("table",'*')

        return Model::$db->get ("users A",null, "A.id, A.user_email, A.name, B.address, B.mobile");

        
        // To get data with TotalCount - no of Rows
        
        // $users = Model::$db->withTotalCount()->get ("users A",null, "A.id, A.user_email, A.name, B.*");
        // $total_users = Model::$db->totalCount;
        

        // For more details Refer Here http://github.com/joshcam/PHP-MySQLi-Database-Class         
    
    }
    */
    
}