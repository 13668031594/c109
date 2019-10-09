<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
</head>
<style>
    body {
        background-color: #fff;
    }

    .content {
        max-width: 1175px;
        max-height: 600px;
        margin: 0px auto;
    }
</style>
<body>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    @if($wallet == '0')
        <legend>{{$set['walletBalance']}}</legend>
    @elseif($wallet == '1')
        <legend>{{$set['walletPoundage']}}</legend>
    @elseif($wallet == '2')
        <legend>{{$set['walletReward']}}</legend>
    @elseif($wallet == '3')
        <legend>{{$set['walletGxd']}}</legend>
    @endif
</fieldset>
<div class="content">
    <table id="demo" lay-filter="test"></table>
</div>

<script src="{{$static}}layui/layui.js"></script>
<script>
    layui.use('table', function () {
        var table = layui.table;

        //第一个实例
        table.render({
            elem: '#demo'
            , url: '/wallet-table?wallet={{$wallet}}' //数据接口
            , page: true //开启分页
            , parseData: function (res) { //res 即为原始返回的数据
                return {
                    "code": 0, //解析接口状态
//                    "msg": res.message, //解析提示文本
                    "count": res.total, //解析数据长度
                    "data": res.message
                };
            }
            , cols: [[ //表头
                {field: 'type_name', title: '类型', width: 100, fixed: 'left'}
                , {field: 'detail', title: '内容'}
                , {field: 'created_at', title: '时间',width: 180}
            ]]
        });

    });
</script>
</body>
</html>