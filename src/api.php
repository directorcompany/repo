<?php

namespace App;

use App\Models\User;
use App\Models\Post;
use App\db\DB;

class Api
{

    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    } 

    public function connection()
    {
        //TODO: Implement api: get user by id, create user
        header('Content-Type: application/json');
        $id = $_SERVER['REQUEST_URI'];
        $id =  @(int) explode('/', $id)[3];
        $method = $_SERVER['REQUEST_METHOD'];
        if(empty($id) && $method=="PUT") {
            $id=$this->createUser();
            $this->getUser($id);
        } else {
            $this->getUser($id);
        }
            
    }

    public function getUser($id) {

        $get = User::findOne($id);
        echo json_encode($get);
    }

    public function createUser() {
        $db = $this->db;
        $response = file_get_contents('php://input');
        $getcontent = json_decode($response,true); //$_PUT contains put fields 
        $user =  new User();
        $user->email = $getcontent["email"];
        $user->first_name=$getcontent["first_name"];
        $user->last_name = $getcontent["last_name"];
        $user->password = $getcontent["password"];
        $user->save();
        // return $db->lastInsertRowId();
    }
}
