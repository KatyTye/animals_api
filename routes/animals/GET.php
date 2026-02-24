<?php

$page = $_GET["page"] ?? $search_able ?? 1;
$limit = $_GET["limit"] ?? "20";

if (!preg_match("/^\d+$/", $page) || (int)$page <=0) {
	echo json_encode((object)[
		"status" => 422,
		"success" => false,
		"message" => "The animal param can only contain numbers, and they should all be above 0."
	]);
	http_response_code(422);
	exit;
}

if (!preg_match("/^\d+$/", $limit) || (int)$limit <=0) {
	echo json_encode((object)[
		"status" => 422,
		"success" => false,
		"message" => "The limit param can only contain numbers, and they should all be above 0."
	]);
	http_response_code(422);
	exit;
}

switch ($url) {
	case (!str_contains($url, "/") || !preg_match("/^\d+$/", $page)):
		$sql = "SELECT a.id, a.name, a.science_name, a.image, t.type_name, a.min_age, a.max_age,
		a.public, lu.unit_short_name AS length_short_unit, wu.unit_short_name AS weight_short_unit,
		lu.unit_name AS length_unit, wu.unit_name AS weight_unit,
		a.length_min, a.length_max, a.weight_min, a.weight_max, a.phase_family_title,
		a.phase_family_text, a.phase_baby_title, a.phase_baby_text, a.phase_leaving_title, a.phase_leaving_text,
		a.phase_independent_title, a.phase_independent_text, col.color_name, col.color_code,

		GROUP_CONCAT(DISTINCT f.animal_name ORDER BY f.animal_name SEPARATOR ', ') AS families,
		GROUP_CONCAT(DISTINCT co.country_name ORDER BY co.country_name SEPARATOR ', ') AS countries

		FROM animals a

		LEFT JOIN animal_types t ON a.type = t.id
		LEFT JOIN animal_families af ON a.id = af.animal_id
		LEFT JOIN families f ON af.family_id = f.id
		LEFT JOIN animal_countries ac ON a.id = ac.animal_id
		LEFT JOIN countries co ON ac.country_id = co.id

		LEFT JOIN units lu ON lu.id = a.length_unit
		LEFT JOIN units wu ON wu.id = a.weight_unit
		LEFT JOIN animal_colors col ON col.id = a.color

		WHERE a.id BETWEEN :pbottom AND :ptop
		GROUP BY a.id
		ORDER BY a.id;";

		$result = returnCalcPage($dbh, $sql, (int)$page, (int)$limit) ?? 0;

		echo json_encode((object)[
			"status" => 200,
			"success" => true,
			"page" => (int)$page,
			"amount" => count($result),
			"results" => (array)returnSortedList($result)
		]);
		exit;
	case (preg_match("/^\d+$/", $page) && (int)$page>=0):
		$sql = "SELECT a.id, a.name, a.science_name, a.image, t.type_name, a.min_age, a.max_age,
		a.public, lu.unit_short_name AS length_short_unit, wu.unit_short_name AS weight_short_unit,
		lu.unit_name AS length_unit, wu.unit_name AS weight_unit,
		a.length_min, a.length_max, a.weight_min, a.weight_max, a.phase_family_title,
		a.phase_family_text, a.phase_baby_title, a.phase_baby_text, a.phase_leaving_title, a.phase_leaving_text,
		a.phase_independent_title, a.phase_independent_text, col.color_name, col.color_code,

		GROUP_CONCAT(DISTINCT f.animal_name ORDER BY f.animal_name SEPARATOR ', ') AS families,
		GROUP_CONCAT(DISTINCT co.country_name ORDER BY co.country_name SEPARATOR ', ') AS countries

		FROM animals a

		LEFT JOIN animal_types t ON a.type = t.id
		LEFT JOIN animal_families af ON a.id = af.animal_id
		LEFT JOIN families f ON af.family_id = f.id
		LEFT JOIN animal_countries ac ON a.id = ac.animal_id
		LEFT JOIN countries co ON ac.country_id = co.id

		LEFT JOIN units lu ON lu.id = a.length_unit
		LEFT JOIN units wu ON wu.id = a.weight_unit
		LEFT JOIN animal_colors col ON col.id = a.color 
		WHERE a.id = :id";

		$result = returnBoundFromSQL($dbh, $sql, "id", $page);

		if (returnSortedAnimal($result[0])->id == null) {
			echo json_encode((object)[
				"status" => 404,
				"success" => false,
				"message" => "There are no animals with this id."
			]);
			http_response_code(404);
		} else {
			echo json_encode(returnSortedAnimal($result[0]));
		}
		exit;
}