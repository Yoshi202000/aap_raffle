<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }} - Prize Showcase</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/aapraffle.css') }}" />
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.js"></script>
    <!-- Confetti.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{asset ('css/confetti.css') }}" />

    <style>

    </style>
</head>

<body>

    @if(count($prizes))
    <div x-data="carousel" class="container">
        <div class="carousel-container">

            <!-- Upper Left Back Button - shows during drawing mode -->
            <button class="back-button-upper-left" x-show="isStartDrawing" @click="stopDraw()"
                title="Go back to carousel">
                <span class="back-arrow">←</span>
                <span class="back-text">Back</span>
            </button>

            <!-- Replace the slide template section in your HTML -->
            <template x-for="(slide, index) in slides" :key="index">
                <div class="slide" :class="{ 'sold-out': slide.prize_count <= 0 && !isDrawing && !isStartDrawing }"
                    :style="getSlideStyle(slide.position)">
                    <div :class="{ 
                              'move-up': isAnimating && !isReturning,
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

                        <!-- Move the product name INSIDE the animated container - only show on center slide -->
                        <div x-show="slide.position === 0" class="product-name-inside" x-text="slide.prize_name">
                        </div>

                        <!-- Prize badge - only show on center slide -->
                        <div x-show="slide.position === 0 && (!isDrawing || isStartDrawing)" class="prize-badge"
                            :class="{ 'sold-out': slide.prize_count <= 0 && !isDrawing && !isStartDrawing }"
                            x-text="(isDrawing || isStartDrawing) ? slide.prize_count + ' available' : (slide.prize_count <= 0 ? '0 available' : slide.prize_count + ' available')">
                        </div>
                    </div>
                </div>
            </template>
            <div x-show="isNext || isReturning" :class="{ 'fade-in': isReturning }" class="navigation">
                <div @click="prev()" class="nav-button-left"></div>
                <div @click="next()" class="nav-button-right"></div>
            </div>

            <!-- Show title only when in drawing mode (after START is pressed) -->
            <div x-show="isDrawing" :class="{ 'fade-in': isDrawing && !isReturning, 'fade-out': isReturning }"
                class="title" x-text="drawingTitle"></div>

            <!-- Show digits only when in drawing mode (after START is pressed) -->
            <div x-show="isDrawing" :class="{ 'fade-in': isDrawing && !isReturning, 'fade-out': isReturning }"
                class="digits-container">
                <template x-for="(digit, index) in couponDigits" :key="index">
                    <div class="digit" :id="'digit-' + (index + 1)">-</div>
                </template>
            </div>
            <div x-show="isDrawing && !isDoneDrawing" :class="{
                        'fade-in': isDrawing && !isDoneDrawing,
                        'fade-out': isReturning,
                        'blinking': isDoneDrawing,
                      }" class="name winner-name blinking-winner" x-text="'The Lucky Winner is'"></div>

            <!-- Show actual winner name after digits finish -->
            <div x-show="isDrawing && isDoneDrawing" :class="{
                        'fade-in': isDrawing && isDoneDrawing,
                        'fade-out': isReturning,
                        'blinking': isDoneDrawing,  
                      }" class="name winner-name blinking-winner" x-text="
                      winnerName || 
                      'Name Of The Winner'">
            </div>
            <!-- Main CTA Button - shows when not in any drawing state -->
            <button class="cta-button" :class="ctaButtonState.class" :disabled="ctaButtonState.disabled"
                x-show="!isDrawing && !isStartDrawing" @click="enterDrawMode()" x-text="ctaButtonState.text"></button>

            <!-- START Button - shows when in start drawing mode only -->
            <button class="cta-button" x-show="isStartDrawing" @click="startAnimation()"
                x-text="startButtonText"></button>

            <!-- Show product name when in start drawing mode or normal carousel mode -->
            <div x-show="isDrawing && isDoneDrawing"
                :class="{ 'fade-in': isDrawing && isDoneDrawing, 'fade-out': isReturning }" class="branch-name">Branch:
            </div>
            <button class="back-button" x-show="isDrawing && isDoneDrawing" @click="stopDraw()"
                x-text="backButtonText"></button>
        </div>
        @else
        <div class="no-prizes">
            <p>No prizes available for display.</p>
        </div>
        @endif
    </div>

    <!-- GitHub banner for demo -->
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
                isStartDrawing: false,
                isAnimating: false,
                isDoneDrawing: false,
                isNext: true,
                isReturning: false,
                returnedSlides: [],
                couponCode: '0000000',
                couponDigits: '0000000',
                isRefreshingWinner: false,
                confettiInterval: null, // Add confetti interval tracking

                // Customizable settings
                digitCount: 7,
                drawingTitle: "",
                ctaButtonText: "SELECT RAFFLE",
                startButtonText: "START",
                backButtonText: "Back to Raffle",
                winnerName: "first name and the last name of the winner",
                showPrizeBadge: false,
                rollSoundPath: 'sounds/audio_raffle.mp3',
                finishSoundPath: 'sounds/success.mp3',
                rollSoundVolume: 1,
                finishSoundVolume: 1,

                // Initialize the component
                init() {
                    this.images = window.raffleImages || [];
                    this.setWinnerData(window.raffleWinner || {});

                    this.images = this.images.map(prize => ({
                        ...prize,
                        prize_image: prize.prize_image ?
                            (prize.prize_image.startsWith('/') ? prize.prize_image : '/' +
                                prize.prize_image) :
                            '/images/no-image.png'
                    }));

                    window.addEventListener('keydown', (event) => {
                        if (!this.isDrawing && !this.isStartDrawing) {
                            if (event.key === 'ArrowRight') {
                                this.next();
                            } else if (event.key === 'ArrowLeft') {
                                this.prev();
                            }
                        }
                        if (event.key === 'Escape' && (this.isDrawing || this.isStartDrawing)) {
                            this.stopDraw();
                        }
                    });
                },

                // Set winner data helper method
                setWinnerData(winner) {
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
                },

                // Confetti functions
                randomInRange(min, max) {
                    return Math.random() * (max - min) + min;
                },

                startConfetti() {
                    // Clear any existing confetti
                    this.stopConfetti();

                    const duration = 10 * 1000, // 10 seconds
                        animationEnd = Date.now() + duration,
                        defaults = {
                            startVelocity: 30,
                            spread: 360,
                            ticks: 60,
                            zIndex: 9999
                        };

                    this.confettiInterval = setInterval(() => {
                        const timeLeft = animationEnd - Date.now();

                        if (timeLeft <= 0) {
                            return this.stopConfetti();
                        }

                        const particleCount = 50 * (timeLeft / duration);

                        // Left side confetti burst
                        confetti(
                            Object.assign({}, defaults, {
                                particleCount,
                                origin: {
                                    x: this.randomInRange(0.1, 0.3),
                                    y: Math.random() - 0.2
                                }
                            })
                        );

                        // Right side confetti burst  
                        confetti(
                            Object.assign({}, defaults, {
                                particleCount,
                                origin: {
                                    x: this.randomInRange(0.7, 0.9),
                                    y: Math.random() - 0.2
                                }
                            })
                        );
                    }, 250);
                },

                stopConfetti() {
                    if (this.confettiInterval) {
                        clearInterval(this.confettiInterval);
                        this.confettiInterval = null;
                    }
                },

                // Enter drawing mode (first step)
                enterDrawMode() {
                    if (this.currentSlide.prize_count <= 0) {
                        this.showUnavailableMessage();
                        return;
                    }

                    this.isStartDrawing = true;
                    this.isDrawing = false;
                    this.isNext = false;
                    this.isAnimating = false;
                    this.isDoneDrawing = false;
                },

                showUnavailableMessage() {
                    const existingMessage = document.querySelector('.unavailable-message');
                    if (existingMessage) {
                        existingMessage.remove();
                    }

                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'unavailable-message';
                    messageDiv.textContent = 'This prize is no longer available!';
                    messageDiv.style.cssText = `
              position: fixed;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              background: #ff4444;
              color: white;
              padding: 20px 40px;
              border-radius: 10px;
              font-size: 18px;
              font-weight: bold;
              z-index: 9999;
              box-shadow: 0 4px 20px rgba(0,0,0,0.3);
              animation: fadeInOut 3s ease-in-out forwards;
            `;

                    if (!document.querySelector('#unavailable-animation')) {
                        const style = document.createElement('style');
                        style.id = 'unavailable-animation';
                        style.textContent = `
                @keyframes fadeInOut {
                  0% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
                  20% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
                  80% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
                  100% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
                }
              `;
                        document.head.appendChild(style);
                    }

                    document.body.appendChild(messageDiv);

                    setTimeout(() => {
                        if (messageDiv.parentNode) {
                            messageDiv.remove();
                        }
                    }, 3000);
                },

                get isPrizeAvailable() {
                    return this.currentSlide.prize_count > 0;
                },

                get ctaButtonState() {
                    if (this.currentSlide.prize_count <= 0) {
                        return {
                            text: 'done',
                            disabled: true,
                            class: 'cta-button-disabled'
                        };
                    }
                    return {
                        text: this.ctaButtonText,
                        disabled: false,
                        class: ''
                    };
                },

                async startAnimation() {
                    const currentRaffleId = this.currentSlide.raffle_id;
                    const currentPrizeCount = this.currentSlide.prize_count;

                    if (currentPrizeCount <= 0) {
                        alert('No more prizes available for this raffle!');
                        return;
                    }

                    try {
                        const response = await fetch('/aap-raffles/decrease-prize', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                raffle_id: currentRaffleId
                            })
                        });

                        const result = await response.json();

                        if (!result.success) {
                            alert('Error updating prize count: ' + (result.message ||
                                'Unknown error'));
                            return;
                        }

                        this.currentSlide.prize_count = result.new_count;

                        const slideIndex = this.images.findIndex(img => img.raffle_id ===
                            currentRaffleId);
                        if (slideIndex !== -1) {
                            this.images[slideIndex].prize_count = result.new_count;
                        }

                    } catch (error) {
                        console.error('Error decreasing prize count:', error);
                        alert('Network error occurred. Please try again.');
                        return;
                    }

                    this.isStartDrawing = false;
                    this.isDrawing = true;
                    this.isAnimating = true;

                    this.$nextTick(() => {
                        console.log("DOM is now ready, starting animation");
                        console.log("Current winner name:", this.winnerName);
                        console.log("Current coupon digits:", this.couponDigits);
                        this.animateDigits();
                    });
                },

                async stopDraw() {
                    // Stop confetti when leaving the drawing screen
                    this.stopConfetti();
                    location.reload();
                    return;
                },


                afterDraw() {
                    this.isDoneDrawing = true;
                    // Start confetti when winner name is shown
                    setTimeout(() => {
                        this.startConfetti();
                    }, 500); // Small delay to let the winner name appear first
                },

                animateDigits() {
                    const digits = Array.from({
                            length: this.digitCount
                        }, (_, i) =>
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

                        const randomAnimationTime = 1000 + (index * 2000);
                        let animationInterval;

                        const startAnimation = () => {
                            animationInterval = setInterval(() => {
                                digit.textContent = Math.floor(Math.random() * 10);
                                digit.style.animation =
                                    'digitChange 0.1s ease-in-out';

                                try {
                                    if (rollSound) {
                                        rollSound.currentTime = 0;
                                        rollSound.play().catch(e => console.warn(
                                            "Could not play sound:", e));
                                    }
                                } catch (e) {}

                                setTimeout(() => {
                                    digit.style.animation = 'none';
                                }, 100);
                            }, 100);

                            setTimeout(() => {
                                clearInterval(animationInterval);

                                digit.textContent = couponDigits[index] || '0';
                                finishedCount++;
                                if (finishedCount === totalDigits) {
                                    try {
                                        if (rollSound) {
                                            rollSound.pause();
                                            rollSound.currentTime = 0;
                                        }
                                        if (finishSound) {
                                            finishSound.play().catch(e => console
                                                .warn("Could not play sound:",
                                                    e));
                                        }
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

                    if (this.isDrawing || this.isStartDrawing) {
                        return [{
                            ...this.currentSlide,
                            position: 0
                        }];
                    }

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
                    const baseWidth = getComputedStyle(document.documentElement).getPropertyValue(
                        '--slide-base-width') || '340px';
                    const baseHeight = getComputedStyle(document.documentElement).getPropertyValue(
                        '--slide-base-height') || '380px';

                    const numBaseWidth = parseInt(baseWidth);
                    const numBaseHeight = parseInt(baseHeight);

                    const config = {
                        '0': {
                            scale: 1.7,
                            offsetX: 0,
                            offsetY: 160,
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

                    const {
                        scale,
                        offsetX,
                        offsetY,
                        zIndex,
                        opacity,
                        rotation
                    } = config[posKey] || fallback;

                    const transitionSpeed = getComputedStyle(document.documentElement).getPropertyValue(
                        '--transition-speed') || '0.8s';
                    const transitionTiming = getComputedStyle(document.documentElement)
                        .getPropertyValue('--transition-timing') || 'cubic-bezier(.22,1,.36,1)';

                    const baseTransition =
                        `transform ${transitionSpeed} ${transitionTiming}, opacity ${transitionSpeed} ${transitionTiming}`;
                    const returnTransition =
                        `transform 1s ${transitionTiming}, opacity 1s ${transitionTiming}`;

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
                    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images
                        .length;
                }
            }
        });
    });
    </script>
    <script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
</body>

</html>