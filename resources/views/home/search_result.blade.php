<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="app">
    <a href="/"> <img src="/images/logo.png" alt=""> </a>
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