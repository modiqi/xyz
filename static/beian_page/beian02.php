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
        <div class="main">
            <div class="title"><?php echo $beian_site_name; ?></div>
            <div class="content">
                <div class="left">
                    <p>轻风吹拂，静谧而轻柔的风景悄然展开。阳光透过稀疏的树叶洒在大地上，微风轻抚着脸庞，带来一丝凉爽。这是一个宜人的日子，仿大自然都在为人们送上一份清新与宁静。</p>
                    <p>在这里，我踏上一段看无尽的旅程。远处的山川静静躺卧，仿佛沉浸在幻般的境界中。周是茂密的草地，似乎留下我来观赏它们的美丽。蝴蝶翩起舞，欢快地在空翻飞，仿佛在用身影刻画着一幅美丽的画卷。</p>
                    <p>微风中飘阵阵花香，吸引着我的注意力。我随着香味的指引，走近一处花海。五彩缤纷的朵竞相绽放，散发诱人的香气，将我完全陶醉其中。我沉浸在花海之中，心旷神怡，仿佛置身于童话世界。</p>
                    <p>沿着小行走，我走进了一座木屋。木屋被花环绕，宛如一个天然的庇护所。我推开门，一股清新的气息扑面而来。木屋内放着一张舒适的藤和一个小小的茶几。我坐下来，闭上眼睛，让轻风轻抚着我的脸颊。这一刻，我受到了内心的宁静与平和。</p>
                    <p>在这片宁静的风景中，我忘了时间的流逝。我沉在这轻风记中，享着属于自己的欢乐时光。这里的一切都是那么美好，让人忍不住想停留下来，与这片轻风为伴。</p>
                    <p>当我离开这片轻风地，我敢肯定，我带着满心的宁静和美好回归喧嚣的世界。这段轻风记将永远铭刻在我心底，提我去欣赏大自然的美妙与温暖、去寻找生活中的一丝宁静平和。</p>
                </div>
                <div class="thumb">
                    <img src="https://www.3328bk.cn/111111.png" />
                </div>
            </div>
        </div>
        <div class="cop">
            <a href="https://beian.miit.gov.cn/" target="_blank" rel="nofollow"><?php echo $beian_hao; ?></a>
        </div>
        <style>
            body,html{background: #f5f7fd;}
            .main{max-width: 1200px;margin: 5% auto;border-top: 5px solid #409eff;padding: 40px;background: #fff;}
            .title{border-bottom: 1px solid #eee;font-size: 24px;padding-bottom: 20px;margin-bottom: 20px;}
            .content{display: flex;}
            .content .left{flex: 1;overflow: hidden;}
            .content p{font-size: 14px;color: #666;margin: 20px 0;text-indent: 2em;line-height: 26px;}
            .thumb{width: 280px;margin-left: 30px;}
            .thumb img{width: 100%;}
            .cop{position: fixed;bottom: 20px;left: 0;width: 100%;text-align: center;}
            .cop a{font-size: 14px;text-decoration: none;color: #999; }
        </style>
    </body>
</html>