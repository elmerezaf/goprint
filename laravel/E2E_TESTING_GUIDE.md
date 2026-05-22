# GoPrint E2E Testing Guide

## Installation

### For Laravel Application

1. Install Playwright dependencies:

```bash
cd laravel
npm install -D @playwright/test
```

2. Install Playwright browsers:

```bash
npx playwright install
```

### For Next.js Application

```bash
cd laravel/nextjs
npm install -D @playwright/test
npx playwright install
```

## Running Tests

### Laravel Tests

```bash
cd laravel

# Run all tests
npx playwright test

# Run specific test file
npx playwright test product.spec.ts

# Run tests in headed mode
npx playwright test --headed

# Run tests with UI mode
npx playwright test --ui

# Show test report
npx playwright show-report
```

**Note:** Make sure your Laravel development server is running:

```bash
php artisan serve
```

### Next.js Tests

```bash
cd laravel/nextjs

# Run all tests
npx playwright test

# Run specific test file
npx playwright test home.spec.ts

# Run tests in headed mode
npx playwright test --headed

# Run tests with UI mode
npx playwright test --ui

# Show test report
npx playwright show-report
```

**Note:** Make sure your Next.js development server is running:

```bash
npm run dev
```

## Test Structure

### Laravel Tests (`tests/Playwright/e2e/`)

- `product.spec.ts` - Product and navigation tests
- `auth.spec.ts` - Authentication tests

### Next.js Tests (`nextjs/tests/e2e/`)

- `home.spec.ts` - Homepage and basic navigation tests

## Adding New Tests

Create new test files in the respective `e2e` directories with `.spec.ts` suffix.

Example test structure:

```typescript
import { test, expect } from '@playwright/test';

test.describe('Feature Tests', () => {
  test('test description', async ({ page }) => {
    await page.goto('/page');
    await expect(page.getByText('Expected text')).toBeVisible();
  });
});
```

## CI/CD Integration

For GitHub Actions, create `.github/workflows/playwright.yml`:

```yaml
name: Playwright Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with:
          node-version: 20
      - run: npm ci
      - run: npx playwright install --with-deps
      - run: php artisan serve &
      - run: npx playwright test
```
