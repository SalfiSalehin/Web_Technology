<?php
header("Content-Type: application/json");

$students = [
    [
        "name" => "Asif Rahman",
        "id" => "CSE101",
        "department" => "CSE",
        "cgpa" => 3.75
    ],
    [
        "name" => "Nusrat Jahan",
        "id" => "CSE102",
        "department" => "CSE",
        "cgpa" => 3.90
    ],
    [
        "name" => "Rakib Hasan",
        "id" => "EEE103",
        "department" => "EEE",
        "cgpa" => 3.60
    ]
];

echo json_encode($students);
?>