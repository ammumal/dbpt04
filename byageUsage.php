<?php
  header("Content-Type: text/html; charset=UTF-8");

  $link = mysqli_connect('localhost', 't04dbp', 't042020dbp!', 't04dbp');
  $age= mysqli_real_escape_string($link, $_POST['age']);
  $rentplace = mysqli_real_escape_string($link, $_POST['place']);

  $query = "select sum(hourlyuse.usage) as s, hourlyuse.renttime, location.loc_name from hourlyuse join location on hourlyuse.rentplace = location.loc_id where hourlyuse.agecode='{$age}' and location.gu='{$rentplace}' group by hourlyuse.renttime, location.loc_name order by s desc, location.gu, hourlyuse.renttime limit 10;";

  $rows = mysqli_query($link, $query);
  $rowResult = '';
  while ($row = mysqli_fetch_array($rows)) {
      $rowResult .= '<tr>';
      $rowResult .= '<td>'.$row['loc_name'].'</td>';
      $rowResult .= '<td>'.$row['renttime'].'</td>';
      $rowResult .= '<td>'.$row['s'].'</td>';
      $rowResult .= '</tr>';
  }

  if ($rows == false) {
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
    <h3> 입력하신 <?= $age ?> 연령의 <?= $rentplace ?> 지역에서 이용건수가 가장 많은 대여소 정보입니다. </h3>
    <table border=1>
      <tr>
          <th> 대여소명 </th>
          <th> 시간 </th>
          <th> 이용건수 </th>
      </tr>
      <?= $rowResult ?>
    </table>
    <br>
    * 시간 단위 : 시
    <br>
    * 시간과 이용건수: 해당 시간부터 1시간 내 대여 건수의 합입니다.
    <br>
    * 데이터는 상위 10개의 결과만 제공합니다.
  </body>

</html>
