<?php
ini_set('display_errors', 1);

require_once '../libs/flight/Flight.php';
require_once '../libs/Parsedown.php';

require_once ("../libs/blade/BladeOne.php");
use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new BladeOne($views,$cache,BladeOne::MODE_DEBUG);
Flight::set('blade', $blade);

require_once '../libs/idiorm.php';
ORM::configure('sqlite:./data.db');

Flight::route('/megaMenu', function(){//################################################## megaMenu

    $row = ORM::for_table('megaMenu')->find_one(1);

    $blade = Flight::get('blade');
    echo $blade->run("megaMenu",array("row"=>$row)); //
});

Flight::route('/megaMenuUpd/@id', function($id){//################################################## megaMenu

  $row = ORM::for_table('megaMenu')->find_one($id);

  $blade = Flight::get('blade');
  echo $blade->run("megaMenuUpd",array("row"=>$row)); 
});

Flight::route('/megaMenuUpdExe', function(){//################################################## megaMenuUpdExe
    $id = Flight::request()->data->id;
    $row = ORM::for_table('megaMenu')->find_one($id);
    $row->css = Flight::request()->data->css;
    $row->html = Flight::request()->data->html;
    $row->save();

    Flight::redirect('/megaMenu');
});

Flight::route('/toc', function(){//################################################## toc

    $rows = ORM::for_table('toc')->order_by_desc('sort')->find_array();

$i = 0;
foreach($rows as $row){
    $rows2 = ORM::for_table('cat')->where("tocId",$row["tocId"])->order_by_desc('updated')->find_array();
    $rows[$i]["cats"] = $rows2;//rows2を入れる
    $i++;
}

//echo "<pre>";
//var_dump($rows);
//echo "</pre>";

/*
$i = 0;
foreach($rows as $row){
    $count = ORM::for_table('cat')->where("tocId",$row["tocId"])->count();
    $rows[$i]["count"] = $count;//countを追記
    $i++;
}
*/


  $blade = Flight::get('blade');

    echo $blade->run("toc",array("rows"=>$rows)); //
/*
*/

});

Flight::route('/tocInsExe', function(){//################################################## tocInsExe
    $row = ORM::for_table('toc')->create();
    $row->date = date('Y-m-d');
    $tocId = Flight::request()->data->tocId;
    $sort = Flight::request()->data->sort;

    if($tocId != null){
        $row->tocId = $tocId;
    }else{
        $row->tocId = 0;
    }

    if($sort != null){
        $row->sort = $sort;
    }else{
        $row->tocId = 0;
    }

    $row->title = Flight::request()->data->title;
    $row->updated = time();
    $row->save();
    Flight::redirect('/toc');
});

Flight::route('/tocUpd/@id', function($id){//################################################## tocUpd
  $row = ORM::for_table('toc')->find_one($id);

  $blade = Flight::get('blade');
  echo $blade->run("tocUpd",array("row"=>$row)); 
});

Flight::route('/tocUpdExe', function(){//################################################## tocUpdExe
    $id = Flight::request()->data->id;
    $row = ORM::for_table('toc')->find_one($id);
    $row->sort = Flight::request()->data->sort;
    $row->tocId = Flight::request()->data->tocId;
    $row->title = Flight::request()->data->title;
    $row->save();

    Flight::redirect('/toc');
});

Flight::route('/tocDel/@id', function($id){//################################################## tocDel
	$row = ORM::for_table('toc')->find_one($id);
	$row->delete();
	Flight::redirect('/toc');
});

Flight::route('/dates', function(){//################################################## dates


//echo date('Y/m/d', $unixTime);


//    echo "test";

  $y = Flight::request()->query->y;
  $m = Flight::request()->query->m;

    if($y == null){
        $y = date("Y");
    }


    if($m == null){
        $m = date("m");
        $m = (int)$m;//数値化
    }

$unixTime = mktime(0,0,0,$m,1,$y);

$nextYM = [];
$previousYM = [];

$nextYM[] = date('Y', strtotime('+1 month', $unixTime));
$nextYM[] = date('m', strtotime('+1 month', $unixTime));

$previousYM[] = date('Y', strtotime('-1 month', $unixTime));
$previousYM[] = date('m', strtotime('-1 month', $unixTime));

//echo (int)$y;
//$m = (int)$m;
//echo $m;

$m = sprintf('%02d', $m);//0埋め

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("select *,strftime('%w',date) as week from date where date like ?");
    $array = array($y . "-" . $m . "-%");//当該月
//    $array = array("2023-01-31");

    $stmt->execute($array);

    $rows = makeRows($stmt);
    $rows = markdownParse($rows);

    //$row = $rows[0];//

//print_r($row);

$m = (int)$m;//数値化

    $blade = Flight::get('blade');
    echo $blade->run("date",array("rows"=>$rows,"nextYM"=>$nextYM,"previousYM"=>$previousYM,"y"=>$y,"m"=>$m)); //

});

Flight::route('/recoCats', function(){//################################################## records
    $rows = ORM::for_table('recoCat')->order_by_desc('sort')->find_many();

    $blade = Flight::get('blade');
    echo $blade->run("recoCat",array("rows"=>$rows)); //
});

Flight::route('/records', function(){//################################################## records

  $recoCatId = Flight::request()->query->recoCatId;

    if($recoCatId == null){
        $recoCatId = 1;
    }

    $row = ORM::for_table('recoCat')->find_one($recoCatId);
    $recoCatRow = $row;

  $y = Flight::request()->query->y;
  $m = Flight::request()->query->m;

    if($y == null){
        $y = date("Y");
    }

    if($m == null){
        $m = date("m");
        $m = (int)$m;//数値化
    }

$unixTime = mktime(0,0,0,$m,1,$y);

$nextYM = [];
$previousYM = [];

$nextYM[] = date('Y', strtotime('+1 month', $unixTime));
$nextYM[] = date('m', strtotime('+1 month', $unixTime));

$previousYM[] = date('Y', strtotime('-1 month', $unixTime));
$previousYM[] = date('m', strtotime('-1 month', $unixTime));

$m = sprintf('%02d', $m);//0埋め

    $db = new PDO('sqlite:data.db');

    $sql = "";

//, sum(min) as sumMin
    $sql .= "
select *,strftime('%w',date) as week,record.id as recoId,record.text as text
from
date
inner join
record
on date.id = record.dateId
";

/*
select * from
record

*/

    $sql .= "
inner join
recoCat
on record.recoCatId = recoCat.id
";

    $sql .= "where date like ?";
    $sql .= " and recoCatId = ?";

    //$sql .= "limit 5";

//echo $sql;

//where date like ?

    //$sql = "select * from record inner join recoCat on record.recoCatId = recoCat.id where date like ?";

    $stmt = $db->prepare($sql);//プリペアする

    //$stmt = $db->prepare("select *,strftime('%w',date) as week from date where date like ?");

    //$array = array();//当該月

    $array = array($y . "-" . $m . "-%",$recoCatId);//当該月

    //$stmt->execute();//エグゼキュートする

    $stmt->execute($array);//プレースホルダにarrayを入れてエグゼキュート

    $rows = makeRows($stmt);
    $rows = markdownParse($rows);

$m = (int)$m;//数値化

/*
echo "<pre>";
print_r($rows);
echo "</pre>";
*/

    $blade = Flight::get('blade');
    echo $blade->run("record",array("rows"=>$rows,"nextYM"=>$nextYM,"previousYM"=>$previousYM,"y"=>$y,"m"=>$m,"recoCatRow"=>$recoCatRow)); //

});

Flight::route('/dateUpd/@id', function($id){//################################################## dateUpd
  $y = Flight::request()->query->y;
  $m = Flight::request()->query->m;

  $row = ORM::for_table('date')->find_one($id);
  $blade = Flight::get('blade');//
  echo $blade->run("dateUpd",array("row"=>$row,"y"=>$y,"m"=>$m)); //
});

Flight::route('/recoUpd/@id', function($id){//################################################## dateUpd
  $y = Flight::request()->query->y;
  $m = Flight::request()->query->m;

    $db = new PDO('sqlite:data.db');

    $sql = "";

    $sql .= "
select *,record.id as recoId,record.text as recoText from
date
inner join
record
on date.id = record.dateId
";

    $sql .= "
inner join
recoCat
on record.recoCatId = recoCat.id
";

    $sql .= "
where recoId = ?
";

    $stmt = $db->prepare($sql);//プリペアする

    $array = array($id);
    $stmt->execute($array);//プレースホルダにarrayを入れてエグゼキュート
    //$stmt->execute();//

    $rows = makeRows($stmt);
    $row = $rows[0];
//print_r($row);

  $blade = Flight::get('blade');//
  echo $blade->run("recoUpd",array("row"=>$row,"y"=>$y,"m"=>$m)); //
});

Flight::route('/dateUpdExe', function(){//################################################## dateUpdExe
    $id = Flight::request()->data->id;
    $row = ORM::for_table('date')->find_one($id);

    $y = Flight::request()->data->y;
    $m = Flight::request()->data->m;

    //$catId = Flight::request()->data->catId;//
    //$row->catId = $catId;//
    //$row->sort = Flight::request()->data->sort;

    //$row->tag = Flight::request()->data->tag;
    $row->text = Flight::request()->data->text;
    //$row->updated = time();
    $row->save();

    $m = sprintf('%02d', $m);//0埋め
    Flight::redirect('/dates?y=' . $y . "&m=" . $m);
});

Flight::route('/recoUpdExe', function(){//################################################## dateUpdExe
    $id = Flight::request()->data->id;
    $row = ORM::for_table('record')->find_one($id);

    $y = Flight::request()->data->y;
    $m = Flight::request()->data->m;

    //$catId = Flight::request()->data->catId;//
    //$row->catId = $catId;//
    //$row->sort = Flight::request()->data->sort;

    $recoCatId = Flight::request()->data->recoCatId;
    $row->recoCatId = $recoCatId;

    $row->text = Flight::request()->data->text;
    $row->min = Flight::request()->data->min;

    //$row->updated = time();

    $row->save();

    $m = sprintf('%02d', $m);//0埋め
    Flight::redirect('/records?recoCatId=' . $recoCatId . '&y=' . $y . "&m=" . $m);
});
/*
*/



Flight::route('/findDateText', function(){//################################################## findDateText
  $word = Flight::request()->query->word;
  $rows = ORM::for_table('date')->where_like('text',"%" . $word . "%")->order_by_asc('date')->find_many();
  $rows = markdownParse($rows);

  $blade = Flight::get('blade');//
  echo $blade->run("date",array("word"=>$word,"rows"=>$rows)); //
});

Flight::route('/datesInsYear', function(){//################################################## datesInsYear

    $y = 2023;//ここの年を変更する
    $m = 1;//開始日
    $d = 1;//開始月

    $unixTime = mktime(0,0,0,$m,$d,$y);

    $dateStr = date('Y-m-d', $unixTime);

    //$m = sprintf('%02d', $m);//0埋め
    //$d = sprintf('%02d', $d);//0埋め

        $db = new PDO('sqlite:data.db');

//echo date('Y', $unixTime);


    while(date('Y', $unixTime) == $y){

//echo date('Y', $unixTime);

        $stmt = $db->prepare("insert into date (date) values (?)");
        $array = array($dateStr);
        $stmt->execute($array);

        $unixTime = strtotime('+1 day', $unixTime);//1日追加

        $dateStr = date('Y-m-d', $unixTime);
//echo $dateStr;

    }
/*
*/

    echo "end!";
});

Flight::route('/datesInsHoliday', function(){//################################################## datesInsHoliday

    $rows = ORM::for_table('date')->find_many();

    $db = new PDO('sqlite:data.db');

    $holidayArr = array(//2023年の祝日
        "2023-01-01",
        "2023-01-02",
        "2023-01-03",
        "2023-01-09",
        "2023-02-23",
        "2023-03-21",
        "2023-05-03",
        "2023-05-04",
        "2023-05-05",
        "2023-07-17",
        "2023-08-11",
        "2023-09-18",
        "2023-10-09",
        "2023-11-03",
        "2023-11-23",
        "2023-12-29",
        "2023-12-30",
        "2023-12-31"
    );

    //$i = 0;

    foreach($rows as $row){

//if($i < 10){

        $id = $row->id;
        $row = ORM::for_table('date')->find_one($id);

        if(in_array($row->date, $holidayArr)){//祝日かどうかを判定

            $row->holiday = 1;

        }else{

            $row->holiday = 0;

        }

        $row->save();

//$i++;

//}//10回だけループ

    }//foreach

    //$stmt = $db->prepare("update date set holiday = 1 where date = ?");

    echo "end!";

});




Flight::route('/recordsInsYear', function(){//################################################## recordsInsYear

//id、2〜366

        $db = new PDO('sqlite:data.db');

//echo date('Y', $unixTime);
//echo date('Y', $unixTime);

//$dateId = 2;

    $rows = ORM::for_table('date')->find_array();//dateテーブルの全レコード


//echo count($rows);

//echo print_r($rows[1]);

    for($i = 1; $i < 11; $i++){//recoCatId

    //$j = 1;

        foreach($rows as $row){

    //if($j < 5){
                    //$stmt = $db->prepare("insert into record (dateId) values (?)");

                    $stmt = $db->prepare("insert into record (dateId,recoCatId) values (?,?)");

                    //$array = array($row["id"]);
                    $array = array($row["id"],$i);

                    $stmt->execute($array);

    //$j++;
    //}//if

        }//foreach

    }//for

    echo "end2!";

});

Flight::route('/recordsInsYearFromLink', function(){//################################################## recordsInsYear

    $recoCatId = Flight::request()->query->recoCatId;
    $y = date("Y");

//echo $y;
//echo "<br>";

    $db = new PDO('sqlite:data.db');

    $sql = "";

    $sql .= "
select count(*)
from
date
inner join
record
on date.id = record.dateId
";

    $sql .= "where recoCatId = ?";
    $sql .= " and date like ?";

//echo $sql;

    $stmt = $db->prepare($sql);

    $array = array();

    $array = array($recoCatId);
    $array = array($recoCatId, $y . "-%");

    $stmt->execute($array);

    $rowNum = $stmt->fetchColumn();

//print_r($rowNum);

if($rowNum == 0){//現在の年の登録数が0のとき、実行

    $db = new PDO('sqlite:data.db');
    $rows = ORM::for_table('date')->where_like("date",$y . "-%")->find_array();//現在の年のdateテーブルの全レコード

        foreach($rows as $row){

                    $stmt = $db->prepare("insert into record (dateId,recoCatId) values (?,?)");

                    $array = array($row["id"],$recoCatId);

                    $stmt->execute($array);

        }//foreach

}else{
    //echo '<script>alert("今年の登録があるので、登録されませんでした")</script>';
}//if


    Flight::redirect('/recoCats');
/*
*/

});


Flight::route('/cats', function(){//################################################## cats
//    echo "test";
    $rows = ORM::for_table('cat')->order_by_desc('updated')->find_many();
  $blade = Flight::get('blade');
    echo $blade->run("cats",array("rows"=>$rows)); //成功2

});

Flight::route('/cat/@tocId', function($tocId){//################################################## cat/@tocId
    $rows = ORM::for_table('cat')->where("tocId",$tocId)->order_by_desc('updated')->find_many();
    $blade = Flight::get('blade');
    echo $blade->run("cats",array("rows"=>$rows)); //成功2
});

Flight::route('/catInsExe', function(){//################################################## catInsExe
    $row = ORM::for_table('cat')->create();
    $row->date = date('Y-m-d');
    $tocId = Flight::request()->data->tocId;
if($tocId != null){
    $row->tocId = Flight::request()->data->tocId;

}else{
    $row->tocId = 0;

}

    $row->title = Flight::request()->data->title;
    $row->updated = time();
    $row->sort = 0;
    $row->linkTo = "[]";
    $row->linked = "[]";
    $row->save();
    Flight::redirect('/cats');
});

Flight::route('/recoCatInsExe', function(){//################################################## recoCatInsExe
    $row = ORM::for_table('recoCat')->create();
    //$row->date = date('Y-m-d');

    $row->title = Flight::request()->data->title;
    $row->sort = Flight::request()->data->sort;

    $row->save();
    Flight::redirect('/recoCats');
});

Flight::route('/catUpd/@id', function($id){//################################################## catUpd
  $row = ORM::for_table('cat')->find_one($id);

  $blade = Flight::get('blade');
  echo $blade->run("catUpd",array("row"=>$row)); 
});

Flight::route('/recoCatUpd/@id', function($id){//################################################## catUpd
  $row = ORM::for_table('recoCat')->find_one($id);

  $blade = Flight::get('blade');
  echo $blade->run("recoCatUpd",array("row"=>$row)); 
});

Flight::route('/catUpdExe', function(){//################################################## catUpdExe
    $id = Flight::request()->data->id;
    $row = ORM::for_table('cat')->find_one($id);
    $row->tocId = Flight::request()->data->tocId;
    $row->title = Flight::request()->data->title;
    $row->save();

    Flight::redirect('/datas/' . $id);
});

Flight::route('/recoCatUpdExe', function(){//################################################## catUpdExe
    $id = Flight::request()->data->id;
    $row = ORM::for_table('recoCat')->find_one($id);
    $row->title = Flight::request()->data->title;
    $row->sort = Flight::request()->data->sort;

    $row->save();

    Flight::redirect('/recoCats');
});


Flight::route('/catLinkAddDel', function(){//################################################## catLinkAddDel

    $id = Flight::request()->data->id;
    $addOrDel = Flight::request()->data->addOrDel;
    $linkAddDel = Flight::request()->data->linkAddDel;

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("select * from cat where id = ?");
    $array = array($id);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];//

    if($addOrDel == 1){
        $addLink = $linkAddDel;

        $linkToObj = json_decode($row["linkTo"]);
        $linkToObj[] = (int)$addLink;
        sort($linkToObj);
        $linkToStr = json_encode($linkToObj);

        $stmt = $db->prepare("update cat set linkTo = ? where id = ?");//更新
        $stmt->execute(array($linkToStr,$id));

        //ここから親レコードのlinkedを入力
        $stmt = $db->prepare("select * from cat where id = ?");//親レコードを取得
        $stmt->execute(array($addLink));

        $rows = makeRows($stmt);
        $row = $rows[0];//親レコード

//var_dump($addLink);

//var_dump($row);

        $linkedObj = json_decode($row["linked"]);
        $linkedObj[] = (int)$id;
        //sort($linkedObj);
        $linkedStr = json_encode($linkedObj);

//var_dump($linkedStr);


        $stmt = $db->prepare("update cat set linked = ? where id = ?");//更新
        $stmt->execute(array($linkedStr,$addLink));
    }else{

        $delLink = $linkAddDel;

        $db = new PDO('sqlite:data.db');
        $stmt = $db->prepare("select linkTo from cat where id = ?");
        $array = array($id);
        $stmt->execute($array);

        $rows = makeRows($stmt);
        $row = $rows[0];//

        $linkToObj = json_decode($row["linkTo"]);
        $delLinkOrder = array_search($delLink,$linkToObj);
        array_splice($linkToObj,$delLinkOrder,1);//linkToから削除
    //var_dump($linkToObj);
        $linkToStr = json_encode($linkToObj);

        $stmt = $db->prepare("update cat set linkTo = ? where id = ?");//更新
        $stmt->execute(array($linkToStr,$id));

    //ここから親レコードのlinkedを削除
        $stmt = $db->prepare("select * from cat where id = ?");//親レコードを取得
        $stmt->execute(array($delLink));

        $rows = makeRows($stmt);
        $row = $rows[0];//親レコード

        $linkedObj = json_decode($row["linked"]);
        $delLinkOrder = array_search($id,$linkedObj);
        array_splice($linkedObj,$delLinkOrder,1);
        $linkedStr = json_encode($linkedObj);

        $stmt = $db->prepare("update cat set linked = ? where id = ?");//更新
        $stmt->execute(array($linkedStr,$delLink));


    }

    Flight::redirect('/datas/' . $id);

});


Flight::route('/catDel/@id', function($id){
	$row = ORM::for_table('cat')->find_one($id);
	$row->delete();
	Flight::redirect('/cats');
});

Flight::route('/catUp/@id', function($id){
    $row = ORM::for_table('cat')->find_one($id);
    $row->updated = time();
    $row->save();
    Flight::redirect('/cats');
});

Flight::route('/datas/@catId', function($catId){//################################################## datas
  $page = Flight::request()->query->page;
  $records = 50;//1ページあたりのレコード数
  $catrow = ORM::for_table('cat')->where('id', $catId)->find_one();

    $db = new PDO('sqlite:./data.db');

    $id = $catId;
    $sql = "select * from cat where id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($id));

    $rows = makeRows($stmt);
    $mainRow = $rows[0];






//linkToの処理
    $linkToObj = json_decode($mainRow["linkTo"]);

    $whereIn = implode(",",$linkToObj);

//var_dump($whereIn);

//$whereIn = 18;

    $stmt = $db->prepare("select * from cat where id in (" . $whereIn . ") order by updated desc");

    $stmt->execute();


    $linkToRows = makeRows($stmt);


//linkedの処理
    $linkedObj = json_decode($mainRow["linked"]);

$whereIn = implode(",",$linkedObj);

    $stmt = $db->prepare("select * from cat where id in (" . $whereIn . ") order by updated desc");
    $stmt->execute();

    $linkedRows = makeRows($stmt);

  $inTag = Flight::request()->query->inTag;

  if($inTag != null){

      if($page === 0){//全表示
        $rows = ORM::for_table('data')->where('catId', $catId)->where_like('inTag',"%" . $inTag . "%")->order_by_desc('sort')->order_by_desc('updated')->find_many();
      }else if($page != null){
        $rows = ORM::for_table('data')->where('catId', $catId)->where_like('inTag',"%" . $inTag . "%")->order_by_desc('sort')->order_by_desc('updated')->limit($records)->offset(($page - 1) * $records)->find_many();
      }else{
        $page = 1;
        $rows = ORM::for_table('data')->where('catId', $catId)->where_like('inTag',"%" . $inTag . "%")->order_by_desc('sort')->order_by_desc('updated')->limit($records)->offset(($page - 1) * $records)->find_many();
      }

  }else{

      if($page === 0){//全表示
        $rows = ORM::for_table('data')->where('catId', $catId)->order_by_desc('sort')->order_by_desc('updated')->find_many();
      }else if($page != null){
        $rows = ORM::for_table('data')->where('catId', $catId)->order_by_desc('sort')->order_by_desc('updated')->limit($records)->offset(($page - 1) * $records)->find_many();
      }else{
        $page = 1;
        $rows = ORM::for_table('data')->where('catId', $catId)->order_by_desc('sort')->order_by_desc('updated')->limit($records)->offset(($page - 1) * $records)->find_many();
      }

      
  }

$rows = markdownParse($rows);

$inTags = [];
foreach($rows as $row){
    $inTags[] = json_decode($row["inTag"]);
}

$inTags = array_reduce($inTags, "array_merge", array());//1次元化
$inTags = array_unique($inTags);//重複を削除

sort($inTags, SORT_STRING);//ソート

  $blade = Flight::get('blade');//
  echo $blade->run("datas",array("catrow"=>$catrow,"rows"=>$rows,"page"=>$page,"linkToRows"=>$linkToRows,"linkedRows"=>$linkedRows,"inTags"=>$inTags)); //

});

Flight::route('/dataOne/@id', function($id){//################################################## dataOne/@id
    $row = ORM::for_table('data')->find_one($id);

$row = markdownParseOne($row);

  $blade = Flight::get('blade');//
  echo $blade->run("dataOne",array("row"=>$row)); //
});

function markdownParse($rows){
  $parse = new Parsedown();
  $parse->setBreaksEnabled(true);
  $parse->setMarkupEscaped(false);
  $i = 0;
   foreach($rows as $row){
     $rows[$i]["text"] = $parse->text($row["text"]);
     $i++;
   }
  return $rows;
}

function markdownParseOne($row){
  $parse = new Parsedown();
  $parse->setBreaksEnabled(true);
  $parse->setMarkupEscaped(false);
  $row["text"] = $parse->text($row["text"]);
  return $row;
}

Flight::route('/dataInsExe', function(){//################################################## dataInsExe
    $catId = Flight::request()->data->catId;
    $row = ORM::for_table('data')->create();
    $row->date = date('Y-m-d');
    $row->catId = $catId;//

    $tag = Flight::request()->data->tag;
    if($tag != ""){
        $row->tag = Flight::request()->data->tag;
    }else{
        $row->tag = "[]";
    }

    $inTag = Flight::request()->data->inTag;
    if($inTag != ""){
        $row->inTag = Flight::request()->data->inTag;
    }else{
        $row->inTag = "[]";
    }

    $row->text = Flight::request()->data->text;
    $row->updated = time();
    $row->sort = 0;
    $row->save();
    Flight::redirect('/datas/' . $catId);
});

Flight::route('/dataUpd/@id', function($id){//################################################## dataUpd
  $row = ORM::for_table('data')->find_one($id);
  $blade = Flight::get('blade');//
  echo $blade->run("dataUpd",array("row"=>$row)); //
});

Flight::route('/dataUpdExe', function(){//################################################## dataUpdExe
    $id = Flight::request()->data->id;
    $row = ORM::for_table('data')->find_one($id);
    $catId = Flight::request()->data->catId;//
    $row->catId = $catId;//
    $row->sort = Flight::request()->data->sort;

    $row->tag = Flight::request()->data->tag;
    $row->inTag = Flight::request()->data->inTag;

    $row->text = Flight::request()->data->text;
    //$row->updated = time();
    $row->save();
    Flight::redirect('/datas/' . $catId);
});

Flight::route('/dataDel/@id', function($id){//################################################## dataDel
	$row = ORM::for_table('data')->find_one($id);
	$catId = $row->catId;//
	$row->delete();
	Flight::redirect('/datas/' . $catId);
});

Flight::route('/dataUp/@id', function($id){//################################################## dataUp
    $row = ORM::for_table('data')->find_one($id);
    $row->updated = time();
    $catId = $row->catId;//
    $row->save();
    Flight::redirect('/datas/' . $catId);
});

Flight::route('/find', function(){//################################################## find
  $word = Flight::request()->query->word;
  $rows = ORM::for_table('data')->where_like('text',"%" . $word . "%")->order_by_desc('updated')->find_many();
  $catrow["title"] = $word;
  findCommon($rows,$catrow);
//  $word = Flight::request()->query->word;
//  $rows = ORM::for_table('data')->where_like('text',"%" . $word . "%")->order_by_desc('updated')->find_many();
//  $catrow["title"] = $word;
// 
//  $parse = new Parsedown();
//  $parse->setBreaksEnabled(true);
//  $parse->setMarkupEscaped(false);
//   foreach($rows as $row){
//     $row["text"] = $parse->text($row["text"]);
//   }
//
//  $blade = Flight::get('blade');//
//  echo $blade->run("datas",array("catrow"=>$catrow,"rows"=>$rows)); //
});

Flight::route('/tag', function(){//################################################## tag
  $word = Flight::request()->query->word;
  $rows = ORM::for_table('data')->where_like('tag',"%" . $word . "%")->order_by_desc('updated')->find_many();
  $catrow["title"] = $word;
  findCommon($rows,$catrow);
});

function findCommon($rows,$catrow){//################################################## findCommon
 
  $parse = new Parsedown();
  $parse->setBreaksEnabled(true);
  $parse->setMarkupEscaped(false);
   foreach($rows as $row){
     $row["text"] = $parse->text($row["text"]);
   }

  $blade = Flight::get('blade');//
  echo $blade->run("find",array("catrow"=>$catrow,"rows"=>$rows)); //
}

Flight::route('/tags', function(){//################################################## tags
//  $rows = ORM::for_table('data')->where("tag")->distinct()->find_many();

//pdo
    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("select tag from data where tag != '[]'");
    $stmt->execute();
    //$rows = $stmt;
//pdoここまで

$tags = [];
foreach($stmt as $row){
    $tags[] = json_decode($row["tag"]);
}

$tags = array_reduce($tags, "array_merge", array());//1次元化
$tags = array_unique($tags);//重複を削除

sort($tags, SORT_STRING);//ソート

  $blade = Flight::get('blade');//
  echo $blade->run("tags",array("tags"=>$tags)); //
});




Flight::route('/test', function(){//################################################## test

//    $count = ORM::for_table('cat')->where("tocId",1)->count();
//    echo ($count);

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("select count(*) from cat");
    //$array = array($id);
    $stmt->execute();

    $stmt = $db->prepare("select count(*) from cat");
    $stmt->execute();


$rows = makeRows($stmt);

    //$array = array($id);
    //$stmt->execute($array);



//$rows = [];
//$rows[][][] = 3;

echo "<pre>";
var_dump($rows);
echo "</pre>";

  //$blade = Flight::get('blade');//
  //echo $blade->run("test",array("rows"=>$rows)); //


});

function makeRows($stmt){
    $i = 0;
    $rows = [];
    while($row = $stmt->fetch()){
        $row["i"] = $i;
        $rows[$i] = $row;
        $i++;
    }
    return $rows;
}




Flight::start();


