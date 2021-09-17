-- claim.start_collecting_at  開標日
-- claim.is_pre_invest  預先投標開關
-- claim.staging_amount 預先投標上限金額
-- claim.is_auto_closed 自動結標開關
-- claim.claim_state 債權狀態
/* -------------------------------------------------------------------------- */
-- 查詢 相關狀態
SELECT
    c.claim_id,
    c.claim_state,
    c.start_collecting_at,
    c.is_pre_invest,
    c.staging_amount,
    c.is_auto_closed,
    td.tender_documents_id,
    td.amount,
    (
    SELECT
        SUM(amount)
    FROM
        tender_documents
    WHERE
        claim_id = 12
) AS '投標總額'
FROM
    `claims` AS c
LEFT JOIN tender_documents AS td
ON
    c.claim_id = td.claim_id
WHERE
    c.claim_id = 12
GROUP BY
    td.tender_documents_id
/* -------------------------------------------------------------------------- */
-- 更新 現在時間 > 開標日
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    c.claim_id = td.claim_id
SET
    c.start_collecting_at = DATE_SUB(CURDATE(), INTERVAL 1 DAY) ,
    c.claim_state = 1
WHERE
    c.claim_id = 12

/* -------------------------------------------------------------------------- */
-- 更新 現在時間 < 開標日 且 is_pre_invest !=1
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    c.claim_id = td.claim_id
SET
    c.start_collecting_at = DATE_SUB(CURDATE(), INTERVAL -1 DAY),
    c.is_pre_invest = 2,
    c.claim_state = 0
WHERE
    c.claim_id = 12
/* -------------------------------------------------------------------------- */
-- 更新 現在時間 < 開標日
-- is_pre_invest =1
-- 已投標總和 不等於 預先投標上限
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    c.claim_id = td.claim_id
SET
    c.start_collecting_at = DATE_SUB(CURDATE(), INTERVAL -1 DAY),
    c.is_pre_invest = 1,
    c.claim_state = 0,
    c.staging_amount =(
    SELECT
        SUM(amount)
    FROM
        tender_documents
    WHERE
        claim_id = 12
) + 100
WHERE
    c.claim_id = 12
/* -------------------------------------------------------------------------- */
-- 更新 現在時間 < 開標日
-- is_pre_invest =1
-- 已投標總和 等於 預先投標上限
-- is_auto_closed != 1
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    c.claim_id = td.claim_id
SET
    c.start_collecting_at = DATE_SUB(CURDATE(), INTERVAL -1 DAY),
    c.is_pre_invest = 1,
    c.claim_state = 0,
    c.staging_amount =(
    SELECT
        SUM(amount)
    FROM
        tender_documents
    WHERE
        claim_id = 12
),
c.is_auto_closed = 2
WHERE
    c.claim_id = 12
/* -------------------------------------------------------------------------- */
-- 更新為能跑完 State 0 的狀態
-- 更新 現在時間 < 開標日
-- is_pre_invest =1
-- 已投標總和 等於 預先投標上限
-- is_auto_closed = 1
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    c.claim_id = td.claim_id
SET
    c.start_collecting_at = DATE_SUB(CURDATE(), INTERVAL -1 DAY),
    c.is_pre_invest = 1,
    c.claim_state = 0,
    c.staging_amount =(
    SELECT
        SUM(amount)
    FROM
        tender_documents
    WHERE
        claim_id = 12
),
c.is_auto_closed = 1
WHERE
    c.claim_id = 12
