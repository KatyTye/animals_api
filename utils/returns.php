<?php
function returnJSONfromSQL($dbh, $sql) {
	$query = $dbh->query($sql);
	$result = $query->fetchAll(PDO::FETCH_ASSOC);
	$json_array = json_encode($result);

	return $json_array;
}

function returnFromSQL($dbh, $sql) {
	$query = $dbh->query($sql);
	$result = $query->fetchAll(PDO::FETCH_ASSOC);

	return $result;
}

function returnBoundFromSQL($dbh, $sql, $name, $value, $PDO = PDO::PARAM_INT) {
	$stmt = $dbh->prepare($sql);

	$stmt->bindParam(":$name", $value, $PDO);

	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function returnCalcPage($dbh, $sql, $page, $limit) {
    $stmt = $dbh->prepare($sql);

    $min_id = ($page - 1) * $limit + 1;
    $max_id = $page * $limit;

    $stmt->bindParam(':pbottom', $min_id, PDO::PARAM_INT);
    $stmt->bindParam(':ptop', $max_id, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function returnWhenVerified($database, $pass) {
	$pass = $pass["Authorization"] ?? "";
	
	if ($pass == "") {
		echo json_encode((object)[
			"status" => 400,
			"success" => false,
			"message" => "The request does not have the required headers."
		]);
		http_response_code(400);
		exit;
	}
	
	$matches = "";
	$pass = preg_match("/(?:Bearer )(.*$)/", $pass, $matches);
	
	$verify_sql = "SELECT a.id,a.password FROM admins a";

	$verify_result = returnFromSQL($database, $verify_sql);
	$got_verifyed = false;

	foreach ($verify_result as $admin) {
		if (password_verify($matches[1], $admin["password"]) == true) {
			$got_verifyed = true;
		}
	}

	switch ($got_verifyed) {

		case (false):
			echo json_encode((object)[
				"status" => 401,
				"success" => false,
				"message" => "The request lacks valid authentication credentials."
			]);
			http_response_code(401);
			exit;

		case (true):
			return;
	}
}

function returnSortedAnimal($result) {
	return (object)[
		"id" => $result["id"],
		"status" => 200,
		"success" => true,
		"name" => $result["name"],
		"science_name" => $result["science_name"],
		"image" => $result["image"],
		"estimated_age" => (object)[
			"unit" => "years",
			"min" => $result["min_age"],
			"max" => $result["max_age"]
		],
		"details" => [
			"type" => $result["type_name"],
			"length" => [
				"unit" => $result["length_unit"],
				"short_unit" => $result["length_short_unit"],
				"min" => $result["length_min"],
				"max" => $result["length_max"]
			],
			"weight" => [
				"unit" => $result["weight_unit"],
				"short_unit" => $result["weight_short_unit"],
				"min" => $result["weight_min"],
				"max" => $result["weight_max"],
			]
		],
		"descriptions" => [
			"phases" => ["family","baby","leaving","independent"],
			"family" => [
				"title" => $result["phase_family_title"],
				"text" => $result["phase_family_text"]
			],
			"baby" => [
				"title" => $result["phase_baby_title"],
				"text" => $result["phase_baby_text"]
			],
			"leaving" => [
				"title" => $result["phase_leaving_title"],
				"text" => $result["phase_leaving_text"]
			],
			"independent" => [
				"title" => $result["phase_independent_title"],
				"text" => $result["phase_independent_text"]
			],
		],
		"close_family" => explode(", ", $result["families"]),
		"countries" => explode(", ", $result["countries"])
	];
}

function returnSortedList($result) {
	$returnValue = [];

	foreach ($result as $animal) {
		$returnValue[] = (object)[
			"id" => $animal["id"],
			"name" => $animal["name"],
			"science_name" => $animal["science_name"],
			"image" => $animal["image"],
			"estimated_age" => (object)[
				"unit" => "years",
				"min" => $animal["min_age"],
				"max" => $animal["max_age"]
			],
			"details" => [
				"type" => $animal["type_name"],
				"length" => [
					"unit" => $animal["length_unit"],
					"short_unit" => $animal["length_short_unit"],
					"min" => $animal["length_min"],
					"max" => $animal["length_max"]
				],
				"weight" => [
					"unit" => $animal["weight_unit"],
					"short_unit" => $animal["weight_short_unit"],
					"min" => $animal["weight_min"],
					"max" => $animal["weight_max"],
				]
			],
			"descriptions" => [
				"phases" => ["family","baby","leaving","independent"],
				"family" => [
					"title" => $animal["phase_family_title"],
					"text" => $animal["phase_family_text"]
				],
				"baby" => [
					"title" => $animal["phase_baby_title"],
					"text" => $animal["phase_baby_text"]
				],
				"leaving" => [
					"title" => $animal["phase_leaving_title"],
					"text" => $animal["phase_leaving_text"]
				],
				"independent" => [
					"title" => $animal["phase_independent_title"],
					"text" => $animal["phase_independent_text"]
				],
			],
			"close_family" => explode(", ", $animal["families"]),
			"countries" => explode(", ", $animal["countries"])
		];
	}

	return $returnValue;
}