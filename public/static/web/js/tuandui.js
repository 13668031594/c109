

layui.use('element', function(){
    var element = layui.element;

});
//选项卡1
function menu(obj){
    var news = obj.parentNode.parentNode.childNodes[3];
    if (news.className.indexOf('show') != -1)
    {
        news.classList.remove('show');
    }else{
        news.classList.add('show');
    }
}