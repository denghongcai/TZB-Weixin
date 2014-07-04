<link href="<?=base_url('umeditor/themes/default/css/umeditor.min.css')?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url('umeditor/umeditor.config.js')?>"></script>
<script type="text/javascript" src="<?=base_url('umeditor/umeditor.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('umeditor/lang/zh-cn/zh-cn.js')?>"></script>
<div class="span8">
    <form id="contentForm" method="post" action="<?=base_url('content/UpdateContent?action=Add')?>">
        <?php if($error !== FALSE):?>
            <div class="notice marker-on-bottom">
                <?php if($error === 1):?>
                    新内容添加失败
                <?php else:?>
                    新内容添加成功
                <?php endif?>
            </div>
        <?php endif?>
        <fieldset>
            <legend>增加内容</legend>
            <div class="input-control text" data-role="input-control">
                <input name="Title" type="text" placeholder="请输入标题">
                <button class="btn-clear" tabindex="-1" type="button"></button>
            </div>
            <div class="input-control text" data-role="input-control">
                <input name="Author" type="text" placeholder="请输入作者">
                <button class="btn-clear" tabindex="-1" type="button"></button>
            </div>
            <div class="input-control select" data-role="input-control">
                <select name="Category">
                    <?php foreach($category as $row):?>
                        <option value="<?=$row['CATEGORYID']?>"><?=$row['CategoryName']?></option>
                    <?php endforeach?>
                </select>
            </div>
            <input type="submit" value="提交">
            <div style="width:620px;height: 300px;margin-top:10px;">
                <script type="text/plain" id="myEditor" style="width: 100%;height:300px;bottom:20px">
                    <p>这里我可以写一些输入提示</p>
                </script>
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    window.UMEDITOR_HOME_URL = "<?=base_url('umeditor')?>";
    $(function(){
        var um = UM.getEditor('myEditor');
    })
</script>