/**
 * BANZAI Digital Cultural Space
 * "Website terasa memiliki jiwa, waktu, dan kesadaran ruang"
 * 
 * Systems:
 * 1. TimeAwareness - Pagi/Sore/Malam mood
 * 2. SeasonalSystem - Sakura/Dust/Wind based on season
 * 3. RitualLoader - Ceremonial page entrance
 * 4. UserPresence - Idle/Active detection
 * 5. LingeringEffects - Memory and afterglow
 * 6. NegativeMotion - Hierarchy through stillness
 */

// ===== 1. TIME AWARENESS =====
class TimeAwareness {
    constructor() {
        this.hour = new Date().getHours();
        this.applyTimeMood();
    }

    getTimePeriod() {
        if (this.hour >= 6 && this.hour < 12) return 'morning';
        if (this.hour >= 12 && this.hour < 18) return 'afternoon';
        return 'night';
    }

    applyTimeMood() {
        const period = this.getTimePeriod();
        const root = document.documentElement;

        // Subtle adjustments (2-5%)
        const moods = {
            morning: {
                '--time-tint': 'rgba(16, 185, 129, 0.03)',  // Cool matcha
                '--time-glow': 'rgba(52, 211, 153, 0.08)',
                '--time-ambient': 'rgba(236, 253, 245, 0.5)'
            },
            afternoon: {
                '--time-tint': 'rgba(255, 183, 197, 0.04)',  // Warm sakura
                '--time-glow': 'rgba(255, 183, 197, 0.1)',
                '--time-ambient': 'rgba(255, 251, 235, 0.3)'
            },
            night: {
                '--time-tint': 'rgba(6, 78, 59, 0.05)',  // Deep calm
                '--time-glow': 'rgba(16, 185, 129, 0.06)',
                '--time-ambient': 'rgba(26, 26, 46, 0.02)'
            }
        };

        Object.entries(moods[period]).forEach(([prop, value]) => {
            root.style.setProperty(prop, value);
        });

        document.body.dataset.timePeriod = period;
    }
}

// ===== 2. SEASONAL SYSTEM =====
class SeasonalSystem {
    constructor() {
        this.month = new Date().getMonth() + 1; // 1-12
        this.season = this.getSeason();
        this.applySeasonalElements();
    }

    getSeason() {
        if (this.month >= 3 && this.month <= 5) return 'spring';
        if (this.month >= 6 && this.month <= 8) return 'summer';
        if (this.month >= 9 && this.month <= 11) return 'autumn';
        return 'winter';
    }

    applySeasonalElements() {
        document.body.dataset.season = this.season;

        // Sakura only in spring
        this.sakuraEnabled = this.season === 'spring';

        // Different particles per season
        this.particleConfig = {
            spring: { type: 'sakura', color: '#FFB7C5', count: 2 },
            summer: { type: 'dust', color: '#10B981', count: 3 },
            autumn: { type: 'dust', color: '#D97706', count: 2 },
            winter: { type: 'minimal', color: '#E5E7EB', count: 1 }
        };
    }

    spawnSeasonalParticle() {
        const config = this.particleConfig[this.season];
        if (config.type === 'minimal') return;

        const container = document.getElementById('living-particles');
        if (!container) return;

        const particle = document.createElement('div');
        const size = config.type === 'sakura' ? (4 + Math.random() * 4) : (80 + Math.random() * 40);

        if (config.type === 'sakura') {
            particle.className = 'seasonal-particle sakura';
            particle.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${Math.random() * 100}%;
                top: -20px;
                background: radial-gradient(ellipse at 30% 30%, #FFD9E0, ${config.color});
                border-radius: 150% 0 150% 0;
                opacity: 0;
                animation: sakuraFloat ${12 + Math.random() * 6}s ease-in-out forwards;
            `;
        } else {
            particle.className = 'seasonal-particle dust';
            particle.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                background: radial-gradient(circle, ${config.color}08, transparent 70%);
                border-radius: 50%;
                filter: blur(${10 + Math.random() * 6}px);
                animation: dustFloat ${30 + Math.random() * 20}s ease-in-out infinite;
            `;
        }

        container.appendChild(particle);

        if (config.type === 'sakura') {
            setTimeout(() => particle.remove(), 18000);
        }
    }
}

// ===== 3. RITUAL LOADER =====
class RitualLoader {
    constructor() {
        this.steps = [
            { delay: 0, action: 'silence' },
            { delay: 500, action: 'text' },
            { delay: 800, action: 'light' },
            { delay: 1200, action: 'interaction' }
        ];
    }

    async performRitual() {
        document.body.classList.add('ritual-loading');

        // Step 1: Silence (0.5s)
        await this.wait(500);

        // Step 2: Text appears
        document.querySelectorAll('.ritual-text').forEach(el => {
            el.classList.add('ritual-visible');
        });
        await this.wait(300);

        // Step 3: Light emerges
        document.querySelectorAll('.ritual-light').forEach(el => {
            el.classList.add('ritual-visible');
        });
        await this.wait(400);

        // Step 4: Interaction enabled
        document.body.classList.remove('ritual-loading');
        document.body.classList.add('ritual-complete');

        // Trigger passing light
        this.triggerEntranceLight();
    }

    triggerEntranceLight() {
        const light = document.createElement('div');
        light.className = 'entrance-light';
        light.style.cssText = `
            position: fixed;
            top: 0;
            left: -50%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, var(--time-glow, rgba(255,255,255,0.03)), transparent);
            pointer-events: none;
            z-index: 9999;
            animation: entrancePass 1s ease-out forwards;
        `;
        document.body.appendChild(light);
        setTimeout(() => light.remove(), 1000);
    }

    wait(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
}

// ===== 4. USER PRESENCE =====
class UserPresence {
    constructor() {
        this.isIdle = false;
        this.lastActivity = Date.now();
        this.idleThreshold = 5000; // 5 seconds
        this.mouseInside = true;
        this.isScrolling = false;
        this.scrollTimeout = null;

        this.bindEvents();
        this.startPresenceLoop();
    }

    bindEvents() {
        // Activity detection
        ['mousemove', 'keydown', 'click', 'touchstart'].forEach(event => {
            document.addEventListener(event, () => this.recordActivity(), { passive: true });
        });

        // Mouse enter/leave
        document.addEventListener('mouseenter', () => {
            this.mouseInside = true;
            this.onMouseEnter();
        });
        document.addEventListener('mouseleave', () => {
            this.mouseInside = false;
            this.onMouseLeave();
        });

        // Scroll detection
        window.addEventListener('scroll', () => {
            this.isScrolling = true;
            this.recordActivity();

            clearTimeout(this.scrollTimeout);
            this.scrollTimeout = setTimeout(() => {
                this.isScrolling = false;
                this.onScrollStop();
            }, 150);
        }, { passive: true });
    }

    recordActivity() {
        this.lastActivity = Date.now();
        if (this.isIdle) {
            this.isIdle = false;
            this.onWake();
        }
    }

    startPresenceLoop() {
        setInterval(() => {
            const idleTime = Date.now() - this.lastActivity;
            if (idleTime > this.idleThreshold && !this.isIdle) {
                this.isIdle = true;
                this.onIdle();
            }
        }, 1000);
    }

    onWake() {
        document.body.classList.remove('presence-idle');
        document.body.classList.add('presence-active');
        document.body.style.setProperty('--presence-intensity', '1');
    }

    onIdle() {
        document.body.classList.remove('presence-active');
        document.body.classList.add('presence-idle');
        document.body.style.setProperty('--presence-intensity', '0.6');
    }

    onMouseEnter() {
        document.body.classList.add('presence-focused');
    }

    onMouseLeave() {
        document.body.classList.remove('presence-focused');
    }

    onScrollStop() {
        document.body.classList.add('presence-still');
        setTimeout(() => {
            document.body.classList.remove('presence-still');
        }, 500);
    }
}

// ===== 5. LINGERING EFFECTS =====
class LingeringEffects {
    constructor() {
        this.bindHoverMemory();
    }

    bindHoverMemory() {
        // Add lingering glow to interactive elements
        document.querySelectorAll('.hero-cta, .nav-cta, .division-card, .member-card, .activity-card').forEach(el => {
            el.addEventListener('mouseenter', () => {
                el.classList.add('lingering-active');
            });

            el.addEventListener('mouseleave', () => {
                // Keep glow for 0.5s after leaving
                setTimeout(() => {
                    el.classList.remove('lingering-active');
                }, 500);
            });
        });
    }

    // Brush stroke that completes and stays
    static animateBrush(element) {
        element.classList.add('brush-animating');
        element.addEventListener('animationend', () => {
            element.classList.remove('brush-animating');
            element.classList.add('brush-complete');
        }, { once: true });
    }
}

// ===== 6. PARTICLE CONTAINER =====
class ParticleContainer {
    constructor() {
        this.container = this.createContainer();
    }

    createContainer() {
        let container = document.getElementById('living-particles');
        if (!container) {
            container = document.createElement('div');
            container.id = 'living-particles';
            container.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 1;
                overflow: hidden;
            `;
            document.body.prepend(container);
        }
        return container;
    }
}

// ===== INJECT STYLES =====
function injectDigitalSpaceStyles() {
    if (document.getElementById('digital-space-styles')) return;

    const styles = document.createElement('style');
    styles.id = 'digital-space-styles';
    styles.textContent = `
        /* ===== TIME-BASED TINTING ===== */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--time-tint, transparent);
            pointer-events: none;
            z-index: 0;
            transition: background 2s ease;
        }

        /* ===== RITUAL LOADING ===== */
        body.ritual-loading {
            overflow: hidden;
        }

        body.ritual-loading .hero-content > * {
            opacity: 0;
            transform: translateY(10px);
        }

        .ritual-text {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .ritual-text.ritual-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .ritual-light {
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .ritual-light.ritual-visible {
            opacity: 1;
        }

        @keyframes entrancePass {
            0% { left: -50%; opacity: 0; }
            30% { opacity: 1; }
            100% { left: 150%; opacity: 0; }
        }

        /* ===== PRESENCE STATES ===== */
        body.presence-idle .seasonal-particle {
            animation-play-state: paused !important;
        }

        body.presence-idle .matcha-dust {
            animation-play-state: paused !important;
        }

        body.presence-active .hero-cta,
        body.presence-active .nav-cta {
            box-shadow: 0 0 20px var(--time-glow, rgba(16,185,129,0.1));
        }

        /* ===== LINGERING EFFECTS ===== */
        .lingering-active {
            box-shadow: 0 0 30px var(--time-glow, rgba(16,185,129,0.15)) !important;
            transition: box-shadow 0.3s ease !important;
        }

        /* ===== SEASONAL PARTICLES ===== */
        @keyframes sakuraFloat {
            0% {
                opacity: 0;
                transform: translateY(0) translateX(0) rotate(0deg);
            }
            10% { opacity: 0.07; }
            50% { opacity: 0.08; }
            90% { opacity: 0.05; }
            100% {
                opacity: 0;
                transform: translateY(100vh) translateX(80px) rotate(540deg);
            }
        }

        @keyframes dustFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(25px, -15px) scale(1.05); }
        }

        /* ===== BRUSH STROKES ===== */
        .brush-underline::after {
            width: 0;
            transition: none;
        }

        .brush-underline.brush-animating::after {
            animation: brushDraw 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .brush-underline.brush-complete::after {
            width: 100%;
        }

        @keyframes brushDraw {
            0% { width: 0; opacity: 0.5; }
            100% { width: 100%; opacity: 1; }
        }

        /* ===== NEGATIVE MOTION (Hierarchy through stillness) ===== */
        .hero-title,
        .page-title,
        .section-title {
            /* Important content stays still */
            animation: none !important;
            transform: none !important;
        }

        /* ===== MATERIAL TEXTURES ===== */
        .division-card,
        .member-card,
        .activity-card {
            /* Paper-like shadow, slightly asymmetric */
            box-shadow: 
                2px 3px 6px rgba(0, 0, 0, 0.04),
                4px 6px 12px rgba(0, 0, 0, 0.03),
                -1px 2px 4px rgba(0, 0, 0, 0.02);
        }

        .division-card:hover,
        .member-card:hover,
        .activity-card:hover {
            box-shadow: 
                3px 5px 10px rgba(0, 0, 0, 0.06),
                6px 10px 20px rgba(0, 0, 0, 0.04),
                -2px 3px 6px rgba(0, 0, 0, 0.02);
        }

        /* ===== POETIC EMPTY STATES ===== */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--neutral-500);
        }

        .empty-state-text {
            font-family: var(--font-heading);
            font-style: italic;
            font-size: 1.125rem;
            opacity: 0.8;
        }

        .empty-state::before {
            content: '';
            display: block;
            width: 60px;
            height: 60px;
            margin: 0 auto 1.5rem;
            background: radial-gradient(circle, var(--time-glow, rgba(16,185,129,0.1)), transparent 70%);
            border-radius: 50%;
            animation: emptyGlow 4s ease-in-out infinite;
        }

        @keyframes emptyGlow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }

        /* ===== SEASON INDICATORS ===== */
        body[data-season="spring"] { --season-accent: #FFB7C5; }
        body[data-season="summer"] { --season-accent: #10B981; }
        body[data-season="autumn"] { --season-accent: #D97706; }
        body[data-season="winter"] { --season-accent: #9CA3AF; }
    `;
    document.head.appendChild(styles);
}

// ===== MAIN ORCHESTRATOR =====
class DigitalCulturalSpace {
    constructor() {
        this.init();
    }

    async init() {
        // Inject styles first
        injectDigitalSpaceStyles();

        // Create particle container
        this.particles = new ParticleContainer();

        // Initialize systems
        this.time = new TimeAwareness();
        this.season = new SeasonalSystem();
        this.presence = new UserPresence();
        this.lingering = new LingeringEffects();

        // Perform ritual on hero pages
        if (document.querySelector('.hero')) {
            this.ritual = new RitualLoader();
            await this.ritual.performRitual();
        }

        // Start seasonal particle spawning
        this.startSeasonalLoop();

        // Animate brush underlines on scroll
        this.observeBrushUnderlines();

        console.log('[Digital Cultural Space] Initialized');
        console.log(`  Time: ${this.time.getTimePeriod()}`);
        console.log(`  Season: ${this.season.season}`);
    }

    startSeasonalLoop() {
        // Spawn particle on significant scroll (every 15s cooldown)
        let canSpawn = true;

        window.addEventListener('scroll', () => {
            if (canSpawn && Math.random() > 0.7) {
                canSpawn = false;
                this.season.spawnSeasonalParticle();
                setTimeout(() => { canSpawn = true; }, 15000);
            }
        }, { passive: true });

        // Initial spawn after 3s
        setTimeout(() => {
            this.season.spawnSeasonalParticle();
        }, 3000);
    }

    observeBrushUnderlines() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('brush-complete')) {
                    LingeringEffects.animateBrush(entry.target);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.brush-underline').forEach(el => {
            observer.observe(el);
        });
    }
}

// ===== INITIALIZE ON DOM READY =====
document.addEventListener('DOMContentLoaded', () => {
    window.digitalSpace = new DigitalCulturalSpace();
});
