<?php
session_start();
if ((!isset($_SESSION["user"]["isAdmin"])) || ($_SESSION["user"]["isAdmin"] != "1")) {
    header("Location:/");
    exit();
}
?>

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

    <!-- Modal to show success/failure feedback -->
    <button id="toggle-modal-btn" data-target="status-modal" class="hidden" onclick="document.getElementById(this.dataset.target).classList.toggle('hidden')"></button>
    <div id="status-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">

                <!-- Button to close modal -->
                <div class="flex items-center justify-between p-2 border-b rounded-t border-gray-200 bg-white">
                    <button type="button" class="text-black/50 hover:text-black bg-white cursor-pointer rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-all" onclick="document.getElementById('toggle-modal-btn').click()">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>

                <div class="p-4 md:p-5">
                    <div id="status-message"></div>
                </div>
            </div>
        </div>
    </div>

    <section class="flex gap-2 p-4 mt-20 mb-8 w-full mx-auto">

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
                    <img class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" src="/assets/icons/category.svg" alt="Categories">
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
                    <thead>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </thead>

                    <tbody id="users-table-body">
                    <!-- Populated with JS -->
                    </tbody>
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
                <div class="w-full flex justify-between items-center pb-2 border-b-2 border-gray-200 mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Products</h1>
                    <button onclick="window.location.href = '/product/add'" class="h-10 px-4 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 cursor-pointer">Add</button>
                </div>
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

        const usersTable = document.getElementById("users-table-body");
        const categoriesTable = document.getElementById("categories-table-body");
        const productsTable = document.getElementById("products-table-body");
        
        const showModalBtn = document.getElementById("toggle-modal-btn");
        const modalStatusMessage = document.getElementById("status-message");

        window.onload = () => {
            loadProducts();
            loadUsers();
        };

        // Populating Categories and Products tables
        function loadProducts() {
            categoriesTable.innerHTML = "";
            productsTable.innerHTML = "";

            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {

                    // Fills in table
                    const xml = xhr.responseXML;
                    const categories = xml.getElementsByTagName("category");
                    
                    for (let i = 0; i < categories.length; i++) {
                        let category = categories[i].getAttribute("name");

                        // Fill in Categories table
                        const categoryRow = document.createElement("tr");
                        categoryRow.className = `cat-${category}`;
                        categoryRow.innerHTML = `
                            <td>${category}</td>
                            <td>
                                <button data-row="${i}" class="delete-btn" onclick="deleteThisCategory('${category}');">Delete</button>
                            </td>
                        `;

                        categoriesTable.appendChild(categoryRow);

                        // Fill in Products table
                        let products = categories[i].getElementsByTagName("product");
                        for (let j = 0; j < products.length; j++) {
                            let id = products[j].getAttribute("id");
                            let name = products[j].getElementsByTagName("name")[0].childNodes[0].nodeValue;

                            const productRow = document.createElement("tr");
                            productRow.className = `${id} prod-cat-${category}`;
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
            };

            xhr.open("GET", "/api/get_all_products.php", true);
            xhr.send();
        }

        // Handling Category form
        addCategoryForm.addEventListener("submit", (e) => {
            e.preventDefault();

            let categoryName = addCategoryForm.categoryName.value.trim();
            if (categoryName == "") {
                modalStatusMessage.innerHTML = `<h1 class="font-bold text-lg text-red-600">Error!</h1><p class="mb-4 text-red-500">Category Name cannot be empty!</p>`;
                showModalBtn.click();

                return;
            }

            // Submits form
            const payload = {
                categoryName: categoryName
            }

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/api/add_category.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    modalStatusMessage.innerHTML = `<h1 class="font-bold text-lg text-green-600">Success!</h1><p class="mb-4 text-green-600">Category added successfully!</p>`;
                    showModalBtn.click();

                    // Adds new row
                    let row = document.createElement("tr");
                    row.className = `cat-${categoryName}`;
                    row.innerHTML = `
                        <td>${categoryName}</td>
                        <td>
                            <button data-row="${document.querySelectorAll('#categories-table-body tr').length}" class="delete-btn" onclick="deleteThisCategory('${categoryName}');">Delete</button>
                        </td>
                    `;

                    categoriesTable.appendChild(row);
                }
            };
            
            xhr.send(JSON.stringify(payload));
        });

        function deleteThisCategory(categoryName) {
            const payload = {
                categoryName: categoryName
            };
            
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/api/delete_category.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    modalStatusMessage.innerHTML = `<h1 class="font-bold text-lg text-green-600">Success!</h1><p class="mb-4 text-green-600">Category deleted successfully!</p>`;
                    showModalBtn.click();

                    // Deletes the row
                    let categoryRow = document.getElementsByClassName(`cat-${categoryName}`)[0];
                    categoriesTable.removeChild(categoryRow);

                    // Removes all products with that category
                    let productsForThatCategory = document.querySelectorAll(`.prod-cat-${categoryName}`);
                    if (productsForThatCategory.length > 0) {
                        productsForThatCategory.forEach(row => {
                            productsTable.removeChild(row);
                        });
                    }
                }
            };
            
            xhr.send(JSON.stringify(payload));
        }

        // Handling product deletion
        function deleteThisProduct(prodId) {
            const payload = {
                prodId: prodId
            };
            
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/api/delete_product.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    modalStatusMessage.innerHTML = `<h1 class="font-bold text-lg text-green-600">Success!</h1><p class="mb-4 text-green-600">Product deleted successfully!</p>`;
                    showModalBtn.click();

                    // Deletes the row
                    let row = document.getElementsByClassName(prodId)[0];
                    productsTable.removeChild(row);
                }
            };
            
            xhr.send(JSON.stringify(payload));
        }

        // User
        function loadUsers() {
            usersTable.innerHTML = "";

            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {

                    // Fills in table
                    const xml = xhr.responseXML;
                    const users = xml.getElementsByTagName("user");
                    
                    for (let i = 0; i < users.length; i++) {
                        let email = users[i].getElementsByTagName("email")[0].childNodes[0].nodeValue;
                        let fullname = users[i].getElementsByTagName("lastName")[0].childNodes[0].nodeValue + " " + users[i].getElementsByTagName("firstName")[0].childNodes[0].nodeValue;
                        
                        let admin = "Normal";
                        if (users[i].getElementsByTagName("admin")[0].childNodes[0].nodeValue == "1") {
                            admin = "Admin";
                        }

                        const row = document.createElement("tr");
                        row.className = `user-${email}`;
                        row.innerHTML = `
                            <td>${email}</td>
                            <td>${fullname}</td>
                            <td>${admin}</td>
                            <td class="flex items-center gap-1">
                                <button class="edit-btn" onclick="changeRole('${email}', '1')">Promote</button>
                                <button class="delete-btn" onclick="changeRole('${email}', '0')">Demote</button>
                            </td>
                        `;

                        usersTable.appendChild(row);
                    }
                }
            };

            xhr.open("GET", "/api/get_all_users.php", true);
            xhr.send();
        }

        function changeRole(email, role) {
            const payload = {
                email: email,
                admin: role
            }

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/api/update_user_role.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let res = JSON.parse(xhr.responseText);

                    modalStatusMessage.innerHTML = `<h1 class="font-bold text-lg text-green-600">Success!</h1><p class="mb-4 text-green-600">${res.message || res.error}</p>`;
                    showModalBtn.click();

                    loadUsers(); // Reload users
                }
            };
            
            xhr.send(JSON.stringify(payload));
        }
    </script>
</body>
</html>