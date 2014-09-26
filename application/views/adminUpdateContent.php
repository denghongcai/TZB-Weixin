<link href="<?=base_url('umeditor/themes/default/css/umeditor.min.css')?>" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url('umeditor/umeditor.config.js')?>"></script>
<script type="text/javascript" src="<?=base_url('umeditor/umeditor.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('umeditor/lang/zh-cn/zh-cn.js')?>"></script>
<div class="span8">
    <form id="contentForm" method="post" action="<?=$action?>">
        <?php if($error !== FALSE):?>
            <div class="notice marker-on-bottom">
                <?php if($error === 1):?>
                    操作失败
                <?php else:?>
                    操作成功
                <?php endif?>
            </div>
        <?php endif?>
        <fieldset>
            <legend>增加内容</legend>
            <div class="input-control text" data-role="input-control">
                <input name="Title" type="text" placeholder="请输入标题" value="<?=$data['Title']?>">
                <button class="btn-clear" tabindex="-1" type="button"></button>
            </div>
            <div class="input-control text" data-role="input-control">
                <input name="Author" type="text" placeholder="请输入作者" value="<?=$data['Author']?>">
                <button class="btn-clear" tabindex="-1" type="button"></button>
            </div>
            
            <div class="input-control select" data-role="input-control">
                <select name="Category">
                    <?php foreach($category as $row):?>
                    <option value="<?=$row['CATEGORYID']?>" <?=$data['CATEGORYID']==$row['CATEGORYID'] ? 'selected="selected"' : ''?>><?=$row['CategoryName']?></option>
                    <?php endforeach?>
                </select>
            </div>
            
            <textarea name="Content" id="Content" style="display: none"></textarea>
            <input type="submit" value="提交">
            <div style="width:620px;height: 300px;margin-top:10px;">
                <script type="text/plain" id="myEditor" style="width: 100%;height:300px;bottom:20px">
                    <?php if($data['Content'] == ""):?>
                    <p>这里我可以写一些输入提示</p>
                    <?php else:?>
                    <?=$data['Content']?>
                    <?php endif ?>
                </script>
            </div>
        </fieldset>
    </form>
</div>
<script src="<?=base_url('js/base64.min.js')?>"></script>
<script type="text/javascript">
    window.UMEDITOR_HOME_URL = "<?=base_url('umeditor')?>";
    $(function(){
        var um = UM.getEditor('myEditor');
        $('#contentForm').submit(function(e){
            e.preventDefault();
            Base64.extendString();
            var strings = um.getContent().toBase64();
            $('#Content').text(strings);
            this.submit();
        })
    })
</script>
