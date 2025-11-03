<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Admin Dashboard</title>

    <link href="/css/output.css" rel="stylesheet">
</head>

<body>
    <?php include("components/header.php"); ?>

    <section class="flex gap-2 p-4 mt-20 w-full mx-auto">

        <!-- Navigation (1/4 of width) -->
        <div class="bg-white w-64 p-4 rounded-2xl border border-gray-200 shadow-sm">
            <div class="mb-6 p-2 border-b-2 border-gray-200">
                <h1 class="text-xl font-semibold text-gray-900">Quick Links</h1>
            </div>
            
            <nav class="space-y-3">
                <a href="#users" class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 group">
                    <img class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" src="/assets/icons/user.svg" alt="Users">
                    <span class="font-medium text-gray-700 group-hover:text-gray-900">Users</span>
                </a>
                
                <a href="#categories" class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 group">
                    <img class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" src="/assets/icons/store.svg" alt="Categories">
                    <span class="font-medium text-gray-700 group-hover:text-gray-900">Categories</span>
                </a>
                
                <a href="#products" class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 group">
                    <img class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" src="/assets/icons/cart.svg" alt="Products">
                    <span class="font-medium text-gray-700 group-hover:text-gray-900">Products</span>
                </a>
            </nav>
        </div>

        <!-- Scrollable view of all data (the rest of width) -->
        <div class="flex-1 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm overflow-y-auto">
            
            <!-- Users -->
            <div id="users" class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-gray-200">Users</h1>
                <table id="users-table" class="w-full border-collapse">
                    <!-- Populated with JS -->
                </table>
            </div>

            <!-- Categories -->
            <div id="categories" class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-gray-200">Categories</h1>
            
                <!-- Add Category Form -->
                <form name="addCategoryForm" class="mb-8 h-fit flex gap-4">
                    <input 
                        name="categoryName" 
                        id="categoryName"
                        type="text" 
                        required 
                        placeholder="Category Name"
                        class="inline px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                    >
                    <input 
                        type="submit" 
                        value="Add"
                        class="px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer"
                    >
                </form>

                <table id="categories-table" class="w-full border-collapse">
                    <thead>
                        <th>Name</th>
                        <th>Actions</th>
                    </thead>

                    <tbody id="categories-table-body"></tbody>
                </table>
            </div>

            <!-- Products -->
            <div id="products">
                <h1 class="text-2xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-gray-200">Products</h1>
                <table id="products-table" class="w-full border-collapse">
                    <thead>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </thead>

                    <tbody id="products-table-body">
                        <!-- Populated with JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <?php include("components/footer.php"); ?>

    <script>
        const addCategoryForm = document.forms.addCategoryForm;
        const categoriesTable = document.getElementById("categories-table-body");
        const productsTable = document.getElementById("products-table-body");

        window.onload = () => {
            loadProducts();
        };

        // Populating Categories and Products tables
        function loadProducts() {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {

                    // Fills in table
                    const xml = xhr.responseXML;
                    const categories = xml.getElementsByTagName("category");
                    
                    for (let i = 0; i < categories.length; i++) {
                        let category = categories[i].getAttribute("name");
                        
                        const categoryRow = document.createElement("tr");
                        categoryRow.innerHTML = `
                            <td>${category}</td>
                            <td>
                                <button class="delete-btn" onclick="deleteThisCategory('${category}');">Delete</button>
                            </td>
                        `;

                        categoriesTable.appendChild(categoryRow);
                        // Fill in Categories table

                        // Fill in Products table
                        let products = categories[i].getElementsByTagName("product");
                        for (let j = 0; j < products.length; j++) {
                            let id = products[j].getAttribute("id");
                            let name = products[j].getElementsByTagName("name")[0].childNodes[0].nodeValue;

                            const productRow = document.createElement("tr");
                            productRow.innerHTML = `
                                <td>${id}</td>
                                <td>${category}</td>
                                <td><a href="/product/${id}" class="font-medium text-md text-blue-600 hover:underline">${name}</a></td>
                                <td class="flex items-center gap-1">
                                    <button class="edit-btn" onclick="window.location.href = '/product/${id}/edit'">Edit</button>
                                    <button class="delete-btn" onclick="deleteThisProduct('${id}');">Delete</button>
                                </td>
                            `;

                            productsTable.appendChild(productRow);
                        }
                    }
                }

                // Error for some reason
                else if ((xhr.readyState == 4) && (xhr.status != 200)) {

                }
            };

            xhr.open("GET", "/api/get_all_products.php", true);
            xhr.send();
        }

        // Handling Category form
        addCategoryForm.addEventListener("submit", (e) => {
            e.preventDefault();

            // Adds new row to table
        });

        function deleteThisCategory(categoryName) {

        }

        // Handling product deletion
        function deleteThisProduct(prodId) {

        }
    </script>
</body>
</html>