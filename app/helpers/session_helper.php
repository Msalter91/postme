<?php
    session_start();

function isLoggedIn(){
    if(isset($_SESSION['user_id'])){
        return True;
    } else {
        return False;
    }
}

function flash($flash = '', $message = '', $class = 'alert alert-success') {
    //Checks to see if a flash and message have been entered but the flash not yet addded to the session
    //If that's the case, it then sets a value in the Session super global called Flash.
    if (!empty($flash) and !empty($message) and empty($_SESSION[$flash])) {

        $_SESSION[$flash] = $message;
        $_SESSION[$flash . '_class'] = $class;
    } elseif (empty($message) and !empty($_SESSION[$flash])) {
        // When this function is then called on the view - the SESSION persists
        // This then allows us to pass a simple message which gets displayed on the view.
        // The values are then unset so that refreshing the page will not cause the message to fire again

        $class = !empty($_SESSION[$flash . '_class']) ? $_SESSION[$flash . '_class'] : '';
        echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$flash] . '</div>';
        unset($_SESSION[$flash]);
        unset($_SESSION[$flash . '_class']);
    }

}