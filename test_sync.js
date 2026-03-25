async function test() {
    const CLIENT_ID = "3ba8c2e7-4421-4ecc-9b1b-4d40f5c33036";
    const CLIENT_SECRET = "e5383090-b742-4580-87fb-50efcbe5425e";
    const authString = Buffer.from(CLIENT_ID + ':' + CLIENT_SECRET).toString('base64');
    
    console.log("Testing POST /api/v1/pix");
    try {
        const res = await fetch("https://api.syncpayments.com.br/api/v1/pix", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Basic ${authString}`
            },
            body: JSON.stringify({ amount: 6947, cpf: "11122233344", nome: "Teste" })
        });
        const text = await res.text();
        console.log(res.status, res.statusText);
        console.log(text);
    } catch(e) { console.error(e); }
}
test();
