<?php
function xyz_em_string_To_Emoji($str,$xyz_em_emojis) {
    return strtr($str, $xyz_em_emojis);
}
$xyz_em_emojis = [
    
    
    '😀'        => '&#128512;',
    '😁'        => '&#128513;',
    '😂'        => '&#128514;',
    '😃'        => '&#128515;',
    '😄'        => '&#128516;',
    '😅'        => '&#128517;',
    '😆'        => '&#128518;',
    '😇'        => '&#128519;',
    '😈'        => '&#128520;',
    '😉'        => '&#128521;',
    '😊'        => '&#128522;',
    '😋'        => '&#128523;',
    '😌'        => '&#128524;',
    '😍'        => '&#128525;',
    '😎'        => '&#128526;',
    '😏'        => '&#128527;',
    '😐'        => '&#128528;',
    '😑'        => '&#128529;',
    '😒'        => '&#128530;',
    '😓'        => '&#128531;',
    '😔'        => '&#128532;',
    '😕'        => '&#128533;',
    '😖'        => '&#128534;',
    '😗'        => '&#128535;',
    '😘'        => '&#128536;',
    '😙'        => '&#128537;',
    '😚'        => '&#128538;',
    '😛'        => '&#128539;',
    '😜'        => '&#128540;',
    '😝'        => '&#128541;',
    '😞'        => '&#128542;',
    '😟'        => '&#128543;',
    '😠'        => '&#128544;',
    '😡'        => '&#128545;',
    '😢'        => '&#128546;',
    '😣'        => '&#128547;',
    '😤'        => '&#128548;',
    '😥'        => '&#128549;',
    '😦'        => '&#128550;',
    '😧'        => '&#128551;',
    '😨'        => '&#128552;',
    '😩'        => '&#128553;',
    '😪'        => '&#128554;',
    '😫'        => '&#128555;',
    '😬'        => '&#128556;',
    '😭'        => '&#128557;',
    '😮'        => '&#128558;',
    '😯'        => '&#128559;',
    '😰'        => '&#128560;',
    '😱'        => '&#128561;',
    '😲'        => '&#128562;',
    '😳'        => '&#128563;',
    '😴'        => '&#128564;',
    '😵'        => '&#128565;',
    '😶'        => '&#128566;',
    '😷'        => '&#128567;',
    '🙁'        => '&#128577;',
    '🙂'        => '&#128578;',
    '🙃'        => '&#128579;',
    '🙄'        => '&#128580;',
    '🤐'        => '&#129296;',
    '🤑'        => '&#129297;',
    '🤒'        => '&#129298;',
    '🤓'        => '&#129299;',
    '🤔'        => '&#129300;',
    '🤕'        => '&#129301;',
    '😸'        => '&#128568;',
    '😹'        => '&#128569;',
    '😺'        => '&#128570;',
    '😻'        => '&#128571;',
    '😼'        => '&#128572;',
    '😽'        => '&#128573;',
    '😾'        => '&#128574;',
    '😿'        => '&#128575;',
    '🙀'        => '&#128576;',
    
    '🙅'        => '&#128581;',
    '🙆'        => '&#128582;',
    '🙌'        => '&#128588;',
    '🙎'        => '&#128590;',
    '🙋'        => '&#128587;',
    
    '🙍'        => '&#128589;',
    '🙇'        => '&#128583;',
    
    '🙈'        => '&#128584;',
    '🙉'        => '&#128585;',
    '🙊'        => '&#128586;',
    
    
    '🙏'        => '&#128591;',
   
    
    
    
    '✊'        => '&#9994;',
    '✋'        => '&#9995;',
    '✌'        => '&#9996;',
    '✍'        => '&#9997;',
    
    '👆'        => '&#128070;',
    '👇'        => '&#128071;',
    '👈'        => '&#128072;',
    '👉'        => '&#128073;',
    '👊'        => '&#128074;',
    '👋'        => '&#128075;',
    '👌'        => '&#128076;',
    '👍'        => '&#128077;',
    '👎'        => '&#128078;',
    '👏'        => '&#128079;',
    '👐'        => '&#128080;',
    
    '👤'        => '&#128100;',
    '👥'        => '&#128101;',
    '👦'        => '&#128102;',
    '👧'        => '&#128103;',
    '👨'        => '&#128104;',
    '👩'        => '&#128105;',
    '👪'        => '&#128106;',
    '👫'        => '&#128107;',
    '👬'        => '&#128108;',
    '👭'        => '&#128109;',
    '👮'        => '&#128110;',
    '👯'        => '&#128111;',
    '👰'        => '&#128112;',
    '👱'        => '&#128113;',
    '👲'        => '&#128114;',
    '👳'        => '&#128115;',
    '👴'        => '&#128116;',
    '👵'        => '&#128117;',
    '👶'        => '&#128118;',
    '👷'        => '&#128119;',
    '👸'        => '&#128120;',
    '👹'        => '&#128121;',
    '👺'        => '&#128122;',
    '👻'        => '&#128123;',
    '👼'        => '&#128124;',
    '👽'        => '&#128125;',
    
    '🌬'        => '&#127788;',
    '🌭'        => '&#127789;',
    '🌮'        => '&#127790;',
    '🌯'        => '&#127791;',
    '🌰'        => '&#127792;',
    '🌱'        => '&#127793;',
    '🌲'        => '&#127794;',
    '🌳'        => '&#127795;',
    '🌴'        => '&#127796;',
    '🌵'        => '&#127797;',
    '🌶'        => '&#127798;',
    '🌷'        => '&#127799;',
    '🌸'        => '&#127800;',
    '🌹'        => '&#127801;',
    '🌺'        => '&#127802;',
    '🌻'        => '&#127803;',
    '🌼'        => '&#127804;',
    '🌽'        => '&#127805;',
    '🌾'        => '&#127806;',
    '🌿'        => '&#127807;',
    '🍀'        => '&#127808;',
    '🍁'        => '&#127809;',
    '🍂'        => '&#127810;',
    '🍃'        => '&#127811;',
    '🍄'        => '&#127812;',
    '🍅'        => '&#127813;',
    '🍆'        => '&#127814;',
    '🍇'        => '&#127815;',
    '🍈'        => '&#127816;',
    '🍉'        => '&#127817;',
    '🍊'        => '&#127818;',
    '🍋'        => '&#127819;',
    '🍌'        => '&#127820;',
    '🍍'        => '&#127821;',
    '🍎'        => '&#127822;',
    '🍏'        => '&#127823;',
    '🍐'        => '&#127824;',
    '🍑'        => '&#127825;',
    '🍒'        => '&#127826;',
    '🍓'        => '&#127827;',
    '🍔'        => '&#127828;',
    '🍕'        => '&#127829;',
    '🍖'        => '&#127830;',
    '🍗'        => '&#127831;',
    '🍘'        => '&#127832;',
    '🍙'        => '&#127833;',
    '🍚'        => '&#127834;',
    '🍛'        => '&#127835;',
    '🍜'        => '&#127836;',
    '🍝'        => '&#127837;',
    '🍞'        => '&#127838;',
    '🍟'        => '&#127839;',
    '🍠'        => '&#127840;',
    '🍡'        => '&#127841;',
    '🍢'        => '&#127842;',
    '🍣'        => '&#127843;',
    '🍤'        => '&#127844;',
    '🍥'        => '&#127845;',
    '🍦'        => '&#127846;',
    '🍧'        => '&#127847;',
    '🍨'        => '&#127848;',
    '🍩'        => '&#127849;',
    '🍪'        => '&#127850;',
    '🍫'        => '&#127851;',
    '🍬'        => '&#127852;',
    '🍭'        => '&#127853;',
    '🍮'        => '&#127854;',
    '🍯'        => '&#127855;',
    '🍰'        => '&#127856;',
    '🍱'        => '&#127857;',
    '🍲'        => '&#127858;',
    '🍳'        => '&#127859;',
    '🍴'        => '&#127860;',
    '🍵'        => '&#127861;',
    '🍶'        => '&#127862;',
    '🍷'        => '&#127863;',
    '🍸'        => '&#127864;',
    '🍹'        => '&#127865;',
    '🍺'        => '&#127866;',
    '🍻'        => '&#127867;',
    '🍼'        => '&#127868;',
    '🍽'        => '&#127869;',
    '🍾'        => '&#127870;',
    '🍿'        => '&#127871;',
    '🎀'        => '&#127872;',
    '🎁'        => '&#127873;',
    '🎂'        => '&#127874;',
    '⚪'        => '&#9898;',
    '⚫'        => '&#9899;',
    '⚽'        => '&#9917;',
    '⚾'        => '&#9918;',
    '⛄'        => '&#9924;',
    '⛅'        => '&#9925;',
    '⛎'        => '&#9934;',
    '⛏'        => '&#9935;',
    '⛑'        => '&#9937;',
    '⛓'        => '&#9939;',
    '⛔'        => '&#9940;',
    '⛩'        => '&#9961;',
    '⛪'        => '&#9962;',
    '⛰'        => '&#9968;',
    '⛱'        => '&#9969;',
    '⛲'        => '&#9970;',
    '⛳'        => '&#9971;',
    '⛴'        => '&#9972;',
    '⛵'        => '&#9973;',
    '⛷'        => '&#9975;',
    '⛸'        => '&#9976;',
    '⛹'        => '&#9977;',
    '⛺'        => '&#9978;',
    '⛽'        => '&#9981;',
    '✂'        => '&#9986;',
    '✅'        => '&#9989;', 
    '✈'        => '&#9992;',
    '✉'        => '&#9993;',
    
    '✏'        => '&#9999;',
    

    
    '🌀'        => '&#127744;',
    '🌁'        => '&#127745;',
    '🌂'        => '&#127746;',
    '🌃'        => '&#127747;',
    '🌄'        => '&#127748;',
    '🌅'        => '&#127749;',
    '🌆'        => '&#127750;',
    '🌇'        => '&#127751;',
    '🌈'        => '&#127752;',
    '🌉'        => '&#127753;',
    '🌊'        => '&#127754;',
    '🌋'        => '&#127755;',
    '🌌'        => '&#127756;',
    '🌍'        => '&#127757;',
    '🌎'        => '&#127758;',
    '🌏'        => '&#127759;',
    '🌐'        => '&#127760;',
    '🌑'        => '&#127761;',
    '🌒'        => '&#127762;',
    '🌓'        => '&#127763;',
    '🌔'        => '&#127764;',
    '🌕'        => '&#127765;',
    '🌖'        => '&#127766;',
    '🌗'        => '&#127767;',
    '🌘'        => '&#127768;',
    '🌙'        => '&#127769;',
    '🌚'        => '&#127770;',
    '🌛'        => '&#127771;',
    '🌜'        => '&#127772;',
    '🌝'        => '&#127773;',
    '🌞'        => '&#127774;',
    '🌟'        => '&#127775;',
    '🌠'        => '&#127776;',
    '🌡'        => '&#127777;',
    '🌤'        => '&#127780;',
    '🌥'        => '&#127781;',
    '🌦'        => '&#127782;',
    '🌧'        => '&#127783;',
    '🌨'        => '&#127784;',
    '🌩'        => '&#127785;',
    '🌪'        => '&#127786;',
    '🌫'        => '&#127787;',
    
    
    
   '🎵'        => '&#127925;',
    '🎶'        => '&#127926;',
    '🎷'        => '&#127927;',
    '🎸'        => '&#127928;',
    '🎹'        => '&#127929;',
    '🎺'        => '&#127930;',
    '🎻'        => '&#127931;',
    '🎼'        => '&#127932;',
    '🎽'        => '&#127933;',
    '🎾'        => '&#127934;',
    '🎿'        => '&#127935;',
    '🏀'        => '&#127936;',
    '🏁'        => '&#127937;',
    '🏂'        => '&#127938;',
    '🏃'        => '&#127939;',
    '🏄'        => '&#127940;',
    '🏅'        => '&#127941;',
    '🏆'        => '&#127942;',
    '🏇'        => '&#127943;',
    '🏈'        => '&#127944;',
    '🏉'        => '&#127945;',
    '🏊'        => '&#127946;',
    '🏋'        => '&#127947;',
    '🏌'        => '&#127948;',
    '🏍'        => '&#127949;',
    '🏎'        => '&#127950;',
    '🏏'        => '&#127951;',
    '🏐'        => '&#127952;',
    '🏑'        => '&#127953;',
    '🏒'        => '&#127954;',
    '🏓'        => '&#127955	;',
    
    '🐀'        => '&#128000;',
    '🐁'        => '&#128001;',
    '🐂'        => '&#128002;',
    '🐃'        => '&#128003;',
    '🐄'        => '&#128004;',
    '🐅'        => '&#128005;',
    '🐆'        => '&#128006;',
    '🐇'        => '&#128007;',
    '🐈'        => '&#128008;',
    '🐉'        => '&#128009;',
    '🐊'        => '&#128010;',
    '🐋'        => '&#128011;',
    '🐌'        => '&#128012;',
    '🐍'        => '&#128013;',
    '🐎'        => '&#128014;',
    '🐏'        => '&#128015;',
    '🐐'        => '&#128016;',
    '🐑'        => '&#128017;',
    '🐒'        => '&#128018;',
    '🐓'        => '&#128019;',
    '🐔'        => '&#128020;',
    '🐕'        => '&#128021;',
    '🐖'        => '&#128022;',
    '🐗'        => '&#128023;',
    '🐘'        => '&#128024;',
    '🐙'        => '&#128025;',
    '🐚'        => '&#128026;',
    '🐛'        => '&#128027;',
    '🐜'        => '&#128028;',
    '🐝'        => '&#128029;',
    '🐞'        => '&#128030;',
    '🐟'        => '&#128031;',
    '🐠'        => '&#128032;',
    '🐡'        => '&#128033;',
    '🐢'        => '&#128034;',
    '🐣'        => '&#128035;',
    '🐤'        => '&#128036;',
    '🐥'        => '&#128037;',
    '🐦'        => '&#128038;',
    '🐧'        => '&#128039;',
    '🐨'        => '&#128040;',
    '🐩'        => '&#128041;',
    '🐪'        => '&#128042;',
    '🐫'        => '&#128043;',
    '🐬'        => '&#128044;',
    '🐭'        => '&#128045;',
    '🐮'        => '&#128046;',
    '🐯'        => '&#128047;',
    '🐰'        => '&#128048;',
    '🐱'        => '&#128049;',
    '🐲'        => '&#128050;',
    '🐳'        => '&#128051;',
    '🐴'        => '&#128052;',
    '🐵'        => '&#128053;',
    '🐶'        => '&#128054;',
    '🐷'        => '&#128055;',
    '🐸'        => '&#128056;',
    '🐹'        => '&#128057;',
    '🐺'        => '&#128058;',
    '🐻'        => '&#128059;',
    '🐼'        => '&#128060;',
    '🐽'        => '&#128061;',
    '🐾'        => '&#128062;',
    '🐿'        => '&#128063;',
    '👀'        => '&#128064;',
    '👁'        => '&#128065;',
    '👂'        => '&#128066;',
    '👃'        => '&#128067;',
    '👄'        => '&#128068;',
    '👅'        => '&#128069;',
   
    '👑'        => '&#128081;',
    '👒'        => '&#128082;',
    '👓'        => '&#128083;',
    '👔'        => '&#128084;',
    '👕'        => '&#128085;',
    '👖'        => '&#128086;',
    '👗'        => '&#128087;',
    '👘'        => '&#128088;',
    
    '👚'        => '&#128090;',
    '👛'        => '&#128091;',
    '👜'        => '&#128092;',
    '👝'        => '&#128093;',
    '👞'        => '&#128094;',
    '👟'        => '&#128095;',
    '👠'        => '&#128096;',
    '👡'        => '&#128097;',
    '👢'        => '&#128098;',
    '👣'        => '&#128099;',
    
    '👾'        => '&#128126;',
    '👿'        => '&#128127;',
    '💀'        => '&#128128;',
    '💁'        => '&#128129;',
    '💂'        => '&#128130;',
    '💃'        => '&#128131;',
    '💄'        => '&#128132;',
    '💅'        => '&#128133;',
    '💆'        => '&#128134;',
    '💇'        => '&#128135;',
    '💈'        => '&#128136;',
    '💉'        => '&#128137;',
    '💊'        => '&#128138;',
    '💋'        => '&#128139;',
    '💌'        => '&#128140;',
    '💍'        => '&#128141;',
    '💎'        => '&#128142;',
    
    
    '🚀'        => '&#128640;',
    '🚁'        => '&#128641;',
    '🚂'        => '&#128642;',
    '🚃'        => '&#128643;',
    '🚄'        => '&#128644;',
    '🚅'        => '&#128645;',
    '🚆'        => '&#128646;',
    '🚇'        => '&#128647;',
    '🚈'        => '&#128648;',
    '🚉'        => '&#128649;',
    '🚊'        => '&#128650;',
    '🚋'        => '&#128651;',
    '🚌'        => '&#128652;',
    '🚍'        => '&#128653;',
    '🚎'        => '&#128654;',
    '🚏'        => '&#128655;',
    '🚐'        => '&#128656;',
    '🚑'        => '&#128657;',
    '🚒'        => '&#128658;',
    '🚓'        => '&#128659;',
    '🚔'        => '&#128660;',
    '🚕'        => '&#128661;',
    '🚖'        => '&#128662;',
    '🚗'        => '&#128663;',
    '🚘'        => '&#128664;',
    '🚙'        => '&#128665;',
    '🚚'        => '&#128666;',
    '🚛'        => '&#128667;',
    '🚜'        => '&#128668;',
    '🚝'        => '&#128669;',
    '🚞'        => '&#128670;',
    '🚟'        => '&#128671;',
    '🚠'        => '&#128672;',
    '🚡'        => '&#128673;',
    '🚢'        => '&#128674;',
    '🚣'        => '&#128675;',
    '🚤'        => '&#128676;',
    '🚥'        => '&#128677;',
    '🚦'        => '&#128678;',
    '🚧'        => '&#128679;',
    '🚨'        => '&#128680;',
    '🚩'        => '&#128681;',
    '🚪'        => '&#128682;',
    '🚫'        => '&#128683;',
    '🚬'        => '&#128684;',
    '🚭'        => '&#128685;',
    '🚮'        => '&#128686;',
    '🚯'        => '&#128687;',
    '🚰'        => '&#128688;',
    '🚱'        => '&#128689;',
    '🚲'        => '&#128690;',
    '🚳'        => '&#128691;',
    '🚴'        => '&#128692;',
    '🚵'        => '&#128693;',
    '🚶'        => '&#128694;',
    '🚷'        => '&#128695;',
    '🚸'        => '&#128696;',
    '🚹'        => '&#128697;',
    '🚺'        => '&#128698;',
    '🚻'        => '&#128699;',
    '🚼'        => '&#128700;',
    '🚽'        => '&#128701;',
    '🚾'        => '&#128702;',
    '🚿'        => '&#128703;',
    '🛀'        => '&#128704;',
    '🛁'        => '&#128705;',
    '🛂'        => '&#128706;',
    '🛃'        => '&#128707;',
    '🛄'        => '&#128708;',
    '🛅'        => '&#128709;',
    '🛋'        => '&#128715;',
    '🛌'        => '&#128716;',
    '🛍'        => '&#128717;',
    '🛎'        => '&#128718;',
    '🛏'        => '&#128719;',
    '🛐'        => '&#128720;',
    '🛑'        => '&#128721;',
    '🛒'        => '&#128722;',
    '🛠'        => '&#128736;',
    '🛡'        => '&#128737;',
    '🛢'        => '&#128738;',
    '🛣'        => '&#128739;',
    '🛤'        => '&#128740;',
    '🛥'        => '&#128741;',
    '🛩'        => '&#128745;',
    '🛫'        => '&#128747;',
    '🛬'        => '&#128748;',
    '🛰'        => '&#128752;',
    '🛳'        => '&#128755;',
    
    '🦀'        => '&#129408;',
    '🦁'        => '&#129409;',
    '🦂'        => '&#129410;',
    '🦃'        => '&#129411;',
    '🦄'        => '&#129412;',
    
    '🧀'        => '&#129472;',
    
    '⌚'        => '&#8986;',
    '⌛'        => '&#8987;',
    '⏩'        => '&#9193;',
    '⏪'        => '&#9194;',
    '⏫'        => '&#9195;',
    '⏬'        => '&#9196;',
    '⏭'        => '&#9197;',
    '⏮'        => '&#9198;',
    '⏯'        => '&#9199;',
    '⏰'        => '&#9200;',
    '⏱'        => '&#9201;',
    '⏲'        => '&#9202;',
    '⏳'        => '&#9203;',
    '⏸'        => '&#9208;',
    '⏹'        => '&#9209;',
    '⏺'        => '&#9210;',
    'Ⓜ'        => '&#9410;',
    '☔'        => '&#9748;',
    '☕'        => '&#9749;',
    '☝'        => '&#9757;',
    '♈'        => '&#9800;',
    '♉'        => '&#9801;',
    '♊'        => '&#9802;',
    '♋'        => '&#9803;',
    '♌'        => '&#9804;',
    '♍'        => '&#9805;',
    '♎'        => '&#9806;',
    '♏'        => '&#9807;',
    '♐'        => '&#9808;',
    '♑'        => '&#9809;',
    '♒'        => '&#9810;',
    '♓'        => '&#9811;',
    '♟'        => '&#9823;',
    '♿'        => '&#9855;',
    '⚓'        => '&#9875;',
    '⚡'        => '&#9889;',
    
    '✒'        => '&#10002;',
'✔'        => '&#10004;',
'✖'        => '&#10006;',
'✝'        => '&#10013;',
'✡'        => '&#10017;',
'✨'        => '&#10024;',
'✳'        => '&#10035;',
'✴'        => '&#10036;',
'❄'        => '&#10052;',
'❇'        => '&#10055;',
'❌'        => '&#10060;',
'❎'        => '&#10062;',
'❓'        => '&#10067;',
'❔'        => '&#10068;',
'❕'        => '&#10069;',
'❗'        => '&#10071;',
'❣'        => '&#10083;',
'❤'        => '&#10084;',
'➕'        => '&#10133;',
'➖'        => '&#10134;',
'➗'        => '&#10135;',
'➡'        => '&#10145;',
'➰'        => '&#10160;',
'➿'        => '&#10175;',
'⤴'        => '&#10548;',
'⤵'        => '&#10549;',
'⬅'        => '&#11013;',
'⬆'        => '&#11014;',
'⬇'        => '&#11015;',
'⬛'        => '&#11035;',
'⬜'        => '&#11036;',
'⭐'        => '&#11088;',
'⭕'        => '&#11093;',
'〰'        => '&#12336;',
'〽'        => '&#12349;',
'㊗'        => '&#12951;',
'㊙'        => '&#12953;',
'🀄'        => '&#126980;',
'🃏'        => '&#127183;',
'🅰'        => '&#127344;',
'🅱'        => '&#127345;',
'🅾'        => '&#127358;',
'🅿'        => '&#127359;',
'🆎'        => '&#127374;',
'🆑'        => '&#127377;',
'🆒'        => '&#127378;',
'🆓'        => '&#127379;',
'🆔'        => '&#127380;',
'🆕'        => '&#127381;',
'🆖'        => '&#127382;',
'🆗'        => '&#127383;',
'🆘'        => '&#127384;',
'🆙'        => '&#127385;',
'🆚'        => '&#127386;',
    
    ];
    
    