<?php
/* copyright(c) WEBsiting.co.kr */
if (!defined('_GNUBOARD_'))
  exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="' . $latest_skin_url . '/main.jquery.bxslider.css">', 0);
add_javascript('<script src="' . G5_JS_URL . '/jquery.bxslider.js"></script>', 10);

$thumb_width = 2000;
$thumb_height = 600;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="mainImages mainImages_<?php echo $board['bo_table'] ?>">
  <ul class="gall_lt">
    <?php
    for ($i = 0; $i < $list_count; $i++) {
      $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

      if ($thumb['src']) {
        $img = $thumb['src'];
      } else {
        // $img = G5_IMG_URL . '/no_img.png';
        $thumb['alt'] = '이미지가 없습니다.';
      }
      if ($list[$i]['comment_cnt'])
        $list[$i]['subject'] .= "<span class=\"lt_cmt\">" . $list[$i]['wr_comment'] . "</span>";
      $img_content = '<img src="' . $img . '" alt="' . $thumb['alt'] . '" >';
      ?>
      <li>
        <a href="<?php echo $list[$i]['href'] ?>" class="lt_img">
          <?php echo $img_content; ?>
        </a>


        <div class="lt_name">
          <?php

          echo "<p href=\"" . $list[$i]['href'] . "\">";
          if ($list[$i]['is_notice'])
            echo "<strong>" . $list[$i]['subject'] . "</strong>";
          else
            echo $list[$i]['subject'];
          echo "</p>";
          ?>
        </div>
        <div class="lt_content">
          <?php echo get_text(cut_str(strip_tags($list[$i]['wr_content']), 300)); ?>
        </div>
        <div class="lt_count">

        </div>

      </li>

    <?php } ?>
  </ul>
  <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <p class="empty_li">등록된 내용이 없습니다.</p>
  <?php } ?>

</div>
<?php if (count($list)) { //게시물이 있다면 ?>
  <script>
    $('.mainImages_<?php echo $board['bo_table'] ?> ul').bxSlider({
      hideControlOnEnd: true,
      auto: true,
      pager: true,
    });


  </script>
<?php } ?>