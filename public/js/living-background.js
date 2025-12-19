/**
 * BANZAI Living Background System
 * Philosophy: "Controlled Expression" - Backgrounds that breathe, not scream
 * 
 * Features:
 * - Slow gradient drift (30-60s loops)
 * - Light & shadow play (like sunlight on washi paper)
 * - Grain texture overlay (3-6% opacity)
 * - Performance-aware (respects prefers-reduced-motion)
 * - Fail-safe: solid colors if animations fail
 */

class LivingBackground {
    constructor() {
        this.isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        this.isLowEnd = this.detectLowEndDevice();
        this.init();
    }

    /**
     * Detect low-end devices based on hardware concurrency
     */
    detectLowEndDevice() {
        const cores = navigator.hardwareConcurrency || 4;
        const memory = navigator.deviceMemory || 4;
        return cores < 4 || memory < 4;
    }

    /**
     * Initialize living backgrounds
     */
    init() {
        // If reduced motion or low-end, use static backgrounds
        if (this.isReducedMotion || this.isLowEnd) {
            this.applyStaticBackgrounds();
            return;
        }

        // Apply living backgrounds to elements with class
        this.applyLivingGradients();
        this.applyLightPlay();
        this.applyWashiTexture();
    }

    /**
     * Apply static backgrounds (fail-safe mode)
     */
    applyStaticBackgrounds() {
        const elements = document.querySelectorAll('.living-gradient');
        elements.forEach(el => {
            el.style.background = 'var(--indigo-900)';
            el.classList.add('static-mode');
        });
        console.log('BANZAI: Static backgrounds applied (reduced motion or low-end device)');
    }

    /**
     * Apply slow gradient drift animation
     */
    applyLivingGradients() {
        const elements = document.querySelectorAll('.living-gradient');
        elements.forEach(el => {
            // Already styled via CSS, just ensure animation is active
            el.style.animationPlayState = 'running';
        });
    }

    /**
     * Apply light & shadow play effect
     */
    applyLightPlay() {
        const elements = document.querySelectorAll('.light-play');
        elements.forEach(el => {
            if (!el.querySelector('.light-play-layer')) {
                const layer = document.createElement('div');
                layer.className = 'light-play-layer';
                layer.style.cssText = `
                    position: absolute;
                    inset: 0;
                    background: radial-gradient(ellipse at 30% 40%, rgba(255, 255, 255, 0.08), transparent 60%);
                    animation: lightShift 60s ease-in-out infinite;
                    pointer-events: none;
                    z-index: 1;
                `;
                el.style.position = 'relative';
                el.insertBefore(layer, el.firstChild);
            }
        });
    }

    /**
     * Apply washi texture overlay
     */
    applyWashiTexture() {
        const elements = document.querySelectorAll('.washi-texture');
        elements.forEach(el => {
            if (!el.querySelector('.washi-texture-layer')) {
                const layer = document.createElement('div');
                layer.className = 'washi-texture-layer';
                layer.style.cssText = `
                    position: absolute;
                    inset: 0;
                    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' /%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.04'/%3E%3C/svg%3E");
                    opacity: 0.04;
                    filter: blur(0.5px);
                    pointer-events: none;
                    z-index: 2;
                `;
                el.style.position = 'relative';
                el.appendChild(layer);
            }
        });
    }

    /**
     * Update backgrounds based on user's group (future enhancement)
     */
    updateForGroup(groupColor) {
        const elements = document.querySelectorAll('.living-gradient');
        elements.forEach(el => {
            // Blend group color with base gradient
            el.style.background = `linear-gradient(160deg, var(--indigo-900), ${groupColor}20)`;
        });
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.banzaiBackground = new LivingBackground();
    });
} else {
    window.banzaiBackground = new LivingBackground();
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = LivingBackground;
}
