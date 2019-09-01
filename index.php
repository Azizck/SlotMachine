<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		Slot Machine 
	</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body> 
<div id="main">
	<div id="line">.</div>
	<div id="container" class="reels">
</div>
<div id="container" class="reels">
</div>
<div id="container" class="reels">
</div>
</div>
</div>
<?php

		// uncomment for debugging 
		/**if(empty($_POST['same'])){
			echo "empty";
		}
		else {
			echo "filled";
			echo $_POST['same'] ;
		}
		*/
        // 2. Store data in the $_SESSION superglobal
		// same image or not 
        $_SESSION["bonus"] = $_POST["same"];
        // bet amount 
        $_SESSION["bet"] = $_POST["bet"];
        // name 
        $_SESSION["name"] = $_POST["name"];
       // uncomment for debugging 
        //	echo "this is bit "+$_SESSION["bet"];



        	if(empty($_POST['name']))
        	$_SESSION['credit'] = 100; 
        	else
        	$_SESSION['credit'] =$_POST['credit'] ; 


        $money=0;
        
        if( !empty($_POST['same'])){
         global $money; 	
	        if($_SESSION['bonus'] > 10){
	        		global $money;
	        	$money=$_SESSION['credit']+$_POST['bet'];
	        	echo  " <div id='win'>YOU WIN !!! </div>";
	       	 }else{
	        		global $money;
	       	 	$money = $_SESSION['credit']- $_POST['bet'];
	        	echo "<div id='lose'>YOU LOSE !!! </div>";
	       	 }

        	$_SESSION['credit'] =$money; 

		}




	        ?>

	<form  method="POST">
`
	Your name here: <input type="text" name="name"       minlength="1"  maxlength="15" value = <?= $_SESSION['name'] ?> >
	Your credit:  <input type="number"  readonly="true" name="credit" value = <?= $_SESSION['credit'] ?> >
	Bet : <input type="number" name="bet" min="0" max=10   required   value= <?= $_SESSION['bet'] ?> >  
	 <span class="error" aria-live="polite"></span>
</br>
		<input type="button" onclick="spin()" value="SPIN">
		<input type="number" id="same" name="same">


 </form>


<?php
$_GET['name']




?>

 </div>
</body>
	<script>



//window.addEventListener('load', function run (){
var form =	document.forms[0];
var b =	document.forms[0]['bet'].value;
var m =	document.forms[0]['credit'].value;
 var error = document.querySelector('.error');










// an array that stores all the fruits' images 
var fruits=["<div class='apple'><img src='images/apple.png'></div>",
	"<div class='cherry'><img src='images/cherry.png'></div>",
	"<div class='lemon'><img src='images/lemon.png'></div>",
	"<div class='pear'><img src='images/pear.png'></div>",
	"<div class='grapes'><img src='images/grapes.png'></div>",
	"<div class='orange'><img src='images/orange.png'></div>",
	"<div class='watermelon' ><img src='images/watermelon.png'></div>"
	];
// retrieve the fruits from the Document and store them in variables
var lemon=document.getElementsByClassName('lemon');
var cherry=document.getElementsByClassName('cherry');
var apple=document.getElementsByClassName('apple');
var pear=document.getElementsByClassName('pear');
var grapes=document.getElementsByClassName('grapes');
var orange=document.getElementsByClassName('orange');
var watermelon=document.getElementsByClassName('watermelon');
//temp  shouldbe delected  	
var bonus=10;
// retrive the image container that represents the reels by their class name 
var reels =document.getElementsByClassName('reels');
//call the function addImages to add the images to the reels  
//a function that spins the reels by scrolling the images containers 
function spinReels(){	
	// if the scroll has not reached the maxium, start scrolling   
	if(reels[0].scrollTop <= 749){
		//call the scroll function to scroll the boxes 
		scroll();
	// if scroll reachs maxium, assign the scroll top to zero 	
	}else {
		// assign the scroll top to zero if maximum is reached 
		reels[0].scrollTop=0;
		reels[1].scrollTop=0;
		reels[2].scrollTop=0;
	}
};

	// functin to generate images in the reels 
	function addImages(){

	// create an array with seven unique numbers .
	var arr = []
	while(arr.length < 7){
    var r = Math.floor(Math.random()*7) +0;
    if(arr.indexOf(r) === -1) arr.push(r);
	}

	var arr1 = []
	while(arr1.length < 7){
    var r = Math.floor(Math.random()*7) +0;
    if(arr1.indexOf(r) === -1) arr1.push(r);
	}

	var arr2 = []
	while(arr2.length < 7){
    var r = Math.floor(Math.random()*7) +0;
    if(arr2.indexOf(r) === -1) arr2.push(r);
	}

		// assgin the images to the three boxes 
		for(var i=0; i<7; i++){
			// first box(reel) 
			var rand = arr[i]; 
			reels[0].innerHTML+=fruits[rand];

		// second box(reel)
			var rand = arr1[i]; 
			reels[1].innerHTML+=fruits[rand];

		//third box or(reel)
			var rand = arr2[i]; 
			reels[2].innerHTML+=fruits[rand];
		}


};	

	// function to perform the scrolling of the three boxes by 5  pixles  
function scroll(){
	reels[0].scrollBy(0,5);
	reels[1].scrollBy(0,5);
	reels[2].scrollBy(0,5);
}

// test all images to find the aliged ones
function findAlignedImg(){
	//bonus=0;
	getYposition(apple);
	getYposition(orange);
	getYposition(cherry);
	getYposition(lemon);
	getYposition(pear);
	getYposition(watermelon);
	getYposition(grapes);
};


// function gets the Y position of the image  takes a fruit as a parameter 
function getYposition (fruit){
	var	yPosition=[];
	// store the Y position
	for(var i=0; i<fruit.length; i++){
		//var stores cherry value 
	console.log("index of: "+i);
	// store the Y position for each index of the fruit 
	yPosition[i]=fruit[i].getBoundingClientRect();//	
	console.log("the Y position of cherry is:"+yPosition[i]['y']);

	}

	detectAlignment(yPosition,fruit);

};
// function takes the Y postion of a fruit and detect if they are aligned horizontally 
function detectAlignment(yPosition,fruit){

	if ((yPosition[0]['y'] > 0 && yPosition[0]['y']<150) || (yPosition[1]['y'] > 0 && yPosition[1]['y']<150)){
	
		if( (yPosition[0]['y'] > 0 && yPosition==yPosition[2]['y'])){
			bonus+=1;
		console.log("two are same "+fruit.toString() + yPosition[0]['y'] +"  " + yPosition[2]['y']);
		}	
		if( (yPosition[0]['y']==yPosition[1]['y'])){
		console.log("two are same " + yPosition[0]['y'] +"  " + yPosition[1]['y']);
		bonus+=1;
		}
		if( (yPosition[1]['y'] > 0 && yPosition[1]['y'] < 150 && yPosition[1]['y']==yPosition[2]['y'])){
		bonus+=1;
		console.log("two are same "+fruit.toString() + yPosition[1]['y'] +"  " + yPosition[2]['y']);
		}
	}else{console.log("NONE ARE THE SAME ___________"+bonus+"_____________")}

		document.forms[0]['same'].value=bonus;
};
   

		
	addImages();
	function spin(){	
	var start= setInterval(spinReels,10);
	// variable contains function to clear interval taht stops the reels from spinning 
	var stop= function(){
		 clearTimeout(start)};


	// call the stop function after 5seconds of spinning 
	//shoud be five 
	setTimeout(stop,3000);
	//should be six 
	setTimeout(findAlignedImg,3001);


	var submit = function (){
	var a = document.forms[0]['bet'].value
	var b =	document.forms[0]['credit'].value
	var aa = parseInt(a);
	var bb = parseInt(b);
		   //if(document.forms[0]['bet'].value > document.forms[0]['credit'].value){
		   	if(aa>bb || bb == 0){
		   	console.log(document.forms[0]['bet'].value);
		   	console.log(document.forms[0]['credit'].value);
            // If the field is not valid, we display a custom error message.
            error.innerHTML = "emm, check your credit darling ! ";
            error.className = "error active";

			}
			else {
			document.forms["0"].submit();}};


	setTimeout(submit,4002);

	


	};
//});
	</script>


</html>