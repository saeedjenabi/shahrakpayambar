
<?php
session_start();
$correct_username = "Saeed";
$correct_password = "Sa@304508";

// مدیریت ورود
if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] === $correct_username && $_POST['password'] === $correct_password) {
        $_SESSION['admin'] = true;
    } else {
        $error = "نام کاربری یا رمز عبور اشتباه است.";
    }
}

// اگر لاگین نشده
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
?>
<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8" />
  <title>ورود ادمین | پیام‌ها</title>
  <style>
    body { font-family: Tahoma, sans-serif; direction: rtl; background: #f2f2f2; padding: 3rem; text-align: center; }
    input[type="text"], input[type="password"], button {
      padding: 10px 15px; font-size: 1.1rem; margin-top: 1rem;
    }
    .box {
      background: white; padding: 2rem; max-width: 400px; margin: auto;
      box-shadow: 0 0 15px rgba(0,0,0,0.2); border-radius: 8px;
    }
  </style>
</head>
<body>
  <div class="box">
    <h2>ورود مدیر برای مشاهده پیام‌ها</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
      <input type="text" name="username" placeholder="نام کاربری" required /><br>
      <input type="password" name="password" placeholder="رمز عبور" required /><br>
      <button type="submit">ورود</button>
    </form>
  </div>
</body>
</html>
<?php
    exit;
}

// نمایش پیام‌ها پس از لاگین
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: view_contact.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8" />
  <title>پیام‌های تماس</title>
  <style>
    body { font-family: Tahoma, sans-serif; direction: rtl; background: #f2f2f2; padding: 2rem; }
    h2 { color: #27ae60; }
    table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 1rem; }
    th, td { padding: 12px 16px; border: 1px solid #ccc; text-align: center; }
    th { background: #27ae60; color: white; }
    tr:nth-child(even) { background-color: #f9f9f9; }
    input[type="text"] { width: 100%; padding: 8px 12px; font-size: 1rem; margin-bottom: 1rem; }
    .container { max-width: 1000px; margin: auto; }
    .logout { text-align: left; margin-top: 10px; }
    .logout a { color: red; text-decoration: none; }
  </style>
  <script>
    function filterTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("tbody tr");
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? "" : "none";
      });
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>لیست پیام‌های ارسال‌شده</h2>
    <input type="text" id="searchInput" placeholder="جستجو در جدول..." onkeyup="filterTable()" />
    <div class="logout"><a href="?logout=1">خروج</a></div>
    <table>
      <thead>
        <tr>
          <th>نام</th>
          <th>ایمیل</th>
          <th>تلفن</th>
          <th>متن پیام</th>
          <th>تاریخ</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $file = 'contact_messages.csv';
        if (file_exists($file)) {
          $lines = file($file);
          foreach ($lines as $line) {
            $decoded = base64_decode(trim($line));
            $fields = explode(",", $decoded);
            echo "<tr>";
            foreach ($fields as $field) {
              echo "<td>" . htmlspecialchars($field) . "</td>";
            }
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='5'>هیچ پیامی ثبت نشده است.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
