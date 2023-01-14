<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/board.css">', 0);
?>

<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL; ?>/jquery.wookmark.css">
<style>
#tiles li {border:solid 1px #eee;
-moz-box-sizing: border-box;
box-sizing: border-box;
}
#tiles li img {width:100%;height:auto;}
</style>

<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">

<h2 class="sound_only"><?php echo $board['bo_subject']; ?></h2>
	
	<?php if ($is_category) { ?>
	<!-- 게시판 카테고리 시작 { -->
	<nav id="bo_cate">		
		<ul id="bo_cate_ul">
			<?php echo $category_option ?>
		</ul>
	</nav>
	<!-- } 게시판 카테고리 끝 -->
	<?php } ?>	

	<form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="sw" value="">

	<!-- 게시판 페이지 정보 및 버튼 시작 { -->
	<div id="bo_btn_top">
	
	<div id="bo_list_total">
		<span>TOTAL : <strong><?php echo number_format($total_count) ?></strong>개</span> /
		<strong><?php echo $page ?></strong>페이지
	</div>

	<?php if ($rss_href || $write_href) { ?>
	<ul class="btn_bo_user">
		<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn btn_admin_icon" title="관리자"><i class="xi-cog xi-spin"></i></a></li><?php } ?>
		<?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" target="_blank" class="btn btn_rss" title="RSS">RSS</a></li><?php } ?>
		<!--<li><button type="button" class="btn_bo_sch" title="게시판 검색"><i class="xi-search xi-x"></i></button></li>-->
		<!--<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn_act" title="글쓰기">글쓰기</a></li><?php } ?>-->
		<?php if ($is_admin == 'super' || $is_auth) {  ?>
		<li>
			<button type="button" class="btn_more_opt is_list_btn" title="게시판 리스트 옵션">
				<i class="xi-ellipsis-v xi-x"></i>
				<span class="sound_only">게시판 리스트 옵션</span>
			</button>
			<?php if ($is_checkbox) { ?>	
			<ul class="more_opt is_list_btn">  
				<li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"><i class="xi-trash xi-x"></i> 선택삭제</button></li>
				<li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"><i class="xi-documents xi-x"></i> 선택복사</button></li>
				<li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"><i class="xi-arrows xi-x"></i> 선택이동</button></li>
			</ul>
		<?php } ?>
		</li>
		<?php }  ?>
	</ul>
	<?php } ?>

	</div>


<?php if ($is_checkbox) { ?>
<div id="allchk" class="all_chk chk_box">
	<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk">
	<label for="chkall">
		<span></span>
		<b class="sound_only">현재 페이지 게시물 </b> 전체선택
	</label>
</div>
<?php } ?>


<div id="photo_type">
<h2 class="sound_only"><?php echo $board['bo_subject'] ?> 목록</caption></h2>

<ul id="tiles">
	<?php for ($i=0; $i<count($list); $i++) { ?>
	<li>
		<a href="<?php echo $list[$i]['href'] ?>">
		<?php
		if ($list[$i]['is_notice']) { // 공지사항
			$img_content = '<img src="'.$board_skin_url.'/img/notice.jpg">';
		} else {
			$thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], true, true);

			if($thumb['src']) {
				$img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" >';
			} else {
			$img_content = '<img src="'.$board_skin_url.'/img/noimg.jpg">';
			}
		}
			echo $img_content;
		?>
		</a>
<?
/////////////////////////////////리스트에서 파일 다운로드////////////////////////////////////////
		$list_pdf_file = get_file($bo_table, $list[$i]['wr_id']);

		for($img_count_num=0;$img_count_num<$list_pdf_file['count'];$img_count_num++){	
			$img_ex = explode(".", $list_pdf_file[$img_count_num]['file']);

			if($img_ex[1]=='pdf'){
				echo "<a href=".$list_pdf_file[$img_count_num]['href'].">".$list_pdf_file[$img_count_num]['source']."</a>";
			}
		}
/////////////////////////////////리스트에서 파일 다운로드 끝////////////////////////////////////////
?>
		<div class="con">
			<?php if ($is_category && $list[$i]['ca_name']) { ?><p class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></p><?php } ?>
			<p class="subject">
			<?php
				if ($list[$i]['icon_new']) echo "<i class=\"xi-new xi-x\"></i><span class=\"sound_only\">새글</span>";
				if (isset($list[$i]['icon_hot'])) echo rtrim($list[$i]['icon_hot']);
				//if (isset($list[$i]['icon_secret'])) echo rtrim($list[$i]['icon_secret']);
			?>
			<a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['subject'] ?></a>
			<?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><span class="cnt_cmt">[<?php echo $list[$i]['wr_comment']; ?>]</span><span class="sound_only">개</span><?php } ?>
			</p>
			<p class="content">
				<a href="<?php echo $list[$i]['href'] ?>"><?php echo cut_str(strip_tags($list[$i]['wr_content']),100) ?></a>
			</p>

			<dl>
				<dd><span class="sound_only">작성자</span><?php echo $list[$i]['name'] ?></dd>
				<dd><span class="sound_only">작성일</span><?php echo $list[$i]['datetime2']; ?></dd>
				<dd>조회 : <?php echo $list[$i]['wr_hit'] ?></dd>
				<?php if ($is_good) { ?><dd class="good"><i class="xi-heart xi-x"></i> <span class="sound_only">추천</span><?php echo $list[$i]['wr_good']; ?></dd><?php } ?>
			</dl>
		</div>

		<!--<a href="<?php echo $list[$i]['href'] ?>" class="btn_detail">
			<div class="detail"><i class="xi-library-books-o xi-x xi-4x"></i><br>DETAIL VIEW.</div>
		</a>-->

		<?php if ($is_checkbox) { ?>
		<div class="gall_chk chk_box">			
				<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="selec_chk">
				<label for="chk_wr_id_<?php echo $i ?>"><span></span><b class="sound_only"><?php echo $list[$i]['subject'] ?></b></label>						
			
			<span class="sound_only">
			<?php
			if ($wr_id == $list[$i]['wr_id'])
				echo "<span class=\"bo_current\">열람중</span>";
			else
				echo $list[$i]['num'];
			?>
			</span>
		</div>
		<?php } ?>

	</li>
	<?php } ?>
	<?php if (count($list) == 0) { echo ''; } ?>
</ul>
</div>


<?php if ($list_href || $is_checkbox || $write_href) { ?>
<div class="bo_fx">
	<?php if ($list_href || $write_href) { ?>
	<ul class="btn_bo_user">
		<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn btn_admin" title="관리자">관리자</a></li><?php } ?>
		<?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" target="_blank" class="btn btn_rss" title="RSS">RSS</a></li><?php } ?>
		<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn_act" title="글쓰기">글쓰기</a></li><?php } ?>
	</ul>	
	<?php } ?>
</div>
<?php } ?>   
</form>

<?php echo $write_pages; ?>

<!-- 게시판 검색 시작 { -->
<div class="bo_sch_wrap">
<fieldset class="bo_sch">
	<form name="fsearch" method="get">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sop" value="and">
	
	<div class="sch_select">
	<label for="sfl">제목</label>
	<select name="sfl" id="sfl">
		<?php echo get_board_sfl_select_options($sfl); ?>
	</select>
	</div>

	<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
	<div class="sch_bar">
		<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" maxlength="20" placeholder=" 검색어를 입력해주세요">
		<button type="submit" value="검색" class="sch_btn"><i class="xi-search xi-x"></i><span class="sound_only">검색</span></button>
	</div>
	</form>
</fieldset>
</div>


<script>
jQuery(function($){	
	var select = $('.sch_select select');
	select.change(function(){
		var select_name = $(this).children('option:selected').text();
		$(this).siblings("label").text(select_name);
	});
});
</script>
<!-- } 게시판 검색 끝 --> 
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<script src="<?php echo G5_THEME_JS_URL; ?>/jquery.imagesloaded.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/jquery.wookmark.js"></script>


<script>
jQuery(function($){
	/* wookmark */
	$('#tiles').imagesLoaded(function() {
		var options = {
			itemWidth: 260,
			autoResize: true,
			container: $('#tiles'),
			offset: 20, //
			outerOffset: 0,
			flexibleWidth: '50%'
		};

		var handler = $('#tiles li');
		var $window = $(window);

		$window.resize(function() {
			var windowWidth = $window.width(),
			newOptions = { flexibleWidth: '50%' };

			if (windowWidth < 1024) {
				newOptions.flexibleWidth = '100%';
			}

			handler.wookmark(newOptions);
		});

	handler.wookmark(options);
	});
});


<?php if ($is_checkbox) { ?>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}

// 게시판 리스트 관리자 옵션
jQuery(function($){
    $(".btn_more_opt.is_list_btn").on("click", function(e) {
        e.stopPropagation();
        $(".more_opt.is_list_btn").toggle();
    });
    $(document).on("click", function (e) {
        if(!$(e.target).closest('.is_list_btn').length) {
            $(".more_opt.is_list_btn").hide();
        }
    });
});
<?php } ?>
</script>
<!-- } 게시판 목록 끝 -->
