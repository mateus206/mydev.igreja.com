<?php
require_once __DIR__ . '/../dao/UserDAO.php';
//require_once __DIR__ . '/../dao/EmailVerificationDAO.php';

class AuthController
{

  private function view($name, $data = [])
  {
    extract($data, EXTR_SKIP);
    
    require __DIR__ . '/../../public/views/' . $name . '.php';
  }

 public function loginWeb()
    {
        //var_dump("Estou no login a validar os dados");
        // Apanhar os dados do formulário
        $email = trim($_POST['email']) ?? '';
 
        $password = trim($_POST['password']) ?? '';
 
        // Se não houver email ou password, mostrar erro
        // é preciso lançar exceção para o index.php apanhar e mostrar o erro via flash message
        if (empty($email) || empty($password)) {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Email e password são OBRIGATÓRIOS!'
            ];
            header("Location: /login");
            exit;
        }
 
        $user = (new UserDAO())->findByEmail($email);
        // var_dump(password_verify($password, $user->getPasswordEmail()));
 
        if (!$user) {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Email ou password inválidos ou não existe conta com esse email'
            ];
            header("Location: /login");
            exit;
        }
 
 
        // Utilizador foi encontrado - verificar password
        if (password_verify($password, $user->getPassword())) {
            //var_dump("Password correta");
            $_SESSION['token'] = [
                'id' => $user->getId(),
                'username' => $user->getNome(),
                'email' => $user->getEmail(),
                'is_admin' => $user->getIsAdmin()
            ];
            // Password correta - criar sessão
            //$_SESSION['user_id'] = $user->id;
            //$_SESSION['username'] = $user->username;
 
            // Redirecionar para a home
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => "Bem-vindo de volta, " . $user->getNome() . "!"
            ];
 
            header("Location: /dashboard");
            exit;
 
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => "Dados de login inválidos"
            ];
            header("Location: /login");
            exit;
        }
 
    }


}
