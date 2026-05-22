import re

with open(r'c:\xampp\htdocs\goprint\video1_page.html', 'r', encoding='utf-8') as f:
    html = f.read()

# Look for API endpoint patterns - search for strings in JS code
api_patterns = [
    r'"([a-z]+Finder[A-Z][a-zA-Z]+)"',
    r"'([a-z]+Finder[A-Z][a-zA-Z]+)'",
    r'"/(web/finder/[^"]+)"',
    r"'/(web/finder/[^']+)'",
    r'"(finder[a-z_]+)"',
    r"'(finder[a-z_]+)'",
    r'"([a-z]+/[a-z]+/[a-z_]+)"',
    r"'([a-z]+/[a-z]+/[a-z_]+)'",
]

for p in api_patterns:
    matches = re.findall(p, html)
    if matches:
        uniq = list(set(matches))
        print(f'\nPattern: {p}')
        for m in sorted(uniq)[:30]:
            print(f'  {m}')

# Search for method/function names related to API
method_pattern = r'(?:methods\.|WXU\.API\d*\.)([a-zA-Z_]+)'
methods = re.findall(method_pattern, html)
if methods:
    print(f'\nAPI Methods:')
    for m in sorted(set(methods)):
        print(f'  {m}')