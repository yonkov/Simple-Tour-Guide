# Simple Tour Guide - AI Coding Instructions

## Project Overview
WordPress plugin that creates interactive step-by-step user tours using Shepherd.js (v8.2.3). Users configure tours via WP admin, which render on the frontend as guided walkthroughs attached to DOM elements.

## Architecture

### Core Flow
1. **Admin Configuration** (`index.php`, `inc/admin.php`) → Settings stored in WP options (`stg_tour`, `stg_settings`, `stg_colors`)
2. **Frontend Enqueue** (`simple_tour_guide_scripts_and_styles()`) → Passes PHP data to JS via `wp_localize_script()`
3. **Tour Execution** (`assets/js/main.js`) → Reads localized params, builds Shepherd.js tour, manages localStorage

### Key Files
- **`index.php`**: Plugin entry point. All WordPress hooks, enqueue logic, option registration, AJAX handlers
- **`inc/admin.php`**: Admin notice/banner for Pro version upsell
- **`templates/form-*.php`**: Admin UI tabs (create tour, options, style, FAQ)
- **`assets/js/main.js`**: Frontend tour initialization and execution
- **`assets/js/admin.js`**: Dynamic step addition/removal in admin, WP Editor integration

## Critical Conventions

### Code Style Standards
**JavaScript:**
- Use classic `for` loops over `forEach()` unless inside callbacks
- Use classic `function` declarations over arrow functions except for callbacks
- Example from `main.js`: `for (i = 0; i < counter; i++)` pattern throughout

**PHP:**
- Follow **WordPress Coding Standards (WPCS)** strictly
- Use tabs for indentation, Yoda conditions for comparisons
- Array declaration: `array()` not `[]`, function braces on same line

### Data Storage Pattern
Tour data uses **dynamic numbered keys** stored in WP options:
```php
// Stored in 'stg_tour' option
'title_1', 'description_1', 'location_1', 'classname_1'
'title_2', 'description_2', 'location_2', 'classname_2'
// Step counter stored separately in 'stg_steps' option
```

**When editing step logic:**
- Loop from `1` to `simple_tour_guide_get_steps_count()` (not zero-indexed)
- Always update counter in DB via AJAX before form submission (`assets/js/admin.js:136`)
- Sanitize descriptions with `wp_kses_post()`, other fields with `sanitize_text_field()`

### Security Patterns
**Every file starts with:**
```php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // or exit( 'Woof Woof Woof!' );
}
```

**Escaping rules:**
- Database retrieval: `esc_attr()` for attributes, `wp_kses_post()` for HTML content
- Output: `esc_html_e()` for translatable strings, `esc_url()` for URLs
- AJAX: Nonce verification with `wp_verify_nonce()` (see `simple_tour_guide_save_counter()`)

### Frontend JavaScript Architecture
`main.js` is **self-executing IIFE** that:
1. Extracts data from `scriptParams` (localized by PHP)
2. Reorganizes into arrays (`stgStepTitles[]`, etc.) - **zero-indexed** despite PHP being 1-indexed
3. Builds Shepherd.js steps with dynamic buttons (Back/Next/Finish based on position)
4. Uses localStorage `tour-guide` key to track dismissal (`isDisplayOnce` setting)

**Key flags:**
- `isSkipStep`: Hides steps attached to invisible elements via `data-popper-reference-hidden` check
- `isBack`: Tracks navigation direction to skip correctly when going backwards
- `isHideMobile`: Early return at 640px breakpoint

### Admin UI Dynamics
- **Step management** (`admin.js`): Clone last step's DOM, increment IDs/names, re-initialize TinyMCE
- **TinyMCE integration**: Must remove editor before cloning (`wp.editor.remove()`), re-add after
- **Counter sync**: Counter stored client-side AND server-side; synced via AJAX on form submit

## Common Tasks

### Adding New Tour Options
1. Add checkbox to `templates/form-general.php` with `stg_settings[option_name]` name
2. Add default value to `$general_options` array in `index.php:simple_tour_guide_setup_sections()`
3. Pass to JS in `$script_params` array (`index.php:66`)
4. Access in `main.js` via `scriptParams.tour_settings.option_name`

### Modifying Tour Step Structure
1. Update loop in `index.php:simple_tour_guide_setup_sections()` to add new field keys
2. Add sanitization in `simple_tour_guide_sanitize()` for new fields
3. Update `templates/form-create.php` to add UI input
4. Modify `main.js` arrays (e.g., add `stgStepNewField[]`) and step object

### Working with Translations
- **Text domain:** `simple-tour-guide`
- **Use:** `esc_html_e()` for direct output, `__()` for returning strings
- **Admin strings:** Pass to JS via `scriptParams.strings` for consistency
- **NEVER include HTML in translatable strings:** Use placeholders (`%1$s`, `%2$s`) with `printf()` instead
- **Always add translator comments:** Use `/* translators: ... */` to explain placeholders
- **Example pattern:**
  ```php
  /* translators: %1$s is a line break, %2$s is a link */
  printf( __( 'Some text,%1$smore text - %2$s.', 'simple-tour-guide' ), 
      '<br>', 
      '<a href="#">' . esc_html__( 'Link text', 'simple-tour-guide' ) . '</a>' 
  );
  ```

## Development Workflow

### No Build Process
Direct file editing—refresh to see changes. Minified Shepherd.js is pre-built (`assets/lib/shepherd.min.js`).

### Testing Tours
- Enable "Show the tour only once" → clears on localStorage deletion
- Use browser DevTools: `localStorage.removeItem('tour-guide')` to reset
- Admin forms auto-clear localStorage on submit for testing convenience

### Common Pitfalls
- **Step numbering mismatch:** PHP 1-indexed, JS 0-indexed—always convert correctly
- **TinyMCE crashes:** Must remove before DOM cloning, reinitialize after
- **Checkbox values:** Use `true` string, not boolean (WP options quirk)
- **CSS selector validation:** Check `startsWith('.')` to avoid double dots (see `main.js:51`)

## External Dependencies
- **Shepherd.js 8.2.3**: Positioned tour library (Popper.js-based)
- **WordPress APIs**: Options API, Settings API, `wp_localize_script()`, TinyMCE
- **WP Color Picker (Iris)**: For style customization (`color-picker.js`)

## Free vs Pro
Free version limited to 1 tour. Pro features (not in codebase) include unlimited tours, custom event triggers, button-based start. Upsell UI in `inc/admin.php` and various template files.
