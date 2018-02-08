<!DOCTYPE html>
<html lang="en" xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
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
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.3.5"></script>
</head>
<body>

<div class="app container-fluid">
    <a href="/"> <img src="/images/logo.png" alt=""> </a>
    <form id="search" method="get" action="<?php echo route('home.search'); ?>">
<!--        --><?php //echo csrf_field()?>
        <input type="text" name="s" id="s" value="<?php echo $search?>" v-on:keyup.space="predict()" list="list">
        <datalist v-show="isShowPredict" id="list">
            <option  v-for="result in results" id="text_predict" v-bind:value="result"></option>
        </datalist>
        <input type="submit" value="Tìm với google" >
    </form>
</div>
<script src="/js/custom.js"></script>
</body>
</html>