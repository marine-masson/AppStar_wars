<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Star Wars</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--<link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">-->
    <link href='https://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo url('assets/css/normalize.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo url('assets/css/skeleton.css'); ?>"/>

    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>
<header>
    <nav>
        <h1><a href="<?php url('index')?>"><img src="../../assets/images/logo.png" alt=""/></a></h1>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li><a href="<?php echo url('category', $category->id) ?>"><?php echo $category->title; ?></a></li>
            <?php endforeach; ?>
            <li><a href="<?php url('cart') ?>">| <i class="fa fa-shopping-cart"></i></a></li>
        </ul>
    </nav>
</header>
<div class="container">
    <div class="row">
        <div class="four-half column" style="margin-top: 5%;">
            <?php echo $content ?>
        </div>
    </div>
</div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
