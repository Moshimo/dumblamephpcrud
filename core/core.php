<?php

abstract class DataType
{
    const INT = 0;
    const BOOL = 1;
    const STRING = 2;
    const FLOAT = 3;
    const DATETIME = 4;
    const DATE = 5;
    const TIME = 6;
    const TIMESTAMP = 7;
    const DOUBLE = 8;
    const FK = 9;
    const KEY = 10;
    const KEYFK = 11;
    const TEXT = 12;
}

class ForeignKey
{
    public $name = "";
    public $keyGroup = array();
    public $theirIds = array();
    public $objResolve;
    public $label;
    public $displayName = "";

    function __construct($name, $displayName, $keyGroup, $theirIds, $objResolve, $label)
    {
        $this->name = $name;
        $this->displayName = $displayName;
        $this->keyGroup = $keyGroup;
        $this->theirIds = $theirIds;
        $this->objResolve =$objResolve;
        $this->label = $label;
    }
}

class Entity
{
    public $title = "";
    public $data = array();
    public $fk = array();
    public $table = "";

    // function __construct($table, $title = "", $data = array(), $fk = array())
    // {
    //     $this->table = $table;
    //     $this->title = $title;
    //     $this->data = $data;
    //     $this->fk = $fk;
    // }
}

abstract class Renderer
{
    abstract function GenerateIndex($items);

    abstract function RenderList($data);
    abstract function RenderViewSingle($data);
    abstract function RenderEditSingle($data, $request, $duplicate);
    abstract function RenderNew($data);

    abstract function OnDeleteEntity($data, $result);
    abstract function OnAddEntity($data, $result);
    abstract function OnUpdateEntity($data, $result);

    abstract function OnEntityNotFound($data);
    abstract function OnActionNotFound($data);
}

function HasValue(&$lookup, $val)
{
    return isset($lookup->{$val}) && $lookup->{$val} != "";
}

include_once 'database.php';
$db = new Database();
$request = (object) $_REQUEST;