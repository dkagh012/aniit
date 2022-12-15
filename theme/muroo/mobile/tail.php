<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

		
		<footer id="footer">
  		<button type="button" id="top_btn"><i class="fa fa-arrow-up" aria-hidden="true"></i><span class="sound_only">상단으로</span></button>
			<script>
            $(function() {
                // 폰트 리사이즈 쿠키있으면 실행
                font_resize("html_wrap", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));

                // '상단으로' 버튼
                $("#top_btn").on("click", function() {
                    $("html, body").animate({scrollTop:0}, '500');
                    return false;
                });
            });
            </script>
			<?php
		    if ($config['cf_analytics']) {
		        echo $config['cf_analytics'];
		    }
		    ?>
		</footer>
	</div>
	<!-- } wrapper 끝 -->
</div>
<!-- } 컨텐츠 끝 -->

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>