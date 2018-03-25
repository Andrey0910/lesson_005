<?php

namespace App;
class ModelUsers
{
    protected $users = [
            "User1", "User2", "User3"
    ];
    public function getAllUsers(){
        return $this->users;
    }
    public function getFirstUser(){
        return $this->users[0];
    }
    public function getUserId($id){
        return $this->getUserId($id);
    }
}