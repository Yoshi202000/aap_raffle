// This should be saved as raffle.js
document.addEventListener('alpine:init', () => {
    Alpine.data('carousel', () => {
        return {
            currentIndex: 0,
            images: [],
            
            init() {
                // Initialize with raffleImages or empty array
                this.images = window.raffleImages || [];
                
                // If images are empty, provide defaults (though your HTML already defines these)
                if (this.images.length === 0) {
                    this.images = [
                        { id: 1, src: '/images/img1.png', caption: 'Slide 1' },
                        { id: 2, src: '/images/img2.png', caption: 'Slide 2' },
                        { id: 3, src: '/images/img3.png', caption: 'Slide 3' },
                        { id: 4, src: '/images/img4.png', caption: 'Slide 4' },
                        { id: 5, src: '/images/img5.png', caption: 'Slide 5' }
                    ];
                }
                
                // Convert alt to caption if needed
                this.images = this.images.map(img => ({
                    ...img,
                    caption: img.caption || img.alt // Use caption if exists, otherwise use alt
                }));
            },

            get currentSlide() {
                return this.images[this.currentIndex] || {};
            },

            get slides() {
                const result = [];
                const total = this.images.length;
                
                // Safety check to prevent errors with empty arrays
                if (total === 0) return [];

                for (let i = 0; i < total; i++) {
                    const relativePos = (i - this.currentIndex + total) % total;
                    // Simplify position calculation
                    const normalizedPos = relativePos > Math.floor(total / 2) ? relativePos - total : relativePos;
                    
                    result.push({
                        ...this.images[i],
                        position: normalizedPos
                    });
                }

                return result;
            },

            getSlideStyle(position) {
                const baseWidth = 460;
                const baseHeight = 300;

                const config = {
                    '0': { scale: 1.0, offsetX: 0, offsetY: 0, zIndex: 100, opacity: 1 },
                    '1': { scale: 0.4, offsetX: 350, offsetY: 160, zIndex: 90, opacity: 0.9 },
                    '-1': { scale: 0.4, offsetX: -350, offsetY: 160, zIndex: 90, opacity: 0.9 },
                    '2': { scale: 0.3, offsetX: 560, offsetY: 230, zIndex: 80, opacity: 0.9 },
                    '-2': { scale: 0.3, offsetX: -560, offsetY: 230, zIndex: 80, opacity: 0.9 }
                };

                // Convert position to string for object lookup
                const posKey = position.toString();
                
                // Default fallback values
                const fallback = {
                    scale: 0.3,
                    offsetX: position * 330,
                    offsetY: 60,
                    zIndex: 70,
                    opacity: 0.4
                };

                // Use lookup values or fallback
                const { scale, offsetX, offsetY, zIndex, opacity } = config[posKey] || fallback;

                return `transform: translate(${offsetX}px, ${offsetY}px) scale(${scale}); width: ${baseWidth}px; height: ${baseHeight}px; z-index: ${zIndex}; opacity: ${opacity}; left: calc(50% - ${baseWidth / 2}px); top: calc(50% - ${baseHeight / 2}px);`;
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