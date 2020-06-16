<script>
        $(function() {
            //control display of goTop button and motion
            $("#gotop").click(function() {
                jQuery("html,body").animate({
                    scrollTop: 0
                }, 1000);
            });
            $(window).scroll(function() {
                if ($(this).scrollTop() > 150) {
                    $('#gotop').fadeIn("fast");
                } else {
                    $('#gotop').stop().fadeOut("fast");
                }
            });
        });
</script>
<button id="gotop"></button>