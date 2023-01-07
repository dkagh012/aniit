<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!defined('_INDEX_')) define('_INDEX_', true);

include_once(G5_THEME_MOBILE_PATH.'/head.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

add_javascript('<script src="'.G5_JS_URL.'/jquery.bxslider.js"></script>', 10);
?>

	<?php
    echo latest('theme/mainimages', 'free', 5, 23);        
    ?>
<?php 
echo latest('theme/slide_thumb', 'ani', 10, 99); 
?>
<?php
    // echo latest('theme/okbest', 'free', 12, 23);
    ?>

<!-- 최신글 탭 스타일 -->
<script src="<?php echo G5_THEME_JS_URL ?>/latest_tab.js"></script>
<!-- 게시판 슬라이더 -->
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
include_once(G5_THEME_PATH.'/tail.php');
?>