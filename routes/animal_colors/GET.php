<?php

$animal = $_GET["type"] ?? $search_able ?? 0;

if (!preg_match("/^\d+$/", $animal) || (int)$animal <=0) {
	echo json_encode((object)[
		"status" => 422,
		"success" => false,
		"message" => "The animal param can only contain numbers, and they should all be above 0."
	]);
	http_response_code(422);
	exit;
}

$headers = getallheaders();

$sql = "SELECT a.id, a.color_name, a.color_code FROM animal_colors a WHERE a.id = :id";
$result = returnBoundFromSQL($dbh, $sql, "id", $animal);

if (isset($result[0]["color_name"])) {
	echo json_encode((object)[
		"id" => $result[0]["id"],
		"status" => 200,
		"success" => true,
		"name" => $result[0]["color_name"],
		"code" => $result[0]["color_code"]
	]);
	http_response_code(200);
} else {
	echo json_encode((object)[
		"status" => 404,
		"success" => false,
		"message" => "No animal color found with that ID."
	]);
	http_response_code(404);
}

exit;