// Theme management functionality
class ThemeManager {
    constructor() {
        this.theme = localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        this.applyTheme();
        this.bindEvents();
    }

    applyTheme() {
        if (this.theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        // Update theme toggle buttons
        this.updateToggleButtons();
    }

    toggleTheme() {
        this.theme = this.theme === 'light' ? 'dark' : 'light';
        localStorage.setItem('theme', this.theme);
        this.applyTheme();
    }

    setTheme(theme) {
        this.theme = theme;
        localStorage.setItem('theme', this.theme);
        this.applyTheme();
    }

    updateToggleButtons() {
        const lightButtons = document.querySelectorAll('[data-theme="light"]');
        const darkButtons = document.querySelectorAll('[data-theme="dark"]');
        
        lightButtons.forEach(btn => {
            btn.classList.toggle('active', this.theme === 'light');
        });
        
        darkButtons.forEach(btn => {
            btn.classList.toggle('active', this.theme === 'dark');
        });
    }

    bindEvents() {
        // Theme toggle buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-theme-toggle]')) {
                this.toggleTheme();
            }
            
            if (e.target.closest('[data-theme]')) {
                const theme = e.target.closest('[data-theme]').dataset.theme;
                this.setTheme(theme);
            }
        });

        // Keyboard shortcut (Ctrl/Cmd + Shift + T)
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'T') {
                e.preventDefault();
                this.toggleTheme();
            }
        });
    }

    // Auto-detect system preference
    detectSystemTheme() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    // Listen for system theme changes
    watchSystemTheme() {
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addListener((e) => {
                if (!localStorage.getItem('theme')) {
                    this.setTheme(e.matches ? 'dark' : 'light');
                }
            });
        }
    }
}

// Initialize theme manager
window.themeManager = new ThemeManager();

// Auto-detect system preference if no saved preference
if (!localStorage.getItem('theme')) {
    window.themeManager.setTheme(window.themeManager.detectSystemTheme());
}

// Watch for system theme changes
window.themeManager.watchSystemTheme();

export default ThemeManager;