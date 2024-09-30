<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update | تعديل منتج</title>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .main {
            background-color: #fff;
            width: 40%;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
        input[type="text"], input[type="file"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        img {
            margin: 10px 0;
            border: 1px solid #ccc;
            padding: 5px;
            width: 100px;
        }
        label {
            cursor: pointer;
            color: #007bff;
        }
        label:hover {
            text-decoration: underline;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        h2 {
            color: #333;
        }
        p {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <?php
        include('config.php');

        // التحقق من وجود id وإجراء العملية في خطوة واحدة بدون الحاجة إلى if..else
        $ID = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : die("Invalid ID or ID not set");

        // تنفيذ الاستعلام
        $up = mysqli_query($connect_database, "SELECT * FROM prod WHERE id = $ID") or die("Error: " . mysqli_error($connect_database));
        $data = mysqli_fetch_array($up) or die("Product not found");

    ?>
    <center>
        <div class="main">
            <form action="up.php" method="post" enctype="multipart/form-data">
                <h2>تعديل المنتجات</h2>
                <br>
                <input type="text" name="id" value="<?php echo $data['id']; ?>">
                <br>
                <input type="text" name="name" placeholder="name" value="<?php echo $data['name']; ?>">
                <br>
                <input type="text" name="price" placeholder="price" value="<?php echo $data['price']; ?>">
                <br>
                <input type="file" id="file" name="image" style="display:none;">
                <label for="file">تحديث صورة المنتج</label>
                <br>
                <img src="<?php echo $data['image']; ?>" alt="Current Product Image">
                <br><br>
                <button name="update" type="submit">تعديل المنتج</button>
                <br><br>
                <a href="products.php">عرض كل المنتجات</a>
            </form>
        </div>
        <p>Developer By Walaa</p>
    </center>
</body>
</html>

