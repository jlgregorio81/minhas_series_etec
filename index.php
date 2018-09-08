<?php

use app\view\home\Home;
use app\model\Genero;
use app\model\Serie;

require_once('autoload.php');

//..cria uma nova view e a exibe.
(new Home())->show();


//use app\model\Genero;
//use app\view\genero\GeneroView;



/*
//sem informar o id no construtor: inserção
$gen = new Genero(null,'Aventura');
$gen->persistir();
 */

//..informando o id no construtor: atualização
//$gen = new Genero(21,'Ficção Científica');
//$gen->persistir();

//..recupera um genero por id
//$gen = (new Genero())->recuperarPorId(22);
//var_dump($gen);

//..exclui um registro do BD
//(new Genero())->excluir(22);

//..consulta todos os generos da tabela
//$lista = (new Genero())->listar();
//..consulta os generos que começam com a letra a
//$lista = (new Genero())->listar('a%');
//var_dump($lista);

//..mostra uma view - para cadastrar novo gênero
//(new GeneroView())->show();

//..exibe um gênero já cadastrado por meio da view
//..recupera um model
//$gen = (new Genero())->recuperarPorId(23);

//..cria uma view e informa o model 
//$genView = new GeneroView($gen);

//..invoca o método show
//$genView->show();

/*
$genero = (new Genero())->recuperarPorId(24);

$serie = new Serie(null, 'Death Note', 1, 2012, 2012, $genero, 'teste dois');

try {
    $serie->persistir();
} catch (\Exception $ex) {
    echo "erro: {$ex->getMessage()}";
}

*/

/*
$serie = (new Serie())->recuperarPorId(6);

var_dump($serie);

*/

$series = (new Serie())->listar(null,null,'genero,nome');

var_dump($series);