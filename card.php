<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عربتى | منتجاتى</title>
    <style>
        h3 {
            font-family: "Cairo", sans-serif;
            font-weight: bold;
        }
        main {
            width: 40%;
            margin-top: 30px;
        }
        table {
            box-shadow: 1px 1px 10px silver;
        }
        thead tr th {
            background-color: #4fd0f3 !important;
            color: white !important;
            text-align: center;
        }
        tbody {
            text-align: center; 
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h3>منتجاتك المحجوزة</h3>
        <?php
            include('config.php');
            $result = mysqli_query($connect_database, "SELECT * FROM addcard");
            if (mysqli_num_rows($result) > 0) {
        ?>
            <main>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">اسم المنتج</th> 
                            <th scope="col">سعر المنتج</th> 
                            <th scope="col">حذف المنتج</th>  
                        </tr>   
                    </thead>
                    <tbody>
                        <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['price']); ?></td>
                                <td><a href="del_card.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-danger">حذف</a></td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </main>
        <?php
            } else {
                echo "<p>لا توجد منتجات محجوزة</p>";
            }
        ?>
        <a href="shop.php" class="btn btn-primary" style="margin-top: 20px;">الرجوع الى صفحة المنتجات</a>
    </div>
</body>
</html>



