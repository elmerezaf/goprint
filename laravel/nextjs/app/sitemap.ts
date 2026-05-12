import { MetadataRoute } from 'next';

export default function sitemap(): MetadataRoute.Sitemap {
  return [
    {
      url: 'https://goprint.com.hk',
      lastModified: new Date(),
      priority: 1.0,
      changeFrequency: 'weekly',
    },
    {
      url: 'https://goprint.com.hk/products',
      lastModified: new Date(),
      priority: 0.9,
      changeFrequency: 'daily',
    },
    {
      url: 'https://goprint.com.hk/about',
      lastModified: new Date(),
      priority: 0.8,
      changeFrequency: 'monthly',
    },
    {
      url: 'https://goprint.com.hk/contact',
      lastModified: new Date(),
      priority: 0.8,
      changeFrequency: 'monthly',
    },
    {
      url: 'https://goprint.com.hk/designer',
      lastModified: new Date(),
      priority: 0.7,
      changeFrequency: 'weekly',
    },
  ];
}
