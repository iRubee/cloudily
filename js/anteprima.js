function anteprima(percorsi)
{
    window.open('./files/' + percorsi, '_blank');
}
function anteprimaCartella(percorsi)
{
    window.location.href = './anteprimaCartella.php?id=' + percorsi;
}