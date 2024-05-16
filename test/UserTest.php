<?php
use PHPUnit\Framework\TestCase;
require './autoloader.php';

class UserTest extends PHPUnit\Framework\TestCase{
    public function testUser(){
        $user = new User();
        $this->assertInstanceOf('User', $user);
    }

    public function testInternalCreation(){
        $data = [
            "username" => "user",
            "password" => "123"
        ];
        $user = new User();
        $result = (int)$user->create_internal($data);
        
        $this->assertGreaterThan(0, $result);
    }
}