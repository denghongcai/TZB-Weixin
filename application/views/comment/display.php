<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>精彩代言</title>
        <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <style>
            body
            {
                background-color:#29c8ff;
            }
            well{
                background-color: #000;
            }
            .first{
                padding: 5px;
                text-align: center;
            }
            .prev{
                padding: 5px;
                text-align: center;
            }
            .next{
                padding: 5px;
            }
            .end{
                padding: 5px;
            }
            .num{
                padding: 5px;
            }
            .current{
                padding: 5px;
            }
            .pa{
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="text-center">
            <img src="<?= base_url('img/banner.jpg') ?>" class="img-responsive center-block"/>
        </div>
        <div class="container">
            <p style="color:white">当前共有<?=$total_counts?>人发起代言，下面是我们为您挑选出的精彩代言。欢迎加入我们，为创青春代言！</p>
            <?php foreach ($comments as $row) :?>
            <div class="container well">
                <label><?=$row['Name']?></label>
                <p class="text-danger"><?=$row['Content']?></p>
                <p class="small text-right text-muted"><span class=" glyphicon glyphicon-time"></span><?=$row['Time']?></p>
            </div>
            <?php endforeach;?>
        </div>
        <div class="pa text-center" style="color:white">
            <div>  
                <?php if ($curr_page > 1) : ?>
                    <a class="prev" href="<?= base_url("comment/index/" . ($curr_page - 1)) ?>"><<</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages && $i <= $limit; $i++) : ?>
                    <?php if ($curr_page == $i) : ?>
                        <span class="current"><?= $i ?></span>
                    <?php else: ?>
                        <a class="num" href="<?= base_url("comment/index/" . $i) ?>"><?=$i?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($curr_page < $total_pages && $curr_page < $limit) : ?>
                    <a class="next" href="<?= base_url("comment/index/" . ($curr_page + 1)) ?>">>></a>
                <?php endif; ?>
            </div>
        </div>
        <p></p>
        <p class="small text-center" style="margin-top:1.5em; color:white">版权所有©2014 创青春全国大学生创业大赛 保留所有权利</p>
        <p class="small text-center" style="color:white">华中科技大学学生会新闻媒体部新媒体小组 制作</p>


        <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>