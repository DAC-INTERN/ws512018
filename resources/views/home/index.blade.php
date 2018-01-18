<!DOCTYPE html>
<html lang="en" xmlns:v-on="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">

    <title>Trang chủ</title>
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/my_style.css">
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
</head>
<body>

<div class="app container-fluid">
    <a href="/"> <img src="/images/logo.png" alt=""> </a>
    <form id="search" method="post" action="<?php echo route('home.search'); ?>" >
        <?php echo csrf_field()?>
        <input type="text" name="s" id="s">
        <input type="submit" value="Tìm với google">
    </form>
</div>
<script src="/js/custom.js"></script>
</body>
</html>