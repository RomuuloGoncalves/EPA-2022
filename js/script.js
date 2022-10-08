storageFunctions = {
        guardarLed: (valor) => localStorage.setItem("led", JSON.stringify(valor)),
        pegarLed: () => JSON.parse(localStorage.getItem("led"))
}

function controlarLeds(valor){
        storageFunctions.guardarLed(valor)
        window.location.href = "./conexao.html"
}


let json = {
        "error": false,
        "category": "Programming",
        "type": "single",
        "joke": "A guy walks into a bar and asks for 1.4 root beers.\nThe bartender says \"I'll have to charge you extra, that's a root beer float\".\nThe guy says \"In that case, better make it a double.\"",
        "flags": {
            "nsfw": false,
            "religious": false,
            "political": false,
            "racist": false,
            "sexist": false,
            "explicit": false
        },
        "id": 2,
        "safe": true,
        "lang": "en"
}