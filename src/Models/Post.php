<?php
namespace App\Models;
use App\db\DB;

class Post {
    
 /**
  * 
  * attributes table users
  * @var mixed
  */
    protected int $id; 
    protected string $title;
    protected string $body;
    protected int $creator_id;
    protected int $created_at;
    protected $db;


    private static $instance = null;

    public static function getInstance(): Post
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
        
       $db = DB::getInstance()->getConnection();
       $title = $db->escapeString($this->title);
       $body = $db->escapeString($this->body);
       $creator_id = $db->escapeString($this->creator_id);
       $created_at = time();
       $insert = "INSERT INTO posts (title,body,creator_id,created_at) 
       VALUES('$title','$body','$creator_id','$created_at')";
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
         $id = $id ?? $rowId;
         $statement = $db->prepare('SELECT * FROM posts WHERE id = :id'); 
         $statement->bindValue(':id', $id);
         $result = $statement->execute();
         $select = $result->fetchArray(SQLITE3_ASSOC);
         return (object) $select;
         }
    
}  