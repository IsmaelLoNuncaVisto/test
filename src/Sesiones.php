<?php

namespace src;

class Session{

    public static function startSession(){
        session_start();
    }

    //SESION NORMAL

    public static function setSession($nombreSesion,$value){
        $_SESSION[$nombreSesion]=$value;
    }

    public static function getSession($nombreSesion){
        return isset($_SESSION[$nombreSesion]) ? $_SESSION[$nombreSesion] : null;
    }

    public static function getCookieSesion($nombreSesion){
        return isset($_COOKIE[$nombreSesion]) ? $_COOKIE[$nombreSesion] : null;
    }


    //COOKIES SESION 

    public static function cookieSession($sessionId){
        $cookieName="cookieDeSesion";
        $cookieValue=$sessionId;
        $cookieExpire=time()+(60*60*24*30);
        setcookie($cookieName,$cookieValue,$cookieExpire);
    }

    public static function mantenerCookie($sessionId){
        session_id($sessionId);
        self::startSession();
    }

    public static function closeCookieSession($idSesion){
        $cookieName="cookieDeSesion";
        $cookieValue=$idSesion;
        $cookieExpire=time()-3600;
        setcookie($cookieName,$cookieValue,$cookieExpire);
    }

    public static function destroySession($idSesion,$rutaRedirigir){
        session_unset();
        session_destroy();
        self::closeCookieSession($idSesion);
        header("Location: " . $rutaRedirigir);
        exit;
    }


    function condicionesInicioSesion($sesionId,$nombreSesion,$paginaRedirigir){
        if(self::getCookieSesion($sesionId)!=null){
            self::mantenerCookie($sesionId);
        }else{
            self::startSession();
            if(self::getSession($nombreSesion)==null){
            header($paginaRedirigir);
            exit;
            }
        }
    }

}

?>