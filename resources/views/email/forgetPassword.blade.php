<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Forgot password </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
	@media (max-width: 500px) {
		div {
			font-size: 8px !important;
		}
		img{
			max-width:50px !important;
			max-height:50px !important;
		}
		.whiteboxContainer {
			margin: 10px 20px 5px 20px !important;
		}
	}
	</style>
</head>
<body style="font-family: Verdana, Geneva, sans-serif;box-shadow: 4px 4px 6px #c0c0c0, 0 -1px 6px #c0c0c0;border-radius:10px;margin:10px 10%; border: 1px solid rgb(239, 239, 254); background-color: rgb(237, 237, 237);">
<div>
   <div style="border-top-left-radius:10px;border-top-right-radius:10px;font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e
;font-family: sans-serif;background-color:#E77E22;padding:5px;" align="center" id="emb-email-header"><img style="padding:6px;border:3px solid #dcdcdc;box-shadow:2px 3px 14px #888;border: 0;-ms-interpolation-mode
: bicubic;display: block;max-width: 90px;" ></div>

	
	<div style="border-radius:10px;background-color: #fff;margin: 20px 40px 5px 40px;padding: 15px 35px;" class="whiteboxContainer" >
	<p>Dear {{ucfirst($data['name'])}},
		<br>
		<center><strong>{{$data['otp']}}</strong></center> 
	</p>
	<p> You recently requested a new password. We've received the request and please enter you <strong>OTP</strong> to verify your account.</b>.</p>
	<br>
	
	Thanks,<br>
	

	</p>
	
	</div>
	
	<div style="font-size:12px;margin-bottom:10px;padding:10px;font-style:italic;text-align:center;">Need more help getting started? Contact Us. We’re here to help you.</div>
	
</div>
</body>
</html>
