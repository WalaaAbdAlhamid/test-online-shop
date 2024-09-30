<?php
   // تضمين ملف الاتصال بقاعدة البيانات
   include('config.php');

   // التحقق من وجود معرّف id في الرابط
   if (isset($_GET['id'])) {
       // تأمين المعرف لمنع هجمات SQL Injection
       $ID = mysqli_real_escape_string($connect_database, $_GET['id']);
       
       // استعلام الحذف
       $delete_query = "DELETE FROM prod WHERE id='$ID'";

       // تنفيذ استعلام الحذف
       $result = mysqli_query($connect_database, $delete_query);

       // التحقق من نجاح عملية الحذف
       if ($result) {
           // إذا تم الحذف بنجاح، إعادة التوجيه إلى صفحة المنتجات
           header('Location: products.php?message=deleted');
           exit(); // تأكد من إنهاء التنفيذ بعد إعادة التوجيه
       } else {
           // إذا حدث خطأ أثناء الحذف، عرض رسالة الخطأ
           echo "Error deleting record: " . mysqli_error($connect_database);
       }
   } else {
       // إذا لم يتم توفير معرف، عرض رسالة مناسبة
       echo "No ID provided.";
   }

   // إنهاء الاتصال بقاعدة البيانات
   mysqli_close($connect_database);
?>
