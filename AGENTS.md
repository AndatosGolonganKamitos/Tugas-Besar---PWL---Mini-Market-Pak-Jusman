# minimarket — AGENTS.md

## Stack
- Laravel 12, PHP ^8.2, SQLite (default), Vite + Tailwind CSS 4

## Setup
```bash
composer setup                      # full init: install, .env, key, migrate, npm install, npm build
composer dev                        # dev servers: artisan serve, queue:listen, pail logs, Vite HMR
```

## Key commands
| Action | Command |
|---|---|
| Run all tests | `composer test` or `php artisan test` |
| Run single test | `vendor/bin/phpunit tests/Path/To/Test.php` |
| Format code | `vendor/bin/pint` |
| Migrate | `php artisan migrate` |
| Fresh migrate + seed | `php artisan migrate:fresh --seed` |
| List routes | `php artisan route:list` |
| Make model/migration/etc | `php artisan make:model Foo -mf` |

## Testing
- **Unit tests** extend `PHPUnit\Framework\TestCase` (no Laravel boot). **Feature tests** extend `Tests\TestCase` (Laravel boot).
- Feature tests use in-memory SQLite (`phpunit.xml`). Use `RefreshDatabase` trait when tests need DB state; it's commented out in the example.
- `composer test` runs `config:clear` first.
- Tests are in `tests/Unit/` and `tests/Feature/`.

## Database
- Default: SQLite (`database/database.sqlite` for local, `:memory:` for test).
- Migrations: users, cache, jobs tables (in that order). Session, cache, queue all default to `database` driver.
- Seed with `php artisan db:seed` or via migrate:fresh above.

## Code style
- `laravel/pint` (PHP CS Fixer wrapper). Config may be added later; run `vendor/bin/pint` to format.

## Architecture notes
- **PSR-4**: `App\` → `app/`, `Tests\` → `tests/`
- Only route file so far is `routes/web.php` (single `/` → welcome view). No custom controllers yet — base controller at `app/Http/Controllers/Controller.php`.
- Models dir: just `User.php`. Providers dir: just `AppServiceProvider.php`.
- `resources/views/` — Blade templates. `resources/css/`, `resources/js/` — Vite entrypoints.

## Vite
- Entry points: `resources/css/app.css`, `resources/js/app.js`
- Tailwind CSS 4 via `@tailwindcss/vite` plugin (no `tailwind.config.js` needed)
- `npm run build` for production, `npm run dev` for HMR (included in `composer dev`)
