<?php
require('./templates/header.template.php');
require('./app/models/index/searchProductModel.php');

class HomeController {
    public function index() {
        $headerTemplate = new HeaderTemplate();
        $headerTemplate->header();
        $searchProduct = new SearchProductModel();
        $searchProduct->search();
    }
}
