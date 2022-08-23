

const formulario = document.getElementById('fbooks')

const imgnone = 'https://via.placeholder.com/150';

formulario.addEventListener('submit', (e)=>{
    e.preventDefault()
    const busca = document.getElementById('bookseacr').value.split(' ').join("+")
    console.log(busca)
    if (busca){
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

function lista(response) {
    for (var i = 0; i < response.items.length; i++) {

        var item = response.items[i];
        // in production code, item.text should have the HTML entities escaped.
        const bookImg = (item.volumeInfo.imageLinks) ? item.volumeInfo.imageLinks.thumbnail : imgnone ;
        document.getElementById("mybooks").innerHTML +=
        "<div class='card'>"+
        " <img style='width:150px' src='"+
        bookImg+
         "' class='card-img-top img-fluid' alt='...'>"+
            "<div class='card-body'>"+
                "<h5>"+  item.volumeInfo.title+ "</h5>"+
            "</div>"+
         "</div>";

    }
    const quant = document.getElementById('quantidade').innerHTML = response.items.length
    const pesquisa = document.getElementById("pesquisa").innerHTML = document.getElementById('bookseacr').value
}
