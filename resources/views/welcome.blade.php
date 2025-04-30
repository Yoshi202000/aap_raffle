<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Anniversary Grand Raffle Slideshow</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }
        
        
        .main-title {
            font-size: 5rem;
            font-weight: 900;
            text-transform: uppercase;
            line-height: 0.9;
            transform: skew(-10deg);
            text-shadow: 2px 2px 0 rgba(0,0,0,0.2);
            position: absolute;
            top: 15%;
            left: 10%;
            z-index: 100;
        }
        
        .subtitle {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fde047;
            transform: skew(-10deg);
            position: absolute;
            top: 10%;
            right: 20%;
        }
        
        .product-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #fde047;
            text-transform: uppercase;
            text-align: center;
            position: absolute;
            bottom: 15%;
            left: 0;
            right: 0;
            margin: auto;
        }
        
        .cta-button {
            background-color: #fde047;
            color: #1e3a8a;
            font-weight: bold;
            text-transform: uppercase;
            padding: 12px 24px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            position: absolute;
            bottom: 5%;
            left: 50%;
            transform: translateX(-50%);
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            background-color: white;
        }
        
        .carousel-container {
            width: 100%;
            position: relative;
            height: 100vh;
            overflow: hidden;
        }
        
        .slide {
            position: absolute;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }
        
        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .navigation {
            position: absolute;
            bottom: 45%;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 0 25%;
            z-index: 200;
        }
        
        .nav-button {
            background-color: #fde047;
            color: #1e3a8a;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .nav-button:hover {
            transform: scale(1.1);
        }
        
        .background-text {
            position: absolute;
            font-size: 10rem;
            font-weight: 900;
            color: rgba(255,255,255,0.1);
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
    </style>
</head>
<body>
    
<!--     
    <h2 class="subtitle">94TH ANNIVERSARY GRAND RAFFLE</h2>
    
    <h1 class="main-title">ONE<br>FORD-A<br>ROAD</h1> -->
    
    <div x-data="carousel()" class="w-full h-full">
        <div class="carousel-container">
            <template x-for="(slide, index) in slides" :key="index">
                <div 
                    class="slide"
                    :style="getSlideStyle(slide.position)"
                >
                    <img :src="slide.src" :alt="slide.caption">
                </div>
            </template>
            
            <div class="navigation">
                <div @click="prev()" class="nav-button">b</div>
                <div @click="next()" class="nav-button">n</div>
            </div>
        </div>
        
        <div class="product-name" x-text="currentSlide.caption"></div>
        
        <button class="cta-button">START DRAW</button>
    </div>

    <script>
    function carousel() {
        return {
            currentIndex: 0,
            images: [
                { src: "/images/img1.png", caption: "Yoshiki Pro max" },
                { src: "/images/img2.png", caption: "Richmond mini" },
                { src: "/images/img3.png", caption: "edward plus" },
                { src: "/images/img4.png", caption: "PREMIUM SMARTPHONE" },
                { src: "/images/img5.png", caption: "MACBOOK PRO 16-INCH" },
            ],

            get currentSlide() {
                return this.images[this.currentIndex];
            },

            get slides() {
                const result = [];
                const total = this.images.length;

                for (let i = 0; i < total; i++) {
                    const relativePos = (i - this.currentIndex + total) % total;
                    const normalizedPos = relativePos > 2 ? relativePos - total : relativePos;
                    result.push({
                        ...this.images[i],
                        position: normalizedPos
                    });
                }

                return result;
            },

            // ✅ FIXED: Make this a method
            getSlideStyle(position) {
                const baseWidth = 460;
                const baseHeight = 300;

                const config = {
                    0: { scale: 1.0, offsetX: 0, offsetY: 0, zIndex: 100, opacity: 1 },
                    1: { scale: 0.5, offsetX: 330, offsetY: 10, zIndex: 90, opacity: 0.8 },
                    -1: { scale: 0.5, offsetX: 0, offsetY: 10, zIndex: 90, opacity: 0.8 },
                    2: { scale: 0.4, offsetX: 0, offsetY: 40, zIndex: 80, opacity: 0.6 },
                    -2: { scale: 0.4, offsetX: -660, offsetY: 40, zIndex: 80, opacity: 0.6 },
                };

                const fallback = {
                    scale: 0.3,
                    offsetX: position * 330,
                    offsetY: 60,
                    zIndex: 70,
                    opacity: 0.4
                };

                const { scale, offsetX, offsetY, zIndex, opacity } = config[position] || fallback;

                return `
                    transform: translate(${offsetX}px, ${offsetY}px) scale(${scale});
                    width: ${baseWidth}px;
                    height: ${baseHeight}px;
                    z-index: ${zIndex};
                    opacity: ${opacity};
                    left: calc(50% - ${baseWidth / 2}px);
                    top: calc(50% - ${baseHeight / 2}px);
                `;
            },

            next() {
                this.currentIndex = (this.currentIndex + 1) % this.images.length;
            },

            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            }
        };
    }
</script>

</body>
</html>