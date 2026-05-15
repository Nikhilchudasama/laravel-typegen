# Laravel TypeGen

> **Laravel TypeGen** — one artisan command turns your Eloquent models, Enums, and FormRequests into a single typed `.ts` file. No more hand-syncing PHP and TypeScript.

## Why Laravel TypeGen?
- **Keeps types in sync**: Automatically reflect changes in your PHP models in your TypeScript interfaces.
- **Zero hand-syncing**: Stop manually writing TypeScript types that mirror your Laravel models.
- **Works with Inertia**: Perfect for Laravel + Inertia + React/Vue stacks.

## Installation

```bash
composer require hemil09/laravel-typegen
```

Publish the config file:

```bash
php artisan vendor:publish --tag=typegen-config
```

## Quick Start

1. Add the `#[TypeScript]` attribute to your Eloquent model:

```php
use Hemil09\TypeGen\Attributes\TypeScript;

#[TypeScript]
class User extends Authenticatable { /* ... */ }
```

2. Run the generate command:

```bash
php artisan typescript:generate
```

3. Import the generated types in your frontend code:

```ts
import { User } from './types/generated';
```

## Configuration

See `config/typegen.php` for all available options, including:
- Output path and style (interface vs type).
- Custom cast mapping.
- Prefix/suffix for generated names.
- Including/excluding timestamps and hidden fields.

## Roadmap
- [ ] Enum support (v0.2)
- [ ] FormRequest -> request DTO (v0.2)
- [ ] Relationship support
- [ ] Route params (Ziggy compatibility)

## License
MIT
