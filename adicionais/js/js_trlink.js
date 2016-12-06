/*
* Nome : Gustavo Camargo
* Criação: 17/11/2016
* Modificação: 17/11/2016
*/

$(document).ready(function(){
  $('#tr-link tbody tr').click(function(){
      window.location = $(this).attr('href');
      return false;
  });
});

$(function(){
	$('#dp1').fdatepicker({
		initialDate: '02-12-1989',
		format: 'mm-dd-yyyy',
		disableDblClickSelection: true,
		leftArrow:'<<',
		rightArrow:'>>',
		closeIcon:'X',
		closeButton: true
	});
});