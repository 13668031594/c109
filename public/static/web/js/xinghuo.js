noticeInit();

// 公告滚动初始化
function noticeInit() {
// 公告滚动条
    var announcement = document.getElementById('announcement');
    var minIndex = 0;
    var maxIndex = $(announcement).find('li').length - 1;
    var currentIndex = 0;
    var speed = 500;

    if (minIndex == maxIndex)
        return false;
    timer && clearInterval(timer);

    var timer = setInterval(function () {

        if (currentIndex == 0) {
            $(announcement).css('top', '0px');
            currentIndex++;
            return false;
        }

        $(announcement).animate({top: -(currentIndex * 30)}, speed);

        if (currentIndex >= maxIndex) {
            currentIndex = minIndex;
        } else {
            currentIndex++;
        }

    }, 5000);
}

function link(obj) {
    var aaa = false;
    var nodes = obj.parentNode.nextSibling;
    for (var i = 0; i < nodes.classList.length; i++) {
        if (nodes.classList[i] == 'show2') {
            aaa = true;
            break;
        } else {
            aaa = false;
        }
    }
    if (aaa == true) {
        nodes.classList.remove('show2');
    } else {
        nodes.classList.add('show2');
    }
}

// 显示付款信息
function showPay(obj) {
    var childNodes = obj.parentNode.children[3];
    if (childNodes.className.indexOf('layui-hide') != -1) {
        childNodes.classList.remove('layui-hide');
    } else {
        childNodes.classList.add('layui-hide');
    }
}

// 凭证上传
function onUpload(obj) {
    obj.nextElementSibling.click();
}

//查看凭证
function onSeeConfirm(obj, file) {
    if ($(obj.previousElementSibling)[0].files.length == 0) {

        layer.msg('请先上传凭证');
        return false;
    }
    var file1 = getObjectURL($(obj.previousElementSibling)[0].files[0]);
    layer.open({
        type: 1,
        offset: '50px',
        area: ['300px', '450px'],
        title: '已上传凭证',
        content: '<img src=' + file1 + ' style="max-width:300px;max-height:450px">',
        btn: '确定',
    });
}

// 打款确认
function onBuyConfirm(obj, id) {

    if ($(obj.previousElementSibling)[0].files.length == 0) {

        layer.msg('请先上传凭证');
        return false;
    }

    var file = $(obj.previousElementSibling)[0].files[0];

    layer.confirm('您确认已打款且上传了支付凭证？', function (index) {

        layer.close(index);
        var loadingIndex = layer.load();
        var formData = new FormData();

        formData.append('image', file);
        formData.append('id', id);

        $.ajax({
            type: 'POST',
            url: URL.BUY_CONFIRM + '/' + id,
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

// 收款确认
function onSellConfirm(id) {
    layer.confirm('您是否确认已收款？', function (index) {
        //console.log(res);
        layer.close(index);
        layer.load();
        $.get(URL.SELL_CONFIRM + '/' + id, {}, function (res) {
            location.reload();
        }, 'json')
    });
}

function viewImage() {
    location.href = 'https://img13.360buyimg.com/n1/jfs/t1/15588/32/3081/215653/5c237e16Ecefa0d19/e027c3df271aeaf2.jpg'
}

// 渲染列表每一项
function addListItem(item) {

    var typeStyle = item.typeName == '买入申请' ? 1 : 2;
    var string = "";

    string += '<div class="drop-down">';
    string += '<div class="list background-image' + typeStyle + '">';
    string += '<h1>' + item.typeName + '</h1>';
    string += '<h5>参与者：' + item.username + '</h5>';
    string += '<h5>申请单编号：' + item.orderNo + item.goodsName + '</h5>';
    string += '<h2>金额：' + item.amount + '(数量：' + item.number + ')</h2>';
    string += '<h5>状态：' + item.statusName + '</h5>';
    string += '<h5>日期：' + item.date + '</h5>';
    string += '<div class="link" onclick="link(this)"><i class="fa fa-arrow-right" style="color:#fff;"></i></div>';
    string += '</div>';


    if (item.children.length > 0) {
        string += '<div class="drop-down-content"><h5>已匹配金额：' + item.isExistTotal + '元</h5>';
        item.children.forEach(function (it, index) {

            var toString = "";
            if (typeStyle == 1) {
                toString += '<h3>';
                toString += '我 <i class="layui-icon layui-icon-next"></i>';
                toString += '<b>' + it.amount + '</b> <i class="layui-icon layui-icon-next"></i>';
                toString += it.to;
                toString += '</h3>';
            } else {
                toString += '<h3>';
                toString += it.from + ' <i class="layui-icon layui-icon-next"></i>';
                toString += '<b>' + it.amount + '</b> <i class="layui-icon layui-icon-next"></i>';
                toString += '我';
                toString += '</h3>';
            }

            string += '<div class="details background-image' + typeStyle + '"><h5>订单号' + it.buyNo + '(匹配买入订单' + it.sellNo + ')</h5>';
            string += '<div class="layui-row">';
            string += '<div class="layui-col-xs4"><h2>' + it.status + '</h2></div>';
            string += '<div class="layui-col-xs8">' + toString + '<h5>订单创建日期:' + it.date + '</h5></div>';
            string += '</div>';
            string += '<div class="link" onclick="showPay(this)"><i class="fa fa-arrow-right" style="color:#fff;"></i></div>';

            // 凭证
            string += '<div class="pay-info layui-hide">';
            string += '<p>打款人领导：' + it.buy_p + '</p>';
            string += '<p>打款人：' + it.buy_nickname + '</p>';

            if (typeStyle == 1) {
                // 银行信息
                string += '<ul class="bank">';
                string += '<li>银行名称:' + it.bank_name + '</li>';
                string += '<li class="card">银行卡号:' + it.bank_no + '</li>';
                string += '<li>开户地址:' + it.bank_address + '</li>';
                string += '<li>持卡人:' + it.bank_man + '</li>';
                string += '<li>支付宝:' + it.alipay + '</li>';
                string += '<li>备注:' + it.note + '</li>';
                string += '</ul>';

                string += '<p>收款人领导：' + it.sell_p + '</p>';
                string += '<p>收款人：' + it.sell_nickname + '</p>';
                string += '<div class="layui-btn-container">';
                // string += '<button type="button" onclick="onUpload(this)" class="layui-btn">上传付款凭证</button>';
                // string += '<input type="file" class="layui-hide"/>';
                // string += '<button type="button" onclick="onBuyConfirm(this,it.id)" class="layui-btn layui-btn-normal">确认</button>';
                string += '</div>';
                string += '</div>';

            } else {
                // 图片信息
                string += '<div class="pay-images">';
                string += '<a target="_parent" href="' + it.pay + '">';
                string += '<img src="' + it.pay + '"/>';
                string += '</a>';
                string += '</div>';

                string += '<p>收款人领导：' + it.buy_p + '</p>';
                string += '<p>收款人：' + it.buy_nickname + '</p>';
                string += '<div class="layui-btn-container">';
                // string += '<button type="button" onclick="onSellConfirm(1)" class="layui-btn layui-btn-normal">确认收款</button>';
                string += '</div>';
                string += '</div>';
            }

            string += '</div>';
        });

        string += '</div>';
    }

    return string;
}

// 填充数据
function fillData(data, dom) {
    var arr = [];
    layui.each(data, function (index, item) {
        arr.push('<li>' + addListItem(item) + '</li>');
    });
    dom.innerHTML = arr.join('');
}

//分页
var buyDom = document.getElementById('biuuu_city_list');
var sellDom = document.getElementById('biuuu_city_list2');

layui.use(['laypage', 'layer', 'element'], function () {
    var laypage = layui.laypage
        , element = layui.element
        , layer = layui.layer
        , $ = layui.$;

    // 获取买入订单数据
    $.getJSON(URL.BUY_LIST, {}, function (res) {
        laypage.render({
            elem: 'demo1'
            , limit: 20
            , count: res.data.count
            , layout: ['limit', 'count']
            , jump: function (obj, first) {
                if (first) {
                    fillData(res.data.message, buyDom);
                } else {
                    $.getJSON(URL.BUY_LIST, {t: '1', page: obj.curr}, function (res) {
                        fillData(res.data.message, buyDom);
                    });
                }
            }
        });
    });

    // 获取卖出订单数据
    $.getJSON(URL.SELL_LIST, {}, function (res) {
        laypage.render({
            elem: 'demo2'
            , limit: 20
            , count: res.data.count
            , layout: ['limit', 'count']
            , jump: function (obj, first) {
                if (first) {
                    fillData(res.data.message, sellDom);
                } else {
                    $.getJSON(URL.SELL_LIST, {t: '2', page: obj.curr}, function (res) {
                        fillData(res.data.message, sellDom);
                    });
                }
            }
        });
    })

});
//弹出窗口
layui.use('layer', function () {
    var $ = layui.jquery, layer = layui.layer;
    var active = {
        //买入弹出层
        mairu: function () {
            layer.open({
                type: 2,
                title: false,
                closeBtn: false,
                area: ['300px', '470px'],
                offset: 'auto',
                btn: ['提交', '取消'],
                btnAlign: 'c',
                moveType: 1,
                content: '/popup',
                success: function (layero, index) {
                    var body = layer.getChildFrame('body', index);
                    body.find("#min").html(GOODS_PARAMS.MIN_NUMBER);
                    body.find("#max").html(GOODS_PARAMS.MAX_NUMBER);
                    body.find("#amount").html(GOODS_PARAMS.AMOUNT);
                    body.find("#img").attr('src', GOODS_PARAMS.IMG);

                },
                yes: function (index, layero) {
                    var body = layer.getChildFrame('body', index);
                    // var poundage = ( body.find('#amount1')[0].value / Number(body.find('#amount')[0].innerText) ) + "";
                    // if (body.find('#inp2')[ 0 ].value > 0 && body.find('#inp1')[0].value.indexOf('.') <= 0) {
                    layer.confirm('您确定购买吗？', function (index1) {
                        layer.close(index1);
                        var index2 = layer.load(2);
                        var DATA = {
                            total: body.find('#inp1')[0].value,//订单总价
                            amount: body.find('#amount1')[0].value,//单价（嵌套获得）
                            number: body.find('#number')[0].value,//数量
                            poundage: body.find('#inp2')[0].value,//手续费（计算获得）
                            inPro: body.find('#inPro')[0].value,//收益率（嵌套获得）
                            time: body.find('#time')[0].value,//收益时间（嵌套获得）
                        };
                        console.log(body.find('#total'));
                        $.post('/buy', DATA, function (data) {

                            layer.close(index2);
                            if (data.status == 'success') {
                                layer.close(index);
                                layer.msg('操作成功');
                            } else {
                                layer.msg(data.message);
                            }

                        }, 'json')
                    });
                    // } else {
                    //     layer.msg('推广权金额必须为单价的整数倍');
                    // }

                }
            });
        }

        //卖出弹出层
        , maichu: function () {
            layer.open({
                type: 2,
                title: '卖出推广权',
                closeBtn: false,
                scrollbar: false,
                area: ['300px', '300px'],
                offset: 'auto',
                btn: ['提交', '取消'],
                btnAlign: 'c',
                content: 'popup2',
                success: function (layero, index) {
                    var body = layer.getChildFrame('body', index);
                    body.find("#sel").val(zhanghu);
                    body.find("#input1").val(bxyongyou);
                    body.find("#input2").val(bxkeyong);
                    body.find("#input3").val(jlyongyou);
                    body.find("#input4").val(jlkeyong);
                },
                yes: function (index, layero) {
                    var body = layer.getChildFrame('body', index);
                    var value3 = Number(body.find('#inp3')[0].value);
                    var value2 = Number(body.find('#inp2')[0].value);
                    var value1 = Number(body.find('#inp1')[0].value);
                    var value4 = body.find('#sel')[0].value;
                    if (value4 == 0) {
                        layer.msg('请选择账户');
                        return;
                    }
                    if (!value3 || isNaN(value3) || value3 < 0 || value3.toString().indexOf(".") > 0) {
                        layer.msg('卖出金额只能为正整数');
                        return;
                    }
                    if (value3 > value2) {
                        layer.msg('卖出金额必须小于可卖金额');
                        return;
                    }

                    layer.confirm('您确定卖出推广权吗？', function (index1) {
                        layer.close(index1);
                        var index2 = layer.load(2);
                        $.post('/sell', {
                            money: body.find('#inp1')[0].value,
                            quantity: body.find('#inp2')[0].value
                        }, function (data) {

                            layer.close(index2);
                            if (data.status == 'success') {
                                layer.close(index);
                                layer.msg('操作成功');
                            } else {
                                layer.msg(data.message);
                            }
                        })
                    });
                }
            });
        }

        //预约弹出层
        , yuyue: function () {
            layer.open({
                type: 2,
                title: '自动采集',
                closeBtn: false,
                scrollbar: false,
                area: ['300px', '450px'],
                offset: 'auto',
                btn: ['提交', '取消'],
                btnAlign: 'c',
                content: '/popup3',
                success: function (layero, index) {
                    var body = layer.getChildFrame('body', index);
                    body.find("#checkbox").attr("checked", autoSwitch);
                    body.find("#sel2").val(autoNumber);
                    body.find("#sel1").val(autoTimes);
                    body.find("#inp").val(autoAmount);
                    body.find("#span").html(autoAmount);
                    var string = '';
                    autoListData.forEach(function (item) {
                        // console.log(item);
                        string += '<div class="layui-form-item border-bottom">';
                        string += '<div class="list">';
                        string += '<div><i class="layui-icon">&#xe65e;</i>' + item.amount + '(' + item.number + '个单位)</div>';
                        string += '<div class="list-content"><i class="layui-icon">&#xe637;</i> 执行日期：' + item.date + '</div>';
                        string += '</div>';
                        string += '<div class="state">周期：' + item.time + '</div>';
                        string += '</div>';
                    });
                    body.find("#list").html(string);

                    if (autoSwitch) {
                        body.find("#container")[0].classList.add('show');
                    } else {
                        body.find("#container")[0].classList.remove('show');
                    }
                },

                yes: function (index, layero) {
                    var body = layer.getChildFrame('body', index);
                    var check = body.find('#checkbox')[0].value;
                    var data = {
                        time: body.find('#sel1')[0].value,
                        number: body.find('#sel2')[0].value,
                        // money: body.find('#inp')[ 0 ].value,
                        switchValue: body.find('#switchValue')[0].value,
                    };
                    console.log(data);
                    layer.confirm('您确定自动采集吗？', function (index1) {
                        layer.close(index1);
                        var index2 = layer.load(2);
                        $.post(URL.AUTO, data, function (res) {

                            layer.close(index2);
                            if (res.status == 'success') {

                                if (data.switchValue == '10'){

                                    autoSwitch = true;
                                }else{

                                    autoSwitch = false;
                                }
// console.log(autoSwitch);
                                layer.close(index);
                                layer.msg('操作成功');
                            } else {
                                layer.msg(res.message);
                            }
                        }, 'json')
                    });
                }
            });
        }
    };

    $('#layerDemo .layui-btn').on('click', function () {
        var othis = $(this), method = othis.data('method');
        active[method] ? active[method].call(this, othis) : '';
    });
});

