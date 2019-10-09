<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}css/market.css">
    <title>details</title>
</head>
<body>
<div class="details">
    <div class="details-content">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
            <legend>订单信息</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">寄售人</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" placeholder="{{$order['sell_nickname']}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">贡献点</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" placeholder="{{$order['gxd']}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">寄售金额</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" placeholder="{{$order['balance']}}(1:{{$order['amount']}})"
                       class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" placeholder="{{$status[$order['status']]}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">创建时间</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" placeholder="{{$order['created_at']}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">购买人</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" placeholder="{{$order['buy_nickname']}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">付款时间</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" placeholder="{{$order['pay_time']}}" class="layui-input">
            </div>
        </div>
    </div>

    <div class="details-content">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
            <legend>收款信息</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">银行</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" placeholder="{{$order['bank_name']}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item background">
            <label class="layui-form-label">卡号</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" value="{{$order['bank_no']}}" class="layui-input background">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">支行</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" value="{{$order['bank_address']}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">持有人</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" value="{{$order['bank_man']}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">支付宝</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" value="{{$order['alipay']}}" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">备注</label>
            <div class="layui-input-inline">
                <input type="text" readonly="readonly" value="{{$order['note']}}" class="layui-input">
            </div>
        </div>
    </div>
</div>
<div class="details-btn">
    @if(($order['status'] == '10'))
        @if($order['sell_uid'] == $member['uid'])
            <button type="button" class="layui-btn layui-btn-fluid" onclick="thisBack(this)">取消交易</button>
        @else
            <button type="button" class="layui-btn layui-btn-fluid" onclick="thisBuy(this)">认购</button>
        @endif
    @elseif(($order['status'] == '20' || $order['status'] == '30') && ($order['buy_uid'] == $member['uid']))
        <button type="button" class="layui-btn layui-btn-fluid" onclick="onUpload(this)">上传凭证</button>
        <input type="file" class="layui-hide"/>
        <button type="button" class="layui-btn" onclick="onSeeConfirm(this)">查看凭证</button>
        <button type="button" class="layui-btn layui-btn-fluid" onclick="onBuyConfirm(this,1)">确定</button>
    @elseif(($order['status'] == '30') && ($order['sell_uid'] == $member['uid']))
        <button type="button" class="layui-btn" onclick="onSeeConfirm(this)">查看凭证</button>
        <button type="button" class="layui-btn layui-btn-fluid" onclick="thisOver(this)">确认收款</button>
    @endif

</div>
</body>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="{{$static}}layui/layui.js"></script>
<script>

    var img = '{{ $order['url'] }}'

    function onUpload(obj) {
        obj.nextElementSibling.click();
    }

    //凭证地址
    function getObjectURL(file) {
        var url = null;
        if (window.createObjcectURL != undefined) {
            url = window.createOjcectURL(file);
        } else if (window.URL != undefined) {
            url = window.URL.createObjectURL(file);
        } else if (window.webkitURL != undefined) {
            url = window.webkitURL.createObjectURL(file);
        }
        return url;
    }

    //查看凭证
    function onSeeConfirm(obj,file) {
        if ( !img && ($(obj.previousElementSibling)[ 0 ].files.length == 0)) {

            layer.msg('请先上传凭证');
            return false;
        }

        if ($(obj.previousElementSibling)[ 0 ].files.length == 0){

            var file1 = img;
        }else {

            var file1 = getObjectURL($(obj.previousElementSibling)[ 0 ].files[0]);
        }

        layer.open({
            type: 1,
            offset: '50px',
            area: ['300px', '450px'],
            title:'已上传凭证',
            content: '<img src=' +file1+ ' style="max-width:300px;max-height:450px">',
            btn: '确定',
        });
    }

    function thisBuy(obj) {

        layer.confirm('您确认要认购此单吗', function (index) {

            layer.close(index);
            var loadingIndex = layer.load();

            $.ajax({
                type: 'GET',
                url: '/trad_buy/{{$order["id"]}}',
                processData: false,
                contentType: false,
                dataType: "json",
                mimeType: "multipart/form-data",
                success: function (res) {
                    layer.close(loadingIndex);
                    location.reload();
                },
                error: function (res) {
                    layer.msg('操作失败');
                }
            })
        });
    }

    function thisBack(obj) {

        layer.confirm('您确定撤销此订单吗', function (index) {

            layer.close(index);
            var loadingIndex = layer.load();

            $.ajax({
                type: 'GET',
                url: '/trad_back/{{$order["id"]}}',
                processData: false,
                contentType: false,
                dataType: "json",
                mimeType: "multipart/form-data",
                success: function (res) {
                    layer.close(loadingIndex);
                    location.reload();
                },
                error: function (res) {
                    layer.msg('操作失败');
                }
            })
        });
    }

    function onBuyConfirm(obj, id) {
        console.log($(obj.previousElementSibling.previousElementSibling)[ 0 ].files.length);
        if ($(obj.previousElementSibling.previousElementSibling)[ 0 ].files.length == 0) {

            layer.msg('请先上传凭证');
            return false;
        }

        var file = $(obj.previousElementSibling.previousElementSibling)[ 0 ].files[ 0 ];

        layer.confirm('您确认已打款且上传了支付凭证？', function (index) {

            layer.close(index);
            var loadingIndex = layer.load();
            var formData = new FormData();

            formData.append('image', file);
//            formData.append('id', id);

            $.ajax({
                type: 'POST',
                url: '/trad_pay/{{$order["id"]}}',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                mimeType: "multipart/form-data",
                success: function (res) {
                    layer.close(loadingIndex);
                    location.reload();
                },
                error: function (res) {
                    layer.msg('操作失败');
                }
            })
        });
    }

    function thisOver(obj) {

        layer.confirm('您要确认收款码？', function (index) {

            layer.close(index);
            var loadingIndex = layer.load();

            $.ajax({
                type: 'GET',
                url: '/trad_over/{{$order["id"]}}',
                processData: false,
                contentType: false,
                dataType: "json",
                mimeType: "multipart/form-data",
                success: function (res) {
                    layer.close(loadingIndex);
                    location.reload();
                },
                error: function (res) {
                    layer.msg('操作失败');
                }
            })
        });
    }

    layui.use(['laypage', 'layer', 'element'], function () {
        var laypage = layui.laypage
            , element = layui.element
            , layer = layui.layer
            , $ = layui.$;

    });
</script>
</html>
