

const btn = document.getElementById('btnbooks')

const imgnone = 'https://via.placeholder.com/150';

const input = document.getElementById('bookseacr')

const loading = document.getElementById('loading');


btn.addEventListener('click', (e)=>{
    document.getElementById("mybooks").innerHTML = ""

    const plegenda = document.getElementById("legenda-busca")
    plegenda.classList.add('d-none');
    e.preventDefault()


    const busca = document.getElementById('bookseacr').value.split(' ').join("+")
    console.log(busca)
    if (busca){
        loading.style.opacity=1;
        loading.classList.remove('d-none')
     pegarLivro(busca)

    }
})

function pegarLivro(busca) {

    const key = 'key=AIzaSyDaW2Xkmf-pjCgJ8I3cXbB_IXba6EzmLxg'
    const url = `https://www.googleapis.com/books/v1/volumes?q=${busca}`


    console.log(url)
    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        success: function(response) {
            console.log(response)
            if (response.totalItems === 0) {
              alert("no result!.. try again")
            }
            else {

                lista(response);
            }
          },
          error: function () {
            alert("Something went wrong.. <br>"+"Try again!");
          }

});



};


    input.addEventListener('focus', (e)=>{
        e.preventDefault()
       // alert('mudando')

    })

function lista(response) {
    loading.style.opacity=0;
    loading.classList.add('d-none')

    const quant = document.getElementById('quantidade').innerHTML = response.items.length
    const pesquisa = document.getElementById("pesquisa").innerHTML = document.getElementById('bookseacr').value
    const plegenda = document.getElementById("legenda-busca")
    if(response.items.length>0){
        plegenda.style.display="block"
        plegenda.classList.remove('d-none')
    }

    $("#bookseacr").val(""); //clearn search box

    input.value.innerHTML=""
    for (var i = 0; i < response.items.length; i++) {

        var item = response.items[i];

        // in production code, item.text should have the HTML entities escaped.
        const bookImg = (item.volumeInfo.imageLinks) ? item.volumeInfo.imageLinks.thumbnail : imgnone ;
        document.getElementById("mybooks").innerHTML +=
       " <a class='booklink col-md-auto' href='/book/"+item.id+"'>"+
        "<div class='card card-books'>"+
        " <img style='width:150px' src='"+
        bookImg+
         "' class='card-img-top img-fluid' alt='...'>"+
            "<div class='card-body body-book'>"+
                "<h5 class='h5book'>"+  item.volumeInfo.title+ "</h5>"+
            "</div>"+
         "</div>"+
         "</a>";

    }


}
