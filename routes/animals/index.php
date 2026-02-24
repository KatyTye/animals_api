<?php
global $http_method;

if ($http_method === "GET") {
	require_once(__DIR__."/GET.php");
} else if ($http_method === "DELETE") {
	require_once(__DIR__."/DEL.php");
} else {
	echo json_encode((object)[
		"status" => 405,
		"success" => false,
		"message" => "The requested url does not accept $http_method method."
	]);
	http_response_code(405);
	exit;
}