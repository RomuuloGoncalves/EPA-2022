let storageFunctions = {
    guardarLed: (valor) => localStorage.setItem("led", JSON.stringify(valor)),
    pegarLed: () => JSON.parse(localStorage.getItem("led")),
};

function controlarLeds(valor) {
    storageFunctions.guardarLed(valor);
    window.location.href = "./conexao.html";
}