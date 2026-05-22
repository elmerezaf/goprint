import urllib.request
import re
import json
import os

UA = 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 MicroMessenger/8.0.42'

def fetch_url(url):
    req = urllib.request.Request(url, headers={'User-Agent': UA})
    resp = urllib.request.urlopen(req, timeout=15)
    return resp.read().decode('utf-8', errors='ignore')

def extract_from_html(html):
    results = {}

    # Find all URLs in HTML
    all_urls = re.findall(r'https?://[^\s"\'<>\\]+', html)
    mp4_urls = [u for u in all_urls if '.mp4' in u.lower()]
    results['mp4_urls'] = list(set(mp4_urls))

    # Look for key patterns
    key_patterns = {
        'specUrl': r'specUrl["\']?\s*[:=]\s*["\']([^"\']+)["\']',
        'coverUrl': r'coverUrl["\']?\s*[:=]\s*["\']([^"\']+)["\']',
        'feedId': r'feedId["\']?\s*[:=]\s*["\']([^"\']+)["\']',
        'nonceId': r'nonceId["\']?\s*[:=]\s*["\']([^"\']+)["\']',
        'objectId': r'objectId["\']?\s*[:=]\s*["\']([^"\']+)["\']',
    }
    for name, pattern in key_patterns.items():
        matches = re.findall(pattern, html, re.IGNORECASE)
        if matches:
            results[name] = list(set(matches))

    return results

def main():
    urls = [
        ('https://weixin.qq.com/sph/APQAtngy4f', 'video1'),
        ('https://weixin.qq.com/sph/Av4QXG9NbL', 'video2'),
    ]

    for url, name in urls:
        print(f'{"="*60}')
        print(f'Processing: {url}')
        print(f'{"="*60}')
        html = fetch_url(url)

        results = extract_from_html(html)
        for k, v in results.items():
            print(f'\n[{k}]:')
            for item in v:
                print(f'  {item}')

        # Save HTML for further analysis
        with open(f'{name}_page.html', 'w', encoding='utf-8') as f:
            f.write(html)
        print(f'\nSaved HTML to {name}_page.html ({len(html)} bytes)')

if __name__ == '__main__':
    main()