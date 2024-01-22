<?php

namespace TestePratico\Controller;

use TestePratico\Template;

class HomePageController
{

    public static function get(\TestePratico\Request $param): \TestePratico\Response
    {

        $page = new Template("home");
        return \TestePratico\Response::response()->setStatus(200)->setBody( $page->render() );

    }
}