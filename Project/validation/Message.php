<?php
class MessagePHP{
    static public function showMessage($str)
    {
        echo "<script language='javascript'>alert(\"${str}\");</script>";
    }
}

