<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
	 <meta charset="utf-8">
    <title>创青春微信管理平台</title>
    <link rel="stylesheet" href="<?=base_url('css/metro-bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/metro-bootstrap-responsive.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/iconFont.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/tagmanager.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/dataTables.tableTools.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/dataTables.editor.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/global.css')?>">
    <script src="<?=base_url('js/jquery.min.js')?>"></script>
    <script src="<?=base_url('js/jquery.widget.min.js')?>"></script>
    <script src="<?=base_url('js/jquery.dataTables.js')?>"></script>
    <script src="<?=base_url('js/tagmanager.js')?>"></script>
    <script src="<?=base_url('js/typeahead.min.js')?>"></script>
    <script src="<?=base_url('js/metro.min.js')?>"></script>
</head>
<body class="metro">
    <header class="bg-dark">
        <div class="navigation-bar fixed-top shadow">
            <div class="navigation-bar-content container">
                <a href="/" class="element"><span class="icon-grid-view"></span> 创青春微信平台管理后台 <sup>0.1</sup></a>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="grid show-grid">
            <div class="row">
                <div class="span4">
                    <nav class="sidebar (light)">
                        <ul>
                            <li>
                                <a class="dropdown-toggle title" href="#">信息统计</a>
                                <ul class="dropdown-menu" data-role="dropdown" style="display: block">
                                    <li class="active" id="total-option"><a href="#"><i class="icon-home"></i>总体</a></li>
                                    <li id="history-option"><a href="#"><i class="icon-history"></i>历史记录</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle title" href="#">内容管理</a>
                                <ul class="dropdown-menu" data-role="dropdown">
                                    <li><a href="<?=base_url('content/ContentList')?>"><i class="icon-book"></i>浏览全部内容</a></li>
                                    <li><a href="<?=base_url('content/UpdateContent')?>"><i class="icon-plus-2"></i>增加内容</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle title" href="#">知识库管理</a>
                                <ul class="dropdown-menu" data-role="dropdown">
                                    <li><a href="<?=base_url('knowledge/KnowledgeList')?>"><i class="icon-book"></i>浏览知识库</a></li>
                                    <li><a href="<?=base_url('knowledge/UpdateKnowledge')?>"><i class="icon-plus-2"></i>增加知识库条目</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle title" href="#">留言管理</a>
                                <ul class="dropdown-menu" data-role="dropdown">
                                    <li><a href="<?=base_url('comment_admin/CommentList')?>"><i class="icon-book"></i>查看留言</a></li>
                                    
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle title" href="#">用户管理</a>
                                <ul class="dropdown-menu" data-role="dropdown">
                                    <li><a href="<?=base_url('user/ModifyPassword')?>"><i class="icon-target"></i>修改密码</a></li>
                                    <li><a href="<?=base_url('user/ManageUser')?>"><i class="icon-user"></i>管理用户</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
