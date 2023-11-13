<?php

class SearchProductModel
{
    public function search()
    {
        if (isset($_GET['btnSearchBar'])) {
            $searchTerm = $_GET['searchBar'];
            header("Location: ?action=searchResult&searchTerm=$searchTerm");
        } else {
        }
    }
}
