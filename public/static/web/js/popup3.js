layui.use('form', function () {
    var form = layui.form;

    form.on('switch(filter)', function (data) {
        var container = document.getElementById('container');
        var switchValue = document.getElementById('switchValue');
        if (data.elem.checked) {
            container.classList.add('show');
            switchValue.value = '10';
        } else {
            container.classList.remove('show');
            switchValue.value = '20';
        }
    });
});

function sel(obj) {
    var inp = document.getElementById('inp');
    inp.value = obj.value * 1000;
}


