<!DOCTYPE html>
<html>
<head>
    <title>Product Order Details</title>
    <meta charset="utf-8">
    <style type="text/css">
		.logo{
			height: 60px;
		}
        .no-spacing-bottom{
        	margin-bottom: 0;
			padding-bottom: 0;
        }		
        .company-name{
        	color: #9c762d;
        	font-size: 25px;
        }
        .company-info{
        	color: #9c762d;
        	font-size: 15px;
        }
        .text-center{
        	text-align: center;
        }
        .text-right{
        	text-align: right;
        }
        #customers {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        #customers td, #customers th {
          border: 1px solid #ddd;
          padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: center;
          background-color: #cca84a;
          color: white;
          font-weight: bold;
        }
	</style>
</head>
<body>
	<div class="col-md-12">
  		<center>
	  		<img class="logo text-center" src="https://ajaxdesign.duphilco.com/assets/images/logos/logo.png">
	  		<p>
	  			<span class="text-bold text-center company-name" style="color: #9c762d">AJAX TRADING CORPORATION</span>
	  			<br>
	  			<span class="text-bold text-center company-info">
	  				Unit 2201 22/F Cityland Pasong Tamo Tower, 2210 Don Chino Roces Ave., Pio del Pilar, Makati City
	  			</span>
	  			<br>
	  			<span class="text-bold text-center company-info">
	  				Phone Number: 0945584559
	  				<br>
	  				Email: Ajax.trading.corp@gmail.com
	  			</span>
	  		</p>
	  		<br>

	  		<h2 style="color: #9c762d">ORDER SUMMARY</h2>
	  		<br>
	  		
	  		<table width="100%">
	  			<tr>
	  				<td width="50%">Order Reference Number: {{$data['order_number']}}</td>
	  				<td width="50%">Phone Number: {{$data['phone_no']}}</td>
	  			</tr>
	  			<tr>
	  				<td width="50%">Customer Name: {{$data['customer_name']}}</td>
	  				<td width="50%">Email: {{$data['email']}}</td>
	  			</tr>
	  			<tr>
	  				<td width="100%">Appointment Schedule: {{$data['date']}}</td>
	  			</tr>
	  		</table>
	  		<br>

	  		<table id="customers">
	  		  	<tr>
		  		    <th></th>
		  		    <th>Details</th>
		  		    <th>Code</th>
		  		    <th>Price</th>
		  		</tr>
	  		  	<tr>
		  		    <td class="text-center">
		  		    	Product Name
		  		    </td>
		  		    <td class="text-center">
		  		    	{{$data['product_name']}}
		  		    </td>
		  		    <td class="text-center">-</td>
		  		    <td class="text-right">
		  		    	{{$data['product_price']}}
		  		    </td>
	  		  	</tr>

	  		  	<tr>
		  		    <td class="text-center">
		  		    	Product Style
		  		    </td>
		  		    <td class="text-center">
		  		    	{{$data['style_name']}}
		  		    </td>
		  		    <td class="text-center">-</td>
		  		    <td class="text-right">
		  		    	{{$data['style_price']}}
		  		    </td>
	  		  	</tr>

	  		  	<tr>
		  		    <td class="text-center">
		  		    	Layout Design
		  		    </td>
		  		    <td class="text-center">
		  		    	{{$data['layout_design']}}
		  		    </td>
		  		    <td class="text-center">-</td>
		  		    <td class="text-right">
		  		    	-
		  		    </td>
	  		  	</tr>

	  		  	<tr>
		  		    <td class="text-center">
		  		    	Product Size
		  		    </td>
		  		    <td class="text-center">
		  		    	{{$data['size_name']}}
		  		    </td>
		  		    <td class="text-center">-</td>
		  		    <td class="text-right">
		  		    	{{$data['size_price']}}
		  		    </td>
	  		  	</tr>

	  		  	<tr>
		  		    <td class="text-center">
		  		    	Product Color
		  		    </td>
		  		    <td class="text-center">
		  		    	{{$data['color']}}
		  		    </td>
		  		    <td class="text-center">
		  		    	{{$data['color_code']}}
		  		    </td>
		  		    <td class="text-right">
		  		    	{{$data['color_price']}}
		  		    </td>
	  		  	</tr>

	  		  @for($i=0; $i < (int)$data['feature_count']; $i++)
	  		  	@if($data['feature_name_'.$i] != 'none')
	  	  		  	<tr>
	  		  		    <td class="text-center">
	  		  		    	{{$data['feature_name_'.$i] ?? ''}}
	  		  		    </td>
	  		  		    <td class="text-center">
	  		  		    	{{$data['feature_detail_name'.$i] ?? ''}}
	  		  		    </td>
	  		  		    <td class="text-center">
	  		  		    	{{$data['feature_detail_code'.$i] ?? ''}}
	  		  		    </td>
	  		  		    <td class="text-right">
	  		  		    	{{$data['feature_detail_price'.$i] ?? ''}}
	  		  		    </td>
	  	  		  	</tr>
	  	  		@endif
	  		  @endfor
	  		  <tr>
		  		    <td class="text-center">
		  		    	Note/Remarks
		  		    </td>
		  		    <td class="text-center" colspan="3">
		  		    	{{$data['remarks']}}
		  		    </td>
	  		  	</tr>
	  		  <tr>
	  		  	<td class="text-center">Total Price</td>
	  		  	<td colspan="3" class="text-right">Php {{$data['final_price'] ?? 0}}</td>
	  		  </tr>
	  		</table>
	  		<br>
	  	</center>
	  	<p style="font-size: 12px; font-style: italic;">Note: Price indicate is only an estimate based on the features selected. Price will vary depending on the exact measurements done on-site and other additional features that the Client will opt to have.</p>
	  	<center>
	  		<br>
	  		<p style="font-size: 12px; font-style: italic;">************ THIS IS A AUTO GENERATED REPORT ************</p>
	  	</center>
	</div>
</body>
</html>