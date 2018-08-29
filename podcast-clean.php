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

insert_podcast_comments();
insert_podcast_comments_reply();

// PODS
$type=2;

// Code End...
require_once(DIR_INC . 'header-html.php');
?>

</head>

    <body>
    
	<?php require_once(DIR_INC . 'nav-bar.php'); ?>
	  
	<div class="site-output">

            <div id="all-output" class="col-md-12" style="background-color: #F8F8F8;">


                <div class="row">
                    <div class="col-md-8">
                            <div id="watch">
                            <div class="video-code"> 
                                <img src="http://raddnet.com/figleaf/assets/uploads/1530123625-fl41.jpg">
                                <audio controls="controls" style="float: right;">
                                  <source src="track.ogg" type="audio/ogg" />
                                  <source src="<?php echo $config['baseurl']; ?>project/aj-jazz-trumpet.mp3" type="audio/mpeg" />
                                Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>
                    </div><!-- // col-md-8 -->

                        <div class="col-md-4">
                    </div><!-- // col-md-4 -->
                </div><!-- // row -->
            </div>
        </div>
        
        <?php  require_once(DIR_INC . 'footer.php'); ?>
        <?php  require_once(DIR_INC . 'footer-js.php'); ?>

    </body>
	
</html>
