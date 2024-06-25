<?php
    $option = unserialize(get_option('xyz-beian',serialize([])));
    $beian_hao = $option['beian_hao']??'';
    $beian_site_name = $option['beian_site_name']??'';
?>
<html>
    <head>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $beian_site_name; ?></title>
    </head>
    <body>
        <div class="head"><h1><?php echo $beian_site_name; ?></h1></div>
        <div class="main">
            <div class="content">
				<p>陌生人你好：</p>
				<p>你好，陌生人。或许我们从未相识，亦或是在某个瞬间擦肩而过，彼此成了对方生命中的过客。然而，我想告诉你，尽管我们之间没有任何联系，但我依然希望你能拥有快乐和幸福。</p>
				<p>每天，我们都会遇到各种各样的陌生人。他们可能是早晨路上与你擦肩而过的行人，也可能是咖啡店里为你泡制一杯香浓咖啡的咖啡师。生活中的陌生人给了我们许多意外的温暖和帮助，让我们感受到人类之间的互相关怀。</p>
				<p>曾经，我在一个陌生的城市迷路了。当时，我感到无助和迷茫，不知道该向谁求助。就在那个瞬间，一个陌生人主动走到我身边，询问我是否需要帮助。他为我指引了正确的方向，并送我回到了我应该去的地方。他没有留下姓名，只是微笑着说：“希望你找到自己要去的地方。”这位陌生人的善举深深地触动了我，让我明白到世界上依然存在着温暖和善意。</p>
				<p>在这个纷繁复杂的社会中，我们常常忽略了身边的陌生人。我们总是急匆匆地赶路，用手机遮挡住面容，几乎看不见周围的人。然而，每个人都有一个故事，每个人都渴望得到关注和理解。或许，只需要一句问候，一个微笑，我们就能成为彼此生命中的点亮之光。</p>
				<p>当你走在街头时，不妨抬起头来，与路人们分享一个友善的目光；当你坐在公共交通工具上时，试着与旁边的陌生人打个招呼；当你在排队等候时，可以主动与前后的人聊上几句。这些简单的举动可能让你与陌生人之间建立起微妙的联系，也让他们感受到你的善意和关怀。</p>
				<p>所以，尽管我们是陌生人，但我相信我们可以通过友善和关爱来连接彼此。每个人都有权利被尊重和被关心，无论他们是谁、来自哪里。让我们抛开陌生感，用真诚的笑容和温暖的问候去面对这个世界。</p>
				<p>你好，陌生人。希望你在生活中遇见更多友善和宽容的陌生人，同时也愿你成为他人生命中的一束光芒。</p>
            </div>
        </div>
        <div class="footer">
            <a href="https://beian.miit.gov.cn/" target="_blank" rel="nofollow"><?php echo $beian_hao; ?></a>
        </div>
        <style>
            *{box-sizing:border-box;margin:0;padding:0}
            html,body{height:100%}
            body{font-family:Arial,sans-serif;font-size:16px;line-height:1.5;color:#333;background-color:#f8f8f9}
            .head{background-color:#f8f8f9;border-bottom:1px solid #f2f2f2;height:200px;line-height:200px;text-align:center}
            .head h1{font-size:36px;font-weight:bold}
            .main{width:100%;max-width:900px;margin:0 auto;padding:40px;box-shadow:0 0 10px rgba(0,0,0,0.1);background-color:#fff}
            .main > div{margin-top:20px}
            .main p{font-size:16px;line-height:1.5;text-align:justify;margin-bottom:20px;text-indent:2em}
            .main .content  b p{text-align:center;font-size:17px}
            .footer{background-color:#f8f8f9;text-align:center;height:100px;line-height:100px;color:#333;border-top:1px solid #f2f2f2}
            .footer a{color:#333}
            img{display:block;margin:0 auto;max-width:100%;height:auto}
            @media screen and (max-width:768px){
                .head{height:100px;line-height:100px}
                .head h1{font-size:24px}
                .main{padding:20px}
                .main p{font-size:14px}
                footer{height:80px;line-height:80px}
            }
        </style>
    </body>
</html>