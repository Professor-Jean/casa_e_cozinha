/*
Data: 15/10/2016.
Desenvolvedor: GUstavo de Camargo.
 */
$(document).ready(function(){
    $('#calendario').fullCalendar({
      events: "adicionais/php/php_eventocalendario.php",
      header:{
        left: "prev,next today",
        center:"title",
        right: ""
      },
      eventClick: function(calEvent, jsEvent, view) {
        window.location.replace("?pas=projeto&arq=consultadetalhada&pro="+calEvent.id);
      }
    });
  });
