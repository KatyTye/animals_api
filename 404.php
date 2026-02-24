<?php

echo json_encode((object)[
	"status" => 404,
	"success" => false,
	"message" => "Could not find the requested resource."
]);