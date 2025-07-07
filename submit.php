
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $owner = $_POST['ownerName'];
    $unit = $_POST['unitNumber'];
    $type = $_POST['requestType'];
    $desc = $_POST['description'];
    $mobile = $_POST['mobile'];
    $code = 'PYMBR-' . rand(100000, 999999);

    $row = [$owner, $unit, $type, $desc, $mobile, $code, date("Y-m-d H:i:s")];
    $file = fopen("requests.csv", "a");
    fputcsv($file, $row);
    fclose($file);

    header("Location: request.html?code=" . urlencode($code));
    exit();
}
?>
