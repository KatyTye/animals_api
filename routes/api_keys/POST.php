<?php

$headers = getallheaders();

if (!isset($headers["key_name"]) || !isset($headers["decrypted_password"])
|| !isset($headers["required_auth"])) {
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

$hashed_password = password_hash($headers["decrypted_password"], PASSWORD_ARGON2ID);

$sql = "INSERT INTO api_keys (key_name, encrypted_password, required_auth)
VALUES (:key_name, :encrypted_password, :required_auth)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":key_name", $headers["key_name"], PDO::PARAM_STR);
$stmt->bindParam(":encrypted_password", $hashed_password, PDO::PARAM_STR);
$stmt->bindParam(":required_auth", $headers["required_auth"], PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
	echo json_encode((object)[
		"status" => 201,
		"success" => true,
		"message" => "The api key has been created successfully."
	]);
	http_response_code(201);
} else {
	echo json_encode((object)[
		"status" => 404,
		"success" => false,
		"message" => "Failed to create the api key."
	]);
	http_response_code(404);
}

exit;