/**
 * Enhanced Admin Product Form JavaScript
 * Handles form validation, image uploads, and user experience improvements
 */

class AdminProductForm {
    constructor() {
        this.form = document.getElementById('product-form');
        this.imageInput = document.getElementById('images');
        this.uploadArea = document.getElementById('upload-area');
        this.previewArea = document.getElementById('image-preview');
        this.previewGrid = document.getElementById('preview-grid');
        
        this.selectedFiles = [];
        this.validationRules = this.initValidationRules();
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupDragAndDrop();
        this.setupFormValidation();
        this.setupAutoSave();
        this.setupKeyboardShortcuts();
        this.loadDraftIfExists();
    }

    initValidationRules() {
        return {
            name: {
                required: true,
                minLength: 3,
                maxLength: 255,
                pattern: /^[a-zA-Z0-9\s\-_]+$/
            },
            category_id: {
                required: true
            },
            description: {
                required: true,
                minLength: 10,
                maxLength: 2000
            },
            price: {
                required: true,
                min: 0.01,
                max: 99999.99
            },
            stock_quantity: {
                required: true,
                min: 0,
                max: 99999
            },
            status: {
                required: true
            }
        };
    }

    setupEventListeners() {
        // Form submission
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Price calculation
        document.getElementById('price').addEventListener('input', () => this.updatePricePreview());
        document.getElementById('sale_price').addEventListener('input', () => this.updatePricePreview());
        
        // SKU generation
        document.getElementById('name').addEventListener('input', () => this.autoGenerateSKU());
        
        // Character counters
        document.getElementById('description').addEventListener('input', (e) => this.updateCharacterCounter(e.target, 'description-counter'));
        
        // File input change
        this.imageInput.addEventListener('change', (e) => this.handleFileSelect(e));
        
        // Real-time validation
        this.setupRealTimeValidation();
    }

    setupDragAndDrop() {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            this.uploadArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            this.uploadArea.addEventListener(eventName, () => {
                this.uploadArea.classList.add('border-blue-500', 'bg-blue-50');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            this.uploadArea.addEventListener(eventName, () => {
                this.uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
            });
        });

        this.uploadArea.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            this.handleFiles(files);
        });
    }

    setupFormValidation() {
        // Add validation to all form fields
        Object.keys(this.validationRules).forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.addEventListener('blur', () => this.validateField(field));
                field.addEventListener('input', () => this.clearFieldErrors(field));
            }
        });
    }

    setupAutoSave() {
        // Auto-save draft every 30 seconds
        setInterval(() => {
            if (this.hasFormData()) {
                this.saveDraft();
            }
        }, 30000);

        // Save on page unload
        window.addEventListener('beforeunload', () => {
            if (this.hasFormData()) {
                this.saveDraft();
            }
        });
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + S to save draft
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                this.saveDraft();
                this.showNotification('Draft saved!', 'success');
            }
            
            // Ctrl/Cmd + Enter to submit
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                this.form.dispatchEvent(new Event('submit'));
            }
            
            // Escape to clear focus
            if (e.key === 'Escape') {
                document.activeElement.blur();
            }
        });
    }

    setupRealTimeValidation() {
        // Email validation for contact fields
        const emailFields = document.querySelectorAll('input[type="email"]');
        emailFields.forEach(field => {
            field.addEventListener('input', () => this.validateEmail(field));
        });

        // URL validation for image URLs
        const urlField = document.getElementById('image_urls');
        if (urlField) {
            urlField.addEventListener('input', () => this.validateImageUrls(urlField));
        }

        // Price validation
        const salePriceField = document.getElementById('sale_price');
        salePriceField.addEventListener('input', () => this.validateSalePrice());
    }

    handleSubmit(e) {
        e.preventDefault();
        
        if (!this.validateForm()) {
            this.showNotification('Please fix the errors before submitting', 'error');
            return;
        }

        this.showLoadingState();
        
        // Add a small delay to show loading state
        setTimeout(() => {
            this.form.submit();
        }, 500);
    }

    handleFileSelect(e) {
        this.handleFiles(e.target.files);
    }

    handleFiles(files) {
        this.selectedFiles = Array.from(files);
        this.updateImagePreviews();
        this.validateImages();
    }

    updateImagePreviews() {
        this.previewGrid.innerHTML = '';
        
        if (this.selectedFiles.length > 0) {
            this.previewArea.classList.remove('hidden');
            
            this.selectedFiles.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    this.createImagePreview(file, index);
                }
            });
        } else {
            this.previewArea.classList.add('hidden');
        }
    }

    createImagePreview(file, index) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = this.createPreviewElement(e.target.result, file.name, index);
            this.previewGrid.appendChild(preview);
        };
        reader.readAsDataURL(file);
    }

    createPreviewElement(src, name, index) {
        const div = document.createElement('div');
        div.className = 'image-preview-item';
        div.innerHTML = `
            <img src="${src}" alt="Preview ${index + 1}">
            <div class="image-preview-badge">
                ${index === 0 ? 'Primary' : index + 1}
            </div>
            <div class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                ${this.truncateFileName(name, 15)}
            </div>
            <button type="button" onclick="adminProductForm.removeImage(${index})" class="image-preview-remove">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        return div;
    }

    removeImage(index) {
        this.selectedFiles.splice(index, 1);
        this.updateImagePreviews();
        this.updateFileInput();
    }

    updateFileInput() {
        // Create new FileList with remaining files
        const dt = new DataTransfer();
        this.selectedFiles.forEach(file => dt.items.add(file));
        this.imageInput.files = dt.files;
    }

    validateImages() {
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        
        let hasErrors = false;
        
        this.selectedFiles.forEach((file, index) => {
            if (!allowedTypes.includes(file.type)) {
                this.showNotification(`File ${index + 1}: Invalid file type. Please use JPEG, PNG, or WebP.`, 'error');
                hasErrors = true;
            }
            
            if (file.size > maxSize) {
                this.showNotification(`File ${index + 1}: File too large. Maximum size is 5MB.`, 'error');
                hasErrors = true;
            }
        });
        
        return !hasErrors;
    }

    validateField(field) {
        const fieldName = field.name;
        const value = field.value.trim();
        const rules = this.validationRules[fieldName];
        
        if (!rules) return true;

        // Clear previous validation state
        this.clearFieldErrors(field);

        // Required validation
        if (rules.required && !value) {
            this.setFieldError(field, 'This field is required');
            return false;
        }

        if (value) {
            // Length validation
            if (rules.minLength && value.length < rules.minLength) {
                this.setFieldError(field, `Minimum ${rules.minLength} characters required`);
                return false;
            }

            if (rules.maxLength && value.length > rules.maxLength) {
                this.setFieldError(field, `Maximum ${rules.maxLength} characters allowed`);
                return false;
            }

            // Numeric validation
            if (rules.min !== undefined) {
                const numValue = parseFloat(value);
                if (numValue < rules.min) {
                    this.setFieldError(field, `Minimum value is ${rules.min}`);
                    return false;
                }
            }

            if (rules.max !== undefined) {
                const numValue = parseFloat(value);
                if (numValue > rules.max) {
                    this.setFieldError(field, `Maximum value is ${rules.max}`);
                    return false;
                }
            }

            // Pattern validation
            if (rules.pattern && !rules.pattern.test(value)) {
                this.setFieldError(field, 'Invalid format');
                return false;
            }
        }

        this.setFieldSuccess(field);
        return true;
    }

    validateForm() {
        let isValid = true;
        
        Object.keys(this.validationRules).forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field && !this.validateField(field)) {
                isValid = false;
            }
        });

        // Custom validations
        if (!this.validateSalePrice()) {
            isValid = false;
        }

        if (!this.validateImages()) {
            isValid = false;
        }

        return isValid;
    }

    validateSalePrice() {
        const priceField = document.getElementById('price');
        const salePriceField = document.getElementById('sale_price');
        
        const price = parseFloat(priceField.value) || 0;
        const salePrice = parseFloat(salePriceField.value) || 0;
        
        if (salePrice > 0 && salePrice >= price) {
            this.setFieldError(salePriceField, 'Sale price must be less than regular price');
            return false;
        }
        
        this.clearFieldErrors(salePriceField);
        return true;
    }

    validateEmail(field) {
        const email = field.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            this.setFieldError(field, 'Please enter a valid email address');
            return false;
        }
        
        this.clearFieldErrors(field);
        return true;
    }

    validateImageUrls(field) {
        const urlsText = field.value.trim();
        if (!urlsText) return true;
        
        const urls = urlsText.split('\n').filter(url => url.trim());
        let hasInvalidUrls = false;
        
        urls.forEach(url => {
            const trimmedUrl = url.trim();
            if (trimmedUrl) {
                try {
                    new URL(trimmedUrl);
                    if (!trimmedUrl.match(/\.(jpg|jpeg|png|gif|webp)$/i)) {
                        hasInvalidUrls = true;
                    }
                } catch {
                    hasInvalidUrls = true;
                }
            }
        });
        
        if (hasInvalidUrls) {
            this.setFieldError(field, 'Some URLs are invalid or not image URLs');
            return false;
        }
        
        this.clearFieldErrors(field);
        return true;
    }

    setFieldError(field, message) {
        field.classList.add('field-invalid');
        field.classList.remove('field-valid');
        
        // Remove existing error message
        const existingError = field.parentElement.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Add new error message
        const errorElement = document.createElement('p');
        errorElement.className = 'field-error mt-2 text-sm text-red-600 flex items-center';
        errorElement.innerHTML = `
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            ${message}
        `;
        
        field.parentElement.appendChild(errorElement);
    }

    setFieldSuccess(field) {
        field.classList.add('field-valid');
        field.classList.remove('field-invalid');
        this.clearFieldErrors(field);
    }

    clearFieldErrors(field) {
        field.classList.remove('field-invalid', 'field-valid');
        const errorElement = field.parentElement.querySelector('.field-error');
        if (errorElement) {
            errorElement.remove();
        }
    }

    updateCharacterCounter(field, counterId) {
        const counter = document.getElementById(counterId);
        if (counter) {
            const length = field.value.length;
            counter.textContent = `${length} characters`;
            
            // Color coding based on length
            if (length > 1500) {
                counter.className = 'absolute bottom-3 right-3 text-xs text-red-500';
            } else if (length > 1000) {
                counter.className = 'absolute bottom-3 right-3 text-xs text-yellow-500';
            } else {
                counter.className = 'absolute bottom-3 right-3 text-xs text-gray-400';
            }
        }
    }

    autoGenerateSKU() {
        const nameField = document.getElementById('name');
        const skuField = document.getElementById('sku');
        const categoryField = document.getElementById('category_id');
        
        if (!skuField.value && nameField.value) {
            const name = nameField.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 6);
            const categoryText = categoryField.selectedOptions[0]?.text || '';
            const categoryCode = categoryText.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 3);
            const randomCode = Math.random().toString(36).substr(2, 4).toUpperCase();
            
            const suggestedSKU = `GB-${name}${categoryCode ? '-' + categoryCode : ''}-${randomCode}`;
            skuField.placeholder = suggestedSKU;
        }
    }

    updatePricePreview() {
        const priceField = document.getElementById('price');
        const salePriceField = document.getElementById('sale_price');
        const pricePreview = document.getElementById('price-preview');
        const priceDisplay = document.getElementById('price-display');

        const price = parseFloat(priceField.value) || 0;
        const salePrice = parseFloat(salePriceField.value) || 0;

        if (price > 0) {
            pricePreview.style.display = 'block';
            
            if (salePrice > 0 && salePrice < price) {
                const discount = Math.round(((price - salePrice) / price) * 100);
                priceDisplay.innerHTML = `
                    <span class="text-lg font-bold text-red-600">$${salePrice.toFixed(2)}</span>
                    <span class="text-sm text-gray-500 line-through">$${price.toFixed(2)}</span>
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">${discount}% OFF</span>
                `;
            } else {
                priceDisplay.innerHTML = `<span class="text-lg font-bold text-gray-900">$${price.toFixed(2)}</span>`;
            }
        } else {
            pricePreview.style.display = 'none';
        }
    }

    showLoadingState() {
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitLoading = document.getElementById('submit-loading');
        
        submitBtn.disabled = true;
        submitBtn.classList.add('btn-loading');
        submitText.classList.add('hidden');
        submitLoading.classList.remove('hidden');
    }

    saveDraft() {
        const formData = new FormData(this.form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            if (key !== '_token' && key !== 'images[]') {
                data[key] = value;
            }
        }
        
        localStorage.setItem('admin_product_draft', JSON.stringify({
            data: data,
            timestamp: Date.now()
        }));
    }

    loadDraftIfExists() {
        const draft = localStorage.getItem('admin_product_draft');
        if (draft) {
            try {
                const { data, timestamp } = JSON.parse(draft);
                
                // Check if draft is less than 24 hours old
                if (Date.now() - timestamp < 24 * 60 * 60 * 1000) {
                    const loadDraft = confirm('Found a saved draft from earlier. Would you like to load it?');
                    if (loadDraft) {
                        this.loadDraftData(data);
                        this.showNotification('Draft loaded successfully!', 'info');
                    }
                } else {
                    // Remove old draft
                    localStorage.removeItem('admin_product_draft');
                }
            } catch (e) {
                console.error('Error loading draft:', e);
                localStorage.removeItem('admin_product_draft');
            }
        }
    }

    loadDraftData(data) {
        Object.keys(data).forEach(key => {
            const field = document.querySelector(`[name="${key}"]`);
            if (field) {
                if (field.type === 'checkbox') {
                    field.checked = data[key] === 'on' || data[key] === true;
                } else {
                    field.value = data[key];
                }
                
                // Trigger events to update UI
                field.dispatchEvent(new Event('input'));
                field.dispatchEvent(new Event('change'));
            }
        });
    }

    hasFormData() {
        const nameField = document.getElementById('name');
        return nameField && nameField.value.trim().length > 0;
    }

    truncateFileName(name, maxLength) {
        return name.length > maxLength ? name.substring(0, maxLength) + '...' : name;
    }

    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type} translate-x-full`;
        
        notification.innerHTML = `
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    ${this.getNotificationIcon(type)}
                    <span class="text-sm font-medium ml-2">${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }

    getNotificationIcon(type) {
        const icons = {
            success: '<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
            error: '<svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            warning: '<svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.729-.833-2.5 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
            info: '<svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        };
        
        return icons[type] || icons.info;
    }
}

// Global functions for template usage
function generateSKU() {
    if (window.adminProductForm) {
        const nameField = document.getElementById('name');
        const categoryField = document.getElementById('category_id');
        const skuField = document.getElementById('sku');
        
        const name = nameField.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 6);
        const categoryText = categoryField.selectedOptions[0]?.text || '';
        const categoryCode = categoryText.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 3);
        const randomCode = Math.random().toString(36).substr(2, 4).toUpperCase();
        
        const newSKU = `GB-${name}${categoryCode ? '-' + categoryCode : ''}-${randomCode}`;
        skuField.value = newSKU;
        
        // Show success feedback
        skuField.classList.add('field-valid');
        setTimeout(() => {
            skuField.classList.remove('field-valid');
        }, 2000);
        
        window.adminProductForm.showNotification('SKU generated successfully!', 'success');
    }
}

function validateUrls() {
    if (window.adminProductForm) {
        const urlField = document.getElementById('image_urls');
        const isValid = window.adminProductForm.validateImageUrls(urlField);
        
        if (isValid) {
            window.adminProductForm.showNotification('All URLs are valid!', 'success');
        }
    }
}

function previewProduct() {
    const formData = new FormData(document.getElementById('product-form'));
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        if (key !== '_token') {
            data[key] = value;
        }
    }
    
    const categoryName = document.getElementById('category_id').selectedOptions[0]?.text || 'Category';
    const price = parseFloat(data.price) || 0;
    const salePrice = parseFloat(data.sale_price) || 0;
    
    const previewContent = `
        <div class="bg-white rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm text-gray-500">Product Image</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mb-2">
                        <span class="text-sm font-medium text-blue-600">${categoryName}</span>
                        ${data.brand ? `<span class="text-sm text-gray-500 ml-2">• ${data.brand}</span>` : ''}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">${data.name || 'Product Name'}</h2>
                    <div class="mb-4">
                        ${salePrice > 0 && salePrice < price ? 
                            `<span class="text-2xl font-bold text-red-600">$${salePrice.toFixed(2)}</span>
                             <span class="text-lg text-gray-500 line-through ml-2">$${price.toFixed(2)}</span>
                             <span class="bg-red-500 text-white text-xs px-2 py-1 rounded ml-2">${Math.round(((price - salePrice) / price) * 100)}% OFF</span>` :
                            `<span class="text-2xl font-bold text-gray-900">$${price.toFixed(2)}</span>`
                        }
                    </div>
                    <div class="mb-4">
                        ${data.stock_quantity > 0 ? 
                            `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                In Stock (${data.stock_quantity} available)
                             </span>` :
                            `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Out of Stock
                             </span>`
                        }
                    </div>
                    <p class="text-gray-600 mb-4">${data.description || 'Product description will appear here...'}</p>
                    ${data.specifications ? `
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-gray-900 mb-2">Specifications</h4>
                            <p class="text-sm text-gray-600">${data.specifications}</p>
                        </div>
                    ` : ''}
                    ${data.firing_range || data.weight || data.build_material ? `
                        <div class="mt-4 grid grid-cols-1 gap-2 text-sm">
                            ${data.firing_range ? `<div class="flex items-center text-gray-600"><span class="font-medium">Range:</span> <span class="ml-1">${data.firing_range}</span></div>` : ''}
                            ${data.weight ? `<div class="flex items-center text-gray-600"><span class="font-medium">Weight:</span> <span class="ml-1">${data.weight}kg</span></div>` : ''}
                            ${data.build_material ? `<div class="flex items-center text-gray-600"><span class="font-medium">Material:</span> <span class="ml-1">${data.build_material}</span></div>` : ''}
                        </div>
                    ` : ''}
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('preview-content').innerHTML = previewContent;
    document.getElementById('preview-modal').classList.remove('hidden');
}

function closePreview() {
    document.getElementById('preview-modal').classList.add('hidden');
}

function saveDraft() {
    if (window.adminProductForm) {
        window.adminProductForm.saveDraft();
        window.adminProductForm.showNotification('Draft saved successfully!', 'success');
    }
}

// Initialize the form when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.adminProductForm = new AdminProductForm();
});

// Export for use in other scripts
export default AdminProductForm;