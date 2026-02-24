<?php
// RECIVE ROUTER, DATABASE and RETURNS
require_once("./db.php");
require_once("./utils/returns.php");
require_once("./utils/router.php");

// REGISTER RESOURCES
require_once("./utils/resources.php");

// GLOBAL VALUES
$http_method = $_SERVER["REQUEST_METHOD"];

// CREATE DEFAULT ROUTE
createRoute(file_Path: "routes/docs", type: "docs");

// CREATE ALL ROUTES
createRoute("animals", "routes/animals/index", extra: true);

// LOAD ROUTES
loadRoutes();