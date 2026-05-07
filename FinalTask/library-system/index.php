<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>University Library Management System</title>
</head>
<body>

<h1>University Library Management System</h1>
<hr>

<!-- =====================================================
     ADD / EDIT FORM
====================================================== -->
<h2 id="form-title">Add New Book</h2>

<form id="book-form">
    <input type="hidden" id="book-id" name="id" value="" />

    <label>Title:</label><br>
    <input type="text" id="book-title" name="title" size="40" required /><br><br>

    <label>Author:</label><br>
    <input type="text" id="book-author" name="author" size="40" required /><br><br>

    <label>Category:</label><br>
    <input type="text" id="book-category" name="category" size="40" required /><br><br>

    <label>Status:</label><br>
    <select id="book-status" name="status">
        <option value="Available">Available</option>
        <option value="Checked Out">Checked Out</option>
        <option value="Reserved">Reserved</option>
        <option value="Lost">Lost</option>
    </select><br><br>

    <button type="submit" id="submit-btn">Add Book</button>
    <button type="button" id="cancel-btn" onclick="resetForm()" style="display:none;">Cancel</button>
</form>

<p id="form-message"></p>

<hr>

<!-- =====================================================
     BOOKS TABLE
====================================================== -->
<h2>All Books</h2>

<p id="loading-msg">Loading books...</p>

<table id="books-table" border="1" cellpadding="6" cellspacing="0" style="display:none;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="books-tbody">
    </tbody>
</table>

<p id="no-books-msg" style="display:none;">No books found.</p>

<!-- =====================================================
     JAVASCRIPT — AJAX Layer
====================================================== -->
<script>

// ── Helper: send an AJAX GET request ─────────────────────────
function ajaxGet(action, params, callback) {
    var url = 'ajax_handler.php?action=' + action;
    for (var key in params) {
        url += '&' + key + '=' + encodeURIComponent(params[key]);
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            callback(JSON.parse(xhr.responseText));
        }
    };
    xhr.send();
}

// ── Helper: send an AJAX POST request ────────────────────────
function ajaxPost(action, data, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax_handler.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            callback(JSON.parse(xhr.responseText));
        }
    };

    // Build POST body string
    var body = 'action=' + encodeURIComponent(action);
    for (var key in data) {
        body += '&' + encodeURIComponent(key) + '=' + encodeURIComponent(data[key]);
    }
    xhr.send(body);
}

// ── Load and display all books ────────────────────────────────
function loadBooks() {
    document.getElementById('loading-msg').style.display = 'block';
    document.getElementById('books-table').style.display = 'none';
    document.getElementById('no-books-msg').style.display = 'none';

    ajaxGet('get_books', {}, function (result) {
        document.getElementById('loading-msg').style.display = 'none';

        if (!result.success) {
            alert('Error: ' + result.message);
            return;
        }

        var books = result.data;

        if (books.length === 0) {
            document.getElementById('no-books-msg').style.display = 'block';
            return;
        }

        var tbody = document.getElementById('books-tbody');
        tbody.innerHTML = '';

        for (var i = 0; i < books.length; i++) {
            var b = books[i];
            var row = '<tr>' +
                '<td>' + b.id + '</td>' +
                '<td>' + b.title + '</td>' +
                '<td>' + b.author + '</td>' +
                '<td>' + b.category + '</td>' +
                '<td>' + b.status + '</td>' +
                '<td>' +
                    '<button onclick="startEdit(' + b.id + ')">Edit</button> ' +
                    '<button onclick="deleteBook(' + b.id + ', \'' + b.title.replace(/'/g, "\\'") + '\')">Delete</button>' +
                '</td>' +
            '</tr>';
            tbody.innerHTML += row;
        }

        document.getElementById('books-table').style.display = 'table';
    });
}

// ── Handle form submit (Add or Update) ───────────────────────
document.getElementById('book-form').onsubmit = function (e) {
    e.preventDefault();

    var id       = document.getElementById('book-id').value;
    var title    = document.getElementById('book-title').value.trim();
    var author   = document.getElementById('book-author').value.trim();
    var category = document.getElementById('book-category').value.trim();
    var status   = document.getElementById('book-status').value;

    if (!title || !author || !category) {
        document.getElementById('form-message').innerText = 'Please fill in all fields.';
        return;
    }

    var action = id ? 'update_book' : 'add_book';
    var data   = { id: id, title: title, author: author, category: category, status: status };

    ajaxPost(action, data, function (result) {
        document.getElementById('form-message').innerText = result.message;
        if (result.success) {
            resetForm();
            loadBooks();
        }
    });
};

// ── Load one book into the form for editing ───────────────────
function startEdit(id) {
    ajaxGet('get_book', { id: id }, function (result) {
        if (!result.success) {
            alert(result.message);
            return;
        }
        var b = result.data;

        document.getElementById('book-id').value       = b.id;
        document.getElementById('book-title').value    = b.title;
        document.getElementById('book-author').value   = b.author;
        document.getElementById('book-category').value = b.category;
        document.getElementById('book-status').value   = b.status;

        document.getElementById('form-title').innerText      = 'Edit Book';
        document.getElementById('submit-btn').innerText      = 'Save Changes';
        document.getElementById('cancel-btn').style.display  = 'inline';
        document.getElementById('form-message').innerText    = '';
    });
}

// ── Delete a book ─────────────────────────────────────────────
function deleteBook(id, title) {
    if (!confirm('Delete "' + title + '"? This cannot be undone.')) return;

    ajaxPost('delete_book', { id: id }, function (result) {
        alert(result.message);
        if (result.success) {
            loadBooks();
        }
    });
}

// ── Reset form back to Add mode ───────────────────────────────
function resetForm() {
    document.getElementById('book-form').reset();
    document.getElementById('book-id').value             = '';
    document.getElementById('form-title').innerText      = 'Add New Book';
    document.getElementById('submit-btn').innerText      = 'Add Book';
    document.getElementById('cancel-btn').style.display  = 'none';
    document.getElementById('form-message').innerText    = '';
}

// ── Load books on page ready ──────────────────────────────────
window.onload = function () {
    loadBooks();
};

</script>

</body>
</html>
