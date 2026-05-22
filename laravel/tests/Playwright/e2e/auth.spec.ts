import { test, expect } from '@playwright/test';

test.describe('GoPrint Authentication Tests', () => {
  test('login page loads correctly', async ({ page }) => {
    await page.goto('/login');
    await expect(page.getByRole('heading', { name: /Log in|登入/i })).toBeVisible();
    await expect(page.getByLabel(/Email|電郵/i)).toBeVisible();
    await expect(page.getByLabel(/Password|密碼/i)).toBeVisible();
  });

  test('register page loads correctly', async ({ page }) => {
    await page.goto('/register');
    await expect(page.getByRole('heading', { name: /Register|註冊/i })).toBeVisible();
    await expect(page.getByLabel(/Name|姓名/i)).toBeVisible();
    await expect(page.getByLabel(/Email|電郵/i)).toBeVisible();
    await expect(page.getByLabel(/Password|密碼/i, { exact: false })).toHaveCount(2);
  });

  test('shows validation errors on empty login form', async ({ page }) => {
    await page.goto('/login');
    await page.getByRole('button', { name: /Log in|登入/i }).click();
    await expect(page.getByText(/required|必填/i)).toBeVisible();
  });

  test('shows validation errors on empty register form', async ({ page }) => {
    await page.goto('/register');
    await page.getByRole('button', { name: /Register|註冊/i }).click();
    await expect(page.getByText(/required|必填/i)).toBeVisible();
  });
});
