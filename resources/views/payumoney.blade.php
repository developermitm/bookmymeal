
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>

    <button id="rzp-button1">Pay</button>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>var options = {
        "key": "rzp_test_kHIhyHpD7UDski", 
        "amount": "50000", 
        "currency": "INR",    
        "name": "Acme Corp", 
        "description": "Test Transaction", 
        "image": "https://example.com/your_logo",    
        "order_id": "order_HZIKYOh2a8XLHS", 
        "handler": function (response){ 
            alert("payment_id :" + response.razorpay_payment_id);        
            alert("order_id :" +response.razorpay_order_id);        
            alert("signature :" +response.razorpay_signature) 
        }, 
        "prefill": { 
            "name": "Gaurav Kumar", 
            "email": "gaurav.kumar@example.com",        
            "contact": "9999999999" 
        }, "notes": { 
        "address": "Razorpay Corporate Office" 
        }, 
        "theme": { 
            "color": "#3399cc" 
        }};

        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', 
        function (response){        
        alert(response.error.code);        
        alert(response.error.description);        
        alert(response.error.source);        
        alert(response.error.step);        
        alert(response.error.reason);        
        alert(response.error.metadata.order_id);        
        alert(response.error.metadata.payment_id);});
        document.getElementById('rzp-button1').onclick = function(e){   
             rzp1.open();    
         e.preventDefault();
     }
 </script>

</body>
</html>