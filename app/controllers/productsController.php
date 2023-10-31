<?php
class ProductController {
    private $db;

    public function __construct() {
        $this->db = new DatabaseModel();
    }
}
