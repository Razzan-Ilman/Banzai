/**
 * BANZAI Member Adaptive UI System
 * UI berubah sesuai kelompok member
 * Filosofi: "Personal Growth & Living Identity"
 */

// Group Theme Configuration
const GROUP_THEMES = {
    1: { // MUSASHI (Bahasa - Cyan)
        name: 'MUSASHI',
        primary: '#06B6D4',
        secondary: '#0891B2',
        accent: '#67E8F9',
        gradient: 'linear-gradient(135deg, #06B6D4, #0891B2)',
        motion: 'smooth-flow'
    },
    2: { // AME-NO-UZUME (Budaya - Violet)
        name: 'AME-NO-UZUME',
        primary: '#8B5CF6',
        secondary: '#7C3AED',
        accent: '#A78BFA',
        gradient: 'linear-gradient(135deg, #8B5CF6, #7C3AED)',
        motion: 'graceful-dance'
    },
    3: { // FUJIN (Medsos - Amber)
        name: 'FUJIN',
        primary: '#F59E0B',
        secondary: '#D97706',
        accent: '#FCD34D',
        gradient: 'linear-gradient(135deg, #F59E0B, #D97706)',
        motion: 'dynamic-burst'
    },
    4: { // YAMATO (BANZAI - Gold)
        name: 'YAMATO',
        primary: '#C7A14A',
        secondary: '#A68B3A',
        accent: '#D4AF37',
        gradient: 'linear-gradient(135deg, #C7A14A, #A68B3A)',
        motion: 'regal-glow'
    }
};

// Level Configuration
const LEVEL_EFFECTS = {
    1: { // Initiate
        name: 'Initiate',
        animation: 'minimal',
        glow: false,
        particles: false
    },
    2: { // Adept
        name: 'Adept',
        animation: 'subtle',
        glow: true,
        particles: false
    },
    3: { // Master
        name: 'Master',
        animation: 'enhanced',
        glow: true,
        particles: true
    }
};

class AdaptiveUI {
    constructor() {
        this.currentGroup = null;
        this.currentLevel = 1;
        this.init();
    }

    init() {
        // Get member data from page
        const memberData = this.getMemberData();

        if (memberData) {
            this.currentGroup = memberData.groupId;
            this.currentLevel = memberData.level;

            // Apply theme
            this.applyGroupTheme(this.currentGroup);
            this.applyLevelEffects(this.currentLevel);
        }
    }

    getMemberData() {
        // Get from data attributes or API
        const container = document.querySelector('[data-member-group]');
        if (container) {
            return {
                groupId: parseInt(container.dataset.memberGroup),
                level: parseInt(container.dataset.memberLevel) || 1
            };
        }
        return null;
    }

    applyGroupTheme(groupId) {
        const theme = GROUP_THEMES[groupId];
        if (!theme) return;

        const root = document.documentElement;

        // Apply CSS variables
        root.style.setProperty('--group-primary', theme.primary);
        root.style.setProperty('--group-secondary', theme.secondary);
        root.style.setProperty('--group-accent', theme.accent);
        root.style.setProperty('--group-gradient', theme.gradient);

        // Apply to specific elements
        this.updateSidebar(theme);
        this.updateButtons(theme);
        this.updateCards(theme);

        // Add motion class
        document.body.classList.add(`motion-${theme.motion}`);

        console.log(`✨ Applied ${theme.name} theme`);
    }

    updateSidebar(theme) {
        const sidebar = document.querySelector('.member-sidebar');
        if (sidebar) {
            sidebar.style.background = theme.gradient;
        }
    }

    updateButtons(theme) {
        // Primary buttons
        document.querySelectorAll('.btn-primary').forEach(btn => {
            btn.style.background = theme.gradient;
        });

        // Stat cards
        document.querySelectorAll('.stat-card').forEach((card, index) => {
            const colors = [theme.primary, theme.secondary, theme.accent, theme.primary];
            card.style.borderLeftColor = colors[index % 4];
        });
    }

    updateCards(theme) {
        // Card headers with gradient
        document.querySelectorAll('.card-header-gradient').forEach(header => {
            header.style.background = theme.gradient;
        });
    }

    applyLevelEffects(level) {
        const effects = LEVEL_EFFECTS[level];
        if (!effects) return;

        const body = document.body;

        // Remove previous level classes
        body.classList.remove('level-1', 'level-2', 'level-3');
        body.classList.add(`level-${level}`);

        // Apply effects based on level
        if (effects.glow) {
            this.enableGlowEffects();
        }

        if (effects.particles && level === 3) {
            this.enableParticles();
        }

        console.log(`🎖️ Applied Level ${level} (${effects.name}) effects`);
    }

    enableGlowEffects() {
        // Add subtle glow to important elements
        document.querySelectorAll('.stat-card, .btn-primary').forEach(el => {
            el.classList.add('has-glow');
        });
    }

    enableParticles() {
        // Only for Level 3 - subtle particles
        const container = document.querySelector('.member-content');
        if (container && !document.querySelector('.particles-container')) {
            const particles = document.createElement('div');
            particles.className = 'particles-container';
            particles.innerHTML = `
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
            `;
            container.appendChild(particles);
        }
    }

    // Public method to change theme (for testing)
    changeGroup(groupId) {
        this.currentGroup = groupId;
        this.applyGroupTheme(groupId);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.adaptiveUI = new AdaptiveUI();
});

// Expose for debugging
window.GROUP_THEMES = GROUP_THEMES;
window.LEVEL_EFFECTS = LEVEL_EFFECTS;
