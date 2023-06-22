<?php
$servername = "localhost";
$username = "higor";
$password = "93530504@Vhf";
$dbname = "cliente";

function criarPergunta($pergunta, $tipo_resposta, $respostas)
{
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("falha na conexão com o banco meu mano: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO perguntas (pergunta, tipo_resposta, respostas) VALUES (?, ?, ?)");
    
    if (!$stmt) {
        die("erro na consulta, aff: " . $conn->error);
    }
    
    $stmt->bind_param("sss", $pergunta, $tipo_resposta, $respostas);

    if ($stmt->execute()) {
        echo "Sua pergunta foi criada!";
    } else {
        echo "Erro ao criar a pergunta: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

function alterarPergunta($id_pergunta, $nova_pergunta, $novas_respostas)
{
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("falha na conexão, meu Deus: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE perguntas SET pergunta = ?, respostas = ? WHERE id = ?");
    
    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    
    $stmt->bind_param("ssi", $nova_pergunta, $novas_respostas, $id_pergunta);

    if ($stmt->execute()) {
        echo "Alteração feita!";
    } else {
        echo "Erro ao alterar a pergunta: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

function listarPerguntas()
{
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("falhou!!!!: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM perguntas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . "<br>";
            echo "Pergunta: " . $row["pergunta"] . "<br>";
            echo "Tipo de Resposta: " . $row["tipo_resposta"] . "<br>";
            echo "Respostas: " . $row["respostas"] . "<br><br>";
        }
    } else {
                echo "Não existem perguntas cadastradas.";
            }

    $conn->close();
}

function listarPergunta($id_pergunta)
{
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) 
    {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM perguntas WHERE id = ?");
    
    if (!$stmt) 
    {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    
    $stmt->bind_param("i", $id_pergunta);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) 
    {
        $row = $result->fetch_assoc();
        echo "ID: " . $row["id"] . "<br>";
        echo "Pergunta: " . $row["pergunta"] . "<br>";
        echo "Tipo de Resposta: " . $row["tipo_resposta"] . "<br>";
        echo "Respostas: " . $row["respostas"] . "<br>";
    } else 
    {
        echo "ID inválido!";
    }

    $stmt->close();
    $conn->close();
}

function excluirPergunta($id_pergunta)
{
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) 
    {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }


    $stmt = $conn->prepare("DELETE FROM perguntas WHERE id = ?");
    
    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    
    $stmt->bind_param("i", $id_pergunta);

    if ($stmt->execute() === TRUE) {
        echo "Exclusão feita!";
    } else {
        echo "Erro ao excluir a pergunta: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

if (isset($_POST['acao'])) {
$acao = $_POST['acao'];

switch ($acao) {
    case 'criar':
        if (isset($_POST['pergunta']) && isset($_POST['tipo_resposta']) && isset($_POST['respostas'])) {
            $pergunta = $_POST['pergunta'];
            $tipo_resposta = $_POST['tipo_resposta'];
            $respostas = $_POST['respostas'];

            criarPergunta($pergunta, $tipo_resposta, $respostas);
        }
        break;
    case 'alterar':
        if (isset($_POST['id_pergunta']) && isset($_POST['nova_pergunta']) && isset($_POST['novas_respostas'])) {
            $id_pergunta = $_POST['id_pergunta'];
            $nova_pergunta = $_POST['nova_pergunta'];
            $novas_respostas = $_POST['novas_respostas'];

            alterarPergunta($id_pergunta, $nova_pergunta, $novas_respostas);
        }
        break;
    case 'listar':
        listarPerguntas();
        break;
    case 'listar_uma':
        if (isset($_POST['id_pergunta_listar'])) {
            $id_pergunta_listar = $_POST['id_pergunta_listar'];

            listarPergunta($id_pergunta_listar);
        }
        break;
    case 'excluir':
        if (isset($_POST['id_pergunta_excluir'])) {
            $id_pergunta_excluir = $_POST['id_pergunta_excluir'];

            excluirPergunta($id_pergunta_excluir);
        }
        break;
    default:
        echo "Ação inválida!";
        break;
}
}
