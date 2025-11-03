<?php
session_start();

// File path
$PATHProd = __DIR__ . "/../../backend/data/products.xml";
$PATHUsr  = __DIR__ . "/../../backend/data/users.xml";

// Load products XML
$productsXML = simplexml_load_file($PATHProd);
$totalProducts = count($productsXML->category->product);

// Total categories
$totalProducts = 0;
$totalCategories = count($productsXML->category);
foreach ($productsXML->category as $cat) {
    $totalProducts += count($cat->product);
}

// Load users XML
$usersXML = simplexml_load_file($PATHUsr);
$totalUsers = count($usersXML->user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop- About Us</title>

    <link rel="icon" type="image/svg+xml" href="/assets/icons/logo.svg">

    <link href="/css/output.css" rel="stylesheet">
    
</head>
<body>
    <?php include("components/header.php"); ?>

    <!-- About Us -->
    <section class="section-layout">

        <div class="section-content space-y-6">

            <!-- Writing -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <h1 class="text-4xl md:text-7xl flex justify-center items-center text-center md:text-left">
                    About Us
                </h1>
                <p class="text-sm md:text-base flex justify-center items-center text-center md:text-left">
                    At Shop. we are passionate about bringing you a seamless online shopping experience. From the latest trends to timeless essentials, our carefully curated collection is designed to meet the needs of every lifestyle. We believe in quality, convenience, and customer satisfaction, which is why we prioritize top-notch products, secure shopping, and fast delivery. <br> Our mission is simple: to make shopping enjoyable, effortless, and inspiring for everyone. Join us on our journey to discover products that enhance your everyday life.
                </p>
            </div>

            <!-- Statistics -->
            <div class="bg-black p-4 my-4 text-gray-500 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-center rounded-2xl">
                <div class="space-y-2 hover:text-white transition-colors duration-300">
                    <h1 class="text-4xl md:text-6xl"><?= $totalProducts ?></h1>
                    <p>Products in Stock</p>
                </div>

                <div class="space-y-2 hover:text-white transition-colors duration-300">
                    <h1 class="text-4xl md:text-6xl"><?= $totalUsers ?></h1>
                    <p>Registered Clients</p>
                </div>

                <div class="space-y-2 hover:text-white transition-colors duration-300">
                    <h1 class="text-4xl md:text-6xl"><?= $totalCategories ?></h1>
                    <p>Product Categories</p>
                </div>
            </div>

        </div>

    </section>

    <!-- Footer -->
    <?php include("components/footer.php"); ?>
</body>
</html>