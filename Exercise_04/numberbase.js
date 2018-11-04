function convertNumBase() {
	var input = document.getElementById("textfieldInput").value;
	var w = parseInt(input, 10).toString(2);
	var x = parseInt(input, 10).toString(5);
	var y = parseInt(input, 10).toString(8);
	var z = parseInt(input, 10).toString(16);
	
	document.getElementById("textarea1").value = w;
	document.getElementById("textarea2").value = x;
	document.getElementById("textarea3").value = y;
	document.getElementById("textarea4").value = z;
}