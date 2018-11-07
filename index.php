<?php include("Simulation.php"); 
if(isset($_POST['sub'])){
  $sim = new Simulation($_POST);
}

if(isset($_POST['random'])){

  $random = Simulation::generateRandomDigit();
  $sim = new Simulation($random);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <link rel="icon" href="assets/images/favicon.ico" type="image/gif" sizes="16x16">
  <title>Simulation</title>
</head>
<body>
  <div class="section header">  
    <div class="container py-4">
      <h3 class="text-center">Simulation of Single Channel Queuing System</h3>
    </div>
  </div>
  <br>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-md-5 jumbotron">
        <form action="" method="post">
          <div class="form-content">
            <div class="row">
              <div class="col-md-12">
                <p>Enter Random Digits<button type="button" id="btnAdd" class="btn btn-primary float-right">Add +</button></p>
                <hr/>
              </div>
            </div>
            <div class="row group">
              <div class="col-md-4">
                <div class="form-group">
                  <label>RD Arrival Time</label>
                  <input type="text" name="rd_arrival[]" class="form-control" required placeholder="RD Arrival Time" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>RD Service Time</label>
                  <input type="text" name="rd_service[]" class="form-control" required placeholder="RD Service Time" />
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <button type="button" class="btn btn-danger btnRemove mt-4">Remove</button>
                </div>
              </div>
            </div>
          </div>
          <p>
            <input type="submit" class="btn btn-success" name="sub" value="Submit">
          </p><br/>
        </form>

      </div>
      <div class="col-md-7 cus">
       <div class="row">
        <div class="col-md-6">
          <p>Distribution of Time Between Arrivals</p>
          <table class="table table-striped ">
            <thead>
              <tr>
                <th scope="col">Time Between Arrivals</th>
                <th scope="col">Random-Digit Assignment</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>001-125</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>126-250</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>251-375</td>
              </tr>
              <tr>
                <th scope="row">4</th>
                <td>376-500</td>
              </tr>
              <tr>
                <th scope="row">5</th>
                <td>501-625</td>
              </tr>
              <tr>
                <th scope="row">6</th>
                <td>626-750</td>
              </tr>
              <tr>
                <th scope="row">7</th>
                <td>751-875</td>
              </tr>
              <tr>
                <th scope="row">8</th>
                <td>876-000</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-6">
          <p>Service-Time Distribution</p>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Service Time</th>
                <th scope="col">Random-Digit Assignment</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>1-10</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>11-30</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>31-60</td>
              </tr>
              <tr>
                <th scope="row">4</th>
                <td>61-85</td>
              </tr>
              <tr>
                <th scope="row">5</th>
                <td>86-95</td>
              </tr>
              <tr>
                <th scope="row">6</th>
                <td>96-00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
<div class="section random">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <div class="row">
          <form action="" method="post">
              <input type="submit" class="btn btn-primary" value="Generate Random Values" name="random">
              </form>
          </div>
        </div>
      </div>
  </div>
</div>
<br>

<div class="section header">  
  <div class="container py-4">
    <h3 class="text-center">Simulation Table for Single Queueing Problem</h3>
  </div>
</div>
<br>
<br>

<div class="container">
  <div class="row">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Coustomer No</th>
          <th scope="col">Time Since Last Arrival</th>
          <th scope="col">Arrival Time</th>
          <th scope="col">Service Time</th>
          <th scope="col">Time Service Begins</th>
          <th scope="col">Customer Waits in Queue</th>
          <th scope="col">Time Service Ends</th>
          <th scope="col">Customer Spends in System</th>
          <th scope="col">Idle Time of Server</th>
        </tr>
      </thead>
      <?php if(isset($_POST['sub']) || isset($_POST['random'])):?>
        <tbody>
          <?php $n=1; ?>
          <?php for($j=0;$j<$sim->arivalLimit;$j++): ?>
            <tr>
              <th scope="row"><?php echo $n++?></th>
              <td><?php echo $sim->arrivalTime[$j] ? $sim->arrivalTime[$j] : '--' ; ?></td>
              <td><?php echo $sim->cumulativeArrivalTime ? $sim->cumulativeArrivalTime[$j] : '--' ; ?></td>
              <td><?php echo $sim->serviceTime ? $sim->serviceTime[$j] : '--' ; ?></td>
              <td><?php echo $sim->serviceBegains ? $sim->serviceBegains[$j] : '--' ; ?></td>
              <td><?php echo $sim->waitInQ ? $sim->waitInQ[$j] : '--' ; ?></td>
              <td><?php echo $sim->serviceEnd ? $sim->serviceEnd[$j] : '--'; ?></td>
              <td><?php echo $sim->customerSpendsInSystem ? $sim->customerSpendsInSystem[$j] : '--'; ?></td>
              <td><?php echo $sim->idleServerTime ? $sim->idleServerTime[$j] : '--'; ?></td>
            </tr>
          <?php endfor ; ?>
        </tbody>
      <?php else: ; ?>
       <tbody>
        <tr>
          <td scope="col" colspan="9" align="center"> No Data Found!</td>
        </tr>
      </tbody>
    <?php endif?>
    <?php if(isset($_POST['sub']) || isset($_POST['random'])):?>
      <thead>
        <tr>
          <th scope="col">Total</th>
          <th scope="col"></th>
          <th scope="col"></th>
          <th scope="col"><?php echo $sim->totalServiceTime?></th>
          <th scope="col"></th>
          <th scope="col"><?php echo $sim->totalWaitInQ?></th>
          <th scope="col"></th>
          <th scope="col"><?php echo $sim->totalTimeSpendsInSystem?></th>
          <th scope="col"><?php echo $sim->totalIdleTime?></th>
        </tr>
      </thead>
    <?php endif?>
  </table>
  <hr>
</div>
</div>
<br>
<br>
<?php if(isset($_POST['sub']) || isset($_POST['random'])):?>
  <div class="avarage-section">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="inner">
            <h5>Avarage Waiting Time</h5> 
            <p class="lead"><?php echo $sim->totalWaitInQ;?> / <?php echo $sim->arivalLimit;?> = <strong><?php echo $sim->avgWaitingTime;?></strong></p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="inner">
            <h5>Probability Wait In Queue</h5>
            <p class="lead"><?php echo $sim->customerWaitCount;?> / <?php echo $sim->arivalLimit;?> = <strong><?php echo $sim->probabilityCustomerHasToWait;?></strong></p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="inner">
            <h5>Probability of Idle Server</h5> 
            <p class="lead">
              <?php echo $sim->totalIdleTime; ?> / 
              <?php echo $sim->serviceEnd ? $sim->serviceEnd[$sim->arivalLimit-1] : 0 ;?> = 
              <strong><?php echo $sim->probabilityOfIdleTime;?></strong></p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="inner">
              <h5>Probability of Server Busy</h5>
              <p class="lead">1 - <?php echo $sim->probabilityOfIdleTime ? $sim->probabilityOfIdleTime : 0;?> = <strong><?php echo 1 - $sim->probabilityOfIdleTime;?></strong></p>
            </div>
          </div>        
        </div>
        <br>
        <div class="row">
          <div class="col-md-3">
            <div class="inner">
              <h5>Average Service Time</h5>
              <p class="lead"><?php echo $sim->totalServiceTime;?> / <?php echo $sim->arivalLimit;?> = <strong><?php echo $sim->avgServiceTime;?></strong></p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="inner">
              <h5>Average Inter Arrival Time</h5>
              <p class="lead"><?php echo $sim->cumulativeArrivalTime[$sim->arivalLimit - 1];?> / <?php echo $sim->arivalLimit - 1;?> = <strong><?php echo $sim->avgInterArrivalTime;?></strong></p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="inner">
              <h5>Avg Wait Time Whom wait</h5> 
              <p class="lead"><?php echo $sim->totalWaitInQ;?> / <?php echo $sim->numberOfCustomerWhoWait;?> = <strong><?php echo $sim->avgCusWaitTimeWhoWaitInQ;?></strong></p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="inner">
              <h5>Avg Time Spends</h5>
              <p class="lead"><?php echo $sim->totalTimeSpendsInSystem;?> / <?php echo $sim->arivalLimit;?> = <strong><?php echo $sim->avgTimeCusSpendsInSys;?></strong></p>
            </div>
          </div>       
        </div>
      </div>
    </div> 
  </div>
</div>
<?php endif?>
<br>
<br>
<br>
<footer class="footer py-5">
  <div class="container">
    <div class="row">
       <div class="col-md-6">
        <h5>Md. Fahim Shahriyear Hossain</h5>
        <h6>shahriyear@gmail.com</h6>
      </div>
      <div class="col-md-6">
        <h5><a href="https://www.facebook.com/shahriyear" target="_blank">fb.com/shahriyear</a></h5>
        <h6><a href="https://github.com/shahriyear" target="_blank">github.com/shahriyear</a></h6>
      </div>
    </div>
  </div>
</footer>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="jquery.multifield.min.js"></script>
<script>
  $('.form-content').multifield({
    section: '.group',
    btnAdd:'#btnAdd',
    btnRemove:'.btnRemove',
  });
</script>
</body>
</html>