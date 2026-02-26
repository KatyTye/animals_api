<?php

$headers = getallheaders();

returnWhenVerified($dbh, $headers);

if (!isset($headers["animal_name"])) {
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

$sql = "INSERT INTO families (animal_name) VALUES (:animal_name)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":animal_name", $headers["animal_name"], PDO::PARAM_STR);
$stmt->execute();

if ($stmt->rowCount() > 0) {
	echo json_encode((object)[
		"status" => 201,
		"success" => true,
		"message" => "The family has been created successfully."
	]);
	http_response_code(201);
} else {
	echo json_encode((object)[
		"status" => 404,
		"success" => false,
		"message" => "Failed to create the family."
	]);
	http_response_code(404);
}

exit;