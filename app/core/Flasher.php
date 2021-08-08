<?php

class Flasher{
    public static function setMessage($pesan, $aksi, $type)
    {
        $_SESSION['msg'] = [
            'pesan' => $pesan,
            'aksi'  => $aksi,
            'type'  => $type
        ];   
    }

    public static function setErrorMessage($pesan, $type)
    {
        $_SESSION['errmsg'] = [
            'pesan' => $pesan,
            'type'  => $type
        ];   
    }

    public static function errorMessage(){
        if( isset($_SESSION['errmsg']) ){
            echo $_SESSION['errmsg']['pesan'];
            unset($_SESSION['errmsg']);
        }
    }

    public static function Message(){
        if( isset($_SESSION['msg']) )
        {
            echo '<div class="alert alert-'. $_SESSION['msg']['type'] .' alert-dismissible fade show" role="alert">
                    <strong>'. $_SESSION['msg']['pesan'] .'</strong> '. $_SESSION['msg']['aksi'] .'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';

            unset($_SESSION['msg']);
        }
    }

    public static function msgInfo(){
        if( isset($_SESSION['msg']) )
        {
            echo '<div class="alert alert-'.$_SESSION['msg']['type'].'" role="alert">
                    '. $_SESSION['msg']['pesan'] .' <strong> '. $_SESSION['msg']['aksi'] .' </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                 ';

            unset($_SESSION['msg']);
        }
    }
}