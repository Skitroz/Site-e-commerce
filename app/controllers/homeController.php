<?php
require('./templates/header.template.php');
class HomeController {
    public function index() {
        $headerTemplate = new HeaderTemplate();
        $headerTemplate->header();
    }
}
