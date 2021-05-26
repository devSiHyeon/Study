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