<?php
header("Content-Type: text/html; charset=UTF-8");

    $link = mysqli_connect('localhost', "t04dbp", "t042020dbp!", 't04dbp');
    $filtered = array(
      'ticket' => mysqli_real_escape_string($link, $_POST['ticket'])
    );

    $query = "SELECT rent_name, SUM(rent_used) AS 'used_amount'
      FROM bike_tb
      WHERE rent_code = '{$filtered['ticket']}'
      GROUP BY rent_name
      ORDER BY used_amount
      DESC limit 10";

    $result = mysqli_query($link, $query);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($link));
        exit();
    }

    $article = '';
    while ($row = mysqli_fetch_array($result)) {
        $article .= '<tr><td>';
        $article .= $row['rent_name'];
        $article .= '</td><td>';
        $article .= $row['used_amount'];
        $article .= '</td></tr>';
    }
    mysqli_close($link);
?>

<!DOCTYPE html>
<html>

</head>
<body>
        <h2><a href="index.html"> 서울시 따릉이 정보 </a> |  대여권 별 대여소 TOP 10</h2>
    <table border='1'>
            <tr>
                <th>대여소명</th>
                <th>대여건수</th>
            </tr>
            <?=$article?>
        </table>
</body>
</html>
