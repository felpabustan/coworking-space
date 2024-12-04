# Custom Themed WordPress Website for Co-Working Space

Welcome to the repository for the custom-themed WordPress website designed specifically for a modern co-working space. This theme leverages **Tailwind CSS**, **jQuery**, **JavaScript**, and **PHP** to deliver a dynamic and user-friendly experience.

## Features
- **Custom Design**: Fully responsive design tailored for a co-working space.
- **Tailwind CSS Integration**: Ensures modern, utility-first styling.
- **Interactive UI**: Enhanced with jQuery and vanilla JavaScript.
- **Dynamic WordPress Features**: Custom post types, widgets, and shortcodes.
- **Optimized Performance**: Fast load times and optimized assets.

## Technologies Used
- **WordPress**: CMS backbone.
- **Tailwind CSS**: For styling and layout.
- **JavaScript & jQuery**: For interactive elements.
- **PHP**: For theme development and backend functionality.

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/felpabustan/coworking-space.git
   ```
2. Upload the theme folder to your WordPress installation:
   - Navigate to `/wp-content/themes/`.
   - Place the theme folder here.

3. Activate the theme:
   - Log in to the WordPress admin panel.
   - Go to **Appearance > Themes**.
   - Activate the custom theme.

4. Install Required Plugins:
   - Ensure any required plugins (e.g., ACF, Contact Form 7) are installed and activated.

## Folder Structure
```plaintext
custom-theme/
├── assets/             # CSS, JS, images, and other static assets
│   ├── css/            # Compiled Tailwind CSS files
│   ├── js/             # Custom JavaScript and jQuery scripts
│   └── images/         # Theme images
├── template-parts/     # Reusable template parts (headers, footers, etc.)
├── functions.php       # Theme setup and custom functions
├── style.css           # Theme stylesheet header for WordPress
├── index.php           # Main template file
├── page-templates/     # Custom page templates
└── README.md           # Project documentation
```

## Development
### Prerequisites
- Node.js and npm installed.
- WordPress development environment (e.g., Local by Flywheel, XAMPP).

### Setup Tailwind CSS
1. Install dependencies:
   ```bash
   npm install
   ```
2. Build CSS:
   ```bash
   npm run build
   ```

### Customizing JavaScript
- Modify JavaScript files in the `assets/js/` directory.
- Use `jQuery` for compatibility with WordPress.

### PHP Functions
- Use `functions.php` for registering menus, widgets, and theme setup.
- Add custom hooks and filters as needed.

## Contributing
Contributions are welcome! Please follow these steps:
1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature-name`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/your-feature-name`).
5. Open a pull request.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact
For questions or support, feel free to contact:
- **Email**: felpabustan93@gmail.com

---

Happy coding! 🎉
