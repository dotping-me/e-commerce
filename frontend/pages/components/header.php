<header class="fixed top-0 left-0 w-full z-50 shadow-2xl rounded-b-2xl backdrop-blur-md bg-white/30 
    hover:bg-gray-700 hover:text-gray-200 transition-colors duration-300 animate-slide-down">
    <nav class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <!-- Left Search bar -->
            <form class="flex-1 flex items-center" method="GET" action="/catalog">
                <div class="relative w-62">
                    <input
                        type="text"
                        placeholder="Search product here..."
                        class="w-full pl-4 pr-10 py-2 rounded-full shadow-xl backdrop-blur-2xl hover:text-gray-200 placeholder-gray-400 transition-colors duration-300 focus:outline-none focus:ring-2 hover:bg-gray-800"
                        name="prodName"
                        id="prodName"
                    >

                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-200 transition-colors duration-300">
                        <img src="/assets/icons/search.svg" class="w-5 h-5">
                    </button>
                </div>
            </form>

            <!-- Center Navigation links -->
            <div class="w-fit flex flex-1 space-x-8 justify-center items-end">
                <!-- <h1 class="text-xl font-bold">Shop.</h1> -->

                <a href="/" class="links">Home</a>
                <a href="/catalog" class="links">Catalog</a>
                <a href="#" class="links">About Us</a>
            </div>

            <!-- Right User & Cart -->
            <div class="flex items-center space-x-2">

                <?php if (isset($_SESSION['user'])): ?>

                    <?php if (!empty($_SESSION['user']['isAdmin'])): ?>

                        <!-- Admin Logged in -->
                        <a href="/dashboard" class="nav-icons">
                            <img class="icon" src="/assets/icons/admin.svg">
                        </a>

                    <?php endif; ?>

                    <!-- Logout button -->
                    <a href="#" class="nav-icons">
                        <img id="logout-icon" class="icon" src="/assets/icons/logout.svg">
                    </a>

                <?php else: ?>

                    <!-- Not logged in -->
                    <a href="/signup" class="nav-icons">
                        <img class="icon" src="/assets/icons/user.svg" alt="User">
                    </a>

                <?php endif; ?>

                <!-- Cart icon -->
                <a href="/cart" class="nav-icons">
                    <img class="icon" src="/assets/icons/cart.svg" alt="Cart">
                </a>
            </div>
        </div>
    </nav>
</header>

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
</script>