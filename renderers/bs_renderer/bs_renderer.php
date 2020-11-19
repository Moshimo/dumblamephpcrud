<?php
include_once "core/core.php";

class BootstrapRenderer extends Renderer
{
    function GenerateIndex($items)
    {
        $this->items = $items;
        include "renderers/bs_renderer/index.tpl";
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
        if (isset($value) && strtotime($value) != -62169984000)
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
        ?>
            <div class="form-group">
                <?php 
                    if ($canBeNull)
                        echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\"". (isset($value) ? " checked=\"checked\"/" : "") .">";
                ?>
                <label for="<?= $key ?>"><?= $label ?></label>
                <input type="text" class="form-control" id="<?= $key ?>" name="<?= $key ?>"<?= isset($value) ? " value=\"$value\"" : "" ?> placeholder="<?= $label ?>" />
            </div>
        <?php
    }

    function EditBool($key, $label, $value, $canBeNull)
    {
        ?>
            <div class="form-group form-check">
                <?php 
                    if ($canBeNull)
                        echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\"". (isset($value) ? " checked=\"checked\"/" : "") .">";
                ?>
                <input type="checkbox" class="form-check-input" id="<?= $key ?>" name="<?= $key ?>"<?= isset($value) && $value == 1 ? " checked=\"checked\"" : "" ?> />
                <label class="form-check-label" for="<?= $key ?>"><?= $label ?></label>
            </div>
        <?php
    }

    function EditForeignKey($key, $label, $value, $isNew, $canBeNull)
    {
        if ($isNew)
        {
            ?>
                <div class="form-group">
                    <?php
                        if ($canBeNull)
                            echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" checked=\"checked\"/>";
                    ?>
                    <label for="<?= $key ?>"><?= $label ?></label>
                    <select class="form-control" name="<?= $key ?>" id="<?= $key ?>">
                        <?php
                            foreach ($value as $val)
                                echo "<option value=\"".$val["id"]."\">" . $val["label"] . "</option>";
                        ?>
                    </select>
                </div>
            <?php
        }
        else
        {
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
                ?>
                    <div class="form-group">
                        <?php
                            if ($canBeNull)
                                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" checked=\"checked\"/>";
                        ?>
                        <label for="<?= $key ?>"><?= $label ?></label>
                        <select class="form-control" name="<?= $key ?>" id="<?= $key ?>">
                            <?php
                                foreach ($value as $val)
                                    echo "<option value=\"".$val["id"]."\" " . ($val["selected"] == true ? " selected=\"selected\"" : "" ) . ">" . $val["label"] . "</option>";
                            ?>
                        </select>
                    </div>
                <?php
            }
            else
            {   
                ?>
                    <div class="form-group">
                        <?php
                            if ($canBeNull)
                                echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\" />";
                        ?>
                        <label for="<?= $key ?>"><?= $label ?></label>
                        <select class="form-control" name="<?= $key ?>" id="<?= $key ?>">
                            <?php
                                foreach ($value as $val)
                                    echo "<option value=\"".$val["id"]."\">" . $val["label"] . "</option>";
                            ?>
                        </select>
                    </div>
                <?php
            }
        }
    }

    function EditText($key, $label, $value, $canBeNull)
    {
        ?>
            <div class="form-group">
                <?php 
                    if ($canBeNull)
                        echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\"". (isset($value) ? " checked=\"checked\"/" : "") .">";
                ?>
                <label for="<?= $key ?>"><?= $label ?></label>
                <textarea class="form-control" rows="4" cols="50" name="<?= $key ?>" id="<?= $key ?>" placeholder="<?= $label ?>"><?= isset($value) ? $value : "" ?></textarea>
            </div>
        <?php
    }

    function EditDateTime($key, $label, $value, $canBeNull)
    {
        ?>
            <div class="form-group">
                <?php 
                    if ($canBeNull)
                        echo "<input type=\"checkbox\" name=\"".$key."_notnull\" id=\"".$key."_notnull\"". (isset($value) ? " checked=\"checked\"/" : "") .">";
                ?>
                <label for="<?= $key ?>"><?= $label ?></label>
                <input type="datetime-local" class="form-control" id="<?= $key ?>" name="<?= $key ?>"<?= isset($value) ? " value=\"" . date_format(date_create($value), 'Y-m-d\TH:i') . "\"" : "" ?> placeholder="<?= $label ?>" />
            </div>
        <?php
    }
    /***************************** */

    function RenderList($data)
    {
        $this->data = $data;
        include "renderers/bs_renderer/list.tpl";
    }

    function RenderViewSingle($data)
    {
        $this->data = $data;
        include "renderers/bs_renderer/view_single.tpl";
    }

    function RenderEditSingle($data, $request, $duplicate)
    {
        $this->data = $data;
        $this->request = $request;
        $this->duplicate = $duplicate;
        $this->action = "edit";

        include "renderers/bs_renderer/edit.tpl";
    }

    function RenderNew($data)
    {
        $this->data = $data;
        $this->action = "new";

        include "renderers/bs_renderer/edit.tpl";
    }

    function OnDeleteEntity($data, $result)
    {
        header("location: ?action=list&table=" . $data->table);
    }

    function OnAddEntity($data, $result)
    {
        header("location: ?action=list&table=" . $data->table);
    }

    function OnUpdateEntity($data, $result)
    {
        header("location: ?action=list&table=" . $data->table);
    }

    function OnEntityNotFound($data)
    {
        echo "'" . $data->table . "' Not Found<br>";
        echo "<a class=\"btn btn-outline-secondary\" href=\"?action=list&table=" . $data->table . "\">Back</a>";
    }

    function OnActionNotFound($data)
    {
        echo "No '" . $data->action . "' Option<br>";
        echo "<a class=\"btn btn-outline-secondary\" href=\"?\">Back</a>";
    }
}