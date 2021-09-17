
// WWW中文縣市鄉鎮選單(不含全區)     2018/6/23 上午 02:31:06

var districtList = {
    "臺北市":[],
    "新北市":[],
    "桃園市":[], 
    "臺中市":[], 
    "臺南市":[], 
    "高雄市":[], 
    "基隆市":[],
    "新竹市":[], 
    "嘉義市":[], 
    "新竹縣":[], 
    "苗栗縣":[], 
    "彰化縣":[], 
    "南投縣":[], 
    "雲林縣":[], 
    "嘉義縣":[], 
    "屏東縣":[],
    "宜蘭縣":[], 
    "花蓮縣":[], 
    "臺東縣":[], 
    "澎湖縣":[],
    "金門縣":[],
    "連江縣":[]
}

districtList["基隆市"].push("仁愛區");
districtList["基隆市"].push("信義區");
districtList["基隆市"].push("中正區");
districtList["基隆市"].push("中山區");
districtList["基隆市"].push("安樂區");
districtList["基隆市"].push("暖暖區");
districtList["基隆市"].push("七堵區");

districtList["臺北市"].push("中正區");
districtList["臺北市"].push("大同區");
districtList["臺北市"].push("中山區");
districtList["臺北市"].push("松山區");
districtList["臺北市"].push("大安區");
districtList["臺北市"].push("萬華區");
districtList["臺北市"].push("信義區");
districtList["臺北市"].push("士林區");
districtList["臺北市"].push("北投區");
districtList["臺北市"].push("內湖區");
districtList["臺北市"].push("南港區");
districtList["臺北市"].push("文山區");


districtList["新北市"].push("萬里區");
districtList["新北市"].push("金山區");
districtList["新北市"].push("板橋區");
districtList["新北市"].push("汐止區");
districtList["新北市"].push("深坑區");
districtList["新北市"].push("石碇區");
districtList["新北市"].push("瑞芳區");
districtList["新北市"].push("平溪區");
districtList["新北市"].push("雙溪區");
districtList["新北市"].push("貢寮區");
districtList["新北市"].push("新店區");
districtList["新北市"].push("坪林區");
districtList["新北市"].push("烏來區");
districtList["新北市"].push("永和區");
districtList["新北市"].push("中和區");
districtList["新北市"].push("土城區");
districtList["新北市"].push("三峽區");
districtList["新北市"].push("樹林區");
districtList["新北市"].push("鶯歌區");
districtList["新北市"].push("三重區");
districtList["新北市"].push("新莊區");
districtList["新北市"].push("泰山區");
districtList["新北市"].push("林口區");
districtList["新北市"].push("蘆洲區");
districtList["新北市"].push("五股區");
districtList["新北市"].push("八里區");
districtList["新北市"].push("淡水區");
districtList["新北市"].push("三芝區");
districtList["新北市"].push("石門區");

districtList["桃園市"].push("中壢區");
districtList["桃園市"].push("平鎮區");
districtList["桃園市"].push("龍潭區");
districtList["桃園市"].push("楊梅區");
districtList["桃園市"].push("新屋區");
districtList["桃園市"].push("觀音區");
districtList["桃園市"].push("桃園區");
districtList["桃園市"].push("龜山區");
districtList["桃園市"].push("八德區");
districtList["桃園市"].push("大溪區");
districtList["桃園市"].push("復興區");
districtList["桃園市"].push("大園區");
districtList["桃園市"].push("蘆竹區");

districtList["新竹市"].push("東區");
districtList["新竹市"].push("北區");
districtList["新竹市"].push("香山區");

districtList["新竹縣"].push("竹北市");
districtList["新竹縣"].push("湖口鄉");
districtList["新竹縣"].push("新豐鄉");
districtList["新竹縣"].push("新埔鎮");
districtList["新竹縣"].push("關西鎮");
districtList["新竹縣"].push("芎林鄉");
districtList["新竹縣"].push("寶山鄉");
districtList["新竹縣"].push("竹東鎮");
districtList["新竹縣"].push("五峰鄉");
districtList["新竹縣"].push("橫山鄉");
districtList["新竹縣"].push("尖石鄉");
districtList["新竹縣"].push("北埔鄉");
districtList["新竹縣"].push("峨眉鄉");

districtList["苗栗縣"].push("竹南鎮");
districtList["苗栗縣"].push("頭份市");
districtList["苗栗縣"].push("三灣鄉");
districtList["苗栗縣"].push("南庄鄉");
districtList["苗栗縣"].push("獅潭鄉");
districtList["苗栗縣"].push("後龍鎮");
districtList["苗栗縣"].push("通霄鎮");
districtList["苗栗縣"].push("苑裡鎮");
districtList["苗栗縣"].push("苗栗市");
districtList["苗栗縣"].push("造橋鄉");
districtList["苗栗縣"].push("頭屋鄉");
districtList["苗栗縣"].push("公館鄉");
districtList["苗栗縣"].push("大湖鄉");
districtList["苗栗縣"].push("泰安鄉");
districtList["苗栗縣"].push("銅鑼鄉");
districtList["苗栗縣"].push("三義鄉");
districtList["苗栗縣"].push("西湖鄉");
districtList["苗栗縣"].push("卓蘭鎮");

districtList["臺中市"].push("中區");
districtList["臺中市"].push("東區");
districtList["臺中市"].push("南區");
districtList["臺中市"].push("西區");
districtList["臺中市"].push("北區");
districtList["臺中市"].push("北屯區");
districtList["臺中市"].push("西屯區");
districtList["臺中市"].push("南屯區");
districtList["臺中市"].push("太平區");
districtList["臺中市"].push("大里區");
districtList["臺中市"].push("霧峰區");
districtList["臺中市"].push("烏日區");
districtList["臺中市"].push("豐原區");
districtList["臺中市"].push("后里區");
districtList["臺中市"].push("石岡區");
districtList["臺中市"].push("東勢區");
districtList["臺中市"].push("和平區");
districtList["臺中市"].push("新社區");
districtList["臺中市"].push("潭子區");
districtList["臺中市"].push("大雅區");
districtList["臺中市"].push("神岡區");
districtList["臺中市"].push("大肚區");
districtList["臺中市"].push("沙鹿區");
districtList["臺中市"].push("龍井區");
districtList["臺中市"].push("梧棲區");
districtList["臺中市"].push("清水區");
districtList["臺中市"].push("大甲區");
districtList["臺中市"].push("外埔區");
districtList["臺中市"].push("大安區");

districtList["彰化縣"].push("彰化市");
districtList["彰化縣"].push("芬園鄉");
districtList["彰化縣"].push("花壇鄉");
districtList["彰化縣"].push("秀水鄉");
districtList["彰化縣"].push("鹿港鎮");
districtList["彰化縣"].push("福興鄉");
districtList["彰化縣"].push("線西鄉");
districtList["彰化縣"].push("和美鎮");
districtList["彰化縣"].push("伸港鄉");
districtList["彰化縣"].push("員林市");
districtList["彰化縣"].push("社頭鄉");
districtList["彰化縣"].push("永靖鄉");
districtList["彰化縣"].push("埔心鄉");
districtList["彰化縣"].push("溪湖鎮");
districtList["彰化縣"].push("大村鄉");
districtList["彰化縣"].push("埔鹽鄉");
districtList["彰化縣"].push("田中鎮");
districtList["彰化縣"].push("北斗鎮");
districtList["彰化縣"].push("田尾鄉");
districtList["彰化縣"].push("埤頭鄉");
districtList["彰化縣"].push("溪州鄉");
districtList["彰化縣"].push("竹塘鄉");
districtList["彰化縣"].push("二林鎮");
districtList["彰化縣"].push("大城鄉");
districtList["彰化縣"].push("芳苑鄉");
districtList["彰化縣"].push("二水鄉");

districtList["南投縣"].push("南投市");
districtList["南投縣"].push("中寮鄉");
districtList["南投縣"].push("草屯鎮");
districtList["南投縣"].push("國姓鄉");
districtList["南投縣"].push("埔里鎮");
districtList["南投縣"].push("仁愛鄉");
districtList["南投縣"].push("名間鄉");
districtList["南投縣"].push("集集鎮");
districtList["南投縣"].push("水里鄉");
districtList["南投縣"].push("魚池鄉");
districtList["南投縣"].push("信義鄉");
districtList["南投縣"].push("竹山鎮");
districtList["南投縣"].push("鹿谷鄉");

districtList["雲林縣"].push("斗南鎮");
districtList["雲林縣"].push("大埤鄉");
districtList["雲林縣"].push("虎尾鎮");
districtList["雲林縣"].push("土庫鎮");
districtList["雲林縣"].push("褒忠鄉");
districtList["雲林縣"].push("東勢鄉");
districtList["雲林縣"].push("臺西鄉");
districtList["雲林縣"].push("崙背鄉");
districtList["雲林縣"].push("麥寮鄉");
districtList["雲林縣"].push("斗六市");
districtList["雲林縣"].push("林內鄉");
districtList["雲林縣"].push("古坑鄉");
districtList["雲林縣"].push("莿桐鄉");
districtList["雲林縣"].push("西螺鎮");
districtList["雲林縣"].push("二崙鄉");
districtList["雲林縣"].push("北港鎮");
districtList["雲林縣"].push("水林鄉");
districtList["雲林縣"].push("口湖鄉");
districtList["雲林縣"].push("四湖鄉");
districtList["雲林縣"].push("元長鄉");

districtList["嘉義市"].push("東區");
districtList["嘉義市"].push("西區");

districtList["嘉義縣"].push("番路鄉");
districtList["嘉義縣"].push("梅山鄉");
districtList["嘉義縣"].push("竹崎鄉");
districtList["嘉義縣"].push("阿里山鄉");
districtList["嘉義縣"].push("中埔鄉");
districtList["嘉義縣"].push("大埔鄉");
districtList["嘉義縣"].push("水上鄉");
districtList["嘉義縣"].push("鹿草鄉");
districtList["嘉義縣"].push("太保市");
districtList["嘉義縣"].push("朴子市");
districtList["嘉義縣"].push("東石鄉");
districtList["嘉義縣"].push("六腳鄉");
districtList["嘉義縣"].push("新港鄉");
districtList["嘉義縣"].push("民雄鄉");
districtList["嘉義縣"].push("大林鎮");
districtList["嘉義縣"].push("溪口鄉");
districtList["嘉義縣"].push("義竹鄉");
districtList["嘉義縣"].push("布袋鎮");

districtList["臺南市"].push("中西區");
districtList["臺南市"].push("東區");
districtList["臺南市"].push("南區");
districtList["臺南市"].push("北區");
districtList["臺南市"].push("安平區");
districtList["臺南市"].push("安南區");
districtList["臺南市"].push("永康區");
districtList["臺南市"].push("歸仁區");
districtList["臺南市"].push("新化區");
districtList["臺南市"].push("左鎮區");
districtList["臺南市"].push("玉井區");
districtList["臺南市"].push("楠西區");
districtList["臺南市"].push("南化區");
districtList["臺南市"].push("仁德區");
districtList["臺南市"].push("關廟區");
districtList["臺南市"].push("龍崎區");
districtList["臺南市"].push("官田區");
districtList["臺南市"].push("麻豆區");
districtList["臺南市"].push("佳里區");
districtList["臺南市"].push("西港區");
districtList["臺南市"].push("七股區");
districtList["臺南市"].push("將軍區");
districtList["臺南市"].push("學甲區");
districtList["臺南市"].push("北門區");
districtList["臺南市"].push("新營區");
districtList["臺南市"].push("後壁區");
districtList["臺南市"].push("白河區");
districtList["臺南市"].push("東山區");
districtList["臺南市"].push("六甲區");
districtList["臺南市"].push("下營區");
districtList["臺南市"].push("柳營區");
districtList["臺南市"].push("鹽水區");
districtList["臺南市"].push("善化區");
districtList["臺南市"].push("大內區");
districtList["臺南市"].push("山上區");
districtList["臺南市"].push("新市區");
districtList["臺南市"].push("安定區");

districtList["高雄市"].push("新興區");
districtList["高雄市"].push("前金區");
districtList["高雄市"].push("苓雅區");
districtList["高雄市"].push("鹽埕區");
districtList["高雄市"].push("鼓山區");
districtList["高雄市"].push("旗津區");
districtList["高雄市"].push("前鎮區");
districtList["高雄市"].push("三民區");
districtList["高雄市"].push("楠梓區");
districtList["高雄市"].push("小港區");
districtList["高雄市"].push("左營區");
districtList["高雄市"].push("仁武區");
districtList["高雄市"].push("大社區");
districtList["高雄市"].push("東沙群島");
districtList["高雄市"].push("南沙群島");
districtList["高雄市"].push("岡山區");
districtList["高雄市"].push("路竹區");
districtList["高雄市"].push("阿蓮區");
districtList["高雄市"].push("田寮區");
districtList["高雄市"].push("燕巢區");
districtList["高雄市"].push("橋頭區");
districtList["高雄市"].push("梓官區");
districtList["高雄市"].push("彌陀區");
districtList["高雄市"].push("永安區");
districtList["高雄市"].push("湖內區");
districtList["高雄市"].push("鳳山區");
districtList["高雄市"].push("大寮區");
districtList["高雄市"].push("林園區");
districtList["高雄市"].push("鳥松區");
districtList["高雄市"].push("大樹區");
districtList["高雄市"].push("旗山區");
districtList["高雄市"].push("美濃區");
districtList["高雄市"].push("六龜區");
districtList["高雄市"].push("內門區");
districtList["高雄市"].push("杉林區");
districtList["高雄市"].push("甲仙區");
districtList["高雄市"].push("桃源區");
districtList["高雄市"].push("那瑪夏區");
districtList["高雄市"].push("茂林區");
districtList["高雄市"].push("茄萣區");

districtList["屏東縣"].push("屏東市");
districtList["屏東縣"].push("三地門鄉");
districtList["屏東縣"].push("霧臺鄉");
districtList["屏東縣"].push("瑪家鄉");
districtList["屏東縣"].push("九如鄉");
districtList["屏東縣"].push("里港鄉");
districtList["屏東縣"].push("高樹鄉");
districtList["屏東縣"].push("鹽埔鄉");
districtList["屏東縣"].push("長治鄉");
districtList["屏東縣"].push("麟洛鄉");
districtList["屏東縣"].push("竹田鄉");
districtList["屏東縣"].push("內埔鄉");
districtList["屏東縣"].push("萬丹鄉");
districtList["屏東縣"].push("潮州鎮");
districtList["屏東縣"].push("泰武鄉");
districtList["屏東縣"].push("來義鄉");
districtList["屏東縣"].push("萬巒鄉");
districtList["屏東縣"].push("崁頂鄉");
districtList["屏東縣"].push("新埤鄉");
districtList["屏東縣"].push("南州鄉");
districtList["屏東縣"].push("林邊鄉");
districtList["屏東縣"].push("東港鎮");
districtList["屏東縣"].push("琉球鄉");
districtList["屏東縣"].push("佳冬鄉");
districtList["屏東縣"].push("新園鄉");
districtList["屏東縣"].push("枋寮鄉");
districtList["屏東縣"].push("枋山鄉");
districtList["屏東縣"].push("春日鄉");
districtList["屏東縣"].push("獅子鄉");
districtList["屏東縣"].push("車城鄉");
districtList["屏東縣"].push("牡丹鄉");
districtList["屏東縣"].push("恆春鎮");
districtList["屏東縣"].push("滿州鄉");

districtList["臺東縣"].push("臺東市");
districtList["臺東縣"].push("綠島鄉");
districtList["臺東縣"].push("蘭嶼鄉");
districtList["臺東縣"].push("延平鄉");
districtList["臺東縣"].push("卑南鄉");
districtList["臺東縣"].push("鹿野鄉");
districtList["臺東縣"].push("關山鎮");
districtList["臺東縣"].push("海端鄉");
districtList["臺東縣"].push("池上鄉");
districtList["臺東縣"].push("東河鄉");
districtList["臺東縣"].push("成功鎮");
districtList["臺東縣"].push("長濱鄉");
districtList["臺東縣"].push("太麻里鄉");
districtList["臺東縣"].push("金峰鄉");
districtList["臺東縣"].push("大武鄉");
districtList["臺東縣"].push("達仁鄉");

districtList["花蓮縣"].push("花蓮市");
districtList["花蓮縣"].push("新城鄉");
districtList["花蓮縣"].push("秀林鄉");
districtList["花蓮縣"].push("吉安鄉");
districtList["花蓮縣"].push("壽豐鄉");
districtList["花蓮縣"].push("鳳林鎮");
districtList["花蓮縣"].push("光復鄉");
districtList["花蓮縣"].push("豐濱鄉");
districtList["花蓮縣"].push("瑞穗鄉");
districtList["花蓮縣"].push("萬榮鄉");
districtList["花蓮縣"].push("玉里鎮");
districtList["花蓮縣"].push("卓溪鄉");
districtList["花蓮縣"].push("富里鄉");

districtList["宜蘭縣"].push("宜蘭市");
districtList["宜蘭縣"].push("頭城鎮");
districtList["宜蘭縣"].push("礁溪鄉");
districtList["宜蘭縣"].push("壯圍鄉");
districtList["宜蘭縣"].push("員山鄉");
districtList["宜蘭縣"].push("羅東鎮");
districtList["宜蘭縣"].push("三星鄉");
districtList["宜蘭縣"].push("大同鄉");
districtList["宜蘭縣"].push("五結鄉");
districtList["宜蘭縣"].push("冬山鄉");
districtList["宜蘭縣"].push("蘇澳鎮");
districtList["宜蘭縣"].push("南澳鄉");
districtList["宜蘭縣"].push("釣魚臺");

districtList["澎湖縣"].push("馬公市");
districtList["澎湖縣"].push("西嶼鄉");
districtList["澎湖縣"].push("望安鄉");
districtList["澎湖縣"].push("七美鄉");
districtList["澎湖縣"].push("白沙鄉");
districtList["澎湖縣"].push("湖西鄉");

districtList["金門縣"].push("金沙鎮");
districtList["金門縣"].push("金湖鎮");
districtList["金門縣"].push("金寧鄉");
districtList["金門縣"].push("金城鎮");
districtList["金門縣"].push("烈嶼鄉");
districtList["金門縣"].push("烏坵鄉");

districtList["連江縣"].push("南竿鄉");
districtList["連江縣"].push("北竿鄉");
districtList["連江縣"].push("莒光鄉");
districtList["連江縣"].push("東引鄉");

