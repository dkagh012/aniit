<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/board.css">', 0);
?>

<link type="text/css" rel="stylesheet" href="<?php echo $board_skin_url; ?>/featherlight.css" />
<script type="text/javascript" src="<?php echo $board_skin_url; ?>/featherlight.js" charset="utf-8"></script>

<style type="text/css">
@media all {
	.lightbox {display: none;}
	.fixwidth {background: rgba(256,256,256, 0.6);}
	.fixwidth .featherlight-content {width: 500px;padding: 25px;color: #fff;	background: #111;}
	.fixwidth .featherlight-close {color: #fff;background: #333;}
}
</style>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->

<article id="bo_v" style="width:<?php echo $width; ?>">

<?php ob_start(); ?>
<div id="bo_v_top">
<ul class="btn_bo_user bo_v_com">
	<li><a href="<?php echo $list_href ?>" class="btn btn_normal btn_list" title="목록"><i class="xi-align-left xi-x"></i>목록</a></li>
	<?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn btn_act" title="수정">수정</a></li><?php } ?>
	<?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn btn_act" title="삭제">삭제</a></li><?php } ?>
	<?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn btn_act" title="답변">답변</a></li><?php } ?>
	<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn_act" title="글쓰기">글쓰기</a></li><?php } ?>
</ul>
</div>
<?php
$link_buttons = ob_get_contents();
ob_end_flush();
?>
<header>
<h2 id="bo_v_title">
	<?php if ($category_name) { ?><span class="bo_v_cate"><?php echo $view['ca_name']; // 분류 출력 끝 ?></span><?php } ?>
	<span class="bo_v_tit"><?php echo cut_str(get_text($view['wr_subject']), 200); // 글제목 출력 ?></span>

	<section id="bo_v_info">
	<h2>페이지 정보</h2>
	<!--<div class="pf_img"><?php echo get_member_profile_img($view['mb_id']) ?></div>-->
	<div class="profile_info">
		<ul class="profile_info_ct">
			<li><!--<strong>작성자</strong>--><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "(IP : $ip)"; } ?></li>
			<li><strong>댓글</strong><a href="#bo_vc" class="comment"><?php echo number_format($view['wr_comment']) ?>건</a></li>
			<li><strong>조회수</strong><?php echo number_format($view['wr_hit']) ?></li>
			<li class="if_date"><strong>작성일</strong><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></li>
		</ul>
	</div>
	</section>

	<?php if($update_href || $delete_href || $copy_href || $move_href || $search_href) { ?>
	<div id="bo_v_more">
		<button type="button" class="btn_more_opt is_view_btn">
			<i class="xi-ellipsis-v xi-x"></i>
			<span class="sound_only">게시판 리스트 옵션</span>
		</button>

		<ul class="more_opt is_view_btn"> 
			<?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>"><i class="xi-pen xi-x"></i> 수정</a></li><?php } ?>
			<?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;"><i class="xi-trash xi-x"></i> 삭제</a></li><?php } ?>
			<?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;"><i class="xi-documents xi-x"></i> 복사</a></li><?php } ?>
			<?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;"><i class="xi-arrows xi-x"></i> 이동</a></li><?php } ?>
			<?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>"><i class="xi-search xi-x"></i> 검색</a></li><?php } ?>
		</ul> 
	</div>

	<script>
	jQuery(function($){
	// 게시판 보기 버튼 옵션
		$(".btn_more_opt.is_view_btn").on("click", function(e) {
			e.stopPropagation();
			$(".more_opt.is_view_btn").toggle();
		})
	;
		$(document).on("click", function (e) {
			if(!$(e.target).closest('.is_view_btn').length) {
				$(".more_opt.is_view_btn").hide();
			}
		});
	});
	</script>
	<?php } ?>


</h2>
</header>


<section id="bo_v_atc">
	<h2 id="bo_v_atc_title">본문</h2>

	<div id="bo_v_share">
		<?php include_once(G5_SNS_PATH."/view.sns.skin.php"); ?>
		<?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class="btn btn_normal btn_scrap" onclick="win_scrap(this.href); return false;"><i class="xi-folder-add xi-x"></i> 스크랩</a><?php } ?>
	</div>

	<?php
	// 파일 출력
	$v_img_count = count($view['file']);
	if($v_img_count) {
		for ($i=0; $i<=count($view['file']); $i++) {
			echo "<div id=\"bo_v_img\">\n";
			echo get_file_thumbnail($view['file'][$i]);
			echo "</div>\n";
		}
	}
	?>

	<!-- 본문 내용 시작 { -->
	<div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
	<?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
	<!-- } 본문 내용 끝 -->

	<?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

	<!--  추천 비추천 시작 { -->
	<?php if ($good_href || $nogood_href) { ?>
	<div id="bo_v_act">
		<?php if ($good_href) { ?>
		<span class="bo_v_act_gng">
			<a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="bo_v_good"><img src="<?php echo $board_skin_url; ?>/img/icon_good.png"><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></a>
			<b id="bo_v_act_good"></b>
		</span>
		<?php } ?>

		<?php if ($nogood_href) { ?>
		<span class="bo_v_act_gng">
			<a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="bo_v_nogood"><img src="<?php echo $board_skin_url; ?>/img/icon_nogood.png"><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
			<b id="bo_v_act_nogood"></b>
		</span>
		<?php } ?>
	</div>
	<?php } else {

		if($board['bo_use_good'] || $board['bo_use_nogood']) {
	?>
	<div id="bo_v_act">
		<?php if($board['bo_use_good']) { ?><span class="bo_v_good"><img src="<?php echo $board_skin_url; ?>/img/icon_good_off.png"><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
		<?php if($board['bo_use_nogood']) { ?><span class="bo_v_nogood"><img src="<?php echo $board_skin_url; ?>/img/icon_nogood_off.png"><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
	</div>
	<?php
		}
	}
	?>
<!-- }  추천 비추천 끝 -->
</section>

<?php
$cnt = 0;
if ($view['file']['count']) {
	for ($i=0; $i<count($view['file']); $i++) {
		if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
			$cnt++;
		}
	}
?>

<?php if($cnt) { ?>
 <!-- 첨부파일 시작 { -->
<section id="bo_v_file">
	<h2>첨부파일</h2>
	<ul>
	<?php
	 // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
	?>
		<li>
			<i class="xi-folder-download xi-3x"></i>
			<a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download"><?php echo $view['file'][$i]['source'] ?> <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)</a>
			<span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드<span class="var"></span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
		</li>
	<?php
		}
	}
	?>
	</ul>
</section>
<!-- } 첨부파일 끝 -->
<?php } ?>

<?php if(isset($view['link'][1]) && $view['link'][1]) { ?>
<!-- 관련링크 시작 { -->
<section id="bo_v_link">
	<h2>관련링크</h2>
	<ul>
	<?php
	// 링크
	$cnt = 0;
		for ($i=1; $i<=count($view['link']); $i++) {
			if ($view['link'][$i]) {
				$cnt++;
				$link = cut_str($view['link'][$i], 70);
	?>
			<li>
                <i class="xi-external-link xi-3x"></i>
				<a href="<?php echo $view['link_href'][$i] ?>" target="_blank"><?php echo $link ?></a>
				<span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
			</li>
	<?php
		}
	}
	?>
	</ul>
</section>
<!-- } 관련링크 끝 -->
<?php } ?>


<?php if ($prev_href || $next_href) { ?>
<ul class="bo_v_nb">
	<?php if ($prev_href) { ?><li class="btn_prv"><span class="nb_tit"><i class="xi-angle-up-min xi-x"></i> 이전글</span><a href="<?php echo $prev_href ?>"><?php echo $prev_wr_subject;?></a> <span class="nb_date"><?php echo str_replace('-', '.', substr($prev_wr_date, '2', '8')); ?></span></li><?php } ?>
	<?php if ($next_href) { ?><li class="btn_next"><span class="nb_tit"><i class="xi-angle-down-min xi-x"></i> 다음글</span><a href="<?php echo $next_href ?>"><?php echo $next_wr_subject;?></a>  <span class="nb_date"><?php echo str_replace('-', '.', substr($next_wr_date, '2', '8')); ?></span></li><?php } ?>
</ul>
<?php } ?>

<?php echo $link_buttons; ?>

<?php include_once(G5_BBS_PATH.'/view_comment.php'); ?>

</article>
<!-- } 게시판 읽기 끝 -->


<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->