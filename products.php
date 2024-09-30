<!DOCTYPE html>
<html lang="en">
<head>
     <link href=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel = "stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add products|اضافة المنتجات </title>
    <link rel="stylesheet" href="style.css">
    <style>
        h3{
            font-family: "Cairo", sans-serif;
            font-weight: bold;
        }
        .card{
            float: right;
            margin-top: 20px;
            margin-left:10px;
            margin-right:10px;

        }
        .card img{
            width:100%;
            height:200px;
        }
        main{
            width: 60%;
        }
    </style>
</head>
<body>
   <center>
       <h3>لوحة تحكم الادمن</h3>
   </center>
   <?php
       include('config.php');
       $result = mysqli_query($connect_database, "SELECT * FROM prod");

       while($row =mysqli_fetch_array($result)){
           echo"
            <center>
                  <main>
                         <div class='card' style='width: 15rem;'>
                                       <img src='$row[image]' class='card-img-top' alt='...'>
                                   <div class='card-body'>
                                       <h5 class='card-title'>$row[name]</h5>
                                       <p class='card-text'>$row[price]</p>
                                       <a href='delete.php? id=$row[id]' class='btn btn-danger'>حذف منتج</a>
                                       <a href='update.php? id=$row[id]' class='btn btn-primary'>تعديل منتج</a>
                                   </div>
                         </div>
                 </main>
            </center>
           
           ";

    }

   ?>

   
</body>
</html>
