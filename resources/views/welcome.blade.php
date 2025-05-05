<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Anniversary Grand Raffle Slideshow</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/raffle.css') }}" />
    <script src="{{ asset('js/raffle.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.js" defer></script>
</head>
<body>
    <div x-data="carousel" class="w-full h-full">
        <div class="carousel-container">
            <template x-for="(slide, index) in slides" :key="index">
                <div 
                    class="slide"
                    :style="getSlideStyle(slide.position)"
                >
                    <img :src="slide.src" :alt="slide.caption">
                </div>
            </template>
            <div 
            x-show="isDrawing"
            x-transition
            class="winner-box"
        >
             Congratulations! <span x-text="currentSlide.caption"></span> 
        </div>
            <div class="navigation">
                <div @click="prev()" class="nav-button-left"></div>
                <div @click="next()" class="nav-button-right"></div>
            </div>
        </div>
        
        <div class="product-name" x-text="currentSlide.caption"></div>
        
        <button class="cta-button" @click="startDraw()">START DRAW</button>
        </div>
        

    <script>
    window.raffleImages = [
        { id: 1, src: '/images/img1.png', caption: 'Yoshiki Pro Max' },
        { id: 2, src: '/images/img2.png', caption: 'Edward plus' },
        { id: 3, src: '/images/img3.png', caption: 'richmond mini' },
        { id: 4, src: '/images/img4.png', caption: 'Slide 4' },
        { id: 5, src: '/images/img5.png', caption: 'Slide 5' }
    ];
    </script>

</body>
</html>