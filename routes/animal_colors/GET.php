<?php
$type = $_GET["type"] ?? $search_able ?? 0;

if (!preg_match("/^\d+$/", $type) || (int)$type <=-1) {
	echo json_encode((object)[
		"status" => 422,
		"success" => false,
		"message" => "The animal param can only contain numbers, and they should all be above 0."
	]);
	http_response_code(422);
	exit;
}

$headers = getallheaders();

if (str_contains($full_url[-1], "/")) {
	$sql = "SELECT a.id, a.color_name, a.color_code FROM animal_colors a";
	$result = returnFromSQL($dbh, $sql);

	echo json_encode((object)[
		"status" => 200,
		"success" => true,
		"results" => $result
	]);
	http_response_code(200);
	exit;

} else if (preg_match("/^\d+$/", $type) && (int)$type>=0) {
	$sql = "SELECT a.id, a.color_name, a.color_code FROM animal_colors a WHERE a.id = :id";
	$result = returnBoundFromSQL($dbh, $sql, "id", $type);

	if (isset($result[0]["color_name"])) {echo json_encode((object)[
		"status" => 200,
		"success" => true,
		"result" => (object)[
			"id" => $result[0]["id"],
			"color_name" => $result[0]["color_name"],
			"color_code" => $result[0]["color_code"]
		]
	]);
	http_response_code(200);
	exit;}
}

echo json_encode((object)[
	"status" => 404,
	"success" => false,
	"message" => "No animal color found with that ID."
]);
http_response_code(404);
exit;