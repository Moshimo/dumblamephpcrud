<?php

class User extends Entity
{
    public $title = "Users";
    public $data = array(
            "id" => [
                "type" => DataType::KEY,
                "label" => "Id",
                "showInList" => false,
                "showInDetail" => false,
                "nullable" => false],

            "username" => [
                "type" => DataType::STRING,
                "label" => "Username",
                "showInList" => true,
                "showInDetail" => true,
                "nullable" => false],

            "password" => [
                "type" => DataType::STRING, 
                "label" => "Password", 
                "showInList" => false, 
                "showInDetail" => true,
                "nullable" => false],

            "last_access" => [
                "type" => DataType::DATETIME, 
                "label" => "Last Access", 
                "showInList" => true, 
                "showInDetail" => false,
                "nullable" => true],

            "expire_date" => [
                "type" => DataType::DATETIME, 
                "label" => "Expires", 
                "showInList" => true, 
                "showInDetail" => true,
                "nullable" => true],

            "privilege_id" => [
                "type" => DataType::FK, 
                "label" => "Privilege", 
                "showInList" => true, 
                "showInDetail" => true,
                "nullable" => false],

            "enabled" => [
                "type" => DataType::BOOL, 
                "label" => "Is Ebabled", 
                "showInList" => true, 
                "showInDetail" => true,
                "nullable" => false],
        );
    public $fk = array();
    public $table = "user";

    function __construct()
    {
        $this->fk = array(
            0 => new ForeignKey(
                "fk_privilege", 
                "Corso", 
                array("privilege_id"), 
                array("id"), 
                new Privilege(), 
                "name"),
        );
    }
}

class Privilege extends Entity
{
    public $title = "Privileges";
    public $data = array(
            "id" => [
                "type" => DataType::KEY,
                "label" => "Id",
                "showInList" => false,
                "showInDetail" => false,
                "nullable" => false],

            "name" => [
                "type" => DataType::STRING,
                "label" => "Title",
                "showInList" => true,
                "showInDetail" => true,
                "nullable" => false],
        );
    public $fk = array();
    public $table = "privilege";

    function __construct() { }
}

$items = [new User(), new Privilege()];