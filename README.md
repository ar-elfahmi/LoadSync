<p align="center">
  <span style="display:inline-flex;align-items:center;gap:14px;">
    <img src="public/image/brand%20logo.svg" alt="LoadSync brand logo" width="140">
    <span style="font-size:2rem;font-weight:700;line-height:1;">LoadSync</span>
  </span>
</p>

# LoadSync

> LoadSync is a Laravel dashboard for monitoring operations and managing machines from a clean, operator-focused interface.

## What You Get

- Dashboard landing page
- Machine management screen
- Laravel routing and testing scaffold
- Vite + Tailwind asset pipeline
- Seeded user for local development

## Screens

- `/` - welcome page
- `/dashboard` - main dashboard
- `/machines` - machine management

## Stack

- Laravel 13
- Blade views
- Vite
- Tailwind CSS 4
- PHPUnit

## Local Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## Run It

```bash
php artisan serve
npm run dev
```

Open `http://127.0.0.1:8000` in your browser.

## Useful Commands

```bash
php artisan test
npm run build
```

## Project Layout

```text
app/
database/
resources/views/
resources/css/
resources/js/
routes/
tests/
```

## Notes

- The app currently ships as a UI-first scaffold.
- `database/seeders/DatabaseSeeder.php` creates a test user for local use.
- `routes/web.php` wires the public pages together.

## License

MIT
