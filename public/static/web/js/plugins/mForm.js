layui.define(['layer', 'form'], function (exports) {

    var layer = layui.layer
        , form = layui.form
        , $ = layui.$;

    form.on('submit(form)', function (data) {

        var elem = data.elem;
        console.log(data);

        //判断并修改提交按钮
        if (elem.className.indexOf("layui-btn-disabled") != -1) {
            return false;
        } else {
            // 更改按钮状态
            elem.classList.add("layui-btn-disabled");
            elem.setAttribute('disabled', 'disabled');
            elem.innerHTML = '请稍候...' + '<i class="layui-anim layui-anim-rotate layui-anim-loop layui-icon layui-icon-loading-1"></i>';
        }

        //提交
        setTimeout(function () {

            $.post(data.form.action, data.field, function (data) {

                console.log(data);
                // 还原按钮状态
                elem.classList.remove("layui-btn-disabled");
                elem.removeAttribute('disabled');
                elem.textContent = '确认登录';

                if (data.status == 'success') {

                    if (data.url){

                        window.location.href = data.url;
                    }else{

                        layer.msg(data.message);
                    }
                } else {

                    layer.msg(data.message);
                }

            }, 'json')
        }, 500);
    });

    exports('mForm', {});
});