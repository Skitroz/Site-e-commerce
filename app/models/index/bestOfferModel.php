<?php
class BestOfferModel {
    public function bestOffer() {

        $bestOffer = "<section class='flex flex-col mx-auto items-center justify-center mt-10'>";
        $bestOffer .= "<h2 class='text-2xl font-bold mb-4'>Meilleures Offres</h2>";
        // Bloc 1
        $bestOffer .= "<div class='flex'>";
        $bestOffer .= "<div class='relative m-2'>";
        $bestOffer .= "<div class='relative'>";
        $bestOffer .= "<img src='./app/img/ordinateur.jpg' alt='Image 1' />";
        $bestOffer .= "<div class='absolute top-0 left-0 w-full h-full flex flex-col items-center justify-center text-white text-xl pr-[600px] pb-[300px] bg-gray-800 opacity-30'>";
        $bestOffer .= "<div>";
        $bestOffer .= "<p class='font-bold text-3xl'>IdeaPad Slim </br>3i Gen 8</p>";
        $bestOffer .= "<p class='mt-4'>À partir de <span class='font-bold'></br>390,72 €</span></p>";
        $bestOffer .= "<div class='mt-6 border-b-2 transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300'>";
        $bestOffer .= "<a href='#' class='flex items-center gap-2 font-bold'>Achetez maintenant <i class='fa-solid fa-chevron-right text-lg mt-1'></i></a>";
        $bestOffer .= "</div>";
        $bestOffer .= "</div>";
        $bestOffer .= "</div>";
        $bestOffer .= "</div>";
        $bestOffer .= "</div>";

        // Bloc 2
        $bestOffer .= "<div class='relative m-2'>";
        $bestOffer .= "<div class='relative'>";
        $bestOffer .= "<img src='./app/img/manettePS5.webp' alt='Image 2' />";
        $bestOffer .= "<div class='absolute top-0 left-0 w-full h-full flex flex-col items-center justify-center text-white text-xl text-center pt-[350px] bg-gray-800 opacity-30'>";
        $bestOffer .= "<div>";
        $bestOffer .= "<p class='font-bold text-3xl'>Manette sans fil</br>DualSense Edge™</p>";
        $bestOffer .= "<p class='mt-4 font-bold'>239,99 €</p>";
        $bestOffer .= "<div class='mt-6 border-b-2 w-[208px] mx-auto transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300'>";
        $bestOffer .= "<a href='#' class='flex items-center gap-2 font-bold text-center'>Achetez maintenant <i class='fa-solid fa-chevron-right text-lg mt-1'></i></a>";
        $bestOffer .= "</div>";
        $bestOffer .= "</div>";
        $bestOffer .= "</div>";
        $bestOffer .= "</div>";
        $bestOffer .= "</div>";
        $bestOffer .=  "</div>";
        $bestOffer .= "</section>";

        echo $bestOffer;
    }
}