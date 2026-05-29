# Laravel TypeGen — VS Code Extension

Automatically runs `php artisan typescript:generate` whenever you save a PHP file containing the `#[TypeScript]` attribute.

## Features

- **Auto-generate on save** — detects `#[TypeScript]` in saved `.php` files and triggers generation instantly.
- **Status bar indicator** — shows live status (`$(zap) TypeGen`) with a click-to-toggle button.
- **Manual trigger** — run via Command Palette: `Laravel TypeGen: Generate Types Now`.
- **Toggle on/off** — `Laravel TypeGen: Toggle Auto-Generate on Save` or click the status bar item.
- **Output channel** — all artisan output streamed to the `Laravel TypeGen` output panel.

## Requirements

- A Laravel project with `artisan` in the workspace root.
- `php` on PATH (or configure `laravelTypegen.phpPath`).
- `hemilrajput/laravel-typegen` `^2.0` installed in the Laravel project.

## Configuration

| Setting | Default | Description |
|---|---|---|
| `laravelTypegen.phpPath` | `"php"` | Path to PHP executable |
| `laravelTypegen.artisanCommand` | `"typescript:generate"` | Artisan command to run |
| `laravelTypegen.enableOnSave` | `true` | Auto-run on save |
| `laravelTypegen.showOutputChannel` | `false` | Auto-show output panel |

## Development

```bash
cd vscode-extension
npm install
npm run compile
# Press F5 in VS Code to launch Extension Development Host
```

## Publishing

```bash
npm install -g @vscode/vsce
vsce package
vsce publish
```
