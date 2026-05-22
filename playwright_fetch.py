from playwright.sync_api import sync_playwright
import json
import os

DESKTOP = os.path.join(os.environ['USERPROFILE'], 'Desktop')
UA = 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 MicroMessenger/8.0.42'

video_ids = ['APQAtngy4f', 'Av4QXG9NbL']

all_requests = []

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(
        user_agent=UA,
        viewport={'width': 390, 'height': 844},
    )
    page = context.new_page()

    # Capture all network requests
    def log_request(request):
        url = request.url
        if any(k in url for k in ['mp4', 'video', 'finder', 'feed', 'cgi-bin', 'api']):
            all_requests.append({
                'type': 'request',
                'url': url,
                'method': request.method,
                'headers': dict(request.headers),
            })
            print(f'[REQ] {request.method} {url}')

    def log_response(response):
        url = response.url
        if any(k in url for k in ['mp4', 'video', 'finder', 'feed', 'cgi-bin', 'api']):
            try:
                body = response.text()
                all_requests.append({
                    'type': 'response',
                    'url': url,
                    'status': response.status,
                    'body_len': len(body),
                    'body_preview': body[:2000],
                })
                print(f'[RESP] {response.status} {url} ({len(body)} bytes)')
            except:
                pass

    page.on('request', log_request)
    page.on('response', log_response)

    for vid in video_ids:
        url = f'https://channels.weixin.qq.com/finder-preview/pages/sph?id={vid}'
        print(f'\n{"="*60}')
        print(f'Loading: {url}')
        print(f'{"="*60}')

        page.goto(url, wait_until='networkidle', timeout=30000)
        page.wait_for_timeout(5000)

        # Check page content
        title = page.title()
        print(f'Page title: {title}')

        # Try to extract any video elements
        video_srcs = page.evaluate('''() => {
            const videos = document.querySelectorAll('video');
            return Array.from(videos).map(v => ({src: v.src, currentSrc: v.currentSrc}));
        }''')
        print(f'Video elements: {video_srcs}')

        # Check for any data in the page
        body_text = page.evaluate('() => document.body.innerText')
        print(f'Body text (first 500): {body_text[:500]}')

        # Screenshot
        page.screenshot(path=os.path.join(DESKTOP, f'channels_{vid}.png'))
        print(f'Screenshot saved to desktop: channels_{vid}.png')

    browser.close()

# Save all captured requests
with open(os.path.join(DESKTOP, 'channels_requests.json'), 'w', encoding='utf-8') as f:
    json.dump(all_requests, f, indent=2, ensure_ascii=False)
print(f'\nSaved {len(all_requests)} requests to channels_requests.json')