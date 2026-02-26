<?php

$id = $_GET["unit"] ?? $search_able ?? 0;

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
	$sql = "SELECT a.id, a.key_name, a.encrypted_password FROM api_keys a";
	$result = returnFromSQL($dbh, $sql);

	echo json_encode((object)[
		"status" => 200,
		"success" => true,
		"results" => $result
	]);
	http_response_code(200);
	exit;

} else if (preg_match("/^\d+$/", $id) && (int)$id>=0) {
	$sql = "SELECT a.id, a.key_name, a.encrypted_password FROM api_keys a WHERE a.id = :id";
	$result = returnBoundFromSQL($dbh, $sql, "id", $id);

	if (isset($result[0]["key_name"])) {
		echo json_encode((object)[
			"status" => 200,
			"success" => true,
			"result" => (object)[
				"id" => $result[0]["id"],
				"key_name" => $result[0]["key_name"],
				"encrypted_password" => $result[0]["encrypted_password"]
			]
		]);
		http_response_code(200);
		exit;
	}
}

echo json_encode((object)[
	"status" => 404,
	"success" => false,
	"message" => "No api key found with that ID."
]);
http_response_code(404);
exit;