<div class="span8">

    <table class="table hovered dataTable" id="commentTables">
        <thead>
            <tr>
                <th class="text-left">作者</th>
                <th class="text-left">内容</th>
                <th class="text-left">时间</th>
                <th class="text-left">展示</th>
                <th class="text-left">删除</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-left">时间</th>
                <th class="text-left">作者</th>
                <th class="text-left">内容</th>
                <th class="text-left">展示</th>
                <th class="text-left">删除</th>
            </tr>
        </tfoot>
    </table>
    <script>
        $(function () {
            $('#commentTables').DataTable({
                'lengthMenu': [[15, 25, 50, -1], [10, 25, 50, "全部"]],
                'processing': true,
                'serverSide': false,
                'ajax': "<?= base_url('comment_admin/CommentListAjax') ?>",
                'columns': [
                    {'data': 'Time'},
                    {'data': 'Name'},
                    {'data': 'Content'},
                    {'data': 'Edit'},
                    {'data': 'Remove'}
                ],
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
