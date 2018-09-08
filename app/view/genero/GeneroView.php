<?php
namespace app\view\genero;

use core\view\HtmlPage;
use app\model\Genero;


class GeneroView extends HtmlPage {
    
    public function __construct($model = null)
    {
        $this->model =  is_null($model) ? new Genero() : $model;
        $this->htmlFile = 'app/view/genero/genero_view.phtml';
    }


}