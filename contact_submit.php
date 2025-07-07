
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $phone = $_POST['phone'] ?? "";
    $message = $_POST['message'] ?? "";
    $timestamp = date("Y-m-d H:i:s");

    $data = [$name, $email, $phone, $message, $timestamp];
    $line = base64_encode(implode(",", $data)) . "\n";

    file_put_contents("contact_messages.csv", $line, FILE_APPEND | LOCK_EX);

    header("Location: contact.html?success=1");
    exit();
}
?>
