<?php

namespace TestePratico\Controller;

use TestePratico\Connection;
use TestePratico\Request;
use TestePratico\Response;

class UsuariosController
{


    /**
     * @param Request $request
     * @param Connection $connection
     * @return Response
     */
    public static function get(Request $request, Connection $connection): Response
    {
        $users = $connection->query("SELECT * FROM users");
        ob_start();
        echo "<table border='1'>

    <tr>
        <th>ID</th>    
        <th>Nome</th>    
        <th>Email</th>
        <th>Ação</th>    
    </tr>
";

        foreach ($users as $user) {

            echo sprintf("<tr>
                      <td>%s</td>
                      <td>%s</td>
                      <td>%s</td>
                      <td>
                           <a href='#'>Editar</a>
                           <a href='#'>Excluir</a>
                      </td>
                   </tr>",
                $user->id, $user->name, $user->email);

        }

        echo "</table>";
        $page = ob_get_clean();
        return Response::response()->setStatus(200)->setBody($page);
    }
}