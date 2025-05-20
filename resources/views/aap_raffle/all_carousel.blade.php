<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $title }} - Prize Showcase</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/aapraffle.css') }}" />
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.js"></script>

</head>
<body>

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
            <template x-for="(digit, index) in couponDigits" :key="index">
              <div class="digit" :id="'digit-' + (index + 1)">-</div>
            </template>
          </div>
          <div x-show="isDrawing && isDoneDrawing" 
               :class="{ 'fade-in': isDrawing && isDoneDrawing, 'fade-out': isReturning }"
               class="name winner-name" x-text="winnerName || 'Name Of The Winner'"></div>
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
    window.raffleWinner = @json($winner ?? null);
  
    document.addEventListener('alpine:init', () => {
      Alpine.data('carousel', () => {
        return {
          // Core state
          currentIndex: 0,
          images: [],
          isDrawing: false,
          isDoneDrawing: false,
          isNext: true,
          isReturning: false, 
          returnedSlides: [],
          couponCode: '0000000',
          couponDigits: [],
          
          // Customizable settings
          digitCount: 7,
          drawingTitle: "THE LUCKY WINNER IS",
          ctaButtonText: "START DRAW",
          backButtonText: "Back to Raffle",
          winnerName: "first name and the last name of the winner",
          showPrizeBadge: false,
          rollSoundPath: 'sounds/audio_raffle.mp3',
          finishSoundPath: 'sounds/success.mp3',
          rollSoundVolume: 0.3,
          finishSoundVolume: 0.5,
          
          // Initialize the component
          init() {
            this.images = window.raffleImages || [];
            
            // Get winner data from the server
            const winner = window.raffleWinner || {};
            this.winnerName = winner.name || "Unknown";
            if (winner.coupon) {
              this.couponCode = winner.coupon;
              this.digitCount = winner.coupon.length;
              this.couponDigits = Array.from(winner.coupon);
            } else {
              this.couponCode = "0000000";
              this.digitCount = 7;
              this.couponDigits = Array.from("0000000");
            }

            this.images = this.images.map(prize => ({
              ...prize,
              prize_image: prize.prize_image 
                ? (prize.prize_image.startsWith('/') ? prize.prize_image : '/' + prize.prize_image)
                : '/images/no-image.png'
            }));

            window.addEventListener('keydown', (event) => {
              if (!this.isDrawing) {
                if (event.key === 'ArrowRight') {
                  this.next();
                } else if (event.key === 'ArrowLeft') {
                  this.prev();
                }
              }
            });
          },
          
          // Methods
          startDraw() {
              this.isDrawing = true;
              this.isNext = false;
              this.isDoneDrawing = false;

              this.$nextTick(() => {
                console.log("DOM is now ready, starting animation");
                this.animateDigits();
              });
            },
            
          stopDraw() {
            this.isReturning = true;
            this.isDoneDrawing = false;
            
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
              this.isDoneDrawing = false;
              this.returnedSlides = [];
            }, 1000);
          },

          afterDraw() {
            this.isDoneDrawing = true;
          },

          animateDigits() {
            const digits = Array.from({ length: this.digitCount }, (_, i) => 
              document.getElementById(`digit-${i + 1}`)
            );
            const couponDigits = [...this.couponDigits];
            console.log("Found digits:", digits.map(d => d?.id));
            console.log("Coupon digits:", couponDigits);

            if (digits.some(d => !d)) {
              console.warn("Some digit elements were not found in the DOM!");
              return;
            }
            
            let rollSound, finishSound;

            try {
              rollSound = new Audio(this.rollSoundPath);     
              finishSound = new Audio(this.finishSoundPath);   
              rollSound.volume = this.rollSoundVolume;
              finishSound.volume = this.finishSoundVolume;
            } catch (e) {
              console.warn("Sound files could not be loaded:", e);
            }

            digits.forEach(digit => {
              if (digit) digit.textContent = '-';
            });

            let finishedCount = 0;
            const totalDigits = digits.length;

            digits.forEach((digit, index) => {
              if (!digit) return;

              const randomAnimationTime = 1000 + (index * 1500);
              let animationInterval;

              const startAnimation = () => {
                animationInterval = setInterval(() => {
                  digit.textContent = Math.floor(Math.random() * 10);
                  digit.style.animation = 'digitChange 0.1s ease-in-out';

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

                setTimeout(() => {
                  clearInterval(animationInterval);

                  // Use actual digit from the coupon
                  digit.textContent = couponDigits[index] || '0';
                  finishedCount++;
                  if (finishedCount === totalDigits) {
                    try {
                      if (rollSound) {
                        rollSound.pause();
                        rollSound.currentTime = 0;
                      }
                      if (finishSound) {
                        finishSound.play().catch(e => console.warn("Could not play sound:", e));
                      }
                      // Show winner name after digits are complete
                      setTimeout(() => {
                        this.afterDraw();
                      }, 500);
                    } catch (e) {}
                  }
                }, randomAnimationTime);
              };

              setTimeout(startAnimation, index * 300);
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