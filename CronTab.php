<?
global $db;

// 어제 날짜 값 구하기
$timestamp = strtotime("-1 days");
$date = date("Y-m-d", $timestamp); 

// INSERT : backup 데이터 파일에 입력하기 
// SELECT : 어제 날짜의 데이터 구하기 
// WHERE : 현재의 날짜 = '{어제 날짜 }'

$sql = "
    INSERT INTO a_backup
    (
        create_date,
        category,
        value1,
        value2,
        value3,
        value4,
        value5
    )
    SELECT
            create_date,
            category,
            value1,
            value2,
            value3,
            value4,
            value5
    FROM a
    WHERE DATE_FORMAT(create_date, '%Y-%m-%d') = '{$date}'
";

?>