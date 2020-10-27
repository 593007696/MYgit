<?php 
$year = date ( 'Y' );   //获得年份, 例如： 2006  
$month = date ( 'n' );  //获得月份, 例如： 04  
$day = date ( 'j' );    //获得日期, 例如： 3  
$firstDay = date ( "w", mktime ( 0, 0, 0, $month, 1, $year ) );  
                                        //获得当月第一天星期几
$daysInMonth = date ( "t", mktime ( 0, 0, 0, $month, 1, $year ) );  
                                        //获得当月的总天数  
//echo $daysInMonth;  
$tempDays = $firstDay + $daysInMonth;   //计算数组中的日历表格数  
$weeksInMonth = ceil ( $tempDays/7 );   //算出该月一共有几周（即表格的行数）  
//创建一个二维数组
$counter=0;
for($j = 0; $j < $weeksInMonth; $j ++) {  
    for($i = 0; $i < 7; $i ++) {
          
        $counter ++;  
        $week [$j] [$i] = $counter;  
        //offset the days  
        $week [$j] [$i] -= $firstDay;  
        if (($week [$j] [$i] < 1) || ($week [$j] [$i] > $daysInMonth)) {  
            $week [$j] [$i] = "";  
        }  
    }  
}  
?> 
 
<table width="400" border="1" cellpadding="2" cellspacing="2"> 
    <tr> 
        <th colspan='7'> 
            <?php 
            echo $year." ";
            echo date ( 'M', mktime ( 0, 0, 0, $month, 1, $year ) ) ;  
            ?> 
        </th> 
    </tr> 
    <tr> 
        <th>日</th> 
        <th>月</th> 
        <th>火</th> 
        <th>水</th> 
        <th>木</th> 
        <th>金</th> 
        <th>土</th> 
    </tr> 
<?php 
foreach ( $week as $key => $val ) {  
    echo "<tr>";  
    for($i = 0; $i < 7; $i ++) {  
        echo "<td align='center'>" . $val [$i] . "</td>";  
    }  
    echo "</tr>";  
}  
?> 