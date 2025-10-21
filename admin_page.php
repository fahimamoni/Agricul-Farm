<?php

@include 'config.php';

session_start();

if (isset($_POST['add_product'])) {

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'uploaded_img/' . $product_image;

   if (empty($product_name) || empty($product_price) || empty($product_image)) {
      $message[] = 'please fill out all';
   } else {
      $insert = "INSERT INTO products(name, price, image) VALUES('$product_name', '$product_price', '$product_image')";
      $upload = mysqli_query($conn, $insert);
      if ($upload) {
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         $message[] = 'new product added successfully';
      } else {
         $message[] = 'could not add the product';
      }
   }
};

if (isset($_GET['delete'])) {
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM products WHERE id = $id");
   header('location:admin_page.php');
};

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <link rel="stylesheet" href="css/product_style.css">
   <link rel="stylesheet" href="css/user_style.css">

</head>

<body>

   <?php

   if (isset($message)) {
      foreach ($message as $message) {
         echo '<span class="message">' . $message . '</span>';
      }
   }

   ?>

   <?php

   $select = mysqli_query($conn, "SELECT * FROM products");

   ?>


   <header class="header">

      <div class="flex">

         <a href="#" class="logo">Agricul Farm</a>



         <div id="maincontent">
            <button id="button">Add Product</button>
         </div>
         <div id="menu-btn" class="fas fa-bars"></div>
         <div class="icons">

            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"><a href="home.php"></a></div>
         </div>


         <div id="overlay"></div>
         <div id="popup">
            <div class="popupcontrols"><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
               <span id="popupclose">X</span>
            </div>
            <div class="c">
            </div>
            <div class="container">
               <div class="admin-product-form-container">

                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                     <h3>add a new product</h3>
                     <input type="text" placeholder="enter product name" name="product_name" class="box">
                     <input type="number" placeholder="enter product price" name="product_price" class="box">
                     <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                     <input type="submit" class="btn" name="add_product" value="add product">
                  </form>

               </div>
            </div>
            <style>
               body {
      background-color: azure;
    }

               #overlay {
                  display: none;
                  position: absolute;
                  top: 0;
                  bottom: 0;
                  background: #999;
                  width: 100%;
                  height: 100%;
                  opacity: 0.8;
                  z-index: 100;
               }

               #popup {
                  display: none;
                  position: absolute;
                  top: 50%;
                  left: 50%;
                  background: #fff;
                  width: 500px;
                  height: 500px;
                  margin-left: -250px;
                  /*Half the value of width to center div*/
                  margin-top: -250px;
                  /*Half the value of height to center div*/
                  z-index: 200;
               }

               #popupclose {
                  float: right;
                  padding: 10px;
                  cursor: pointer;
               }

               .popupcontent {
                  padding: 10px;
                  position: center;
               }

               #button {
                  cursor: pointer;
               }
            </style>


   </header>
   <div class="home-bg">

      <section class="home">

         <div class="content">
            <p>Explore your panel to track your product's, from here you can control your products your current total number of products are:</p>
         </div>

      </section>
   </div>
   </div>
   </div>
   <div class="row">
      <section style="padding: 20px;">
         <div class="col-sm-3">
            <div class="card card-green">
               <p>Total Products-</p>
               <?php

               $query = "SELECT id FROM products ORDER BY id";
               $query_run = mysqli_query($conn, $query);
               $row = mysqli_num_rows($query_run);
               echo '<h4>  ' . $row . '</h4>';
               ?>

            </div>
            <div class="container">


            </div>
         </div>

         <div class="product-display">
            <table class="product-display-table">
               <thead>
                  <tr>
                     <th>product image</th>
                     <th>product name</th>
                     <th>product price</th>
                     <th>action</th>
                  </tr>
               </thead>

               <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                  <tr>
                     <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                     <td><?php echo $row['name']; ?></td>
                     <td>$<?php echo $row['price']; ?>/-</td>
                     <td>
                        <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                        <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
                     </td>
                  </tr>
               <?php } ?>
            </table>
         </div>

</body>

</html>

<script type="text/javascript">
   // Initialize Variables
   var closePopup = document.getElementById("popupclose");
   var overlay = document.getElementById("overlay");
   var popup = document.getElementById("popup");
   var button = document.getElementById("button");
   // Close Popup Event
   closePopup.onclick = function() {
      overlay.style.display = 'none';
      popup.style.display = 'none';
   };
   // Show Overlay and Popup
   button.onclick = function() {
      overlay.style.display = 'block';
      popup.style.display = 'block';
   }
</script>
</body>

</html>