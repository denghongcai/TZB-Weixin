<div class="span8">
    <table class="table hovered dataTable" id="knowTables">
        <thead>
            <tr>
                <th class="text-left">问题</th>
                <th class="text-left">Tag</th>
                <th class="text-left">答案</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-left">问题</th>
                <th class="text-left">Tag</th>
                <th class="text-left">答案</th>
            </tr>
        </tfoot>
    </table>
    <script>
        var editor;
        $(function(){
            editor = new $.fn.dataTable.Editor({
                ajax: "<?=base_url('knowledge/UpdateKnowledge')?>",
                table: "#knowTables",
                formOptions: {
                },
                fields: [
                    {
                        label: "问题",
                        name: "Question"
                    },
                    {
                        label: "Tag",
                        name: "Tag"
                    },
                    {
                        label: "答案",
                        name: "Answer"
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
            $('#knowTables').DataTable({
                'dom': 'Tfrtip',
                'lengthMenu': [[15, 25, 50, -1], [10, 25, 50, "全部"]],
                'processing': true,
                'serverSide': false,
                'ajax': "<?=base_url('knowledge/KnowledgeListAjax')?>",
                'columns': [
                    {'data': 'Question'},
                    {'data': 'Tag'},
                    {'data': 'Answer'}
                ],
                tableTools: {
                    sRowSelect: "os",
                    aButtons: [
                        { sExtends: "editor_edit",   editor: editor },
                        { sExtends: "editor_remove", editor: editor }
                    ]
                },
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
        })
    </script>
</div>