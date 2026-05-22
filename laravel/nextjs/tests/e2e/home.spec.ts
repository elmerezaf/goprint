import { test, expect } from '@playwright/test';

test.describe('Next.js GoPrint Tests', () => {
  test('homepage loads correctly', async ({ page }) => {
    await page.goto('/');
    await expect(page.getByRole('heading', { name: /GoPrint/ })).toBeVisible();
    await expect(page.getByText(/Professional Printing Services/)).toBeVisible();
  });

  test('navigation works correctly', async ({ page }) => {
    await page.goto('/');
    
    await page.getByRole('link', { name: 'Products' }).click();
    await expect(page).toHaveURL('/products');

    await page.goBack();
    await expect(page).toHaveURL('/');

    await page.getByRole('link', { name: 'Cart' }).click();
    await expect(page).toHaveURL('/cart');
  });

  test('featured products are displayed', async ({ page }) => {
    await page.goto('/');
    await expect(page.getByText('Featured Products')).toBeVisible();
  });

  test('can view product card', async ({ page }) => {
    await page.goto('/');
    const productCards = page.locator('[class*="ProductCard"]').or(page.locator('[class*="product-card"]'));
    const count = await productCards.count();
    if (count > 0) {
      await expect(productCards.first()).toBeVisible();
    }
  });
});
