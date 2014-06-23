<div class="span8">
    <form method="post" action="<?=base_url('user/ModifyPassword')?>">
        <?php if($error !== FALSE):?>
            <div class="notice marker-on-bottom">
                <?php if($error === 1):?>
                    两次密码输入不一致
                <?php else:?>
                    密码修改成功
                <?php endif?>
            </div>
        <?php endif?>
        <fieldset>
            <legend>修改密码</legend>
            <label>当前密码</label>
            <div class="input-control password" data-role="input-control">
                <input name="curPassword" type="password" placeholder="请输入当前密码" autofocus="">
                <button class="btn-clear" tabindex="-1" type="button"></button>
            </div>
            <label>新密码</label>
            <div class="input-control password" data-role="input-control">
                <input name="newPassword" type="password" placeholder="请输入新密码">
                <button class="btn-clear" tabindex="-1" type="button"></button>
            </div>
            <input type="submit" value="提交"/>
        </fieldset>
    </form>
</div>