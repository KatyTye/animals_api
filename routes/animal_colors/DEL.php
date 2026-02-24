<?php

$animal = $_GET["type"] ?? $search_able ?? 0;

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

$sql = "DELETE FROM animal_colors WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $animal, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
	echo json_encode((object)[
		"status" => 202,
		"success" => true,
		"message" => "The animal color has now been deleted."
	]);
	http_response_code(202);
} else {
	echo json_encode((object)[
		"status" => 404,
		"success" => false,
		"message" => "No animal color found with that ID."
	]);
	http_response_code(404);
}

exit;