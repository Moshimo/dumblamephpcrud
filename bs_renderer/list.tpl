<!doctype html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="bs_renderer/css/bootstrap.min.css">
  <title>Lista</title>
</head>

<body>

    <div class="container-fluid">
        <div class="col-md-10 offset-md-1">
            <table class="table table-hover">
            <?php
            echo "<tr>";

            foreach ($this->data["entity"]->data as $fieldKey => $field) {
                if ($field["showInList"])
                {
                    echo "<th>" . $field["label"] . "</th>";
                }
            }

            echo "<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>";
            echo "</tr>";
            foreach($this->data["rows"] as $rowKey => $row)
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
                $queryString["table"] = $this->data["entity"]->table;
                $queryString["action"] = "view";
                echo "<td><a class=\"btn btn-outline-primary\" href=\"?" . http_build_query($queryString) . "\">Visualizza</a></td>";
                $queryString["action"] = "duplicate";
                echo "<td><a class=\"btn btn-outline-success\" href=\"?" . http_build_query($queryString) . "\">Duplica</a></td>";
                $queryString["action"] = "edit";
                echo "<td><a class=\"btn btn-outline-success\" href=\"?" . http_build_query($queryString) . "\">Modifica</a></td>";
                $queryString["action"] = "delete";
                echo "<td><a class=\"btn btn-outline-danger\" href=\"?" . http_build_query($queryString) . "\">Elimina</a></td>";
                echo "</tr>";
            }
            ?>
            </table>

            <?php
            echo "<a class=\"btn btn-outline-primary\" href=\"?action=new&table=".$this->data["entity"]->table."\">Nuovo</a>";
            echo "<br/><br/>";
            echo "<a class=\"btn btn-outline-secondary\" href=\"?\">Indietro</a>";
            ?>
        </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="bs_renderer/js/bootstrap.min.js"></script>
</body>

</html>