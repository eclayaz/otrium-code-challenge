<?php

namespace App;

class Foo implements FooInterface
{

  private $userManager;

  public function __construct(UserManager $userManager)
  {
    $this->userManager = $userManager;
  }

    /**
     * Gets the name of the application.
     */
    public function getName()
    {
//      try {
//        $dsn = 'mysql:host=mysql;dbname=otrium;charset=utf8;port=3306';
//        $pdo = new PDO($dsn, 'dev', 'dev');
//      } catch (PDOException $e) {
//        echo $e->getMessage();
//      }

      $this->userManager->register('axx', 'b');

      return 'Nginx PHP MySQL';
    }
}
