<?php

$headers = getallheaders();

returnWhenVerified($dbh, $headers);

if (!isset($headers["public"]) || !isset($headers["name"]) || !isset($headers["science_name"]) ||
	!isset($headers["min_age"]) || !isset($headers["max_age"]) || !isset($headers["image"]) ||
	!isset($headers["type"]) || !isset($headers["length_unit"]) || !isset($headers["weight_unit"]) ||
	!isset($headers["length_min"]) || !isset($headers["length_max"]) || !isset($headers["weight_min"]) ||
	!isset($headers["weight_max"]) || !isset($headers["phase_family_title"]) || !isset($headers["phase_family_text"]) ||
	!isset($headers["color"]) || !isset($headers["phase_leaving_text"]) || !isset($headers["phase_baby_title"]) ||
	!isset($headers["phase_independent_title"]) || !isset($headers["phase_baby_text"]) ||
	!isset($headers["phase_independent_text"]) || !isset($headers["phase_leaving_title"])
) {
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

$sql = "INSERT INTO animals (
	created, public, name, science_name, min_age, max_age, image, type,
	length_unit, weight_unit, length_min, length_max, weight_min, weight_max,
	phase_family_title, phase_family_text, phase_baby_title, phase_baby_text,
	phase_leaving_title, phase_leaving_text,
	phase_independent_title, phase_independent_text, color
) VALUES (
	NOW(), :public, :name, :science_name, :min_age, :max_age, :image, :type,
	:length_unit, :weight_unit, :length_min, :length_max, :weight_min, :weight_max,
	:phase_family_title, :phase_family_text, :phase_baby_title, :phase_baby_text,
	:phase_leaving_title, :phase_leaving_text,
	:phase_independent_title, :phase_independent_text, :color
)";

$stmt = $dbh->prepare($sql);
$stmt->bindParam(":public", $headers["public"], PDO::PARAM_INT);
$stmt->bindParam(":name", $headers["name"], PDO::PARAM_STR);
$stmt->bindParam(":science_name", $headers["science_name"], PDO::PARAM_STR);
$stmt->bindParam(":min_age", $headers["min_age"], PDO::PARAM_INT);
$stmt->bindParam(":max_age", $headers["max_age"], PDO::PARAM_INT);
$stmt->bindParam(":image", $headers["image"], PDO::PARAM_STR);
$stmt->bindParam(":type", $headers["type"], PDO::PARAM_INT);
$stmt->bindParam(":length_unit", $headers["length_unit"], PDO::PARAM_INT);
$stmt->bindParam(":weight_unit", $headers["weight_unit"], PDO::PARAM_INT);
$stmt->bindParam(":length_min", $headers["length_min"], PDO::PARAM_STR);
$stmt->bindParam(":length_max", $headers["length_max"], PDO::PARAM_STR);
$stmt->bindParam(":weight_min", $headers["weight_min"], PDO::PARAM_STR);
$stmt->bindParam(":weight_max", $headers["weight_max"], PDO::PARAM_STR);
$stmt->bindParam(":phase_family_title", $headers["phase_family_title"], PDO::PARAM_STR);
$stmt->bindParam(":phase_family_text", $headers["phase_family_text"], PDO::PARAM_STR);
$stmt->bindParam(":phase_baby_title", $headers["phase_baby_title"], PDO::PARAM_STR);
$stmt->bindParam(":phase_baby_text", $headers["phase_baby_text"], PDO::PARAM_STR);
$stmt->bindParam(":phase_leaving_title", $headers["phase_leaving_title"], PDO::PARAM_STR);
$stmt->bindParam(":phase_leaving_text", $headers["phase_leaving_text"], PDO::PARAM_STR);
$stmt->bindParam(":phase_independent_title", $headers["phase_independent_title"], PDO::PARAM_STR);
$stmt->bindParam(":phase_independent_text", $headers["phase_independent_text"], PDO::PARAM_STR);
$stmt->bindParam(":color", $headers["color"], PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo json_encode((object)[
        "status" => 201,
        "success" => true,
        "message" => "The animal has been created successfully."
    ]);
    http_response_code(201);
} else {
    echo json_encode((object)[
        "status" => 500,
        "success" => false,
        "message" => "Failed to create the animal."
    ]);
    http_response_code(500);
}

exit;