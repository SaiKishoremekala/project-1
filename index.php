<?php
session_start();


include("connection.php");
extract($_REQUEST);
$arr=array();
if(isset($_GET['msg']))
{
	$loginmsg=$_GET['msg'];
}
else
{
	$loginmsg="";
}
if(isset($_SESSION['cust_id']))
{
	 $cust_id=$_SESSION['cust_id'];
	 $cquery=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
	 $cresult=mysqli_fetch_array($cquery);
}
else
{
	$cust_id="";
}
 





$query=mysqli_query($con,"select  tblvendor.fld_name,tblvendor.fldvendor_id,tblvendor.fld_email,
tblvendor.fld_mob,tblvendor.fld_address,tblvendor.fld_logo,tbcategory.category_id,tbcategory.category_name,tbcategory.cost,
tbcategory.description,tbcategory.paymentmode 
from tblvendor inner join tbcategory on tblvendor.fldvendor_id=tbcategory.fldvendor_id;");
while($row=mysqli_fetch_array($query))
{
	$arr[]=$row['category_id'];
	shuffle($arr);
}

//print_r($arr);

 if(isset($addtocart))
 {
	 
	if(!empty($_SESSION['cust_id']))
	{
		 
		header("location:form/cart.php?product=$addtocart");
	}
	else
	{
		header("location:form/?product=$addtocart");
	}
 }
 
 if(isset($login))
 {
	 header("location:form/index.php");
 }
 if(isset($logout))
 {
	 session_destroy();
	 header("location:index.php");
 }
 $query=mysqli_query($con,"select tbcategory.category_name,tbcategory.fldvendor_id,tbcategory.cost,tbcategory.description,tbcategory.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id from tbcategory inner  join tblcart on tbcategory.category_id=tblcart.fld_product_id where tblcart.fld_customer_id='$cust_id'");
  $re=mysqli_num_rows($query);
if(isset($message))
 {
	 
	 if(mysqli_query($con,"insert into tblmessage(fld_name,fld_email,fld_phone,fld_msg) values ('$nm','$em','$ph','$txt')"))
     {
		 echo "<script> alert('We will be Connecting You shortly')</script>";
	 }
	 else
	 {
		 echo "failed";
	 }
 }

?>

<!DOCTYPE html>
<html lang="en" >

<head>
	<title>Wedding Planner</title>
	<link href="css_1/bootstrap.min.css" rel="stylesheet">
	<!-- FontAwesome icon -->
	<link href="fontawesome/css/fontawesome-all.css" rel="stylesheet">
	<!-- Fontello icon -->
	<link href="fontello/css/fontello.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<!-- Style CSS -->
	<link href="css_1/style.css" rel="stylesheet">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
</head>

<body>
	
	<!-- header -->
	<div class="header">
		<!-- top - header -->
		<div class="header-top">
			<div class="container">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-sm-6 col-6 d-none d-xl-block d-lg-block d-md-block">
						<div class="header-text">
							<p class="wlecome-text">Welcome to Wedding Planner | We create - You celebrate</p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-sm-12 col-12">
						<div class="header-text text-right">
							<p>Are You a Vendor? <a href="vendor-new.php" class="text-white">Want to Become Vendor</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/.header-top -->
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-classic">
				<a class="navbar-brand" href="index.php">
					<img src="images/logo_1.jpg" alt="logo" class="img-fluid">
				</a>
				<?php if(!empty($cust_id)) { ?>	<a class="navbar-brand" style="color:black; text-decoratio:none;"><i class="far fa-user"> <?php echo $cresult['fld_name']; ?></i></a>
				<?php } ?>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbar-classic">
					<ul class="navbar-nav ml-auto mt-2 mt-lg-0 mr-3">
						<li class="nav-item active"> <a class="nav-link" href="index.php">Home
                
              </a>
						</li>
						<li class="nav-item"> <a class="nav-link" href="aboutus.php">About Us</a>
						</li>
						<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="menu-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Vendors Category
            </a>
							<ul class="dropdown-menu" aria-labelledby="menu-3">
								<li><a class="dropdown-item" href="venues.php" title="">Venues</a>
								</li>
								<li><a class="dropdown-item" href="photographers.php" title="">Photographers</a>
								</li>
								<li><a class="dropdown-item" href="catering.php" title="">Catering</a>
								</li>
								<li><a class="dropdown-item" href="florists.php" title="">Florists</a>
								</li>
								<li><a class="dropdown-item" href="invitations.php" title="">Invitations</a>
								</li>
								<li><a class="dropdown-item" href="lightings.php" title="">Lightings</a>
								<li><a class="dropdown-item" href="music_bands.php" title="">Music bands</a>
								</li>
								<li><a class="dropdown-item" href="parking.php" title="">Parking</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<form method="post" class="mb0">
								<?php if(empty($cust_id)) { ?>	<a href="form/index.php?msg=you must be login first"><span style="color:#de6693; font-size:28px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:red;" id="cart"  class="badge badge-light">0</span></i></span></a>
								&nbsp;&nbsp;&nbsp;
								<button class="btn-default btn-sm" name="login" type="submit">Log In</button>&nbsp;&nbsp;&nbsp;
								<?php } else { ?>	<a href="form/cart.php"><span style=" color:green; font-size:28px;"><i class="fa fa-shopping-cart" aria-hidden="true"><span style="color:green;" id="cart"  class="badge badge-light"><?php if(isset($re)) { echo $re; }?></span></i></span></a>
								<button class="btn-default btn-sm btn-outline-success" name="logout" type="submit">Log Out</button>&nbsp;&nbsp;&nbsp;
								<?php } ?>
							</form>
						</li>
					</ul>
				</div>
			</nav>
			<!--menu ends-->
		</div>
	</div>
	<!-- /.header endin -->

	 <!-- Message button -->
    <?php if(isset($_SESSION['cust_id'])){include 'message.php';}?>
    <!--/ . Message button -->
    
	<!--Static Banner-->
	<div class="hero-section">
		<div class="container">
			<div class="row">
				<div class="offset-xl-1 col-xl-10 offset-lg-1 col-lg-10 col-md-12 col-sm-12 col-12">
					<!-- search-block -->
					<div class="">
						<div class="text-center search-head">
							<h1 class="search-head-title">A Vision Beyond Your Dreams</h1>
							<p class="d-none d-xl-block d-lg-block d-sm-block text-white">Wedding Planner is the largest and most trusted global directory connecting engaged couples with local wedding professionals. Millions of couples around the world are able to search, compare and book from a directory of over 100+ vendors.</p>
						</div>
						<!-- /.search-block -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--//Static Banner-->
	<div class="space-medium">
		<div class="container">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 text-center">
					<div class="feature-block">
						<div class="circle-icon bg-info rounded-circle mb30"> <i class="icon-038-bouquet"></i>
						</div>
						<div class="feature-content">
							<h3>Hire the right vendor</h3>
							<p>The appropriate wedding plan requires dedication &amp; having the best possible vendors will play a big role in making it a success.</p>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 text-center">
					<div class="feature-block">
						<div class="circle-icon bg-danger rounded-circle mb30"> <i class="icon-013-calendar"></i>
						</div>
						<div class="feature-content">
							<h3>Wedding Planning Tools</h3>
							<p>The internet has gifted us with so many great digital resources for planning our weddings, many of which are affordable, or free.</p>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 text-center">
					<div class="feature-block">
						<div class="circle-icon bg-secondary rounded-circle mb30"> <i class="icon-021-love-1"></i>
						</div>
						<div class="feature-content">
							<h3>Wedding Tips &amp; advice</h3>
							<p>Ensure your special day goes without a hitch. From venues to the guest list, we’ve got the wedding planning tips.
								<!-- to ensure your big day is glitch free. -->
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- venue-categoris-section-->
	<div class="space-small">
		<div class="container-fluid">
			<div class="row">
				<div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
					<div class="section-title text-center">
						<!-- section title start-->
						<h2>Vendor Categories</h2>
					</div>
					<!-- /.section title start-->
				</div>
			</div>
			 <div class="container-fluid">
            <div class="row">

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card-category">                    	

                        <div class="category-image zoomimg"><a href="venues.php"><img src="images/wedding-venue.jpg" alt=""></a></div>
                        <div class="category-content">
                            <h3 class="cateogry-title"> <a href="venues.php">Venue</a> <span class="category-count">
	                        	<?php $sql=mysqli_query($con, "SELECT * from tbcategory tc left join tblvendor
								 tv on tv.fldvendor_id=tc.fldvendor_id where tc.category_name = 'Venue'
");


	                        $row=mysqli_num_rows($sql);


	                        echo $row;



	                         ?>

	                        </span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card-category">
                        <div class="category-image zoomimg"><a href="photographers.php"><img src="images/wedding_photographer.jpg" alt=""></a></div>
                        <div class="category-content">
                            <h3 class="cateogry-title"> <a href="photographers.php">Photographer</a> <span class="category-count">
                            	<?php $sql=mysqli_query($con, "SELECT * from tbcategory tc left join tblvendor
								 tv on tv.fldvendor_id=tc.fldvendor_id where tc.category_name = 'Photographer'
");


	                        $row=mysqli_num_rows($sql);


	                        echo $row;



	                         ?>
                            </span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card-category">
                        <div class="category-image zoomimg"><a href="florists.php"><img src="images/catergory-florist.jpg" alt=""></a></div>
                        <div class="category-content">
                            <h3 class="cateogry-title"><a href="florists.php">Florist</a> <span class="category-count">



                            	<?php $sql=mysqli_query($con, "SELECT * from tbcategory tc left join tblvendor
								 tv on tv.fldvendor_id=tc.fldvendor_id where tc.category_name = 'Florist'
");


	                        $row=mysqli_num_rows($sql);


	                        echo $row;



	                         ?>



                            </span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card-category">
                        <div class="category-image zoomimg"><a href="catering.php"><img src="images/catering.jpg" alt=""></a></div>
                        <div class="category-content">
                            <h3 class="cateogry-title"> <a href="catering.php">Wedding Catering</a> <span class="category-count">
                            	<?php $sql=mysqli_query($con, "SELECT * from tbcategory tc left join tblvendor
								 tv on tv.fldvendor_id=tc.fldvendor_id where tc.category_name = 'Catering'
");


	                        $row=mysqli_num_rows($sql);


	                        echo $row;



	                         ?>
                            </span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card-category">
                        <div class="category-image zoomimg"><a href="invitations.php"><img src="images/wedding-invitation.jpg" alt=""></a></div>
                        <div class="category-content">
                            <h3 class="cateogry-title"> <a href="invitations.php">Wedding  Invitation</a> <span class="category-count">
                            	<?php $sql=mysqli_query($con, "SELECT * from tbcategory tc left join tblvendor
								 tv on tv.fldvendor_id=tc.fldvendor_id where tc.category_name = 'Wedding Invitation'
");


	                        $row=mysqli_num_rows($sql);


	                        echo $row;



	                         ?>
                            </span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card-category">
                        <div class="category-image zoomimg"><a href="lightings.php"><img src="images/wedding-lighting.jpg" alt=""></a></div>
                        <div class="category-content">
                            <h3 class="cateogry-title"><a href="lightings.php">Lighting</a> <span class="category-count">
                            	<?php $sql=mysqli_query($con, "SELECT * from tbcategory tc left join tblvendor
								 tv on tv.fldvendor_id=tc.fldvendor_id where tc.category_name = 'Lighting'
");


	                        $row=mysqli_num_rows($sql);


	                        echo $row;



	                         ?>
                            </span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card-category">
                        <div class="category-image zoomimg"><a href="music_bands.php"><img src="images/music_band_1.jpg" alt=""></a></div>
                        <div class="category-content">
                            <h3 class="cateogry-title"> <a href="music_bands.php">Music Bands</a> <span class="category-count">
                            	<?php $sql=mysqli_query($con, "SELECT * from tbcategory tc left join tblvendor
								 tv on tv.fldvendor_id=tc.fldvendor_id where tc.category_name = 'Music Band'
");


	                        $row=mysqli_num_rows($sql);


	                        echo $row;



	                         ?>
                            </span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="card-category">
                        <div class="category-image zoomimg"><a href="parking.php"><img src="images/parking_2.jpg" alt=""></a></div>
                        <div class="category-content">
                            <h3 class="cateogry-title"><a href="parking.php">Parking</a> <span class="category-count">
                            	<?php $sql=mysqli_query($con, "SELECT * from tbcategory tc left join tblvendor
								 tv on tv.fldvendor_id=tc.fldvendor_id where tc.category_name = 'Parking'
");


	                        $row=mysqli_num_rows($sql);


	                        echo $row;



	                         ?>
                            </span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
				<!-- <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center mt30"><a href="#" class="btn btn-default btn-lg">View All category</a></div>
            </div> --></div>
			<!-- /.venue-categoris-section-->
			</div>
		<div class="bg-white space-medium">
			<div class="container">
				<div class="row">
					<div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
						<div class="section-title text-center">
							<!-- section title start-->
							<h2 class="mb10">How it Works</h2>
							<p>Simple and easy step to get started your wedding planning.</p>
						</div>
						<!-- /.section title start-->
					</div>
				</div>
				<div class="row">
					<!-- feature-block-->
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
						<div class="feature feature-icon-block">
							<div class="feature-icon"><i class="icon icon-017-location icon-3x icon-default"></i>
							</div>
							<div class="feature-content">
								<h3 class="mb-3">Search Supplier</h3>
								<p>Find the perfect wedding suppliers you've always dreamed about. Wedding Planner offers the most comprehensive directory of wedding suppliers.</p>
							</div>
						</div>
					</div>
					<!-- /.feature-block-->
					<!-- feature-block-->
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
						<div class="feature feature-icon-block">
							<div class="feature-icon"> <i class="icon icon-004-chat icon-3x icon-default"></i>
							</div>
							<div class="feature-content">
								<h3 class="mb-3">Book Perfect Vendor</h3>
								<p>Vendor should be reliable – someone you can depend on. They should be hardworking, not entitled. Vendors are more than just wedding suppliers.</p>
							</div>
						</div>
					</div>
					<!-- /.feature-block-->
					<!-- feature-block-->
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
						<div class="feature feature-icon-block">
							<div class="feature-icon"><i class="icon icon-025-groom icon-3x icon-default"></i>
							</div>
							<div class="feature-content">
								<h3 class="mb-3">Celebrate Wedding Day</h3>
								<p>Since your original wedding date marks the day you planned to formally seal your marriage, honor the intention by reciting your vows together.</p>
							</div>
						</div>
					</div>
					<!-- /.feature-block-->
				</div>
			</div>
		</div>
		<div class="cta-third">
			<div class="container">
				<div class="row d-flex align-items-center">
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
						<div class="cta-third-content">
							<h2 class="text-white mb0">Join us and help create a better future.</h2> 
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 text-right"> <a href="vendor-new.php" class="btn btn-default">Join our Team</a>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
						<!-- footer-widget -->
						<div class="footer-widget">
							<a href="#">
								<img src="http://localhost/WeddingPlanner_1/assets/images/logo_1.png" alt="" class="mb20">
							</a>
							<p class="mb0">Wedding Planner is the largest and most trusted global directory connecting engaged couples with local wedding professionals.</p>
							<p>Millions of couples around the world are able to search, compare and book from a directory of over 500+ vendors.</p>
						</div>
						<div class="admin_section">
							<ul class="footer_menu">
								<li><a href="admin.php">Admin Login</a>
								</li>
								<li><a href="vendor-new.php">Vendor Registration</a>
								</li>
								<li><a href="vendor_login.php">Vendor Login</a>
								</li>
							</ul>
						</div>
					</div>
					<!-- /.footer-widget -->
				</div>
			</div>
		</div>
		<div class="tiny-footer">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
						<p>© 2021 Wedding Planner. All Rights Reserved | Developed By <a href="http://binduchaithanya.co.in/">B'Webs</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		
		<!--footer primary-->
</body>

</html>