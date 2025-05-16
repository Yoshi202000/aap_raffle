<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $title }} - Prize Showcase</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.js"></script>
  <style>
    /* ===== CUSTOMIZATION VARIABLES ===== */
    :root {
      /* Colors */
      --primary-color: #fde047;
      --secondary-color: #1e3a8a;
      --text-color: #ffffff;
      --background-overlay: rgba(0, 0, 0, 0.3);
      --winner-box-bg: white;
      --digit-bg: rgba(0, 0, 0, 0.3);
      
      /* Sizes */
      --slide-base-width: 340px;
      --slide-base-height: 380px;
      --digit-width: 80px;
      --digit-height: 110px;
      --nav-button-size: 35px;
      
      /* Fonts */
      --title-font-size: 24px;
      --name-font-size: 24px;
      --product-name-font-size: 1.2rem;
      --digit-font-size: 36px;
      
      /* Animations */
      --transition-speed: 0.8s;
      --transition-timing: cubic-bezier(.22,1,.36,1);
    }

    /* ===== RESET & BASE STYLES ===== */
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

    .container {
      margin: auto;
      width: 100%;
      height: 100%;
      position: relative;
    }

    /* ===== CAROUSEL STRUCTURE ===== */
    .carousel-container {
      width: 100%;
      position: relative;
      height: 750px;
      overflow: hidden;
    }

    .slide {
      height: 100%;
      position: absolute;
      overflow: visible;
      transition: all var(--transition-speed) var(--transition-timing);
    }

    .slide > div {
      transition: margin-top 0.7s ease-out;
    }

    .img-container {
      height: 240px;
      width: auto;
      position: relative;
    }

    .img-container img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    /* ===== NAVIGATION ===== */
    .navigation {
      position: absolute;
      bottom: 38%;
      left: 0;
      right: 0;
      display: flex;
      justify-content: space-between;
      padding: 0 21%;
      z-index: 200;
      transition: opacity 0.5s ease-in-out;
    }

    .nav-button-right {
      width: 0; 
      height: 0; 
      border-top: var(--nav-button-size) solid transparent;
      border-bottom: var(--nav-button-size) solid transparent;
      border-left: var(--nav-button-size) solid var(--primary-color);
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    .nav-button-left {
      width: 0; 
      height: 0; 
      border-top: var(--nav-button-size) solid transparent;
      border-bottom: var(--nav-button-size) solid transparent; 
      border-right: var(--nav-button-size) solid var(--primary-color);
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    .nav-button-right:hover, .nav-button-left:hover {
      transform: scale(1.1);
    }

    /* ===== DRAWING SECTION ===== */
    .title {
      color: var(--primary-color);
      text-align: center;
      font-size: var(--title-font-size);
      font-weight: bold;
      text-transform: uppercase;
      position: absolute;
      top: 20px;
      left: 40%;
      transform: translateX(-50%);
      z-index: 50;
      transition: opacity 0.5s ease-out;
    }

    .name {
      color: var(--primary-color);
      width: 100%;    
      text-align: center;
      font-size: var(--name-font-size);
      font-weight: bold;
      margin-bottom: 30px;
      text-transform: uppercase;
      position: absolute;     
      top: 300px;
      transform: translateX(-50%);
      z-index: 50;
    }

    .digits-container {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      width: 100%;
      position: absolute;
      top: 430px;
      left: 0;
      right: 0;
      margin: 0 auto;
      z-index: 150;
      transition: opacity 0.5s ease-out;
    }

    .digit {
      width: var(--digit-width);
      height: var(--digit-height);
      background-color: var(--digit-bg);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-color);
      font-size: var(--digit-font-size);
      font-weight: bold;
      transition: transform 0.2s ease-out;
    }

    /* ===== BUTTONS & LABELS ===== */
    .product-name {
      font-size: var(--product-name-font-size);
      font-weight: 700;
      color: var(--text-color);
      text-transform: uppercase;
      text-align: center;
      position: absolute;
      left: 0;
      right: 0;
      bottom: 95px; 
      margin: 0 10px;
      padding: 10px 0;
    }

    .cta-button {
      background-color: var(--primary-color);
      color: var(--secondary-color);
      font-weight: bold;
      text-transform: uppercase;
      padding: 10px 25px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      position: absolute;
      margin-bottom: 35px;
      bottom: 0%;
      z-index: 10000000;
      left: 50%;
      transform: translateX(-50%);
      transition: all 0.3s ease;
    }

    .cta-button:hover {
      background-color: var(--text-color);
    }

    .back-button {
      background-color: var(--primary-color);
      color: var(--secondary-color);
      font-weight: bold;
      text-transform: uppercase;
      padding: 7px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.8rem;
      z-index: 10000000000000;
      position: absolute;
      bottom: 15px;
      left: 50%;
      transform: translateX(-50%);
      transition: opacity 0.3s ease-out;
    }

    .back-button:hover {
      background-color: var(--text-color);
    }

    .prize-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background-color: var(--primary-color);
      color: var(--secondary-color);
      font-weight: bold;
      padding: 5px 10px;
      border-radius: 20px;
    }

    .winner-box {
      position: absolute;
      top: 70%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: var(--winner-box-bg);
      padding: 30px 50px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      z-index: 200;
      display: none;
      animation: fadeIn 0.5s ease-in-out forwards;
    }

    .no-prizes {
      background-color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      margin: 40px 0;
    }

    /* ===== ANIMATIONS ===== */
    .fade-in {
      animation: fadeInEffect 0.5s ease-in forwards;
    }

    .fade-out {
      animation: fadeOutEffect 0.5s ease-out forwards;
    }

    .Namefade-in {
      animation: fadeInEffect 0.5s ease-in forwards;
    }

    .move-up {
      animation: moveUpMargin 0.7s ease-out forwards;
    }

    .move-down {
      animation: moveDownMargin 0.8s ease-out forwards;
    }

    @keyframes fadeInEffect {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeOutEffect {
      from {
        opacity: 1;
        transform: translateY(0);
      }
      to {
        opacity: 0;
        transform: translateY(20px);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translate(-50%, -20px);
      }
      to {
        opacity: 1;
        transform: translate(-50%, 0);
      }
    }

    @keyframes moveUpMargin {
      0% {
        margin-top: 0;
      }
      100% {
        margin-top: -90px;
      }
    }

    @keyframes moveDownMargin {
      0% {
        margin-top: -90px;
      }
      100% {
        margin-top: 0;
      }
    }

    @keyframes digitChange {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-5px);
      }
    }
  </style>
</head>
<body>
  <div class="container">
    @if(count($prizes))
      <div x-data="carousel" class="container">
        <div class="carousel-container">
          <template x-for="(slide, index) in slides" :key="index">
            <div class="slide" :style="getSlideStyle(slide.position)"> 
              <div :class="{ 
                'move-up': isDrawing && !isReturning,
                'move-down': isReturning
              }">
                <template x-if="slide.prize_image">
                  <div class="img-container">
                    <img :src="slide.prize_image" :alt="slide.prize_name">
                    <div x-show="isDrawing" 
                         :class="{ 'Namefade-in': isDrawing && !isReturning, 'fade-out': isReturning}"
                         class="name" x-text="winnerName || 'Name Of The Winner'"></div>
                  </div>
                </template>
                <template x-if="!slide.prize_image">
                  <img src="/images/no-image.png" :alt="slide.prize_name">
                </template>
                <template x-if="showPrizeBadge && slide.prize_count">
                  <div class="prize-badge" x-text="slide.prize_count + ' available'"></div>
                </template>
              </div>
            </div>
          </template>

          <div x-show="isNext || isReturning" 
               :class="{ 'fade-in': isReturning }"
               class="navigation">
            <div @click="prev()" class="nav-button-left"></div>
            <div @click="next()" class="nav-button-right"></div>
          </div>
          
          <div x-show="isDrawing" 
               :class="{ 'fade-in': isDrawing && !isReturning, 'fade-out': isReturning }" 
               class="title" x-text="drawingTitle"></div>
          
          <div x-show="isDrawing" 
               :class="{ 'fade-in': isDrawing && !isReturning, 'fade-out': isReturning }" 
               class="digits-container">
            <template x-for="n in digitCount">
              <div class="digit" :id="'digit-' + n">-</div>
            </template>
          </div>
        </div>
        <button class="cta-button" x-show="!isDrawing" @click="startDraw()" x-text="ctaButtonText"></button>
        <div class="product-name" x-text="currentSlide.prize_name"></div>
        <button class="back-button" x-show="isDrawing" @click="stopDraw()" x-text="backButtonText"></button>    
      </div>
    @else
      <div class="no-prizes">
        <p>No prizes available for display.</p>
      </div>
    @endif
  </div>

  <script>
    window.raffleImages = @json($prizes);
  
    document.addEventListener('alpine:init', () => {
      Alpine.data('carousel', () => {
        return {
          // Core state
          currentIndex: 0,
          images: [],
          isDrawing: false,
          isNext: true,
          isReturning: false, 
          returnedSlides: [],
          
          // Customizable settings
          digitCount: 7,
          drawingTitle: "THE LUCKY WINNER IS",
          ctaButtonText: "START DRAW",
          backButtonText: "Back to Raffles",
          winnerName: "",
          showPrizeBadge: false,
          rollSoundPath: 'sounds/audio_raffle.mp3',
          finishSoundPath: 'sounds/success.mp3',
          rollSoundVolume: 0.3,
          finishSoundVolume: 0.5,
          
          // Methods
          startDraw() {
            this.isDrawing = true;
            this.isNext = false;
            this.animateDigits();
          },

          stopDraw() {
            this.isReturning = true;
            
            this.returnedSlides = [];
            const total = this.images.length;
            
            if (total > 0) {
              for (let i = 0; i < total; i++) {
                // Calculate position relative to current index
                let position;
                
                if (i === this.currentIndex) {
                  position = 0;
                } else if (i > this.currentIndex) {
                  const diff = i - this.currentIndex;
                  position = diff <= Math.floor(total / 2) ? diff : diff - total;
                } else {
                  const diff = this.currentIndex - i;
                  position = diff <= Math.floor(total / 2) ? -diff : total - diff;
                }
                
                this.returnedSlides.push({
                  ...this.images[i],
                  position: position,
                  isCenter: position === 0
                });
              }
            }
            
            // Delay state change until animation completes
            setTimeout(() => {
              this.isDrawing = false;
              this.isNext = true;
              this.isReturning = false;
              this.returnedSlides = [];
            }, 1000);
          },

          animateDigits() {
            const digits = Array.from({ length: this.digitCount }, (_, i) => 
              document.getElementById(`digit-${i + 1}`));

            let rollSound, finishSound;
            
            try {
              rollSound = new Audio(this.rollSoundPath);     
              finishSound = new Audio(this.finishSoundPath);   
              rollSound.volume = this.rollSoundVolume;
              finishSound.volume = this.finishSoundVolume;
            } catch (e) {
              console.warn("Sound files could not be loaded:", e);
            }

            // Reset digits
            digits.forEach(digit => {
              if (digit) digit.textContent = '-';
            });

            let finishedCount = 0;
            const totalDigits = digits.length;

            digits.forEach((digit, index) => {
              if (!digit) return;

              const randomAnimationTime = 1000 + (index * 300);
              let animationInterval;

              const startAnimation = () => {
                animationInterval = setInterval(() => {
                  digit.textContent = Math.floor(Math.random() * 10);
                  digit.style.animation = 'digitChange 0.1s ease-in-out';

                  // Play roll sound
                  try {
                    if (rollSound) {
                      rollSound.currentTime = 0;
                      rollSound.play().catch(e => console.warn("Could not play sound:", e));
                    }
                  } catch (e) {}

                  setTimeout(() => {
                    digit.style.animation = 'none';
                  }, 100);
                }, 100);

                // Stop animation after random duration
                setTimeout(() => {
                  clearInterval(animationInterval);
                  digit.textContent = Math.floor(Math.random() * 10);

                  finishedCount++;

                  // If all digits are done, play finish sound
                  if (finishedCount === totalDigits) {
                    try {
                      if (rollSound) {
                        rollSound.pause();
                        rollSound.currentTime = 0;
                      }
                      if (finishSound) {
                        finishSound.play().catch(e => console.warn("Could not play sound:", e));
                      }
                    } catch (e) {}
                  }
                }, randomAnimationTime);
              };

              setTimeout(startAnimation, index * 300);
            });
          },

          init() {
            this.images = window.raffleImages || [];

            this.images = this.images.map(prize => ({
              ...prize,
              prize_image: prize.prize_image 
                ? (prize.prize_image.startsWith('/') ? prize.prize_image : '/' + prize.prize_image)
                : '/images/no-image.png'
            }));

            window.addEventListener('keydown', (event) => {
              if (event.key === 'ArrowRight') {
                this.next();
              } else if (event.key === 'ArrowLeft') {
                this.prev();
              }
            });
          },

          get currentSlide() {
            return this.images[this.currentIndex] || {};
          },

          get slides() {
            if (this.isReturning) {
              return this.returnedSlides;
            }
            
            if (this.isDrawing) {
              return [{
                ...this.currentSlide,
                position: 0
              }];
            }
          
            // Normal carousel mode
            const result = [];
            const total = this.images.length;
            
            if (total === 0) return [];

            for (let i = 0; i < total; i++) {
              let position;
              
              if (i === this.currentIndex) {
                position = 0;
              } else if (i > this.currentIndex) {
                const diff = i - this.currentIndex;
                position = diff <= Math.floor(total / 2) ? diff : diff - total;
              } else {
                const diff = this.currentIndex - i;
                position = diff <= Math.floor(total / 2) ? -diff : total - diff;
              }
              
              result.push({
                ...this.images[i],
                position: position,
                isCenter: position === 0 
              });
            }

            return result;
          },

          getSlideStyle(position) {
            // These values can be customized
            const baseWidth = getComputedStyle(document.documentElement).getPropertyValue('--slide-base-width') || '340px';
            const baseHeight = getComputedStyle(document.documentElement).getPropertyValue('--slide-base-height') || '380px';
            
            const numBaseWidth = parseInt(baseWidth);
            const numBaseHeight = parseInt(baseHeight);

            const config = {
              '0': { scale: 1.7, offsetX: 0, offsetY: 160, zIndex: 100, opacity: 1 },
              '1': { scale: 0.7, offsetX: 350, offsetY: 160, zIndex: 90, opacity: 0.9, rotation: -5},
              '-1': { scale: 0.7, offsetX: -350, offsetY: 160, zIndex: 90, opacity: 0.9, rotation: 5},
              '2': { scale: 0.3, offsetX: 560, offsetY: 230, zIndex: 80, opacity: 0.9, rotation: -10},
              '-2': { scale: 0.3, offsetX: -560, offsetY: 230, zIndex: 80, opacity: 0.9, rotation: 10 }
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

            const { scale, offsetX, offsetY, zIndex, opacity, rotation } = config[posKey] || fallback;

            // Adjust transition timing for return animation
            const transitionSpeed = getComputedStyle(document.documentElement).getPropertyValue('--transition-speed') || '0.8s';
            const transitionTiming = getComputedStyle(document.documentElement).getPropertyValue('--transition-timing') || 'cubic-bezier(.22,1,.36,1)';
            
            const baseTransition = `transform ${transitionSpeed} ${transitionTiming}, opacity ${transitionSpeed} ${transitionTiming}`;
            const returnTransition = `transform 1s ${transitionTiming}, opacity 1s ${transitionTiming}`;

            return `transform: translate(${offsetX}px, ${offsetY}px) scale(${scale}) rotate(${rotation || 0}deg); 
                    width: ${numBaseWidth}px; 
                    height: ${numBaseHeight}px; 
                    z-index: ${zIndex}; 
                    opacity: ${opacity}; 
                    left: calc(50% - ${numBaseWidth / 2}px); 
                    top: calc(50% - ${numBaseHeight / 2}px); 
                    transition: ${this.isReturning ? returnTransition : baseTransition};`;
          },

          next() {
            if (this.images.length === 0) return;
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
          },

          prev() {
            if (this.images.length === 0) return;
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
          }
        }
      });
    });
  </script>
</body>
</html>