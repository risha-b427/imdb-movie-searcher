<?php

header("Content-Type: application/json");

$apiKey = "7f6b2274";

$type = $_GET["type"] ?? "";
$movie = $_GET["movie"] ?? "";
$id = $_GET["id"] ?? "";

if ($type == "search") {
    if ($movie == "") {
        echo json_encode([
            "Response" => "False",
            "Error" => "No movie title entered"
        ]);
        exit;
    }

    $url = "http://www.omdbapi.com/?apikey=" . $apiKey . "&s=" . urlencode($movie);
    echo file_get_contents($url);
    exit;
}

if ($type == "details") {
    if ($id == "") {
        echo json_encode([
            "Response" => "False",
            "Error" => "No IMDb ID provided"
        ]);
        exit;
    }

    $url = "http://www.omdbapi.com/?apikey=" . $apiKey . "&i=" . urlencode($id);
    echo file_get_contents($url);
    exit;
}

echo json_encode([
    "Response" => "False",
    "Error" => "Invalid request"
]);

?>