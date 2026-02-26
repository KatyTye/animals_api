<?php

$id = $_GET["id"] ?? $search_able ?? 0;

if (!preg_match("/^\d+$/", $id) || (int)$id <=-1) {
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
	$sql = "SELECT a.animal_id, a.family_id FROM animal_families a";
	$result = returnFromSQL($dbh, $sql);

	echo json_encode((object)[
		"status" => 200,
		"success" => true,
		"results" => returnMultiList($result, "family_id", "animal_id")
	]);
	http_response_code(200);
	exit;

} else if (preg_match("/^\d+$/", $id) && (int)$id>=0) {
	$sql = "SELECT a.animal_id, a.family_id FROM animal_families a WHERE a.animal_id = :id";
	$result = returnBoundFromSQL($dbh, $sql, "id", $id);

	if (isset($result[0]["animal_id"])) {
		echo json_encode((object)[
			"status" => 200,
			"success" => true,
			"result" => returnSingleList($result, "family_id")
		]);
		http_response_code(200);
		exit;
	}
}

echo json_encode((object)[
	"status" => 404,
	"success" => false,
	"message" => "No animal family found with that ID."
]);
http_response_code(404);
exit;