<?php
  header("Content-Type: text/html; charset=UTF-8");

  $link = mysqli_connect('localhost', 't04dbp', 't042020dbp!', 't04dbp');
  $rentplace = mysqli_real_escape_string($link, $_POST['search']);

  $query = "select hourlyuse.renttime, sum(hourlyuse.usage) as s, location.loc_name from hourlyuse join location on hourlyuse.rentplace = location.loc_id where location.loc_name like '%{$rentplace}%' group by hourlyuse.renttime, location.loc_name order by location.loc_name, hourlyuse.renttime, s limit 30";
  $rows = mysqli_query($link, $query);

  $hourlyResult = '';
  $num = 0;

  if($rows -> num_rows > 0){
    while ($row = mysqli_fetch_assoc($rows)) {
        $hourlyResult .= '<tr>';
        $hourlyResult .= '<td>'.$row['loc_name'].'</td>';
        $hourlyResult .= '<td>'.$row['renttime'].'</td>';
        $hourlyResult .= '<td>'.$row['s'].'</td>';
        $hourlyResult .= '</tr>';
        }
    } else {
      $hourlyResult .= '<td colspan="3"> 검색 결과가 없습니다! </td>';
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
    <h3> 검색하신 "<?=$rentplace ?>" 장소의 시간대 별 이용정보입니다. </h3>
    <table border=1>
      <tr>
          <th> 대여소명 </th>
          <th> 시간 </th>
          <th> 이용건수 </th>
      </tr>
      <?= $hourlyResult ?>
    </table>
    <br>
    * 시간과 이용건수: 해당 시간부터 1시간 내 대여 건수의 합입니다.
    <br>
    * 데이터는 최대 30개의 결과만 제공합니다.
  </body>

</html>
