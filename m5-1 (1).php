<?php 
	$dsn = 'データベース名';
	$user = 'ユーザ名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
    $sql="CREATE TABLE IF NOT EXISTS tb"//テーブル作成
    ." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32)," //最大で32文字格納できる
	. "comment TEXT,"
	. "day TEXT,"
	. "paspas TEXT"
	.");";
	$stmt = $pdo->query($sql);
    if(!empty($_POST["str"])&&!empty($_POST["name"])&&empty($_POST["editnum"])&&!empty($_POST["pas"])){
        $str=$_POST["str"];
    $name1=$_POST["name"];
    $day1=date("Y年m月d日H時i分s秒");
    $paspas1=$_POST["pas"];
        $sql = $pdo -> prepare("INSERT INTO tb (name, comment,day,paspas) VALUES (:name, :comment ,:day,:paspas)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':day', $day, PDO::PARAM_STR);
	$sql -> bindParam(':paspas', $paspas, PDO::PARAM_STR);
	$name = $name1;
	$comment = $str; 
	$day=$day1;
	$paspas=$paspas1;
    $sql -> execute();
    }

	
	//削除
    elseif(!empty($_POST["deletenum"])){
        $pas1=$_POST["pas1"];
        $sql = 'SELECT * FROM tb';
	$stmt = $pdo->query($sql);
        $results1=$stmt->fetchAll(); //featchallは全データを配列として取得
        foreach($results1 as $row1){
        if($pas1===$row1["paspas"]){ //配列の4と比較
                 $num=$_POST["deletenum"];
                 $id=$num;
             $sql = 'delete from tb where id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
            }

        else{
        $num=$_POST["deletenum"];
        if($num===$row1["id"]&&$pas1!==$row1["paspas"]){
            echo "パスワードが違います";
        }
        }
        }
    }
    //編集
    elseif(!empty($_POST["hensyuunum"])){
         $pas2=$_POST["pas2"];
          $sql = 'SELECT * FROM tb';
	$stmt = $pdo->query($sql);
          $results3=$stmt->fetchAll();
          foreach($results3 as $row3){
          if($pas2==$row3["paspas"]){
                 $hensyuu=$_POST["hensyuunum"];
                 if($hensyuu===$row3["id"]){
                     $hensyuuname=$row3["name"];
                    $hensyuustr=$row3["comment"];
                 }
                }
            
            else{
                $hensyuu=$_POST["hensyuunum"];
                if($hensyuu===$row3["id"]&&$pas2!==$row3["paspas"]){
                echo "パスワードが違います。<br>";
          }
        }
          }
    
          }
    
    elseif(!empty($_POST["editnum"])&&!empty($_POST["name"])&&!empty($_POST["str"])&&empty($_POST["pas"])){
        $hensyuu=$_POST["editnum"];
    $id = $hensyuu; //変更する投稿番号
	$name2 = $_POST["name"];
	$comment2 = $_POST["str"];
	$day2=  date("Y年m月d日H時i分s秒");//変更したい名前、変更したいコメントは自分で決めること
	$sql = 'UPDATE tb SET name=:name,comment=:comment,day=:day WHERE id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':day', $day, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$name=$name2;
	$comment=$comment2;
	$day=$day2;
	$stmt->execute();

    }



?>
<html>
  <body>
    <form action="" method="post">
       <input type="text" name="name" placeholder="名前"value="<?php if(!empty($hensyuuname)){
       echo $hensyuuname;
       }
   else{}?>"  ><br>
       <input type="text" name="str" placeholder="コメント"  value="<?php if(!empty($hensyuustr)){
       echo $hensyuustr; }
       else{}?>"><br>
       <input type="text" name="pas" placeholder="パスワード">
       <input type="hidden" name="editnum" value="<?php if(!empty($hensyuu)){
           echo $hensyuu;}
       else{}?>">
        <input type="submit" name="submit"><br>
        <input type="num" name="deletenum" placeholder="削除対象番号"><br>
        <input type="text" name="pas1" placeholder="パスワード" >
        <input type="submit" name="delete" value="削除"><br>
        <input type="number" name="hensyuunum" placeholder="編集対象番号"><br>
        <input type="text" name="pas2" placeholder="パスワード" >
        <input type="submit" name="hensyuu" value="編集">
        
    </form>
    </body>
    <?php	$sql = 'SELECT * FROM tb';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll(); //featchallは全データを配列として取得
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].'<>';
		echo $row['name'].'<>';
		echo $row['comment'].'<>';
		echo $row['day'].'<br>';
		echo "<hr>";
	}
    ?>
    </html>