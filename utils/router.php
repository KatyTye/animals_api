<?php
$full_url = $_GET["url"] ?? "";
$url = trim($full_url, "/");

$paths = [];
$resources = [];
$not_found_path = "./404.php";

function createRoute($path = "", $file_Path = "", $type = "json", $file_Type = "php", $extra = true) {
	global $paths;

	$paths[] = (object)[
		"path" => $path,
		"type" => $type,
		"search" => $extra,
		"file" => "./$file_Path.$file_Type"
	];
}

function createResource($path, $file_Path = "", $url_path = "", $file_Type = "svg") {
	global $resources;

	$resources[] = (object)[
		"name" => $path,
		"type" => $file_Type,
		"path" => "$file_Path.$file_Type",
		"url_path" => $url_path
	];
}

function loadRoutes() {
	global $not_found_path;
	global $resources;
	global $full_url;
	global $paths;
	global $url;
	global $dbh;

	foreach ($paths as $path) {
		if ($url == $path->path) {
			if ($path->type == "json") {
				header("Content-Type:application/json");
			}

			require_once($path->file);
			http_response_code(200);
			exit;
		} else if (strpos($url, $path->path) === 0
			&& $path->search == true && $full_url[-1] != "/" &&
			substr_count($url, "/") == substr_count("$path->path/", "/")) {
			if ($path->type == "json") {
				header("Content-Type:application/json");
			}

			$search_able = basename($url);
			require_once($path->file);
			
			http_response_code(200);
			exit;
		}
	}

	foreach ($resources as $source) {
		if ($url == "$source->url_path$source->name.$source->type") {
			$mime = mime_content_type($source->path);

			header("Content-Type: $mime");
			header("Content-Disposition: inline; filename=\"" . basename($source->path) . "\"");

			readfile("./$source->path");
			http_response_code(200);
			exit;
		}
	}

	header("Content-Type:application/json");
	require_once($not_found_path);
	http_response_code(404);
	exit;
}