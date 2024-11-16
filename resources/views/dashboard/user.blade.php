
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
        section {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        table th {
            background-color: #f1f1f1;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">User Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#browse-books" data-section="browse-books">Browse Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#view-orders" data-section="view-orders">View Orders</a>
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
        <h1 class="text-center mb-4">Welcome to Your Dashboard</h1>

        <!-- Browse Books Section -->
        <section id="browse-books">
            <h2>Browse Books</h2>
            <div class="mb-3">
                <label for="filter-category" class="form-label">Filter by Category</label>
                <select id="filter-category" class="form-control">
                    <option value="all">All Categories</option>
                </select>
            </div>
            <div id="books-list">
                <!-- Books will be dynamically loaded here -->
            </div>
        </section>

        <!-- View Orders Section -->
        <section id="view-orders" style="display: none;">
            <h2>Your Orders</h2>
            <table class="table table-striped" id="orders-table">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Orders will be dynamically loaded here -->
                </tbody>
            </table>
        </section>
    </div>

    <!-- Order Modal -->
    <div class="modal" id="order-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Place Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="order-form">
                        <input type="hidden" id="order-book-id">
                        <div class="mb-3">
                            <label for="order-book-title" class="form-label">Book Title</label>
                            <input type="text" id="order-book-title" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="order-quantity" class="form-label">Quantity</label>
                            <input type="number" id="order-quantity" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {

        // Handle navigation between sections   
        $('.nav-link').click(function(e) {
            e.preventDefault();
            var sectionId = $(this).data('section');
            
            // Hide all sections
            $('section').hide();
            
            // Show the selected section
            $('#' + sectionId).show();
            
            // Update active class on navbar
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });
        // Fetch categories on page load
            $.ajax({
                url: '/categories',
                method: 'GET',
                success: function(response) {
                    var categories = response;
                    console.log('Fetched categories:', categories);
                    var categorySelect = $('#filter-category');
                    categories.forEach(function(category) {
                        categorySelect.append('<option value="' + category.id + '">' + category.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching categories:', error);
                }
            });
        });
        // Fetch books based on selected category
        $('#filter-category').change(function() {
            var categoryId = $(this).val();
            $.ajax({
            url: `/book/category/${categoryId}`, // Dynamically inject the categoryId into the URL
            method: 'GET',
            success: function(response) {
                // Access the 'books' property in the response object
                var books = response.books;
                console.log('Fetched books:', books);

                var booksList = $('#books-list');
                booksList.empty();

                if (books.length > 0) {
                    books.forEach(function(book) {
                        booksList.append(
                            '<div class="card mb-3">' +
                                '<div class="card-body d-flex justify-content-between">' +
                                    '<div>' +
                                        '<h5 class="card-title">' + book.title + '</h5>' +
                                        '<p class="card-text">Category: ' + book.category.name + '</p>' +
                                        '<p class="card-text">Price: $' + book.price + '</p>' +
                                        '<p class="card-text">Description: ' + book.description + '</p>' +
                                    '</div>' +
                                    '<div>' +
                                        '<button class="btn btn-primary order-book" data-book-id="' + book.id + '">Order</button>' +
                                    '</div>' +
                                '</div>' +
                            '</div>'
                        );
                    });
                } else {
                    booksList.append('<p>No books available in this category.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching books:', error);
                $('#books-list').html('<p class="text-danger">Failed to fetch books. Please try again.</p>');
            }
        });

        // Open order modal when "Order" button is clicked
        $(document).on('click', '.order-book', function() {
            var bookId = $(this).data('book-id');
            var bookTitle = $(this).closest('.card-body').find('.card-title').text();

            $('#order-book-id').val(bookId);
            $('#order-book-title').val(bookTitle);
            $('#order-modal').modal('show');
        });

        // Handle order form submission
        $('#order-form').submit(function(e) {
            e.preventDefault();

            var bookId = $('#order-book-id').val();
            var quantity = $('#order-quantity').val();
            var userId = '{{ auth()->user()->id }}'; // Get the authenticated user's ID
            console.log('Placing order for book ID:', bookId, 'Quantity:', quantity, 'User ID:', userId);
            $.ajax({
            url: '/order',
            method: 'POST',
            data: {
                book_id: bookId,
                user_id: userId,
                quantity: quantity,
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {
                console.log('Order placed successfully:', response);
                $('#order-modal').modal('hide');
                alert('Order placed successfully!');
            },
            error: function(xhr, status, error) {
                console.error('Error placing order:', error);
                alert('Failed to place order. Please try again.');
            }
            });
        });
    });
    // Fetch orders on page load
    $.ajax({
    url: '/order',
    method: 'GET',
    success: function(response) {
        var orders = response.orders;
        console.log('Fetched orders:', orders);

        var ordersTableBody = $('#orders-table tbody');
        ordersTableBody.empty(); // Clear previous content

        if (orders.length > 0) {
            orders.forEach(function(order) {
                var book = order.book || {}; // Safeguard against missing book data

                ordersTableBody.append(
                    '<tr>' +
                        '<td>' + (book.title || 'Unknown Title') + '</td>' +
                        '<td>' + order.quantity + '</td>' +
                        '<td>$' + ((book.price || 0) * order.quantity).toFixed(2) + '</td>' +
                        '<td><button class="btn btn-danger cancel-order" data-order-id="' + order.id + '">Cancel</button></td>' +
                    '</tr>'
                );
            });
        } else {
            ordersTableBody.append('<tr><td colspan="5" class="text-center">No orders found.</td></tr>');
        }
    },
    error: function(xhr, status, error) {
        console.error('Error fetching orders:', error);
        $('#orders-table tbody').html('<tr><td colspan="5" class="text-danger text-center">Failed to fetch orders. Please try again.</td></tr>');
    }
});

    // Handle order cancellation
    $(document).on('click', '.cancel-order', function() {
        var orderId = $(this).data('order-id');
        $.ajax({
            url: `/order/${orderId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {
                console.log('Order cancelled successfully:', response);
                alert('Order cancelled successfully!');
                location.reload(); // Reload the page to update the orders list
            },
            error: function(xhr, status, error) {
                console.error('Error cancelling order:', error);
                alert('Failed to cancel order. Please try again.');
            }
        });
    });

    // Handle logout
    $('#logout').click(function() {
    $.ajax({
        url: '/logout',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'), // Add CSRF token dynamically
        },
        success: function(response) {
            console.log('Logged out successfully:', response);
            alert('Logged out successfully!');
            window.location.href = '/'; // Redirect to the login page
        },
        error: function(xhr, status, error) {
            console.error('Error logging out:', error);
            alert('Failed to logout. Please try again.');
        }
    });
});




    </script>
</body>
</html>
