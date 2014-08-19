<?php
define('BASEPATH', dirname(__FILE__));
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    require(BASEPATH . '/config.inc.php');
    require(BASEPATH . '/db.inc.php');
    $id = $_GET['id'];
    $db = DB::connect();
    $content = $db->Content('CONTENTID', $id)->limit(1)->fetch();
    if(empty($content)) {
        echo "error id: " . $id;
        exit;
    }
} else {
    echo "no id";exit;
}
?>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <title><?=$content['Title']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">

        <style>.vote_box{position:relative;background-color:#fff;padding:1em 0 0;overflow:hidden}.vote_box:before,.vote_box:after{content:" ";content:" ";position:absolute;left:0;top:0;width:200%;height:1px;border-top:1px solid #e1e1df;-webkit-transform-origin:0 0;transform-origin:0 0;-webkit-transform:scale(0.5);transform:scale(0.5)}.vote_box:after{top:auto;bottom:-1px}.vote_box.skin_help{display:none;position:absolute;top:0;padding:0;width:15px}.vote_box.po_left{left:-15px}.vote_box.po_right{left:100%}body,div,dl,dt,dd,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td{margin:0;padding:0}pre{word-break:break-all;word-wrap:break-word}table{border-collapse:collapse;border-spacing:0}fieldset,img{border:0}address,caption,cite,code,dfn,th,var{font-style:normal;font-weight:normal}ol,ul{list-style:none}caption,th{text-align:left}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal}q:before,q:after{content:''}abbr,acronym{border:0;font-variant:normal}sup{vertical-align:text-top}sub{vertical-align:text-bottom}input,textarea,select{font-family:inherit;font-size:inherit;font-weight:inherit}input,textarea,select{font-size:100%}legend{color:#000}body{background:#f8f7f5;color:#222;font-family:Helvetica,STHeiti STXihei,Microsoft JhengHei,Microsoft YaHei,Tohoma,Arial;height:100%;padding:15px 0 0;position:relative}body>.tips{display:none;left:50%;padding:20px;position:fixed;text-align:center;top:50%;width:200px;z-index:100}.page{padding:15px}.page .page-error,.page .page-loading{line-height:30px;position:relative;text-align:center}.btn{background-color:#fcfcfc;border:1px solid #ccc;border-radius:5px;box-shadow:0 1px 4px rgba(0,0,0,0.3);color:#222;cursor:pointer;display:block;font-size:15px;font-weight:bold;margin:15px 0;moz-box-shadow:0 1px 4px rgba(0,0,0,0.3);padding:10px;text-align:center;text-decoration:none;webkit-box-shadow:0 1px 4px rgba(0,0,0,0.3)}.icons{background:url(http://res.wx.qq.com/mmbizwap/zh_CN/htmledition/images/icons.png) no-repeat 0 0;border-radius:5px;height:25px;overflow:hidden;position:relative;width:25px}.icons.arrow-r{background:url(http://res.wx.qq.com/mmbizwap/zh_CN/htmledition/images/brand_profileinweb_arrow@2x.png) no-repeat center center;background-size:100%;height:16px;width:12px}.icons.check{background-position:-25px 0}#activity-detail .page-bizinfo .header #activity-name{color:#000;font-size:20px;font-weight:bold;white-space:pre-wrap;word-wrap:normal;word-break:normal}.page-bizinfo{padding-left:15px;padding-right:15px}.activity-meta{display:inline-block;line-height:16px;vertical-align:middle;margin-left:8px;padding-top:2px;padding-bottom:2px;color:#8c8c8c;font-size:11px}.activity-meta.no-extra{margin-left:0}.activity-info .text-ellipsis{display:inline-block;vertical-align:middle;max-width:104px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}#post-user{text-decoration:none;outline:0;color:#607fa6}a.activity-meta{text-decoration:none;outline:0;color:#607fa6}a.activity-meta:active{color:#607fa6}a.activity-meta:active .icon_link_arrow{background:transparent url(http://res.wx.qq.com/mmbizwap/zh_CN/htmledition/images/link_arrow_right_blue.png) no-repeat 0 0;-webkit-background-size:100%;-moz-background-size:100%;-o-background-size:100%;background-size:100%}.activity-info .icon_link_arrow{margin-left:3px;margin-top:-5px}.icon_link_arrow{display:none;vertical-align:middle;width:7px;height:7px;background:transparent url(http://res.wx.qq.com/mmbizwap/zh_CN/htmledition/images/link_arrow_right_blue.png) no-repeat 0 0;-webkit-background-size:100%;-moz-background-size:100%;-o-background-size:100%;background-size:100%}#activity-detail .page-content{margin:4px 0 0;padding-left:15px;padding-right:15px}#activity-detail .page-content .media{margin:18px 0}#activity-detail .page-content .media img{width:100%}#activity-detail .page-content .text{color:#3e3e3e;line-height:1.5;width:100%}#activity-detail .page-content .text p{*zoom:1;min-height:1.5em;min-height:1.5em;white-space:pre-wrap}#activity-detail .page-content .text p:after{content:"\200B";display:block;height:0;clear:both}#activity-list .header{font-size:20px}#activity-list .page-list{border:1px solid #ccc;border-radius:5px;margin:18px 0;overflow:hidden}#activity-list .page-list .line.btn{border-radius:0;margin:0;text-align:left}#activity-list .page-list .line.btn .checkbox{height:25px;line-height:25px;padding-left:35px;position:relative}#activity-list .page-list .line.btn .checkbox .icons{background-color:#ccc;left:0;position:absolute;top:0}#activity-list .page-list .line.btn.off .icons{background-image:none}.vm{vertical-align:middle}.tc{text-align:center}.db{display:block}.dib{display:inline-block}.b{font-weight:700}.clr{clear:both}.text img{max-width:100%!important;height:auto!important}.page-toolbar{padding:18px 0;overflow:hidden;*zoom:1;height:16px;line-height:16px}.page-toolbar a{color:#607fa6;font-size:14px;text-decoration:none;text-shadow:0 1px #fff;-webkit-text-shadow:0 1px #fff;-moz-text-shadow:0 1px #fff}.page-url{float:left}.page-toolbar a.page-imform{float:right;color:#7b7b7b}.page-toolbar .pager{display:block;margin:0 auto -16px;text-align:center;font-size:14px}.page-toolbar .pager a{margin:0 10px}.page-toolarea{font-size:14px;padding:10px 0 20px}.page-toolarea a{display:block;line-height:2em;color:#7b7b7b;text-decoration:none}.page-toolarea .icon_arrow_gray{margin-left:5px;margin-top:-0.2em}.res_iframe{width:100%;background-color:transparent;border:0}.line_title{text-align:center;margin-top:20px;border-top:1px dotted #a8a8a7}.line_title .tips{display:inline-block;position:relative;top:-9px;padding-left:16px;padding-right:16px;font-size:14px;color:#cfcfcf;background-color:#f8f7f5;text-decoration:none}.icon_arrow_gray{display:inline-block;vertical-align:middle;width:7px;height:7px;background:transparent url(http://res.wx.qq.com/mmbizwap/zh_CN/htmledition/images/icon_arrow_gray.png) no-repeat 0 0;-webkit-background-size:100%;-moz-background-size:100%;-o-background-size:100%;background-size:100%}.selectTdClass{background-color:#edf5fa!important}table.noBorderTable td,table.noBorderTable th,table.noBorderTable caption{border:1px dashed #ddd!important}table{margin-bottom:10px;border-collapse:collapse;display:table;width:100%!important}td,th{word-wrap:break-word;word-break:break-all;padding:5px 10px;border:1px solid #DDD}caption{border:1px dashed #DDD;border-bottom:0;padding:3px;text-align:center}th{border-top:2px solid #BBB;background:#f7f7f7}.ue-table-interlace-color-single{background-color:#fcfcfc}.ue-table-interlace-color-double{background-color:#f7faff}td p{margin:0;padding:0}.vote_area{position:relative;display:block;display:block;margin:14px 0;white-space:normal!important}.vote_iframe{width:100%;height:100%;background-color:transparent;border:0}.text{word-wrap:break-word;-webkit-hyphens:auto;-ms-hyphens:auto;hyphens:auto;-webkit-nbsp-mode:space}.text *{max-width:100%;word-wrap:break-word!important}</style>
        <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="http://res.wx.qq.com/mmbizwap/zh_CN/htmledition/style/pc-page1ea1b6.css"/>
    <![endif]-->
        <link media="screen and (min-width:1000px)" rel="stylesheet" type="text/css" href="http://res.wx.qq.com/mmbizwap/zh_CN/htmledition/style/pc-page1ea1b6.css">
        <style>
            body{ -webkit-touch-callout: none; -webkit-text-size-adjust: none; }
        </style>
        <style>
            #nickname{overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:90%;}
            .page-toolarea a.random_empha{color:#607fa6;}
            ol,ul{list-style-position:inside;}
            #activity-detail .page-content .text{font-size:16px;}
        </style>
    </head> 

    <body id="activity-detail">
        <img width="12px" style="position: absolute;top:-1000px;" src="http://res.wx.qq.com/mmbizwap/zh_CN/htmledition/images/ico_loading1984f1.gif">
        <div class="wrp_page">

            <div class="page-bizinfo">
                <div class="header">
                    <h1 id="activity-name"><?=$content['Title']?></h1>
                    <p class="activity-info">
                        <span id="post-date" class="activity-meta no-extra"><?=$content['AddTime']?></span>
                        <a href="#" id="post-user" class="activity-meta">
                            <span class="text-ellipsis">创青春 <?=$content['Author']?></span><i class="icon_link_arrow"></i>
                        </a>
                    </p>
                </div>
            </div>

            <div id="page-content" class="page-content" lang="en">
                <div id="img-content">


                    <div class="text" id="js_content">
                        <?=$content['Content']?>
                        <p><span style="max-width: 100%; font-family: Times; "><br></span></p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; max-width: 100%; min-height: 1.5em; white-space: normal; line-height: 2em; color: rgb(62, 62, 62); font-family: 宋体; -webkit-text-size-adjust: none; background-color: rgb(255, 255, 255); "><span style="font-family: sans-serif;"></span><img data-src="http://mmbiz.qpic.cn/mmbiz/qLVg5iafF2DXSSCTd8hl2pCInD6QqYpamYjMeU9nfgiaLoh88kZGxPWKJ4EY7bh5l3cze01hkE9xybM2dWfrw2eg/0" style="font-family: sans-serif; height: auto !important; visibility: visible !important;" src="http://mmbiz.qpic.cn/mmbiz/qLVg5iafF2DXSSCTd8hl2pCInD6QqYpamYjMeU9nfgiaLoh88kZGxPWKJ4EY7bh5l3cze01hkE9xybM2dWfrw2eg/0"></p>
                    </div>

                </div>
            </div>

        </div>






    </body></html>