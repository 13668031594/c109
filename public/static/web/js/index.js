var menu = document.getElementById('menu');
var introduce = document.getElementById('introduce');

function bottom_menu(obj) {
    var hide = document.getElementById('hide');
    hide.classList.add('container-hide');
    menu.classList.add('show');
}

function hide(obj) {
    menu.classList.remove('show');
    obj.classList.remove('container-hide');
}

function page(obj) {
    introduce.src = obj.dataset.menu;
}