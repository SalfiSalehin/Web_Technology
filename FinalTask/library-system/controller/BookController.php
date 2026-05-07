<?php
// controller/BookController.php — Business logic (Controller layer)

require_once __DIR__ . '/../model/BookModel.php';

// Sanitise a text input
function clean($value) {
    return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
}

// Controller: Add book
function controller_add_book() {
    $title    = clean($_POST['title']    ?? '');
    $author   = clean($_POST['author']   ?? '');
    $category = clean($_POST['category'] ?? '');
    $status   = clean($_POST['status']   ?? 'Available');

    if ($title === '' || $author === '' || $category === '' || $status === '') {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        return;
    }

    echo json_encode(model_create_book($title, $author, $category, $status));
}

// Controller: Get all books
function controller_get_books() {
    echo json_encode(model_get_all_books());
}

// Controller: Get one book (for edit form)
function controller_get_book() {
    $id = (int)($_GET['id'] ?? 0);
    if ($id < 1) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID.']);
        return;
    }
    echo json_encode(model_get_book_by_id($id));
}

// Controller: Update book
function controller_update_book() {
    $id       = (int)($_POST['id']       ?? 0);
    $title    = clean($_POST['title']    ?? '');
    $author   = clean($_POST['author']   ?? '');
    $category = clean($_POST['category'] ?? '');
    $status   = clean($_POST['status']   ?? '');

    if ($id < 1 || $title === '' || $author === '' || $category === '' || $status === '') {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        return;
    }

    echo json_encode(model_update_book($id, $title, $author, $category, $status));
}

// Controller: Delete book
function controller_delete_book() {
    $id = (int)($_POST['id'] ?? 0);
    if ($id < 1) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID.']);
        return;
    }
    echo json_encode(model_delete_book($id));
}
