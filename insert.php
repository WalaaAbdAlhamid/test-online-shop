<?php
include('config.php');

if (isset($_POST['upload'])) {
    // التحقق من أن الحقول ليست فارغة
    if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_FILES['image']['name'])) {
        $NAME = mysqli_real_escape_string($connect_database, $_POST['name']);
        $PRICE = mysqli_real_escape_string($connect_database, $_POST['price']);
        $IMAGE = $_FILES['image'];
        $image_location = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_up = "images/" . $image_name;
        
        // إدخال البيانات باستخدام Prepared Statements لتجنب SQL Injection
        $insert = $connect_database->prepare("INSERT INTO prod (name, price, image) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $NAME, $PRICE, $image_up);
        
        if ($insert->execute()) {
            if (move_uploaded_file($image_location, $image_up)) {
                echo "<script>alert('تم رفع المنتج بنجاح')</script>";
            } else {
                echo "<script>alert('حدثت مشكلة، لم يتم رفع الصورة')</script>";
            }
        } else {
            echo "<script>alert('حدثت مشكلة، لم يتم إدخال البيانات')</script>";
        }
        
        $insert->close();
    } else {
        echo "<script>alert('يرجى ملء جميع الحقول')</script>";
    }

    // إعادة التوجيه إلى الصفحة الرئيسية
    header('Location: index.php');
}
?>

