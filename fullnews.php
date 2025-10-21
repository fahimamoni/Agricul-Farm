<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Full News</title>
    <style media="screen">
      img{
        width: 750px;
        height: 300px;
      }
      .div1{
        margin-left: 400px;
        margin-top: 50px;
      }
      .div2{
        width: 750px;
        margin-top: 20px;
        font-size: 20px;
      }
      p{
        font-size: 20px;
        font-weight: bold;
        margin-left: 290px;
      }
      ::-webkit-scrollbar{
        display: none;
      }
      body {
      background-color: white;
    }

    </style>
  </head>
  <body>
    <?php
    include 'navbar.php';
    include 'db.php';

    $id=$_POST['id'];

    $sql="SELECT * from news where id='$id'";
    $query=mysqli_query($conn,$sql);

    while ($info=mysqli_fetch_array($query)) {
      ?>
        <div class="div1">
          <p><?php echo $info['date']; ?></p>
          <img src="image/<?php echo $info['image']; ?>" alt="">
          <div class="div2">
            <?php echo $info['news']; ?>

          </div>
        </div>
      <?php
    }


    ?>

  </body>
</html>
