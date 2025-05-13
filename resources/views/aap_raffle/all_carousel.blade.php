<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $title }} - Prize Showcase</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.js"></script>
  <style>
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
    }

    .raffle-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .title {
            color: #ffde00;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .digits-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            position: absolute;
            top: 400px;
            left: 450px;
        }
        
        .digit {
            width: 60px;
            height: 80px;
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            font-weight: bold;
        }
        .winner-box {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 18px;
            display: none;
            animation: fadeIn 0.5s ease-in-out forwards;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

         @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -20px);
            }
            to {
                opacity: a;
                transform: translate(-50%, 0);
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

    .main-title {
      font-size: 3rem;
      font-weight: 900;
      text-transform: uppercase;
      line-height: 0.9;
      transform: skew(-10deg);
      text-shadow: 2px 2px 0 rgba(0,0,0,0.2);
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
    }

    .slide {
      height: 100%;
      position: absolute;
      overflow: visible;
      transition: all 0.8s cubic-bezier(.22,1,.36,1);
    }
    .slide > div {
    transition: margin-top 0.7s ease-out;
  }
  .fade-in {
  animation: fadeInEffect 0.5s ease-in forwards;
}
  .fade-out {
  animation: fadeOutEffect 0.5s ease-out forwards;
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

    .slide img {
      width: 100%;
      height: 100%;
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
  color: #ffff;
  text-transform: uppercase;
  text-align: center;
  position: absolute;
  left: 0;
  right: 0;
  bottom: 95px; 
  margin: 0 10px;
  padding: 10px 0;
    }
.back-button{
  position: absolute;
  bottom: 95px;
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

    .nav-button-right:hover, .nav-button-left:hover {
      transform: scale(1.1);
    }

    .background-text {
      position: absolute;
      font-size: 5rem;
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

    .prize-counter {
      text-align: center;
      margin: 20px;     
      font-weight: bold;
      color: white;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
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
      top: 70%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 30px 50px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      z-index: 200;
    }

    .prize-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background-color: #fde047;
      color: #1e3a8a;
      font-weight: bold;
      padding: 5px 10px;
      border-radius: 20px;
    }

    .move-up {
  animation: moveUpMargin 0.7s ease-out forwards;
}

@keyframes moveUpMargin {
  0% {
    margin-top: 0;
  }
  100% {
    margin-top: -30px;
  }
}

@keyframes moveDownMargin {
  0% {
    margin-top: -30px;
  }
  100% {
    margin-top: 0;
  }
}

/* Make sure the digits-container is properly positioned and fades smoothly */
.digits-container {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  width: 100%;
  position: absolute;
  top: 400px;
  left: 0;
  right: 0;
  margin: 0 auto;
  z-index: 150;
  transition: opacity 0.5s ease-out;
}

.title {
  transition: opacity 0.5s ease-out;
}

/* Enhanced digit animations */
.digit {
  width: 60px;
  height: 80px;
  background-color: rgba(0, 0, 0, 0.3);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 36px;
  font-weight: bold;
  transition: transform 0.2s ease-out;
}

/* Ensure navigation buttons fade in smoothly */
.navigation {
  transition: opacity 0.5s ease-in-out;
}

/* Make sure the back button doesn't disappear too quickly */
.back-button {
  transition: opacity 0.3s ease-out;
}
.move-down {
  animation: moveDownMargin 0.8s ease-out forwards;
}
  </style>
</head>
<body>
  <div class="container">

    @if(count($prizes))
      <div x-data="carousel" class="container">
        <div class="carousel-container">
  <template x-for="(slide, index) in slides" :key="index">
    <div class="slide" 
      :style="getSlideStyle(slide.position)"
    > 
      <!-- Apply animations based on state -->
      <div :class="{ 
        'move-up': isDrawing && !isReturning,
        'move-down': isReturning
      }">
        <template x-if="slide.prize_image">
          <img :src="slide.prize_image" :alt="slide.prize_name">
        </template>
        <template x-if="!slide.prize_image">
          <img src="/images/no-image.png" :alt="slide.prize_name">
        </template>
        <div class="prize-badge" x-text="slide.prize_count + ' available'"></div>
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
       class="title">THE LUCKY WINNER IS</div>
  
  <div x-show="isDrawing" 
       :class="{ 'fade-in': isDrawing && !isReturning, 'fade-out': isReturning }" 
       class="digits-container">
    <div class="digit" id="digit-1">-</div>
    <div class="digit" id="digit-2">-</div>
    <div class="digit" id="digit-3">-</div>
    <div class="digit" id="digit-4">-</div>
    <div class="digit" id="digit-5">-</div>
    <div class="digit" id="digit-6">-</div>
    <div class="digit" id="digit-7">-</div>
  </div>
</div>
        <button class="cta-button" x-show="!isDrawing" @click="startDraw()">START DRAW</button>
        <div class="product-name" x-text="currentSlide.prize_name"></div>
        <div class="prize-counter">
          Prize <span x-text="currentIndex + 1"></span> of <span x-text="images.length"></span>
        </div>
        <button class="back-button" x-show="isDrawing" @click="stopDraw()" >Back to Raffles</button>    
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
      currentIndex: 0,
      images: [],
      isDrawing: false,
      isNext: true,
      isReturning: false, 
      returnedSlides: [], 
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
        }, 1000); // Animation duration
      },

      animateDigits() {
        const digits = Array.from({ length: 7 }, (_, i) => document.getElementById(`digit-${i+1}`));
        
        // Reset digits
        digits.forEach(digit => {
          if (digit) digit.textContent = '-';
        });
        
        digits.forEach((digit, index) => {
          if (!digit) return;
          
          let randomAnimationTime = 1000 + (index * 300);
          let animationInterval;
          
          const startAnimation = () => {
            animationInterval = setInterval(() => {
              digit.textContent = Math.floor(Math.random() * 10);
              digit.style.animation = 'digitChange 0.1s ease-in-out';
              
              setTimeout(() => {
                digit.style.animation = 'none';
              }, 100);
            }, 100);
            
            setTimeout(() => {
              clearInterval(animationInterval);
              digit.textContent = Math.floor(Math.random() * 10);
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
      },

      get currentSlide() {
        return this.images[this.currentIndex] || {};
      },

      get slides() {
        // If we're in the returning animation phase, show all slides transitioning back
        if (this.isReturning) {
          return this.returnedSlides;
        }
        
        // If in drawing mode (and not returning), just show the center slide
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
        const baseWidth = 340;
        const baseHeight = 380;

        const config = {
          '0': { scale: 1.5, offsetX: 0, offsetY: 160, zIndex: 100, opacity: 1 },
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
        const transitionTiming = this.isReturning 
          ? "transform 1s cubic-bezier(.22,1,.36,1), opacity 1s cubic-bezier(.22,1,.36,1)" 
          : "transform 0.5s cubic-bezier(.22,1,.36,1), opacity 0.5s cubic-bezier(.22,1,.36,1)";

        return `transform: translate(${offsetX}px, ${offsetY}px) scale(${scale}) rotate(${rotation || 0}deg); width: ${baseWidth}px; height: ${baseHeight}px; z-index: ${zIndex}; opacity: ${opacity}; left: calc(50% - ${baseWidth / 2}px); top: calc(50% - ${baseHeight / 2}px); transition: ${transitionTiming};`;
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