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

//semua data tabel angin
$app->get("/angin/", function (Request $request, Response $response){
    $sql = "SELECT * FROM tbl_angin";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//semua data tabel arus
$app->get("/arus/", function (Request $request, Response $response){
    $sql = "SELECT * FROM tbl_arus";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//semua data tabel curah hujan
$app->get("/curah-hujan/", function (Request $request, Response $response){
    $sql = "SELECT * FROM tbl_curah_hujan";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//semua data tabel suhu udara
$app->get("/suhu-udara/", function (Request $request, Response $response){
    $sql = "SELECT * FROM tbl_suhu_udara";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//------------------------------------------------------------------------------

//cari data angin berdasarkan lat lon
$app->get("/angin/cari/", function (Request $request, Response $response, $args){
    $lat1 = $request->getQueryParam("lat");
    $lon1 = $request->getQueryParam("lon");

    $sql = "SELECT nilai_angin FROM tbl_angin WHERE lat = $lat1 AND lon = $lon1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//cari data arus berdasarkan lat lon
$app->get("/arus/cari/", function (Request $request, Response $response, $args){
    $lat1 = $request->getQueryParam("lat");
    $lon1 = $request->getQueryParam("lon");

    $sql = "SELECT nilai_arus FROM tbl_arus WHERE lat = $lat1 AND lon = $lon1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//cari data curah hujan berdasarkan lat lon
$app->get("/curah-hujan/cari/", function (Request $request, Response $response, $args){
    $lat1 = $request->getQueryParam("lat");
    $lon1 = $request->getQueryParam("lon");

    $sql = "SELECT nilai_curah_hujan FROM tbl_curah_hujan WHERE lat = $lat1 AND lon = $lon1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//cari data suhu udara berdasarkan lat lon
$app->get("/suhu-udara/cari/", function (Request $request, Response $response, $args){
    $lat1 = $request->getQueryParam("lat");
    $lon1 = $request->getQueryParam("lon");

    $sql = "SELECT nilai_suhu_udara FROM tbl_suhu_udara WHERE lat = $lat1 AND lon = $lon1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//seluruh data berdasarkan lat lon
$app->get("/cari/", function (Request $request, Response $response, $args){
    $lat1 = $request->getQueryParam("lat");
    $lon1 = $request->getQueryParam("lon");

    $sql = "SELECT tbl_angin.nilai_angin, tbl_arus.nilai_arus, tbl_suhu_udara.nilai_suhu_udara, tbl_curah_hujan.nilai_curah_hujan 
    		FROM tbl_angin, tbl_arus, tbl_suhu_udara, tbl_curah_hujan 
    		WHERE tbl_angin.lat = $lat1 AND tbl_angin.lon = $lon1 
    		AND tbl_arus.lat = $lat1 AND tbl_arus.lon = $lon1
    		AND tbl_suhu_udara.lat = $lat1 AND tbl_suhu_udara.lon = $lon1
    		AND tbl_curah_hujan.lat = $lat1 AND tbl_curah_hujan.lon = $lon1   
    		GROUP BY tbl_angin.id_angin, tbl_arus.id_arus, tbl_curah_hujan.id_curah_hujan, tbl_suhu_udara.id_suhu_udara";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

//------------------------------------------------------------------------------------------------
//seluruh data dengan tanggal
$app->get("/cari/tgl/", function (Request $request, Response $response, $args){
    $tgl1 = $request->getQueryParam("tgl");

    $sql = "SELECT tbl_angin.nilai_angin, tbl_arus.nilai_arus, tbl_curah_hujan.nilai_curah_hujan, tbl_suhu_udara.nilai_suhu_udara
    FROM tbl_angin, tbl_arus, tbl_curah_hujan, tbl_suhu_udara 
    WHERE tbl_angin.tanggal = '$tgl1' AND tbl_arus.tanggal = '$tgl1' AND tbl_curah_hujan.tanggal = '$tgl1' AND tbl_suhu_udara.tanggal = '$tgl1'
    GROUP BY tbl_angin.id_angin, tbl_arus.id_arus, tbl_curah_hujan.id_curah_hujan, tbl_suhu_udara.id_suhu_udara";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});


//------------------------------------------------------------------------------------------------
//cari dari NC
//cari data angin
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
