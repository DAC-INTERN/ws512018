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
    <link rel="stylesheet" href="/css/custom.css">
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
</head>
<body>

<div class="app container-fluid">
    <div class="form-search">
        <a href="/"> <img src="/images/logo.png" alt=""> </a>
        <form id="search" method="post" action="<?php echo route('home.search')?>">
            <?php echo csrf_field()?>
            <input type="text" name="s" id="s" value="<?php echo $search?>">
            <input type="submit" value="Tìm với google">
        </form>
    </div>
    <div id="result" class="container">
        @if(empty($search))
            <h4>Vui lòng nhập trường để tìm kiếm !!!</h4>
        @elseif (Empty($urls))
            <p>Không tìm thấy kết quả trong tài liệu nào</p>
        @else
            <ul>
                <?php foreach ($urls as $urlModel): ?>
                <li>
                    <a href="{{$urlModel->url}}"><h5 class="title">{{ $urlModel->title }}</h5></a>
                    <p>{{$urlModel->description}}</p>
                </li>
                <?php endforeach ?>
            </ul>
        @endif
    </div>
</div>

</body>
</html>