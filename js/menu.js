var menu1 = document.getElementById('menuFile');
var menu2 = document.getElementById('menuCartella');
var con_men = false;
var id_temp;
function menuFile(nome, id, event)
{
    var target = event.target || event.srcElement;
    var rect = target.getBoundingClientRect();
    var x = rect.left;
    var y = rect.bottom + window.scrollY;
    if (con_men == false)
    {

        var sposta = document.getElementById('sposta');
        var privatizza = document.getElementById('privatizza');
        var elimina = document.getElementById('elimina');
        var condividi = document.getElementById('condividi');
        var scarica = document.getElementById('scarica');
        if(document.getElementById('togli') != null)
        {
            var togli = document.getElementById('togli');
            togli.href = './menu_file/togli.php?id=' + id;
        }
        sposta.href = './menu_file/spostamento.php?id=' + id;
        privatizza.href = './menu_file/privatizza.php?id=' + id;
        elimina.href = './menu_file/elimina.php?id=' + id;
        condividi.href = './menu_file/condividi.php?id=' + id;
        scarica.href = './files/' + nome;

        menu1.style.display = 'block';
        con_men = true;
        id_temp = id;
        menu1.style.left = x - 150 + 'px';
        menu1.style.top = y + 15 + 'px';

    }
    else 
    {
        if(id == id_temp)
        {
            menu1.style.display = 'none';
            con_men = false;
        }

    }
    
}

function menuCartella(id, event)
{
    var target = event.target || event.srcElement;
    var rect = target.getBoundingClientRect();
    var x = rect.left;
    var y = rect.bottom + window.scrollY;
    var privatizza = document.getElementById('privatizza1');
    var elimina = document.getElementById('elimina1');
    var condividi = document.getElementById('condividi1');

    privatizza.href = './menu_cartelle/privatizza.php?id=' + id;
    elimina.href = './menu_cartelle/elimina.php?id=' + id;
    condividi.href = './menu_cartelle/condividi.php?id=' + id;

    
    if (con_men == false)
    {
        menu2.style.display = 'block';
        con_men = true;
        menu2.style.left = x - 150 + 'px';
        menu2.style.top = y + 10 + 'px';
        id_temp = id;
    }
    else 
    {
        if(id == id_temp)
        {
            menu2.style.display = 'none';
            con_men = false;
        }

    }
}