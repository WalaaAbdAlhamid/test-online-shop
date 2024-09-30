<?php

include 'config.php';

if(isset($_POST['submit'])){        

   $name = mysqli_real_escape_string($connect_database , $_POST['name']);
   $email = mysqli_real_escape_string($connect_database , $_POST['email']);
   $pass = mysqli_real_escape_string($connect_database , md5($_POST['password']));
   $cpass = mysqli_real_escape_string($connect_database , md5($_POST['cpassword']));

   $select = mysqli_query($connect_database , "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'البريد الإلكتروني موجود بالفعل!';
   } else {
      if($pass != $cpass){
         $message[] = 'كلمتا المرور غير متطابقتين!';
      } else {
         mysqli_query($connect_database , "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
         $message[] = 'تم التسجيل بنجاح!';
         header('location:login.php');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>تسجيل حساب جديد</title>
   <style>
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: 'Arial', sans-serif;
      }

      body {
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         background-color: #f4f4f4;
      }

      .form-container {
         background-color: #fff;
         padding: 40px;
         border-radius: 8px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         width: 100%;
         max-width: 400px;
         text-align: center;
      }

      h3 {
         margin-bottom: 20px;
         color: #333;
      }

      .box {
         width: 100%;
         padding: 12px;
         margin: 10px 0;
         border: 1px solid #ddd;
         border-radius: 4px;
         font-size: 16px;
      }

      .btn {
         width: 100%;
         padding: 12px;
         background-color: #28a745;
         color: white;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         font-size: 16px;
         margin-top: 10px;
      }

      .btn:hover {
         background-color: #218838;
      }

      .form-container p {
         margin-top: 20px;
         font-size: 14px;
         color: #666;
      }

      .form-container a {
         color: #007bff;
         text-decoration: none;
      }

      .form-container a:hover {
         text-decoration: underline;
      }

      .message {
         margin-bottom: 10px;
         padding: 10px;
         background-color: #f8d7da;
         color: #721c24;
         border: 1px solid #f5c6cb;
         border-radius: 4px;
         text-align: center;
      }
   </style>
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $msg){
      echo '<div class="message" onclick="this.remove();">'.$msg.'</div>';
   }
}
?>

<div class="form-container">
   <form action="" method="post">
      <h3>إنشاء حساب جديد</h3>
      <input type="text" name="name" required placeholder="اسم المستخدم" class="box">
      <input type="email" name="email" required placeholder="البريد الإلكتروني" class="box">
      <input type="password" name="password" required placeholder="كلمة المرور" class="box">
      <input type="password" name="cpassword" required placeholder="تأكيد كلمة المرور" class="box">
      <input type="submit" name="submit" class="btn" value="تسجيل حساب">
      <p>هل لديك حساب؟ <a href="login.php">تسجيل دخول</a></p>
   </form>
</div>

</body>
</html>
