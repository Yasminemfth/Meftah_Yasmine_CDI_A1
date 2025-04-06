// Swiper pour les cartes
var swiperCartes = new Swiper(".swiper.cartes", {
    effect: "cards",
    grabCursor: true,
    loop: true,  // Permet le défilement infini
});

// Swiper pour les images
var swiperImages = new Swiper(".swiper.img", {
    cssMode: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
    },
    mousewheel: true,
    keyboard: true,
    loop: true, // Permet un défilement continu
});
