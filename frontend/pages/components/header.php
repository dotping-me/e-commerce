<?php
session_start();
?>

<header class="fixed top-0 left-0 w-full z-50 shadow-2xl rounded-b-2xl backdrop-blur-md bg-white/30 
    hover:bg-gray-700 hover:text-gray-200 transition-colors duration-300 animate-slide-down">
    <nav class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <!-- Left Search bar -->
            <form class="hidden sm:flex flex-1 items-center" method="GET" action="/catalog">
                <div class="relative w-62">
                    <input
                        type="text"
                        placeholder="Search product here..."
                        class="w-full pl-4 pr-10 py-2 rounded-full shadow-xl backdrop-blur-2xl hover:text-gray-200 placeholder-gray-400 transition-colors duration-300 focus:outline-none focus:ring-2 hover:bg-gray-800"
                        name="prodName"
                        id="prodName"
                    >
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-200 transition-colors duration-300">
                        <img src="/assets/icons/search.svg" class="icon">
                    </button>
                </div>
            </form>

            <!-- Center Navigation links -->
            <div class="hidden md:flex w-fit flex-1 space-x-8 justify-center items-end">
                <a href="/" class="links">Home</a>
                <a href="/catalog" class="links">Catalog</a>
                <a href="/aboutus" class="links">About Us</a>
            </div>

            <!-- Right User & Cart -->
            <div class="hidden md:flex items-center space-x-2">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if (!empty($_SESSION['user']['isAdmin'])): ?>
                        <a href="/dashboard" class="nav-icons">
                            <img class="icon" src="/assets/icons/admin.svg">
                        </a>
                    <?php endif; ?>

                    <a href="#" class="nav-icons">
                        <img id="logout-icon" class="icon" src="/assets/icons/logout.svg">
                    </a>
                <?php else: ?>
                    <a href="/signup" class="nav-icons">
                        <img class="icon" src="/assets/icons/user.svg" alt="User">
                    </a>
                <?php endif; ?>

                <a href="/cart" class="nav-icons">
                    <img class="icon" src="/assets/icons/cart.svg" alt="Cart">
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menu-btn" class="md:hidden p-2 rounded-full hover:bg-gray-500 transition-colors duration-300">
                <img src="/assets/icons/menu.svg" alt="Menu" class="w-6 h-6">
            </button>
        </div>
    </nav>
</header>

<!-- Sidebar -->
<div id="sidebar" class="fixed top-0 left-0 h-full bg-gray-700 text-white transform -translate-x-full transition-transform duration-300 ease-in-out z-50 p-6 space-y-6 overflow-y-auto">
    <button id="close-btn" class="absolute top-4 right-4 text-gray-400 hover:text-white">
        <img class="icon" src="/assets/icons/close.svg">
    </button>

    <form class="flex items-center mt-10 mb-6" method="GET" action="/catalog">
        <div class="relative w-full">
            <input
                type="text"
                placeholder="Search..."
                class="w-full pl-4 pr-10 py-2 rounded-full bg-gray-800 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
                name="prodName"
            >
            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                <img src="/assets/icons/search.svg" class="icon">
            </button>
        </div>
    </form>

    <nav class="flex flex-col space-y-4">
        <a href="/" class="links text-white hover:text-gray-400">Home</a>
        <a href="/catalog" class="links text-white hover:text-gray-400">Catalog</a>
        <a href="/aboutus" class="links text-white hover:text-gray-400">About Us</a>
    </nav>

    <div class="border-t border-gray-900 my-4"></div>

    <div class="flex flex-col space-y-3">
        <?php if (isset($_SESSION['user'])): ?>
            <?php if (!empty($_SESSION['user']['isAdmin'])): ?>
                <a href="/dashboard" class="flex items-center space-x-2 hover:text-gray-400">
                    <img src="/assets/icons/admin.svg" class="icon"><span>Dashboard</span>
                </a>
            <?php endif; ?>

            <a href="#" id="logout-icon-mobile" class="flex items-center space-x-2 hover:text-gray-400">
                <img src="/assets/icons/logout.svg" class="icon"><span>Logout</span>
            </a>
        <?php else: ?>
            <a href="/signup" class="flex items-center space-x-2 hover:text-gray-400">
                <img src="/assets/icons/user.svg" class="icon"><span>Sign Up</span>
            </a>
        <?php endif; ?>

        <a href="/cart" class="flex items-center space-x-2 hover:text-gray-400">
            <img src="/assets/icons/cart.svg" class="icon"><span>Cart</span>
        </a>
    </div>
</div>

<!-- Popup and Overlay -->
<div id="overlay"></div>
<div id="popup"></div> 

<script>
    // Logout Popup
    const popup   = document.getElementById("popup"); 
    const overlay = document.getElementById("overlay"); 

    document.getElementById("logout-icon")?.addEventListener("click", function(e) {
        e.preventDefault();
        fetch("/api/logout.php")
        .then(res => res.json())
        .then(data => {
            popup.textContent = data.message;
            popup.classList.add("active");
            overlay.classList.add("active");

            setTimeout(() => {
                popup.classList.remove("active");
                overlay.classList.remove("active");
            }, 2000);

            if ( data.success ) {
                setTimeout(() => {
                    window.location.href = "/signup"; // redirect to signup page
                }, 3000)
            }            
        });
    });

    // Sidebar
    const menuBtn = document.getElementById("menu-btn");
    const sidebar = document.getElementById("sidebar");
    const closeBtn = document.getElementById("close-btn");

    // Open sidebar
    menuBtn.addEventListener("click", () => {
        sidebar.classList.remove("-translate-x-full");
        document.body.style.overflow = "hidden"; // prevent background scroll
    });

    // Close sidebar
    closeBtn.addEventListener("click", () => {
        sidebar.classList.add("-translate-x-full");
        document.body.style.overflow = "auto";
    });
</script>