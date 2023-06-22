function alterarPergunta(id_pergunta, nova_pergunta, novas_respostas) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
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
    xmlhttp.send("acao=alterar&id_pergunta=" + encodeURIComponent(id_pergunta) + "&nova_pergunta=" + encodeURIComponent(nova_pergunta) + "&novas_respostas=" + encodeURIComponent(novas_respostas));
  }
  