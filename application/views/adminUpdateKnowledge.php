<style>
    .tt-dropdown-menu {
        width: 422px;
        margin-top: 8px;
        padding: 8px 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }

    .tt-suggestion {
        padding: 3px 20px;
        font-size: 18px;
        line-height: 24px;
    }

    .tt-suggestion.tt-is-under-cursor {
        color: #fff;
        background-color: #0097cf;

    }

    .tt-suggestion p {
        margin: 0;
    }

    .tt-query, .tt-hint {
        width: 396px;
        height: normal;
        padding: 8px 12px;
        font-size: 100%;
        line-height: 30px;
        border: 2px solid #ccc;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        outline: none;
    }
</style>
<div class="span8">
    <form method="post" action="<?=$action?>">
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
            <legend>增加条目</legend>
            <label>问题</label>
            <div class="input-control text" data-role="input-control">
                <input name="Question" type="text" placeholder="请输入问题" value="<?=$data['Question']?>">
                <button class="btn-clear" tabindex="-1" type="button"></button>
            </div>
            <label>答案</label>
            <div class="input-control text" data-role="input-control">
                <input name="Answer" type="text" placeholder="请输入答案" autofocus="" value="<?=$data['Answer']?>">
                <button class="btn-clear" tabindex="-1" type="button"></button>
            </div>
            <label>Tag</label>
            <div class="input-control" id="tagcontainer">

            </div>
            <div class="input-control text" data-role="input-control">
                <input class="tm-input" type="text" placeholder="请输入Tag" autofocus="" autocomplete="false" value="<?=$data['Tag']?>" name="Tags">
                <button class="btn-clear" tabindex="-1" type="button"></button>
            </div>
            <input type="submit" value="提交">
        </fieldset>
    </form>
</div>
<script>
    $(function(){
        var substringMatcher = function() {
            return function findMatches(q, cb){
                var matches = [];
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "<?=base_url('knowledge/GetTagAjax')?>",
                    data: {'TagName': q},
                    success: function(data){
                        $.each(data, function(i, str) {
                            matches.push({ value: str });
                        });
                    },
                    dataType: 'json'
                });
                cb(matches);
            };
        };
        var tagApi = $(".tm-input").tagsManager({
            tagsContainer: '#tagcontainer',
            hiddenTagListName: 'Tag'
        });
        $(".tm-input").typeahead({
            highlight: true,
            minLength: 1
        },{
            name: 'Tag',
            displayKey: 'value',
            source: substringMatcher()
        }).on('typeahead:selected', function (e, d) {
                tagApi.tagsManager("pushTag", d.value);
            });
    })
</script>