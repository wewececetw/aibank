-- claim.start_collecting_at 開標日
-- claim.closed_at 預計結標日

/* -------------------------------------------------------------------------- */
-- 查詢 相關狀態
SELECT
    c.claim_id,
    c.claim_state,
    c.start_collecting_at,
    c.closed_at,
    c.estimated_close_date,
    c.staging_amount,
    c.auto_close_threshold,
    c.is_auto_closed,
    td.tender_documents_id,
    td.tender_document_state,
    (
    SELECT
        SUM(amount)
    FROM
        tender_documents
    WHERE
        claim_id = 12
) AS total_amount,
(
    SELECT
        auto_close_threshold * 0.01 * staging_amount
    FROM
        claims
    WHERE
        claim_id = 12
) AS min_auto_close_amount,
(
    (
    SELECT
        SUM(amount)+100
    FROM
        tender_documents
    WHERE
        claim_id = 12
) /(c.auto_close_threshold * 0.01)
) AS '期望Staging_amount'
FROM
    claims AS c
LEFT JOIN tender_documents AS td
ON
    td.claim_id = c.claim_id
WHERE
    c.claim_id = 12

/* -------------------------------------------------------------------------- */
-- 更新為 轉state 6 狀態
-- 不符合 開標日 <= 現在 < 預計結標日
-- 現在 < 預計結標日
-- 現在 > 開標日

/* -------------------------------------------------------------------------- */
-- 更新為 轉state 1 狀態
-- 不符合 開標日 <= 現在 < 預計結標日
-- 現在 < 預計結標日
-- 現在 < 開標日
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    c.claim_id = td.claim_id
SET
    c.claim_state = 1,
    c.closed_at = DATE_SUB(CURDATE(), INTERVAL -1 DAY),
    c.start_collecting_at = DATE_SUB(CURDATE(), INTERVAL -1 DAY)
WHERE
    c.claim_id = 12

/* -------------------------------------------------------------------------- */
-- 更新為 流標
-- 不符合 開標日 <= 現在 < 預計結標日
-- 現在 >= 預計結標日
UPDATE
    tender_documents
SET
    tender_document_state = 1
WHERE
    claim_id = 12;
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    td.claim_id = c.claim_id
SET
    c.claim_state = 1,
    c.closed_at = DATE_SUB(CURDATE(), INTERVAL 1 DAY),
    c.start_collecting_at = DATE_SUB(CURDATE(), INTERVAL -1 DAY),
    c.staging_amount =(
        (
        SELECT
            SUM(amount) +100
        FROM
            tender_documents
        WHERE
            claim_id = 12
    ) /(c.auto_close_threshold * 0.01)
    )
WHERE
    c.claim_id = 12
/* -------------------------------------------------------------------------- */
-- 更新為 轉狀態2
-- 不符合 開標日 <= 現在 < 預計結標日
-- 現在 >= 預計結標日
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    td.claim_id = c.claim_id
SET
    c.claim_state = 1,
    c.closed_at = DATE_SUB(CURDATE(), INTERVAL 1 DAY),
    c.start_collecting_at = DATE_SUB(CURDATE(), INTERVAL -1 DAY),
    c.is_auto_closed = 1,
    c.staging_amount =(
        (
        SELECT
            SUM(amount)
        FROM
            tender_documents
        WHERE
            claim_id = 12
    ) /(c.auto_close_threshold * 0.01)
    )
WHERE
    c.claim_id = 12
/* -------------------------------------------------------------------------- */
-- 更新為 轉狀態2
-- 開標日 <= 現在 < 預計結標日
UPDATE
    tender_documents
SET
    tender_document_state = 1
WHERE
    claim_id = 12;

UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    td.claim_id = c.claim_id
SET
    c.claim_state = 1,
    c.estimated_close_date = DATE_SUB(CURDATE(), INTERVAL -3 DAY),
    c.start_collecting_at = DATE_SUB(CURDATE(), INTERVAL 3 DAY),
    c.is_auto_closed = 1,
    c.staging_amount =(
        (
        SELECT
            SUM(amount) - 10
        FROM
            tender_documents
        WHERE
            claim_id = 12
    ) /(c.auto_close_threshold * 0.01)
    )
WHERE
    c.claim_id = 12
