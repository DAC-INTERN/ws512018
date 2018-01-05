<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<div class="app">
    <img src="/images/logo.png" alt="">
    <form id="search" method="post" action="<?php echo route('home.search')?>">
        <?php echo csrf_field()?>
        <input type="text" name="s" id="s">
        <input type="submit" value="Search"></input>
    </form>

    <div id="result">
        <?php if (isset($urls)): ?>
        <ul>
            <?php foreach ($urls as $urlModel): ?>
            <li>
                <a href="{{$urlModel->url}}"><h3 class="title">{{ $urlModel->title }}</h3></a>
                <p>{{$urlModel->description}}</p>
            </li>
            <?php endforeach ?>
        </ul>
        <?php endif?>
    </div>
</div>

</body>
</html>