<!-- Esta página é referente ao registro do funcionários, assim, inserindo funcionários no banco de dados  -->
<div class="funcionario-registro">
  <div>
    <h1 class="h1custom">Registro de funcionário</h1>
  </div>
  <div class="fundo-funcionario">
    <form name="registro_funcionario" action="?pas=funcionario&arq=operacoes" method="POST" onsubmit="return validarRegistroF()">
      <div>
        <input type="hidden" name="operacao" value="1">
        <label for="nome">Nome Completo:</label>
        <input type="text" name="nome" id="nome" maxlength="45">
      </div>
      <div>
        <label for="mail">Email:</label>
        <input type="text" name="email" id="mail" maxlength="100">
      </div>
      <div>
        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" maxlength="14">
      </div>
      <div>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" maxlength="20">
      </div>
      <div>
        <label for="senha">Senha:</label maxlength="32">
        <input type="password" name="senha" id="senha">
      </div>
      <div>
        <button class="botao btn-limpar" type="reset">Limpar</button>
        <button class="botao btn-registro" type="submit">Registrar</button>
      </div>
    </form>
  </div>
</div>
