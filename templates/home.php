<?php


$template = new \TestePratico\Template("base");
ob_start();
?>


<h1>Teste prático de PHP.</h1>
<p>Um CRUD para gerir cadastros de usuários, permitindo atrelar uma ou mais cores a um usuário. O sistema deve ser feito
    sem frameworks e sem dependências externas.</p>

<?php

$template->set("conteudo", ob_get_clean());
echo $template->render();
?>
