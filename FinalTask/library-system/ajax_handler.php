<?php
// ajax_handler.php — Single AJAX entry point

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/controller/BookController.php';

$action = trim($_REQUEST['action'] ?? '');

switch ($action) {
    case 'get_books':
        controller_get_books();
        break;

    case 'get_book':
        controller_get_book();
        break;

    case 'add_book':
        controller_add_book();
        break;

    case 'update_book':
        controller_update_book();
        break;

    case 'delete_book':
        controller_delete_book();
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Unknown action.']);
        break;
}
