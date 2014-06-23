<div class="span8">
    <button id="AddUser-Btn"><i class="icon-plus on-left"></i>添加用户</button>
    <table class="table hovered">
        <thead>
            <tr>
                <th class="text-left">用户名</th>
                <th class="text-left">所属部门</th>
                <th class="text-left">姓名</th>
                <th class="text-left">联系方式</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>呵呵</td>
                <td class="right">呵呵</td>
                <td class="right">呵呵</td>
                <td class="right">呵呵</td>
            </tr>
        </tbody>
        <tfoot></tfoot>
    </table>
    <script>
        $(function(){
            $("#AddUser-Btn").on('click', function(){
                $.Dialog({
                    overlay: true,
                    shadow: true,
                    flat: true,
                    draggable: true,
                    width: 400,
                    icon: '<span class="icon-user"></span>',
                    title: '添加新用户',
                    content: '',
                    padding: 10,
                    onShow: function(_dialog){
                        var content = '<form class="user-input" method="post" action="<?=base_url("user/ManageUser?action=Add")?>">' +
                            '<label>用户名</label>' +
                            '<div class="input-control text"><input type="text" name="UserName"><button class="btn-clear"></button></div>' +
                            '<label>密码</label>'+
                            '<div class="input-control password"><input type="password" name="PassWord"><button class="btn-reveal"></button></div>' +
                            '<label>真实姓名</label>' +
                            '<div class="input-control text"><input type="text" name="RealName"><button class="btn-clear"></button></div>' +
                            '<label>部门</label>' +
                            '<div class="input-control text"><input type="text" name="DepartMent"><button class="btn-clear"></button></div>' +
                            '<label>联系方式</label>' +
                            '<div class="input-control text"><input type="text" name="ContactInfo"><button class="btn-clear"></button></div>' +
                            '<div class="form-actions">' +
                            '<button class="button primary">提交</button>&nbsp;'+
                            '<button class="button" type="button" onclick="$.Dialog.close()">取消</button> '+
                            '</div>'+
                            '</form>';

                        $.Dialog.title("添加新用户");
                        $.Dialog.content(content);
                    }
                });
            });
        })
    </script>
</div>
