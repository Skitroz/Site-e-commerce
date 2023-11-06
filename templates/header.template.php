<?php

class HeaderTemplate
{
    public function header()
    {
        $headerContent = "<script src='https://cdn.tailwindcss.com'></script>";
        $headerContent .= "<script src='https://kit.fontawesome.com/0d88df16c5.js' crossorigin='anonymous'></script>";
        $headerContent .= "<header>";
        $headerContent .= "<div class='bg-black py-2 font-light'>";
        $headerContent .= "<div class='flex justify-evenly'>";
        $headerContent .= "<ul class='flex gap-4 text-white'>";
        $headerContent .= "<li><a href='#' class=''>FAQ</a></li>";
        $headerContent .= "<li><a href='#' class=''>Contact</a></li>";
        $headerContent .= "<li><a href='#' class=''>Trouver mon colis</a></li>";
        $headerContent .= "</ul>";
        $headerContent .= "<p class='text-white flex gap-2 items-center'><i class='fa-solid fa-check mt-1'></i>Livraison en 7 jours garantie</p>";
        $headerContent .= "</div>";
        $headerContent .= "</div>";
        $headerContent .= "<div class='py-4 border-b'>";
        $headerContent .= "<div class='flex justify-between mx-24 items-center'>";
        $headerContent .= "<ul class='flex items-center gap-16'>";
        $headerContent .= "<li><a href='#' class='font-bold text-2xl flex gap-2 items-center'><i class='fa-solid fa-cloud'></i>Commerce</a></li>";
        $headerContent .= "<li><p class='font-semi-bold'>Contactez-nous</p><a href='mailto:contact@cloudcommerce.com' class='font-medium underline text-black'>contact@cloudcommerce.com</a></li>";
        $headerContent .= "</ul>";
        $headerContent .= "<ul class='flex gap-4 text-xl'>";
        $headerContent .= "<li><a href='#'><i class='fa-regular fa-user'></i></a></li>";
        $headerContent .= "<li><a href='#'><i class='fa-regular fa-heart'></i></a></li>";
        $headerContent .= "<li><a href='#'><i class='fa-regular fa-envelope-open'></i></a></li>";
        $headerContent .= "</ul>";
        $headerContent .= "</div>";
        $headerContent .= "</div>";

        $headerContent .= "<div class='py-4 border-b'>";
        $headerContent .= "<menu class='mx-48 flex items-center justify-between'>";
        $headerContent .= "<div class='relative'>";
        $headerContent .= "<button id='menuButton' class='block text-white text-[12px] font-semibold border border-gray-300 rounded p-2 focus:outline-none flex gap-2 items-center bg-black'><span>BOUTIQUE PAR CATÉGORIE</span><i class='fa-solid fa-bars mt-1'></i></button>";
        $headerContent .= "<ul id='menuDropdown' class='hidden absolute top-10 left-0 w-full bg-white border border-gray-300 rounded-lg shadow-lg'>";
        $headerContent .= "<li><a href='#' class='block px-4 py-2 hover:bg-gray-200 w-full text-[13px] gap-2 flex items-center'><i class='fa-solid fa-mobile-screen-button'></i>Téléphone</a></li>";
        $headerContent .= "<li><a href='#' class='block px-4 py-2 hover:bg-gray-200 w-full text-[13px] gap-2 flex items-center'><i class='fa-solid fa-tablet-screen-button'></i>Tablette</a></li>";
        $headerContent .= "<li><a href='#' class='block px-4 py-2 hover:bg-gray-200 w-full text-[13px] gap-2 flex items-center'><i class='fa-solid fa-laptop'></i>Ordinateur</a></li>";
        $headerContent .= "</ul>";
        $headerContent .= "</div>";        
        $headerContent .= "<ul class='flex gap-10'>";
        $headerContent .= "<li><a href='#'>CONTACT</a></li>";
        $headerContent .= "<li><a href='#' class='flex gap-1 items-center'><i class='fa-solid fa-fire'></i><span>PROMOS</span></a></li>";
        $headerContent .= "</ul>";
        $headerContent .= "<form action='' method='GET' class='py-2 px-4 border-[2px] border-black mb-0 flex gap-2 items-center rounded'>";
        $headerContent .= "<input type='text' name='searchBar' placeholder='Rechercher des produits...' class='focus:outline-none'>";
        $headerContent .= "<button type='submit' name='btnSearchBar'><i class='fa-solid fa-magnifying-glass'></i></button>";
        $headerContent .= "</form>";
        $headerContent .= "</menu>";
        $headerContent .= "</div>";
        $headerContent .= "</header>";

        $headerContent .= "<script>
            const menuButton = document.getElementById('menuButton');
            const menuDropdown = document.getElementById('menuDropdown');
            menuButton.addEventListener('click', () => {
                menuDropdown.classList.toggle('hidden');
            });
        </script>";

        echo $headerContent;
    }
}


