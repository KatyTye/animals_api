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

$sql = "DELETE FROM api_keys WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
	echo json_encode((object)[
		"status" => 202,
		"success" => true,
		"message" => "The unit has now been deleted."
	]);
	http_response_code(202);
} else {
	echo json_encode((object)[
		"status" => 404,
		"success" => false,
		"message" => "No unit found with that ID."
	]);
	http_response_code(404);
}

exit;