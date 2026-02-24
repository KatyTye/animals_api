<?php

$animal = $_GET["type"] ?? $search_able ?? 1;

if (!preg_match("/^\d+$/", $animal) || (int)$animal <=0) {
	echo json_encode((object)[
		"status" => 422,
		"success" => false,
		"message" => "The animal param can only contain numbers, and they should all be above 0."
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
    "color_name", "color_code"
];

$field = $headers["field"];

if (!in_array($field, $allowed, true)) {
    throw new Exception("Invalid field name");
}

$sql = "UPDATE animal_colors SET `$field` = :val WHERE id = :id";

$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $animal, PDO::PARAM_INT);

if (in_array($field, $allowed, true)) {
    $stmt->bindValue(":val", (int)$headers["value"], PDO::PARAM_INT);
} else {
    $stmt->bindValue(":val", $headers["value"], PDO::PARAM_STR);
}

$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo json_encode((object)[
        "status" => 200,
        "success" => true,
        "message" => "The animal color ".$headers["field"]." has been updated successfully."
    ]);
    http_response_code(200);
} else {
    echo json_encode((object)[
        "status" => 204,
        "success" => false,
        "message" => "Failed to update the field ".$headers["field"]." for the animal colors."
    ]);
    http_response_code(204);
}

exit;