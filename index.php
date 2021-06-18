<?php

require_once "inc/session.php";
require_once "inc/conn.php";

$db->exec("UPDATE meta_data SET value='false' WHERE meta='trigger'");


	require_once "nav.php";
	echo "<div id='page'>";
if(get('page')){

	require_once get('page').".php";
	?>
	<script>$(".sidenav-item").removeClass('sidenav-active');$("#<?php echo get('page');?>Nav").addClass('sidenav-active');</script>
	<?php

}else{

	require_once "dashboard.php";

}


 ?>

</body>

<script type="text/javascript">

	var loader = "<div class='container-fluid' style='height:100vh;'><div class='row'><div class='col-12' style='display: flex; height: 70vh; align-items: center; justify-content: center;'><img src='assets/images/loader.gif' width='100px' height='100px'/></div</div></div>"; // This should  loading gif image

	function showLoader(){
		$("#page").fadeOut('fast', function(){
			$("#page").empty();
			$("#page").html(loader);
			$("#page").fadeIn('fast');
		});
	}

	function pager(e, f){
		showLoader();
		setTimeout(function(){

			$.ajax({
			    type: "GET",
			    url: e,
			    data: {},
			    success: function(result){

    				$("#page").fadeOut('fast', function(){

					$("#page").empty();
    				$("#page").html(result);
    				$("#page").fadeIn('medium');
    				});

    				$(".sidenav-item").removeClass('sidenav-active');
    				$("#"+f).addClass('sidenav-active');

			    },
			    error: function(){

			        $("#page").hide();

			        var result = '<div class="row"><div class="col-12"><div class="glass p-5"><div class="row"><div class="col-lg-12 p-5 text-center br-20" style="display: flex; align-items: center; justify-content: center; height: 70vh"><div><h1><span class="bx bx-accessibility"></span>No internet connection</h1></div></div></div></div></div></div>';

    				$("#page").html(result);
    				$("#page").fadeIn();

    				$(".sidenav-item").removeClass('sidenav-active');

			    }

			});

		}, 800);
	};

	// pager('...billing.php', "billingNav");


	$(document).ready(function(){

	})
</script>
