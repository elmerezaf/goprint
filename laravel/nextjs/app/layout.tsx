import type { Metadata } from 'next';
import { Inter } from '@next/font/google';

const inter = Inter({ subsets: ['latin'] });

export const metadata: Metadata = {
  title: 'GoPrint - Professional Printing Services in Hong Kong',
  description: 'High-quality printing services including business cards, flyers, posters, banners and more. Fast delivery across Hong Kong.',
  keywords: 'printing, Hong Kong, business cards, flyers, posters, banners, professional printing',
  authors: [{ name: 'Elmer So' }],
  creator: 'Elmer So',
  publisher: 'GoPrint',
  formatDetection: {
    email: true,
    address: true,
    telephone: true,
  },
  openGraph: {
    title: 'GoPrint - Professional Printing Services',
    description: 'High-quality printing services in Hong Kong',
    type: 'website',
    locale: 'zh_HK',
    siteName: 'GoPrint',
  },
  twitter: {
    card: 'summary_large_image',
    title: 'GoPrint - Professional Printing Services',
    description: 'High-quality printing services in Hong Kong',
  },
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="zh-HK">
      <body className={inter.className}>{children}</body>
    </html>
  );
}
