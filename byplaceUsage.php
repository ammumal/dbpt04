<?php
  header("Content-Type: text/html; charset=UTF-8");
  date_default_timezone_set('Asia/Seoul');

  $link = mysqli_connect('localhost', 't04dbp', 't042020dbp!', 't04dbp');
  $renttime= mysqli_real_escape_string($link, $_POST['time']);
  $rentplace = mysqli_real_escape_string($link, $_POST['place']);

  if ($renttime == 0) {
      $renttime = date("H");
  }

  $maxQuery = "select location.loc_name, sum(hourlyuse.usage) as s from hourlyuse join location on hourlyuse.rentplace = location.loc_id where location.gu='{$rentplace}' and hourlyuse.renttime='{$renttime}' group by hourlyuse.renttime, location.loc_name order by s desc limit 5";
  $minQuery = "select location.loc_name, sum(hourlyuse.usage) as s from hourlyuse join location on hourlyuse.rentplace = location.loc_id where location.gu='{$rentplace}' and hourlyuse.renttime='{$renttime}' group by hourlyuse.renttime, location.loc_name order by s limit 5";

  $maxRows = mysqli_query($link, $maxQuery);
  $minRows = mysqli_query($link, $minQuery);

  $maxResult = '';
  $minResult = '';

  while ($minRow = mysqli_fetch_assoc($minRows)) {
      $minResult .= '<tr>';
      $minResult .= '<td>'.$minRow['loc_name'].'</td>';
      $minResult .= '<td>'.$minRow['s'].'</td>';
      $minResult .= '</tr>';
  }

  while ($maxRow = mysqli_fetch_assoc($maxRows)) {
      $maxResult .= '<tr>';
      $maxResult .= '<td>'.$maxRow['loc_name'].'</td>';
      $maxResult .= '<td>'.$maxRow['s'].'</td>';
      $maxResult .= '</tr>';
  }


  if ($maxRows == false || $minRows == false) {
      echo '조회 과정에서 문제가 발생했습니다. 관리자에게 문의하세요.';
      echo "<a href='main.php'> 돌아가기 </a>";
      error_log(mysqli_error($link));
  }
?>
<html>
  <head>
      <meta charset="utf-8">
      <title> 시간대 별 이용 복잡도 </title>
  </head>
  <body>
    <h3> 연령대별 정보 | <a href="index.html"> Home </a>
    <h3> 입력하신 <?= $renttime ?> 시간대 <?= $rentplace ?> 에서 최고로 복잡한 대여소 정보입니다.  </h3>
    <table border=1>
      <tr>
          <th> 대여소명 </th>
          <th> 이용건수 </th>
      </tr>
      <?= $maxResult ?>
    </table>
    <h3> <?= $renttime ?> 시간대 <?= $rentplace ?> 지역에서 이용건수가 가장 적은 아래의 대여소를 추천해드립니다.  </h3>
    <table border=1>
      <tr>
          <th> 대여소명 </th>
          <th> 이용건수 </th>
      </tr>
      <?= $minResult ?>
    </table>
    <br>
    * 시간과 이용건수: 해당 시간부터 1시간 내 대여 건수의 합입니다.
    <br>
    * 상위 5개의 정보를 제공합니다.
  </body>

</html>
