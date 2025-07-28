class ProductFilter {
    constructor() {
        this.filterForm = document.getElementById('filter-form');
        this.productGrid = document.getElementById('product-grid');
        this.loadingOverlay = document.getElementById('loading-overlay');
        this.currentFilters = {};
        this.debounceTimeout = null;
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateFiltersFromURL();
    }

    bindEvents() {
        // Filter form changes
        if (this.filterForm) {
            this.filterForm.addEventListener('change', (e) => {
                this.handleFilterChange(e);
            });

            // Debounced text inputs
            const textInputs = this.filterForm.querySelectorAll('input[type="text"], input[type="number"]');
            textInputs.forEach(input => {
                input.addEventListener('input', (e) => {
                    clearTimeout(this.debounceTimeout);
                    this.debounceTimeout = setTimeout(() => {
                        this.handleFilterChange(e);
                    }, 500);
                });
            });
        }

        // Sort dropdown
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', () => {
                this.applyFilters();
            });
        }

        // Clear filters button
        const clearButton = document.getElementById('clear-filters');
        if (clearButton) {
            clearButton.addEventListener('click', () => {
                this.clearAllFilters();
            });
        }
    }

    handleFilterChange(event) {
        const input = event.target;
        const filterName = input.name;
        let filterValue = input.value;

        // Handle different input types
        if (input.type === 'checkbox') {
            if (input.checked) {
                if (!this.currentFilters[filterName]) {
                    this.currentFilters[filterName] = [];
                }
                this.currentFilters[filterName].push(filterValue);
            } else {
                if (this.currentFilters[filterName]) {
                    const index = this.currentFilters[filterName].indexOf(filterValue);
                    if (index > -1) {
                        this.currentFilters[filterName].splice(index, 1);
                    }
                    if (this.currentFilters[filterName].length === 0) {
                        delete this.currentFilters[filterName];
                    }
                }
            }
        } else {
            if (filterValue) {
                this.currentFilters[filterName] = filterValue;
            } else {
                delete this.currentFilters[filterName];
            }
        }

        this.applyFilters();
    }

    async applyFilters() {
        this.showLoading();

        // Build query string
        const params = new URLSearchParams();
        
        Object.keys(this.currentFilters).forEach(key => {
            const value = this.currentFilters[key];
            if (Array.isArray(value)) {
                value.forEach(v => params.append(`${key}[]`, v));
            } else {
                params.append(key, value);
            }
        });

        // Add sort parameter
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect && sortSelect.value) {
            params.append('sort', sortSelect.value);
        }

        try {
            const response = await fetch(`${window.location.pathname}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            
            if (data.html) {
                this.updateProductGrid(data.html);
                this.updateURL(params);
                this.updateResultsCount(data.count);
            }
        } catch (error) {
            console.error('Filter error:', error);
            this.showError('Failed to apply filters. Please try again.');
        } finally {
            this.hideLoading();
        }
    }

    updateProductGrid(html) {
        if (this.productGrid) {
            this.productGrid.innerHTML = html;
            
            // Trigger animations for new content
            const newProducts = this.productGrid.querySelectorAll('.product-item');
            newProducts.forEach((product, index) => {
                product.style.opacity = '0';
                product.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    product.style.transition = 'all 0.3s ease';
                    product.style.opacity = '1';
                    product.style.transform = 'translateY(0)';
                }, index * 50);
            });
        }
    }

    updateURL(params) {
        const newURL = `${window.location.pathname}${params.toString() ? '?' + params.toString() : ''}`;
        window.history.pushState({}, '', newURL);
    }

    updateResultsCount(count) {
        const countElement = document.getElementById('results-count');
        if (countElement) {
            countElement.textContent = `${count} products found`;
        }
    }

    updateFiltersFromURL() {
        const params = new URLSearchParams(window.location.search);
        
        params.forEach((value, key) => {
            if (key.endsWith('[]')) {
                const cleanKey = key.slice(0, -2);
                if (!this.currentFilters[cleanKey]) {
                    this.currentFilters[cleanKey] = [];
                }
                this.currentFilters[cleanKey].push(value);
            } else {
                this.currentFilters[key] = value;
            }
        });

        this.syncFormWithFilters();
    }

    syncFormWithFilters() {
        Object.keys(this.currentFilters).forEach(filterName => {
            const filterValue = this.currentFilters[filterName];
            const inputs = this.filterForm.querySelectorAll(`[name="${filterName}"], [name="${filterName}[]"]`);
            
            inputs.forEach(input => {
                if (input.type === 'checkbox') {
                    input.checked = Array.isArray(filterValue) 
                        ? filterValue.includes(input.value)
                        : filterValue === input.value;
                } else {
                    input.value = Array.isArray(filterValue) ? filterValue[0] : filterValue;
                }
            });
        });
    }

    clearAllFilters() {
        this.currentFilters = {};
        
        // Reset form
        if (this.filterForm) {
            this.filterForm.reset();
        }
        
        // Reset sort
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.value = '';
        }
        
        this.applyFilters();
    }

    showLoading() {
        if (this.loadingOverlay) {
            this.loadingOverlay.classList.remove('hidden');
        }
        
        if (this.productGrid) {
            this.productGrid.style.opacity = '0.5';
            this.productGrid.style.pointerEvents = 'none';
        }
    }

    hideLoading() {
        if (this.loadingOverlay) {
            this.loadingOverlay.classList.add('hidden');
        }
        
        if (this.productGrid) {
            this.productGrid.style.opacity = '1';
            this.productGrid.style.pointerEvents = 'auto';
        }
    }

    showError(message) {
        // Create and show error notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-20 right-4 z-50 max-w-sm p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-lg';
        notification.innerHTML = `
            <div class="flex justify-between items-center">
                <span class="text-sm">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-red-500 hover:text-red-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ProductFilter();
});