<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

//------------------------------------------------------------------------------------------------
//cari dari NC
//cari data angin
//satu parameter
$app->get("/cari-nc/angin/", function (Request $request, Response $response, $args){
    $cari_lat = $request->getQueryParam("lat");
    $cari_lon = $request->getQueryParam("lon");
    $cari_tgl = $request->getQueryParam("tgl");

    // Data yang akan dipindah ke python
    $data = array($cari_lat,$cari_lon,$cari_tgl);

    // Execute the python script with the JSON data
    $result = shell_exec('python "/var/www/html/semar-api/src/API/angin.py" ' . base64_encode(json_encode($data)));

    // Decode the result
    $resultData = json_decode($result, true);

    return $response->withJson(["status" => "success", "data_angin" => $resultData], 200);
});

//cari data arus
$app->get("/cari-nc/arus/", function (Request $request, Response $response, $args){
    $cari_lat = $request->getQueryParam("lat");
    $cari_lon = $request->getQueryParam("lon");
    $cari_tgl = $request->getQueryParam("tgl");

    // Data yang akan dipindah ke python
    $data = array($cari_lat,$cari_lon,$cari_tgl);

    // Execute the python script with the JSON data
    $result = shell_exec('python "/var/www/html/semar-api/src/API/arus.py" ' . base64_encode(json_encode($data)));

    // Decode the result
    $resultData = json_decode($result, true);

    return $response->withJson(["status" => "success", "data_arus" => $resultData], 200);
});

//cari data suhu udara laut
$app->get("/cari-nc/suhu-udara-laut/", function (Request $request, Response $response, $args){
    $cari_lat = $request->getQueryParam("lat");
    $cari_lon = $request->getQueryParam("lon");
    $cari_tgl = $request->getQueryParam("tgl");

    // Data yang akan dipindah ke python
    $data = array($cari_lat,$cari_lon,$cari_tgl);

    // Execute the python script with the JSON data
    $result = shell_exec('python "/var/www/html/semar-api/src/API/suhu_udara_laut.py" ' . base64_encode(json_encode($data)));

    // Decode the result
    $resultData = json_decode($result, true);

    return $response->withJson(["status" => "success", "data_suhu_udara_laut" => $resultData], 200);
});



//------------------------------------------------------------------------------------------------
//cari dari NC
//dua parameter
$app->get("/cari-nc/angin/arus/", function (Request $request, Response $response, $args){
    $cari_lat = $request->getQueryParam("lat");
    $cari_lon = $request->getQueryParam("lon");
    $cari_tgl = $request->getQueryParam("tgl");

    // Data yang akan dipindah ke python
    $data = array($cari_lat,$cari_lon,$cari_tgl);

    //angin
    // Execute the python script with the JSON data
    $result = shell_exec('python "/var/www/html/semar-api/src/API/angin.py" ' . base64_encode(json_encode($data)));
    // Decode the result
    $resultData = json_decode($result, true);

    //arus
    // Execute the python script with the JSON data
    $result2 = shell_exec('python "/var/www/html/semar-api/src/API/arus.py" ' . base64_encode(json_encode($data)));
    // Decode the result
    $resultData2 = json_decode($result2, true);

    return $response->withJson(["status" => "success", "data_angin" => $resultData,"data_arus"=>$resultData2], 200);
});

//------------------------------------------------------------------------------------------------
//cari dari NC
//tiga parameter
$app->get("/cari-nc/angin/arus/suhu-udara-laut/", function (Request $request, Response $response, $args){
    $cari_lat = $request->getQueryParam("lat");
    $cari_lon = $request->getQueryParam("lon");
    $cari_tgl = $request->getQueryParam("tgl");

    // Data yang akan dipindah ke python
    $data = array($cari_lat,$cari_lon,$cari_tgl);

    //angin
    // Execute the python script with the JSON data
    $result = shell_exec('python "/var/www/html/semar-api/src/API/angin.py" ' . base64_encode(json_encode($data)));
    // Decode the result
    $resultData = json_decode($result, true);

    //arus
    // Execute the python script with the JSON data
    $result2 = shell_exec('python "/var/www/html/semar-api/src/API/arus.py" ' . base64_encode(json_encode($data)));
    // Decode the result
    $resultData2 = json_decode($result2, true);

    //suhu udara laut
    // Execute the python script with the JSON data
    $result3 = shell_exec('python "/var/www/html/semar-api/src/API/suhu_udara_laut.py" ' . base64_encode(json_encode($data)));
    // Decode the result
    $resultData3 = json_decode($result, true);

    return $response->withJson(["status" => "success", "data_angin" => $resultData,"data_arus"=>$resultData2, "data_suhu_udara_laut" => $resultData3], 200);
});