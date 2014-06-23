<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <link rel="stylesheet" href="<?=base_url('css/metro-bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/metro-bootstrap-responsive.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/iconFont.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/global.css')?>">
    <script src="<?=base_url('js/jquery.min.js')?>"></script>
    <script src="<?=base_url('js/jquery.widget.min.js')?>"></script>
    <script src="<?=base_url('js/metro.min.js')?>"></script>
</head>
<body class="metro">
    <div class="container">
        <div class="grid">
            <div class="row">
                <form class="loginform" method="post" action="<?=base_url('login')?>">
                    <?php if($error):?>
                    <div class="notice marker-on-bottom">
                        用户名或密码错误
                    </div>
                    <?php endif?>
                    <fieldset>
                        <legend>华中科技大学挑战杯微信管理后台</legend>
                        <label>用户名</label>
                        <div class="input-control text" data-role="input-control">
                            <input name="UserName" type="text" placeholder="输入你的用户名" autofocus="">
                            <button class="btn-clear" tabindex="0" type="button"></button>
                        </div>
                        <label>密码</label>
                        <div class="input-control password" data-role="input-control">
                            <input name="PassWord" type="password" placeholder="输入你的密码">
                            <button class="btn-reveal" tabindex="1" type="button"></button>
                        </div>
                        <input type="submit" value="登录"/>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</body>
</html>