var working = false;
$('#form').on('submit', function(e) {
    e.preventDefault();
    if (working) return;
    working = true;
    var $this = $(this),
    $state = $this.find('button > .state');
    $this.addClass('loading');
    $state.html('Autentificando');
    setTimeout(function() {
        $this.addClass('ok');
        $state.html('Bienvenido de vuelta!');
        setTimeout(function() {
            $state.html('Log in');
            $this.removeClass('ok loading');
            working = false;
        }, 2000);
    }, 1000);
    // window.location="http://localhost/practica3_final/sesiones/checklogin.php";;
});