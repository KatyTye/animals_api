<?php

$country = $_GET["id"] ?? $search_able ?? 0;

if (!preg_match("/^\d+$/", $country) || (int)$country <=-1) {
	echo json_encode((object)[
		"status" => 422,
		"success" => false,
		"message" => "The id param can only contain numbers, and they should all be above 0."
	]);
	http_response_code(422);
	exit;
}

$headers = getallheaders();

if (str_contains($full_url[-1], "/")) {
	$sql = "SELECT a.id, a.country_name FROM countries a";
	$result = returnFromSQL($dbh, $sql);

	echo json_encode((object)[
		"status" => 200,
		"success" => true,
		"results" => $result
	]);
	http_response_code(200);
	exit;

} else if (preg_match("/^\d+$/", $country) && (int)$country>=0) {
	$sql = "SELECT a.id, a.country_name FROM countries a WHERE a.id = :id";
	$result = returnBoundFromSQL($dbh, $sql, "id", $country);

	if (isset($result[0]["country_name"])) {
		echo json_encode((object)[
			"status" => 200,
			"success" => true,
			"result" => (object)[
				"id" => $result[0]["id"],
				"country_name" => $result[0]["country_name"]
			]
		]);
		http_response_code(200);
		exit;
	}
}

echo json_encode((object)[
	"status" => 404,
	"success" => false,
	"message" => "No country found with that ID."
]);
http_response_code(404);
exit;