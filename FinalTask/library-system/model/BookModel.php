<?php
// model/BookModel.php — All database functions (Model layer)

require_once __DIR__ . '/../config/database.php';

// INSERT a new book
function model_create_book($title, $author, $category, $status) {
    $conn = get_db_connection();
    $sql  = "INSERT INTO books (title, author, category, status) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssss', $title, $author, $category, $status);

    if (mysqli_stmt_execute($stmt)) {
        $id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return ['success' => true, 'message' => 'Book added successfully.', 'id' => $id];
    }

    $err = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return ['success' => false, 'message' => 'Insert failed: ' . $err];
}

// SELECT all books
function model_get_all_books() {
    $conn   = get_db_connection();
    $result = mysqli_query($conn, "SELECT * FROM books ORDER BY id DESC");

    if (!$result) {
        mysqli_close($conn);
        return ['success' => false, 'data' => [], 'message' => 'Query failed.'];
    }

    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }

    mysqli_free_result($result);
    mysqli_close($conn);
    return ['success' => true, 'data' => $books, 'message' => 'OK'];
}

// SELECT one book by ID
function model_get_book_by_id($id) {
    $conn = get_db_connection();
    $sql  = "SELECT * FROM books WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $book   = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    if ($book) {
        return ['success' => true, 'data' => $book, 'message' => 'Found.'];
    }
    return ['success' => false, 'data' => null, 'message' => 'Book not found.'];
}

// UPDATE a book
function model_update_book($id, $title, $author, $category, $status) {
    $conn = get_db_connection();
    $sql  = "UPDATE books SET title=?, author=?, category=?, status=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssi', $title, $author, $category, $status, $id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return ['success' => true, 'message' => 'Book updated successfully.'];
    }

    $err = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return ['success' => false, 'message' => 'Update failed: ' . $err];
}

// DELETE a book
function model_delete_book($id) {
    $conn = get_db_connection();
    $sql  = "DELETE FROM books WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return ['success' => true, 'message' => 'Book deleted successfully.'];
    }

    $err = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return ['success' => false, 'message' => 'Delete failed: ' . $err];
}
