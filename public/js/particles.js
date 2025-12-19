/**
 * BANZAI Particle System
 * Philosophy: "Controlled Expression" - Particles as symbols, not decoration
 * 
 * Rules (STRICT):
 * - Maximum 8 particles per viewport
 * - Very slow movement (1-3px/s)
 * - No fast loops
 * - Context-aware (not on all sections)
 * - Respects reduced motion
 * 
 * Particle Types:
 * - Sakura: Time & memory (slow falling)
 * - Light Dust: Energy & life (gentle floating)
 * - Brush Specks: Art & expression (subtle drift)
 */

class ParticleSystem {
    constructor() {
        this.maxParticles = 8;
        this.particles = [];
        this.isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        this.isLowEnd = this.detectLowEndDevice();
        this.container = null;

        if (!this.isReducedMotion && !this.isLowEnd) {
            this.init();
        } else {
            console.log('BANZAI: Particles disabled (reduced motion or low-end device)');
        }
    }

    /**
     * Detect low-end devices
     */
    detectLowEndDevice() {
        const cores = navigator.hardwareConcurrency || 4;
        const memory = navigator.deviceMemory || 4;
        return cores < 4 || memory < 4;
    }

    /**
     * Initialize particle system
     */
    init() {
        // Create particle container
        this.container = document.createElement('div');
        this.container.id = 'banzai-particles';
        this.container.style.cssText = `
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 9999;
            overflow: hidden;
        `;
        document.body.appendChild(this.container);

        // Start particle generation (very slow)
        this.generateParticles();
    }

    /**
     * Generate particles based on context
     */
    generateParticles() {
        // Only generate if we haven't reached max
        if (this.particles.length >= this.maxParticles) {
            return;
        }

        // Determine particle type based on page context
        const particleType = this.determineParticleType();

        // Generate 2-3 particles initially, then slowly add more
        const initialCount = Math.min(3, this.maxParticles);
        for (let i = 0; i < initialCount; i++) {
            setTimeout(() => {
                this.createParticle(particleType);
            }, i * 2000); // 2s delay between each
        }

        // Slowly add more particles over time (one every 10s)
        this.particleInterval = setInterval(() => {
            if (this.particles.length < this.maxParticles) {
                this.createParticle(particleType);
            }
        }, 10000);
    }

    /**
     * Determine particle type based on page context
     */
    determineParticleType() {
        const path = window.location.pathname;

        if (path.includes('budaya') || path.includes('activities')) {
            return 'sakura'; // Time & memory
        } else if (path.includes('bahasa')) {
            return 'light_dust'; // Energy & learning
        } else if (path.includes('medsos')) {
            return 'brush_specks'; // Art & expression
        }

        // Default: light dust for homepage
        return 'light_dust';
    }

    /**
     * Create a single particle
     */
    createParticle(type) {
        const particle = document.createElement('div');
        particle.className = `banzai-particle particle-${type}`;

        // Random starting position
        const startX = Math.random() * window.innerWidth;
        const startY = type === 'sakura' ? -20 : Math.random() * window.innerHeight;

        // Particle styling based on type
        const styles = this.getParticleStyles(type);
        particle.style.cssText = `
            position: absolute;
            left: ${startX}px;
            top: ${startY}px;
            ${styles}
            pointer-events: none;
        `;

        this.container.appendChild(particle);
        this.particles.push(particle);

        // Animate particle
        this.animateParticle(particle, type);
    }

    /**
     * Get particle styles based on type
     */
    getParticleStyles(type) {
        switch (type) {
            case 'sakura':
                return `
                    width: 8px;
                    height: 8px;
                    border: 1px solid var(--sakura-particle);
                    border-radius: 50% 0 50% 0;
                    opacity: 0.6;
                `;
            case 'light_dust':
                return `
                    width: 4px;
                    height: 4px;
                    background: radial-gradient(circle, rgba(255, 255, 255, 0.3), transparent);
                    border-radius: 50%;
                    opacity: 0.4;
                `;
            case 'brush_specks':
                return `
                    width: 6px;
                    height: 2px;
                    background: rgba(28, 28, 28, 0.2);
                    border-radius: 2px;
                    opacity: 0.3;
                `;
            default:
                return '';
        }
    }

    /**
     * Animate particle (VERY SLOW)
     */
    animateParticle(particle, type) {
        const duration = this.getAnimationDuration(type);
        const animation = this.getAnimationKeyframes(type);

        particle.style.animation = `${animation} ${duration}s linear infinite`;

        // Remove particle after one cycle and create new one
        setTimeout(() => {
            this.removeParticle(particle);
            // Create replacement if still under max
            if (this.particles.length < this.maxParticles) {
                this.createParticle(type);
            }
        }, duration * 1000);
    }

    /**
     * Get animation duration (VERY SLOW: 30-60s)
     */
    getAnimationDuration(type) {
        switch (type) {
            case 'sakura':
                return 45 + Math.random() * 15; // 45-60s
            case 'light_dust':
                return 30 + Math.random() * 10; // 30-40s
            case 'brush_specks':
                return 35 + Math.random() * 10; // 35-45s
            default:
                return 40;
        }
    }

    /**
     * Get animation keyframes name
     */
    getAnimationKeyframes(type) {
        switch (type) {
            case 'sakura':
                return 'sakuraFall';
            case 'light_dust':
                return 'lightDust';
            case 'brush_specks':
                return 'brushSpeck';
            default:
                return 'lightDust';
        }
    }

    /**
     * Remove particle
     */
    removeParticle(particle) {
        const index = this.particles.indexOf(particle);
        if (index > -1) {
            this.particles.splice(index, 1);
        }
        if (particle.parentNode) {
            particle.parentNode.removeChild(particle);
        }
    }

    /**
     * Destroy particle system
     */
    destroy() {
        if (this.particleInterval) {
            clearInterval(this.particleInterval);
        }
        this.particles.forEach(p => this.removeParticle(p));
        if (this.container && this.container.parentNode) {
            this.container.parentNode.removeChild(this.container);
        }
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.banzaiParticles = new ParticleSystem();
    });
} else {
    window.banzaiParticles = new ParticleSystem();
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ParticleSystem;
}
