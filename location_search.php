<?php
    $link = mysqli_connect("localhost", "t04dbp", "t042020dbp!", "t04dbp");

    if(mysqli_connect_error()) {
        echo "MySQL connect failed";
        echo "<br>";
        echo mysqli_connect_error();
        exit();
    }

    // $gu = $_GET['search'];
    $filtered_gu = mysqli_real_escape_string($link, $_GET['search']);

    $query = "
        SELECT loc_id, loc_name, gu, details, type, if (type = 'LCD', lcd, qr) as '수량'
        FROM location
        WHERE gu ='" $filtered_gu "'";

    $result = mysqli_query($link, $query);

    $article = '';
    while ($row = mysqli_fetch_array($result)) {
        $article .= '<tr><td>';
        $article .= $row['loc_id'];
        $article .= '</td><td>';
        $article .= $row['loc_name'];
        $article .= '</td><td>';
        $article .= $row['gu'];
        $article .= '</td><td>';
        $article .= $row['details'];
        $article .= '</td><td>';
        $article .= $row['type'];
        $article .= '</td><td>';
        $article .= $row['수량'];
        $article .= '</td></tr>';
    }

    mysqli_free_result($result);
    mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> 서울시 따릉이 대여소 위치 안내 </title>
    <style>
        body{
            font-family: Consolas, monospace;
            font-family: 12px;
        }
        table{
            width: 100%;
        }
        th,td{
            padding: 10px;
            border-bottom: 1px solid #dadada;
        }
    </style>
</head>
<body>
        <h2><a href="index.html"> 서울시 따릉이 정보 </a> | 따릉이 대여소 위치 안내 </h2>
        <table>
            <tr>
                <th>loc_id</th>
                <th>loc_name</th>
                <th>gu</th>
                <th>details</th>
                <th>type</th>
                <th>수량</th>
            </tr>
            <?= $article ?>
        </table>
</body>
</html>