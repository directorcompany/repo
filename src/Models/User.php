<?php
namespace App\Models;
use App\db\DB;

class User {
    
 /**
  * 
  * attributes table users
  * @var mixed
  */
    protected int $id; 
    protected string $email; 
    protected string $first_name;
    protected string $last_name;
    protected string $password; 
    protected int $created_at;
    protected $db;

     public function __construct() {
         $this->db = DB::getInstance()->getConnection();
     }

     private static $instance = null;

     
     public static function getInstance(): User
     {
         if (!self::$instance) {
             self::$instance = new static();
         }
 
         return self::$instance;
     }

     
     public function __get($key) {

        if(property_exists($this,$key)) {

            return $this->$key;
        }
    }

     public function __set($key,$value) {
        if(property_exists($this,$key)) {
            $this->$key=$value;
     }
    }

    /**
     * save data to table users
     *
     * @return void
     */ 

    public function save() {
        
       $db=$this->db;
       $email = $db->escapeString($this->email);
       $first_name = $db->escapeString($this->first_name);
       $last_name = $db->escapeString($this->last_name);
       $password = $db->escapeString($this->password);
       $created_at = time();
       $insert = "INSERT INTO users(email,first_name,last_name,password,created_at) 
       VALUES('$email','$first_name','$last_name','$password','$created_at')";
       $db->exec($insert);
       $this->id = $db->lastInsertRowId();  
    }    
    /**
     * findOne
     *
     * @param  mixed $id
     * @return void
     */
    public static function findOne(int | null $id = null) { 
        $db = DB::getInstance()->getConnection();
        $rowId = $db->lastInsertRowId();
        $statement = $db->prepare('SELECT * FROM users WHERE id = :id');
        $id = $id ?? $rowId;
        $statement->bindValue(':id',$id);
        $result = $statement->execute();
        $select= $result->fetchArray(SQLITE3_ASSOC);
         return (object) $select;  
    }
    
}