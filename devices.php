<?php

require_once "inc/session.php";
require_once "inc/conn.php";

$today = date('Y-m-d');
$energy_consumed = energy_format(($db->query("SELECT SUM(last_power) FROM device_power_graph"))->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'], 2);

?>


		<div class="row">

		    <div class="col-lg-6">

		        <div class="bg-white br-20 p-3" style="height: 100vh; position: relative;">

		            <div class="row m-0 p-0">

		                <div class="col-12">
		                    <h5>All Devices</h5>
		                </div>


                        <?php
                            $devices_sql = $db->query("SELECT * FROM device_summary");
                            $devices_list = array();

                            while ($ds_x = $devices_sql->fetchArray(SQLITE3_ASSOC)) {
                                $devices_list[] = $ds_x;
                            }

                            foreach ($devices_list as $d) {
                                if ($d['device_name']=='unknown') {
								$x_id = $d['device_id'];
								$off_time = $db->query("SELECT off_time FROM device_active WHERE device_id='$x_id' ORDER BY id DESC LIMIT 0,1")->fetchArray(SQLITE3_ASSOC)['off_time'];
								if (($off_time+60) > $time_buffer) {
                                	?>

                                <div class="col-6 p-0">

                                    <div class="p-3 br-20 m-2" style="background-color: #f5f5f5; color: #333; overflow: hidden;">

                                        <div style="display: inline;">
                                        </div>

                                        <div style="display: inline; margin-left: 5px;">

                                            <span class="font-weight-bold" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDevice" aria-controls="offcanvasDevice">NEW DEVICE - <?php echo $d['device_id']; ?></span>

                                        </div>


                                    </div>

                                </div>
                                <?php
		                            }
                                }else{
									$d_id= $d['device_id'];
									$last_active=$db->query("SELECT off_time FROM device_active WHERE device_id='$d_id'")->fetchArray()['off_time'];
									$active=false;
									if( time()-$last_active < 60){
										$active=true;
									}
									$active=true;
									?>

                                <div class="col-6 p-0">

                                    <div class="p-3 br-20 m-2" style="<?php echo $active ? @$styles[$d['device_name']]['bg'] : $styles['disabled']['bg']; ?> overflow: hidden; cursor: pointer;">

                                        <div style="display: inline;" onclick="showDeviceInfo('<?php echo $d['device_id'];?>')">

                                            <img src="assets/svgs/<?php echo @$styles[$d['device_name']]['icon']; ?>" style="width: 40px; height: 40px;"/>

                                        </div>

                                        <div style="display: inline; margin-left: 5px;" onclick="showDeviceInfo('<?php echo $d['device_id'];?>')">

                                            <span class="font-weight-bold" style="font-size: 12px; <?php echo $active ? @$styles[$d['device_name']]['color'] : $styles['disabled']['color']; ?>"><?php echo $d['device_name']; ?></span>

                                        </div>

                                        <div style="display: inline; float: right; margin-top: 3px">

                                            <label class="switch" style="transform: rotate(90deg)">
                                                <input <?php echo $active ? '': 'disabled';?> onclick="toggleDevice('<?php echo $d['device_id']; ?>')" type="checkbox" <?php echo $d['state'] ? "":"checked"; ?>  id="<?php echo $d['device_id'];?>_input">
                                                <span class="slider" <?php echo $active ? '': "style='background:grey'";?>></span>
                                            </label>

                                        </div>

                                    </div>

                                </div>


                    			<?php
                                }

							}

						?>

<!-- 						
		                <div class="col-6 p-0">

		                    <div class="p-3 br-20 m-2" style="background-color: #abffb3; color: white; overflow: hidden;">

		                        <div style="display: inline;">

    		                            <img src="assets/svgs/water-pump-g.svg" style="width: 40px; height: 40px;"/>

    		                    </div>

    		                    <div style="display: inline; margin-left: 5px;">

    		                        <span class="font-weight-bold" style="font-size: 12px; color: #02BC47;">Cooker</span>

    		                    </div>

    		                    <div style="display: inline; float: right; margin-top: 3px">

    		                        <label class="switch" style="transform: rotate(90deg)">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>

    		                    </div>

		                    </div>

		                </div>

		                <div class="col-6 p-0">

		                    <div class="p-3 br-20 m-2" style="background-color: #0055FF; color: white; overflow: hidden;">

		                        <div style="display: inline;">

    		                            <img src="assets/svgs/air-conditioner-w.svg" style="width: 40px; height: 40px; color; : red"/>

    		                    </div>

    		                    <div style="display: inline; margin-left: 5px;">

    		                        <span class="font-weight-bold" style="font-size: 12px;">Air Conditioner</span>

    		                    </div>

    		                    <div style="display: inline; float: right; margin-top: 3px">

    		                        <label class="switch" style="transform: rotate(90deg)">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>

    		                    </div>

		                    </div>

		                </div>

		                <div class="col-6 p-0">

		                    <div class="p-3 br-20 m-2" style="background-color: #0055FF; color: white; overflow: hidden;">

		                        <div style="display: inline;">

    		                            <img src="assets/svgs/air-conditioner-w.svg" style="width: 40px; height: 40px;"/>

    		                    </div>

    		                    <div style="display: inline; margin-left: 5px;">

    		                        <span class="font-weight-bold" style="font-size: 12px">Freezer</span>

    		                    </div>

    		                    <div style="display: inline; float: right; margin-top: 3px">

    		                        <label class="switch" style="transform: rotate(90deg)">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>

    		                    </div>

		                    </div>

		                </div>

		                <div class="col-6 p-0">

		                    <div class="p-3 br-20 m-2" style="background-color: #EDCBF9; color: white; overflow: hidden;">

		                        <div style="display: inline;">

    		                            <img src="assets/svgs/cooker-p.svg" style="width: 40px; height: 40px;"/>

    		                    </div>

    		                    <div style="display: inline; margin-left: 5px;">

    		                        <span class="font-weight-bold" style="font-size: 12px; color: #a653c9;">Water Heater</span>

    		                    </div>

    		                    <div style="display: inline; float: right; margin-top: 3px">

    		                        <label class="switch" style="transform: rotate(90deg)">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>

    		                    </div>

		                    </div>

		                </div>

		                <div class="col-6 p-0">

		                    <div class="p-3 br-20 m-2" style="background-color: #D9D8DD; color: white; overflow: hidden;">

		                        <div style="display: inline;">

    		                            <img src="assets/svgs/we2.svg" style="width: 40px; height: 40px;"/>

    		                    </div>

    		                    <div style="display: inline; margin-left: 5px;">

    		                        <span class="font-weight-bold" style="font-size: 12px; color: black;">Television</span>

    		                    </div>

    		                    <div style="display: inline; float: right; margin-top: 3px">

    		                        <label class="switch" style="transform: rotate(90deg)">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>

    		                    </div>

		                    </div>

		                </div> -->
						

		            </div>

		            <button class="btn btn-primary rounded-circle pos-center-bottom" style="width: 50px; height: 50px; padding: 0px; font-size: 45px; display: flex; align-items: center; justify-content: center;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDevice" aria-controls="offcanvasDevice">
		                +
		            </button>

		        </div>

		    </div>



            <!-- ############### -->
            <!-- start right panel -->
		    <div class="col-lg-6">

                <!-- all devices div -->
                <div  id="allDeviceInfo">

		        <div class="bg-2 br-20" style="padding: 20px; color: white;">

		            <div class="row">

		                <div class="col-4">

		                    <div>
		                        <span style="font-size: 12px;">
		                            <img src="assets/svgs/energy.svg" style="width: 15px; height: 15px; margin-right: 5px;"/>Energy Consumed
		                        </span>
		                    </div>

		                    <div class="mt-3">
		                        <span style="font-size: 18px;">Today</span><br/>
		                        <h6 style="font-weight: 900; font-size: 24px" class="mb-0" id="devicesSM"><?php echo $energy_consumed/1000; ?></h6>
		                    </div>


		                </div>

		                <div class="col-8">



		                </div>

		            </div>

		        </div>

		        <div class="bg-white br-20 p-3 mt-3" style="height: 80vh; position: relative;display: none">

		            <div class="row m-0 p-0">

		                <div class="col-12">
		                    <span style="font-size: 12px;">
		                            <img src="assets/svgs/energy1.svg" style="width: 15px; height: 15px; margin-right: 5px;"/>Energy Consumed
		                    </span>
		                </div>

		                <div class="col-12 mt-5">

		                    <div style="border-top: 1px dashed black; margin-top: 20px;"></div>

		                    <div style="border-top: 1px dashed black; margin-top: 80px;"></div>

		                    <div style="border-top: 1px dashed black; margin-top: 40px;"></div>

		                    <div style="border-top: 1px dashed black; margin-top: 40px;"></div>

		                </div>

		                <div class="col-12" style="margin-top: -225px;">

		                    <div class="row">

                                <div class="col-2" style="text-align: left;">

                                    <div style="width: 50px; text-align: center">

                                        <small>50W</small>

                                        <div style="background-color: #e9ecef; height: 200px; width: inherit; border-radius: 10px; position: relative;">

                                            <div style="width: inherit; height: 60%; background-color: #2D62ED; border-radius: 10px; position: absolute; bottom: 0px;"></div>

                                        </div>

                                        <small>AC</small>

                                    </div>

                                </div>

                                <div class="col-2" style="text-align: center;">

                                    <div style="width: 50px; text-align: center">

                                        <small>50W</small>

                                        <div style="background-color: #e9ecef; height: 200px; width: inherit; border-radius: 10px; position: relative;">

                                            <div style="width: inherit; height: 20%; background-color: #2D62ED; border-radius: 10px; position: absolute; bottom: 0px;"></div>

                                        </div>

                                        <small>AC</small>

                                    </div>

                                </div>

                                <div class="col-2" style="text-align: center;">

                                    <div style="width: 50px; text-align: center">

                                        <small>50W</small>

                                        <div style="background-color: #e9ecef; height: 200px; width: inherit; border-radius: 10px; position: relative;">

                                            <div style="width: inherit; height: 83%; background-color: #2D62ED; border-radius: 10px; position: absolute; bottom: 0px;"></div>

                                        </div>

                                        <small>AC</small>

                                    </div>

                                </div>

                                <div class="col-2" style="text-align: center;">

                                    <div style="width: 50px; text-align: center">

                                        <small>50W</small>

                                        <div style="background-color: #e9ecef; height: 200px; width: inherit; border-radius: 10px; position: relative;">

                                            <div style="width: inherit; height: 75%; background-color: #2D62ED; border-radius: 10px; position: absolute; bottom: 0px;"></div>

                                        </div>

                                        <small>AC</small>

                                    </div>

                                </div>

                                <div class="col-2" style="text-align: center;">

                                    <div style="width: 50px; text-align: center">

                                        <small>50W</small>

                                        <div style="background-color: #e9ecef; height: 200px; width: inherit; border-radius: 10px; position: relative;">

                                            <div style="width: inherit; height: 30%; background-color: #2D62ED; border-radius: 10px; position: absolute; bottom: 0px;"></div>

                                        </div>

                                        <small>AC</small>

                                    </div>

                                </div>

                                <div class="col-2" style="text-align: right;">

                                    <div style="width: 50px; text-align: center">

                                        <small>50W</small>

                                        <div style="background-color: #e9ecef; height: 200px; width: inherit; border-radius: 10px; position: relative;">

                                            <div style="width: inherit; height: 90%; background-color: #2D62ED; border-radius: 10px; position: absolute; bottom: 0px;"></div>

                                        </div>

                                        <small>AC</small>

                                    </div>

                                </div>

		                    </div>

		                </div>

		            </div>

		            <div class="row m-0 p-0 mt-3">

		                <div class="col-12">

		                    <small style="display: flex; align-items: center; margin-bottom: 8px">

    		                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; padding: 5px; background-color: #D9D8DD" class="rounded-circle">
    		                        <img src="assets/svgs/energy-b.svg" style="width: 25px; height: 25px;"/>
    		                    </div>
    		                    <span style="margin-left: 15px;">
    		                        150 Watts less energy used this month
    		                    </span>

    		                </small>

		                </div>

		            </div>

		            <div class="row m-0 p-0 mt-1">

		                <div class="col-6">

		                    <div style="overflow: hidden;">

		                        <div style="display: inline-block;">

    		                        <span style="font-size: 45px; color: #2D62ED">&#8358;</span>

    		                    </div>

    		                    <div style="display: inline-block; margin-left: 5px;">

    		                        <span class="font-weight-bold" style="font-size: 12px">Avg. days of Usage</span>  <br/>
    		                        <span style="font-weight: 900" class="mb-0">&#8358; 3900.00</span>

    		                    </div>

		                    </div>

		                </div>

		                <div class="col-6">

		                    <div style="overflow: hidden;">

		                        <div style="display: inline-block;">

    		                        <span><img src="assets/svgs/energy-b.svg" style="width: 45px; height: 40px; margin-top: -15px;"/></span>

    		                    </div>

    		                    <div style="display: inline-block; margin-left: 5px;">

    		                        <span class="font-weight-bold" style="font-size: 12px">Avg. days of Usage</span>  <br/>
    		                        <span style="font-weight: 900" class="mb-0">80 W</span>

    		                    </div>

		                    </div>

		                </div>

		            </div>

		            <div class="pos-center-bottom" style="width: 300px; display: flex; align-items: center; justify-content: center;">

		                <div class="bg-2 text-white rounded-circle" style="display: inline-flex; align-items: center; justify-content: center; padding: 15px; width: 75px; height: 75px;">
							<span class="bx bx-power-off" style="font-size: 40px;"></span>
		                </div>
						<div style="display: inline-flex; align-items: center; justify-content: center; height: 50px; width: 150px; margin-left: -20px; border-radius: 10px;" class="bg-2 text-white">
							<div class="m-0 p-0">
								<small>Content here</small>
								<div class="shadow-sm p-2 bg-white" style="border-radius: 10px; width: 100%; z-index: 1000">
								</div>
							</div>
						</div>

		            </div>

		        </div>


                </div>
                <!-- end all devices info -->

                <div id="singleDevice">

                </div>

		    </div>
            <!-- end right panel -->

		</div>


<!-- end #page div -->
	</div>
<!-- end .page-content div -->
</div>


<div class="clearfix"></div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDevice" aria-labelledby="offcanvasDeviceLabel">
	<div style="padding: 20px">
	  <div class="offcanvas-header">
	    <h6 class="offcanvas-title" id="offcanvasDeviceLabel"><b>Add new device</b></h6>
	    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	  </div>

	  <div class="offcanvas-body">

	    <div class="mb-3">
		  <label for="exampleFormControlInput1" class="form-label">Smart Socket Id</label>
	        <select name="socket_id" id="socket_id" class="form-control">
	            <?php
	            $sql = $db->query("SELECT device_id FROM device_summary WHERE device_name='unknown'");
	            $dev_list = array();
	            while ($y = $sql->fetchArray(SQLITE3_ASSOC)) {
	                $dev_list[] = $y;
	            }
	            foreach ($dev_list as $dl) {
	                ?>
	            <option value="<?php echo $dl['device_id'];?>"><?php echo $dl['device_id'];?></option>
	        <?php }?>
	        </select>
		</div>

	    <div class="mb-3">
		  <label for="exampleFormControlInput1" class="form-label">Device Name</label>
		  <select id="device_name" class="form-control" style="text-transform:capitalize;">
		  	<option>Select</option>
			  <?php $errr = array('fridge', 'tv', 'television', 'ac','air conditioner','pump','washing machine','dryer','cooking oven','freezer', 'microwave','ev','printer',
              'bulb','water pump','heater','cooker','kettle','light','speaker','refrigerator','fan');

			  foreach ($errr as $e){

			  ?>
		  	<option value="<?php echo $e;?>"><?php echo $e;?></option>
			<?php }?>
		  </select>
		</div>

		<br>
		<!-- <button class="btn btn-primary" onclick="add_device()" style="width: 100%;"  data-bs-toggle="offcanvas" data-bs-target="#offcanvasDevice" aria-controls="offcanvasDevice">+ ADD</button> -->


	  </div>
	</div>
</div>

<div class="modal fade" id="deviceModal">
  <div class="modal-dialog">
    <div class="modal-content">

		<div class="modal-header">
			Device Information
		</div>

      <!-- Modal body -->
      <div class="modal-body" id="deviceInfo">

      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
    var postLink = "inc/post.php";

    function toggleDevice(e){
    	var state = $("#"+e+"_input").prop('checked');
    	new_state = "0";
    	if(state){var new_state = '1';}
        $.post(postLink, {toggle_id: e, toggle_state: new_state}, function(res){
            // console.log(res);
        });
    }

    function showDeviceInfo(e){
        $.post(postLink, {device_graph:  e}, function(res){
            $("#deviceInfo").html(res);
			$("#deviceModal").modal("show");
        })
    }

    function add_device(){
        $.post(postLink, {add_device: 1, socket_id: $("#socket_id").val(), device_name: $("#device_name").val()}, function(res){
			$("#deviceModal").modal("hide");
             pager('devices.php', 'devicesNav');
        })
    }

    function delete_socket(e){
        $.post(postLink, {delete_device: e}, function(res){
            console.log(res);
			$("#deviceModal").modal("hide");
            pager('devices.php', 'devicesNav');
        })
    }



	
	function updatePage(){
		$.post(postLink, {update_page:  'devices'}, function(res){
			console.log(res);
            if (nlp = JSON.parse(res)){
				document.getElementById('devicesSM').innerHTML = nlp.devicesSM;

				var devices = nlp.devices;

				for (var i = devices.length - 1; i >= 0; i--) {
					if (devices[i].state==1) {
						$("#" + devices[i].device_id + "_input").prop("checked", true);
					}else{
						$("#" + devices[i].device_id + "_input").prop("checked", false);
					}

					if (devices[i].active=='true') {
						$("#" + devices[i].device_id + "_input").parent().show();
					}else{
						$("#" + devices[i].device_id + "_input").parent().hide();
					}
				}

				console.log(nlp);
				setTimeout(function(){
					updatePage();
				}, 3000);
			}

        });
	}

	updatePage();


</script>

<?php 
$db->close();
unset($db);
 ?>
