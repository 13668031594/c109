


var inp1 = document.getElementById('inp1');
var inp2 = document.getElementById('inp2');
var span1 = document.getElementById('span1');
var span2 = document.getElementById('span2');

function sel(obj){
	if (obj.value == 0)
	{
		inp1.value = '';
		inp2.value = '';
	}
	if (obj.value == 1)
	{
		inp1.value = input1.value;
		inp2.value = input2.value;
	}
	if (obj.value == 2)
	{
		inp1.value = input3.value;
		inp2.value = input4.value;
	}
}