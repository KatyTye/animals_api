<?php

$unit = $_GET["unit"] ?? $search_able ?? 0;

if (!preg_match("/^\d+$/", $unit) || (int)$unit <=-1) {
	echo json_encode((object)[
		"status" => 422,
		"success" => false,
		"message" => "The param can only contain numbers, and they should all be above 0."
	]);
	http_response_code(422);
	exit;
}

$headers = getallheaders();

if (str_contains($full_url[-1], "/")) {
	$sql = "SELECT a.id, a.unit_name, a.unit_short_name FROM units a";
	$result = returnFromSQL($dbh, $sql);

	echo json_encode((object)[
		"status" => 200,
		"success" => true,
		"results" => $result
	]);
	http_response_code(200);
	exit;

} else if (preg_match("/^\d+$/", $unit) && (int)$unit>=0) {
	$sql = "SELECT a.id, a.unit_name, a.unit_short_name FROM units a WHERE a.id = :id";
	$result = returnBoundFromSQL($dbh, $sql, "id", $unit);

	if (isset($result[0]["unit_name"])) {
		echo json_encode((object)[
			"status" => 200,
			"success" => true,
			"result" => (object)[
				"id" => $result[0]["id"],
				"unit_name" => $result[0]["unit_name"],
				"unit_short_name" => $result[0]["unit_short_name"]
			]
		]);
		http_response_code(200);
		exit;
	}
}

echo json_encode((object)[
	"status" => 404,
	"success" => false,
	"message" => "No unit found with that ID."
]);
http_response_code(404);
exit;