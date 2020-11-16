<?php

/*
TODO:
OTHER TYPES (TEXT=>TextArea , INT, DATE, ...)

IF TEMPLATE PAGE EXISTS, PASS OBJECT AND DELEGATE RENDERING ELSE RENDER BASIC AS IS

SEARCH
ORDER BY
*/

include_once "core/core.php";
include_once "core/db_presenter.php";

include_once "MyEntities.php";
// include_once "simple_renderer.php";
// $renderer = new SimpleRenderer();
include_once "bs_renderer.php";
$renderer = new BootstrapRenderer();

Enroute($items, $request, $renderer);