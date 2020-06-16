<script> 
function closecommentbtn() {
    var commentdiv = document.getElementById('commentdiv');
    var drinkdiv=document.getElementById('commentdiv2');
    if (commentdiv.style.display === 'inline-block') {
        $('#commentdiv').fadeOut();
    }
    if (drinkdiv.style.display === 'inline-block') {
        $('#commentdiv2').fadeOut();
    }
}

function nextbtn(){
    var commentdiv=document.getElementById('commentdiv');
    var drinkdiv=document.getElementById('commentdiv2');
    $('#commentdiv').fadeOut();
    $('#commentdiv2').fadeIn();
    drinkdiv.style.display='inline-block';
}
</script>