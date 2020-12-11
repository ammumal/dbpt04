<?php
    $link = mysqli_connect("localhost", "root", "rootroot", "endterm");
    $filtered = array(
        'age' => mysqli_real_escape_string($link, $_POST['age'])
    );


    $query = "SELECT rent_name
      FROM june
      where age_code = '{$filtered['age']}'
      group by rent_name
      order by sum(use_num) desc
      limit 3
      ";


    $result = mysqli_query($link, $query);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($link));
        exit();
    }


    $rent_name ='';

    while ($row = mysqli_fetch_array($result)) {
        $rent_name .= '<tr>'.$row['rent_name'].'</tr>';
        $rent_name .= '<tr>'.'<br>'.'</tr>';
    }

    switch ($filtered['age']) {
      case "AGE_001":
        $age_inform = '10대';
      break;
      case "AGE_002":
        $age_inform = '20대';
      break;
      case "AGE_003":
        $age_inform = '30대';
      break;
      case "AGE_004":
        $age_inform = '40대';
      break;
      case "AGE_005":
        $age_inform = '50대';
      break;
      case "AGE_006":
        $age_inform = '60대';
      break;
      default:
        $age_inform = '70대';

}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charser-"uft-8">
    <title> 따릉이 </title>
</head>

<body>
    <h2><a href="main.php">메인</a> | 연령별 대여소 TOP 3</h2>
    <h2> <?=$age_inform?>의 대여소 이용 TOP3 </h2>
    <h3><?=$rent_name?></h3>
</body>

</html>
