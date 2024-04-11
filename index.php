<?php
include ("incl/header.incl.php");
?>


<div class="container">
    <h1>Home</h1>
    <div class="span">
        <div class="row">
            <div class="col-md-12">
                <div class="span span3" >
                    <a href='farmers/index.php'>
                    <i class="fas fa-thin fa-hat-cowboy-side fa-8x"></i><br/>
                        <strong style="padding-top: 10px"> Farmers</strong>
                    </a>
                </div>
                <div class="span span3" >
                    <a href='employees/index.php'>
                    <i class="fas fa-thin fa-users fa-8x"></i><br/>
                        <strong style="padding-top: 10px">   Employees</strong>
                    </a>
                </div>
                <div class="span span3" >
                    <a href='delivery/index.php'>
                    <i class="fas fa-thin fa-truck fa-8x"></i><br/>
                        <strong>  Deliveries</strong>
                    </a>
                </div>
                <div class="span span3" >
                <a href='reports/index.php'>
                <i class="fas fa-thin fa-chart-simple fa-8x"></i><br/>
                        <strong>  Reports and Predictions</strong>
                    </a>
                </div>
                <div class="span span3" >
                    <a href='payment/index.php'>
                    <i class="fas fa-thin fa-credit-card fa-8x"></i><br/>
                        <strong> Payments</strong>
                    </a>
                </div>
                <div class="span span3" >
                    <a href='settings/index.php'>
                    <i class="fas fa-thin fa-gear fa-8x"></i><br/>
                        <strong style="padding-top: 10px">   Settings</strong>
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</div>


<?php
$footer = 'incl/footer.incl.php';
include ("$footer");
?>