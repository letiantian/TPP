<?php
/**
 * Class error: show error page
 */
class error extends TPP {

    public function __construct() {}

    public function index() {

    }

    public function error404() {
        $render = $this->tpp_loader()->load_core_class('Render');
        $render->render('error/404', null);
        $render->show();
    }
}