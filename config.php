<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname   = "testonline";

// الاتصال بقاعدة البيانات
$connect_database = mysqli_connect($host, $username, $password, $dbname);

// التحقق من الاتصال
if(mysqli_connect_errno()){
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

// تم الاتصال بنجاح - يمكن إزالة هذا الجزء إذا كنت لا تريد عرض أي شيء على الصفحة
?>


