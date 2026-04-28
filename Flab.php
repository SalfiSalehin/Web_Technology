<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<form method="get">
        Enter student name:
        <input type="text" name="student_name">
        <input type="submit" value="Submit">
    </form>

<?php

$student_marks = array(90, 41, 45, 86, 33);

foreach ($student_marks as $value){
    echo $value . "<br>";
}

$total = 0;
$max = $student_marks[0];
$min = $student_marks[0];
$pass = 0;
$fail = 0;

foreach($student_marks as $value){
    $total += $value;

    if($value > $max){
        $max = $value;
    }
    if($value < $min){
        $min = $value;
    }
    if($value >= 50){
        $pass++;
    }
    else{
        $fail++;
    }
}

$avg = (float)$total / count($student_marks);

echo "<br> Total:  $total";
echo "<br> Average:  $avg";
echo "<br> Max:  $max";
echo "<br> Min:  $min";
echo "<br> Pass:  $pass";
echo "<br> Fail:  $fail";

$student = [
    "name" => "Salfi",
    "id" => "23-54120-3",
    "cgpa" => 3.8 
];

echo "<br><br> Student Info :<br>";
foreach($student as $key => $value){
    echo "$key : $value <br>";
}

sort($student_marks);
echo "<br>Sorted Marks:<br>";
foreach ($student_marks as $m) {
    echo $m. "<br>";
}

echo "<br>";
echo "Uppercase Name: " . strtoupper($student['name'])."<br>";
echo "Name Length: " . strlen($student['name']) . "<br>";

if (isset($_GET["student_name"]) && $_GET["student_name"] != "") {
            echo "Student name entered: " . $_GET["student_name"];
        } else {
            echo "No student name entered.";
        }

?>
    
</body>
</html>