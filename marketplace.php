<div class="row">

    <div class="col-12">

        <div class="main-card shadow-sm">

            <div class="row">

            <div class="col-lg-8">

	            <div class="row">

		            <div class="col-12">

			            <div class="main-card shadow-sm mt-0 mb-0">

				            <h6><b>Analysis</b></h6>

				            <div style="height: 12px"></div>

				            <div id="chartContainer2" style="height: 300px; width: 100%;"></div>

			            </div>

	                </div>

		            <div class="col-6 mt-5 mb-5">

			            <div class="main-card shadow-sm" style="padding: 0px;">

				            <div class="col-12 text-center pos-top">

				                <button class="btn btn-danger btn-sm">
						            <i class='bx bx-down-arrow-alt'></i>
						            BUY
					            </button>

				            </div>

				            <div class="col-12 pos-center">
					            <div class="row">
						            <div class="col-12 text-center">
							            <input type="text" class="custom-input form-control"/>
							            <span class="text-lg">kWh</span>
						            </div>
						            <div class="col-12 mt-2 text-center">
							            Amount in Naira: <span class="text-lg">&#8358; 0.00</span>
						            </div>
					            </div>
				            </div>

				            <div class="col-12 pos-bottom text-center text-primary p-4">
					            Current Rate: &#8358; 36.25
				            </div>

			            </div>

		            </div>

		            <div class="col-6 mt-5 mb-5">

			            <div class="main-card shadow-sm" style="padding: 0px;">

				            <div class="col-12 text-center pos-top">
					            <button class="btn btn-success btn-sm">
						            <i class='bx bx-up-arrow-alt'></i>
						            SELL
					            </button>
				            </div>

				            <div class="col-12 pos-center">
					            <div class="row">
						            <div class="col-12 text-center">
							            <span class="text-lg">min</span>
							            <input type="text" class="custom-input-2 form-control"/>
							            <span class="text-lg">kWh</span>
						            </div>
						            <div class="col-12 text-center mt-2">
							            <span class="text-lg">max</span>
							            <input type="text" class="custom-input-2 form-control"/>
							            <span class="text-lg">kWh</span>
						            </div>
					            </div>
				            </div>

				            <div class="col-12 pos-bottom text-center text-primary p-4">
					            Current Rate: &#8358; 36.25
				            </div>

			            </div>

		            </div>

            	</div>

            </div>

            <div class="col-lg-4">

                <div class="main-card shadow-sm mt-0">

            	    <h6><b>Recent Transactions</b></h6>

            	    <div style="height: 12px"></div>

            		<div class="table-responsive" style="font-size: 12px !important">

            	        <table class="table table-lg table-bordered table-hover table-striped">
            		        <thead>
            		            <tr>
            				        <th scope="col">Energy (W)</th>
            				        <th scope="col">Time</th>
            				        <th scope="col">Price</th>
            				    </tr>
            			    </thead>
            			    <tbody>

            	                <tr class='clickable-row' data-href='#'>
            				        <td>200W</td>
            				        <td>01:00:23</td>
            			            <td style="color: green"><b>N 0.45</b></td>
            			        </tr>

            				    <tr class='clickable-row' data-href='#'>
            				        <td>200W</td>
            				        <td>01:00:23</td>
            				        <td style="color: green"><b>N 0.45</b></td>
            				    </tr>

            			    </tbody>
            			</table>

            	    </div>
            	</div>

            </div>

        </div>

        </div>

    </div>

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
<input type="text" class="form-control">
</div>

<div class="mb-3">
<label for="exampleFormControlInput1" class="form-label">Device Name</label>
<input type="text" class="form-control">
</div>

<br>
<button class="btn btn-primary" style="width: 100%;">+ ADD</button>


</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-body">
<h6><b>Fridge #1</b></h6>
</div>

</div>
</div>
</div>

<script src="assets/js/canvasjs.min.js"></script>

<script>
	$(document).ready(function() {

		var chart = new CanvasJS.Chart("chartContainer2", {
			animationEnabled: true,
			theme: "light2",
			data: [{
				type: "candlestick",
				yValueFormatString: "$###0.00",
				xValueFormatString: "MMM",
				dataPoints: [
					{ x: new Date(2016, 00, 01), y: [34.080002, 36.060001, 33.410000, 36.060001] },
					{ x: new Date(2016, 01, 01), y: [36.040001, 37.500000, 35.790001, 36.950001] },
					{ x: new Date(2016, 02, 01), y: [37.099998, 39.720001, 37.060001, 39.169998] },
					{ x: new Date(2016, 03, 01), y: [38.669998, 39.360001, 37.730000, 38.820000] },
					{ x: new Date(2016, 04, 01), y: [38.869999, 39.669998, 37.770000, 39.150002] },
					{ x: new Date(2016, 05, 01), y: [39.099998, 43.419998, 38.580002, 43.209999] },
					{ x: new Date(2016, 06, 01), y: [43.209999, 43.889999, 41.700001, 43.290001] },
					{ x: new Date(2016, 07, 01), y: [43.250000, 43.500000, 40.549999, 40.880001] },
					{ x: new Date(2016, 08, 01), y: [40.849998, 41.700001, 39.549999, 40.610001] },
					{ x: new Date(2016, 09, 01), y: [40.619999, 41.040001, 36.270000, 36.790001] },
					{ x: new Date(2016, 10, 01), y: [36.970001, 39.669998, 36.099998, 38.630001] },
					{ x: new Date(2016, 11, 01), y: [38.630001, 42.840000, 38.160000, 40.380001] }
				]
			}]
		});
		chart.render();

	});
</script>
