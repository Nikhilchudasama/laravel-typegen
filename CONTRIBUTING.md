# Contributing to Laravel TypeGen

First off, thank you for considering contributing to Laravel TypeGen! It's people like you that make the open-source community such a great place.

## Code of Conduct
Please be respectful and professional in all interactions.

## How Can I Contribute?

### Reporting Bugs
- Use the Bug Report template.
- Provide a clear description and steps to reproduce.

### Suggesting Enhancements
- Open an issue to discuss the enhancement before starting work.

### Pull Requests
1. Fork the repo and create your branch from `main`.
2. If you've added code that should be tested, add tests.
3. If you've changed APIs, update the documentation.
4. Run all validation checks to ensure code quality:
   - **Code Style (Pint)**: `composer lint` (or `composer lint:test` for dry-run)
   - **Static Analysis (PHPStan)**: `composer stan`
   - **Rector Check**: `composer rector` (or `composer rector:fix` to auto-fix)
   - **Test Suite**: `composer test`

## Local Development
```bash
git clone git@github.com:hemilrajput/laravel-typegen.git
cd laravel-typegen
composer install
composer lint
composer stan
composer rector
composer test
```

Happy coding!
