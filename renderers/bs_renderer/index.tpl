<!doctype html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="renderers/bs_renderer/css/bootstrap.min.css">
  <title>Indice</title>
</head>

<body>

  <div class="container-fluid">
    <div class="col-md-10 offset-md-1">
      <div class="list-group">
        <?php if(count($this->items) < 1): ?>
          No entities
        <?php else: ?>
          <?php foreach ($this->items as $item): ?>
            <a class="list-group-item list-group-item-action" href="?action=list&table=<?=  $item->table ?>"><?= $item->title ?></a>
          <?php endforeach ?>
        <?php endif; ?>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="renderers/bs_renderer/js/bootstrap.min.js"></script>
</body>

</html>