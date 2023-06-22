function criarPergunta(pergunta, tipo_resposta, respostas) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
      if (this.readyState == 4 && this.status == 200) 
      {
          console.log("Resposta: " + this.responseText);
      } else if (this.readyState < 4) 
            {
                console.log("Estado da requisição: " + this.readyState);
            } else {
                      console.log("Requisição falhou: " + this.status);
                  }
    }
    xmlhttp.open("POST", "http://localhost/trabalhorequisicao/validar.php");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("acao=criar&pergunta=" + encodeURIComponent(pergunta) + "&tipo_resposta=" + encodeURIComponent(tipo_resposta) + "&respostas=" + encodeURIComponent(respostas));
  }
  