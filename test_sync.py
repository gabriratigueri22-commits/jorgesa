import urllib.request
import urllib.error
import base64
import json

CLIENT_ID = "3ba8c2e7-4421-4ecc-9b1b-4d40f5c33036"
CLIENT_SECRET = "e5383090-b742-4580-87fb-50efcbe5425e"

endpoints = [
    "https://api.syncpayments.com.br/v1/transaction/pix",
    "https://api.syncpayments.com.br/v1/transactions",
    "https://api.syncpayments.com.br/api/v1/pix",
    "https://api.syncpayments.com.br/oauth/token"
]

auth_str = f"{CLIENT_ID}:{CLIENT_SECRET}"
encoded = base64.b64encode(auth_str.encode()).decode()

data = json.dumps({"amount": 6947, "payment_method": "pix", "cpf": "11122233344", "name": "Teste"}).encode()

for url in endpoints:
    print(f"Testing {url}")
    req = urllib.request.Request(url, data=data, method="POST")
    req.add_header("Content-Type", "application/json")
    req.add_header("Authorization", f"Basic {encoded}")
    
    try:
        response = urllib.request.urlopen(req)
        print(response.getcode(), response.read().decode())
    except urllib.error.HTTPError as e:
        print(e.code, e.read().decode())
    except Exception as e:
        print("Error:", str(e))
    print("-" * 20)
