<?php

namespace App\Acme;

class Mailer
{
  public function mail($recipient, $content)
  {
//    die('asd');
    // send an email to the recipient
    die($recipient. $content);
  }
}