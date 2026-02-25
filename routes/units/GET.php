<?php

$animal = $_GET["unit"] ?? $search_able ?? 0;

if (!preg_match("/^\d+$/", $animal) || (int)$animal <=0) {
	echo json_encode((object)[
		"status" => 422,
		"success" => false,
		"message" => "The param can only contain numbers, and they should all be above 0."
	]);
	http_response_code(422);
	exit;
}

$headers = getallheaders();

$sql = "SELECT a.id, a.unit_name, a.unit_short_name FROM units a WHERE a.id = :id";
$result = returnBoundFromSQL($dbh, $sql, "id", $animal);

if (isset($result[0]["unit_name"])) {
	echo json_encode((object)[
		"status" => 200,
		"success" => true,
		"result" => (object)[
			"id" => $result[0]["id"],
			"long_name" => $result[0]["unit_name"],
			"short_name" => $result[0]["unit_short_name"]
		]
	]);
	http_response_code(200);
} else {
	echo json_encode((object)[
		"status" => 404,
		"success" => false,
		"message" => "No unit found with that ID."
	]);
	http_response_code(404);
}

exit;