<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($connect_database, $_POST['email']);
    $pass = mysqli_real_escape_string($connect_database, md5($_POST['password']));

    $select = mysqli_query($connect_database, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        header('Location: shop.php');
        exit(); // تأكد من إنهاء السكربت بعد إعادة التوجيه
    } else {
        $message[] = 'البريد الإلكتروني أو كلمة المرور غير صحيحة!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>

    <!-- CSS Styles -->
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }
        .form-container h3 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .form-container input[type="email"], .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }
        .form-container p {
            margin-top: 10px;
            color: #555;
        }
        .form-container p a {
            color: #007bff;
            text-decoration: none;
        }
        .form-container p a:hover {
            text-decoration: underline;
        }
        .message {
            background-color: #ffcccc;
            color: #b30000;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #b30000;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .message:hover {
            background-color: #ff9999;
        }
    </style>
</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message" onclick="this.remove();">' . $msg . '</div>';
    }
}
?>

<div class="form-container">
    <form action="" method="post">
        <h3>تسجيل الدخول</h3>
        <input type="email" name="email" required placeholder="البريد الإلكتروني" class="box">
        <input type="password" name="password" required placeholder="كلمة المرور" class="box">
        <input type="submit" name="submit" class="btn" value="تسجيل الدخول">
        <p>هل لديك حساب؟ <a href="register.php">إنشاء حساب جديد</a></p>
    </form>
</div>

</body>
</html>

