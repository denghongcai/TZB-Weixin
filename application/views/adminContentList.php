<div class="span8">
    <label>选择类别</label>
    <div class="input-control select" data-role="input-control">
        <select name="category">
            <?php foreach($category as $row):?>
            <option value="<?=$row['CATEGORYID']?>"><?=$row['CategoryName']?></option>
            <?php endforeach?>
        </select>
    </div>
    <table class="table hovered dataTable" id="contentTables">
        <thead>
        <tr>
            <th class="text-left">标题</th>
            <th class="text-left">作者</th>
            <th class="text-left">内容</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <th class="text-left">标题</th>
            <th class="text-left">作者</th>
            <th class="text-left">内容</th>
        </tr>
        </tfoot>
    </table>
    <script>
        var editor;
        $(function(){
            editor = new $.fn.dataTable.Editor({
                ajax: "<?=base_url('content/UpdateContent')?>",
                table: "#contentTables",
                formOptions: {
                },
                fields: [
                    {
                        label: "标题",
                        name: "Title"
                    },
                    {
                        label: "作者",
                        name: "Author"
                    },
                    {
                        label: "内容",
                        name: "Content"
                    }
                ],
                i18n: {
                    create: {
                        button: "禁用",
                        title:  "创建新条目",
                        submit: "创建"
                    },
                    edit: {
                        button: "修改",
                        title:  "修改条目",
                        submit: "确认修改"
                    },
                    remove: {
                        button: "删除",
                        title:  "删除",
                        submit: "删除",
                        confirm: {
                            _: "你想删除这 %d 行?",
                            1: "你想删除这一行吗？"
                        }
                    },
                    error: {
                        system: "系统出错，请联系系统管理员"
                    }
                }
            });
            var ajaxUrl = "";
            var dt = undefined;
            var dtinit = function(cid){
                ajaxUrl = "<?=base_url('content/ContentListAjax')?>"
                    + "?categoryid="
                    + cid;
                if(dt !== undefined)
                    dt.destroy();

                dt = $('#contentTables').DataTable({
                    'dom': 'Tfrtip',
                    'paging': false,
                    'lengthMenu': [[15, 25, 50, -1], [10, 25, 50, "全部"]],
                    'processing': true,
                    'serverSide': false,
                    'ajax': ajaxUrl,
                    'columns': [
                        {'data': 'Title'},
                        {'data': 'Author'},
                        {'data': 'Content'}
                    ],
                    tableTools: {
                        sRowSelect: "os",
                        aButtons: [
                            { sExtends: "editor_edit",   editor: editor },
                            { sExtends: "editor_remove", editor: editor }
                        ]
                    },
                    *
                    'language': {
                        'processing': '正在获取数据...',
                        'search': '搜索',
                        'lengthMenu': '显示_MENU_项',
                        'info': '显示总共_TOTAL_项中的_START_到_END_项',
                        'infoEmpty': '显示总共0项中的0到0项',
                        'infoFiltered': '(过滤后总共_TOTAL_项)',
                        'zeroRecords': '没有符合的记录',
                        'paginate': {
                            'first': '第一页',
                            'previous': '前一页',
                            'next': '下一页',
                            'last': '最后一页'
                        }
                    }
                })
            };
            dtinit($('select[name="category"]').val());
            $('select[name="category"]').on('change', function(){
                dtinit($(this).val());
            });
        })
    </script>
</div>