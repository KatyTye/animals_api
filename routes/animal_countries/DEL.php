<?php

$id = $_GET["id"] ?? $search_able ?? 0;

if (!preg_match("/^\d+$/", $id) || (int)$id <=0) {
	echo json_encode((object)[
		"status" => 422,
		"success" => false,
		"message" => "The param can only contain numbers, and they should all be above 0."
	]);
	http_response_code(422);
	exit;
}

$headers = getallheaders();

returnWhenVerified($dbh, $headers);

if (!isset($headers["country_id"])) {
	echo json_encode((object)[
		"status" => 400,
		"success" => false,
		"message" => "The request does not have the required headers."
	]);
	http_response_code(400);
	exit;
}

$check = true;

foreach ($headers as $key => $value) {
	if (empty($value) && $key !== "Content-Length") {
		$check = false;
	}
}

if ($check == false) {
	echo json_encode((object)[
		"status" => 400,
		"success" => false,
		"message" => "The request headers require all to be filled."
	]);
	http_response_code(400);
	exit;
}

$sql = "DELETE FROM animal_countries WHERE animal_id = :id AND country_id = :second_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->bindParam(":second_id", $headers["country_id"], PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
	echo json_encode((object)[
		"status" => 202,
		"success" => true,
		"message" => "The animal country has now been deleted."
	]);
	http_response_code(202);
} else {
	echo json_encode((object)[
		"status" => 404,
		"success" => false,
		"message" => "No animal country found with those IDs."
	]);
	http_response_code(404);
}

exit;