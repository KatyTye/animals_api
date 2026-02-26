<?php

$headers = getallheaders();

returnWhenVerified($dbh, $headers);

if (!isset($headers["animal_id"]) || !isset($headers["family_id"])) {
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

$sql = "INSERT INTO animal_families (animal_id, family_id) VALUES (:animal_id, :family_id)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":animal_id", $headers["animal_id"], PDO::PARAM_INT);
$stmt->bindParam(":family_id", $headers["family_id"], PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
	echo json_encode((object)[
		"status" => 201,
		"success" => true,
		"message" => "The animal family has been created successfully."
	]);
	http_response_code(201);
} else {
	echo json_encode((object)[
		"status" => 404,
		"success" => false,
		"message" => "Failed to create the animal family."
	]);
	http_response_code(404);
}

exit;