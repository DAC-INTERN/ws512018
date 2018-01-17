<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="app">
    <img src="/images/logo.png" alt="">
    <form id="search" method="post" action="<?php echo route('home.search')?>">
        <?php echo csrf_field()?>
        <input type="text" name="s" id="s">
        <input type="submit" value="Tìm với google">
    </form>
</div>

</body>
</html>