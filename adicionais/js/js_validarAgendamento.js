function validarAgendamento(){
  var novoAgendamento = confirm("Existe necessidade de agendar uma nova reunião?\n\nOK - Sim \nCancelar - Não");
    if(novoAgendamento==true){
        document.getElementById('status').innerHTML='<input type="hidden" name="hidstatus" value="Incompleto">';
        return true;
      }else{
          return true;
        }
}