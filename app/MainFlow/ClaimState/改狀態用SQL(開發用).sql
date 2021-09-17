--查詢狀態0 claims
SELECT
    c.start_collecting_at AS '開標日',
    c.is_pre_invest AS '欲投標',
    c.is_auto_closed AS '自動關閉',
    c.claim_state AS claim_state,
    c.auto_close_threshold AS '關閉%數',
    c.staging_amount
FROM
    claims AS c
WHERE
    claim_id = 12

--更新為 State 0 能跑完的狀態 但不包含 tender_document ，要能跑到結標 還需要調整 tender_document amount
    --讓 claim 底下所有的 tenders amount 加總後 = $total ，
    --orginale_claim_amount * auto_close_threshold % <= $total <= orginale_claim_amount 才會過
UPDATE
    claims
SET
    start_collecting_at = DATE_SUB(curdate(),INTERVAL -1 DAY) ,
    is_pre_invest = 1,
    is_auto_closed = 1,
    claim_state = 0,
    auto_close_threshold = 90
WHERE
   claim_id = 12

--查看 State1 債權狀態
SELECT
    c.claim_id,
    c.claim_state,
    c.start_collecting_at,
    c.closed_at,
    c.is_auto_closed,
    c.staging_amount,
    ((c.staging_amount * c.auto_close_threshold) /100) as min_closed,
    td.tender_documents_id,
    td.tender_document_state,
    td.amount
FROM
    `claims` c
LEFT JOIN tender_documents AS td
ON td.claim_id = c.claim_id
WHERE
    c.claim_id = 12

--更新為 State1 能跑倒轉state2 狀態
UPDATE
    claims as c
left join tender_documents AS td
ON
    c.claim_id = td.claim_id
SET
    c.start_collecting_at = DATE_SUB(curdate(),INTERVAL 1 DAY) ,
    c.closed_at = DATE_SUB(curdate(),INTERVAL -1 DAY),
    c.is_pre_invest = 1,
    c.is_auto_closed = 1,
    c.claim_state = 1,
    c.auto_close_threshold = 90,
    td.tender_document_state = 1,
    c.staging_amount = 600
WHERE
   c.claim_id = 12

--更新為 State 1
UPDATE
    claims as c
left join tender_documents AS td
ON
    c.claim_id = td.claim_id
SET
    c.start_collecting_at = DATE_SUB(curdate(),INTERVAL 1 DAY) ,
    c.closed_at = DATE_SUB(curdate(),INTERVAL -1 DAY),
    c.is_pre_invest = 1,
    c.is_auto_closed = 1,
    c.claim_state = 1,
    c.auto_close_threshold = 90,
    td.tender_document_state = 1
WHERE
   c.claim_id = 12

-- 查詢 State2 狀態
SELECT
    c.claim_id,
    c.claim_state,
    c.closed_at,
    c.payment_final_deadline,
    c.value_date
FROM
    claims AS c
LEFT JOIN tender_documents AS td
ON
    td.claim_id = c.claim_id
WHERE
    c.claim_id = 12

-- 更新為 State 2 能跑完的狀態
UPDATE
    claims AS c
	LEFT JOIN tender_documents AS td
ON
    c.claim_id = td.claim_id
SET
    td.tender_document_state = '1',
    c.claim_state = 2,
    c.closed_at = DATE_SUB(curdate(),INTERVAL 1 DAY),
    c.payment_final_deadline = DATE_SUB(curdate(),INTERVAL -1 DAY)
WHERE
   c.claim_id = 12


-- 更新為 State 4 能跑完的狀態
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    c.claim_id = td.claim_id
LEFT JOIN tender_repayments AS tr
ON
    td.tender_documents_id = tr.tender_documents_id
SET
    td.tender_document_state = 2,
    c.claim_state = 4,
    tr.tender_repayment_state = 2
WHERE
    c.claim_id = 12

--更新為 State 4 並要寄送Email給PP人員的狀態
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    c.claim_id = td.claim_id
LEFT JOIN tender_repayments AS tr
ON
    td.tender_documents_id = tr.tender_documents_id
SET
    td.tender_document_state = 2,
    c.claim_state = 4,
    tr.tender_repayment_state = 1,
    tr.last_contact_pp_time = DATE_SUB(curdate(),INTERVAL 1 DAY)
WHERE
    c.claim_id = 12
