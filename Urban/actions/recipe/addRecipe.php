<?php

include ("../../inc/db.php");
//include ("../../inc/checked_logged_in.php");

$user_id = $_POST['user_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$cooktime = $_POST['cooktime'];
$price = $_POST['price'];
//$image = $_POST['image'];
$origin_id = $_POST['origin_id'];
//$type_id = $_POST['type_id'];

echo "Title : $title <br>";
echo "Description : $description<br>";
echo "Cooking time : $cooktime <br>";
echo "Price :  $price <br>";
echo "Origins_id : $origin_id <br>";
//  echo "Type_id : $type_id  <br>";
//echo "Ratings_id : $ratings <br>";
/* UPLOAD IMAGE */
$uploaddir = '../../img/recipe/';
$uploadfile = $uploaddir . basename($_FILES['image']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}

$stmt = $db->prepare("INSERT INTO "
        . "recipes (title, description, cooktime, price, image, origin_id) "
        . "VALUES "
        . "(:title, :description, :cooktime, :price, :image, :origin_id)");

$stmt->bindValue(":title", $title);
$stmt->bindValue(":description", $description);
$stmt->bindValue(":cooktime", $cooktime);
$stmt->bindValue(":price", $price);
$stmt->bindValue(":image", $_FILES['image']['name']);
$stmt->bindValue(":origin_id", $origin_id);

$stmt->execute();

echo "Title : $title <br>";

$stmt = $db->prepare("SELECT * FROM recipes WHERE title='$title'");
$stmt->execute();
$recipe = $stmt->fetchObject();


echo "$recipe->recipe_id";


echo "Complete";
