<?php

function GetFKForReadEntity($obj, $field, $fks, &$cachedFK)
{
    global $db;
    if ($cachedFK == NULL)
        $cachedFK = [];
        
    $separator = "/";
    $separator2 = " AND ";
    $fkIds = array();
    foreach ($fks as $fk) {
        if (in_array($field, $fk->keyGroup))
        {
            $cacheKey = "";
            $whereCondition = "";
            for ($i=0; $i < count($fk->keyGroup); $i++) { 
                $cacheKey .= $obj->{$fk->keyGroup[$i]} . $separator;
                $whereCondition .= "`" . $fk->theirIds[$i] . "` = " . $obj->{$fk->keyGroup[$i]} . $separator2;
                $fkIds[$fk->keyGroup[$i]] = $obj->{$fk->keyGroup[$i]};
            }
            $whereCondition = substr($whereCondition, 0 , strlen($whereCondition) - strlen($separator2));
            $cacheKey = substr($cacheKey, 0 , strlen($cacheKey) - strlen($separator));
            
            if (array_key_exists($cacheKey, $cachedFK))
                return $cachedFK[$cacheKey];
            else
            {
                $resSet = $db->RetrievingQuery("SELECT * FROM `" . $fk->objResolve->table . "` WHERE $whereCondition", array(), false);
                $cachedFK[$cacheKey] = array("fk_obj" => $resSet, "fk_ids" => $fkIds, "fk_label" => $fk->label);
            }
            return $cachedFK[$cacheKey];
        }
    }
}

function GetFKForListEntity($obj, $field, $fks)
{
    global $db;
        
    $separator = "/";
    $separator2 = " AND ";
    $fkIds = array();
    foreach ($fks as $fk) {
        if (in_array($field, $fk->keyGroup))
        {
            $cacheKey = "";
            $whereCondition = "";
            for ($i=0; $i < count($fk->keyGroup); $i++) { 
                $cacheKey .= $obj->{$fk->keyGroup[$i]} . $separator;
                $whereCondition .= "`" . $fk->theirIds[$i] . "` = " . $obj->{$fk->keyGroup[$i]} . $separator2;
                $fkIds[$fk->keyGroup[$i]] = $obj->{$fk->keyGroup[$i]};
            }
            $whereCondition = substr($whereCondition, 0 , strlen($whereCondition) - strlen($separator2));
            $cacheKey = substr($cacheKey, 0 , strlen($cacheKey) - strlen($separator));
            
            $resSet = $db->RetrievingQuery("SELECT * FROM `" . $fk->objResolve->table . "` WHERE $whereCondition", array(), false);
            return array("fk_obj" => $resSet, "fk_ids" => $fkIds, "fk_label" => $fk->label);
        }
    }
}

function GetFKForEditEntity($obj, $fieldKey, $field)
{
    global $db;
    foreach ($field as $index => $fk)
    {
        if (in_array($fieldKey, $fk->keyGroup))
        {
            $resSet = $db->RetrievingQuery("SELECT * FROM `" . $fk->objResolve->table . "`");
            $separator = "/";
            $row = array();
            foreach ($resSet as $res)
            {
                $id = "";
                $isSelected = true;
                for ($i=0; $i < count($fk->keyGroup); $i++) { 
                    $id .= $res->{$fk->theirIds[$i]} . $separator;
                    if ($res->{$fk->theirIds[$i]} != $obj->{$fk->keyGroup[$i]})
                    {
                        $isSelected = false;
                    }
                    if (strlen($id) > 0)
                        $id = substr($id, 0, strlen($id) - strlen($separator));
                }
                array_push($row, array(
                    "id" => $id,
                    "selected" => $isSelected,
                    "label" => $res->{$fk->label}
                ));
            }
            return $row;
            // break;
        }
    }
}

function GetFKForNewEntity($fieldKey, $field)
{
    global $db;
    foreach ($field as $index => $fk)
    {
        if (in_array($fieldKey, $fk->keyGroup))
        {
            $resSet = $db->RetrievingQuery("SELECT * FROM `" . $fk->objResolve->table . "`");
            $separator = "/";
            $row = array();
            foreach ($resSet as $res)
            {
                $id = "";
                for ($i=0; $i < count($fk->keyGroup); $i++) { 
                    $id .= $res->{$fk->theirIds[$i]} . $separator;
                    if (strlen($id) > 0)
                        $id = substr($id, 0, strlen($id) - strlen($separator));
                }
                array_push($row, array(
                    "id" => $id,
                    "label" => $res->{$fk->label}
                ));
            }
            return $row;
        }
    }
}

function GetNewEntityData($obj)
{
    $data = $obj->data;
    $columns = array();
    foreach ($data as $key => $field) {
        if ($field["type"] == DataType::FK || $field["type"] == DataType::KEYFK)
        {
            $columns[$key] = array("field" => $field, "fk" => GetFKForNewEntity($key, $obj->fk));
        }
        else
        {
            $columns[$key] = array("field" => $field);
        }
    }
    return array("columns" =>  $columns, "entity" => $obj);
}

function GetEditEntityData($obj, $reqParams)
{
    $data = $obj->data;
    $whereCondition = "";
    $separator = " AND ";
    foreach ($reqParams as $key => $value) {
        if ($key != "table" && $key != "action")
        {
            $whereCondition .= "`$key` = " . $value . $separator;
        }
    }
    if (strlen($whereCondition) > 0)
        $whereCondition = substr($whereCondition, 0, strlen($whereCondition) - strlen($separator));

    $sql = "SELECT * FROM `" . $obj->table . "` WHERE " . $whereCondition;
    global $db;
    $res = $db->RetrievingQuery($sql, array(), false);

    $columns = array();
    foreach ($data as $key => $val) {
        if ($val["type"] == DataType::FK || $val["type"] == DataType::KEYFK)
        {
            $columns[$key] = array("field" => $val, "value" => GetFKForEditEntity($res, $key, $obj->fk));
        }
        else
        {
            $columns[$key] = array("field" => $val, "value" => $res->{$key});
        }
    }

    return array("columns" =>  $columns, "entity" => $obj);
}

function ReadEntityData($obj, $reqParams)
{
    $data = $obj->data;
    $whereCondition = "";
    $separator = " AND ";
    foreach ($reqParams as $key => $value) {
        if ($key != "table" && $key != "action")
        {
            $whereCondition .= "`$key` = " . $value . $separator;
        }
    }
    if (strlen($whereCondition) > 0)
        $whereCondition = substr($whereCondition, 0, strlen($whereCondition) - strlen($separator));

    $sql = "SELECT * FROM `" . $obj->table . "` WHERE " . $whereCondition;
    global $db;
    $res = $db->RetrievingQuery($sql, array(), false);

    $cacheKey = [];
    $columns = array();
    foreach ($data as $key => $val) {
        if ($val["nullable"] && !isset($res->{$key}))
        {
            $columns[$key] = array("field" => $val, "value" => NULL);
        }

        else if ($val["type"] == DataType::FK || $val["type"] == DataType::KEYFK)
        {
            $fk = GetFKForReadEntity($res, $key, $obj->fk, $cacheKey[]);
            $columns[$key] = array("field" => $val, "value" => $fk["fk_obj"]->{$fk["fk_label"]}, "fk" => $fk);
        }
        else
        {
            $columns[$key] = array("field" => $val, "value" => $res->{$key});
        }
    }

    return array("columns" =>  $columns, "entity" => $obj);
}

function GetListData($obj)
{
    $data = $obj->data;
    $sql = "SELECT * FROM `" . $obj->table . "`";
    global $db;
    $resSet = $db->RetrievingQuery($sql);

    $rows = array();
    $cacheKey = [];
    foreach ($resSet as $resKey => $res) {
        $columns = array();
        foreach ($data as $key => $val) {
            if ($val["nullable"] && !isset($res->{$key}))
            {
                $columns[$key] = array("field" => $val, "value" => NULL);
            }

            else if ($val["type"] == DataType::FK || $val["type"] == DataType::KEYFK)
            {
                $fk = GetFKForListEntity($res, $key, $obj->fk, $cacheKey);
                $columns[$key] = array("field" => $val, "value" => $fk);
            }
            else
            {
                $columns[$key] = array("field" => $val, "value" => $res->{$key});
            }
        }
        $rows[$resKey] = $columns;
    }

    return array("rows" => $rows, "entity" => $obj);
}

function DeleteEntity($data)
{
    $whereConditions = "";
    $separator = " AND ";
    foreach ($data as $key => $value) {
        if ($key != "table" && $key != "action")
            $whereConditions .= "`$key` = " . $value . $separator;
    }
    if (strlen($whereConditions) > 0)
        $whereConditions = substr($whereConditions, 0, strlen($whereConditions) - strlen($separator));

    $sql = "DELETE FROM `$data->table` WHERE " . $whereConditions;
    global $db;
    $db->ImperativeQuery($sql);

    return true; // ToDo: Not always true
}

function AddEntity($obj, $data)
{
    $inserts = "";
    $values = "";
    $separator = ", ";
    foreach ($obj->data as $key => $value)
    {
        if (isset($data->{$key}) || ($value["type"] == DataType::BOOL) && $value["showInDetail"])
        {
            $inserts .= "`$key`, ";

            if (!$value["nullable"] || ($value["nullable"] && isset($data->{$key . "_notnull"})))
            {
                if ($value["type"] == DataType::STRING)
                    $values .= "\"".$data->{$key}."\"" . $separator;
                else if ($value["type"] == DataType::BOOL)
                    $values .= (isset($data->{$key}) ? "1" : "0") . $separator;
                else
                    $values .= "\"".$data->{$key}."\"" . $separator;
            }
            else
            {
                $values .= "NULL" . $separator;
            }
        }
    }
    foreach ($obj->fk as $key => $value) {
        if (isset($data->{$value->name}))
        {
            $ids = explode("/", $data->{$value->name});
            $fknames = [];
            foreach ($value->keyGroup as $group) {
                $fknames[] = $group;
            }
            $i = 0;
            foreach ($ids as $fkid) {
                $inserts .= "`$fknames[$i]`". $separator;
                $values .= $fkid . $separator;
            }
        }
    }
    if (strlen($inserts) > 0)
        $inserts = substr($inserts, 0, strlen($inserts) - strlen($separator));
    if (strlen($values) > 0)
        $values = substr($values, 0, strlen($values) - strlen($separator));
    
    $sql = "INSERT INTO `$data->table` ($inserts) VALUES ($values)";
    global $db;
    $db->ImperativeQuery($sql);

    return true; // ToDo: Not always true
}

function UpdateEntity($obj, $data)
{
    $whereConditions = "";
    $updates = "";
    $separator = ", ";
    $separator2 = " AND ";
    foreach ($obj->data as $key => $value) {
        if ($value["type"] == DataType::KEY || $value["type"] == DataType::KEYFK)
        {
            $whereConditions .= "`$key` = " . $data->{$key} . $separator2;
        }
        else
        {
            if (isset($data->{$key}) || ($value["type"] == DataType::BOOL) && $value["showInDetail"])
            {
                if (!$value["nullable"] || ($value["nullable"] && isset($data->{$key . "_notnull"})))
                {
                    if ($value["type"] == DataType::STRING)
                        $updates .= "`$key` = " . "\"".$data->{$key}."\"" . $separator;
                    else if ($value["type"] == DataType::BOOL)
                        $updates .= "`$key` = " . (isset($data->{$key}) ? "1" : "0") . $separator;
                    else
                        $updates .= "`$key` = " . "\"".$data->{$key}."\"" . $separator;
                }
                else
                {
                    $updates .= "`$key` = NULL" . $separator;
                }
            }
        }
    }
    $fkUpdates = "";
    foreach ($obj->fk as $key => $value) {
        if (isset($data->{$value->name}))
        {
            $ids = explode("/", $data->{$value->name});
            $fknames = [];
            foreach ($value->keyGroup as $group) {
                $fknames[] = $group;
            }
            $i = 0;
            foreach ($ids as $fkid) {
                $fkUpdates .= $fknames[$i] . " = " . $fkid . $separator;
            }
        }
    }
    $updates .= $fkUpdates;

    if (strlen($whereConditions) > 0)
        $whereConditions = substr($whereConditions, 0, strlen($whereConditions) - strlen($separator2));
    if (strlen($updates) > 0)
        $updates = substr($updates, 0, strlen($updates) - strlen($separator));
        
    $sql = "UPDATE `$data->table` SET " . $updates . " WHERE " . $whereConditions;
    global $db;

    $db->ImperativeQuery($sql);

    return true; // ToDo: Not always true
}

function Enroute($items, $reqParams, $renderer)
{
    if (!HasValue($reqParams, "action"))
        $renderer->GenerateIndex($items);
    else
    {
        $found = null;
        foreach ($items as $entity) {
            if ($entity->table == $reqParams->table)
            {
                $found = $entity;
                break;
            }
        }
        if ($found)
        {
            if ($reqParams->action == "delete")
                $renderer->OnDeleteEntity($reqParams, DeleteEntity($reqParams));
            else if ($reqParams->action == "view")
                $renderer->RenderViewSingle($found ? ReadEntityData($found, $reqParams) : NULL);
            else if ($reqParams->action == "list")
                $renderer->RenderList($found ? GetListData($found) : NULL);
            else if ($reqParams->action == "new")
                $renderer->RenderNew($found ? GetNewEntityData($found) : NULL);
            else if ($reqParams->action == "add")
                $renderer->OnAddEntity($reqParams, AddEntity($found, $reqParams));
            else if ($reqParams->action == "duplicate")
                $renderer->RenderEditSingle($found ? GetEditEntityData($found, $reqParams) : NULL, $reqParams, true);
            else if ($reqParams->action == "edit")
                $renderer->RenderEditSingle($found ? GetEditEntityData($found, $reqParams) : NULL, $reqParams, false);
            else if ($reqParams->action == "update")
                $renderer->OnUpdateEntity($reqParams, UpdateEntity($found, $reqParams));
            else
                $renderer->OnActionNotFound($reqParams);
        }
        else
            $renderer->OnEntityNotFound($reqParams);
    }
}