<?php

/*
TODO:
SEARCH
ORDER BY
*/

include_once "core/core.php";
include_once "core/db_presenter.php";

include_once "MyEntities.php";
// include_once "renderers/simple_renderer.php";
// $renderer = new SimpleRenderer();
include_once "renderers/bs_renderer/bs_renderer.php";
$renderer = new BootstrapRenderer();

Enroute($items, $request, $renderer);