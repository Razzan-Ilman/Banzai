/**
 * BANZAI Responsive Utility
 * Sistem deteksi device dan penyesuaian tampilan dinamis
 */

class BanzaiResponsive {
    constructor() {
        this.breakpoints = {
            mobile: 480,
            tablet: 768,
            desktop: 1024,
            wide: 1440
        };

        this.currentDevice = null;
        this.currentOrientation = null;
        this.isTouchDevice = this.detectTouch();

        this.init();
    }

    init() {
        // Initial detection
        this.detectDevice();
        this.detectOrientation();
        this.applyDeviceClasses();

        // Listen for resize
        window.addEventListener('resize', this.debounce(() => {
            const previousDevice = this.currentDevice;
            this.detectDevice();
            this.detectOrientation();
            this.applyDeviceClasses();

            // Dispatch custom event if device changed
            if (previousDevice !== this.currentDevice) {
                this.dispatchDeviceChange();
            }
        }, 150));

        // Listen for orientation change
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                this.detectOrientation();
                this.applyDeviceClasses();
            }, 100);
        });
    }

    detectTouch() {
        return ('ontouchstart' in window) ||
            (navigator.maxTouchPoints > 0) ||
            (navigator.msMaxTouchPoints > 0);
    }

    detectDevice() {
        const width = window.innerWidth;

        if (width <= this.breakpoints.mobile) {
            this.currentDevice = 'mobile-small';
        } else if (width <= this.breakpoints.tablet) {
            this.currentDevice = 'mobile';
        } else if (width <= this.breakpoints.desktop) {
            this.currentDevice = 'tablet';
        } else if (width <= this.breakpoints.wide) {
            this.currentDevice = 'desktop';
        } else {
            this.currentDevice = 'wide';
        }

        return this.currentDevice;
    }

    detectOrientation() {
        if (window.innerHeight > window.innerWidth) {
            this.currentOrientation = 'portrait';
        } else {
            this.currentOrientation = 'landscape';
        }
        return this.currentOrientation;
    }

    applyDeviceClasses() {
        const body = document.body;
        const deviceClasses = ['mobile-small', 'mobile', 'tablet', 'desktop', 'wide'];
        const orientationClasses = ['portrait', 'landscape'];

        // Remove all device classes
        deviceClasses.forEach(cls => body.classList.remove(cls));
        orientationClasses.forEach(cls => body.classList.remove(cls));

        // Add current device class
        body.classList.add(this.currentDevice);
        body.classList.add(this.currentOrientation);

        // Add touch/no-touch class
        if (this.isTouchDevice) {
            body.classList.add('touch-device');
            body.classList.remove('no-touch');
        } else {
            body.classList.add('no-touch');
            body.classList.remove('touch-device');
        }

        // Add data attributes
        body.dataset.device = this.currentDevice;
        body.dataset.orientation = this.currentOrientation;
    }

    dispatchDeviceChange() {
        const event = new CustomEvent('deviceChange', {
            detail: {
                device: this.currentDevice,
                orientation: this.currentOrientation,
                width: window.innerWidth,
                height: window.innerHeight,
                isTouch: this.isTouchDevice
            }
        });
        window.dispatchEvent(event);
    }

    isMobile() {
        return this.currentDevice === 'mobile' || this.currentDevice === 'mobile-small';
    }

    isTablet() {
        return this.currentDevice === 'tablet';
    }

    isDesktop() {
        return this.currentDevice === 'desktop' || this.currentDevice === 'wide';
    }

    getViewportInfo() {
        return {
            device: this.currentDevice,
            orientation: this.currentOrientation,
            width: window.innerWidth,
            height: window.innerHeight,
            isTouch: this.isTouchDevice,
            isMobile: this.isMobile(),
            isTablet: this.isTablet(),
            isDesktop: this.isDesktop()
        };
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

/**
 * BANZAI Layout Manager
 * Mengelola layout secara dinamis berdasarkan device
 */
class BanzaiLayout {
    constructor(responsive) {
        this.responsive = responsive;
        this.sidebar = null;
        this.backdrop = null;
        this.mobileHeader = null;
        this.init();
    }

    init() {
        // Wait for DOM
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    setup() {
        this.sidebar = document.querySelector('.member-sidebar, .admin-sidebar');
        this.backdrop = document.getElementById('sidebarBackdrop');
        this.mobileHeader = document.querySelector('.mobile-header');

        this.bindEvents();
        this.adjustLayout();

        // Listen for device changes
        window.addEventListener('deviceChange', (e) => {
            this.adjustLayout();
        });
    }

    bindEvents() {
        // Mobile menu toggle
        const menuBtn = document.getElementById('mobileMenuBtn');
        if (menuBtn) {
            menuBtn.addEventListener('click', () => this.toggleSidebar());
        }

        // Backdrop click
        if (this.backdrop) {
            this.backdrop.addEventListener('click', () => this.closeSidebar());
        }

        // Close on nav link click (mobile only)
        if (this.sidebar) {
            this.sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (this.responsive.isMobile()) {
                        this.closeSidebar();
                    }
                });
            });
        }

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isSidebarOpen()) {
                this.closeSidebar();
            }
        });

        // Swipe gestures for mobile
        this.setupSwipeGestures();
    }

    setupSwipeGestures() {
        if (!this.responsive.isTouchDevice) return;

        let startX = 0;
        let startY = 0;

        document.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        }, { passive: true });

        document.addEventListener('touchend', (e) => {
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;
            const diffX = endX - startX;
            const diffY = endY - startY;

            // Horizontal swipe detection (min 50px, within 30deg angle)
            if (Math.abs(diffX) > 50 && Math.abs(diffY) < Math.abs(diffX) * 0.5) {
                if (diffX > 0 && startX < 30) {
                    // Swipe right from left edge - open sidebar
                    this.openSidebar();
                } else if (diffX < 0 && this.isSidebarOpen()) {
                    // Swipe left - close sidebar
                    this.closeSidebar();
                }
            }
        }, { passive: true });
    }

    adjustLayout() {
        const device = this.responsive.currentDevice;

        if (this.responsive.isMobile()) {
            // Mobile: Hide sidebar, show mobile header
            if (this.sidebar) {
                this.sidebar.classList.remove('active');
            }
            if (this.mobileHeader) {
                this.mobileHeader.style.display = 'flex';
            }
        } else {
            // Desktop/Tablet: Show sidebar, hide mobile header
            if (this.sidebar) {
                this.sidebar.classList.remove('active');
            }
            if (this.mobileHeader) {
                this.mobileHeader.style.display = 'none';
            }
            if (this.backdrop) {
                this.backdrop.classList.remove('active');
            }
        }
    }

    toggleSidebar() {
        if (this.sidebar) {
            this.sidebar.classList.toggle('active');
            if (this.backdrop) {
                this.backdrop.classList.toggle('active');
            }
        }
    }

    openSidebar() {
        if (this.sidebar) {
            this.sidebar.classList.add('active');
            if (this.backdrop) {
                this.backdrop.classList.add('active');
            }
        }
    }

    closeSidebar() {
        if (this.sidebar) {
            this.sidebar.classList.remove('active');
            if (this.backdrop) {
                this.backdrop.classList.remove('active');
            }
        }
    }

    isSidebarOpen() {
        return this.sidebar?.classList.contains('active');
    }
}

/**
 * BANZAI Viewport Helper
 * CSS Custom Properties untuk viewport-aware styling
 */
class BanzaiViewport {
    constructor() {
        this.updateViewportUnits();

        window.addEventListener('resize', this.debounce(() => {
            this.updateViewportUnits();
        }, 100));
    }

    updateViewportUnits() {
        // Fix for mobile browser address bar
        const vh = window.innerHeight * 0.01;
        const vw = window.innerWidth * 0.01;

        document.documentElement.style.setProperty('--vh', `${vh}px`);
        document.documentElement.style.setProperty('--vw', `${vw}px`);
        document.documentElement.style.setProperty('--viewport-height', `${window.innerHeight}px`);
        document.documentElement.style.setProperty('--viewport-width', `${window.innerWidth}px`);
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize
const banzaiResponsive = new BanzaiResponsive();
const banzaiLayout = new BanzaiLayout(banzaiResponsive);
const banzaiViewport = new BanzaiViewport();

// Export for global access
window.BanzaiResponsive = banzaiResponsive;
window.BanzaiLayout = banzaiLayout;

// Console info (dev only)
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    console.log('🎌 BANZAI Responsive System Initialized');
    console.log('📱 Current Device:', banzaiResponsive.getViewportInfo());
}
