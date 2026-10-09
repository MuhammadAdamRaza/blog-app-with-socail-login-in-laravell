@extends('layouts.app')

@section('title', 'Products')

@section('content')
<style>
    .products-page { display:grid; gap:20px; }
    .products-hero { display:flex; align-items:center; justify-content:space-between; gap:20px; padding:28px 32px; border-radius:18px; color:#fff; background:linear-gradient(120deg,#111827 0%,#312e81 58%,#4f46e5 100%); box-shadow:0 16px 35px #312e8128; }
    .products-hero-copy { max-width:640px; }
    .products-kicker,.section-kicker { display:block; margin-bottom:7px; color:#c7d2fe; font-size:.72rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
    .products-hero h1 { margin:0; color:#fff; font-size:clamp(2rem,4vw,2.65rem); line-height:1.1; letter-spacing:-.045em; }
    .products-hero p { margin:10px 0 0; color:#e0e7ff; font-size:.98rem; }
    .products-message { display:none; margin:0; padding:13px 16px; border:1px solid #a7f3d0; border-radius:11px; color:#065f46; background:#ecfdf5; }
    .products-message.is-error { border-color:#fecaca; color:#991b1b; background:#fef2f2; }
    .products-workspace { display:grid; grid-template-columns:minmax(290px,.82fr) minmax(0,1.18fr); gap:20px; align-items:start; }
    .product-editor,.product-catalog { min-width:0; padding:24px; }
    .product-section-heading { margin-bottom:20px; }
    .section-kicker { margin-bottom:5px; color:#6366f1; }
    .product-section-heading h2,.product-list-heading h2 { margin:0; color:#0f172a; font-size:1.25rem; letter-spacing:-.02em; }
    .product-section-heading p,.product-list-heading p { margin:5px 0 0; color:#64748b; font-size:.9rem; }
    .product-form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:15px 13px; }
    .product-form-grid .full-width { grid-column:1 / -1; }
    .product-active-label { display:flex!important; min-height:44px; align-items:center; gap:9px; margin:0!important; padding:0 12px; border:1px solid #e2e8f0; border-radius:9px; background:#f8fafc; }
    .product-form-actions { display:flex; flex-wrap:wrap; align-items:center; gap:10px; margin-top:18px; }
    .product-form-actions [hidden] { display:none!important; }
    .product-list-heading { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; margin-bottom:17px; }
    .product-search-form { display:grid; grid-template-columns:minmax(0,1fr) auto auto; align-items:end; gap:9px; margin:0 0 18px; padding:13px; border:1px solid #e8eaf3; border-radius:12px; background:#f8fafc; }
    .product-search-form .field-group { min-width:0; }
    .product-search-form input { background:#fff; }
    .product-search-form .btn { min-width:92px; height:44px; }
    .product-list { display:grid; gap:12px; }
    .product-list .record-card { padding:17px; border-color:#e5e7eb; box-shadow:0 3px 12px #0f172a08; transition:border-color .18s ease,transform .18s ease,box-shadow .18s ease; }
    .product-list .record-card:hover { transform:translateY(-2px); border-color:#c7d2fe; box-shadow:0 10px 22px #312e8110; }
    .product-card-heading { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; }
    .product-card-heading h3 { margin:0; color:#111827; font-size:1rem; font-weight:750; overflow-wrap:anywhere; }
    .product-card-description { margin:8px 0; color:#64748b; font-size:.9rem; overflow-wrap:anywhere; }
    .product-status { display:inline-flex; align-items:center; padding:4px 9px; border-radius:999px; color:#047857; background:#ecfdf5; font-size:.72rem; font-weight:750; white-space:nowrap; }
    .product-status.is-inactive { color:#475569; background:#f1f5f9; }
    .product-meta { margin:0; color:#334155; font-size:.84rem; font-weight:650; }
    .product-actions { gap:9px; margin-top:14px; }
    .product-actions .btn { min-width:120px; }
    .product-empty { padding:34px 20px; border:1px dashed #cbd5e1; border-radius:12px; color:#64748b; background:#fbfcff; text-align:center; }
    @media(max-width:860px) { .products-workspace { grid-template-columns:1fr; } }
    @media(max-width:620px) {
        .products-hero { align-items:flex-start; flex-direction:column; padding:23px 21px; }
        .product-editor,.product-catalog { padding:18px; }
        .product-form-grid { grid-template-columns:1fr; }
        .product-form-grid .full-width { grid-column:auto; }
        .product-search-form { grid-template-columns:1fr 1fr; }
        .product-search-form .field-group { grid-column:1 / -1; }
        .product-search-form .btn { width:100%; min-width:0; }
    }
</style>

<div class="products-page">
    <header class="products-hero">
        <div class="products-hero-copy">
            <span class="products-kicker">Catalog workspace</span>
            <h1>Products</h1>
            <p>Add, organize, and update the items in your catalog from one place.</p>
        </div>
    </header>

    <p id="product-message" class="products-message" role="status" aria-live="polite"></p>

    <div class="products-workspace">
        <section class="page-card product-editor">
            <div class="product-section-heading">
                <span class="section-kicker">Product details</span>
                <h2 id="product-form-title">Add a product</h2>
                <p>Enter the product information below.</p>
            </div>
            <form id="product-form">
                <div class="product-form-grid">
                    <div class="field-group full-width">
                        <label for="product-name">Product name</label>
                        <input id="product-name" name="name" type="text" maxlength="255" placeholder="e.g. Wireless headphones" required>
                    </div>
                    <div class="field-group">
                        <label for="product-price">Price</label>
                        <input id="product-price" name="price" type="number" min="0" step="0.01" placeholder="0.00" required>
                    </div>
                    <div class="field-group">
                        <label for="product-stock">Stock quantity</label>
                        <input id="product-stock" name="stock" type="number" min="0" step="1" value="0">
                    </div>
                    <div class="field-group full-width">
                        <label for="product-description">Description</label>
                        <textarea id="product-description" name="description" rows="3" placeholder="Add a short product description"></textarea>
                    </div>
                    <div class="field-group full-width">
                        <label class="product-active-label" for="product-active">
                            <input id="product-active" name="is_active" type="checkbox" checked>
                            Available in catalog
                        </label>
                    </div>
                </div>
                <div class="product-form-actions">
                    <button id="product-submit" class="btn" type="submit">Add product</button>
                    <button id="cancel-edit" class="btn btn-secondary" type="button" hidden>Cancel edit</button>
                </div>
            </form>
        </section>

        <section class="page-card product-catalog">
            <div class="product-list-heading">
                <div>
                    <span class="section-kicker">Your catalog</span>
                    <h2>Products</h2>
                    <p>Browse active products or search by name and description.</p>
                </div>
                <button id="refresh-products" class="btn btn-secondary" type="button">Refresh</button>
            </div>
            <form id="product-search-form" class="product-search-form" role="search">
                <div class="field-group">
                    <label for="product-search">Search products</label>
                    <input id="product-search" type="search" placeholder="Type a product name">
                </div>
                <button class="btn" type="submit">Search</button>
                <button class="btn btn-secondary" id="clear-search" type="button">Clear</button>
            </form>
            <div id="product-list" class="record-list product-list" aria-live="polite">Loading products...</div>
        </section>
    </div>
</div>

<script>
(() => {
    const apiUrl = '/api/products';
    const productForm = document.querySelector('#product-form');
    const searchForm = document.querySelector('#product-search-form');
    const productList = document.querySelector('#product-list');
    const message = document.querySelector('#product-message');
    const submitButton = document.querySelector('#product-submit');
    const formTitle = document.querySelector('#product-form-title');
    const cancelEditButton = document.querySelector('#cancel-edit');
    let editingId = null;

    function showMessage(text, isError = false) {
        message.textContent = text;
        message.classList.toggle('is-error', isError);
        message.style.display = 'block';
        window.clearTimeout(showMessage.timeout);
        showMessage.timeout = window.setTimeout(() => {
            message.style.display = 'none';
        }, 5000);
    }

    async function apiRequest(url, options = {}) {
        const headers = { Accept: 'application/json', ...(options.headers || {}) };
        if (options.body) headers['Content-Type'] = 'application/json';

        const response = await fetch(url, { ...options, headers });
        const payload = await response.json().catch(() => ({}));

        if (!response.ok) {
            const validationMessages = payload.errors
                ? Object.values(payload.errors).flat().join(' ')
                : '';
            throw new Error(validationMessages || payload.message || `Request failed (${response.status}).`);
        }

        return payload;
    }

    function makeButton(label, className, onClick) {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = className;
        button.textContent = label;
        button.addEventListener('click', event => onClick(event.currentTarget));
        return button;
    }

    function renderProducts(products) {
        productList.replaceChildren();

        if (!products.length) {
            const empty = document.createElement('div');
            empty.className = 'product-empty';
            empty.textContent = 'No matching products found.';
            productList.append(empty);
            return;
        }

        products.forEach(product => {
            const card = document.createElement('article');
            card.className = 'record-card';

            const heading = document.createElement('div');
            heading.className = 'product-card-heading';
            const name = document.createElement('h3');
            name.textContent = product.name;
            const status = document.createElement('span');
            status.className = `product-status${product.is_active ? '' : ' is-inactive'}`;
            status.textContent = product.is_active ? 'Active' : 'Inactive';
            heading.append(name, status);

            const description = document.createElement('p');
            description.textContent = product.description || 'No description provided.';
            const details = document.createElement('p');
            details.className = 'product-meta';
            details.textContent = `Price: ${Number(product.price).toFixed(2)} | Stock: ${product.stock}`;

            const actions = document.createElement('div');
            actions.className = 'action-row product-actions';
            actions.append(makeButton('Edit', 'btn', () => startEdit(product)));
            actions.append(makeButton('Delete', 'btn btn-danger', trigger => deleteProduct(product, trigger)));
            card.append(heading, description, details, actions);
            productList.append(card);
        });
    }

    async function loadProducts(searchTerm = '') {
        productList.textContent = 'Loading products...';
        try {
            const url = searchTerm
                ? `${apiUrl}/search?q=${encodeURIComponent(searchTerm)}`
                : apiUrl;
            const result = await apiRequest(url);
            renderProducts(result.data || []);
        } catch (error) {
            productList.textContent = 'Could not load products.';
            showMessage(error.message, true);
        }
    }

    function startEdit(product) {
        editingId = product.id;
        formTitle.textContent = `Edit product #${product.id}`;
        submitButton.textContent = 'Save changes';
        cancelEditButton.hidden = false;
        document.querySelector('#product-name').value = product.name || '';
        document.querySelector('#product-description').value = product.description || '';
        document.querySelector('#product-price').value = product.price;
        document.querySelector('#product-stock').value = product.stock;
        document.querySelector('#product-active').checked = Boolean(product.is_active);
        productForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function resetForm() {
        editingId = null;
        productForm.reset();
        document.querySelector('#product-stock').value = 0;
        document.querySelector('#product-active').checked = true;
        formTitle.textContent = 'Add a product';
        submitButton.textContent = 'Add product';
        cancelEditButton.hidden = true;
    }

    productForm.addEventListener('submit', async event => {
        event.preventDefault();
        const payload = {
            name: document.querySelector('#product-name').value.trim(),
            description: document.querySelector('#product-description').value.trim() || null,
            price: Number(document.querySelector('#product-price').value),
            stock: Number(document.querySelector('#product-stock').value || 0),
            is_active: document.querySelector('#product-active').checked,
        };

        try {
            const editing = editingId !== null;
            const result = await apiRequest(editing ? `${apiUrl}/${editingId}` : apiUrl, {
                method: editing ? 'PUT' : 'POST',
                body: JSON.stringify(payload),
            });
            showMessage(result.message || (editing ? 'Product updated.' : 'Product added.'));
            resetForm();
            await loadProducts(document.querySelector('#product-search').value.trim());
        } catch (error) {
            showMessage(error.message, true);
        }
    });

    function deleteProduct(product, trigger) {
        window.showAppConfirmation(trigger, `Delete this product?`, async () => {
            try {
                const result = await apiRequest(`${apiUrl}/${product.id}`, { method: 'DELETE' });
                showMessage(result.message || 'Product deleted.');
                await loadProducts(document.querySelector('#product-search').value.trim());
            } catch (error) {
                showMessage(error.message, true);
            }
        });
    }

    searchForm.addEventListener('submit', event => {
        event.preventDefault();
        loadProducts(document.querySelector('#product-search').value.trim());
    });

    document.querySelector('#clear-search').addEventListener('click', () => {
        document.querySelector('#product-search').value = '';
        loadProducts();
    });

    document.querySelector('#refresh-products').addEventListener('click', () => {
        document.querySelector('#product-search').value = '';
        resetForm();
        loadProducts();
    });

    cancelEditButton.addEventListener('click', resetForm);
    loadProducts();
})();
</script>
@endsection
