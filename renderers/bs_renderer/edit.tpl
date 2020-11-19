<!doctype html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="bs_renderer/css/bootstrap.min.css">
  <title>Indice</title>
</head>

<body>

  <div class="container-fluid">
      <div class="col-md-6 offset-md-3">
          <div class="card">
              <div class="card-body">
              <?php
                    if ($this->action == "edit")
                    {
                        echo "<form method=\"POST\" action=\"?action=" . ($this->duplicate ? "add" : "update") . "&table=".$this->data["entity"]->table."\">";

                        foreach ($this->request as $key => $value) {
                            if ($key != "table" && $key != "action")
                            {
                                if (!$this->duplicate)
                                    echo "<input type=\"hidden\" name=\"$key\" value=\"$value\">";
                            }
                        }
                        foreach ($this->data["columns"] as $key => $val) {
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
                                    $this->EditForeignKey($key, $val["field"]["label"], $val["value"], false, $val["field"]["nullable"]);
                                break;
                                case DataType::STRING:
                                default:
                                    $this->EditString($key, $val["field"]["label"], $val["value"], $val["field"]["nullable"]);
                                break;
                            }
                        }
                        echo "<button class=\"btn btn-outline-primary\" type=\"submit\">Salva</button>";
                        echo "</form>";
                        echo "<br><br>";
                        echo "<a class=\"btn btn-outline-secondary\" href=\"?action=list&table=" . $this->data["entity"]->table . "\">Back</a>";
                    }
                    else
                    {
                        echo "<form method=\"POST\" action=\"?action=add&table=".$this->data["entity"]->table."\">";
                    
                        foreach ($this->data["columns"] as $key => $val)
                        {
                            if ($val["field"]["showInDetail"] == false)
                                continue;
                            switch ($val["field"]["type"])
                            {
                                case DataType::BOOL:
                                    $this->EditBool($key, $val["field"]["label"], NULL, $val["field"]["nullable"]);
                                break;
                                case DataType::TEXT:
                                    $this->EditText($key, $val["field"]["label"], NULL, $val["field"]["nullable"]);
                                break;
                                case DataType::DATETIME:
                                    $this->EditDateTime($key, $val["field"]["label"], NULL, $val["field"]["nullable"]);
                                break;
                                case DataType::KEYFK:
                                case DataType::FK:
                                    $this->EditForeignKey($key, $val["field"]["label"], $val["fk"], true, $val["field"]["nullable"]);
                                break;
                                case DataType::STRING:
                                default:
                                    $this->EditString($key, $val["field"]["label"], NULL, $val["field"]["nullable"]);
                                break;
                            }
                        }
                        echo "<button class=\"btn btn-outline-primary\" type=\"submit\">Inserisci</button>";
                        echo "</form>";
                        echo "<br><br>";
                        echo "<a class=\"btn btn-outline-secondary\" href=\"?action=list&table=" . $this->data["entity"]->table . "\">Back</a>";
                    }
                ?>
              </div>
          </div>
        </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="bs_renderer/js/bootstrap.min.js"></script>
</body>

</html>