<div class="relative" x-data="liveSearch()" x-init="init()">
    <div class="relative">
        <input type="text" 
               x-model="query"
               @input.debounce.300ms="search()"
               @focus="showResults = true"
               @keydown.arrow-down.prevent="highlightNext()"
               @keydown.arrow-up.prevent="highlightPrevious()"
               @keydown.enter.prevent="selectHighlighted()"
               @keydown.escape="hideResults()"
               placeholder="Search products..."
               class="w-full px-4 py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
        
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        
        <div x-show="loading" class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Search Results -->
    <div x-show="showResults && (results.products.length > 0 || results.categories.length > 0)" 
         x-transition
         class="absolute z-50 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-96 overflow-y-auto">
        
        <!-- Categories -->
        <template x-if="results.categories.length > 0">
            <div>
                <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                    Categories
                </div>
                <template x-for="(category, index) in results.categories" :key="category.id">
                    <a :href="category.url" 
                       class="block px-4 py-2 hover:bg-gray-50 transition-colors">
                        <div class="text-sm font-medium text-gray-900" x-text="category.name"></div>
                    </a>
                </template>
            </div>
        </template>

        <!-- Products -->
        <template x-if="results.products.length > 0">
            <div>
                <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50 border-t border-gray-200">
                    Products
                </div>
                <template x-for="(product, index) in results.products" :key="product.id">
                    <a :href="product.url" 
                       class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                        <img :src="product.image" 
                             :alt="product.name" 
                             class="w-10 h-10 object-cover rounded">
                        <div class="ml-3 flex-1">
                            <div class="text-sm font-medium text-gray-900" x-text="product.name"></div>
                            <div class="text-xs text-gray-500" x-text="product.category"></div>
                        </div>
                        <div class="text-sm font-medium text-gray-900" x-text="'$' + product.price"></div>
                    </a>
                </template>
            </div>
        </template>

        <!-- No Results -->
        <template x-if="query.length >= 2 && results.products.length === 0 && results.categories.length === 0 && !loading">
            <div class="px-4 py-8 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33"></path>
                    </svg>
<p class="text-gray-500 text-sm">No results found</p>
<p class="text-gray-400 text-xs mt-1">Try adjusting your search terms</p>
</div>
</template>
</div>
</div>      <!-- Backdrop -->
<div x-show="showResults" 
     @click="hideResults()" 
     class="fixed inset-0 z-40" 
     style="display: none;"></div>
     </div>
<script>
function liveSearch() {
    return {
        query: '',
        results: { products: [], categories: [] },
        loading: false,
        showResults: false,
        highlightedIndex: -1,

        init() {
            // Close results when clicking outside
            document.addEventListener('click', (e) => {
                if (!this.$el.contains(e.target)) {
                    this.hideResults();
                }
            });
        },

        async search() {
            if (this.query.length < 2) {
                this.results = { products: [], categories: [] };
                this.showResults = false;
                return;
            }

            this.loading = true;
            
            try {
                const response = await fetch(`/search/suggestions?q=${encodeURIComponent(this.query)}`);
                this.results = await response.json();
                this.showResults = true;
                this.highlightedIndex = -1;
            } catch (error) {
                console.error('Search error:', error);
            } finally {
                this.loading = false;
            }
        },

        hideResults() {
            this.showResults = false;
            this.highlightedIndex = -1;
        },

        highlightNext() {
            const totalItems = this.results.categories.length + this.results.products.length;
            if (totalItems > 0) {
                this.highlightedIndex = Math.min(this.highlightedIndex + 1, totalItems - 1);
            }
        },

        highlightPrevious() {
            if (this.highlightedIndex > 0) {
                this.highlightedIndex = Math.max(this.highlightedIndex - 1, 0);
            }
        },

        selectHighlighted() {
            const totalCategories = this.results.categories.length;
            
            if (this.highlightedIndex >= 0) {
                let item;
                if (this.highlightedIndex < totalCategories) {
                    item = this.results.categories[this.highlightedIndex];
                } else {
                    item = this.results.products[this.highlightedIndex - totalCategories];
                }
                
                if (item && item.url) {
                    window.location.href = item.url;
                }
            }
        }
    }
}
</script>