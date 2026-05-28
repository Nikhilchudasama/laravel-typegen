# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.4.0] - 2026-05-28

### Added
- **Route types generation**: New `typescript:routes` command to generate Ziggy-compatible typescript type mappings for named routes.
- **Watch mode**: Added `--watch` flag to `typescript:generate` utilizing a lightweight polling loop.
- **File splitting**: Configurable file splitting (`output.split`) to generate individual files for each type with auto-resolved relative imports and barrel `index.ts`.
- **Custom cast support**: Automatic mapping of custom Eloquent cast classes registered in config overrides.

## [0.3.0] - 2026-05-15

### Added
- Eloquent relationship support: opt in per-model via `#[TypeScript(includeRelations: [...])]`
- Auto-discovery of related models — referenced models are generated automatically
- Polymorphic `MorphTo` support via Laravel's morph map

## [0.2.0] - 2026-05-15

### Added
- **Enum Support**: `#[TypeScript]` on backed or pure enums generates TypeScript union types.
- **FormRequest Support**: `rules()` method auto-generates request DTO interfaces.
- **Enum-Cast Integration**: Models referencing enums via `$casts` produce typed references automatically.
- **Professional Setup**: Added Laravel Pint and Larastan for code quality.

## [0.1.0] - 2026-05-15

### Added
- Initial release with Eloquent model generation.
- `#[TypeScript]` attribute for opting into generation.
- Artisan `typescript:generate` command.
