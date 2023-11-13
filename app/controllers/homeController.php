<?php
require('./app/models/index/searchProductModel.php');
require('./app/models/index/bestOfferModel.php');
require('./app/models/index/topSellingModel.php');

class HomeController {
    public function index() {
        $searchProduct = new SearchProductModel();
        $searchProduct->search();
        $bestOffer = new BestOfferModel();
        $bestOffer->bestOffer();
        $topSelling = new TopSellingModel();
        $topSelling->topSelling();
    }
}
