const containerLampadas = document.getElementById("lampadas")
const containerGrupos = document.getElementById("grupos")

let arrayLampadas = [
    {
        nome: "luz-1",
        estado: 1
    },

    {
        nome: "luz-2",
        estado: 0
    },   
    
    {
        nome: "luz-3",
        estado: 1
    },
    
    {
        nome: "luz-4",
        estado: 0
    },

    {
        nome: "luz-5",
        estado: 0
    },
]

let arrayGrupos = [
    {
        nome: "Sala",
        estado: 1,
        lampadas: [],
    },

    {
        nome: "Cozinha",
        estado: 0,
        lampadas: [],
    },

    {
        nome: "Varanda",
        estado: 1,
        lampadas: [],
    },
]

function atualizarConteudoPagina(){
    containerLampadas.innerHTML = ""
    arrayLampadas.forEach(preencherLampadas)

    containerGrupos.innerHTML = ""
    arrayGrupos.forEach(preencherGrupos)
}

// Testes pra enviar informações pro arduíno né pae
let storageFunctions = {
    guardarLed: (valor) => localStorage.setItem("led", JSON.stringify(valor)),
    pegarLed: () => JSON.parse(localStorage.getItem("led")),
};

function controlarLeds(valor) {
    storageFunctions.guardarLed(valor);
    window.location.href = "./conexao.html";
}

atualizarConteudoPagina()