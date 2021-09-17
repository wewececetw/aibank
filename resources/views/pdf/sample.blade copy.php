<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta name="generator" content="Aspose.Words for .NET 17.1.0.0" />
    <title>信任豬智能債權媒合平台</title>
    <style>
        td {
            border-style: solid;
            border-width: 0.75pt;
        }

        table {
            border-collapse: collapse
        }

        .specialText {
            font-family: 'simsun';
            font-size: 10pt;
            color: #0070c0;
            background-color: #d8d8d8;
            height: 10pt;
            margin: 0pt;
        }

        .test {}

    </style>
</head>

<body style="font-family: simsun;white-space:normal">
    <div>
        <span class="test">hello</span>
        <span class="test">hello2</span>
        <p style="margin:0pt 140.5pt 0pt 142.5pt; text-align:center; line-height:25.55pt; widows:0; orphans:0"><span
                style="font-family:'simsun'; font-size:22pt">信任豬智能債權媒合平台</span><br /><span
                style="font-family:'simsun'; font-size:22pt">債權讓</span><span
                style="font-family:'simsun'; font-size:22pt">售</span><span
                style="font-family:'simsun'; font-size:22pt">協議書</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:17pt"><span
                style="font-family:'simsun'">&#xa0;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:17pt"><span
                style="font-family:'simsun'">                                       </span><span
                style="font-family:'simsun'">                                        </span><span
                style="font-family:'simsun'; font-size:10pt">  </span><span
                style="font-family:'simsun'; font-size:10pt">債權憑證編號</span><span
                style="font-family:'simsun'; font-size:10pt">:</span>
            <span class="specialText">P123123456456</span>
        </p>
        <p
            style="margin-top:0pt; margin-left:22.5pt; margin-bottom:0pt; text-indent:-22.5pt; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">壹、</span><span style="font:7pt 'Times New Roman'"> </span><span
                style="font-family:'simsun'">當事人</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">&#xa0;</span></p>
        <table cellspacing="0" cellpadding="0" style="border-collapse:collapse">
            <tr style="height:53.7pt">
                <td
                    style="width:122.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">買受人(即受讓人)</span>
                    </p>
                </td>
                <td
                    style="width:386pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle">
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span class="specialText">{{ $user->user_name }}</span>
                        <span style="font-family:'simsun'; font-size:10pt">(下稱甲方)</span>

                    </p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">豬豬在線帳號：</span><a
                            href="mailto:{{ $user->email }}" style="text-decoration:none"><span class="specialText"
                                style="text-decoration:underline;">{{ $user->email }}</span>
                        </a>
                    </p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">證件字號：</span><span
                            class="specialText">{{ $user->id_card_number }}</span>
                    </p>
                </td>
            </tr>
            <tr style="height:70.75pt">
                <td
                    style="width:122.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt">
                        <span>出賣人(即讓與人)</span>
                    </p>
                </td>
                <td
                    style="width:386pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle">
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span class="specialText">{{ $claim->seller_name }}</span><span
                            style="font-family:'simsun'; font-size:10pt">（下稱乙方）</span>
                    </p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">地址：</span><span
                            class="specialText">{{ $claim->seller_address }}</span>
                    </p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">負責人：</span><span
                            class="specialText">{{ $claim->seller_responsible_person }}</span>
                    </p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">證件字號：</span><span
                            class="specialText">{{ $claim->seller_id_number }}</span>
                    </p>
                </td>
            </tr>
            <tr style="height:63.3pt">
                <td
                    style="width:122.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">債權讓售代理人</span>
                    </p>
                </td>
                <td
                    style="width:386pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle">
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span class="specialText">{{ $claim->agent_name }}</span>
                    </p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">地址：</span><span
                            class="specialText">{{$claim->agent_address}}</span>
                    </p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">負責人：</span><span
                            class="specialText">{{ $claim->agent_responsible_person }}</span>
                    </p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt"> 證件字號：</span><span
                            class="specialText">{{ $claim->agent_id_number }}</span>
                    </p>
                </td>
            </tr>
            <tr style="height:76.95pt">
                <td
                    style="width:122.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                            style="font-family:'simsun'">居</span><span style="font-family:'simsun'">間</span><span
                            style="font-family:'simsun'">人</span></p>
                </td>
                <td
                    style="width:386pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle">
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">信任豬股份有限公司（下稱丙方） </span></p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">網站平台名稱：豬豬在線債權媒合平台 (</span><a
                            href="http://www.pponline.com.tw" style="text-decoration:none"><span
                                style="font-family:'simsun'; font-size:10pt; text-decoration:underline; color:#0000ff">www.pponline.com.tw</span></a><span
                            style="font-family:'simsun'; font-size:10pt">) </span></p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">地址：台北市中山區錦州街46號9樓之6 </span></p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">負責人：李家福 </span></p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">證</span><span
                            style="font-family:'simsun'; font-size:10pt">件</span><span
                            style="font-family:'simsun'; font-size:10pt">字</span><span
                            style="font-family:'simsun'; font-size:10pt">號</span><span
                            style="font-family:'simsun'; font-size:10pt">：54179376</span></p>
                </td>
            </tr>
            <tr style="height:63.2pt">
                <td
                    style="width:122.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                            style="font-family:'simsun'">債</span><span style="font-family:'simsun'">權</span><span
                            style="font-family:'simsun'">管</span><span style="font-family:'simsun'">理</span><span
                            style="font-family:'simsun'">人</span></p>
                </td>
                <td
                    style="width:386pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle">
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">亞</span><span
                            style="font-family:'simsun'; font-size:10pt">洲</span><span
                            style="font-family:'simsun'; font-size:10pt">信</span><span
                            style="font-family:'simsun'; font-size:10pt">用</span><span
                            style="font-family:'simsun'; font-size:10pt">管</span><span
                            style="font-family:'simsun'; font-size:10pt">理</span><span
                            style="font-family:'simsun'; font-size:10pt">股</span><span
                            style="font-family:'simsun'; font-size:10pt">份</span><span
                            style="font-family:'simsun'; font-size:10pt">有</span><span
                            style="font-family:'simsun'; font-size:10pt">限</span><span
                            style="font-family:'simsun'; font-size:10pt">公</span><span
                            style="font-family:'simsun'; font-size:10pt">司</span></p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">地</span><span
                            style="font-family:'simsun'; font-size:10pt">址：</span><span
                            style="font-family:'simsun'; font-size:10pt">新</span><span
                            style="font-family:'simsun'; font-size:10pt">北</span><span
                            style="font-family:'simsun'; font-size:10pt">市</span><span
                            style="font-family:'simsun'; font-size:10pt">汐</span><span
                            style="font-family:'simsun'; font-size:10pt">止</span><span
                            style="font-family:'simsun'; font-size:10pt">區</span><span
                            style="font-family:'simsun'; font-size:10pt">新</span><span
                            style="font-family:'simsun'; font-size:10pt">台</span><span
                            style="font-family:'simsun'; font-size:10pt">五</span><span
                            style="font-family:'simsun'; font-size:10pt">路1</span><span
                            style="font-family:'simsun'; font-size:10pt">段10</span><span
                            style="font-family:'simsun'; font-size:10pt">6</span><span
                            style="font-family:'simsun'; font-size:10pt">號8</span><span
                            style="font-family:'simsun'; font-size:10pt">樓</span></p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">負</span><span
                            style="font-family:'simsun'; font-size:10pt">責</span><span
                            style="font-family:'simsun'; font-size:10pt">人</span><span
                            style="font-family:'simsun'; font-size:10pt">：</span><span
                            style="font-family:'simsun'; font-size:10pt">李</span><span
                            style="font-family:'simsun'; font-size:10pt">元</span><span
                            style="font-family:'simsun'; font-size:10pt">正</span></p>
                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:12pt; widows:0; orphans:0">
                        <span style="font-family:'simsun'; font-size:10pt">證</span><span
                            style="font-family:'simsun'; font-size:10pt">件</span><span
                            style="font-family:'simsun'; font-size:10pt">字</span><span
                            style="font-family:'simsun'; font-size:10pt">號</span><span
                            style="font-family:'simsun'; font-size:10pt">：</span><span
                            style="font-family:'simsun'; font-size:10pt">70559817</span></p>
                </td>
            </tr>
        </table>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">&#xa0;</span></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">貳、前</span><span style="font-family:'simsun'">  </span><span
                style="font-family:'simsun'">言</span></p>
        {{--  --}}
        {{-- <p style="margin-left:10px"><strong>一、豬豬在線債權媒合平台網站(www.pponline.com.tw)為丙方所開發及擁有，提供信用諮詢、債權買賣</strong></p>
        <p>
            讓與、債權交易居間媒合及其他相關聯之服務。乙方擬將標的債權(定義詳本協議約定條款第二條標的債
            權之內容)出售並轉讓與甲方，甲方則擬買受並受讓標的債權。
        </p> --}}

        {{--  --}}
        <p style="margin:1.3pt 10pt 0pt 22pt; text-indent:-22pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">一、</span><span style="font-family:'simsun'">豬豬在線債權媒合平台網站</span><span
                style="font-family:'simsun'">(www.pponline.com.tw)為丙方所開發及擁有，提供信用諮詢、債權買</span><span
                style="font-family:'simsun'">賣</span></p>
        <p style="margin:1.3pt 10pt 0pt 22pt; text-indent:-22pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">讓與、債權交易居間媒合及其他相關聯之服務。乙方擬將標的債權</span><span
                style="font-family:'simsun'">(定義詳本協議約定條款第二條</span><span style="font-family:'simsun'">標的債</span></p>
        <p style="margin:1.3pt 10pt 0pt 22pt; text-indent:-22pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">權之內容</span><span
                style="font-family:'simsun'">)出售並轉讓與甲方，甲方則擬買受並受讓標的債權。</span></p>
        <p style="margin:1.3pt 10pt 0pt 22pt; text-indent:-22pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">二、甲方透過豬豬在線債權媒合平台網站有關之規則和說明，進行標的債權之購買等相關操作，並同意及</span></p>
        <p style="margin:1.3pt 10pt 0pt 22pt; text-indent:-22pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">確認本協議之所有約定。</span></p>
        <p style="margin:1.3pt 10pt 0pt 22pt; text-indent:-22pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">三、甲乙丙三方爰約定條款如下，俾資遵循。</span><br /></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">參</span><span style="font-family:'simsun'">、</span><span
                style="font-family:'simsun'">約定條款</span></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">一、</span><span style="font-family:'simsun'"> </span><span
                style="font-family:'simsun'">債權讓與媒合說明：</span></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">1. 本協議書（下稱“本協議”）由甲乙丙三方於中華民國 </span><span
                style="font-family:'simsun'; color:red; background-color:#d8d8d8">不確定(暫時先放)</span><span
                style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">{{ date('Y',strtotime($claim->value_date))}}</span><span
                style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8"> </span><span
                style="font-family:'simsun'">年 </span><span
                style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">{{ date('m',strtotime($claim->value_date))}}
            </span><span style="font-family:'simsun'">月 </span><span
                style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">{{ date('d',strtotime($claim->value_date))}}
            </span><span style="font-family:'simsun'">日所約定。</span></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">2. 本協議係由甲乙丙三方使用丙方所設立之豬豬在線債權媒合平台網站的債權讓與服務，根據豬豬在線</span></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">債權媒合平台服務合約、隱私條款及其他相關協議自願達成約定。</span></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">3. 使用本協議之甲方與乙方已事先閱讀、充分了解並認可豬豬在線債權媒合平台所提供之本協議。</span></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">4. 本協議採用電子合約形式，其效力受中華民國法律保護，與紙本合約有同一效力。</span></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">5. 甲方及乙方茲各自聲明與保證，其為具有民法上完全行為能力之自然人，或合法設立登記之法人或團</span></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">體，並承諾其提供給丙方的資訊是完全真實，無任何虛偽或隱瞞</span><span
                style="font-family:'simsun'">。</span><br /></p>
        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">二</span><span style="font-family:'simsun'">、</span><span
                style="font-family:'simsun'"> </span><span
                style="font-family:'simsun'">買賣標的債權(下稱標的債權)為於豬豬在線債權媒合平台網站揭示之編號</span><span
                style="font-family:'simsun'; background-color:#d8d8d8">[ </span><span
                style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">{{ $claim->claim_number }}</span><span
                style="font-family:'simsun'; background-color:#d8d8d8"> ]</span><span
                style="font-family:'simsun'">債權(下稱原債權)之一 部，其相關資訊如下：</span></p>
        <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;word-break:break-all;">
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">原債權之金額、債務人、擔保品等</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8"><?php
                            $name = number_format((float)$claim->original_claim_amount, 0, '.', ',') . "、";
                            $name .= mb_substr($claim->borrower,0,1,'utf-8');
                            $starCount = mb_strlen($claim->borrower,"utf-8")-1;
                            for ($x=0;$x < $starCount;$x++) {
                                $name .= '*';
                            }
                            echo $name;
                        ?></span></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">原債權金額出售範圍</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span
                            style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">{{ number_format($claim->max_amount, 0, '.', ',') }}</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">標的債權之買賣價金</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span
                            style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">{{ number_format($amount, 0, '.', ',') }}</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">標的債權占原債權之比例</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">
                            @if(isset($claim->original_claim_amount))
                            {{ round(($amount/$claim->original_claim_amount)*100,4) }}%
                            @else
                            0%
                            @endif
                        </span></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">標的債權讓與日期(交割日)</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">
                            {{ date('Y-m-d',strtotime($claim->value_date)) }}
                        </span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">標的債權之回收期間</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span
                            style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">{{ date('Y-m-d',strtotime($claim->value_date)) }}
                            ~
                            {{ date("Y-m-d", strtotime("+$claim->periods month", strtotime($claim->value_date))) }}</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">標的債權年化收益</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span
                            style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">{{ $claim->annual_interest_rate }}%</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">VIP 專屬回饋</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span
                            style="font-family:'simsun'; color:red; background-color:#d8d8d8">{{$claim->major_traffic_fines}}</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">甲方預定回收之標的債權本金及利息總額</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">4,255,826</span></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">給付方式</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">金融機構匯款</span></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">丙方之平台服務費</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">25583</span></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:50pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">買回條款</span></p>
                </td>
                <td
                    style="width:100pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">1.
                            逾期債權買回結算日為逾期起始的第40日。</span></p>
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">2. 買回給付日</span><span
                            style="font-family:'simsun'; color:#0070c0; background-color:#d8d8d8">為逾期起始的第45日內。</span>
                    </p>
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style=" color:#0070c0; background-color:#d8d8d8">3. 剩餘債權本金100%買回，</span><br>
                        <span
                            style=" color:#0070c0; background-color:#d8d8d8;margin-left:16pt;">給付原始債權逾期起始日至債權買回結算日的利息，</span><br>
                        <span style=" color:#0070c0; background-color:#d8d8d8;margin-left:16pt;">未滿一期以一期計算。</span>
                    </p>
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt;word-break:break-all;">
                        <span style="background-color:#d8d8d8;color:#0070c0;">4. 原債權案件債務人提前全數清償時，結算剩餘本金100%</span><br>
                        <span
                            style="background-color:#d8d8d8;color:#0070c0;margin-left:16pt;">買回，利息不足一期以一期計算，於清償日後5日內結算買回。</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2"
                    style="width:519pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">乙方代收標的債權後，按附表一(下稱明細表)所示金額經由丙方給付甲方。</span></p>
                </td>
            </tr>
        </table>
        <table>

        </table>




        <p
            style="margin-top:1.3pt; margin-right:10pt; margin-bottom:0pt; line-height:113%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">&#xa0;</span></p>
        <h2 style="margin-top:0.7pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">三、</span><span
                style="font-family:'simsun'; font-weight:normal"> </span><span
                style="font-family:'simsun'; font-weight:normal">各方權利和義務</span></h2>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">1. </span><span
                style="font-family:'simsun'">甲方同意以上述標的債權之買賣價金向乙方購買標的債權，並應於丙方指定之期間將價金交付丙方，</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">由丙方轉付乙方。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">2. 有下列任一狀況發生時，視為本協議解除條件之成就，本協議書失其效力，若當時甲方已支付買賣價</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">金者，乙方應自行或指示丙方（於丙方已經收取甲方給付之買賣價金但尚未交付乙方之情形）返還甲方。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">2.1 於豬豬在線債權媒合平台網站所揭示之原債權之認購期間內，實際總認購金額未達該網頁揭示</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">之最低金額者。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">2.2 實際總認購金額雖達該網頁揭示之最低金額，惟於買賣價金繳納期限內甲方及/或其他債權認購</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">人有未足額繳納買賣價金之情事。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">3. 甲方享有標的債權之相關權利及依本協議約定所得享有之收益，並應主動向稅捐機關申報及繳納前述</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">收益所產生的所得稅費。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">4. 甲方同意乙方代其收取買賣標的債</span><span
                style="font-family:'simsun'">權之每期本金及利息，按期給付甲方如明細表所示之各項金額，並</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">由乙方先行交付丙方，再由丙方依據上開明細表所載於扣除甲方應給付丙方之平台服務費後交付甲方。甲</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">方同意乙方自標的債權之債務人所收取超過明細表所示各項金額之餘款，逕行抵充甲方</span><span
                style="font-family:'simsun'">應給付乙方之委任</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">報酬款。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">5. 甲方於受讓標的債權後，甲乙雙方同意標的債權及其擔保、從屬、隨附之權利及所產生之請求權由甲</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">方全數委託乙方仍以債權人之身分主張之。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">6. 甲方同意乙方有權代甲方在必要時對債務人進行標的債權的違約提醒及催收工作，包括但不限於電話</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">通知、上</span><span
                style="font-family:'simsun'">門通知、發律師函、發支付命令、執行本票裁定及強制執行、對債務人提起訴訟、拍賣擔保品</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">等。甲方在此確認委託乙方為其進行以上工作，並同意授權乙方及丙方得將此工作再行委託給其他專業合</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">法的催收公司或資產管理公司進行標的債權保全等必要措施。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">7. 甲方</span><span
                style="font-family:'simsun'">於持有標的債權之期間內，無條件同意不得將標的債權再行轉讓予乙、丙以外之第三人，但經由</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">乙方及丙方同意者不在此限。如有違反，甲方除應就乙方因而所生之一切損害，負擔賠償責任外，並應給</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">付相當於標的債權金額二倍之懲罰性違約金予乙方。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">8. 甲方承諾其對依據本協議獲得的乙方、丙方及債務人之資訊或資料應予以保</span><span
                style="font-family:'simsun'">密，無正當理由，不得向</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">外披露。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">9. 於乙方因任何情事發生而無法繼續執行本協議的各項權利及義務時，甲方同意乙方委託亞洲信用管理</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">股份有限公司或其他專業合法的資產管理公司全權代乙方處理之。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">10. 甲方充分了解債</span><span
                style="font-family:'simsun'">務人享有分期之利益，故自受讓標的債權後，除債務人主動提前清償外，甲方不得以</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">任何理由要求債務人提前償還或要求解除本債權讓售協議。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">11. 乙方同意由丙方代為收取甲方應給付予乙方之標的債權買賣價金，丙方於收取後最遲三個營業日內應</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">如數轉付給乙方。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">12. 乙方應擔保標的債權於本協議約</span><span
                style="font-family:'simsun'">定時並無一權二賣之重複買賣情事、設定負擔或其他權利瑕疵之情</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">事。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">13. 標的債權之債務人如有未依約或遲延償還之情事，乙方應立即通知甲方。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">14. 如乙方於豬豬在線債權媒合平台網站中載明其願於標的債權之債務人有遲延償還之情事時以特定金額</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">買回標的債權者，乙方有權並應依照其揭示之買回日期向甲方買回未獲清償之標的債權，乙方買回之價金</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">為本協議中標的債權如明細表所示之尚未回收本金金額之一定成數（該成數以乙方於豬豬在線債權媒合平</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">台網站中揭示者為準，併參本協議約定條款二），並應給付結算至標的債權買回日止如明細表所示的利息</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">給甲方</span><span
                style="font-family:'simsun'">(利息未滿一期者以一期計算之)。若於豬豬在線債權媒合平台網站中未揭示前述之買回條款者，甲</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">方同意就前述已陷於遲延之標的債權及其</span><span
                style="font-family:'simsun'">擔保、從屬、隨附之權利及所產生之請求權，全數委由乙方以債</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">權人身分轉委託給亞洲信用管理股份有限公司，而由該公司以債權人之受託人身分主張及處理後續債權催</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">收、保全、回收及後續通知分配等事項，甲方並同意支付債權回收金額的</span><span
                style="font-family:'simsun'">30%予亞洲信用管理股份有限公</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">司為其提供上開服務之報酬。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">15. 乙方違反前兩項約定，致甲方或丙方之權益受有損害者，乙方應負損害賠償之責。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">16. 如標的債權之債務人自願提前清償者，乙方應於最後一次收取標的債權之本金及利息後，依明細表所</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">載給付甲方尚未回收本金之金額，及截至乙方最後一次收取標的</span><span
                style="font-family:'simsun'">債權本金及利息之日止之利息</span><span style="font-family:'simsun'">(其中，利</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">息未滿一期者以一期計算之</span><span
                style="font-family:'simsun'">)。為杜疑義，除本協議另有約定外，於標的債權之債務人提前清償之日後，</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">甲方就明細表所載之權利均視為拋棄。</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">&#xa0;</span></p>
        <p style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">四</span><span style="font-family:'simsun'">、</span><span
                style="font-family:'simsun'">服務費</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">1. 在本協議中，因丙方為甲方提供債權資訊諮詢、債權信用及還款評估、還款代收、還款特殊情況溝通</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">報告及訂約等相關服務（統稱</span><span style="font-family:'simsun'">“</span><span
                style="font-family:'simsun'">債權轉讓媒合服務</span><span style="font-family:'simsun'">”</span><span
                style="font-family:'simsun'">）及帳戶管理之服務，甲方同意支付丙方服</span><span style="font-family:'simsun'">務費。</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">2. 在本協議中，使用會員是指與丙方訂定服務合約，註冊於豬豬在線債權媒合平台網站，得以丙方所核</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">發之豬豬在線債權媒合平台網路帳戶使用丙方所提供之交易、代收、代付、居間媒合服務及其他經主管機</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">關核准業務之成員。</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">3. 丙方有權就所提供之服務向相對應之甲方及乙方收取各項居間仲介費、管理費和(或)服務費。各種收費</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">項目，依豬豬在線債權媒合平台網站所載或相應方之協議為之。</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">4. 甲方使用本服務時，丙方向甲方收取之平台服務費將自明細表中之各期應給付利息中扣除，此平台服</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">務費，丙方將依本協議明細表中的總利息金額</span><span
                style="font-family:'simsun'">，以約定費率（</span><span
                style="font-family:'simsun'">10%），四捨五入至整數位後計算總應收服</span>
        </p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">務費金額，並平均攤入明細表中每期利息支付日時扣取，各個當期的平均攤計服務費金額如小於新台幣</span><span
                style="font-family:'simsun'">1</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">元，則以新台幣</span><span
                style="font-family:'simsun'">1元計算，逐期累計的服務費金額已等於總應收服務費後，往後期數則不再計收服務費。</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">5. 丙方有權隨時調整本服務之各項服務費，調整後之服務費將公告刊載於本服務相關網頁上，並自其所</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">訂定之生效日期起生效，不另行個別通知。若會員不同意調整後之服務費，應即停止使用本服務，如使用</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">會員繼續使用本服務，即視為已同意調整後之服務費。</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'">&#xa0;</span></p>
        <h2 style="margin-top:0.65pt; margin-right:5pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">五</span><span
                style="font-family:'simsun'; font-weight:normal">、</span><span
                style="font-family:'simsun'; font-weight:normal">違約責任</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">1. 本協議各方均應嚴格履行本協議約定之義務，非經各方協商一致或依</span><span
                style="font-family:'simsun'; font-weight:normal">照本協議約定，任何一方不得解</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">除本協議。</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">2. 任何一方違約，違約方應承擔因違約使得其他各方產生的費用和損失，包括但不限於調查、訴訟費、</span>
        </h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">律師費等，應由違約方承擔。</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">3. 因可歸責於甲方之事由致甲方或乙方提前解除本協議時，乙方有權要求甲方支付因此產生的相關費</span>
        </h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">用，乙方得從應按期給付給甲方之標的債權本金及利息中扣除相關費用後給付予甲方。</span><span
                style="font-family:'simsun'; font-weight:normal">(費用內容依豬豬</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">在線債權媒合平台網站所載</span><span
                style="font-family:'simsun'; font-weight:normal">)</span></h2>
        <h2 style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">&#xa0;</span></h2>
        <h2 style="margin-top:0pt; margin-right:5pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">六</span><span
                style="font-family:'simsun'; font-weight:normal">、</span><span
                style="font-family:'simsun'; font-weight:normal">法律適用及爭議解決</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">1. 本協議如有未盡事宜，悉依中華民國民法及其他相關法令解決之。</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">2. 本協議的約定、履行、終止、解釋均適用中華民國法律。</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">3. 本協議在履行過程中，如發生任何爭執或糾紛，各方應友好協商解決；若協商不成，因本協議所生之</span>
        </h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">一切爭議，合約當事人同意以臺灣臺北地方法院為第一審合意管轄法院。</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">4. 丙方擁有對本協議的最終解釋權。</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">&#xa0;</span></h2>
        <h2 style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">七</span><span
                style="font-family:'simsun'; font-weight:normal">、</span><span
                style="font-family:'simsun'; font-weight:normal">附則</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">1. 各方可經由協議對本協議作出修改和補充。本協議的修改和補充經過各方之同意後具有契約同等的法</span>
        </h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">律效力。</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">2. 本協議及其修改或補充均採用透過豬豬在線債權媒合平台網站以電子合約形式製成，可以有一份或多</span>
        </h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">份，並且每份具有同等法律效力，並永久保存在丙方為此設立的專用伺服器</span><span
                style="font-family:'simsun'; font-weight:normal">(或雲端伺服器)上備查和保</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">管。各方均同意該形式之協議效力，如</span><span
                style="font-family:'simsun'; font-weight:normal">對協議內容有爭議，各方均同意以豬豬在線債權媒合平台網站資料</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">庫上所保留文檔版本解釋為準。甲乙丙三方並同意本債權讓售協議書及相關債權法律文件亦將以電子合約</span>
        </h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">形式保存於亞洲信用管理股份有限公司所設立的專用伺服器</span><span
                style="font-family:'simsun'; font-weight:normal">(或雲端伺服器)上供備查和保管，並為後續債</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">權保全及催收等使用。</span></h2>
        <h2 style="margin:1.35pt 5pt 0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">3. 如果本協議中的任何條款違反適用的法律或法規，則該條將被視為無效，但該無效條款並不影響本協</span>
        </h2>
        <h2 style="margin-top:1.35pt; margin-left:5pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">議其他條款的效力。</span><br /></h2>
        <h2 style="margin-top:1.35pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt"><span
                style="font-family:'simsun'; font-weight:normal">八</span><span
                style="font-family:'simsun'; font-weight:normal">、</span><span
                style="font-family:'simsun'; font-weight:normal">特別聲明：</span></h2>
        <p
            style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">豬豬在線債權媒合平台僅單純提供使用會員認購債權之媒合服務，並不自行或協助債權讓與人向不特定人收受 存款或受託經理信託資金，</span><span
                style="font-family:'simsun'">債權讓與人及使用會員均不得利用本平台從事違反銀行法第 29 條第 1 項規定:除法
                律另有規定者外，非銀行不得經營收受存款、受託經理信託資金、公眾財產或辦理國內外匯兌業務之行為，否 則應自負相關法律責任！</span></p>
        <p
            style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">&#xa0;</span></p>
        <table cellspacing="0" cellpadding="0" style="border-collapse:collapse">
            <tr style="height:79.15pt">
                <td
                    style="width:120pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">居</span><span style="font-family:'simsun'">間</span><span
                            style="font-family:'simsun'">人</span><span style="font-family:'simsun'">用</span><span
                            style="font-family:'simsun'">印</span><span style="font-family:'simsun'">章：</span></p>
                </td>
                <td
                    style="width:120pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">&#xa0;</span></p>
                </td>
                <td
                    style="width:120pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">債</span><span style="font-family:'simsun'">權</span><span
                            style="font-family:'simsun'">管</span><span style="font-family:'simsun'">理</span><span
                            style="font-family:'simsun'">人</span><span style="font-family:'simsun'">用</span><span
                            style="font-family:'simsun'">印</span><span style="font-family:'simsun'">章：</span></p>
                </td>
                <td
                    style="width:120pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">&#xa0;</span></p>
                </td>
            </tr>
        </table>
        <p
            style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">&#xa0;</span></p>
        <p
            style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">附表一：標的債權回收明細表</span></p>
        <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
            <tr>
                <td
                    style="width:10pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">期數</span></p>
                </td>
                <td
                    style="width:10pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">日期</span></p>
                </td>
                <td
                    style="width:10pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">甲方就標的債權回收之本金</span></p>
                </td>
                <td
                    style="width:10pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">甲方就標的債權回收之利息</span></p>
                </td>
                <td
                    style="width:10pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">丙方之平台服務費</span></p>
                </td>
            </tr>
            @foreach($money['everyMonthPrincipal'] as $k => $v)
            <tr>
                <td
                    style="width:10pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">{{ $k+1 }}</span></p>
                </td>
                <td
                    style="width:10pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">{{ $timeArray[$k] }}</span></p>
                </td>
                <td
                    style="width:10pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">{{ $money['everyMonthPrincipal'][$k] }}</span></p>
                </td>
                <td
                    style="width:10pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">{{ $money['everyMonthInterest'][$k] }}</span></p>
                </td>
                <td
                    style="width:10pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top">
                    <p
                        style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
                        <span style="font-family:'simsun'">{{ $managmentFee[$k] }}</span></p>
                </td>
            </tr>
            @endforeach
        </table>
        <p
            style="margin-top:1.3pt; margin-right:5.95pt; margin-bottom:0pt; line-height:117%; widows:0; orphans:0; font-size:10pt">
            <span style="font-family:'simsun'">&#xa0;</span></p>


    </div>
</body>

</html>
