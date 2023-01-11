<?php
if (!defined('_GNUBOARD_'))
  exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

//스킨 CSS,JS 인클루드
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $latest_skin_url . '/css/style.css?' . time() . '" />', 11);
add_stylesheet('<link rel="stylesheet" href="' . $latest_skin_url . '/css/style_mobile.css?' . time() . '" media="all and (max-width: 768px)" />', 12);

//썸네일 사이즈 등 설정
$thumb_width = 480;
$thumb_height = 360;
if (G5_IS_MOBILE) {
  //$thumb_width = 480;
  //$thumb_height = 360;
}
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>


<div class="xns_gnuboard_latest_gallery_thumbnail xns_background">
  <div class="xns_title">
    새소식
  </div>
  <?php for ($i = 0; $i < $list_count; $i++) { ?>
    <?php
    //썸네일 설정
    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);
    ?>
    <div class="responsive">
      <div class="gallery">
        <a href="<?php echo $list[$i]['href'] ?>">
          <?php if ($thumb['src']) { ?>
            <img class="thumb" src="<?php echo $thumb['src'] ?>" />
          <?php } else { ?>
          <?php } ?>
          <img class="background_image" src="<?php echo $latest_skin_url ?>/images/noimage_480x360.png" />
        </a>
        <div class="desc">

          <ul>
            <li class="slide_title cut">

              <!-- 카테고리 -->
              [<?php
              if ($list[$i]['ca_name']) {
                echo $list[$i]['ca_name'];
              }
              ?>]
              <!-- 이름 -->
              <?php echo $list[$i]['subject'] ?>


            </li>

            <li class="slide_date">

              <?php
              // echo $list[$i]['datetime'] 
              ?>
              <?php
              if ($list[$i]['comment_cnt']) {
                //    echo "<span class='slide_comm'>+".$list[$i]['comment_cnt']."</span>";
              }
              ?>
            </li>

          </ul>

        </div>
      </div>
    </div>
  <?php } ?>
</div>