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
        <form id="search" method="get" action="<?php echo route('home.search')?>">
            <?php echo csrf_field()?>
            <input type="text" name="s" id="s" value="<?php echo $search?>">
            <input type="submit" value="Tìm với google">
        </form>
    </div>
    <h3>{{$count}} kết quả tìm được</h3>
    <div id="result" class="container">
        @if(!isset($urls))
            <h4>Vui lòng nhập trường để tìm kiếm !!!</h4>
        @elseif (!($urls->count()))
            <div class="no-search-result">
                <p>Không tìm thấy <strong> <?php echo $search ?> </strong> trong bất kỳ tài liệu nào</p>
                <p>Đề Xuất :</p>
                <ul class="search-error">
                    <li>Xin bạn chắc chắn rằng tất cả các từ đều đúng chính tả.</li>
                    <li>Hãy thử những từ khóa khác.</li>
                    <li>Hãy thử những từ khóa chung hơn.</li>
                </ul>
            </div>
        @else
            <ul class="list-result">
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