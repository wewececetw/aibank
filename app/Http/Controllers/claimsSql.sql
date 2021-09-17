DELIMITER
    $$
DROP FUNCTION IF EXISTS
    getSpacielDate $$
CREATE FUNCTION getSpacielDate(exceptDate DATE) RETURNS DATE BEGIN
SET GLOBAL log_bin_trust_function_creators = 1;


        SET @exceptDate = exceptDate;
        SET @a := IFNULL(
            DATE_FORMAT(
                "2020-03-19 12:00:00",
                "%Y-%m-%d %H:%i-%s"
            ),
            (
            SELECT
                DATE_ADD(
                    DATE(
                        DATE_ADD(
                            @exceptDate,
                            INTERVAL `value` DAY
                        )
                    ),
                    INTERVAL '10:00:00' HOUR_SECOND
                )
            FROM
                system_variables
            WHERE
                variable_name = 'opened'
        )
        );
        return @a;
    END $$
DELIMITER
    ;
INSERT INTO claims(
    claim_state,
    staged_at,
    original_claim_amount,
    periods,
    staging_amount,
    remaining_periods,
    risk_category,
    annual_interest_rate,
    min_amount,
    max_amount,
    management_fee_rate,
    description,
    agreement_buyer,
    agreement_buyer_clause,
    launched_at,
    serial_number,
    typing,
    repayment_method,
    auto_close_threshold,
    debtor_transferor,
    borrower,
    id_number,
    gender,
    age,
    education,
    marital_state,
    place_of_residence,
    living_state,
    industry,
    job_title,
    seniority,
    monthly_salary,
    guarantor,
    pig_credit,
    id_number_effective,
    peer_blacklist,
    rehabilitated_settlement,
    ticket_state,
    major_traffic_fines,
    peer_query_count,
    start_collecting_at,
    estimated_close_date,
    value_date,
    payment_final_deadline,
    note,
    `foreign`,
    commission_interest_rate,
    seller_name,
    seller_address,
    seller_responsible_person,
    seller_id_number,
    agent_name,
    agent_address,
    agent_responsible_person,
    agent_id_number,
    is_pre_invest,
    pre_invest_min_amount,
    is_auto_closed,
    is_display,
    number_of_sales,
    claim_number
)
SELECT
    "0",
    @staged_at := IFNULL(
        DATE_FORMAT("43907", "%Y-%m-%d %H:%i-%s"),
        DATE_FORMAT(
            CURRENT_TIMESTAMP(), "%Y-%m-%d %H:%i-%s")
        ),
        "5000",
        "20",
        "53000",
        "10",
        @risk_category := "S",
        "8",
        "1000",
        "5000",
        "1",
        "付押租金",
        "亞太普惠金融科技股份有限公司",
        "1. 逾期債權買回結算日為逾期起始的第40日。 2. 買回給付日為逾期起始的第45日內。 3. 剩餘債權本金100%買回，給付原始債權逾期起始日至債權買回結算日的利息，未滿一期以一期計算。 4. 原債權案件債務人提前全數清償時，結算剩餘本金100%買回，利息不足一期以一期計算，於清償日後5日內結算買回。5. 債權轉讓人未依前項約定買回時，由亞洲信用管理股份有限公司實施債權保全及回收款分配。",
        @launched_at := IFNULL(
            DATE_FORMAT("43907", "%Y-%m-%d %H:%i-%s"),
            DATE_FORMAT(
                CURRENT_TIMESTAMP(), "%Y-%m-%d %H:%i-%s")
            ),
            @serial_number := "888",
            "租房押金分期付款",
            "先息後本",
            "100",
            "亞太普惠金融科技股份有限公司",
            "蕭名崴",
            "D123025661",
            "男",
            "21",
            "高中",
            "未婚",
            "新北市",
            "未揭露",
            "未揭露",
            "助理工程師",
            "未揭露",
            "3萬",
            "無",
            "C",
            "正常",
            "正常",
            "正常",
            "正常",
            "無",
            "1",
            @start_collecting_at := getSpacielDate(@launched_at),
            @estimated_close_date := IFNULL(
                DATE_FORMAT(
                    "43908.260416667",
                    "%Y-%m-%d %H:%i-%s"
                ),
                (
                SELECT
                    DATE_ADD(
                        DATE(
                            DATE_ADD(
                                @launched_at,
                                INTERVAL `value` DAY
                            )
                        ),
                        INTERVAL '23:59:59' HOUR_SECOND
                    )
                FROM
                    system_variables
                WHERE
                    variable_name = 'closed'
            )
            ),
            @value_date := IFNULL(
                DATE_FORMAT(
                    "43908.260416667",
                    "%Y-%m-%d %H:%i-%s"
                ),
                (
                SELECT
                    DATE_ADD(
                        DATE(
                            DATE_ADD(
                                @launched_at,
                                INTERVAL `value` DAY
                            )
                        ),
                        INTERVAL '00:00:00' HOUR_SECOND
                    )
                FROM
                    system_variables
                WHERE
                    variable_name = 'repayment'
            )
            ),
            @payment_final_deadline := IFNULL(
                DATE_FORMAT(
                    "43908.260416667",
                    "%Y-%m-%d %H:%i-%s"
                ),
                (
                SELECT
                    DATE_ADD(
                        DATE(
                            DATE_ADD(
                                @launched_at,
                                INTERVAL `value` DAY
                            )
                        ),
                        INTERVAL '23:59:59' HOUR_SECOND
                    )
                FROM
                    system_variables
                WHERE
                    variable_name = 'payment_final_deadline'
            )
            ),
            "你好",
            "1",
            "0.02",
            "亞太普惠金融科技股份有限公司",
            "台北市中山區錦州街46號9樓之6",
            "唐正峰",
            "54188852",
            "null",
            "null",
            "null",
            "null",
            "1",
            "10000",
            "1",
            "0",
            @number_of_sales := "1",
            CONCAT(
                @risk_category,
                @serial_number,
                @number_of_sales
            )
