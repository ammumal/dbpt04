<?php
    $link = mysqli_connect("localhost", "root", "rootroot", "endterm");
    $filtered = array(
        'month' => mysqli_real_escape_string($link, $_POST['month']),
        'gu' => mysqli_real_escape_string($link, $_POST['gu'])
    );


    if ($filtered['month']=='base') {
        switch (date("M")) {
      case "Jan":
        $mon = 202001;
        break;
      case 'Feb':
        $mon = 202002;
        break;
      case 'Mar':
        $mon = 202003;
        break;
      case 'Apr':
        $mon = 202004;
        break;
      case 'Mar':
        $mon = 202005;
        break;
      case 'Jun':
        $mon = 201906;
        break;
      case 'Jul':
        $mon = 201907;
        break;
      case 'Aug':
        $mon = 201908;
        break;
      case 'Sep':
        $mon = 201909;
        break;
      case 'Oct':
        $mon = 201910;
        break;
      case 'Nov':
        $mon = 201911;
        break;
      default:
        $mon = 201912;
    }
    } else {
        switch ($filtered['month']) {
    case 'Jan':
      $mon = 202001;
      break;
    case 'Feb':
      $mon = 202002;
      break;
    case 'Mar':
      $mon = 202003;
      break;
    case 'Apr':
      $mon = 202004;
      break;
    case 'Mar':
      $mon = 202005;
      break;
    case 'Jun':
      $mon = 201906;
      break;
    case 'Jul':
      $mon = 201907;
      break;
    case 'Aug':
      $mon = 201908;
      break;
    case 'Sep':
      $mon = 201909;
      break;
    case 'Oct':
      $mon = 201910;
      break;
    case 'Nov':
      $mon = 201911;
      break;
    default:
      $mon = 201912;
    }
    }

  if ($mon >= 201912) {
      $query = "SELECT rent_group, rent_name, rent_count
        FROM rent_dec_may
        where rent_group = '{$filtered['gu']}' and rent_month = $mon
        order by rent_count desc
        limit 1
        ";
  } else {
      $query = "SELECT rent_group, rent_name, rent_count
            FROM rent_june_nov
            where rent_group = '{$filtered['gu']}' and rent_month = $mon
            order by rent_count desc
            limit 1
            ";
  }


    $result = mysqli_query($link, $query);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($link));
        exit();
    }


    $rent_top ='';
    $rent_count='';
    $gu_name='';
    while ($row = mysqli_fetch_array($result)) {
        $gu_name .= '<tr>'.$row['rent_group'].'</tr>';
        $rent_top .= '<tr>'.$row['rent_name'].'</tr>';
        $rent_count .= '<tr>'.$row['rent_count'].'</tr>';
    }

    if ($mon >= 201912) {
        $query = "SELECT rent_name, rent_count
          FROM rent_dec_may
          where rent_group = '{$filtered['gu']}' and rent_month = $mon
          order by rent_count Asc
          limit 1
          ";
    } else {
        $query = "SELECT rent_name, rent_count
              FROM rent_june_nov
              where rent_group = '{$filtered['gu']}' and rent_month = $mon
              order by rent_count Asc
              limit 1
              ";
    }
      $result = mysqli_query($link, $query);
      if (!$result) {
          printf("Error: %s\n", mysqli_error($link));
          exit();
      }


      $rent_name ='';
      $rent_count2='';
      while ($row = mysqli_fetch_array($result)) {
          $rent_name .= '<tr>'.$row['rent_name'].'</tr>';
          $rent_count2 .= '<tr>'.$row['rent_count'].'</tr>';
      }


?>

<!DOCTYPE html>
<html>

<head>
    <meta charser-"uft-8">
    <title> 따릉이 </title>
</head>

<body>
    <h2><a href="main.php">메인</a> | 따릉이 월별 복잡도</h2>
    <h3> 조회하신 월에 과거 <?=$mon?> 의 <?=$gu_name?>에서 가장 복잡도가 심한 대여소는 <?=$rent_top?>입니다.</h3>
    <h3> 과거 해당 월에 이 대여소는 <?=$rent_count?>만큼 이용되었습니다.</h3>
    <h3> 따라서 <?=$rent_count2?>만큼 이용해서 복잡도가 가장 적은 다음 <?=$rent_name?> 대여소를 이용하시길 추천합니다.</h3>
</body>

</html>
