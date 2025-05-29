<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $raffle->ar_nameprize }} - Prize Showcase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.js"></script>
    <style>
    /* Copy all your CSS styles from the template */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow-x: hidden;
        font-family: Arial, sans-serif;
        background-image: url('/images/bg.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
    }

    /* Include all other styles from your template */
    /* ... */

    .container {
        margin: auto;
        width: 100%;
    }

    .raffle-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .main-title {
        font-size: 3rem;
        font-weight: 900;
        text-transform: uppercase;
        line-height: 0.9;
        transform: skew(-10deg);
        text-shadow: 2px 2px 0 rgba(0, 0, 0, 0.2);
        color: #fff;
        margin-bottom: 10px;
        text-align: center;
    }

    .subtitle {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fde047;
        transform: skew(-10deg);
        margin-bottom: 20px;
        text-align: center;
    }

    .raffle-details {
        background-color: rgba(255, 255, 255, 0.8);
        margin: 20px 0;
        padding: 15px;
        border-radius: 8px;
    }

    .back-link {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        background-color: #3490dc;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .carousel-container {
        width: 100%;
        position: relative;
        height: 500px;
        overflow: hidden;
        margin: 40px 0;
    }

    .slide {
        position: absolute;
        border-radius: 8px;
        overflow: hidden;
        transition: all 1.5s cubic-bezier(.22, 1, .36, 1);
    }

    .slide img {
        width: 100%;
        height: 70%;
        object-fit: contain;
        padding: 10px;
    }

    .slide-content {
        padding: 15px;
        text-align: center;
    }

    .product-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e3a8a;
        text-transform: uppercase;
        margin-bottom: 5px;
        text-align: center;
        position: absolute;
        bottom: 15%;
        left: 0;
        right: 0;
        margin: 10px;
    }

    .prize-value {
        font-size: 1rem;
        color: #333;
        margin-bottom: 10px;
    }

    .navigation {
        position: absolute;
        bottom: 38%;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        padding: 0 21%;
        z-index: 200;
    }

    .nav-button-right {
        width: 0;
        height: 0;
        border-top: 35px solid transparent;
        border-bottom: 35px solid transparent;
        border-left: 35px solid #fde047;
        cursor: pointer;
    }

    .nav-button-left {
        width: 0;
        height: 0;
        border-top: 35px solid transparent;
        border-bottom: 35px solid transparent;
        border-right: 35px solid #fde047;
        cursor: pointer;
    }

    .nav-button-right:hover,
    .nav-button-left:hover {
        transform: scale(1.1);
    }

    .background-text {
        position: absolute;
        font-size: 5rem;
        font-weight: 900;
        color: rgba(255, 255, 255, 0.1);
        text-transform: uppercase;
        white-space: nowrap;
        z-index: -1;
    }

    .top-text {
        top: 5%;
        left: -10%;
        transform: skew(-10deg);
    }

    .bottom-text {
        bottom: 5%;
        right: -10%;
        transform: skew(-10deg);
    }

    .prize-counter {
        text-align: center;
        margin: 20px 0;
        font-weight: bold;
        color: white;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }

    .no-prizes {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        margin: 40px 0;
    }

    .cta-button {
        background-color: #fde047;
        color: #1e3a8a;
        font-weight: normal;
        text-transform: uppercase;
        padding: 7px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        position: absolute;
        margin-bottom: 35px;
        bottom: 5%;
        left: 50%;
        transform: translateX(-50%);
        transition: all 0.3s ease;
    }

    .cta-button:hover {
        background-color: white;
    }

    .winner-box {
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 30px 50px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        z-index: 200;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="raffle-header">
            <h1 class="main-title">{{ $raffle->ar_nameprize }}</h1>
            <p class="subtitle">Win Amazing Prizes!</p>
        </div>

        @if(count($prizes))
        <div x-data="carousel" class="w-full h-full">
            <div class="carousel-container">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="slide" :style="getSlideStyle(slide.position)">
                        <template x-if="slide.prize_image">
                            <img :src="slide.prize_image" :alt="slide.prize_name">
                        </template>
                        <template x-if="!slide.prize_image">
                            <img src="/images/no-image.png" :alt="slide.prize_name">
                        </template>
                    </div>
                </template>

                <div x-show="isDrawing" x-transition class="winner-box">
                    Congratulations! <span x-text="currentSlide.prize_name"></span>
                </div>

                <div class="navigation">
                    <div @click="prev()" class="nav-button-left"></div>
                    <div @click="next()" class="nav-button-right"></div>
                </div>
            </div>

            <div class="product-name" x-text="currentSlide.prize_name"></div>
            <button class="cta-button" @click="startDraw()">START DRAW</button>

            <div class="prize-counter">
                Prize <span x-text="currentIndex + 1"></span> of <span x-text="images.length"></span>
            </div>
        </div>
        @else
        <div class="no-prizes">
            <p>No prizes available for this raffle.</p>
        </div>
        @endif

        <a href="{{ route('aap_raffles.index') }}" class="back-link">← Back to Raffles</a>
    </div>

    <script>
    // Pass the Laravel data to Alpine.js
    window.raffleImages = @json($prizes);

    document.addEventListener('alpine:init', () => {
        Alpine.data('carousel', () => {
            return {
                currentIndex: 0,
                images: [],
                isDrawing: false,

                startDraw() {
                    this.isDrawing = true;
                },

                init() {
                    // Initialize with prizes data from Laravel
                    this.images = window.raffleImages || [];

                    // Map the prize data to the expected format for the carousel
                    this.images = this.images.map(prize => ({
                        ...prize,
                        prize_image: prize.prize_image ?
                            (prize.prize_image.startsWith('/') ? prize.prize_image : '/' +
                                prize.prize_image) :
                            '/images/no-image.png'
                    }));
                },

                get currentSlide() {
                    return this.images[this.currentIndex] || {};
                },

                get slides() {
                    if (this.isDrawing) {
                        return [{
                            ...this.currentSlide,
                            position: 0
                        }];
                    }

                    const result = [];
                    const total = this.images.length;

                    if (total === 0) return [];

                    for (let i = 0; i < total; i++) {
                        const relativePos = (i - this.currentIndex + total) % total;
                        const normalizedPos = relativePos > Math.floor(total / 2) ? relativePos -
                            total : relativePos;

                        result.push({
                            ...this.images[i],
                            position: normalizedPos
                        });
                    }

                    return result;
                },

                getSlideStyle(position) {
                    const baseWidth = 340;
                    const baseHeight = 380;

                    const config = {
                        '0': {
                            scale: 1.0,
                            offsetX: 0,
                            offsetY: 0,
                            zIndex: 100,
                            opacity: 1
                        },
                        '1': {
                            scale: 0.7,
                            offsetX: 350,
                            offsetY: 160,
                            zIndex: 90,
                            opacity: 0.9,
                            rotation: -5
                        },
                        '-1': {
                            scale: 0.7,
                            offsetX: -350,
                            offsetY: 160,
                            zIndex: 90,
                            opacity: 0.9,
                            rotation: 5
                        },
                        '2': {
                            scale: 0.3,
                            offsetX: 560,
                            offsetY: 230,
                            zIndex: 80,
                            opacity: 0.9,
                            rotation: -10
                        },
                        '-2': {
                            scale: 0.3,
                            offsetX: -560,
                            offsetY: 230,
                            zIndex: 80,
                            opacity: 0.9,
                            rotation: 10
                        }
                    };

                    const posKey = position.toString();

                    const fallback = {
                        scale: 0.1,
                        offsetX: position > 0 ? 550 : -550,
                        offsetY: 90,
                        zIndex: 70,
                        opacity: 0,
                        rotation: 0,
                    };

                    // Use lookup values or fallback
                    const {
                        scale,
                        offsetX,
                        offsetY,
                        zIndex,
                        opacity,
                        rotation
                    } = config[posKey] || fallback;

                    return `transform: translate(${offsetX}px, ${offsetY}px) scale(${scale}) rotate(${rotation || 0}deg); width: ${baseWidth}px; height: ${baseHeight}px; z-index: ${zIndex}; opacity: ${opacity}; left: calc(50% - ${baseWidth / 2}px); top: calc(50% - ${baseHeight / 2}px);`;
                },

                next() {
                    if (this.images.length === 0) return;
                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                },

                prev() {
                    if (this.images.length === 0) return;
                    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images
                        .length;
                }
            }
        });
    });
    </script>
</body>

</html>