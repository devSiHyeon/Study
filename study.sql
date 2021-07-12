-- INSERT
    INSERT INTO tb_name
    SET
        sql name = '$변수'
        name = '$name'
    ;    

-- SELECT
    -- ASC : 오름차순(1 → 10) / DESC : 내림차순(10 → 1)
        SELECT *                
        FROM tb_name
        ORDER BY name ASC  
        ;     

-- UPDATE
        UPDATE tb_name
        SET
            sql name = '$변수'
            name = '$name'
        WHERE id = '{$id}'
        LIMIT 1
        ;

-- DELETE
        DELETE
        FROM tb_name
        WHERE id = '{$delete_file}'
        ;

-- UNION & UNION ALL & LEFT JOIN 
    -- UNION : 중복생략 / UNION ALL : 전체
    -- LEFT JOIN : 왼쪽의 테이블을 기준으로 join 해라

    SELECT
                    dp.title AS department,
                    em.name AS name,
                    sub.employee_idx,
                    COUNT(*) AS cnt
    FROM
                    (                                   -- 테이블명 들어갈 부분에 괄호 묶어서 조건
                        SELECT idx AS employee_idx
                        FROM jfm_employee

                        UNION ALL

                        SELECT employee_idx
                        FROM jfm_process_worker
                        WHERE process_idx = '1'
                    ) sub                               -- 임의 파일명

                    LEFT JOIN jfm_employee em           -- em : 임의 파일명
                    ON sub.employee_idx = em.idx

                    LEFT JOIN jfm_department dp         -- dp : 임의 파일명
                    ON em.department_idx = dp.idx

    GROUP BY sub.employee_idx
    ORDER BY cnt DESC

-- 정렬번호 만들기 (목차 순서 변경시 임의 번호)
    -- 전체 INSERT
    $sql = "
                    INSERT INTO tb_name
                    SET
                            product_idx = '{$product_idx}',
                            -- sort = '{$temp_no}'
    ";
    $result = $db->query($sql);
    $lastInsertID = $db->lastInsertID();

    -- 정렬번호
    $sql = "
                    UPDATE tb_name
                    SET sort = '{$lastInsertID}'
                    WHERE idx = '{$lastInsertID}'
    ";

-- JOIN 쿼리

-- UNION 쿼리

-- SUB 쿼리

-- 날짜 지정 
    https://extbrain.tistory.com/29

    $timestamp_d = strtotime("-1 days");        -- 하루 전 (어제)
    $timestamp_d = strtotime("+1 days");        -- 하루 뒤 (내일)
    $timestamp_m = strtotime("-2 months");      -- 두 달 전
    $timestamp_m = strtotime("-1 years");       -- 1년 전

    -- 삭제
        SELECT * FROM copy WHERE DATE_FORMAT(create_date, '%Y-%m') = '2021-05'

        DELETE 
        FROM copy 
        WHERE DATE_FORMAT(create_date, '%Y-%m') = '2021-05'
-- VIEW 쿼리

-- 프로시저

-- fetchAll & fetchArray
    fetchAll : 
    fetchArray : 결과를 배열로 나열

-- 목록 위, 아래버튼 클릭 시 변수 이동 (바꾸려는 값 추출하여 B번호 SELECT, UPDATE - A번호 이동, B번호 이동) 
    // 위 idx, sort 추출
    $sql = "
                SELECT idx, sort
                FROM jfm_product_process
                WHERE sort IN (
                        SELECT MAX(sort) AS sort
                        FROM jfm_product_process
                        WHERE
                                            product_idx = '{$product_idx}'
                                            AND sort < '{$current_sort}'
                        ORDER BY sort ASC, idx DESC
                )
    ";
    
    $result = $db->query($sql)->fetchArray();
    $next_idx = $result['idx'];     // 바껴야하는 대상의 idx
    $next_sort = $result['sort'];   // 바껴야하는 대상의 sort


