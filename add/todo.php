<?php 
class Todo
{
  private $pdo;
  function __construct($pdo){
    $this->pdo=$pdo;
  }
  public function todo(){
    if($_SERVER["REQUEST_METHOD"]==="POST"){
      $action=filter_input(INPUT_GET,"action");
      switch($action){
        case "add":
          $id=$this->add();
          echo json_encode($id);
          break;
        case "delete":
          $this->delete();
          break;
        case "toggle":
          $this->toggle();
          break;
        case "purge":
          $this->purge();
          break;
      }
      exit;
    }
  }
  public function add(){
    $title=filter_input(INPUT_POST,"title");
    $stmt=$this->pdo->prepare("INSERT INTO todo(title) VALUES(
      :title)");
    $stmt->bindValue("title",$title,\PDO::PARAM_STR);
    $stmt->execute();
    return (int) $this->pdo->lastInsertId();
  }
  public function toggle(){
    $id=filter_input(INPUT_POST,"id");
    $stmt=$this->pdo->prepare("UPDATE todo SET is_done=NOT is_done WHERE id=:id");
    $stmt->bindValue("id",$id,\PDO::PARAM_INT);
    $stmt->execute();
  }
  public function delete(){
    $id=filter_input(INPUT_POST,"id");
    $stmt=$this->pdo->prepare("DELETE FROM todo WHERE id=:id");
    $stmt->bindValue("id",$id,\PDO::PARAM_INT);
    $stmt->execute();
  }
  public function purge(){
    $this->pdo->query("DELETE FROM todo WHERE is_done=1");
  }

  public function getTodo(){
    $stmt=$this->pdo->query("SELECT * FROM todo");
    $todoList=$stmt->fetchAll();

    return $todoList;
  }
}
?>