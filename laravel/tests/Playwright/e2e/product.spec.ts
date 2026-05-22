import { test, expect } from '@playwright/test';

test.describe('GoPrint Product Tests', () => {
  test('homepage loads correctly', async ({ page }) => {
    await page.goto('/');
    await expect(page).toHaveTitle(/GoPrint/);
    await expect(page.getByRole('heading', { name: /GoPrint/ })).toBeVisible();
  });

  test('can navigate to products page', async ({ page }) => {
    await page.goto('/');
    await page.getByRole('link', { name: /Products|產品|products/i }).click();
    await expect(page).toHaveURL(/.*products/);
  });

  test('can view products list', async ({ page }) => {
    await page.goto('/products');
    await expect(page.getByText('Products')).toBeVisible();
  });

  test('can navigate to about page', async ({ page }) => {
    await page.goto('/');
    await page.getByRole('link', { name: /About|關於|about/i }).click();
    await expect(page).toHaveURL(/.*about/);
  });

  test('can navigate to contact page', async ({ page }) => {
    await page.goto('/');
    await page.getByRole('link', { name: /Contact|聯絡|contact/i }).click();
    await expect(page).toHaveURL(/.*contact/);
  });

  test('can navigate to cart page', async ({ page }) => {
    await page.goto('/');
    await page.getByRole('link', { name: /Cart|購物車|cart/i }).click();
    await expect(page).toHaveURL(/.*cart/);
  });

  test('can navigate to login page', async ({ page }) => {
    await page.goto('/');
    await page.getByRole('link', { name: /Login|登入|login/i }).click();
    await expect(page).toHaveURL(/.*login/);
  });

  test('can navigate to register page', async ({ page }) => {
    await page.goto('/');
    await page.getByRole('link', { name: /Register|註冊|register/i }).click();
    await expect(page).toHaveURL(/.*register/);
  });

  test('can navigate to designer page', async ({ page }) => {
    await page.goto('/');
    await page.getByRole('link', { name: /Design|設計|designer/i }).click();
    await expect(page).toHaveURL(/.*designer/);
  });
});
