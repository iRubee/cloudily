var bottoneEspansione = document.getElementById('espansione');
var espanso = false;
bottoneEspansione.addEventListener('click', function() {
    var aside = document.querySelector('aside');
    if(!espanso)
    {
        aside.style.width = '90%';
        bottoneEspansione.style.rotate = '-90deg';
        espanso = true;
    }
    else
    {
        
        aside.style.width = '50px';
        bottoneEspansione.style.rotate = '90deg';
        espanso = false;
    }

});

function attiva(numero)
{
    var linkAttivato = document.querySelector('.active');
    console.log(linkAttivato);
    linkAttivato.classList.remove('active');
    document.querySelector('.disactive'+ numero).classList.add('active');
}