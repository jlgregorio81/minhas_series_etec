<?php
namespace app\model;

use util\Connection;

final class Serie
{

    private $id;
    private $nome;
    private $temporadas;
    private $anoInicio;
    private $anoFim;
    private $genero;
    private $imagem;

    public function __construct($id = null, $nome = null, $temporadas = null, $anoInicio = null, $anoFim = null, Genero $genero = null, $imagem = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->temporadas = $temporadas;
        $this->anoInicio = $anoInicio;
        $this->anoFim = $anoFim;
        $this->genero = is_null($genero) ? new Genero() : $genero;
        $this->imagem = $imagem;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @return  self
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of temporadas
     */
    public function getTemporadas()
    {
        return $this->temporadas;
    }

    /**
     * Set the value of temporadas
     *
     * @return  self
     */
    public function setTemporadas($temporadas)
    {
        $this->temporadas = $temporadas;

        return $this;
    }

    /**
     * Get the value of anoInicio
     */
    public function getAnoInicio()
    {
        return $this->anoInicio;
    }

    /**
     * Set the value of anoInicio
     *
     * @return  self
     */
    public function setAnoInicio($anoInicio)
    {
        $this->anoInicio = $anoInicio;

        return $this;
    }

    /**
     * Get the value of anoFim
     */
    public function getAnoFim()
    {
        return $this->anoFim;
    }

    /**
     * Set the value of anoFim
     *
     * @return  self
     */
    public function setAnoFim($anoFim)
    {
        $this->anoFim = $anoFim;

        return $this;
    }

    /**
     * Get the value of genero
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set the value of genero
     *
     * @return  self
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get the value of imagem
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set the value of imagem
     *
     * @return  self
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;

        return $this;
    }


    public function persistir()
    {
        try {
            $sql = null;
            if ($this->id == null) {
                $sql = "insert into serie " .
                    "(nome, temporadas, ano_inicio, ano_fim, genero, imagem) 
                     values (:nome, :temporadas, :ano_inicio, :ano_fim, :genero, :imagem )";
            } else {
                $sql = "update genero set nome = :nome, temporadas = :temporadas, ano_inicio = :ano_inicio, ano_fim = :ano_fim, genero = :genero, imagem = :imagem " .
                    " where id = :id";
            }
            $conn = Connection::getConnection()->prepare($sql);
            $conn->bindValue(':nome', $this->nome);
            $conn->bindValue(':temporadas', $this->temporadas);
            $conn->bindValue(':ano_inicio', $this->anoInicio);
            $conn->bindValue(':ano_fim', $this->anoFim);
            $conn->bindValue(':genero', $this->genero->getId());
            $conn->bindValue(':imagem', $this->imagem);

            if ($this->id != null)
                $conn->bindValue(':id', $this->id);

            return $conn->execute();
        } catch (\Exception $ex) {
            throw $ex;
        }
        finally {
            unset($conn);
        }
    }

    public function excluir($id)
    {
        try {
            $sql = "delete from serie where " .
                " id = :id";
            $conn = Connection::getConnection()->prepare($sql);
            $conn->bindValue(':id', $id);
            return $conn->execute();
        } catch (\Exception $ex) {
            throw $ex;
        }
        finally {
            unset($conn);
        }
    }


    public function recuperarPorId($id)
    {
        try {
            $sql = "select * from serie where " .
                " id = :id";
            $qry = Connection::getConnection()->prepare($sql);
            $qry->bindValue(':id', $id);
            $qry->execute();
            $result = $qry->fetchAll(\PDO::FETCH_ASSOC);
            if ($result) {
                $genero = (new Genero())->recuperarPorId($result[0]['genero']);
                return new Serie($result[0]['id'], $result[0]['nome'], $result[0]['temporadas'], $result[0]['ano_inicio'], $result[0]['ano_fim'], $genero, $result[0]['imagem']);
            } else
                return null;
        } catch (\Exception $ex) {
            throw $ex;
        }
        finally {
            unset($conn);
        }

    }

    public function listar($nome = null, $genero = null, $orderBy = null)
    {
        try {
            $sql = "select * from serie where 1=1 " ;
            if($nome)
                $sql .= " and upper(nome) like upper(:nome) ";
            if($genero)
                $sql .= " and genero = :genero ";
            if($orderBy)
                $sql .= " order by $orderBy";
            
            echo $sql;
                    
            $qry = Connection::getConnection()->prepare($sql);
            
            if($nome)
                $qry->bindValue(':nome', $nome . '%');
            if($genero)
            $qry->bindValue(':genero', $genero);
            
            $qry->execute();
            $result = $qry->fetchAll(\PDO::FETCH_ASSOC);
            if ($result) {
                $lista = null;
                foreach ($result as $linha) {
                    $genero = (new Genero())->recuperarPorId($linha['genero']);
                    $lista[] = new Serie($linha['id'], $linha['nome'], $linha['temporadas'], $linha['ano_inicio'], $linha['ano_fim'], $genero, $linha['imagem']);
                }
                return $lista;
            } else {
                return null;
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
        finally {
            unset($conn);
        }
    }



}