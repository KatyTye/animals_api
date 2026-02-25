<?php

$country = $_GET["id"] ?? $search_able ?? 1;

if (!preg_match("/^\d+$/", $country) || (int)$country <=0) {
	echo json_encode((object)[
		"status" => 422,
		"success" => false,
		"message" => "The id param can only contain numbers, and they should all be above 0."
	]);
	http_response_code(422);
	exit;
}

$headers = getallheaders();

returnWhenVerified($dbh, $headers);

if (!isset($headers["field"]) || !isset($headers["value"])) {
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

$allowed = [
    "country_name"
];

$field = $headers["field"];

if (!in_array($field, $allowed, true)) {
    echo json_encode((object)[
		"status" => 404,
		"success" => false,
		"message" => "Could not find this field option."
	]);
	http_response_code(404);
	exit;
}

$sql = "UPDATE countries SET `$field` = :val WHERE id = :id";

$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $country, PDO::PARAM_INT);

if (!preg_match("/^\d+$/", $country)) {
    $stmt->bindValue(":val", (int)$headers["value"], PDO::PARAM_INT);
} else {
    $stmt->bindValue(":val", $headers["value"], PDO::PARAM_STR);
}

$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo json_encode((object)[
        "status" => 200,
        "success" => true,
        "message" => "The country field ".$headers["field"]." has been updated successfully."
    ]);
    http_response_code(200);
} else {
    echo json_encode((object)[
        "status" => 204,
        "success" => false,
        "message" => "Failed to update the field ".$headers["field"]." for the country."
    ]);
    http_response_code(204);
}

exit;