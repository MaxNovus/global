<?php include "../config/config.php";
require_once(DIR_INCSYS . 'header.php');
// Code Here...
if (isset($_REQUEST['vid']) && $_REQUEST['vid']<>'') {
$vid=$_REQUEST['vid'];
} 

$vquery="SELECT A.*,B.* FROM videos A, kw_sub B WHERE (A.rid='".$vid."') AND (B.subid=A.author_id)";
$vres=$db->rq($vquery);
$row=$db->afetch($vres);
$id=$row['id'];

// Comments & Reply
insert_video_comments();
insert_video_comments_reply();

// VIDEOS =1, PODCAST =2
$type=1;

// Code End...
require_once(DIR_INC . 'header-html.php');
?>

    <link rel="stylesheet" href="<?php  echo $config['baseurl']; ?>build/vendor/flowplayer/skin/skin.css">
    <script src="<?php  echo $config['baseurl']; ?>build/vendor/flowplayer/flowplayer.min.js"></script>

</head>

    <body> 
    
    <?php require_once(DIR_INC . 'nav-bar.php'); ?>
	  
	<div class="site-output">

            <div id="all-output" class="col-md-12" style="background-color: #F8F8F8;">
		
                <div class="row">
            	
                    <div class="col-md-8">
                        
                        <div id="watch">
                            <?php update_video_views(); ?>

                            <?php
                            $video_file = $config['baseurl']."assets/uploads/".$row['video_file'];
                            ?>
                            <!-- PLAYER -->
                            <div class="flowplayer" data-swf="flowplayer.swf" data-ratio="0.4167">
                               <!--<video poster="<?php //echo $config['baseurl']; ?>assets/uploads/<?php //echo $row['image']; ?>" controls >-->
                                <video controls >
                                    <source type="video/webm" src="<?php echo $video_file.".webm"; ?>">
                                    <source type="video/mp4"  src="<?php echo $video_file.".mp4"; ?>">
                                </video>
                            </div>
                        </div> 
                        
                    </div>
                </div><!-- // row -->

            </div>

        </div>

      <?php  require_once(DIR_INC . 'footer.php'); ?>
      <?php  require_once(DIR_INC . 'footer-js.php'); ?>
    
    </body>
	
</html>
