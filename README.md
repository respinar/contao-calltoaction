# Contao Call to Action Bundle

A lightweight and flexible Call to Action (CTA) bundle for Contao CMS. It allows editors to create reusable, visually appealing call-to-action buttons as **Frontend Modules** directly from the Contao backend.

Perfect for highlighting important links such as contact pages, product pages, downloads, quotations, newsletters, or any other action you want visitors to take.

## Features

- ✅ Native Contao 5 support
- ✅ Available as a **Frontend Module**
- ✅ Uses modern Twig templates
- ✅ Fully compatible with the Contao backend UI
- ✅ Supports internal and external links
- ✅ Configurable button text
- ✅ Optional headline
- ✅ Optional CSS classes for custom styling
- ✅ Accessible HTML output
- ✅ Lightweight with no JavaScript dependencies
- ✅ Easy to customize

## Requirements

- PHP 8.3+
- Contao 5.3+

## Installation

Install the bundle via Composer:

```bash
composer require respinar/contao-calltoaction
```

Then update the database if required.

## Usage

### Frontend Module

1. Create a new frontend module.
2. Select **Call to Action**.
3. Configure the button.
4. Include the module in your page layout or article.

## Customization

The bundle uses Twig templates, making it easy to customize the frontend output.

Override the template in your project just like any other Contao Twig template.

You can also style the button using your own CSS classes.

## Example

```html
<a class="cta-button" href="/contact">
    Contact Us
</a>
```

## Why use this bundle?

Instead of creating CTA buttons manually with HTML or custom templates, editors can manage them directly from the Contao backend while developers retain full control over the frontend design.

This keeps content structured, reusable, and easy to maintain.

## Contributing

Contributions, feature requests, and bug reports are welcome.

Please open an issue or submit a pull request on GitHub.

## License

MIT License

Copyright (c) Hamid Peywasti