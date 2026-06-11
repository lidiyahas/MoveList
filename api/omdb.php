<?php
function searchMovie($title){
    $apiKey = "97abd1e8";
    $url = "http://www.omdbapi.com/?apikey=$apiKey&s=" . urlencode($title);

    $context = stream_context_create([
        'http' => [
            'timeout' => 5 // ⬅️ penting banget
        ]
    ]);

    $response = @file_get_contents($url, false, $context);

    if($response === FALSE){
        return [
            "Response" => "False",
            "Error" => "Gagal koneksi ke OMDb API"
        ];
    }

    return json_decode($response, true);
}

function getMovieDetail($imdbID){
    $apiKey = "97abd1e8";
    $url = "http://www.omdbapi.com/?apikey=$apiKey&i=$imdbID";

    $response = file_get_contents($url);
    return json_decode($response, true);
}


function getTrailerVideoId($title){

    $apiKey = "AIzaSyCK2O03juEBMxvpd11-Ep8gy-5j9164sYs";

    $query = urlencode($title . " official trailer");

    $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=$query&type=video&maxResults=1&key=$apiKey";

    $context = stream_context_create([
        'http' => [
            'timeout' => 5
        ]
    ]);

    $response = @file_get_contents($url, false, $context);

    if($response === FALSE){
        return null;
    }

    $data = json_decode($response, true);

    return $data['items'][0]['id']['videoId'] ?? null;
}

?>
