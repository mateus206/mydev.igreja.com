<?php

require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/eventosDAO.php';
require_once __DIR__ . '/../dao/ApoioSocialDAO.php';
require_once __DIR__ . '/../dao/PedidoOracaoDAO.php';
require_once __DIR__ . '/../dao/acaosolidariasDAO.php';
require_once __DIR__ . '/../dao/ContribuicaoDAO.php';
require_once __DIR__ . '/../dao/MinisterioInscricaoDAO.php';
require_once __DIR__ . '/../dao/NotificacaoDAO.php';

class WebController
{
    private function view($viewName, $data = [])
    {
        extract($data, EXTR_SKIP);
        require_once __DIR__ . "/../../public/views/{$viewName}.php";
    }

    private function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }

    private function toast(string $type, string $message): void
    {
        $_SESSION['toast'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public function index()
    {
        $this->view('home');
    }

    public function login()
    {
        $this->view('login');
    }

    public function dashboard()
    {
        $userCount = (new UserDAO())->getUsersCount();
        $eventCount = (new UserDAO())->getEventCount();
        $apoioSocialCount = (new UserDAO())->getApoioSocialCount();
        $pedidosOracaoCount = (new UserDAO())->getPedidosOracaoCount();
        $contribuicaoCount = (new ContribuicaoDAO())->countAll();
        $ministerioCount = (new MinisterioInscricaoDAO())->countAll();
        $notificacaoCount = (new NotificacaoDAO())->countAll();

        $this->view('dashboard', [
            'userCount' => $userCount,
            'eventCount' => $eventCount,
            'apoioSocialCount' => $apoioSocialCount,
            'pedidosOracaoCount' => $pedidosOracaoCount,
            'contribuicaoCount' => $contribuicaoCount,
            'ministerioCount' => $ministerioCount,
            'notificacaoCount' => $notificacaoCount
        ]);
    }

    public function users()
    {
        $users = (new UserDAO())->getUsers();
        $this->view('users', ['users' => $users]);
    }

    public function editUser()
    {
        $id = (int)($_GET['id'] ?? 0);
        $editUser = (new UserDAO())->findById($id);

        if (!$editUser) {
            $this->toast('error', 'Utilizador não encontrado.');
            $this->redirect('/users');
        }

        $users = (new UserDAO())->getUsers();
        $this->view('users', ['users' => $users, 'editUser' => $editUser]);
    }

    public function storeUser()
    {
        try {
            (new UserDAO())->create($_POST);
            $this->toast('success', 'Utilizador criado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao criar utilizador: ' . $e->getMessage());
        }

        $this->redirect('/users');
    }

    public function updateUser()
    {
        try {
            (new UserDAO())->update((int)$_POST['id'], $_POST);
            $this->toast('success', 'Utilizador atualizado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao atualizar utilizador: ' . $e->getMessage());
        }

        $this->redirect('/users');
    }

    public function deleteUser()
    {
        try {
            (new UserDAO())->delete((int)$_POST['id']);
            $this->toast('success', 'Utilizador apagado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao apagar utilizador: ' . $e->getMessage());
        }

        $this->redirect('/users');
    }

    public function eventos()
    {
        $eventos = (new EventoDAO())->findAll();
        $users = (new UserDAO())->getUsers();

        $this->view('eventos', [
            'eventos' => $eventos,
            'users' => $users
        ]);
    }

    public function editEvento()
    {
        $id = (int)($_GET['id'] ?? 0);
        $editEvento = (new EventoDAO())->findById($id);

        if (!$editEvento) {
            $this->toast('error', 'Evento não encontrado.');
            $this->redirect('/eventos');
        }

        $eventos = (new EventoDAO())->findAll();
        $users = (new UserDAO())->getUsers();
        $this->view('eventos', ['eventos' => $eventos, 'users' => $users, 'editEvento' => $editEvento]);
    }

    public function storeEvento()
    {
        try {
            (new EventoDAO())->createFromArray($_POST);
            $this->toast('success', 'Evento criado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao criar evento: ' . $e->getMessage());
        }

        $this->redirect('/eventos');
    }

    public function updateEvento()
    {
        try {
            (new EventoDAO())->update((int)$_POST['id'], $_POST);
            $this->toast('success', 'Evento atualizado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao atualizar evento: ' . $e->getMessage());
        }

        $this->redirect('/eventos');
    }

    public function deleteEvento()
    {
        try {
            (new EventoDAO())->delete((int)$_POST['id']);
            $this->toast('success', 'Evento apagado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao apagar evento: ' . $e->getMessage());
        }

        $this->redirect('/eventos');
    }

    public function apoioSociais()
    {
        $apoios = (new ApoioSocialDAO())->findAll();
        $users = (new UserDAO())->getUsers();

        $this->view('apoio_sociais', [
            'apoios' => $apoios,
            'users' => $users
        ]);
    }

    public function editApoioSocial()
    {
        $id = (int)($_GET['id'] ?? 0);
        $editApoio = (new ApoioSocialDAO())->findById($id);

        if (!$editApoio) {
            $this->toast('error', 'Apoio social não encontrado.');
            $this->redirect('/apoio-sociais');
        }

        $apoios = (new ApoioSocialDAO())->findAll();
        $users = (new UserDAO())->getUsers();
        $this->view('apoio_sociais', ['apoios' => $apoios, 'users' => $users, 'editApoio' => $editApoio]);
    }

    public function storeApoioSocial()
    {
        try {
            (new ApoioSocialDAO())->createFromArray($_POST);
            $this->toast('success', 'Pedido de apoio social criado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao criar apoio social: ' . $e->getMessage());
        }

        $this->redirect('/apoio-sociais');
    }

    public function updateApoioSocial()
    {
        try {
            (new ApoioSocialDAO())->update((int)$_POST['id'], $_POST);
            $this->toast('success', 'Apoio social atualizado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao atualizar apoio social: ' . $e->getMessage());
        }

        $this->redirect('/apoio-sociais');
    }

    public function deleteApoioSocial()
    {
        try {
            (new ApoioSocialDAO())->delete((int)$_POST['id']);
            $this->toast('success', 'Apoio social apagado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao apagar apoio social: ' . $e->getMessage());
        }

        $this->redirect('/apoio-sociais');
    }

    public function pedidoOracoes()
    {
        $pedidos = (new PedidoOracaoDAO())->findAll();
        $users = (new UserDAO())->getUsers();

        $this->view('pedido_oracoes', [
            'pedidos' => $pedidos,
            'users' => $users
        ]);
    }

    public function editPedidoOracao()
    {
        $id = (int)($_GET['id'] ?? 0);
        $editPedido = (new PedidoOracaoDAO())->findById($id);

        if (!$editPedido) {
            $this->toast('error', 'Pedido de oração não encontrado.');
            $this->redirect('/pedido-oracoes');
        }

        $pedidos = (new PedidoOracaoDAO())->findAll();
        $users = (new UserDAO())->getUsers();
        $this->view('pedido_oracoes', ['pedidos' => $pedidos, 'users' => $users, 'editPedido' => $editPedido]);
    }

    public function storePedidoOracao()
    {
        try {
            (new PedidoOracaoDAO())->createFromArray($_POST);
            $this->toast('success', 'Pedido de oração criado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao criar pedido de oração: ' . $e->getMessage());
        }

        $this->redirect('/pedido-oracoes');
    }

    public function updatePedidoOracao()
    {
        try {
            (new PedidoOracaoDAO())->update((int)$_POST['id'], $_POST);
            $this->toast('success', 'Pedido de oração atualizado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao atualizar pedido de oração: ' . $e->getMessage());
        }

        $this->redirect('/pedido-oracoes');
    }

    public function deletePedidoOracao()
    {
        try {
            (new PedidoOracaoDAO())->delete((int)$_POST['id']);
            $this->toast('success', 'Pedido de oração apagado com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao apagar pedido de oração: ' . $e->getMessage());
        }

        $this->redirect('/pedido-oracoes');
    }

    public function acaoSolidarias()
    {
        $acoes = (new AcaoSolidariaDAO())->findAll();
        $users = (new UserDAO())->getUsers();

        $this->view('acao_solidarias', [
            'acoes' => $acoes,
            'users' => $users
        ]);
    }

    public function editAcaoSolidaria()
    {
        $id = (int)($_GET['id'] ?? 0);
        $editAcao = (new AcaoSolidariaDAO())->findById($id);

        if (!$editAcao) {
            $this->toast('error', 'Ação solidária não encontrada.');
            $this->redirect('/acao-solidarias');
        }

        $acoes = (new AcaoSolidariaDAO())->findAll();
        $users = (new UserDAO())->getUsers();
        $this->view('acao_solidarias', ['acoes' => $acoes, 'users' => $users, 'editAcao' => $editAcao]);
    }

    public function storeAcaoSolidaria()
    {
        try {
            (new AcaoSolidariaDAO())->createFromArray($_POST);
            $this->toast('success', 'Ação solidária criada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao criar ação solidária: ' . $e->getMessage());
        }

        $this->redirect('/acao-solidarias');
    }

    public function updateAcaoSolidaria()
    {
        try {
            (new AcaoSolidariaDAO())->update((int)$_POST['id'], $_POST);
            $this->toast('success', 'Ação solidária atualizada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao atualizar ação solidária: ' . $e->getMessage());
        }

        $this->redirect('/acao-solidarias');
    }

    public function deleteAcaoSolidaria()
    {
        try {
            (new AcaoSolidariaDAO())->delete((int)$_POST['id']);
            $this->toast('success', 'Ação solidária apagada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao apagar ação solidária: ' . $e->getMessage());
        }

        $this->redirect('/acao-solidarias');
    }


    public function contribuicoes()
    {
        $contribuicoes = (new ContribuicaoDAO())->findAll();
        $users = (new UserDAO())->getUsers();
        $this->view('contribuicoes', ['contribuicoes' => $contribuicoes, 'users' => $users]);
    }

    public function editContribuicao()
    {
        $id = (int)($_GET['id'] ?? 0);
        $editContribuicao = (new ContribuicaoDAO())->findById($id);
        if (!$editContribuicao) {
            $this->toast('error', 'Contribuição não encontrada.');
            $this->redirect('/contribuicoes');
        }
        $contribuicoes = (new ContribuicaoDAO())->findAll();
        $users = (new UserDAO())->getUsers();
        $this->view('contribuicoes', ['contribuicoes' => $contribuicoes, 'users' => $users, 'editContribuicao' => $editContribuicao]);
    }

    public function storeContribuicao()
    {
        try {
            (new ContribuicaoDAO())->createFromArray($_POST);
            $this->toast('success', 'Contribuição criada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao criar contribuição: ' . $e->getMessage());
        }
        $this->redirect('/contribuicoes');
    }

    public function updateContribuicao()
    {
        try {
            (new ContribuicaoDAO())->update((int)$_POST['id'], $_POST);
            $this->toast('success', 'Contribuição atualizada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao atualizar contribuição: ' . $e->getMessage());
        }
        $this->redirect('/contribuicoes');
    }

    public function deleteContribuicao()
    {
        try {
            (new ContribuicaoDAO())->delete((int)$_POST['id']);
            $this->toast('success', 'Contribuição apagada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao apagar contribuição: ' . $e->getMessage());
        }
        $this->redirect('/contribuicoes');
    }

    public function ministeriosInscricoes()
    {
        $inscricoes = (new MinisterioInscricaoDAO())->findAll();
        $users = (new UserDAO())->getUsers();
        $this->view('ministerios_inscricoes', ['inscricoes' => $inscricoes, 'users' => $users]);
    }

    public function editMinisterioInscricao()
    {
        $id = (int)($_GET['id'] ?? 0);
        $editInscricao = (new MinisterioInscricaoDAO())->findById($id);
        if (!$editInscricao) {
            $this->toast('error', 'Inscrição não encontrada.');
            $this->redirect('/ministerios-inscricoes');
        }
        $inscricoes = (new MinisterioInscricaoDAO())->findAll();
        $users = (new UserDAO())->getUsers();
        $this->view('ministerios_inscricoes', ['inscricoes' => $inscricoes, 'users' => $users, 'editInscricao' => $editInscricao]);
    }

    public function storeMinisterioInscricao()
    {
        try {
            (new MinisterioInscricaoDAO())->createFromArray($_POST);
            $this->toast('success', 'Inscrição criada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao criar inscrição: ' . $e->getMessage());
        }
        $this->redirect('/ministerios-inscricoes');
    }

    public function updateMinisterioInscricao()
    {
        try {
            (new MinisterioInscricaoDAO())->update((int)$_POST['id'], $_POST);
            $this->toast('success', 'Inscrição atualizada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao atualizar inscrição: ' . $e->getMessage());
        }
        $this->redirect('/ministerios-inscricoes');
    }

    public function deleteMinisterioInscricao()
    {
        try {
            (new MinisterioInscricaoDAO())->delete((int)$_POST['id']);
            $this->toast('success', 'Inscrição apagada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao apagar inscrição: ' . $e->getMessage());
        }
        $this->redirect('/ministerios-inscricoes');
    }

    public function notificacoes()
    {
        $notificacoes = (new NotificacaoDAO())->findAll();
        $users = (new UserDAO())->getUsers();
        $this->view('notificacoes', ['notificacoes' => $notificacoes, 'users' => $users]);
    }

    public function editNotificacao()
    {
        $id = (int)($_GET['id'] ?? 0);
        $editNotificacao = (new NotificacaoDAO())->findById($id);
        if (!$editNotificacao) {
            $this->toast('error', 'Notificação não encontrada.');
            $this->redirect('/notificacoes');
        }
        $notificacoes = (new NotificacaoDAO())->findAll();
        $users = (new UserDAO())->getUsers();
        $this->view('notificacoes', ['notificacoes' => $notificacoes, 'users' => $users, 'editNotificacao' => $editNotificacao]);
    }

    public function storeNotificacao()
    {
        try {
            (new NotificacaoDAO())->createFromArray($_POST);
            $this->toast('success', 'Notificação criada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao criar notificação: ' . $e->getMessage());
        }
        $this->redirect('/notificacoes');
    }

    public function updateNotificacao()
    {
        try {
            (new NotificacaoDAO())->update((int)$_POST['id'], $_POST);
            $this->toast('success', 'Notificação atualizada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao atualizar notificação: ' . $e->getMessage());
        }
        $this->redirect('/notificacoes');
    }

    public function deleteNotificacao()
    {
        try {
            (new NotificacaoDAO())->delete((int)$_POST['id']);
            $this->toast('success', 'Notificação apagada com sucesso.');
        } catch (Exception $e) {
            $this->toast('error', 'Erro ao apagar notificação: ' . $e->getMessage());
        }
        $this->redirect('/notificacoes');
    }

    public function campanhas()
    {
        $this->view('campanhas');
    }

    public function verifyEmail(string $token): void
    {
        $this->view("verify-email", ["token" => $token]);
    }
}
