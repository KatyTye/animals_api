<?php

$headers = getallheaders();

returnWhenVerified($dbh, $headers);

if (!isset($headers["name"]) || !isset($headers["short_name"])) {
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

$sql = "INSERT INTO units (unit_name, unit_short_name) VALUES (:unit_name, :unit_short_name)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":unit_name", $headers["name"], PDO::PARAM_STR);
$stmt->bindParam(":unit_short_name", $headers["short_name"], PDO::PARAM_STR);
$stmt->execute();

if ($stmt->rowCount() > 0) {
	echo json_encode((object)[
		"status" => 201,
		"success" => true,
		"message" => "The unit has been created successfully."
	]);
	http_response_code(201);
} else {
	echo json_encode((object)[
		"status" => 404,
		"success" => false,
		"message" => "Failed to create the unit."
	]);
	http_response_code(404);
}

exit;