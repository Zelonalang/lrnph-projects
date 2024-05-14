<?php
// Establish database connection
$dsn = "mysql:host=localhost;dbname=lrnphdev";
$username = "itadmin";
$password = "La.rose1@)@!";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to retrieve data from users table
    $query = "SELECT csize, coutput, totalpblispcs FROM coatingprod";
    $result = $pdo->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    // Process the data for the pie chart
    $csizeData = [];
    $coutputData = [];

    foreach ($data as $row) {
        $csizeData[$row['csize']] = isset($csizeData[$row['csize']]) ? $csizeData[$row['csize']] + 1 : 1;
        $coutputData[$row['coutput']] = isset($coutputData[$row['coutput']]) ? $coutputData[$row['coutput']] + 1 : 1;
    }

    $csizeLabels = array_keys($csizeData);
    $csizeValues = array_values($csizeData);

    $coutputLabels = array_keys($coutputData);
    $coutputValues = array_values($coutputData);

    $responseData = [
        'csizeLabels' => $csizeLabels,
        'csizeValues' => $csizeValues,
        'coutputLabels' => $coutputLabels,
        'coutputValues' => $coutputValues,
    ];

    header('Content-Type: application/json');
    echo json_encode($responseData);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
