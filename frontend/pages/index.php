<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shop - Home</title>

    <link rel="icon" type="image/svg+xml" href="/assets/icons/logo.svg">

    <link href="/css/output.css" rel="stylesheet">
</head>

<body>

    <!-- Navigation Bar -->
    <?php include("components/header.php"); ?>

    <!-- Hero Section -->
    <section id="hero" class="relative h-96 flex flex-col items-center justify-center text-center bg-cover bg-center" style="background-image: url('/assets/images/bghero.avif');">
        <div class="relative mt-20">
            <h2 id="hero-subtitle" class="text-4xl text-white font-bold mt-13 opacity-0"></h2>
            <h1 id="hero-title" class="text-9xl font-extrabold text-shadow-lg/20 text-white opacity-0 absolute left-1/2 -translate-x-1/2 -top-10 tracking-wide mix-blend-overlay"></h1>
        </div>

        <p id="hero-desc" class="max-w-lg text-gray-100 text-base mt-12 opacity-0 transition-opacity duration-700">
            Discover products of the highest quality, tailored for your needs. Start your journey today.
        </p>
    </section>

    <!-- Section Divider -->
    <img class="absolute opacity-40" src="/assets/icons/divider.svg">
    
    <!-- Featured Section -->
    <h1 id="feat-product" class="text-5xl font-bold mx-7 my-14 mb-0 opacity-0 transition-opacity duration-700">Featured Products.</h1>
    <section id="catalog" class="relative flex justify-center">
        <div id="products-display-here" class="grid grid-cols-5 gap-4 max-w-7xl m-10">
            <!-- JS will populate this grid -->
        </div>
    </section>
    
    <!-- About Us Quote -->
    <section class="bg-black relative h-90 grid grid-cols-2 gap-4 text-gray-200">
        <!-- Border -->
        <img class="absolute top-0" src="/assets/icons/border2.svg">

        <!-- Writing -->
        <h1 class="flex justify-center items-center text-7xl">About Us</h1>
        <p class="flex justify-center items-center text-bold text-wrap">"Where every click brings you closer to what you love — curated collections, seamless shopping, and a touch of inspiration in every product."</p>
        
        <!-- Border -->
        <img class="absolute bottom-0 rotate-180" src="/assets/icons/border2.svg">
    </section>

    <!-- Just for testing
    <form id="deleteForm" action="/api/delete_product.php" method="POST">
        <input class="border-2 border-black" type="text" name="productId" id="productId">
    </form>
    <script>
        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const productId = document.getElementById('productId').value;
            const payload = {
                product_id: productId
            };
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/delete_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    console.log('Success:', response);
                    alert(response.message || response.error);
                }
            };
            
            xhr.send(JSON.stringify(payload));
        });
    </script>
    -->

    <!-- Footer -->
    <?php include("components/footer.php"); ?>

    <script>
        // Hero animations
        document.addEventListener("DOMContentLoaded", () => {
        const subTitleEl = document.getElementById("hero-subtitle");
        const titleEl    = document.getElementById("hero-title");
        const descEl     = document.getElementById("hero-desc");
        const featProd   = document.getElementById("feat-product");

                const subText = "Welcome to Our";
                const mainText = "SHOP.";
                let i = 0, j = 0;

                // Type "Welcome to"
                function typeSub() {
                    if (i < subText.length) {
                        subTitleEl.textContent = subText.substring(0, i + 1);
                        subTitleEl.style.opacity = 1;
                        i++;
                        setTimeout(typeSub, 50);
                    } else {
                        setTimeout(typeMain, 300);
                    }  
                }

                // Type "SHOP." with larger font size and lower opacity behind
                function typeMain() {
                    if (j < mainText.length) {
                        titleEl.textContent = mainText.substring(0, j + 1);
                        titleEl.style.opacity = 0.4;
                        j++;
                        setTimeout(typeMain, 100);
                    } else {
                        setTimeout(() => {
                            descEl.style.opacity = 1; // Show paragraph
                            featProd.style.opacity = 1; // Show heading
                            }, 400);
                        }
                    }

            // Call animation
            typeSub();
        });

        // Extract product info
        const getProductDetails = (productXML) => {
            let productId = productXML["id"];
            let productName = productXML.getElementsByTagName("name")[0].childNodes[0].nodeValue;
            let productDesc = productXML.getElementsByTagName("desc")[0].childNodes[0].nodeValue.slice(0, 64) + "...";
            let productImg = productXML.getElementsByTagName("img")[0].childNodes[0].nodeValue;

            return { id: productId, name: productName, desc: productDesc, img: productImg };
        };

        // Populate grid
        const populateCatalog = (xmlDoc) => {
            const container = document.getElementById("products-display-here");
            const products = xmlDoc.getElementsByTagName("product");
            if (products.length < 9) return; // Need at least 9 products

            // Random selection
            const selected = [];
            while (selected.length < 9) {
                const rnd = Math.floor(Math.random() * products.length);
                if (!selected.includes(rnd)) selected.push(rnd);
            }

            const details = selected.map(i => getProductDetails(products[i]));

            // Grid HTML
            container.innerHTML = `
            <!-- 1st Column -->
            <div class="grid grid-rows-2 gap-4 items-end">
                <div class="product-card row-span-2 h-[300px] self-end">
                    <img src="/api/get_image.php?imgName=${details[0].img}" alt="${details[0].name}" class="product-image">
                    <div class="product-overlay">
                        <div class="product-name">${details[0].name}</div>
                        <div class="product-desc">${details[0].desc}</div>
                        <a href="/product/${details[0].id}" class="product-link">View</a>
                    </div>
                </div>
                <div class="product-card h-[150px] self-start">
                    <img src="/api/get_image.php?imgName=${details[1].img}" alt="${details[1].name}" class="product-image">
                    <div class="product-overlay">
                        <div class="product-name">${details[1].name}</div>
                        <div class="product-desc">${details[1].desc}</div>
                        <a href="/product/${details[1].id}" class="product-link">View</a>
                    </div>
                </div>
            </div>

            <!-- 2nd Column -->
            <div class="product-card h-[350px] self-end">
                <img src="/api/get_image.php?imgName=${details[2].img}" alt="${details[2].name}" class="product-image">
                <div class="product-overlay">
                    <div class="product-name">${details[2].name}</div>
                    <div class="product-desc">${details[2].desc}</div>
                    <a href="/product/${details[2].id}" class="product-link">View</a>
                </div>
            </div>

            <!-- 3rd Column -->
            <div class="product-card h-[300px] self-end">
                <img src="/api/get_image.php?imgName=${details[3].img}" alt="${details[3].name}" class="product-image">
                <div class="product-overlay">
                    <div class="product-name">${details[3].name}</div>
                    <div class="product-desc">${details[3].desc}</div>
                    <a href="/product/${details[3].id}" class="product-link">View</a>
                </div>
            </div>

            <!-- 4th Column -->
            <div class="product-card h-[350px] self-end">
                <img src="/api/get_image.php?imgName=${details[4].img}" alt="${details[4].name}" class="product-image">
                <div class="product-overlay">
                    <div class="product-name">${details[4].name}</div>
                    <div class="product-desc">${details[4].desc}</div>
                    <a href="/product/${details[4].id}" class="product-link">View</a>
                </div>
            </div>

            <!-- 5th Column -->
            <div class="grid grid-rows-2 gap-4 items-end">
                <div class="product-card row-span-2 h-[300px] self-end">
                    <img src="/api/get_image.php?imgName=${details[5].img}" alt="${details[5].name}" class="product-image">
                    <div class="product-overlay">
                        <div class="product-name">${details[5].name}</div>
                        <div class="product-desc">${details[5].desc}</div>
                        <a href="/product/${details[5].id}" class="product-link">View</a>
                    </div>
                </div>
                <div class="product-card h-[150px] self-start">
                    <img src="/api/get_image.php?imgName=${details[6].img}" alt="${details[6].name}" class="product-image">
                    <div class="product-overlay">
                        <div class="product-name">${details[6].name}</div>
                        <div class="product-desc">${details[6].desc}</div>
                        <a href="/product/${details[6].id}" class="product-link">View</a>
                    </div>
                </div>
            </div>
            `;

        };

        // AJAX with XML
        const getAllProducts = () => {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {
                    populateCatalog(xhr.responseXML);
                }
            };

            xhr.open("GET", "/api/get_all_products.php", true);
            xhr.send();
        };

        window.onload = () => {
            getAllProducts();
        };
    </script>
</body>
</html>