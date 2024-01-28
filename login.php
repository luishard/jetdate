
<?php

// Inclua a classe
include 'DatabaseConnection.php';

$host = "localhost:4306";
$username = "root";
$password = "";
$database = "jetdate";

// Crie uma instância da classe
$db = new DatabaseConnection($host, $username, $password, $database);

// Verifique o login do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['user']; // Substitua 'usuario' com o nome real do campo
    $senha = $_POST['password']; // Substitua 'senha' com o nome real do campo

    // Consulta para verificar as credenciais
    $sql = "SELECT * FROM user WHERE cpf = :usuario";
    $params = array(':usuario' => $usuario);

    $result = $db->query($sql, $params)->fetch();

    if ($result && password_verify($senha, $result['password_hash'])) {
        // Login correto
        echo "Login bem-sucedido!";
    } else {
        // Login incorreto
        echo "Login falhou. Verifique suas credenciais.";
    }
}

// Não se esqueça de fechar a conexão quando não for mais necessária
$db->closeConnection();

?>
