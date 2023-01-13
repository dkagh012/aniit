<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

include_once(G5_THEME_MOBILE_PATH . '/head.php');

add_javascript('<script src="' . G5_THEME_JS_URL . '/waterfall-light.js"></script>', 10);
add_javascript('<script src="'.G5_JS_URL.'/jquery.bxslider.js"></script>', 10);
?>

<div class="latest_wr">

    <!-- 메인화면 최신글 시작 -->
    <?php
echo latest('theme/main', 'free', 10, 23);
    ?>

    <!-- 메인화면 최신글 끝 -->
    
</div>
<div class="latest_img">
<?php
echo latest('theme/xns_gnuboard_latest_gallery_thumbnail', 'ani', 6, 23);

?>
</div>
<div class=latest_img>
<?php
echo latest('theme/community', 'ani', 9, 23);

?>
</div>

 <?php
/* thumb_width, thumb_width : 배너이미지 가로,세로 크기 */
// $options = array();
// $options['thumb_width'] = '2560';
// $options['thumb_height'] = '800';
// echo latest('theme/main_slider', 'free', 5, 23, 0, $options);
?>
    <?php 
    // echo poll('theme/basic'); 
    // 설문조사 ?>


<script>
$('.lt_slider').each(function(){
	$(this).bxSlider({
		pager:true,
		hideControlOnEnd: true,
		nextText: '<i class="fa fa-angle-right" aria-hidden="true"></i>',
		prevText: '<i class="fa fa-angle-left" aria-hidden="true"></i>'
	});
});
</script>


<?php
include_once(G5_THEME_MOBILE_PATH . '/tail.php');
?>