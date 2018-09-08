<?php
namespace app\controller;

use core\Controller;
use app\model\Genero;
use app\view\genero\GeneroView;
use core\view\HtmlMessage;


class GeneroCtr extends Controller
{
    /**
     * Cria um novo objeto model a partir dos dados do formulário
     */
    public function criarModel()
    {
        if (!is_null($this->post['id'])) {
            return new Genero($this->post['id'], $this->post['nome']);
        }
    }


    /**
     * Exibe a view de cadastro
     */
    public function exibirView()
    {
        //..cria uma nova view
        $genView = new GeneroView();
        //..se algum id for informato no get, então recupera o genero mediante o id
        if (isset($this->get['id'])) {
            $id = $this->get['id'];
            $genModel = (new Genero())->recuperarPorId($id);
            $genView->setModel($genModel);
        }
        $genView->show();
    }

    public function salvar()
    {
        $msg = null;
        try {
            $gen = $this->criarModel();
            $gen->persistir();
            $msg = new HtmlMessage("Mensagem", "Gênero Salvo/Atualizado com sucesso!");
        } catch (\Exception $ex) {
            $msg = new HtmlMessage("Mensagem de Erro", "Erro: {$ex->getMessage()}");
        }
        finally {
            $msg->show();
        }
    }

    public function exibirList()
    {

    }

    public function excluir()
    {
        try {
            if (!is_null($this->post['id'])) {
                $id = $this->post['id'];
                (new Genero())->excluir($id);
                $msg = new HtmlMessage("Mensagem", "Gênero excluído com sucesso!");
            }
        } catch (\Exception $ex) {
            $msg = new HtmlMessage("Mensagem de Erro", "Erro: {$ex->getMessage()}");
        }
        finally {
            $msg->show();
        }
    }


}