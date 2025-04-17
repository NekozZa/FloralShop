<?php 
    define('ACCESS_TOKEN', 'pk.eyJ1IjoibmVrb3phIiwiYSI6ImNtOWxiYXQ5NDAwYnAya3B0cWc3eDVsdWEifQ.Sj1IBVdiV8prKvSENInqLA');

    function getAddressCoordinates($address) {
        $address_format = urlencode($address);
        $url = "https://api.mapbox.com/search/geocode/v6/forward?access_token=". ACCESS_TOKEN . "&q=" . $address_format;
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        $coordinates = $data['features'][0]['geometry']['coordinates'];
        return join(',', $coordinates);
    }
?>