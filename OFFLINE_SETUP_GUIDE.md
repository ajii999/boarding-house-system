# Offline Setup Guide for Bootstrap and Font Awesome

To avoid tracking prevention issues and enable offline functionality, download and host Bootstrap and Font Awesome locally.

## Step 1: Download Bootstrap

1. Visit: https://getbootstrap.com/docs/5.3/getting-started/download/
2. Download the "Compiled CSS and JS" version
3. Extract the files
4. Copy to your project:
   - `bootstrap.min.css` → `public/css/bootstrap.min.css`
   - `bootstrap.bundle.min.js` → `public/js/bootstrap.bundle.min.js`

## Step 2: Download Font Awesome

1. Visit: https://fontawesome.com/download
2. Download Font Awesome Free (or use the CDN package)
3. Extract the files
4. Copy the entire `font-awesome` folder to `public/css/`
   - Structure should be: `public/css/font-awesome/css/all.min.css`
   - And: `public/css/font-awesome/webfonts/` (contains font files)

## Step 3: Update Layout Files

### For Tenant Layout (`resources/views/layouts/tenant.blade.php`):

Replace:
```html
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" rel="stylesheet">
```

With:
```html
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome/css/all.min.css') }}" rel="stylesheet">
```

And replace:
```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
```

With:
```html
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
```

### For Admin Layout (`resources/views/layouts/admin.blade.php`):

Make the same changes as above.

## Alternative: Quick CDN Fix

If you prefer to keep using CDNs, try these alternatives that are less likely to be blocked:

### Option 1: Use unpkg.com
```html
<link href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" rel="stylesheet">
```

### Option 2: Use BootstrapCDN (bootstrapcdn.com)
```html
<link href="https://cdn.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.bootstrapcdn.com/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
```

## Benefits of Local Files

- ✅ Works completely offline
- ✅ No tracking prevention issues
- ✅ Faster page loads (no external requests)
- ✅ More reliable (no dependency on CDN availability)
- ✅ Better for production environments
- ✅ No CORS issues
