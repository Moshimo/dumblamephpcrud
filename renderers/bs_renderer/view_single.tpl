<!doctype html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="renderers/bs_renderer/css/bootstrap.min.css">
  <title><?= $this->data["entity"]->title ?></title>
</head>

<body>

  <div class="container-fluid">
      <div class="col-md-6 offset-md-3 card">
          <div class="card-body">
            <?php
                    foreach($this->data["columns"] as $colKey => $col)
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
                    $queryString["table"] = $this->data["entity"]->table;
                    $queryString["action"] = "new";
                    echo " <a class=\"btn btn-outline-primary\" href=\"?" . http_build_query($queryString) . "\">New</a> ";
                    $queryString["action"] = "duplicate";
                    echo " <a class=\"btn btn-outline-success\" href=\"?" . http_build_query($queryString) . "\">Duplicate</a> ";
                    $queryString["action"] = "edit";
                    echo " <a class=\"btn btn-outline-success\" href=\"?" . http_build_query($queryString) . "\">Edit</a> ";
                    $queryString["action"] = "delete";
                    echo " <a class=\"btn btn-outline-danger\" href=\"?" . http_build_query($queryString) . "\">Delete</a> ";

                    echo "<br><br><a class=\"btn btn-outline-secondary\" href=\"?action=list&table=" . $this->data["entity"]->table . "\">Back</a>";
            ?>
            </div>
        </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="renderers/bs_renderer/js/bootstrap.min.js"></script>
</body>

</html>