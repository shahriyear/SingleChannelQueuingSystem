<?php

/*
@Author Shahriyear
*/


class Simulation 
{
	//----------------------------------------------------------------------------------
	//--------------------------------Controller Start----------------------------------
	//----------------------------------------------------------------------------------

	//----------------------------------Problem Set 1-----------------------------------

	// public $arivalLimit = 10;
	// public $randNumberForArrival = [0, 913, 727, 015, 948, 309, 922, 753, 235, 302];
	// public $randNumberForService = [84, 10, 74, 53, 17, 79, 91, 67, 89, 38];

	//----------------------------------Problem Set 2-----------------------------------

	// public $arivalLimit = 5;
	// public $randNumberForArrival = [0, 25, 45, 65, 14];
	// public $randNumberForService = [14, 65, 47, 24, 14];

	//----------------------------------------------------------------------------------
	//--------------------------------Controller End------------------------------------
	//----------------------------------------------------------------------------------




	
	//----------------------------------------------------------------------------------
	//---------------------------------Initialization-----------------------------------
	//----------------------------------------------------------------------------------
	//Arrival time
	public $randNumberForArrival;
	public $arrivalTime = [0];
	public $cumulativeArrivalTime = [];

	//Service time
	public $randNumberForService;
	public $serviceTime = [];
	public $serviceBegains = [0];
	public $serviceEnd = [];
	public $waitInQ = [];
	public $customerSpendsInSystem = [];
	public $idleServerTime = [];
	
	//total
	public $totalWaitInQ = 0;
	public $totalServiceTime = 0;
	public $totalTimeSpendsInSystem = 0;
	public $totalIdleTime = 0;
	public $numberOfCustomerWhoWait= 0;

	//avarage
	public $avgWaitingTime = 0;
	public $customerWaitCount = 0; 
	public $probabilityCustomerHasToWait = 0;
	public $probabilityOfIdleTime = 0;
	public $avgServiceTime = 0;
	public $avgInterArrivalTime = 0;
	public $avgCusWaitTimeWhoWaitInQ = 0;
	public $avgTimeCusSpendsInSys = 0;

	public function __construct($arg){
		// echo "<pre/>";
		// print_r($arg);
		// exit;
		$this->getUserData($arg);
		$this->initWaitInQ();

		$this->randForArrivalTime();
		$this->addArivalTime();

		$this->randForServiceTime();
		$this->serviceAll();
		$this->spendsInSystem();
		$this->idleServer();

		$this->totalWaitingTime();
		$this->totalService();
		$this->totalTimeInsystem();
		$this->totalIdle();

		$this->avgWaitTime();
		$this->probabilityThatACustomerHasToWait();
		$this->probabilityOfIdleTimeServer();
		$this->avarageServiceTime();
		$this->avarageInterArrivalTime();
		$this->numberOfCustomerWhoWaitInQ();
		$this->avgCustomerWaitTimeWhoWaitInQ();
		$this->avarageTimeCustomerSpendsInSystem();

	}


	public function getUserData($arg){
		$this->arivalLimit = count($arg['rd_arrival']);
		for($i=0;$i<$this->arivalLimit;$i++){
			$this->randNumberForArrival[$i] = $arg['rd_arrival'][$i];
			$this->randNumberForService[$i] = $arg['rd_service'][$i];
		}
	}

	//set wait in q default = 0
	public function initWaitInQ(){
		for($i=0;$i<$this->arivalLimit;$i++){
			$this->waitInQ[$i] = 0;
			$this->idleServerTime[$i] = 0;
		}
		return true;
	}
	//----------------------------------------------------------------------------------
	//-----------------------------Initialization End-----------------------------------
	//----------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------
	//-----------------------------Helper Functions-------------------------------------
	//----------------------------------------------------------------------------------
	
	//two decimal number
	public function roundNumber($num){
		$num = number_format((float)$num, 2, '.', '');
		return $num;
	}

	//----------------------------------------------------------------------------------
	//-----------------------------Helper Function End----------------------------------
	//----------------------------------------------------------------------------------

	//Arrival time
	public function randForArrivalTime()
	{
		
		for($i=1;$i<$this->arivalLimit;$i++){
			if(001<=$this->randNumberForArrival[$i] && $this->randNumberForArrival[$i]<=125){
				$value = 1;	
			}
			elseif(126<=$this->randNumberForArrival[$i] && $this->randNumberForArrival[$i]<=250){
				$value = 2;	
			}
			elseif(251<=$this->randNumberForArrival[$i] && $this->randNumberForArrival[$i]<=375){
				$value = 3;	
			}
			elseif(376<=$this->randNumberForArrival[$i] && $this->randNumberForArrival[$i]<=500){
				$value = 4;	
			}
			elseif(501<=$this->randNumberForArrival[$i] && $this->randNumberForArrival[$i]<=625){
				$value = 5;	
			}
			elseif(626<=$this->randNumberForArrival[$i] && $this->randNumberForArrival[$i]<=750){
				$value = 6;	
			}
			elseif(751<=$this->randNumberForArrival[$i] && $this->randNumberForArrival[$i]<=875){
				$value = 7;	
			}
			elseif(876<=$this->randNumberForArrival[$i] && $this->randNumberForArrival[$i]<=999 || $this->randNumberForArrival[$i]==0){
				$value = 8;	
			}
			$this->arrivalTime[$i] = $value;
		}
		return true;
	}

	//Cumutative Arrival Time
	public function addArivalTime(){
		$add=0;
		for($i=0;$i<$this->arivalLimit;$i++){
			$add += $this->arrivalTime[$i];
			$this->cumulativeArrivalTime[$i] = $add;
		}
		return true;
	}

	//Service time
	public function randForServiceTime()
	{
		
		for($i=0;$i<$this->arivalLimit;$i++){
			if(1<=$this->randNumberForService[$i] && $this->randNumberForService[$i]<=10){
				$value = 1;	
			}
			elseif(11<=$this->randNumberForService[$i] && $this->randNumberForService[$i]<=30){
				$value = 2;	
			}
			elseif(31<=$this->randNumberForService[$i] && $this->randNumberForService[$i]<=60){
				$value = 3;	
			}
			elseif(61<=$this->randNumberForService[$i] && $this->randNumberForService[$i]<=85){
				$value = 4;	
			}
			elseif(86<=$this->randNumberForService[$i] && $this->randNumberForService[$i]<=95){
				$value = 5;	
			}
			elseif(96<=$this->randNumberForService[$i] && $this->randNumberForService[$i]<=99 || $this->randNumberForService[$i] == 0){
				$value = 6;	
			}
			$this->serviceTime[$i] = $value;
		}
		return true;
	}

	//Service Begains Wait End
	public function serviceAll(){
		
		for($i=1,$j=0;$i<$this->arivalLimit;$i++,$j++){
			
			$this->serviceEnd[0] = $this->cumulativeArrivalTime[0] + $this->serviceTime[0];

			if($this->serviceEnd[$j] < $this->cumulativeArrivalTime[$i]){
				$this->serviceBegains[$i] = $this->cumulativeArrivalTime[$i];
			}else{
				$this->serviceBegains[$i] = $this->serviceEnd[$j];
				$this->waitInQ[$i] = $this->serviceBegains[$i] - $this->cumulativeArrivalTime[$i];
			}
			$this->serviceEnd[$i] = $this->serviceTime[$i] + $this->serviceBegains[$i];
		}

		return true;
	}

	//Customer In System 
	public function spendsInSystem(){
		for($i=0;$i<$this->arivalLimit;$i++){
			$this->customerSpendsInSystem[$i] = $this->serviceTime[$i] + $this->waitInQ[$i];
		}
		return true;
	}

	//when server is idle
	public function idleServer(){

		for($i=1,$j=0;$i<$this->arivalLimit;$i++,$j++){
			if($this->serviceEnd[$j] < $this->cumulativeArrivalTime[$i]){
				$this->idleServerTime[$i] = $this->cumulativeArrivalTime[$i] - $this->serviceEnd[$j];
			}
			
		}
		return true;
	}

	//total waiting time
	public function totalWaitingTime(){
		for($i=0;$i<$this->arivalLimit;$i++){
			$this->totalWaitInQ += $this->waitInQ[$i];
		}
		return true;
	}

	//total service time
	public function totalService(){
		for($i=0;$i<$this->arivalLimit;$i++){
			$this->totalServiceTime += $this->serviceTime[$i];
		}
		return true;
	}

	//total time spends in system
	public function totalTimeInsystem(){
		for($i=0;$i<$this->arivalLimit;$i++){
			$this->totalTimeSpendsInSystem += $this->customerSpendsInSystem[$i];
		}
		return true;
	}
	
	//totalIdleTime
	public function totalIdle(){
		for($i=0;$i<$this->arivalLimit;$i++){
			$this->totalIdleTime += $this->idleServerTime[$i];
		}
		return true;
	}
	//avarage waiting time
	public function avgWaitTime(){
		$this->avgWaitingTime = $this->totalWaitInQ / $this->arivalLimit;
		$this->avgWaitingTime = $this->roundNumber($this->avgWaitingTime);
		return true;
	}
	//probability to wait customer
	public function probabilityThatACustomerHasToWait(){

		for($i=0;$i<$this->arivalLimit;$i++){
			if($this->waitInQ[$i] != 0){
				$this->customerWaitCount++;
			}
		}
		$this->probabilityCustomerHasToWait = $this->customerWaitCount / $this->arivalLimit;
		$this->probabilityCustomerHasToWait = $this->roundNumber($this->probabilityCustomerHasToWait);
		return true;
	}
	//probability to idle server
	public function probabilityOfIdleTimeServer(){

		$this->probabilityOfIdleTime = $this->totalIdleTime / $this->serviceEnd[$this->arivalLimit-1];
		$this->probabilityOfIdleTime = $this->roundNumber($this->probabilityOfIdleTime);
		return true;
	}

	//avarage service time
	public function avarageServiceTime(){
		$this->avgServiceTime = $this->totalServiceTime / $this->arivalLimit;
		$this->avgServiceTime = $this->roundNumber($this->avgServiceTime);
		return true;
	}
	//avarage inter arrival time
	public function avarageInterArrivalTime(){

		$this->avgInterArrivalTime = $this->cumulativeArrivalTime[$this->arivalLimit - 1] / ($this->arivalLimit - 1);
		$this->avgInterArrivalTime = $this->roundNumber($this->avgInterArrivalTime);
		return true;
	}

	//find the customer who wait in queue
	public function numberOfCustomerWhoWaitInQ(){
		for($i=0;$i<$this->arivalLimit;$i++){
			if($this->waitInQ[$i] != 0){
				$this->numberOfCustomerWhoWait++;
			}
		}
		return true;
	}
	// avarage customer wait time who wait in queue
	public function avgCustomerWaitTimeWhoWaitInQ(){
		$this->avgCusWaitTimeWhoWaitInQ =  $this->totalWaitInQ / $this->numberOfCustomerWhoWait;
		$this->avgCusWaitTimeWhoWaitInQ = $this->roundNumber($this->avgCusWaitTimeWhoWaitInQ);
		return true;
	}

	public function avarageTimeCustomerSpendsInSystem(){
		$this->avgTimeCusSpendsInSys = $this->totalTimeSpendsInSystem / $this->arivalLimit;
		$this->avgTimeCusSpendsInSys = $this->roundNumber($this->avgTimeCusSpendsInSys);
		return true; 
	}

	public static function generateRandomDigit(){
		$loop = mt_rand(10,50);
		for($i=0; $i<$loop;$i++){
			$random['rd_arrival'][$i] = mt_rand(0,999);
			$random['rd_service'][$i] = mt_rand(0,99);
		}
		$random['rd_arrival'][0] = 0;
		return $random; 
	}


}


	//----------------------------------------------------------------------------------
	//---------------------------------Function Calling---------------------------------
	//----------------------------------------------------------------------------------

	// $sim = new Simulation();



?>