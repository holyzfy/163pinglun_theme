<?php 
$about = $page = get_page_by_title('关于');
$link = get_page_link($about->ID);
?>
<div id="footer">
    <div class="wrapper clearfix">
        <div class="left">&copy; 163pinglun.com 2011 - <?php echo date("Y"); ?> Some Rights Reserved. 京ICP备14037201号-2</div>
            <div class="right"><a href="<?php echo $link ?>">关于</a> | <?php wp_register('',' | '); ?><?php wp_loginout(); ?></div>
    </div>
</div>
<script type="text/javascript">
$(function(){   
    /*相关评论position:sticky效果*/
    var $widget = $("#widget_related_entries"),
    offset = $widget.offset();
    $widget.length > 0 && $(window).scroll(function(){
        var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
        $widget.toggleClass( 'fixed', scrollTop > offset.top && ( $(window).width() >= 940 ) && ( $(window).height() >= 350 ) );
    }).scroll();

    function datetimeDiff(startDate, endDate) {
        try {
            startDate = startDate instanceof Date ? startDate : new Date(startDate);
            endDate = endDate instanceof Date ? endDate : new Date(endDate);
        } catch(e) {
            return;
        }
            
        var delta = endDate.getTime() - startDate.getTime();
        var oneMinute = 60 * 1000,
            oneHour = 60 * oneMinute,
            oneDay = 24 * oneHour;

        var isSameMonth = endDate.getMonth() == startDate.getMonth(),
            day = Math.floor(delta / oneDay),
            day2 = isSameMonth ? endDate.getDate() - startDate.getDate() : day,
            hour = Math.floor((delta - day * oneDay) / oneHour),
            minute = Math.floor((delta - day * oneDay - hour * oneHour) / oneMinute);
        return {
            day: day2,
            hour: hour,
            minute: minute,
            isSameDay: isSameMonth && endDate.getDate() == startDate.getDate()
        };
    }

    function formatDate() {
        var endDate = new Date();
        var dayLabel = ["今天", "昨天", "前天"];
        $("#content span.entry-date").each(function(){
            var ret = "";

            var text = $(this).text();
                array = text.split(" "),
                d = array[0].split("/"),
                t = array[1].split(":");
            var start = new Date(d[0], d[1] - 1, d[2], t[0], t[1]);
            var diff = datetimeDiff(start, endDate);
            if(!diff || diff.day > 10) return;
            var startDate = new Date(start);

            var hour = startDate.getHours(),
                minute = startDate.getMinutes();
            hour = hour >= 10 ? hour : 0 + "" + hour;
            minute = minute >= 10 ? minute : 0 + "" + minute;
            var time = hour + ":" + minute;
            if(diff.day < 3) {
                ret = dayLabel[diff.day] + " " + time;
            } else {
                ret = diff.day + "天前";
            }
            $(this).text(ret);
        });
    }

    formatDate();
});
</script>

<div style="width:0; height:0; overflow:hidden;">
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F86534126a52735076890ede15e5ffc2b' type='text/javascript'%3E%3C/script%3E"));
</script>
</div>
<?php
/*
*在body 前面，紧紧挨着body 调用 wp_footer()
*http://codex.wordpress.org/zh-cn:主题开发#.E7.B4.A2.E5.BC.95_.28index.php.29
*/
 wp_footer(); ?>    
</body>
</html>