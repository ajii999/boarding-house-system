# Complete Bootstrap 5 Offline Setup Instructions

## Overview

This website has been fully converted to use Bootstrap 5 with local files for complete offline functionality. All layouts and pages are now responsive and work on mobile, tablet, and desktop devices.

## Quick Setup (5 Minutes)

### Step 1: Download Bootstrap 5.3.2

1. Go to: https://getbootstrap.com/docs/5.3/getting-started/download/
2. Click "Download" under "Compiled CSS and JS"
3. Extract the ZIP file
4. Copy these files:
   - `bootstrap.min.css` → `public/css/bootstrap.min.css`
   - `bootstrap.bundle.min.js` → `public/js/bootstrap.bundle.min.js`

### Step 2: Download Font Awesome 6.0.0

1. Go to: https://fontawesome.com/download
2. Download "Font Awesome Free"
3. Extract the ZIP file
4. Copy the entire `font-awesome` folder to: `public/css/font-awesome/`
   - Final path: `public/css/font-awesome/css/all.min.css`
   - Font files should be in: `public/css/font-awesome/webfonts/`

### Step 3: Verify File Structure

```
public/
├── css/
│   ├── bootstrap.min.css          ← Bootstrap CSS
│   └── font-awesome/
│       ├── css/
│       │   └── all.min.css        ← Font Awesome CSS
│       └── webfonts/
│           ├── fa-solid-900.woff2
│           ├── fa-regular-400.woff2
│           └── ... (other fonts)
└── js/
    └── bootstrap.bundle.min.js     ← Bootstrap JS
```

### Step 4: Test

1. Run: `php artisan serve`
2. Visit your website
3. Check browser console (F12) - should see no CDN errors
4. Test on mobile device or resize browser window

## What Has Been Converted

### ✅ Layouts (All Responsive)
- ✅ Tenant Layout - Bootstrap 5 with responsive sidebar
- ✅ Admin Layout - Bootstrap 5 with responsive sidebar  
- ✅ Staff Layout - Bootstrap 5 with responsive sidebar
- ✅ App Layout (for auth pages) - Bootstrap 5

### ✅ Authentication Pages
- ✅ Login Page - Fully responsive Bootstrap 5
- ✅ Register Page - Fully responsive Bootstrap 5

### ✅ Maintenance Pages
- ✅ Tenant Maintenance Show - Bootstrap 5 responsive
- ✅ Admin Maintenance Show - Bootstrap 5 responsive

### ✅ Features Implemented
- ✅ Responsive navigation (mobile hamburger menu)
- ✅ Bootstrap grid system (responsive columns)
- ✅ Bootstrap cards for content sections
- ✅ Bootstrap modals for images
- ✅ Bootstrap badges for status indicators
- ✅ Bootstrap buttons with responsive sizing
- ✅ Bootstrap tables with horizontal scroll on mobile
- ✅ Bootstrap alerts for notifications
- ✅ Responsive images (img-fluid, img-thumbnail)
- ✅ Mobile-first design approach

## Responsive Breakpoints

The website uses Bootstrap's standard breakpoints:
- **Mobile**: < 576px (extra small)
- **Tablet**: 576px - 991px (small to large)
- **Desktop**: ≥ 992px (extra large and above)

## Key Bootstrap Components Used

1. **Grid System**: `container`, `row`, `col-12`, `col-md-6`, `col-lg-4`
2. **Cards**: `card`, `card-header`, `card-body`
3. **Navigation**: Custom responsive sidebar with mobile toggle
4. **Modals**: `modal`, `modal-dialog`, `modal-content` for image viewing
5. **Tables**: `table`, `table-responsive` for scrollable tables
6. **Forms**: `form-control`, `form-label`, `input-group`
7. **Buttons**: `btn`, `btn-primary`, `btn-danger`, etc.
8. **Badges**: `badge` for status indicators
9. **Alerts**: `alert`, `alert-success`, `alert-danger`
10. **Utilities**: `d-flex`, `d-none`, `d-md-block`, `mb-3`, `p-4`, etc.

## Mobile Features

- **Collapsible Sidebar**: Slides in/out on mobile devices
- **Responsive Tables**: Horizontal scroll on small screens
- **Stacked Layouts**: Single column on mobile, multi-column on desktop
- **Touch-Friendly**: Larger buttons and touch targets on mobile
- **Responsive Images**: Automatically scale to fit screen
- **Mobile Menu**: Hamburger button for navigation on small screens

## Testing Responsiveness

1. **Desktop (≥992px)**: Sidebar always visible, multi-column layouts
2. **Tablet (768px-991px)**: Sidebar hidden by default, can be toggled
3. **Mobile (<768px)**: Sidebar hidden, hamburger menu, single column layouts

## Troubleshooting

### Bootstrap Not Loading?
- Check `public/css/bootstrap.min.css` exists
- Verify file permissions (should be readable)
- Clear browser cache (Ctrl+F5)

### Font Awesome Icons Missing?
- Check `public/css/font-awesome/css/all.min.css` exists
- Verify `public/css/font-awesome/webfonts/` folder has font files
- Check browser console for 404 errors

### Layout Looks Broken?
- Verify Bootstrap JS is loading: `public/js/bootstrap.bundle.min.js`
- Check browser console for JavaScript errors
- Ensure all layout files use `{{ asset() }}` helper

### Mobile Menu Not Working?
- Verify Bootstrap JS is loaded
- Check JavaScript console for errors
- Ensure sidebar toggle script is present

## File Size Reference

- Bootstrap CSS: ~200 KB
- Bootstrap JS: ~80 KB  
- Font Awesome CSS: ~100 KB
- Font Awesome Fonts: ~1-2 MB total

**Total**: ~1.5-2 MB (one-time download, then works offline)

## Next Steps

After setup, you can:
1. Customize Bootstrap colors in `public/css/bootstrap.min.css` (or use custom CSS)
2. Add custom styles in `@stack('styles')` section
3. Modify sidebar colors in layout files' `<style>` sections
4. Add more responsive utilities as needed

## Support

All layout files now include:
- ✅ Local Bootstrap CSS and JS references
- ✅ Local Font Awesome references
- ✅ Responsive navigation
- ✅ Mobile-friendly design
- ✅ Comprehensive HTML comments explaining sections

Your website is now fully responsive and works completely offline!

