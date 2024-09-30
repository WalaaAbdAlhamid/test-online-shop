<?php
include('config.php');

if (isset($_POST['update'])){
    // التحقق من أن الحقول ليست فارغة
    if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_FILES['image']['name'])) {
        $ID  = $_POST['id'];
        $NAME = mysqli_real_escape_string($connect_database, $_POST['name']);
        $PRICE = mysqli_real_escape_string($connect_database, $_POST['price']);
        $IMAGE = $_FILES['image'];
        $image_location = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_up = "images/" . $image_name;

        // التأكد من أن الجدول الصحيح يتم تحديثه
        $update = "UPDATE prod SET name= '$NAME', price='$PRICE', image='$image_up' WHERE id=$ID";

        // تنفيذ الاستعلام والتحقق من النجاح
        if (mysqli_query($connect_database, $update)) {
            if (move_uploaded_file($image_location, $image_up)) {
                echo "<script>alert('تم تحديث المنتج بنجاح');</script>";
            } else {
                echo "<script>alert('حدثت مشكلة أثناء رفع الصورة');</script>";
            }
        } else {
            // إذا حدث خطأ في تنفيذ الاستعلام
            echo "<script>alert('حدث خطأ في تحديث المنتج: " . mysqli_error($connect_database) . "');</script>";
        }
    } else {
        echo "<script>alert('تأكد من تعبئة جميع الحقول');</script>";
    }

    // إعادة التوجيه إلى الصفحة الرئيسية
    header('Location: index.php');
}
?>
