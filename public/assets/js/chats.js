
    const btnchats = document.querySelector("#btn-chats")
    const chatsmodal = document.querySelector('#modal-chats')
    const chatsBody = document.querySelector('.chats-body')
    const btnMax = document.querySelector('#btn-maxmize')
    const btnMin = document.querySelector('#btn-minimize')

function esconder(){
    chatsmodal.classList.remove('show')
    chatsmodal.classList.add('hide')

}

function mostrar(){
    chatsmodal.classList.remove('hide')
    chatsmodal.classList.add('show')



}

function maxmize(){
    chatsBody.style.display = "block"
    chatsBody.classList.remove('d-none')
    btnMax.classList.add('d-none')
    btnMin.classList.remove('d-none')



}

function minimize(){

    chatsBody.style.display = "none"
    chatsBody.classList.add('d-none')
    btnMax.classList.remove('d-none')
    btnMin.classList.add('d-none')


}

    btnchats.addEventListener('click', (e)=>{
        e.preventDefault();


        if (chatsmodal.classList.contains("show")){
            esconder()

        }else if(chatsmodal.classList.contains("hide")){
            maxmize()
            mostrar()

        }

    })
