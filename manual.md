# GRIMOIRE PUBLISHING SYSTEM
## OPERATOR'S MANUAL AND TECHNICAL REFERENCE
### Version 1.0

---

**Document Number:** GRM-1000-001
**Publication Date:** October 2025
**Prepared by:** Grimoire Technical Publications
**System Requirements:** PHP 8.2+, Kirby CMS 4.x

---

## TABLE OF CONTENTS

1. INTRODUCTION
2. SYSTEM ARCHITECTURE AND REQUIREMENTS
3. INSTALLATION AND CONFIGURATION
4. CONTENT MANAGEMENT PROCEDURES
5. READING INTERFACE OPERATION
6. ADMINISTRATIVE FUNCTIONS
7. TECHNICAL REFERENCE
8. TROUBLESHOOTING AND MAINTENANCE
9. APPENDICES

---

## 1. INTRODUCTION

### 1.1 PURPOSE AND SCOPE

This manual provides comprehensive documentation for the Grimoire Publishing System, a web-based content publishing platform designed for the distribution of long-form written works. The system enables content creators to author, manage, and publish books, novels, and serialized content for web-based consumption.

Grimoire is built upon the Kirby Content Management System (CMS) and provides an enhanced reading experience through progressive web technologies.

### 1.2 INTENDED AUDIENCE

This document serves three primary user classes:

- **System Administrators:** Responsible for installation, configuration, and maintenance
- **Content Authors:** Individuals creating and managing published works
- **End Users:** Readers accessing published content through the web interface

### 1.3 DOCUMENTATION CONVENTIONS

Throughout this manual, the following conventions are employed:

- **UPPERCASE** indicates system constants and configuration keys
- `monospace` indicates file paths, code, and command-line entries
- *italic* indicates field names and menu options
- **Bold** indicates important notices or warnings

### 1.4 RELATED DOCUMENTATION

- Kirby CMS Documentation: https://getkirby.com/docs
- PHP Manual: https://www.php.net/manual/
- Tailwind CSS Documentation: https://tailwindcss.com/docs

---

## 2. SYSTEM ARCHITECTURE AND REQUIREMENTS

### 2.1 SYSTEM OVERVIEW

Grimoire implements a hierarchical content structure consisting of three primary levels:

**Level 1: HOME**
The primary landing page displaying all published works in a grid layout.

**Level 2: BOOK**
Container pages for individual works, including metadata and chapter listings.

**Level 3: CHAPTER**
Individual content pages containing the readable text of each chapter.

[PLACEHOLDER: System architecture diagram showing Home → Book → Chapter hierarchy with database relationships]

### 2.2 HARDWARE REQUIREMENTS

**Minimum Server Configuration:**
- Processor: 1 GHz or faster
- Memory: 512 MB RAM minimum, 1 GB recommended
- Storage: 100 MB for system files, plus storage for content and media

**Client Browser Requirements:**
- Modern web browser with JavaScript enabled
- HTML5 and CSS3 support required
- LocalStorage API support recommended for enhanced features

### 2.3 SOFTWARE REQUIREMENTS

**Server Environment:**
- PHP Version: 8.2 or higher
- Required PHP Extensions: mbstring, gd, curl, zip
- Web Server: Apache, Nginx, or compatible
- Composer: Latest stable version

**Development Environment:**
- Node.js: 14.x or higher
- NPM: 6.x or higher
- Tailwind CSS: Configured via npm

### 2.4 LICENSING REQUIREMENTS

Grimoire is distributed under open source terms. However, the following third-party components require separate licensing:

- **Kirby CMS:** Requires commercial license for production use (evaluation free)
- **Fancybox UI:** Licensed under GPLv3 or commercial license

---

## 3. INSTALLATION AND CONFIGURATION

### 3.1 INITIAL INSTALLATION

**PROCEDURE 3.1.1: Installing Grimoire**

1. Extract the Grimoire distribution archive to your web server document root
2. Navigate to the installation directory via command line interface
3. Execute dependency installation:
   ```
   composer update
   ```
4. Install frontend dependencies:
   ```
   npm install
   ```
5. Build frontend assets:
   ```
   npm run build
   ```

**NOTE:** For development environments, use `npm run watch` to enable automatic asset rebuilding.

[PLACEHOLDER: Screenshot of terminal showing successful composer update]

### 3.2 WEB SERVER CONFIGURATION

**PROCEDURE 3.2.1: Apache Configuration**

Grimoire includes a pre-configured `.htaccess` file. Ensure `mod_rewrite` is enabled:

```apache
LoadModule rewrite_module modules/mod_rewrite.so
```

**PROCEDURE 3.2.2: Starting Development Server**

For local development, utilize the built-in PHP server:

```
composer start
```

This command executes: `php -S localhost:8000 kirby/router.php`

Access the system at: `http://localhost:8000`

[PLACEHOLDER: Browser screenshot showing Grimoire home page on localhost:8000]

### 3.3 ADMINISTRATIVE PANEL ACCESS

The Kirby Panel provides the administrative interface for content management.

**PROCEDURE 3.3.1: Initial Panel Access**

1. Navigate to: `http://[your-domain]/panel`
2. On first access, create an administrator account
3. Enter desired credentials
4. Submit account creation form

[PLACEHOLDER: Screenshot of Kirby Panel login screen]

**WARNING:** Store administrative credentials securely. Lost credentials require manual file system recovery.

### 3.4 SYSTEM CONFIGURATION

Primary system configuration is located in `site/config/config.php`.

**CONFIGURATION 3.4.1: Debug Mode**

For production environments, ensure debug mode is disabled:

```php
'debug' => false
```

**CONFIGURATION 3.4.2: Markdown Settings**

Grimoire enables extended Markdown features:

```php
'markdown' => [
  'extra' => true
]
```

**CONFIGURATION 3.4.3: Image Processing**

Thumbnail generation settings:

```php
'thumbs' => [
  'driver' => 'gd',
  'quality' => 80
]
```

### 3.5 SITE-LEVEL SETTINGS

Access site settings through the Panel at Settings > Site.

**Setting Fields:**

| Field Name | Type | Description |
|------------|------|-------------|
| *Name* | Text | Site name displayed in navigation |
| *Logo* | File | Optional logo image (replaces text name when enabled) |
| *Show Logo?* | Toggle | Controls logo display |
| *Show attribution at the bottom?* | Toggle | Controls footer attribution display |
| *Show Book/Comic badges?* | Toggle | Controls content type badges on home page |

[PLACEHOLDER: Screenshot of site settings interface in Panel]

---

## 4. CONTENT MANAGEMENT PROCEDURES

### 4.1 CONTENT HIERARCHY OVERVIEW

All content resides in the `content/` directory with the following structure:

```
content/
├── 1_book-name/
│   ├── book.txt
│   ├── cover.jpg
│   ├── 1_chapter-name/
│   │   └── chapter.txt
│   ├── 2_next-chapter/
│   │   └── chapter.txt
│   └── ...
└── 2_another-book/
    └── ...
```

**NOTE:** Numeric prefixes determine display order. Higher numbers appear later in sequence.

### 4.2 CREATING A NEW BOOK

**PROCEDURE 4.2.1: Book Creation**

1. Access the Panel at `/panel`
2. Navigate to the Home page view
3. Click "+ Add" button
4. Select "Book" from template options
5. Enter URL slug (must be unique, lowercase, hyphen-separated)
6. Click "Add" to create book page

[PLACEHOLDER: Screenshot of Add Page dialog with Book template selected]

### 4.3 CONFIGURING BOOK METADATA

**PROCEDURE 4.3.1: Book Field Entry**

Navigate to the newly created book page and complete the following fields:

**Required Fields:**

| Field | Description | Format |
|-------|-------------|--------|
| *Title* | Primary book title | Plain text |
| *Subtitle* | Secondary title or tagline | Plain text |
| *Author* | Author name(s) | Plain text |
| *Blurb* | Marketing description | Markdown supported |
| *Cover* | Cover image | Image file (JPG, PNG recommended) |

**Optional Fields:**

| Field | Description | Default |
|-------|-------------|---------|
| *Content Rating* | Display filtering | SFW |
| *Series Name* | If part of series | Empty |
| *Series Number* | Sequential position | Empty |

[PLACEHOLDER: Screenshot of book metadata editing interface]

**Content Rating Options:**

- **SFW (Safe for Work):** No content warnings, displayed normally
- **NSFW (Not Safe for Work):** Cover blurred on home page, click to reveal
- **NSFL (Not Safe for Life):** Cover blurred, requires confirmation dialog

### 4.4 UPLOADING COVER IMAGES

**PROCEDURE 4.4.1: Cover Image Upload**

1. In book editing view, locate *Cover* field
2. Click "+" or drag image file to upload area
3. Wait for upload completion
4. Image appears in cover field
5. Click "Save" to commit changes

**Image Specifications:**

- Recommended dimensions: 1600 x 2400 pixels (2:3 aspect ratio)
- Maximum file size: Determined by PHP configuration
- Supported formats: JPEG, PNG, WebP
- Color mode: RGB

**NOTE:** Grimoire automatically generates thumbnails for optimal display performance.

### 4.5 CREATING CHAPTERS

**PROCEDURE 4.5.1: Chapter Creation**

1. Within book editing view, locate "Chapters" section
2. Click "+ Add" button
3. Select "Chapter" template
4. Enter chapter URL slug
5. Click "Add" to create chapter

**PROCEDURE 4.5.2: Chapter Content Entry**

[PLACEHOLDER: Screenshot of chapter editing interface showing content field]

Navigate to chapter editing view and complete:

**Primary Fields:**

| Field | Description | Required |
|-------|-------------|----------|
| *Title* | Chapter title | Yes |
| *Subtitle* | Optional subtitle | No |
| *Content* (wcontent) | Chapter text | Yes |

**NOTE:** The content field is internally named `wcontent`, not the standard `content` field.

### 4.6 AUTHOR'S NOTES

Chapters support optional author's notes displayed before or after chapter content.

**PROCEDURE 4.6.1: Adding Author's Notes**

1. In chapter editing view, locate *Author's note* field
2. Enter note text (Markdown supported)
3. Select *Author's note mode*:
   - **Don't Display:** Note saved but not shown
   - **Display Before Chapter:** Note appears above chapter text
   - **Display After Chapter:** Note appears below chapter text
4. Save changes

[PLACEHOLDER: Screenshot showing author's note in gray box on chapter page]

### 4.7 CHAPTER ORDERING

Chapter display order is determined by numeric prefixes in the file system.

**PROCEDURE 4.7.1: Reordering Chapters**

1. In book editing view, locate "Chapters" section
2. Hover over chapter to reveal handle icon
3. Click and drag chapter to new position
4. Release to commit new order
5. System automatically updates numeric prefixes

### 4.8 SERIES MANAGEMENT

Books may be organized into series with sequential navigation.

**PROCEDURE 4.8.1: Adding Book to Series**

1. Edit book metadata
2. Enter *Series Name* (must match exactly across all books in series)
3. Enter *Series Number* (integer: 1, 2, 3, etc.)
4. Save changes

When series metadata is configured, automatic "Previous" and "Next" navigation links appear on book pages, allowing readers to traverse the series sequentially.

[PLACEHOLDER: Screenshot showing previous/next series navigation on book page]

---

## 5. READING INTERFACE OPERATION

### 5.1 HOME PAGE INTERFACE

The home page displays all published books in a responsive grid layout.

**Interface Components:**

- **Navigation Bar:** Site name/logo, theme toggle, Panel access link
- **Book Grid:** Thumbnail cards for each book
- **Book Card Elements:** Cover image, title, series information (if applicable), author name
- **Footer:** Optional attribution text

[PLACEHOLDER: Screenshot of home page with multiple books in grid layout]

**User Actions:**

- Click any book card to navigate to book detail page
- Click Panel icon to access administrative interface
- Click theme toggle to switch between light/dark modes

### 5.2 BOOK PAGE INTERFACE

Book pages provide comprehensive information about a work and chapter access.

**Layout Structure:**

**Left Column (Desktop):**
- Cover image (full size)

**Right Column (Desktop):**
- Series information (if applicable)
- Title and subtitle
- Author name
- Blurb text
- Series navigation (previous/next in series)
- Reading progress indicator
- "Resume Reading" button
- Total reading time estimate
- Chapter list with individual reading times

[PLACEHOLDER: Screenshot of book page showing two-column layout]

**Mobile Layout:**

On screens below 768px width, layout converts to single column with cover image at top.

### 5.3 CHAPTER READING INTERFACE

Chapter pages provide optimized reading experience with minimal distractions.

**Interface Components:**

**Top Navigation Bar:**
- Back button (returns to book page)
- Breadcrumb: Book Title » Chapter Title
- Font size controls (A-, A, A+) - desktop only
- Theme toggle

**Reading Progress Bar:**
- Fixed at top of viewport
- Fills left-to-right as reader scrolls
- Black gradient in light mode, white gradient in dark mode

**Content Area:**
- Author's note (if configured for "before" display)
- Chapter content (centered, optimized typography)
- Author's note (if configured for "after" display)
- "Read Next" button (if subsequent chapter exists)

[PLACEHOLDER: Screenshot of chapter reading interface with progress bar]

### 5.4 THEME SWITCHING

Grimoire supports light and dark reading modes.

**PROCEDURE 5.4.1: Manual Theme Toggle**

Method 1: Click moon/sun icon in navigation bar
Method 2: Press `T` key on keyboard

**Theme Characteristics:**

| Element | Light Mode | Dark Mode |
|---------|------------|-----------|
| Background | White (#FFFFFF) | Dark Gray (#111827) |
| Primary Text | Black (#000000) | Light Gray (#F9FAFB) |
| Secondary Text | Gray (#6B7280) | Medium Gray (#9CA3AF) |
| Progress Bar | Black gradient | White gradient |

**Persistence:** Theme preference stored in browser LocalStorage, persists across sessions.

### 5.5 FONT SIZE ADJUSTMENT

Desktop users can adjust reading text size for optimal comfort.

**PROCEDURE 5.5.1: Font Size Selection**

1. Navigate to any chapter page
2. Locate font size controls (A-, A, A+) in navigation bar
3. Click desired size:
   - **A-** (Small): prose-sm class
   - **A** (Default): prose-lg class
   - **A+** (Large): prose-xl class
4. Size preference saved automatically

**NOTE:** Font size controls hidden on mobile devices (screen width < 768px) to preserve navigation bar space.

[PLACEHOLDER: Screenshot showing three different font sizes side by side]

### 5.6 READING PROGRESS TRACKING

Grimoire automatically tracks reading progress at both chapter and book levels.

**TRACKING MECHANISM 5.6.1: Chapter Progress**

- System monitors scroll position in real-time
- When reader scrolls to 90% of chapter length, chapter marked as complete
- Progress data stored in LocalStorage: `grimoire_chapter_progress_{bookId}`
- Completed chapters display with reduced opacity (40%) on book page

**TRACKING MECHANISM 5.6.2: Book Progress**

- Book page displays progress indicator when any chapters completed
- Shows: "X of Y chapters (Z%)"
- Visual progress bar fills proportionally
- Progress data persists in browser LocalStorage

[PLACEHOLDER: Screenshot of book page showing progress indicator at 60%]

### 5.7 SCROLL POSITION MEMORY

The system preserves exact scroll position for each chapter.

**MECHANISM 5.7.1: Position Saving**

- Scroll position saved automatically every 500ms during reading
- Position saved on page navigation
- Stored with timestamp in LocalStorage: `grimoire_reading_position_{bookId}_{chapterId}`

**MECHANISM 5.7.2: Position Restoration**

- On chapter page load, system checks for saved position
- If found, page scrolls to saved location after 100ms delay
- Allows seamless continuation of reading session

### 5.8 RESUME READING FUNCTIONALITY

Book pages provide quick access to most recently read chapter.

**MECHANISM 5.8.1: Last Read Detection**

1. System examines all chapters in book
2. Retrieves saved reading position timestamps
3. Identifies chapter with most recent timestamp
4. Displays "Resume Reading" button linking to that chapter

**User Action:**

Click "Resume Reading" button to navigate directly to last-read chapter at saved scroll position.

[PLACEHOLDER: Screenshot highlighting Resume Reading button]

### 5.9 READING TIME ESTIMATES

All reading time calculations based on 225 words per minute (industry standard).

**Display Locations:**

- **Book Page:** Total reading time for entire book
- **Chapter List:** Individual time estimate per chapter

**Calculation Method:**

```
words_in_content = str_word_count(chapter_content)
minutes = ceil(words_in_content / 225)
```

### 5.10 KEYBOARD SHORTCUTS

The following keyboard shortcuts enhance reading efficiency:

| Key | Function | Context |
|-----|----------|---------|
| `T` | Toggle theme | All pages |
| `→` (Right Arrow) | Next chapter | Chapter pages |
| `←` (Left Arrow) | Previous page | Chapter pages |

**NOTE:** Keyboard shortcuts disabled when input/textarea elements have focus.

### 5.11 DISTRACTION-FREE READING MODE

Navigation bar automatically hides during scrolling to maximize reading space.

**BEHAVIOR 5.11.1: Auto-Hide Navigation**

- When scrolling down beyond 100 pixels: navigation slides up and fades out
- When scrolling up: navigation slides down and fades in
- When hovering near top of page: navigation becomes visible
- Smooth CSS transitions provide non-jarring experience

This feature reduces visual clutter during active reading while maintaining quick access to controls.

### 5.12 RSS FEED ACCESS

Each book provides an XML RSS feed for chapter notifications.

**PROCEDURE 5.12.1: Subscribing to Book Feed**

1. Navigate to book page
2. Click RSS icon in navigation bar
3. Browser displays XML feed or prompts for feed reader
4. Add URL to preferred RSS reader application

**Feed URL Format:** `https://[domain]/[book-slug].xml`

---

## 6. ADMINISTRATIVE FUNCTIONS

### 6.1 USER MANAGEMENT

**PROCEDURE 6.1.1: Creating Additional Users**

1. Log into Panel as administrator
2. Navigate to Users section
3. Click "+ Add" to create new user
4. Enter user details:
   - Email address
   - Password
   - User role (Admin or Editor)
   - Language preference
5. Save user account

**User Roles:**

| Role | Permissions |
|------|-------------|
| Admin | Full system access, user management, settings |
| Editor | Content creation and editing, no settings access |

### 6.2 CONTENT PUBLICATION CONTROL

**PROCEDURE 6.2.1: Publishing Content**

Content visibility controlled by page status:

- **Draft:** Content exists but not listed on site
- **Listed:** Content visible to public

To publish content:
1. Edit page in Panel
2. Locate status control (top right)
3. Change from "Draft" to "Listed"
4. Save changes

**PROCEDURE 6.2.2: Unpublishing Content**

1. Edit page in Panel
2. Change status from "Listed" to "Unlisted" or "Draft"
3. Save changes
4. Content removed from public view immediately

[PLACEHOLDER: Screenshot showing status toggle between Draft and Listed]

### 6.3 BACKUP PROCEDURES

**PROCEDURE 6.3.1: Content Backup**

1. Access server via FTP, SFTP, or shell
2. Navigate to installation directory
3. Create compressed archive of:
   - `/content` directory (all content and metadata)
   - `/media` directory (uploaded images)
   - `/site` directory (templates and configuration)
4. Download archive to secure location
5. Verify archive integrity

**Recommended Backup Frequency:** Daily for active sites, weekly for static sites

**PROCEDURE 6.3.2: Database-Free Architecture**

**NOTE:** Grimoire utilizes file-based storage. No database backup required. All content exists as human-readable text files.

### 6.4 ASSET COMPILATION

**PROCEDURE 6.4.1: CSS Rebuilding**

When modifying styles:

1. Edit source file: `assets/css/processing.css`
2. Execute build command:
   ```
   npm run build
   ```
3. Compiled output written to: `assets/css/tailwind.css`
4. Clear browser cache to see changes

**PROCEDURE 6.4.2: Development Workflow**

For active development:

```
npm run watch
```

This command monitors source files and automatically rebuilds on changes.

### 6.5 SYSTEM UPDATES

**PROCEDURE 6.5.1: Updating Kirby CMS**

1. Backup entire installation (see PROCEDURE 6.3.1)
2. Navigate to installation directory via command line
3. Execute update command:
   ```
   composer update
   ```
4. Review update log for breaking changes
5. Test site functionality
6. If issues occur, restore from backup

**PROCEDURE 6.5.2: Updating Frontend Dependencies**

1. Check for outdated packages:
   ```
   npm outdated
   ```
2. Update packages:
   ```
   npm update
   ```
3. Rebuild assets:
   ```
   npm run build
   ```
4. Test site functionality

---

## 7. TECHNICAL REFERENCE

### 7.1 FILE SYSTEM STRUCTURE

```
kirby-grimoire/
├── assets/
│   ├── css/
│   │   ├── processing.css      # Tailwind source
│   │   └── tailwind.css        # Compiled output
│   ├── js/
│   │   └── main.js             # Custom JavaScript
│   └── img/
│       └── fallback.jpg        # Default cover image
├── content/                    # Content storage
│   ├── site.txt                # Site metadata
│   └── [numbered-books]/       # Book directories
├── kirby/                      # Kirby CMS core (vendor)
├── media/                      # Auto-generated thumbnails
├── site/
│   ├── blueprints/             # Panel field definitions
│   │   ├── site.yml            # Site settings blueprint
│   │   ├── pages/
│   │   │   ├── book.yml        # Book field definitions
│   │   │   └── chapter.yml     # Chapter field definitions
│   │   └── files/              # File field definitions
│   ├── config/
│   │   └── config.php          # System configuration
│   ├── models/                 # Custom page models
│   ├── snippets/               # Reusable code fragments
│   │   ├── head.php            # HTML head section
│   │   └── scripts.php         # JavaScript and styles
│   └── templates/              # Page rendering
│       ├── home.php            # Landing page
│       ├── book.php            # Book detail page
│       ├── book.xml.php        # RSS feed template
│       └── chapter.php         # Chapter reading page
├── .htaccess                   # Apache configuration
├── composer.json               # PHP dependencies
├── package.json                # Node dependencies
└── tailwind.config.js          # Tailwind configuration
```

### 7.2 LOCALSTORAGE DATA SCHEMA

Grimoire stores user preferences and progress in browser LocalStorage using the following keys:

| Key | Data Type | Purpose |
|-----|-----------|---------|
| `grimoire_theme` | String | "light" or "dark" |
| `grimoire_font_size` | String | "small", "default", or "large" |
| `grimoire_chapter_progress_{bookId}` | Array | List of completed chapter IDs |
| `grimoire_reading_position_{bookId}_{chapterId}` | Object | `{scroll: Number, timestamp: Number}` |

**Example Reading Position:**
```json
{
  "scroll": 2840,
  "timestamp": 1698765432000
}
```

### 7.3 CONTENT FILE FORMAT

All content stored in plain text format with YAML frontmatter.

**EXAMPLE 7.3.1: Book Metadata (book.txt)**

```
Title: The Manual

----

Subtitle: A Comprehensive Guide

----

Author: Technical Publications

----

Blurb: Complete system documentation

----

Cover:
- cover.jpg

----

Rating: sfw

----

Seriesname: Documentation Series

----

Seriesnumber: 1
```

**EXAMPLE 7.3.2: Chapter Content (chapter.txt)**

```
Title: Chapter One

----

Subtitle: Getting Started

----

Wcontent:

This is the chapter content written in Markdown.

## Headings Work

- Bullet lists
- Also work

**Bold** and *italic* supported.

----

An: This is an author's note.

----

Anmode: after
```

### 7.4 TEMPLATE HIERARCHY

Kirby automatically selects templates based on page type:

```
Page Type → Blueprint → Template → Output
──────────────────────────────────────────
site      → site.yml  → home.php → HTML
book      → book.yml  → book.php → HTML
book.xml  → (same)    → book.xml.php → XML/RSS
chapter   → chapter.yml → chapter.php → HTML
```

### 7.5 CSS ARCHITECTURE

**Tailwind Configuration (tailwind.config.js):**

- **Dark Mode:** Class-based (`darkMode: 'class'`)
- **Content Paths:** Scans `site/**/*.php`, `site/**/*.js`, `content/**/*.txt`
- **Plugins:** Typography plugin for prose styling

**Custom Styles (site/snippets/scripts.php):**

Inline `<style>` block provides:
- Reading progress bar styling
- Navigation hide/show animations
- Font size button active states
- Comic-specific styles (if comic feature used)

### 7.6 JAVASCRIPT ARCHITECTURE

All reading features encapsulated in `Grimoire` namespace.

**Core Modules:**

1. **Storage Utility** (`Grimoire.storage`)
   - `get(key, defaultValue)`: Retrieve from LocalStorage
   - `set(key, value)`: Store in LocalStorage

2. **Reading Progress Bar**
   - Monitors scroll position via `requestAnimationFrame`
   - Updates progress bar width in real-time

3. **Scroll Position Tracking**
   - Saves position every 500ms during scroll
   - Restores on page load after 100ms delay

4. **Chapter Completion Tracking**
   - Monitors when reader reaches 90% of content
   - Marks chapter as read in LocalStorage

5. **Font Size Controls**
   - Manipulates Tailwind typography classes
   - Persists preference across sessions

6. **Theme Toggle**
   - Adds/removes `dark` class on `<html>` element
   - Updates icon graphic
   - Persists preference

7. **Distraction-Free Mode**
   - Hides/shows navigation based on scroll direction
   - Uses `requestAnimationFrame` for performance

8. **Keyboard Shortcuts**
   - Listens for key events
   - Prevents default when shortcuts triggered
   - Respects input focus state

### 7.7 API ENDPOINTS

Grimoire does not provide a REST API. All content access occurs through rendered HTML pages and RSS feeds.

**Public URLs:**

| Pattern | Description |
|---------|-------------|
| `/` | Home page (all books) |
| `/{book-slug}` | Book detail page |
| `/{book-slug}.xml` | Book RSS feed |
| `/{book-slug}/{chapter-slug}` | Chapter reading page |
| `/panel` | Administrative interface |

### 7.8 MARKDOWN EXTENSIONS

Kirby's Markdown Extra features enabled by default.

**Supported Syntax:**

- Standard Markdown: headings, lists, links, images, emphasis
- Tables: Pipe-delimited table syntax
- Fenced code blocks: Triple backtick syntax
- Definition lists: Colon-based definitions
- Footnotes: Reference-style footnotes
- Abbreviations: Definition-based abbreviations
- KirbyTags: `(image: filename.jpg)`, `(link: page-name text: Link Text)`

---

## 8. TROUBLESHOOTING AND MAINTENANCE

### 8.1 COMMON ISSUES

**ISSUE 8.1.1: Panel Access Denied**

**Symptoms:** Cannot access `/panel`, receives error

**Resolution:**
1. Verify `.htaccess` file present in root directory
2. Verify Apache `mod_rewrite` enabled
3. Check file permissions: Panel requires write access to `/site/accounts`
4. Review PHP error log for specific errors

**ISSUE 8.1.2: Cover Images Not Displaying**

**Symptoms:** Book covers show fallback image or broken image icon

**Resolution:**
1. Verify image uploaded to book via Panel
2. Check file exists in: `/content/{book-number}_{book-slug}/`
3. Verify PHP GD extension installed: `php -m | grep gd`
4. Check file permissions: Web server must read content directory
5. Clear media cache: Delete `/media` directory (regenerates automatically)

[PLACEHOLDER: Screenshot showing correctly uploaded cover image in Panel]

**ISSUE 8.1.3: CSS Changes Not Appearing**

**Symptoms:** Style modifications not reflected in browser

**Resolution:**
1. Verify editing correct file: `assets/css/processing.css`
2. Rebuild CSS: `npm run build`
3. Clear browser cache: Hard refresh (Ctrl+F5 or Cmd+Shift+R)
4. Verify output file updated: Check modification time of `assets/css/tailwind.css`

**ISSUE 8.1.4: Progress Tracking Not Working**

**Symptoms:** Reading progress not saved, "Resume Reading" not appearing

**Resolution:**
1. Verify JavaScript enabled in browser
2. Check browser console for JavaScript errors
3. Verify LocalStorage not disabled:
   - Open browser DevTools
   - Navigate to Application/Storage tab
   - Verify LocalStorage accessible
4. Check browser privacy settings: Some privacy modes disable LocalStorage
5. Verify `data-book-id` and `data-chapter-id` attributes present on `<body>` element

**ISSUE 8.1.5: Chapter Content Not Displaying**

**Symptoms:** Chapter page loads but content area empty

**Resolution:**
1. Verify content entered in `wcontent` field (not `content`)
2. Check chapter.txt file contains `Wcontent:` section
3. Verify no YAML syntax errors in chapter.txt
4. Check PHP error log for template rendering errors

### 8.2 PERFORMANCE OPTIMIZATION

**OPTIMIZATION 8.2.1: Image Compression**

For optimal load times:
1. Compress cover images before upload
2. Use tools: ImageOptim, TinyPNG, or Squoosh
3. Target file size: Under 500 KB per cover image
4. Kirby generates thumbnails automatically from source

**OPTIMIZATION 8.2.2: CSS Purging**

Production builds should purge unused CSS:

Tailwind configuration already optimized:
- Scans only necessary files for class usage
- Automatically removes unused utilities
- `npm run build` produces minified output

**OPTIMIZATION 8.2.3: PHP Caching**

For high-traffic sites:
1. Enable PHP OPcache in php.ini:
   ```ini
   opcache.enable=1
   opcache.memory_consumption=128
   opcache.max_accelerated_files=10000
   ```
2. Consider Kirby's built-in cache (requires configuration)

### 8.3 SECURITY BEST PRACTICES

**SECURITY 8.3.1: Production Checklist**

Before deploying to production:

- [ ] Disable debug mode in `site/config/config.php`
- [ ] Use strong passwords for Panel accounts (minimum 12 characters)
- [ ] Restrict Panel access to admin IP addresses (if feasible)
- [ ] Enable HTTPS/SSL (required for LocalStorage security)
- [ ] Keep Kirby and dependencies updated
- [ ] Set appropriate file permissions:
  - Directories: 755
  - Files: 644
  - Except: `site/accounts/` requires write access
- [ ] Remove unused Panel users
- [ ] Regular backups configured

**SECURITY 8.3.2: Content Sanitization**

Kirby automatically sanitizes user input. However:

- Review uploaded files: Only allow trusted users to upload
- Content Rating system: Use NSFW/NSFL appropriately
- Author's notes: Markdown permitted but HTML filtered

### 8.4 LOG FILE LOCATIONS

**PHP Error Log:**
- Location varies by server configuration
- Common: `/var/log/php/error.log` or server root
- Enable in php.ini: `log_errors = On`

**Web Server Logs:**
- Apache: `/var/log/apache2/error.log`
- Nginx: `/var/log/nginx/error.log`

**Kirby Debug Mode:**
When enabled, errors display directly in browser (development only).

---

## 9. APPENDICES

### APPENDIX A: GLOSSARY OF TERMS

**Blurb:** Marketing description text for a book, displayed on book detail page.

**Blueprint:** YAML configuration file defining fields and structure for Panel editing interface.

**Chapter:** Individual content page within a book, containing readable text.

**Grimoire:** The system name, referring to this web publishing platform.

**KirbyTags:** Special syntax for embedding content: `(image: file.jpg)`, `(link: page)`

**LocalStorage:** Browser API for persistent client-side data storage.

**Panel:** Kirby's administrative web interface for content management.

**Prose:** Tailwind CSS plugin providing optimized typography for long-form reading.

**Slug:** URL-friendly identifier for pages, lowercase with hyphens.

**Template:** PHP file that renders page content as HTML.

**wcontent:** Field name for chapter content (Grimoire-specific, not standard Kirby field).

### APPENDIX B: KEYBOARD SHORTCUT REFERENCE

| Key | Action | Available On |
|-----|--------|--------------|
| `T` | Toggle light/dark theme | All pages |
| `→` | Navigate to next chapter | Chapter pages |
| `←` | Navigate to previous page/book | Chapter pages |
| `A-` | Decrease font size | Chapter pages (desktop) |
| `A` | Reset to default font size | Chapter pages (desktop) |
| `A+` | Increase font size | Chapter pages (desktop) |

**Note:** Shortcuts disabled when text input has focus.

### APPENDIX C: CONTENT RATING SYSTEM

| Rating | Meaning | Home Page Behavior | Access Requirement |
|--------|---------|-------------------|-------------------|
| SFW | Safe for Work | Cover displayed normally | None |
| NSFW | Not Safe for Work | Cover blurred, click to reveal | Single click |
| NSFL | Not Safe for Life | Cover blurred, click prompts warning | Click + confirmation |

**Implementation Notes:**
- Rating stored in book.txt as `Rating:` field
- Blurring implemented via CSS class `blur-xl`
- JavaScript handles click events and confirmations
- NSFL warning text: "This content is marked as NSFL (Not Safe for Life) and may contain extremely disturbing material. Are you sure you want to reveal this content?"

### APPENDIX D: SERIES NAVIGATION SPECIFICATION

Series navigation enables multi-book sequential reading.

**Requirements:**
1. Each book in series must have identical `seriesname` value
2. Each book must have unique `seriesnumber` (integer, starting from 1)
3. Numbers must be sequential (no gaps: 1, 2, 3, etc.)

**Behavior:**
- Book page displays "Previous" link if book N-1 exists with matching series name
- Book page displays "Next" link if book N+1 exists with matching series name
- Links positioned below blurb text, before progress indicator
- Format: Border buttons with arrow indicators

**Example Series Configuration:**

Book 1: `Seriesname: The Chronicles` / `Seriesnumber: 1`
Book 2: `Seriesname: The Chronicles` / `Seriesnumber: 2`
Book 3: `Seriesname: The Chronicles` / `Seriesnumber: 3`

### APPENDIX E: RSS FEED SPECIFICATION

Each book automatically generates an RSS 2.0 feed.

**Feed URL:** `https://[domain]/[book-slug].xml`

**Feed Elements:**
- `<title>` Book title
- `<description>` Book blurb
- `<link>` Book URL
- `<item>` One per chapter, containing:
  - `<title>` Chapter title
  - `<description>` First 500 characters of chapter content
  - `<link>` Chapter URL
  - `<pubDate>` Chapter publication date
  - `<guid>` Unique chapter identifier

**Template Location:** `site/templates/book.xml.php`

### APPENDIX F: TAILWIND TYPOGRAPHY CLASSES

Grimoire uses Tailwind's Typography plugin for optimized reading.

**Applied Classes:**

| Class | Purpose | Applied To |
|-------|---------|------------|
| `prose` | Base typography styles | Content containers |
| `prose-sm` | Small text size | Content (when user selects A-) |
| `prose-lg` | Large text size (default) | Content (default state) |
| `prose-xl` | Extra large text | Content (when user selects A+) |
| `dark:prose-invert` | Dark mode text colors | Content (in dark theme) |
| `max-w-prose` | Optimal reading width | Content containers |

**Effective Measurements:**
- `prose-sm`: Approximately 14px base font
- `prose-lg`: Approximately 18px base font (default)
- `prose-xl`: Approximately 20px base font
- `max-w-prose`: 65 characters per line (optimal readability)

### APPENDIX G: TECHNICAL SUPPORT

**Official Repository:**
https://github.com/[repository-path]

**Issue Reporting:**
Submit bug reports and feature requests via GitHub Issues.

**Documentation Updates:**
This manual maintained in `/manual.md`. Contributions via pull request.

**Community Support:**
Kirby CMS Forum: https://forum.getkirby.com

**Commercial Support:**
For consulting, custom development, or priority support, contact technical team via repository.

---

## REVISION HISTORY

| Version | Date | Changes |
|---------|------|---------|
| 1.0 | October 2025 | Initial release |

---

## LICENSE AND COPYRIGHT

Grimoire Publishing System
Copyright © 2025

Built on Kirby CMS
Copyright © Bastian Allgeier

This documentation may be reproduced and distributed under the terms of the system license.

---

**END OF DOCUMENT**
