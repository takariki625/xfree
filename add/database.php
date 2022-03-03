<?php 
class localPdo
{
  private static $pdo;
  public static function getInstance(){
    self::$pdo=new PDO(
      pdo,
      user,
      pw
    );
    return self::$pdo;
  }
}
?>