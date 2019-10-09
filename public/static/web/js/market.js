layui.use('element', function () {
    var element = layui.element;

});

function popup(obj) {
    layui.use('layer', function () {
        var $ = layui.jquery, layer = layui.layer;
        var layer = layui.layer;
        layer.open({
            type: 2,
            title: false,
            area: ['300px', '350px'],
            closeBtn: 0,
            btn: ['确定', '取消'],
            content: '/popup4',
            success: function (layero, index) {
                var body = layer.getChildFrame('body', index);
                body.find("#proportion").val(bili);
            },
            yes: function (index, layero) {
                var body = layer.getChildFrame('body', index);
                var value1 = body.find('#inp1')[0].value;
                var value2 = body.find('#inp2')[0].value;
                var value3 = body.find('#inp3')[0].value;
                if (value1 == '' && value2 == '') {
                    layer.msg('请填写要寄售的贡献点和金额');
                    return;
                }
                if (!value2 || isNaN(value2) || value2 < 0 || value2.toString().indexOf(".") > 0) {
                    layer.msg('寄售金额必须为正整数');
                    return;
                }
                if (!value1 || isNaN(value1) || value1 < 0 || value1.toString().indexOf(".") > 0) {
                    layer.msg('寄售金额必须为正整数');
                    return;
                }
                if (!value3 || isNaN(value3) || value3 < 0 || value3.toString().indexOf(".") > 0) {
                    layer.msg('寄售贡献点必须为100的倍数');
                    return;
                }
                layer.confirm('您确定寄售贡献点吗？', function (index1) {
                    layer.close(index1);
                    var index2 = layer.load(2);
                    $.post(URL.SELL, {
                        gxd: body.find('#inp1')[ 0 ].value,
                        balance: body.find('#inp2')[ 0 ].value,
                        poundage: body.find('#inp3')[ 0 ].value
                    }, function (res) {

                        if (res.status == 'success')
                        {
                            layer.msg('操作成功,2秒后自动刷新');
                            setTimeout(function () {
                                location.reload();
                                layer.close(index2);
                            }, 2000);
                        }else{
                            layer.msg(res.message);
                            layer.close(index2);
                        }

                    }, 'json')
                });
            }
        });

    });
};

layui.use('table', function () {
    var table = layui.table;

    //第一个实例
    table.render({
        elem: '#demo'
        , limit: 10
        , url: '/trad_index' //数据接口
        , page: true //开启分页
        , parseData: function (res) { //res 即为原始返回的数据
            return {
                "code": 0, //解析接口状态
                // "msg": res.message, //解析提示文本
                "count": res.total, //解析数据长度
                "data": res.message,
                /*"data":[
                        {'id':'T20190417000001','username':'盖伦','sex':456,'city':'1:0.2','sign':'2019年8月24日 15:52:04','state':'待付款','price':'2000.00','details':'<a href="wallet/details.html">查看详情</a>'},
                        {'id':'T20190417000001','username':'盖伦','sex':456,'city':'1:0.2','sign':'2019年8月24日 15:52:04','state':'待付款','price':'2000.00','details':'<a href="wallet/details.html">查看详情</a>'},
                        {'id':'T20190417000001','username':'盖伦','sex':456,'city':'1:0.2','sign':'2019年8月24日 15:52:04','state':'待付款','price':'2000.00','details':'<a href="wallet/details.html">查看详情</a>'},
                        {'id':'T20190417000001','username':'盖伦','sex':456,'city':'1:0.2','sign':'2019年8月24日 15:52:04','state':'待付款','price':'2000.00','details':'<a href="wallet/details.html">查看详情</a>'},
                        {'id':'T20190417000001','username':'盖伦','sex':456,'city':'1:0.2','sign':'2019年8月24日 15:52:04','state':'待付款','price':'2000.00','details':'<a href="wallet/details.html">查看详情</a>'},
                        {'id':'T20190417000001','username':'盖伦','sex':456,'city':'1:0.2','sign':'2019年8月24日 15:52:04','state':'待付款','price':'2000.00','details':'<a href="wallet/details.html">查看详情</a>'},
                        {'id':'T20190417000001','username':'盖伦','sex':456,'city':'1:0.2','sign':'2019年8月24日 15:52:04','state':'待付款','price':'2000.00','details':'<a href="wallet/details.html">查看详情</a>'},
                ] */
            };
        }
        , cols: [[
            {field: 'sell_nickname', title: '出售人', width: 80, fixed: 'left'}
            , {field: 'order', title: '交易号', width: 200}
            , {field: 'gxd', title: '贡献点', width: 80}
            , {field: 'balance', title: '现金', width: 80}
            , {field: 'amount', title: '单价', width: 200}
            , {field: 'status_name', title: '状态', width: 80}
            , {field: 'details', title: '详情'}
        ]]

    });

    table.render({
        elem: '#demo2'
        , limit: 10
        , url: '/trad_sell'
        , page: true
        , parseData: function (res) {
            return {
                "code": 0,
                // "msg": res.message,
                "count": res.total,
                "data": res.message,
                /*"data": [
                    {
                        'id': 'T20190417000001',
                        'username': '赵信',
                        'sex': 456,
                        'city': '1:0.2',
                        'sign': '2019年8月24日 15:52:04',
                        'state': '待付款',
                        'price': '2000.00',
                        'details': '<a href="wallet/details.html">查看详情</a>'
                    },
                    {
                        'id': 'T20190417000001',
                        'username': '赵信',
                        'sex': 456,
                        'city': '1:0.2',
                        'sign': '2019年8月24日 15:52:04',
                        'state': '待付款',
                        'price': '2000.00',
                        'details': '<a href="wallet/details.html">查看详情</a>'
                    },
                    {
                        'id': 'T20190417000001',
                        'username': '赵信',
                        'sex': 456,
                        'city': '1:0.2',
                        'sign': '2019年8月24日 15:52:04',
                        'state': '待付款',
                        'price': '2000.00',
                        'details': '<a href="wallet/details.html">查看详情</a>'
                    },
                    {
                        'id': 'T20190417000001',
                        'username': '赵信',
                        'sex': 456,
                        'city': '1:0.2',
                        'sign': '2019年8月24日 15:52:04',
                        'state': '待付款',
                        'price': '2000.00',
                        'details': '<a href="wallet/details.html">查看详情</a>'
                    },
                    {
                        'id': 'T20190417000001',
                        'username': '赵信',
                        'sex': 456,
                        'city': '1:0.2',
                        'sign': '2019年8月24日 15:52:04',
                        'state': '待付款',
                        'price': '2000.00',
                        'details': '<a href="wallet/details.html">查看详情</a>'
                    },
                    {
                        'id': 'T20190417000001',
                        'username': '赵信',
                        'sex': 456,
                        'city': '1:0.2',
                        'sign': '2019年8月24日 15:52:04',
                        'state': '待付款',
                        'price': '2000.00',
                        'details': '<a href="wallet/details.html">查看详情</a>'
                    },
                    {
                        'id': 'T20190417000001',
                        'username': '赵信',
                        'sex': 456,
                        'city': '1:0.2',
                        'sign': '2019年8月24日 15:52:04',
                        'state': '待付款',
                        'price': '2000.00',
                        'details': '<a href="wallet/details.html">查看详情</a>'
                    },
                ]*/
            };
        }
        , cols: [[ //表头
            {field: 'buy_nickname', title: '买入人', width: 80, fixed: 'left'}
            , {field: 'order', title: '交易号', width: 200}
            , {field: 'gxd', title: '贡献点', width: 80}
            , {field: 'balance', title: '现金', width: 80}
            , {field: 'amount', title: '单价', width: 200}
            , {field: 'status_name', title: '状态', width: 80}
            , {field: 'details', title: '详情'}
        ]]

    });

    table.render({
        elem: '#demo3'
        , limit: 10
        , url: '/trad_buy' //数据接口
        , page: true //开启分页
        , parseData: function (res) { //res 即为原始返回的数据
            return {
                "code": 0, //解析接口状态
                // "msg": res.message, //解析提示文本
                "count": res.total, //解析数据长度
                "data": res.message,
                /*"data": [
                                   {
                                       'id': 'T20190417000001',
                                       'username': '嘉文四世',
                                       'sex': 456,
                                       'city': '1:0.2',
                                       'sign': '2019年8月24日 15:52:04',
                                       'state': '待付款',
                                       'price': '2000.00',
                                       'details': '<a href="wallet/details.html">查看详情</a>'
                                   },
                                   {
                                       'id': 'T20190417000001',
                                       'username': '嘉文四世',
                                       'sex': 456,
                                       'city': '1:0.2',
                                       'sign': '2019年8月24日 15:52:04',
                                       'state': '待付款',
                                       'price': '2000.00',
                                       'details': '<a href="wallet/details.html">查看详情</a>'
                                   },
                                   {
                                       'id': 'T20190417000001',
                                       'username': '嘉文四世',
                                       'sex': 456,
                                       'city': '1:0.2',
                                       'sign': '2019年8月24日 15:52:04',
                                       'state': '待付款',
                                       'price': '2000.00',
                                       'details': '<a href="wallet/details.html">查看详情</a>'
                                   },
                                   {
                                       'id': 'T20190417000001',
                                       'username': '嘉文四世',
                                       'sex': 456,
                                       'city': '1:0.2',
                                       'sign': '2019年8月24日 15:52:04',
                                       'state': '待付款',
                                       'price': '2000.00',
                                       'details': '<a href="wallet/details.html">查看详情</a>'
                                   },
                                   {
                                       'id': 'T20190417000001',
                                       'username': '嘉文四世',
                                       'sex': 456,
                                       'city': '1:0.2',
                                       'sign': '2019年8月24日 15:52:04',
                                       'state': '待付款',
                                       'price': '2000.00',
                                       'details': '<a href="wallet/details.html">查看详情</a>'
                                   },
                                   {
                                       'id': 'T20190417000001',
                                       'username': '嘉文四世',
                                       'sex': 456,
                                       'city': '1:0.2',
                                       'sign': '2019年8月24日 15:52:04',
                                       'state': '待付款',
                                       'price': '2000.00',
                                       'details': '<a href="wallet/details.html">查看详情</a>'
                                   },
                                   {
                                       'id': 'T20190417000001',
                                       'username': '嘉文四世',
                                       'sex': 456,
                                       'city': '1:0.2',
                                       'sign': '2019年8月24日 15:52:04',
                                       'state': '待付款',
                                       'price': '2000.00',
                                       'details': '<a href="wallet/details.html">查看详情</a>'
                                   },
                               ]*/
            };
        }
        , cols: [[ //表头
            {field: 'sell_nickname', title: '卖出人', width: 80, fixed: 'left'}
            , {field: 'order', title: '交易号', width: 200}
            , {field: 'gxd', title: '贡献点', width: 80}
            , {field: 'balance', title: '现金', width: 80}
            , {field: 'amount', title: '单价', width: 200}
            , {field: 'status_name', title: '状态', width: 80}
            , {field: 'details', title: '详情',minWidth:120}
        ]]

    });
});