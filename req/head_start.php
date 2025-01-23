<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- <base href="http://194.36.84.9/plesk-site-preview/sungate24.com/https/194.36.84.9/"> -->
    <base href="http://localhost/sungate24/">
    <meta name="author" content="Sungate Holiday">
    <meta name="publisher" content="Sungate Holiday">
    <meta name="copyright" content="Sungate Holiday">
    <meta name="description"
        content="Herzlich Willkommen auf Sungate24! Ihr Experte für exklusive Reisen zu besten Preisen! Finden Sie Ihren perfekten Urlaub zu guten Preisen! Von Hotel bis zur Tour und Schifffahrt alle Urlaubsziele aus einer Hand! ">
    <meta name="keywords"
        content="urlaub, sommer, sonne, frühjahr, frühling, winter, herbst, travel, türkei, italien, südsee, frankfreich, ibiza, malorca, kroatien, griechenland, zypern, fernreise, sand, strand, meer, schifffahrt, charter, flug, kinder, kinderfreundlich, familie">
    <meta name="page-topic" content="Reise Tourismus">
    <meta name="page-type" content="Katalog Verzeichnis">
    <meta name="audience" content="Alle">
    <meta name="robots" content="index, follow">
    <?php
    // Assuming you already have $con as the MySQLi connection from db.php
    
    // Prepare the SQL query using MySQLi
    $query = "SELECT * FROM the_setting WHERE type = 'general'";

    // Execute the query
    $result = $con->query($query);

    // Check if the query was successful
    if ($result) {
        // Fetch all results as an associative array
        $generalSettings = $result->fetch_all(MYSQLI_ASSOC);

        function namedSettings($settings)
        {
            $named_settings = [];
            if ($settings) {
                foreach ($settings as $setting) {
                    $named_settings[$setting['name']] = $setting;
                }
            }
            return $named_settings;
        }

        $general = namedSettings($generalSettings);
    } else {
        // If the query fails, handle the error
        die("Query failed: " . $con->error);
    }

    $rezervasyonNo = $_SESSION["sepet"]["rezervasyonNumarasi"] ?? '';
    ?>