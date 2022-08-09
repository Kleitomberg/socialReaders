
    const btnchats = document.querySelector("#btn-chats")
    const chatsmodal = document.querySelector('#modal-chats')

function esconder(){
    chatsmodal.classList.remove('show')
    chatsmodal.classList.add('hide')

}

function mostrar(){
    chatsmodal.classList.remove('hide')
    chatsmodal.classList.add('show')

}

    btnchats.addEventListener('click', (e)=>{
        e.preventDefault();


        if (chatsmodal.classList.contains("show")){
            esconder()

        }else if(chatsmodal.classList.contains("hide")){
            mostrar()

        }

    })
