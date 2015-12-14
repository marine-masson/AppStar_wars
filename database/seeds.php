<?php

$pdo = new PDO('mysql:host=localhost;dbname=db_starwars', 'yoda', 'yoda');


$pdo->query("INSERT INTO categories (title) VALUES ('goodies')");
$pdo->query("INSERT INTO categories (title) VALUES ('vetements')");
$pdo->query("INSERT INTO categories (title) VALUES ('high tech')");
$pdo->query("INSERT INTO categories (title) VALUES ('jouets')");

$pdo->query("INSERT INTO tags (name) VALUES ('galaxy'), ('star'), ('jedi')");
$pdo->query("INSERT INTO categories (title, description) VALUES ('armes', 'armes de l\'univers Star wars),('équipement', 'équipements de l\'univers Star wars')");
$pdo->query("INSERT INTO products (title, category_id, abstract, price, published_at) VALUES ('Sabre Laser', 4,'Le sabre laser est une arme principalement utilisée par les Jedi et les Sith.', '99,99', '17-11-2015')");
$pdo->query("INSERT INTO products (title, category_id, abstract, price, published_at) VALUES ('Sweat-Shirt Chewbacca', 2,'Idéal pour l\'hiver', '59,99', '17-11-2015')");
$pdo->query("INSERT INTO products (title, category_id, abstract, price, published_at) VALUES ('Enceinte Étoile de la mort ', 3, 'Bluetooth !!', '60,00', '20-11-2015')");
$pdo->query("INSERT INTO products (title, category_id, abstract, price, published_at) VALUES ('Un lit Star Wars ', 1,'« Chasseur Jedi »', '9000,00', '22-11-2015')");
$pdo->query("INSERT INTO images (product_id, uri) VALUES ('3', 'enceinte.jpg')");
$pdo->query("INSERT INTO images (product_id, uri) VALUES ('2', 'veste.jpg')");
$pdo->query("INSERT INTO images (product_id, uri) VALUES ('4', 'lit.jpg')");
$pdo->query("INSERT INTO images (product_id, uri) VALUES ('1', 'sabre.jpg')");
$pdo->query("INSERT INTO tags (name) VALUES ('équipements')");



$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('4','2')");
$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('4','1')");
$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('1','1')");
