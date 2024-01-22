<?php

namespace TestePratico\Controller;

class HomePageController
{

    public static function get(\TestePratico\Request $param): \TestePratico\Response
    {

        $page =  <<<HTML
    <h1>Teste prático de PHP.</h1>
    <p>Um CRUD para gerir cadastros de usuários, permitindo atrelar uma ou mais cores a um usuário. O sistema deve ser feito sem frameworks e sem dependências externas.</p>
    <a href="/usuarios"> Gerenciador de Usuários </a>
HTML;

        return \TestePratico\Response::response()->setStatus(200)->setBody( $page );

    }
}