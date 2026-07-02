import urllib.request

urls = [
    'https://lydam.store/public/unzip.php',
    'http://lydam.store/public/unzip.php',
    'https://lydam.store/unzip.php'
]

for url in urls:
    print(f"\nRequesting: {url}...")
    try:
        req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
        with urllib.request.urlopen(req, timeout=10) as response:
            print("Status:", response.status)
            print("Headers:", response.info())
            body = response.read(500)
            print("Body:", body.decode('utf-8', errors='ignore'))
    except Exception as e:
        print("Failed:", e)
        if hasattr(e, 'read'):
            print("Error body:", e.read(500).decode('utf-8', errors='ignore'))
