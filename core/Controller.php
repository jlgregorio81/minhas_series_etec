<?php
namespace core;

abstract class Controller
{

    protected $get;
    protected $post;
    protected $request;


    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->request = $_REQUEST;
    }

    public abstract function exibirView();

    public abstract function exibirList();

    public abstract function salvar();

    public abstract function excluir();

    public abstract function criarModel();

    public function processar()
    {
        if ($this->post['comando']) {
            $comando = strtolower($this->post['comando']);
            switch ($comando) {
                case 'salvar':
                    $this->salvar();
                    break;
                case 'excluir':
                    $this->excluir();
                    break;
                case 'limpar':
                    $this->exibirView();
                    break;
                case 'exibirView':
                    $this->exibirView();
                    break;
                case 'exibirList':
                    $this->exibirList();
                    break;
                default:
                    break;
            }
        }
    }


}
