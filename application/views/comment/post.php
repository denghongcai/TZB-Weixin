<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>我要代言</title>
        <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <style>
            body
            {
                background-color:#df2b2b;
            }

            textarea{
                width:98%;
                margin:auto;
                padding:5px;
            }
        </style>
    </head>
    <body>
        <div class="text-center">
            <img src="<?= base_url('img/banner.jpg') ?>" class="img-responsive center-block"/>
        </div>
        <div class="container">
            <form class="" role="form" method="post" action="<?= base_url('comment/doPost') ?>">
                <div class="form-group form-horizontal row">
                    <div class="col-xs-4 text-right" style="color:white"><label for="name">称呼</label></div>
                    <div class="col-xs-8 text-left"><input name="name" id="name" type="text" placeholder="请输入您的称呼"></div>
                </div>
                <div class="form-group form-horizontal row">
                    <div class="col-xs-4 text-right" style="color:white"><label for="comment">我的看法</label></div>
                    <div class="col-xs-8 text-left"><textarea rows="5" name="comment" id="comment" placeholder="请输入您关于社会主义核心价值观的看法"></textarea></div>
                </div>
                <div class="col-xs-6 text-center">
                    <button type="reset" class="btn btn-info">重置</button>
                </div>
                <div class="col-xs-6 text-center">
                    <button type="submit" class="btn btn-info">提交</button>
                </div>
            </form>
        </div>
        <p></p>
        <p class="small text-center" style="margin-top:1.5em; color:white">版权所有©2014 华中科技大学学生会 保留所有权利</p>
        <p class="small text-center" style="color:white">华中科技大学学生会新闻媒体部新媒体小组 制作</p>

        <div><p class="text-center"></p></div>
        <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>
