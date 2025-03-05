<?php
    require_once "./database/database.php";
    require_once "./database/product.php";
    require_once "./handle.php";

    $db = new Database();
    $products = new product($db);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        if (isset($_SESSION["account_login"])) {
            if (isset($_SESSION["account_login"]["idRole"]) && $_SESSION["account_login"]["idRole"] != 1) {
                session_destroy();
            }
        }
    }

    if(isset($_GET["code"]))
    {
        require_once "./gui/googleLogin.php";
        require_once "./database/user.php";
        $user = new user($db);
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
        
        if(!isset($token["error"]))
        {
            $google_client->setAccessToken($token['access_token']);

            $_SESSION['access_token']=$token['access_token'];

            $google_service = new Google_Service_Oauth2($google_client);

            $data = $google_service->userinfo->get();

            $fullname = $data['name'];
            $email = $data['email'];
            $avatar = $data['picture'];
            $check = $user->loginWithEmail($email, $fullname, $avatar);
            // echo print_r($check);
            // exit ();
            if ($check == "") {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
            if ($check == 'admin') {
                header ("location: " . 'http://localhost/LTW-UD2/admin/');
            }
            else
                echo "<script>alert('$check');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css -->
    <link rel="stylesheet" href="">

</head>

<body>

    <!-- navbar -->
    <div class="container-fluid">
        <?php
            require_once "";
            include "./gui/navbar.php";
        ?>
    </div>

    <!-- content -->
    <div class="container-fluid">

        <!-- slide banner -->
        <div class="slide-image">

        </div>

        <!-- buyer race -->
        <div class="row buyer-benefit">

        </div>

        <!-- product new -->
        <div class="product-new">
            <div class="title">
                <h1>Sản phẩm mới</h1>
            </div>
            <div class="products">
                <?php
                    $result = $products->selectProductNew ();
                    while ($row = $result->fetch_assoc()) {
                ?>

                <div class="product">
                    <div class="product-item">
                        <div class="product-top">
                            <a href="./detailProduct.php?idProduct=<?php echo $row['idProduct']; ?>"
                                class="product-image">
                                <img src="<?php echo $row['image']; ?>" loading="lazy" alt="" class="img-fluid">
                            </a>
                        </div>
                        <div class="product-info">
                            <div class="product-name">
                                <a
                                    href="./detailProduct.php?idProduct=<?php echo $row['idProduct']; ?>"><?php echo $row['productName']; ?></a>
                            </div>
                            <?php
                                if ($row['oldPrice'] != 0) {
                            ?>
                            <div class="product-price">
                                <span class="old-price"><?php echo convertPrice($row['oldPrice']); ?></span>
                                <span class="current-price"><?php echo convertPrice($row['currentPrice']); ?></span>
                            </div>
                            <?php
                                } else {
                            ?>
                            <div class="product-price">
                                <span><?php echo convertPrice($row['currentPrice']); ?></span>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <?php
                    }
                ?>
            </div>
        </div>

        <!-- best seller -->
        <div class="best-seller">
            <div class="title">
                <h1>Sản phẩm bán chạy</h1>
            </div>
            <div class="products">
                <?php
                    $result = $products->selectProductBestSeller ();
                    while ($row = $result->fetch_assoc()) {
                ?>
                <div class="product">
                    <div class="product-item">
                        <div class="product-top">
                            <a href="./detailProduct.php?idProduct=<?php echo $row['idProduct']; ?>"
                                class="product-image">
                                <img src="<?php echo $row['image']; ?>" loading="lazy" alt="" class="img-fluid">
                            </a>
                        </div>
                        <div class="product-info">
                            <div class="product-name">
                                <a
                                    href="./detailProduct.php?idProduct=<?php echo $row['idProduct']; ?>"><?php echo $row['productName']; ?></a>
                            </div>
                            <?php
                                if ($row['oldPrice'] != 0) {
                            ?>
                            <div class="product-price">
                                <span class="old-price"><?php echo convertPrice($row['oldPrice']); ?></span>
                                <span class="current-price"><?php echo convertPrice($row['currentPrice']); ?></span>
                            </div>
                            <?php
                                } else {
                            ?>
                            <div class="product-price">
                                <span><?php echo convertPrice($row['currentPrice']); ?></span>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <?php
                    }
                ?>
            </div>
        </div>

        <!-- feature brands -->
        <div class="feature-brands row">
            <div class="title col-sm-12 col-md-12 col-lg-12">
                <h1>Thương hiệu nổi bật</h1>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 row">
                <?php
                    $result = $brands->selectAll();
                    while ($row = $result->fetch_assoc()) {
                ?>

                <a href="./products.php?idBrand=<?php echo $row['idBrand']; ?>" class="col-lg-3 col-md-3 col-sm-4"><img
                        class="img-fluid" loading="lazy" src="<?php echo $row['imageLogo']; ?>" alt=""></a>
                <?php
                    }
                ?>
            </div>
        </div>

        <!-- news -->
        <div class="news">
            
        </div>

    </div>
    <!-- js -->
</body>

</html>