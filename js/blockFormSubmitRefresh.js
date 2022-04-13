// Permet de bloquer le renvoie des formulaires lors du rafraîchissement
//    de la page par l'utilisateur.

if ( window.history.replaceState )
{
    window.history.replaceState( null, null, window.location.href );
}
