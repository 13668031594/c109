<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}css/tuandui.css">
    <title>tuandui</title>
</head>
<body>
<div style="margin:0px auto;padding:10px;">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
        <legend>我的团队</legend>
    </fieldset>
    <div class="layui-tab">
        <ul class="layui-tab-title">
            <li class="layui-this">直推</li>
            <li>团队</li>
        </ul>
        <div class="layui-tab-content" style="height:500px;">
            <div class="layui-tab-item layui-show">
                @foreach($child['team'] as $k => $v)
                    <div class="content">
                        <div class="list">
                            <div class="list-content">
                                {{$k + 1}} <i class="layui-icon">&#xe66f;</i> {{$v['nickname']}}
                            </div>
                            <div class="list-state">
                                <span class="list-state-span">{{$act[$v['act']]}}</span>

                                <span class="list-state-span">{{$status[$v['status']]}}</span>
                            </div>
                            <div class="menu" onclick="menu(this)">
                                <i class="layui-icon layui-icon-triangle-d" style="margin-left:10px;"></i>
                            </div>
                        </div>

                        <div class="list-news" id="news">
                            <div class="list-news-list">
                                <i class="layui-icon">&#xe678;</i> {{$v['phone']}}
                            </div>
                            <div class="list-news-list">
                                <i class="layui-icon">&#xe637;</i> 排单时间
                            </div>
                            <div class="list-news-list">
                                {{$v['last_buy_time']}}
                            </div>
                            <div class="list-news-list">
                                <i class="layui-icon">&#xe637;</i> 注册时间
                            </div>
                            <div class="list-news-list">
                                {{$v['created_at']}}
                            </div>
                            @if($v['status'] == '10')
                                <div class="list-news-btn">
                                    @if($v['hosting'] == '10')
                                    <div class="btn" onclick="hosting({{$v['uid']}})">切换</div>
                                    @endif
                                    <div class="btn" onclick="btn({{$v['uid']}})">赠送</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{--<div id="member"></div>--}}
            </div>

            <div class="layui-tab-item">
                <div id="test1" class="team"></div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="{{$static}}layui/layui.js"></script>
<script src="{{$static}}js/tuandui.js"></script>
<script>

    function hosting(id) {

        layer.confirm('确认切换到该会员吗？', function (index) {

            layer.close(index);
            var loadingIndex = layer.load();

            var formData = new FormData();

            formData.append('id', id);

            $.ajax({
                type: 'POST',
                url: '/hosting',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                mimeType: "multipart/form-data",
                success: function (res) {
                    layer.close(loadingIndex);
                    window.top.location.reload();
                },
                error: function (res) {
                    layer.msg('操作失败');
                }
            })
        });
    }


    //选项卡2
    layui.use('tree', function(){
        var tree = layui.tree;

        var inst1 = tree.render({
            elem: '#test1'
            ,data: {!! $team !!}
        });
    });

    function btn(id){

        layui.use('layer', function(){
            var layer = layui.layer,
                $ = layui.jquery;

            layer.open({
                type: 1,
                area: '300px',
                title: '赠送',
                closeBtn: 0,
                btn: ['确定', '取消'],
                content: '<div class="btn-list"><input id="inp">元</div>',
                yes: function(index, layero){
                    console.log(id);
                    var inp = document.getElementById('inp');
                    if (inp.value == '')
                    {
                        layer.msg('请输入赠送金额');
                    }else{
                        $.post('/turn',{id:id,poundage:inp.value}, function(res){
                            if (res.status == 'success')
                            {
                                layer.msg('操作成功');
                                layer.close(index);
                            }else{
                                layer.msg(res.data);
                            }
                        },'json');
                    }
                }
            });
        });
    }

</script>
</body>
</html>
