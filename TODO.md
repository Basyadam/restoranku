# Login & Register Page Improvement Plan

## ✅ Step 1: Update auth CSS
- Add auth page styles to `public/assets/customer/css/style.css`
  - `.auth-card` modern card with shadow & rounded corners
  - `.auth-side` gradient side banner
  - `.auth-field` input group styling
  - `.auth-toggle-password` show/hide password button
  - `.auth-btn` submit button styling
  - `.demo-account` clickable demo account cards
  - `.strength-meter` password strength progress bar
  - `.password-match` password match indicator

## ⬜ Step 2: Redesign login page
- Rewrite `resources/views/auth/login.blade.php` with:
  - Split card layout (gradient side banner + form)
  - Show/hide password toggle
  - Per-field validation errors
  - Loading state on submit button
  - Clickable demo accounts (auto-fill)
  - Remember me checkbox

## ⬜ Step 3: Redesign register page
- Rewrite `resources/views/auth/register.blade.php` with:
  - Split card layout
  - Show/hide password for both password fields
  - Password strength meter
  - Real-time password match validation
  - Per-field validation errors
  - Loading state on submit button

## ⬜ Step 4: Update AuthController
- Add remember me support in login()

## ⬜ Step 5: Test
- Verify /login and /register render correctly
- Test show/hide password, strength meter, match validation, demo fill, loading state

