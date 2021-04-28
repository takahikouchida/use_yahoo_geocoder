<?php
$google_maps_api_key = "";
$google_endpoint = "https://maps.googleapis.com/maps/api/geocode/json?";

while ($line = fgets(STDIN)) {
    $address = str_replace(array("\r\n", "\r", "\n"), '', $line);
    $params = http_build_query(array(
        "language" => "ja",
        "address" => $address,
        "key" => $google_maps_api_key
    ));

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $google_endpoint.$params);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $google_result =  curl_exec($curl);

    if ($google_result) {
        $json = json_decode($google_result);
        if ($json->status == "OK") {
            echo $address . "," . $json->results[0]->geometry->location->lng . "," . $json->results[0]->geometry->location->lat . "\n";
        }
    }
}


?>