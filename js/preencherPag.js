let imagens = ['./img/lampada_ligada.png', './img/lampada_desligada.png']
function preencherLampadas(valor, index){
    console.log(index)

    let imagem = valor.estado == 1 ? imagens[0] : imagens[1]

    containerLampadas.innerHTML += `
        <div class="card card__lampada">
            <img src=${imagem} alt="" />
            <p>${valor.nome}</p>
        </div>
    `
}

function preencherGrupos(valor, index){
    let imagem = valor.estado == 1 ? imagens[0] : imagens[1]
    
    containerGrupos.innerHTML += `
        <div class="card card__grupo">
        <img src=${imagem} alt="" />
        <label for="checkbox-${index}" class="switch">
            <input type="checkbox" id="checkbox-${index}">
            <span class="slider"></span>
        </label>
        <div class="page__titulo">
            <p>${valor.nome}</p>
            <a href="#">
                <ion-icon name="information-circle-outline"></ion-icon>
            </a>
        </div>
    </div>
    `
}