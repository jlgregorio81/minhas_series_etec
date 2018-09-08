<?php
namespace app\model;
use util\Connection;

final class Genero{

    private $id;
    private $nome;

    //nome da tabela
    private $TABELA = 'genero';
    //nomes dos campos
    private $TBL_ID = 'id';
    private $TBL_NOME = 'nome';

    public function __construct($id = null, 
        $nome = null){
        $this->id = $id;
        $this->nome = $nome;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function persistir(){
        try{
            $sql = null;            
            if($this->id == null){
            $sql = "insert into $this->TABELA " .
                   "($this->TBL_NOME) values (:nome)";            
            } else {
                $sql = "update $this->TABELA set $this->TBL_NOME = :nome " . 
                       "where $this->TBL_ID = :id";
            }                   
            $conn = Connection::getConnection()->prepare($sql);
            $conn->bindValue(':nome', $this->nome);
            
            if($this->id != null)
                $conn->bindValue(':id',$this->id);            
            
            return $conn->execute();            
        } catch(\Exception $ex){
            throw $ex;
        } finally{        
            unset($conn);            
        }
    }    

    public function excluir($id)
    {
        try{
            $sql = "delete from {$this->TABELA} where " .
              " {$this->TBL_ID} = :id";
            $conn = Connection::getConnection()->prepare($sql);
            $conn->bindValue(':id',$id);
            return $conn->execute();
        } catch (\Exception $ex){
            throw $ex;    
        } finally {
            unset($conn);
        }
    }


    public function recuperarPorId($id)
    {
        try{
            $sql = "select * from {$this->TABELA} where " . 
                " {$this->TBL_ID} = :id";
            $qry = Connection::getConnection()->prepare($sql);
            $qry->bindValue(':id', $id);
            $qry->execute();
            $result = $qry->fetchAll(\PDO::FETCH_ASSOC);            
            if($result)
                return new Genero($result[0]['id'],
                           $result[0]['nome']);
            else
                return null;
        } catch (\Exception $ex){
            throw $ex;    
        } finally {
            unset($conn);
        }  

    }

    public function listar($nome = '')
    {
        try{
            $sql = "select * from {$this->TABELA} where " . 
              " upper({$this->TBL_NOME}) like upper(:nome)";
            $qry = Connection::getConnection()->prepare($sql);
            $qry->bindValue(':nome', $nome . '%'); 
            $qry->execute();
            $result = $qry->fetchAll(\PDO::FETCH_ASSOC);            
            if($result){
                $lista = null;
                foreach($result as $linha){
                    $lista[] = new Genero($linha['id'],$linha['nome']);
                }
                return $lista;
            }
            else{
                return null;
            }
        } catch (\Exception $ex){
            throw $ex;    
        } finally {
            unset($conn);
        }              
    }

    
}