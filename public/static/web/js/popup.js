var inp2 = document.getElementById('inp2');
var inp3 = document.getElementById('inp3');
// 获取单价
var amount = document.getElementById("amount");
var poundage_amount = document.getElementById("poundage");
var number = document.getElementById("number");

function val(obj) {

    if (inp1.value > 0) {

        var the_number = ( obj.value / Number(amount.innerText) ) + "";
        if (the_number.indexOf('.') != -1) {
            the_number = Number(poundage.split('.')[ 0 ]) + 1
        }
        //inp2.value = obj.value / Number(amount.innerText);
        inp2.value = the_number * poundage_amount.value;
        number.value = the_number;
        // console.log(poundage_amount.value);
    } else {
        inp2.value = 0;
        number.value = 0;
    }
}
	