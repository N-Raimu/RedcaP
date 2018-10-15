<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" charset="utf-8">
</head>
<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

$sql="CREATE TABLE redcap"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(30),"
."comment TEXT,"
."password char(15),"
."date char(100)"
.");";
$stmt = $pdo->query($sql);

echo "<hr>";

?>
<body>

</body>
<?php
if(!empty($_POST['editNo'])){
echo "編集ナンバー確認。";

$sql = 'SELECT*FROM redcap';
$result = $pdo->query($sql);
 foreach($result as $row){
  if($_POST["passe"] == $row['password']){
   echo "パスワード一致。";
   $editPass = $row[password];
     if($_POST['editNo'] == $row['id']){
      echo "現在の内容を表示します。編集しますか？";
        $editName = $row[name];
        $editCom = $row[comment];
     }
  }
 }
}

if(!empty($_POST['delete'])){ //削除
echo "削除フォーム入力確認。";

$sql = 'SELECT*FROM redcap';
  $result = $pdo->query($sql);
  foreach($result as $row){
   if($_POST['delNo'] == $row['id'] and $_POST['passd'] == $row['password']){
echo "パスワード確認。削除します。";

        $id = $_POST['delNo'];
        $sql = "delete from redcap where id=$id";
        $result = $pdo->query($sql);

   }
  }

}elseif(!empty($_POST["name"]) and !empty($_POST["com"]) and !empty($_POST["pass"])){ //フォームに入ってる場合
echo "入力フォーム確認。";

     if(!empty($_POST["edit"])){ //編集モードの確認
    echo "編集モード確認。";

$sql = 'SELECT*FROM redcap';
      $result = $pdo->query($sql);
      foreach($result as $row){
       if($_POST['edit'] == $row['id'] and $_POST['pass'] == $row['password']){
        echo "パスワード確認。編集します。";

       //以下編集
        $id=$_POST['edit'];
        $nm=$_POST['name'];
        $kome=$_POST['com'];
        $sql = "update redcap set name='$nm',comment='$kome' where id=$id";
        $result = $pdo->query($sql);
       }
      }
     }elseif(empty($_POST['edit'])){ //新規書き込み
         echo "新規書き込み確認。新規書き込みします。";

             $id = $row['id'];
             $name = $_POST['name'];
             $comment = $_POST['com'];
             $password = $_POST['pass'];
             $date=date("Y/m/d H:i:s");

            $sql = $pdo->prepare("INSERT INTO redcap(id,name,comment,password,date)VALUES(:id,:name,:comment,:password,:date)");
            $sql->bindParam(':id',$id,PDO::PARAM_STR);
            $sql->bindParam(':name',$name,PDO::PARAM_STR);
            $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
            $sql->bindParam(':password',$password,PDO::PARAM_STR);
            $sql->bindParam(':date',$date,PDO::PARAM_STR);

               $sql->execute();
     }
}


?>
<form method="POST" action="mission4-1.php">
<p><input type="hidden"  name="edit" value='<?php echo $_POST["editNo"]; ?>' ></p>
<p>名前：<input type="text" name="name" value= '<?PHP echo "$editName"; ?>' ></p>  
<p>コメント：<input type="text" name="com" value= '<?PHP echo "$editCom"; ?>' ></p>
<p>パスワード:<input name="pass" type="text" value= '<?PHP echo "$editPass"; ?>' >  <input type="submit" value="送信"></p></form>
<form method="POST" action="mission4-1.php">
<p>削除するコメントの行番号:<input name="delNo" type="number" ></p>
<p>パスワード:<input name="passd" type="text">  <input type="submit" name="delete" value="送信"></p>
</form>
<form method="POST" action="mission4-1.php">
<p>編集対象番号：<input type="number" name="editNo"></p>
<p>パスワード:<input name="passe" type="text" >  <input type="submit" name="word" value="送信"></p>
</form>
<?php
echo "<hr>";
echo "<br>\n";

$sql = 'SELECT*FROM redcap';
$results = $pdo->query($sql);
  foreach($results as $row){
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].',';
    echo $row['date'].'<br>';
  }
?>
</html>
