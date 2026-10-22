var iframe = document.getElementById('iframe');
var searchbar = document.getElementById('cerca');
var searchbutton = document.getElementById('search-button');
var searchbar1 = document.getElementById('cerca1');
var searchbutton1 = document.getElementById('search-button1');

searchbutton.addEventListener('click', function() 
{
    iframe.src = './ricerca.php?search=' + encodeURIComponent(searchbar.value);
});

searchbutton1.addEventListener('click', function() 
{
    iframe.src = './ricerca.php?search=' + encodeURIComponent(searchbar1.value);
})