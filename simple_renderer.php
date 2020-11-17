<?php
include_once "core/core.php";

class SimpleRenderer extends Renderer
{
    function GenerateIndex($items)
    {
        echo "<ul>";
        foreach ($items as $item) {
            echo "<li><a href=\"?action=list&table=" . $item->table . "\">" . $item->title . "</a></li>";
        }
        echo "</ul>";
    }

    /***************************** PRINTING COMPONENTS */
    function PrintBool($value, $label = NULL)
    {
        if (isset($label))
            echo "<b>$label</b>: ";
        if (isset($value))
            echo "<input type=\"checkbox\" disabled=\"disabled\"" . ($value == 1 ? " checked=\"checked\"" : "") . " />";
    }
    
    function PrintString($value, $label = NULL)
    {
        if (isset($label))
            echo "<b>$label</b>: ";
        if (isset($value))
            echo $value;
    }

    function PrintDateTime($value, $label = NULL)
    {
        if (isset($label))
            echo "<b>$label</b>: ";
        if (isset($value))
            echo date_format(date_create($value), 'd/m/Y H:i');
    }

    function PrintText($value, $label = NULL)
    {
        if (isset($label))
        {
            echo "<b>$label</b>: ";
            echo $value;
        }
        else
        {
            if (isset($value))
                echo strlen($value) > 15 ? substr($value, 0, 50)."..." : $value;
        }
    }

    /***************************** */

    /***************************** EDITING COMPONENTS */
    function EditString($key, $label, $value, $canBeNull)
    {
        echo "<br>";
        if (isset($value))
        {
            if ($canBeNull)
                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" checked=\"checked\"/>";
            echo "<input type=\"text\" name=\"".$key."\" value=\"".$value."\" placeholder=\"".$label."\" />";
        }
        else
        {   
            if ($canBeNull)
                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" />";
            echo "<input type=\"text\" name=\"".$key."\" placeholder=\"".$label."\" />";
        }
    }

    function EditBool($key, $label, $value, $canBeNull)
    {
        echo "<br>";
        if (isset($value))
        {
            if ($canBeNull)
                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" checked=\"checked\"/>";
            echo "<label for=\"".$key."\">".$label."</label>";
            echo "<input type=\"checkbox\" name=\"".$key."\" id=\"".$key."\"" . ($value == 1 ? " checked=\"checked\"" : "") . "/>";
        }
        else
        {   
            if ($canBeNull)
                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" />";
            echo "<label for=\"".$key."\">".$label."</label>";
            echo "<input type=\"checkbox\" name=\"".$key."\" id=\"".$key."\"/>";
        }
    }

    function EditForeignKey($key, $label, $value, $canBeNull)
    {
        echo "<br>";
        $isNull = true;
        foreach ($value as $val)
        {
            if ($val["selected"] == true)
            {
                $isNull = false;
                break;
            }
        }

        if (!$isNull)
        {
            if ($canBeNull)
                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" checked=\"checked\"/>";

            echo "<b>$label</b>: ";
            echo "<select name=\"". $key . "\">";
            foreach ($value as $val)
            {
                echo "<option value=\"".$val["id"]."\" " . ($val["selected"] == true ? " selected=\"selected\"" : "" ) . ">" . $val["label"] . "</option>";
            }
            echo "</select>";
        }
        else
        {   
            if ($canBeNull)
                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" />";

            echo "<b>$label</b>: ";
            echo "<select name=\"". $key . "\">";
            foreach ($value as $val)
            {
                echo "<option value=\"".$val["id"]."\">" . $val["label"] . "</option>";
            }
            echo "</select>";
        }
    }

    function EditText($key, $label, $value, $canBeNull)
    {
        echo "<br>";
        if (isset($value))
        {
            if ($canBeNull)
                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" checked=\"checked\"/>";
            echo "<b>$label</b>: ";
            echo "<textarea rows=\"4\" cols=\"50\" name=\"$key\">" . $value . "</textarea>";
        }
        else
        {   
            if ($canBeNull)
                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" />";
            echo "<b>$label</b>: ";
            echo "<textarea rows=\"4\" cols=\"50\" name=\"$key\"></textarea>";
        }
    }

    function EditDateTime($key, $label, $value, $canBeNull)
    {
        echo "<br>";
        if (isset($value)) // field not null
        {
            if ($canBeNull)
                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" checked=\"checked\"/>";
            
            echo "<b>$label</b>: ";
            echo "<input type=\"datetime-local\" name=\"".$key."\" value=\"".date_format(date_create($value), 'Y-m-d\TH:i')."\" placeholder=\"".$label."\" />";
        }
        else
        {   
            if ($canBeNull)
                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" />";
            
            echo "<b>$label</b>: ";
            echo "<input type=\"datetime-local\" name=\"".$key."\" value=\"\" placeholder=\"".$label."\" />";
        }
    }
    /***************************** */

    /***************************** "NEW" COMPONENTS */
    function NewString($fieldKey, $label, $canBeNull)
    {
        echo "<br>";
        if ($canBeNull)
            echo "<input type=\"checkbox\" name=\"".$fieldKey."_notnull\" id=\"".$fieldKey."_notnull\" checked=\"checked\"/>";
        echo "<input type=\"text\" name=\"".$fieldKey."\" placeholder=\"".$label."\" />";
    }
    
    function NewBool($fieldKey, $label, $canBeNull)
    {
        echo "<br>";
        if ($canBeNull)
            echo "<input type=\"checkbox\" name=\"".$fieldKey."_notnull\" id=\"".$fieldKey."_notnull\" checked=\"checked\"/>";
        echo "<label for=\"".$fieldKey."\">".$label."</label>";
        echo "<input type=\"checkbox\" name=\"".$fieldKey."\" id=\"".$fieldKey."\"/>";
    }
    
    function NewText($fieldKey, $label, $canBeNull)
    {
        echo "<br>";
        if ($canBeNull)
            echo "<input type=\"checkbox\" name=\"".$fieldKey."_notnull\" id=\"".$fieldKey."_notnull\" checked=\"checked\"/>";
        echo "<b>$label</b>: ";
        echo "<textarea rows=\"4\" cols=\"50\" name=\"$fieldKey\"></textarea>";
    }

    function NewDateTime($fieldKey, $label, $canBeNull)
    {
        echo "<br>";
        if ($canBeNull)
            echo "<input type=\"checkbox\" name=\"".$fieldKey."_notnull\" id=\"".$fieldKey."_notnull\" checked=\"checked\"/>";
        echo "<b>$label</b>: ";
        echo "<input type=\"datetime-local\" name=\"".$fieldKey."\" placeholder=\"".$label."\" />";
    }

    function NewForeignKey($fieldKey, $label, $value, $canBeNull)
    {
        echo "<br>";
        if ($canBeNull)
            echo "<input type=\"checkbox\" name=\"".$fieldKey."_notnull\" id=\"".$fieldKey."_notnull\" checked=\"checked\"/>";
        echo "<b>$label</b>: ";
        echo "<select name=\"". $fieldKey . "\">";
        foreach ($value as $val)
        {
            echo "<option value=\"".$val["id"]."\">" . $val["label"] . "</option>";
        }
        echo "</select>";
    }
    /***************************** */

    function RenderList($data)
    {
        if (!isset($data))
        {
            echo "No Entity";
            echo "<br><br><a href=\"?\">Back</a>";
            return;
        }

        echo "<table>";
        echo "<tr>";

        foreach ($data["entity"]->data as $fieldKey => $field) {
            if ($field["showInList"])
            {
                echo "<th>" . $field["label"] . "</th>";
            }
        }

        echo "<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>";
        echo "</tr>";
        foreach($data["rows"] as $rowKey => $row)
        {
            echo "<tr>";
            foreach($row as $colKey => $col)
            {
                if ($col["field"]["type"] == DataType::KEY)
                    $queryString[$colKey] = $col["value"];
                else if ($col["field"]["type"] == DataType::KEYFK)
                {
                    foreach($col["value"]["fk_ids"] as $key => $fkId)
                        $queryString[$key] = $fkId;
                }

                if (!$col["field"]["showInList"] == true)
                {
                    continue;
                }
                echo "<td>";
                if (isset($col["value"]))
                {
                    switch ($col["field"]["type"])
                    {
                        case DataType::BOOL:
                            $this->PrintBool($col["value"]);
                        break;
                        case DataType::INT:
                            $this->PrintString($col["value"]);
                        break;
                        case DataType::STRING:
                            $this->PrintString($col["value"]);
                        break;
                        case DataType::DATETIME:
                            $this->PrintDateTime($col["value"]);
                        break;
                        case DataType::TEXT:
                            $this->PrintText($col["value"]);
                        break;
                        case DataType::KEYFK:
                        case DataType::FK:
                            $this->PrintString($col["value"]["fk_obj"]->{$col["value"]["fk_label"]});
                        break;
                        default:
                        break;
                    }
                }
                echo "</td>";
            }
            $queryString["table"] = $data["entity"]->table;
            $queryString["action"] = "view";
            echo "<td><a href=\"?" . http_build_query($queryString) . "\">View</a></td>";
            $queryString["action"] = "duplicate";
            echo "<td><a href=\"?" . http_build_query($queryString) . "\">Duplicate</a></td>";
            $queryString["action"] = "edit";
            echo "<td><a href=\"?" . http_build_query($queryString) . "\">Edit</a></td>";
            $queryString["action"] = "delete";
            echo "<td><a href=\"?" . http_build_query($queryString) . "\">Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<br><br><a href=\"?action=new&table=".$data["entity"]->table."\">New</a>";
        echo "<br><br><a href=\"?\">Back</a>";
    }

    function RenderViewSingle($data)
    {
        if (!isset($data))
        {
            echo "No Entity";
            echo "<br><br><a href=\"?\">Back</a>";
            return;
        }

        foreach($data["columns"] as $colKey => $col)
        {
            if ($col["field"]["type"] == DataType::KEY || $col["field"]["type"] == DataType::KEYFK)
                $queryString[$colKey] = $col["value"];

            if (!$col["field"]["showInDetail"] == true)
            {
                continue;
            }
            switch ($col["field"]["type"])
            {
                case DataType::BOOL:
                    $this->PrintBool($col["value"], $col["field"]["label"]);
                break;
                case DataType::INT:
                    $this->PrintString($col["value"], $col["field"]["label"]);
                break;
                case DataType::STRING:
                    $this->PrintString($col["value"], $col["field"]["label"]);
                break;
                case DataType::DATETIME:
                    $this->PrintDateTime($col["value"], $col["field"]["label"]);
                break;
                case DataType::TEXT:
                    $this->PrintText($col["value"], $col["field"]["label"]);
                break;
                case DataType::KEYFK:
                case DataType::FK:
                    $this->PrintString($col["value"], $col["field"]["label"]);
                break;
                default:
                break;
            }
            echo "<br>";
        }
        echo "<br>";
        $queryString["table"] = $data["entity"]->table;
        $queryString["action"] = "new";
        echo " <a href=\"?" . http_build_query($queryString) . "\">New</a> ";
        $queryString["action"] = "duplicate";
        echo " <a href=\"?" . http_build_query($queryString) . "\">Duplicate</a> ";
        $queryString["action"] = "edit";
        echo " <a href=\"?" . http_build_query($queryString) . "\">Edit</a> ";
        $queryString["action"] = "delete";
        echo " <a href=\"?" . http_build_query($queryString) . "\">Delete</a> ";

        echo "<br><br><a href=\"?action=list&table=" . $data["entity"]->table . "\">Back</a>";
    }

    function RenderEditSingle($data, $request, $duplicate)
    {
        if (!isset($data))
        {
            echo "No Entity";
            echo "<br><br><a href=\"?\">Back</a>";
            return;
        }

        echo "<form method=\"POST\" action=\"?action=" . ($duplicate ? "add" : "update") . "&table=".$data["entity"]->table."\">";

        foreach ($request as $key => $value) {
            if ($key != "table" && $key != "action")
            {
                if (!$duplicate)
                    echo "<input type=\"hidden\" name=\"$key\" value=\"$value\">";
            }
        }
        foreach ($data["columns"] as $key => $val) {
            if ($val["field"]["showInDetail"] == false)
                continue;
            switch ($val["field"]["type"])
            {
                case DataType::BOOL:
                    $this->EditBool($key, $val["field"]["label"], $val["value"], $val["field"]["nullable"]);
                break;
                case DataType::DATETIME:
                    $this->EditDateTime($key, $val["field"]["label"], $val["value"], $val["field"]["nullable"]);
                break;
                case DataType::TEXT:
                    $this->EditText($key, $val["field"]["label"], $val["value"], $val["field"]["nullable"]);
                break;
                case DataType::KEYFK:
                case DataType::FK:
                    $this->EditForeignKey($key, $val["field"]["label"], $val["value"], $val["field"]["nullable"]);
                break;
                case DataType::STRING:
                default:
                    $this->EditString($key, $val["field"]["label"], $val["value"], $val["field"]["nullable"]);
                break;
            }
        }
        echo "<br><br>";
        echo "<button type=\"submit\">Salva</button>";
        echo "</form>";
        echo "<br><br><a href=\"?action=list&table=" . $data["entity"]->table . "\">Back</a>";
    }

    function RenderNew($data)
    {
        echo "<form method=\"POST\" action=\"?action=add&table=".$data["entity"]->table."\">";
    
        foreach ($data["columns"] as $key => $val)
        {
            if ($val["field"]["showInDetail"] == false)
                continue;
            switch ($val["field"]["type"])
            {
                case DataType::BOOL:
                    $this->NewBool($key, $val["field"]["label"], $val["field"]["nullable"]);
                break;
                case DataType::TEXT:
                    $this->NewText($key, $val["field"]["label"], $val["field"]["nullable"]);
                break;
                case DataType::DATETIME:
                    $this->NewDateTime($key, $val["field"]["label"], $val["field"]["nullable"]);
                break;
                case DataType::KEYFK:
                case DataType::FK:
                    $this->NewForeignKey($key, $val["field"]["label"], $val["fk"], $val["field"]["nullable"]);
                break;
                case DataType::STRING:
                default:
                    $this->NewString($key, $val["field"]["label"], $val["field"]["nullable"]);
                break;
            }
        }
        echo "<br><br>";
        echo "<button type=\"submit\">Inserisci</button>";
        echo "</form>";
        echo "<br><br><a href=\"?action=list&table=" . $data["entity"]->table . "\">Back</a>";
    }

    function OnDeleteEntity($data, $result)
    {
        echo "<a href=\"?action=list&table=" . $data->table . "\">Back</a>";
    }

    function OnAddEntity($data, $result)
    {
        echo "<a href=\"?action=list&table=" . $data->table . "\">Back</a>";
    }

    function OnUpdateEntity($data, $result)
    {
        echo "<a href=\"?action=list&table=" . $data->table . "\">Back</a>";
    }

    function OnEntityNotFound($data)
    {
        echo "'" . $data->table . "' Not Found<br>";
        echo "<a href=\"?action=list&table=" . $data->table . "\">Back</a>";
    }

    function OnActionNotFound($data)
    {
        echo "No '" . $data->action . "' Option<br>";
        echo "<a href=\"?\">Back</a>";
    }
}