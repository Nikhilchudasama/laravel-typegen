# Laravel TypeGen

> **Laravel TypeGen** — one artisan command turns your Eloquent models, Enums, and FormRequests into a single typed `.ts` file. No more hand-syncing PHP and TypeScript.

## Why Laravel TypeGen?
- **Keeps types in sync**: Automatically reflect changes in your PHP models in your TypeScript interfaces.
Generate TypeScript types from Eloquent models, Enums, and FormRequests. Built for the Laravel 13 + Inertia + React/Vue stack.

---

## ⚡️ The Killer Feature: Synchronized Types
Laravel TypeGen doesn't just generate standalone interfaces. It understands your application's logic.

**PHP Enum + Model Cast:**
```php
enum UserRole: string {
    case Admin = 'admin';
}

class User extends Model {
    protected $casts = ['role' => UserRole::class];
}
```

**TypeScript Output:**
```ts
export type UserRole = 'admin';

export interface User {
    id: number;
    role: UserRole; // Automatically linked!
}
```

---

## 🚀 Features
- **Eloquent Models**: Generates interfaces from `$fillable`, `$casts`, and timestamps.
- **Enums**: Generates union types from backed and pure PHP enums.
- **FormRequests**: Generates request DTOs from your `rules()` method.
- **Attribute-Driven**: Opt-in to generation using the `#[TypeScript]` attribute.
- **Zero-Config**: Smart defaults for standard Laravel projects.

## 📊 Comparison

| Feature | TypeGen | Spatie TS Transformer |
|---|:---:|:---:|
| Eloquent Support | ✅ | ✅ |
| Enum Support | ✅ | ✅ |
| **FormRequest → DTO** | ✅ | ❌ |
| **Linked Enum Casts** | ✅ | ⚠️ (Manual) |
| Attribute Driven | ✅ | ✅ |
| Inertia Native | ✅ | ⚠️ |

---

## 📦 Installation
```bash
composer require hemil09/laravel-typegen
```

## 🛠 Usage

### 1. Tag your classes
```php
use Hemil09\TypeGen\Attributes\TypeScript;

#[TypeScript]
class User extends Model { ... }
```

### 2. Generate
```bash
php artisan typescript:generate
```

---

## 🗺 Roadmap
- [x] Enum support (v0.2)
- [x] FormRequest → DTO (v0.2)
- [ ] Eloquent relationships (v0.3)
- [ ] Route parameter types (v0.3)
- [ ] Watch mode (v0.3)


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
