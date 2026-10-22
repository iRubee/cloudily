var add_button = document.getElementById('add');
var note_button = document.getElementById('note');
var folder_button = document.getElementById('folder');
var aperto = false;
add_button.addEventListener('click', function() {
    if(!aperto) {
        
        note_button.style.marginRight = '70px'
        folder_button.style.marginBottom = '70px'; 
        
        aperto = true;
    } else {

        note_button.style.marginRight = '0px'
        folder_button.style.marginBottom = '0px';
        
        aperto = false;
    }
});

note_button.addEventListener('click', function()
{
    window.location.href = 'aggiungi.php?from=0';
})
folder_button.addEventListener('click', function()
{
    window.location.href = 'aggiungi.php?from=1';
})