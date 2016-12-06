  <h1 class="titulo-pagina">Registro de Cliente</h1>
  <form onsubmit="return validarRegCliente()" name="frmcadcliente" method="POST" action="?pas=cliente&arq=operacoes">
    <div class="formulario-registro">
      <div>
        <label class="alinhar-inputs">Nome Completo: *</label>
        <input class="inputs-registro" type="text" name="txtnome" placeholder="Carlos Marques" maxlength="45"></input>
      </div>
      <div>
        <label class=" alinhar-inputs">E-mail: </label>
        <input class="inputs-registro" type="text" name="txtemail" placeholder="capital@gmail.com" maxlength="100"></input>
      </div>
      <div>
        <label class="alinhar-inputs">Telefone: *</label>
        <input class="inputs-registro" type="text" name="txtfone" placeholder="40028922" maxlength="12" id="telefone"></input>
      </div>
      <div>
        <label class="alinhar-inputs">RG: </label>
        <input class="inputs-registro" type="text" name="txtrg" placeholder="xxxxxxx" maxlength="10" id="rg"></input>
      </div>
      <div>
        <label class=" alinhar-inputs">CPF: </label>
        <input class="inputs-registro" type="text" name="txtcpf" placeholder="xxxxxxxxxxx" maxlength="11" id="cpf"></input>
      </div>
      <div>
        <label class=" alinhar-inputs">Cidade: </label>
        <input class="inputs-registro" type="text" name="txtcidade" placeholder="Joinville" maxlength="30"></input>
      </div>
      <div>
        <label class=" alinhar-inputs">Bairro: </label>
        <input class="inputs-registro" type="text" name="txtbairro" placeholder="Iriríu" maxlength="20"></input>
      </div>
      <div>
        <label class=" alinhar-inputs">Logradouro: </label>
        <input class="inputs-registro" type="text" name="txtlogradouro" placeholder="Local de logradouro" maxlength="45"></input>
      </div>
      <div>
        <label class=" alinhar-inputs">Complemento: </label>
        <input class="inputs-registro" type="text" name="txtcomplemento" placeholder="105/casa" maxlength="20"></input>
      </div>
      <div>
        <label class=" alinhar-inputs">Número da Residência: </label>
        <input class="inputs-registro" type="text" name="txtnumero" placeholder="106" maxlength="5" ></input>
      </div>
      <input type="hidden" name="op" value="registro"></input>
      <div class="alinhar-btns-formulario">
          <label><button class="btn-resetar" type="reset"><img class="imagem-dentro-btn" src="layout/imagens/apagar.png" width="10%" height="8%">Limpar</button></label>
          <button class="btn-registrar" type="submit">Registrar</button>
      </div>
    </div>
  </form>
