function abrirModal (id) {
    document.getElementById(id).classList.remove("apagar")
    colocarBlur();
}

function fecharModal(id){
    document.getElementById(id).classList.add("apagar")
    apagarBlur();
}

function colocarBlur () {
    document.querySelectorAll(".page")[0].classList.remove("remover");
    document.querySelectorAll(".page")[1].classList.remove("remover");
}

function apagarBlur(){
    document.querySelectorAll(".page")[0].classList.add("remover");
    document.querySelectorAll(".page")[1].classList.add("remover");
}

function toggleModal(id){
    modal = document.getElementById(id);
    modal.classList.toggle("desativar");
}