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

insert_video_comments();
insert_video_comments_reply();

// VIDEOS
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
                        
                        <div id="ply">
                            
                            <div class="video-share" id="vshare">
                                
                                <!-- TITLE-->
                                <h1 class="video-title" style="margin-bottom:0;"><?php echo $row['title']; ?></h1>
                                
                                    <!-- STATS -->
                                    <ul class="like">
                                        <li>
                                         <span class="views"><i class="fa fa-eye"></i> <?php echo number_format($row['views']); ?> Views </span>
                                        </li>
                                        <li><a id="<?php echo $id; ?>"class="like" onClick="likeIt(this.id);" href="#">
                                        <?php echo kwik_count("like_dislike","video_id='".$id."' AND liked='1'"); ?>
                                        <i class="fa fa-thumbs-up"></i></a></li>
                                        <li><a id="<?php echo $id; ?>" class="deslike" onClick="dislikeIt(this.id);" href="#">
                                        <?php echo kwik_count("like_dislike","video_id='".$id."' AND disliked='1'"); ?> 
                                        <i class="fa fa-thumbs-down"></i></a></li>
                                    </ul>
                                    
                                    <!-- SHARE -->
                                    <ul class="social_link">
                                         <li><a class="embed" data-toggle="tooltip" data-placement="top" title="Embed"><i class="fa fa-code" aria-hidden="true" ></i></a></li>
                                         <li><a class="facebook" href="http://www.facebook.com/sharer.php?u=<?php echo $config['baseurl'].'view/'.$vid; ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook" aria-hidden="true" ></i></a></li>
                                        <li><a class="twitter" href="http://twitter.com/share?text=An%20intersting%20video&url=<?php echo $config['baseurl'].'view/'.$vid; ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li><a class="google" href="https://plus.google.com/share?url=<?php echo $config['baseurl'].'view/'.$vid; ?>" data-toggle="tooltip" data-placement="top" title="Google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                    </ul>
                                
                            </div>
    
                            <?php 
                            $products="SELECT A.*, B.* FROM kw_products_description A, kw_products B "
                                     . "WHERE (B.merchant_id='".$row['author_id']."') AND A.language_id='".$langid."' AND (B.product_id = A.product_id)"
                                     . "ORDER BY A.product_id DESC LIMIT 12";
                            $result=$db->rq($products);
                            $num_results=$db->num_rows($result);
                            if ($num_results>0) {
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0" style="border: 1px solid #e6e8e8;padding: 20px;">
                                    <!-- Carousel indicators -->
                                    <ol class="carousel-indicators">
                                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                            <li data-target="#myCarousel" data-slide-to="1"></li>
                                            <li data-target="#myCarousel" data-slide-to="2"></li>
                                    </ol>   
                                    <!-- Wrapper for carousel items -->
                                    
                                    <div class="carousel-inner">
                                        <div class="item carousel-item active">
                                            <div class="row">
                                            <?php
                                            $c=0;
                                            while ($prow=$db->afetch($result)) {
                                            $c=$c+1;
                                            ?>
                                                <div class="col-sm-3">
                                                    <div class="thumb-wrapper">
                                                        <a href="<?php echo $config['baseurl']; ?>view-product/<?php echo $prow['encid']; ?>/<?php echo $prow['slug']; ?>" target="_blank">
                                                        <div class="img-box">
                                                        <?php if ($prow['image']<>'') { ?>
                                                        <img src="<?php echo $config['baseurl']; ?>assets/img/products/<?php echo $prow['image'];?>" class="img-responsive img-fluid"/>				
                                                        <?php } else { ?>
                                                        <img src="<?php echo $config['baseurl']; ?>build/img/noimg/no_product.jpg" width="100" height="100" class="img-responsive img-fluid" />
                                                        <?php } ?>
                                                        </div>
                                                        <div class="thumb-content">
                                                            <h5><?php echo $prow['name']; ?></h5>
                                                            <p class="item-price"><strike><?php if ($prow['price'] > $prow['offer_price']) { echo $prow['price']; } ?></strike> <span><?php echo $prow['offer_price']; ?></span></p>
                                                        </div>
                                                        </a>        
                                                    </div>
                                                </div>
                                                <?php
                                                if ($c==4 || $c==8) {
                                                ?>
                                            </div>
                                        </div>
                                        <div class="item carousel-item">
                                            <div class="row">
                                                <?php } } ?>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- Carousel controls -->
                                        <?php /*
                                        <a class="carousel-control left carousel-control-prev" href="#myCarousel" data-slide="prev">
                                                <i class="fa fa-angle-left"></i>
                                        </a>
                                        <a class="carousel-control right carousel-control-next" href="#myCarousel" data-slide="next">
                                                <i class="fa fa-angle-right"></i>
                                        </a>
                                         */ ?> 
                                    </div>
                                </div>
                            </div>
                            <?php } ?>                          
                        
                            <!-- EMBED -->
                            <div class="video-share" id="vembed" style="display:none;">
                                <h1 class="video-title" style="margin-bottom:0;">Embed</h1>
                                <textarea style="width: 600px;height: 75px;margin-top: 5px;border-color:#ccc;">
                                    <object width="425" height="350" id="undefined" name="undefined" 
                                           data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" 
                                           type="application/x-shockwave-flash">
                                       <param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" />
                                       <param name="allowfullscreen" value="true" />
                                       <param name="allowscriptaccess" value="always" />
                                       <param name="flashvars" value='config={"clip":{"url":"<?php echo $config['baseurl'].'view/'.$vid; ?>"},"playlist":[{"url":"http://edge.flowplayer.org/flowplayer-700.flv"}]}' />
                                   </object>
                                </textarea>
                            </div>
                        
                            <!-- EXP -->    
                            <?php
                            include ("../build/vendor/getid3/getid3.php");
                            $getID3 = new getID3;
                            $filename = "../assets/uploads/SampleVideo_1280x720_1mb.mp4";
                            $file = $getID3->analyze($filename);
                            //echo("Duration: ".$file['playtime_string'].
                            //" / Dimensions: ".$file['video']['resolution_x']." wide by ".$file['video']['resolution_y']." tall".
                            //" / Filesize: ".$file['filesize']." bytes<br />");
                             ?>

                            <div class="chanel-item" id="chitem">
                                
                                <!-- CHANNEL LOGO -->
                                <div class="chanel-thumb">
                                    <a href="#">
                                        <?php if ($row['channel_image']<>'') { ?>
                                        <img src="<?php echo $config['baseurl']; ?>assets/img/user/<?php echo $row['channel_logo']; ?>" width="200" height="200" style="margin-right:5px;"/>
                                        <?php } else { ?>
                                        <img src="<?php echo $config['baseurl']; ?>build/img/noimg/channel.png" width="200" height="200" style="margin-right:5px;"/>
                                        <?php } ?>
                                    </a>
                                </div>

                                <!-- STATS -->
                                <div class="chanel-info">
                                    <a class="title" href="#"><?php echo $row['channel']; ?></a>
                                    <span class="subscribers">
                                    <?php 
                                    $scount = kwik_count("channel_subs","channel_id='".$row['author_id']."'"); 
                                    if ($scount==1) {
                                    echo $scount.' '.$lang['SUBSCRIBER']; 
                                    } else {
                                    echo $scount.' '.$lang['SUBSCRIBERS'];
                                    }
                                    ?>
                                    </span>
                                </div>
                                
                                <?php 
                                //SUBSCRIBE/UNSUBSCRIBE
                                $subs=kwik_count("channel_subs","channel_id='".$row['subid']."' AND subid='".$_SESSION['SUBSUBID']."'");

                                if ($subs==0) { ?>
                                <a href="#" id="<?php echo $row['subid']; ?>" class="subscribe" onClick="subscribeIt(this.id);">
                                <?php echo $lang['SUBSCRIBE']; ?>
                                </a>
                                <?php } ?>

                                <?php if ($subs==1) { ?>
                                <a href="#" id="<?php echo $row['subid']; ?>" class="subscribe" onClick="unsubscribeIt(this.id);">
                                <?php echo $lang['UNSUBSCRIBE']; ?>
                                </a>
                                <?php } ?>
                         		
                            </div>
                            
                            <div class="service-1 click1">
                                <div class="row">
                                    <input type="checkbox" id="expend" />
                                        <div class="medium-12 small-12 columns smalldesc" style="margin-left: 15px;margin-right: 15px;">
                                            <p class="font16 "><?php echo $row['body']; ?></p>
                                        </div>
                                    <div style="text-align:center;"><label for="expend" style="color:#bec3c3; font-weight:0;">Read More</label></div>
                                </div>
                            </div>                        


                            <!-- COMMENTS -->
                            <div id="comments" class="post-comments">
                                <h3 class="post-box-title">
                                    <span><?php $tcomments = video_comments_count($id); echo $tcomments; ?></span> 
                                    <?php 
                                        if ($tcomments==1) { 
                                        echo $lang['CCOMMENT'];
                                        } else if ($tcomments==0) {									
                                        echo $lang['BEFIRST'];
                                        } else if ($tcomments>1) {									
                                        echo $lang['COMMENTS']; 
                                        } 
                                    ?> 
                                </h3>

                                <ul class="comments-list">
                                    <?php
                                    $cqry="SELECT A.*, B.subid,B.firstname,B.lastname,B.photo, B.channel, B.channel_image, B.channel_logo FROM video_comments A, kw_sub B
                                    WHERE (A.removed=0) AND (A.video_id='".$id."') AND (A.langid='".$_SESSION['SESSLANG']."') AND (A.parent_id=0) AND (B.subid=A.user_id) ORDER BY pinned, date DESC
                                    "; 
                                    $cres=$db->rq($cqry);
                                    while ($crow=$db->afetch($cres)) {	
                                    ?>
                                    <li>
                                        <div class="post_author">
                                            <div class="img_in">
                                                <a href="#">
                                                    <?php if ($crow['channel']<>'' && $crow['channel_logo']<>'') { ?>
                                                        <img src="<?php echo $config['baseurl']; ?>assets/img/user/<?php echo $crow['channel_logo']; ?>" width="64" height="64" alt="<?php echo $row['channel']; ?>">
                                                        <?php }  else if ($crow['channel']<>'' && $crow['channel_logo']=='') { ?>
                                                        <img src="<?php echo $config['baseurl']; ?>build/img/noimg/channel.png" width="64" height="64" alt="<?php echo $row['channel']; ?>">
                                                        <?php }  else if ($crow['channel']=='' && $crow['photo']<>'') { ?>
                                                        <img src="<?php echo $config['baseurl']; ?>assets/img/user/<?php echo $crow['photo']; ?>" width="64" height="64" alt="<?php echo $row['firstname'].' '.$row['lastname']; ?>">
                                                        <?php }  else if ($crow['channel']=='' && $crow['photo']=='') { ?>
                                                        <img src="<?php echo $config['baseurl']; ?>build/img/noimg/80.jpg" width="64" height="64" alt="<?php echo $row['firstname'].' '.$row['lastname']; ?>">
                                                    }
                                                    <?php } ?>
                                                </a>
                                            </div>
                                            <a href="#" class="author-name"><?php echo $crow['channel']; ?></a>
                                            <time datetime="2017-03-24T18:18"><?php echo db_to_display_date($crow['date'],10); ?></time>
                                        </div>
                                        
                                        <p><?php echo $crow['comment']; ?></p>
                                        
                                        <a href="javascript:void(0);" id="<?php echo $crow['cid']; ?>" onClick="getReply(this.id)" class="reply"><?php echo $lang['REPLY']; ?></a>
                                        <div id="repdiv<?php echo $crow['cid']; ?>" style="display:none;" class="replydiv">        
                                            <form action="" method="post">
                                                <textarea class="form-control" maxlength="500" rows="1" id="comment" name="comment" placeholder="<?php echo $lang['ADDPUBLICREPLY']; ?>" required></textarea>
                                                <input type="hidden" name="backto" value="<?php echo $_REQUEST['vid']; ?>" />	
                                                <input type="hidden" name="cid" value="<?php echo $crow['cid']; ?>" />	
                                                <button type="submit" id="submit_reply" name="submit_reply" class="btn btn-dm"><?php echo $lang['REPLY']; ?></button>
                                            </form>
                                        </div>     
					
                                        <!-- REPLY -->
                                        <ul class="children">
                                            <?php
                                            $rqry="SELECT A.*, B.subid,B.firstname,B.lastname,B.photo,B.channel,B.channel_logo FROM video_comments A, kw_sub B
                                            WHERE (A.removed=0) AND (A.parent_id='".$crow['cid']."') AND (A.langid='".$_SESSION['SESSLANG']."') AND (B.subid=A.user_id) ORDER BY pinned, date DESC
                                            "; 
                                            $rres=$db->rq($rqry);
                                            $rnos=$db->num_rows($rres);
                                            if ($rnos>0) {
                                            while ($rrow=$db->afetch($rres)) {	
                                            ?>
                                               <li>
                                                    <div class="post_author">
                                                        <div class="img_in">
                                                            <a href="#">
                                                            <?php if ($rrow['channel']<>'' && $rrow['channel_logo']<>'') { ?>
                                                                <img src="<?php echo $config['baseurl']; ?>assets/img/user/<?php echo $rrow['channel_logo']; ?>" width="64" height="64" alt="<?php echo $rrow['channel']; ?>">
                                                                <?php }  else if ($rrow['channel']<>'' && $rrow['channel_logo']=='') { ?>
                                                                <img src="<?php echo $config['baseurl']; ?>build/img/noimg/channel.png" width="64" height="64" alt="<?php echo $rrow['channel']; ?>">
                                                                <?php }  else if ($rrow['channel']=='' && $rrow['photo']<>'') { ?>
                                                                <img src="<?php echo $config['baseurl']; ?>assets/img/user/<?php echo $rrow['photo']; ?>" width="64" height="64" alt="<?php echo $rrow['firstname'].' '.$rrow['lastname']; ?>">
                                                                <?php }  else if ($rrow['channel']=='' && $rrow['photo']=='') { ?>
                                                                <img src="<?php echo $config['baseurl']; ?>build/img/noimg/80.jpg" width="64" height="64" alt="<?php echo $rrow['firstname'].' '.$rrow['lastname']; ?>">
                                                            }
                                                            <?php } ?>
                                                            </a>
                                                        </div>
                                                        <a href="#" class="author-name"><?php echo $rrow['firstname'].' '.$rrow['lastname']; ?></a>
                                                        <time datetime="2017-03-24T18:18"><?php echo db_to_display_date($rrow['date'],10); ?></time>
                                                    </div>
                                                    <p><?php echo $rrow['comment']; ?></p>
                                                 </li>
                                            <?php } } ?>  
                                        </ul>
                                </li>
                            <?php } ?>    
                            </ul>

                            <?php
                            // Only 1 comment
                            //$is_commented=kwik_count("video_comments","langid='".$langid."' AND video_id='".$id."' AND user_id='".$_SESSION['SUBSUBID']."'");
                            //if ($is_commented==0) { 
                            ?>
                            <h3 class="post-box-title">Add Comments</h3>
                            
                            <?php
                            // Only Loggedin user can comment
                            if (!isset($_SESSION['SUBSUBID'])) {	
                            ?>
                            <a href="<?php echo $config['baseurl']; ?>login/view/<?php echo $_REQUEST['vid']; ?>" class="btn btn-sm btn-warning">Please login to leave your comment</a>
                            <?php } ?>
                            
                            <?php
                            // Channel blocked user can't comment
                            $blocked = kwik_count("channel_blocked_users","user='".$_SESSION['SUBSUBID']."'");
                            
                            if (isset($_SESSION['SUBSUBID']) && $blocked == 0) { 
                            ?>    
                            <form action="" method="post">
                               <textarea class="form-control" maxlength="500" rows="1" id="comment" name="comment" placeholder="<?php echo $lang['COMMENT']; ?>"></textarea>
                               	<input type="hidden" name="backto" value="<?php echo $_REQUEST['vid']; ?>" />	
                                <input type="hidden" name="vid" value="<?php echo $id; ?>" />	
                               <button type="submit" id="contact_submit" name="submit" class="btn btn-dm"><?php echo $lang['POSTCOMMENT']; ?></button>
                           </form>
                           <?php } ?>
                            
                            
                        </div>
                        <!-- // Comments -->
                   </div>
                </div> 
                        
            </div>

            <!-- Related Posts-->
            <div class="col-md-4">

                <div id="related-posts">

                    <div id="ads">
                        <?php
                        // Disply Ad
                        $location=4;
                        $default_image="page-default-right-420-240.jpg";
                        $rightq = "SELECT * FROM ads WHERE location = '".$location."' LIMIT 1";
                        $rres = $db->rq($rightq);
                        $rnos = $db->num_rows($rres);
                        $rrow = $db->afetch($rres);
                        $path = $config['baseurl']."assets/img/ads/";
                        if ($rnos==1) {
                            $img=$path.$rrow['image'];
                        } else {
                            $img=$path.$default_image;
                        }
                        ?>
                        <a href="<?php echo $rrow['link']; ?>" target="_blank" title="<?php echo $rrow['title']; ?>">
                            <img src="<?php echo $img; ?>" alt="<?php echo $rrow['alt']; ?>" style="margin-bottom:15px;" />
                        </a>    
                    </div>    
                            
                    <?php
                    // Related Videos
                    // Get records from the database
                    $related = mysql_real_escape_string($row['title'].','.$row['body'].','.$row['search_cats'].','.$row['search_tags']);
                    $rel_query="SELECT * FROM videos WHERE type='".$type."' AND rid!='".$vid."' AND MATCH(title,body,search_cats,search_tags) AGAINST ('".$related."' IN NATURAL LANGUAGE MODE) LIMIT 20";
                    $rel_result = $db->rq($rel_query);    			
                    $rel_nos = $db->num_rows($rel_result);

                    if($rel_nos == 0){ 
                    echo "<h5 style='margin-top:200px; margin-bottom:200px;'>Sorry, No related videos yet!</h2>";
                    } else { 
                    while($rel_row = $db->afetch($rel_result)){ 
                    ?> 
                    <!-- video item -->
                    <div class="related-video-item">
                        <div class="thumb">
                        <!--<small class="time">10:53</small>-->
                            <a href="<?php echo $config['baseurl']; ?>view/<?php echo $rel_row['rid']; ?>"><img src="<?php echo $config['baseurl']; ?>assets/uploads/<?php echo $rel_row['image']; ?>" alt="<?php echo $rel_row['title']; ?>" style="height:120px;" ></a>
                        </div>
                        <a href="#" class="title"><?php echo kwik_cut($rel_row['title'],80,'..', true); ?></a>
                        <a class="channel-name" href="<?php echo $config['baseurl']; ?>channel/<?php echo jay_get("kw_sub","subid='".$rel_row['author_id']."'","channel"); ?>"><i class="fa fa-check-circle"></i> <?php echo jay_get("kw_sub","subid='".$rel_row['author_id']."'","channel"); ?><span></a>
                        <a class="channel-name" href="#"><i class="fa fa-eye"></i> <?php echo number_format($rel_row['views']); ?> views</span></a>
                    </div>
                    <!-- // video item -->
                    <?php }} ?>

                </div>

            </div><!-- // col-md-4 -->

        </div><!-- // row -->

    </div>

</div>

      <?php  require_once(DIR_INC . 'footer.php'); ?>
      <?php  require_once(DIR_INC . 'footer-js.php'); ?>


<script type="text/javascript">


function likeIt(id) {
var id = id;

		$.ajax({ 
		  type: "GET",
			url: "<?php echo $config['baseurl']; ?>project/ax/like_it.php",
			data:'tolike='+id,
			type: "POST",
			success: function (data){
			if(data==1) {
			alert("You must be logged in to like.");
			} else if (data==2) {
			alert("Liked successfully.");
			}
				$("#watch").load(location.href + " #watch");
				}
		});

}


function dislikeIt(id) {
var id = id;

		$.ajax({ 
		  type: "GET",
			url: "<?php echo $config['baseurl']; ?>project/ax/dislike_it.php",
			data:'todislike='+id,
			type: "POST",
			success: function (data){
			if(data==1) {
			alert("You must be logged in to dislike.");
			} else if (data==2) {
			alert("Disliked successfully.");
			}
				$("#vshare").load(location.href + " #vshare");
				}
		});

}


function subscribeIt(id) {
var id = id;

		$.ajax({ 
		  type: "GET",
			url: "<?php echo $config['baseurl']; ?>project/ax/subscribe_it.php",
			data:'tosub='+id,
			type: "POST",
			success: function (data){
			if(data==1) {
			alert("You must be logged in to subscribe.");
			} else if (data==2) {
			alert("subscribed successfully.");
			}
				$("#chitem").load(location.href + " #chitem");
				}
		});

}


function unsubscribeIt(id) {
var id = id;

		$.ajax({ 
		  type: "GET",
			url: "<?php echo $config['baseurl']; ?>project/ax/unsubscribe_it.php",
			data:'tounsub='+id,
			type: "POST",
			success: function (data){
			if(data==1) {
			alert("You must be logged in to unsubscribe.");
			} else if (data==2) {
			alert("Unsubscribed successfully.");
			}
				$("#chitem").load(location.href + " #chitem");
				}
		});

}


</script>

<script>
$(".embed").click(function(){
    $("#vembed").toggle();
    
});   
</script>

    
    
<script>
    function getReply(id) {
        
    <?php if (!isset($_SESSION['SUBSUBID'])) { ?>
    alert("Please login to reply."); exit();
    <?php } ?>
        
        
    var id = id;
    var repdiv = "repdiv"+id;

    if(document.getElementById(repdiv).style.display == 'none')
    {

        $("div#"+repdiv).removeClass("replydiv");
        $("div#"+repdiv).addClass("repopen");
        document.getElementById(repdiv).style.display='block';
    }
    else
    {
        document.getElementById(repdiv).style.display = 'none';
    }

    }

</script>
    
	</body>
	
</html>
