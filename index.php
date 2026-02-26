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
createRoute(file_Path: "routes/docs", type: "docs", extra: false);

// CREATE ALL ROUTES
createRoute("units", "routes/units/index");
createRoute("animals", "routes/animals/index");
createRoute("families", "routes/families/index");
createRoute("types", "routes/animal_types/index");
createRoute("countries", "routes/countries/index");
createRoute("colors", "routes/animal_colors/index");
createRoute("animals/family", "routes/animal_families/index");

// ADMIN ROUTES
createRoute("api-keys", "routes/api_keys/index");

// LOAD ROUTES
loadRoutes();