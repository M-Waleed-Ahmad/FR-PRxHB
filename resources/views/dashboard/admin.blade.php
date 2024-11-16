<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .container h1 {
            font-size: 2.5rem;
            color: #343a40;
        }
        section {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none; /* Hide sections by default */
        }
        #user-management {
            display: block; /* Show user-management section initially */
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#user-management" data-section="user-management">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#category-management" data-section="category-management">Manage Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#book-management" data-section="book-management">Manage Books</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button class="nav-link text-danger" id="logout">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Admin Dashboard</h1>

        <!-- User Management Section -->
        <section id="user-management">
            <h2>Manage Users</h2>
            <div class="mb-3">
                <input type="text" id="search-users" class="form-control" placeholder="Search Users">
                <button id="user-search-button" class="btn btn-primary mt-2">Search</button>
            </div>
            <button id="add-user" class="btn btn-success mb-3">Add User</button>
            <table class="table table-striped" id="users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>

        <!-- Category Management Section -->
        <section id="category-management">
            <h2>Manage Categories</h2>
            <div class="mb-3">
                <input type="text" id="search-categories" class="form-control" placeholder="Search Categories">
                <button id="category-search-button" class="btn btn-primary mt-2">Search</button>
            </div>
            <button id="add-category" class="btn btn-success mb-3">Add Category</button>
            <table class="table table-striped" id="categories-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>

        <!-- Book Management Section -->
        <section id="book-management">
            <h2>Manage Books</h2>
            <div class="mb-3">
                <input type="text" id="search-books" class="form-control" placeholder="Search Books">
                <button id="book-search-button" class="btn btn-primary mt-2">Search</button>
            </div>
            <button id="add-book" class="btn btn-success mb-3">Add Book</button>
            <table class="table table-striped" id="books-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Handle navbar clicks
            $('.nav-link').on('click', function (e) {
                e.preventDefault();

                // Get the section ID to show
                const sectionToShow = $(this).data('section');

                // Hide all sections and show the selected one
                $('section').hide();
                $(`#${sectionToShow}`).fadeIn();

                // Update the active link
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
</body>
</html>

<!-- User Modal -->
<div class="modal fade" id="user-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="user-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="user-id">
                    <div class="mb-3">
                        <label for="user-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="user-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="user-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="user-email" required>
                    </div>
                    <div class="mb-3">
                        <label for="user-type" class="form-label">Type</label>
                        <select class="form-control" id="user-type" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="mb-3" id="password-field">
                        <label for="user-password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="user-password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="edit-user-modal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edit-user-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-user-id">
                    <div class="mb-3">
                        <label for="edit-user-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit-user-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-user-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit-user-email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-user-type" class="form-label">Type</label>
                        <select class="form-control" id="edit-user-type" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="category-modal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="category-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="category-id">
                    <div class="mb-3">
                        <label for="category-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="category-name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="edit-category-modal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edit-category-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-category-id">
                    <div class="mb-3">
                        <label for="edit-category-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit-category-name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Book Modal -->
<div class="modal fade" id="book-modal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="book-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookModalLabel">Add Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="book-id">
                    <div class="mb-3">
                        <label for="book-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="book-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="book-category" class="form-label">Category</label>
                        <select class="form-control" id="book-category" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="book-price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="book-price" required>
                    </div>
                    <div class="mb-3">
                        <label for="book-description" class="form-label">Description</label>
                        <textarea class="form-control" id="book-description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Book</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Book Modal -->
<div class="modal fade" id="edit-book-modal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edit-book-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookModalLabel">Edit Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-book-id">
                    <div class="mb-3">
                        <label for="edit-book-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit-book-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-book-category" class="form-label">Category</label>
                        <select class="form-control" id="edit-book-category" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-book-price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit-book-price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-book-description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit-book-description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
         // Open User Modal
        //  $("#add-user").click(function () {
        //         $("#user-modal").modal('show');
        //     });

            // Open Category Modal
            $("#add-category").click(function () {
                $("#category-modal").modal('show');
            });

            // Open Book Modal
            $("#add-book").click(function () {
                $("#book-modal").modal('show');
            });
    $(document).ready(function () {
        // Set up CSRF Token for AJAX
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        // Users AJAX
        const userTable = "#users-table tbody";

        function fetchUsers() {
            $.get('/admin/users', function (users) {
                $(userTable).html(users.map(user => `
                    <tr>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.type}</td>
                        <td>
                            <button onclick="editUser(${user.id})" class="btn btn-warning btn-sm">Edit</button>
                            <button onclick="deleteUser(${user.id})" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                `).join(""));
            });
        }

        fetchUsers();

        $("#user-search-button").on("click", function () {
            const query = $("#search-users").val();
            $.get(`/admin/users/search/${query}`, function (users) {
                $(userTable).html(users.map(user => `
                    <tr>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.type}</td>
                        <td>
                            <button onclick="editUser(${user.id})" class="btn btn-warning btn-sm">Edit</button>
                            <button onclick="deleteUser(${user.id})" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                `).join(""));
            });
        });

        // Open User Modal
        $("#add-user").click(function () {
            $("#user-modal").modal('show');
            // $("#user-form")[0].reset();
            $("#user-id").val('');
            $("#password-field").show();
        });

        // Save User
        $("#user-form").submit(function (e) {
            e.preventDefault();
            const id = $("#user-id").val();
            const url = id ? `/admin/users/${id}` : '/admin/users';
            const method = id ? 'PUT' : 'POST';
            const data = {
                name: $("#user-name").val(),
                email: $("#user-email").val(),
                type: $("#user-type").val(),
                password: $("#user-password").val()
            };

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function () {
                    $("#user-modal").modal('hide');
                    fetchUsers();
                }
            });
        });

        // Edit User
        window.editUser = function (id) {
            $.get(`/admin/users/${id}`, function (user) {
                $("#edit-user-id").val(user.id);
                $("#edit-user-name").val(user.name);
                $("#edit-user-email").val(user.email);
                $("#edit-user-type").val(user.type);
                // $("#password-field").val(user.password);
                $("#edit-user-modal").modal('show');
            });
        };

        $("#edit-user-form").submit(function (e) {
            e.preventDefault();
            const id = $("#edit-user-id").val();
            console.log(id);
            const url = `/admin/users/${id}`;
            const method = 'PUT';
            const data = {
                name: $("#edit-user-name").val(),
                email: $("#edit-user-email").val(),
                type: $("#edit-user-type").val()
            };

            console.log(data);
            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function () {
                    $("#edit-user-modal").modal('hide');
                    fetchUsers();
                }
            });
        });
        // Delete User
        window.deleteUser = function (id) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: `/admin/users/${id}`,
                    method: 'DELETE',
                    success: function () {
                        fetchUsers();
                    }
                });
            }
        };
    });
    let categoriesd;
    // Categories AJAX
    const categoryTable = "#categories-table tbody";
    
    function fetchCategories() {
        $.get('/admin/categories', function (categories) {
            categoriesd=categories;
        $(categoryTable).html(categories.map(category => `
            <tr>
            <td>${category.name}</td>
            <td>
                <button onclick="editCategory(${category.id})" class="btn btn-warning btn-sm">Edit</button>
                <button onclick="deleteCategory(${category.id})" class="btn btn-danger btn-sm">Delete</button>
            </td>
            </tr>
        `).join(""));
        });
    }

    fetchCategories();

    $('#category-search-button').on('click', function () {
        const query = $('#search-categories').val();  // Get the value from input field
        console.log(query, "query");
        // Make the GET request to search for categories
        $.get(`/admin/categories/search/${query}`, function (categories) {
            console.log(categories, "categories");
            
            // Render the categories into the table
            $('#categories-table').html(categories.map(category => `
                <tr>
                    <td>${category.name}</td>
                    <td>
                        <button onclick="editCategory(${category.id})" class="btn btn-warning btn-sm">Edit</button>
                        <button onclick="deleteCategory(${category.id})" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            `).join(""));
        }).fail(function() {
            alert("An error occurred while searching.");
        });
    });
   
    // Open Category Modal
    $("#add-category").click(function () {
        $("#category-modal").modal('show');
        $("#category-form")[0].reset();
        $("#category-id").val('');
    });

    // Save Category
    $("#category-form").submit(function (e) {
        e.preventDefault();
        const id = $("#category-id").val();
        const url = id ? `/admin/categories/${id}` : '/admin/categories';
        const method = id ? 'PUT' : 'POST';
        const data = {
        name: $("#category-name").val()
        };

        $.ajax({
        url: url,
        method: method,
        data: data,
        success: function () {
            $("#category-modal").modal('hide');
            fetchCategories();
        }
        });
    });

    // Edit Category
    window.editCategory = function (id) {
        $.get(`/admin/categories/${id}`, function (category) {
        $("#edit-category-id").val(category.id);
        $("#edit-category-name").val(category.name);
        $("#edit-category-modal").modal('show');
        console.log(category);
        });
    };
    $("#edit-category-form").submit(function (e) {
        e.preventDefault();
        const id = $("#edit-category-id").val();
        const url = `/admin/categories/${id}`;
        const method = 'PUT';
        const data = {
        name: $("#edit-category-name").val()
        };
        console.log(data);
        $.ajax({
        url: url,
        method: method,
        data: data,
        success: function () {
            $("#edit-category-modal").modal('hide');
            fetchCategories();
        }
        });
    });

    // Delete Category
    window.deleteCategory = function (id) {
        if (confirm('Are you sure you want to delete this category?')) {
        $.ajax({
            url: `/admin/categories/${id}`,
            method: 'DELETE',
            success: function () {
            fetchCategories();
            }
        });
        }
    };
    // Books AJAX
    const bookTable = "#books-table tbody";

    function fetchBooks() {
        $.get('/admin/books', function (books) {
            $(bookTable).html(books.map(book => `
                <tr>
                    <td>${book.title}</td>
                    <td>${book.category.name}</td>
                    <td>${book.price}</td>
                    <td>
                        <button onclick="editBook(${book.id})" class="btn btn-warning btn-sm">Edit</button>
                        <button onclick="deleteBook(${book.id})" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            `).join(""));
        });
    }

    fetchBooks();


    // Open Book Modal
    $("#add-book").click(function () {
        $("#book-modal").modal('show');
        $("#book-form")[0].reset();
        $("#book-id").val('');
    });

    $('#book-search-button').on('click', function () {
        const query = $('#search-books').val();  // Get the value from input field
        console.log(query, "query");
        // Make the GET request to search for books
        $.get(`/admin/books/search/${query}`, function (books) {
            console.log(books, "books");
            
            // Render the books into the table
            $('#books-table').html(books.map(book => `
                <tr>
                    <td>${book.title}</td>
                    <td>${book.category}</td>
                    <td>${book.price}</td>
                    <td>
                        <button onclick="editBook(${book.id})" class="btn btn-warning btn-sm">Edit</button>
                        <button onclick="deleteBook(${book.id})" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            `).join(""));
        }).fail(function() {
            alert("An error occurred while searching.");
        });
    });
    // Save Book
    $("#book-form").submit(function (e) {
        e.preventDefault();
        const id = $("#book-id").val();
        const url = id ? `/admin/books/${id}` : '/admin/books';
        const method = id ? 'PUT' : 'POST';
        const data = {
            title: $("#book-title").val(),
            category_id: $("#book-category").val(),
            price: $("#book-price").val(),
            description: $("#book-description").val()
        };

        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function () {
                $("#book-modal").modal('hide');
                fetchBooks();
            }
        });
    });

    // Edit Book
    window.editBook = function (id) {
        $.get(`/admin/books/${id}`, function (book) {
            $("#edit-book-id").val(book.id);
            $("#edit-book-title").val(book.title);
            $("#edit-book-category").val(book.category);
            $("#edit-book-price").val(book.price);
            $("#edit-book-description").val(book.description);
            $("#edit-book-modal").modal('show');
        });
    };
    $("#edit-book-form").submit(function (e) {
        e.preventDefault();
        const id = $("#edit-book-id").val();
        const url = `/admin/books/${id}`;
        const method = 'PUT';
        const data = {
            title: $("#edit-book-title").val(),
            category: $("#edit-book-category").val(),
            price: $("#edit-book-price").val(),
            description: $("#edit-book-description").val()
        };

        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function () {
                $("#edit-book-modal").modal('hide');
                fetchBooks();
            }
        });
    });

    // Delete Book
    window.deleteBook = function (id) {
        if (confirm('Are you sure you want to delete this book?')) {
            $.ajax({
                url: `/admin/books/${id}`,
                method: 'DELETE',
                success: function () {
                    fetchBooks();
                }
            });
        }
    };
    

    $('#logout').on('click', function () {
        // Send the POST request for logout
        $.ajax({
            url: '/logout',  // Your logout route
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')  // Add CSRF token to the request
            },
            success: function (response) {
                // Redirect or perform actions on successful logout
                window.location.href = '/login';  // Redirect to login page
            },
            error: function (xhr, status, error) {
                // Handle errors (optional)
                console.error("Logout error: " + error);
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>
