--order 要吃的資料
SELECT
    SUM(td.amount) as expected_amount,
    u.virtual_account as virtual_account,
    u.user_id as user_id
FROM
    tender_documents AS td
LEFT JOIN claims AS c
ON
    c.claim_id = td.claim_id
LEFT JOIN users AS u
ON
    u.user_id = td.user_id
WHERE
    c.claim_state = 2 AND td.is_order_create = 0
GROUP BY
    u.user_id
--拉 claim.state =2 的 所有 tender_id
SELECT
	td.tender_documents_id,
FROM
    tender_documents AS td
LEFT JOIN claims AS c
ON
    c.claim_id = td.claim_id

WHERE
    c.claim_state = 2 AND td.is_order_create = 0


--
SELECT
	c.claim_id,
	td.tender_documents_id,
    td.is_order_create,
    td.order_id,
    u.user_id,
    u.virtual_account
FROM
    tender_documents AS td
LEFT JOIN claims AS c
ON
    c.claim_id = td.claim_id
LEFT JOIN users AS u
ON
    u.user_id = td.user_id
WHERE
    c.claim_id = 12

---
UPDATE
    claims AS c
LEFT JOIN tender_documents AS td
ON
    td.claim_id = c.claim_id
SET
    c.claim_state = 2,
    td.is_order_create = 0,
    td.order_id = null
where
 c.claim_id = 12
