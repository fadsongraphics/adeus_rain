<!DOCTYPE html>
<html>
<head>
	<title>ADEUS</title>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css"/>

	<!-- JS -->
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery-3.6.0.min.js"></script>

	<!-- Gilroy Font -->
    <link href="assets/gilroy-font/gilroy.css" rel="stylesheet"/>

	<!-- Icons -->
	<link href='assets/css/boxicons.min.css' rel='stylesheet'/>

</head>

<body>



<div class="modal fade" id="voiceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
	  <br>

	  <center><h4><i class='bx bx-microphone'></i></h4></center>

	  <div class="modal-header" style="border-bottom:none">
        <b><h5 class="modal-title" id="nlp_q">...</h5></b>
      </div>

      <div class="modal-body">
        <b id="nlp_r" style="color:red"></b>
      </div>
	  
    </div>
  </div>
</div>

<script>
    var postLink = "inc/post.php";
	var voiceModal = new bootstrap.Modal(document.getElementById("voiceModal"));
	var nlp;
	var new_trigger = 0;

	setInterval(function(){
		$.post(postLink, {tts:  1}, function(res){
			console.log(res);
            if (nlp = JSON.parse(res)){
				var trigger = nlp.trigger;
				document.getElementById('nlp_q').innerHTML = nlp.nlp_q;
				document.getElementById('nlp_r').innerHTML = nlp.nlp_r;
				if(new_trigger !== trigger){
					if(trigger=='false'){
						voiceModal.hide();
					}
					if(trigger=='true'){
						voiceModal.show();
					}
					new_trigger = trigger;
				}
			}

        });
	}, 100);
</script>



    <div class="sidenav">

        <div class="sidenav-top glass">

            <div class="sidenav-logo">

                <a href="dongle_view.php"><img src="assets/logo/adeus_logo.png" width="200"/></a>

            </div>

            <div class="sidenav-pad">

            	<a href="dongle_view.php">
        	    <div class="sidenav-item" id="homeNav">
        		    <div class="sidenav-icon">
        		        <i class='bx bx-home'></i>
        		    </div>
        		    <div class="sidenav-txt">
        		        Home
        		    </div>
        		    <div class="clearfix"></div>
        	    </div>
	        	</a>

        	    <div class="sidenav-item sidenav-active" id="dashboardNav" onclick="pager('dashboard.php', 'dashboardNav')">
        		    <div class="sidenav-icon">
        		        <i class='bx bx-window-alt'></i>
        		    </div>
        		    <div class="sidenav-txt">
        		        Dashboard
        		    </div>
        		    <div class="clearfix"></div>
        	    </div>

                <div class="sidenav-item" id="devicesNav" onclick="pager('devices.php', 'devicesNav')">
                    <div class="sidenav-icon">
                        <i class='bx bx-category-alt'></i>
                    </div>
                    <div class="sidenav-txt">
                        Devices
                    </div>
                    <div class="clearfix"></div>
                </div>

<!--         	    <div class="sidenav-item" id="billingNav" onclick="pager('billing.php', 'billingNav')">
        		    <div class="sidenav-icon">
        		        <i class='bx bx-wallet'></i>
        		    </div>
        		    <div class="sidenav-txt">
        		        Billing
        		        </div>
        		    <div class="clearfix"></div>
                </div>

        	    <div class="sidenav-item" id="marketNav" onclick="pager('marketplace.php', 'marketNav')">
        		    <div class="sidenav-icon">
        		        <i class='bx bx-home'></i>
        		    </div>
        		    <div class="sidenav-txt">
        		        Market
        		    </div>
        		    <div class="clearfix"></div>
        	    </div>

        	    <div class="sidenav-item"id="settingsNav" onclick="pager('settings.php', 'settingsNav')">
        		    <div class="sidenav-icon">
        		        <i class='bx bx-cog'></i>
        		    </div>
        		    <div class="sidenav-txt">
        		        Settings
        		    </div>
        		    <div class="clearfix"></div>
        	    </div>

        	    <div class="sidenav-item">
        		    <div class="sidenav-icon">
        		        <i class='bx bx-left-arrow-alt'></i>
        		    </div>
        		    <div class="sidenav-txt">
        		        Sign out
        		    </div>
        		    <div class="clearfix"></div>
        	    </div> -->

            </div>

        </div>

        <div class="sidenav-bottom">

            <img src="assets/images/tenor.gif"/>

            <div class="glass br-20 p-2" style="position: absolute; top: 10px; left: 10px; width: 200px; font-size: 16px;">

                <p>Hi! Vivian, The Market looks nice today !!</p>

                <p><a href="#" style="text-decoration: none;">See More <i class="bx bx-right-arrow-alt" style="font-size: inherit; line-height: inherit;"></i></a></p>

            </div>

        </div>

    </div>

    <div class="page-content">

	    <div class="page-nav">


		    <div class="nav-info">
		    </div>

		    <div class="nav-profile">
		        <img src="assets/images/male_avatar.png" style="width: inherit; height: inherit;" class="rounded-circle"/>
		    </div>

		    <div class="nav-rates">

			    <div class="nav-rate-energy">Energy Rates</div>

			    <img src="assets/images/ggbb1.jpg" class="nav-rate-icon-red">
			    <div class="nav-rate-price">₦ --</div>

			    <img src="assets/images/ggbb2.jpg" class="nav-rate-icon-red">
			    <div class="nav-rate-price">₦ --</div>

			    <div class="clearfix"></div>

		    </div>

    		<div class="search-icon" style="display: flex; justify-content: center; align-items: center;">
    		    <span class="bx bx-wifi-off" style="font-size: 30px"></span>
    		</div>
    		<div class="search-icon" style="display: flex; justify-content: center; align-items: center;" onclick="pager('dashboard.php', 'dashboardNav')">
    		    <span class="bx bx-refresh" style="font-size: 30px"></span>
    		</div>

    		<div class="clearfix"></div>

    	</div>

	<!-- end nav -->
