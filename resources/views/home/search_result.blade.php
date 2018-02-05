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
            <input type="text" name="s" id="s" value="<?php echo $search?>"
                   v-on:change="predict">
            <input type="submit" value="Tìm với google">
        </form>

    </div>
    <div id="result" class="container">
        <div class="list_suggest">
                @if(!empty($predict))
                    <h6 class="SuggestText">Có phải bạn muốn tìm : </h6>
                    <?php foreach ($predict as $suggest): ?>
                        <?php foreach ($suggest as $suggests):?>
                            <a href="/search?s={{$search}}+{{$suggests}}" class="SuggestText">{{$search}} {{$suggests}}</a>
                        <?php endforeach?>
                    <?php endforeach ?>
                @endif
        </div>
        @if(!isset($urls))
            <h4>Vui lòng nhập trường để tìm kiếm !!!</h4>
        @elseif (!$count)
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
            <h3>Có khoảng {{$count}} kết quả tìm được ( {{$time}} ms )</h3>
            <ul class="list-result">
                <?php foreach ($urls as $urlModel): ?>
                <li>
                    <a href="{{$urlModel->url}}"><h5 class="title">{{ $urlModel->title }}</h5></a>
                    <p>{{$urlModel->description}}</p>
                </li>
                <?php endforeach ?>
            </ul>
            {!! $urls->links() !!}
        @endif
    </div>

</div>
<script src="/js/custompage.js"></script>
</body>
</html>