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
        $(function(){
            var ajaxUrl = "";
            var dt = undefined;
            var dtinit = function(cid){
                ajaxUrl = "<?=base_url('content/ContentListAjax')?>"
                    + "?categoryid="
                    + cid;
                if(dt !== undefined)
                    dt.destroy();

                dt = $('#contentTables').DataTable({
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