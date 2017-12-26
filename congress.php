<html>
    <head>
        <title>Homework 6: Server-side Scripting</title>
        <!--Embedded JavaScript code -->
        <script language="JavaScript">
            
            /**IMPORTANT NOTES: 
            *Sunlight API Key: dfbc7131ab4240338f3ac0d8bb9adcd6
            *Sunlight foundation web: http://congress.api.sunlightfoundation.com/
            */
            
            //Function to change keyword on select change
            function selectChange(){
                
                var selected = document.getElementById("congressDatabaseSelect").value;
                
                if(selected == "legislators"){
                    document.getElementById("keyword").innerHTML="State/Representative*";
                }
                else if(selected == "committees"){
                    document.getElementById("keyword").innerHTML="Committee ID*";
                }
                else if(selected == "bills"){
                    document.getElementById("keyword").innerHTML="Bill ID*";
                }
                else if(selected == "amendments"){
                    document.getElementById("keyword").innerHTML="Amendment ID*";
                }
                else{
                    document.getElementById("keyword").innerHTML="Keyword*";
                }
            }
        
            //Function for form validation when you click submit
            function validateFormFields(){
                
                var congressDatabaseField = document.forms["congressDatabaseForm"]["congressDatabase"].value;
                var keywordField = document.forms["congressDatabaseForm"]["keywordText"].value;
                
                
                if((congressDatabaseField == "Select your option") && (keywordField == null || keywordField == "")){
                    alert("Please enter the following missing information: Congress database, keyword");
                    return false;
                }
                
                else if((congressDatabaseField == "Select your option")){
                    alert("Please enter the following missing information: Congress database");
                    return false;
                }
                else if((keywordField == null || keywordField == "")){
                    alert("Please enter the following missing information: Keyword");
                    return false;
                }
            }
            
            //Function to Clear form
            function clearForm(){
                
                //Reset form fields to initial state
                document.forms["congressDatabaseForm"]["congressDatabase"].value="Select your option";
                document.forms["congressDatabaseForm"]["keywordText"].value="";
                document.forms["congressDatabaseForm"]["chamber"].value="senate";
                selectChange();
                
                //clear result area
                document.getElementById("resultsArea").innerHTML="";
            }
            
            //Function to view Details of legislators
            function viewLegislatorDetails(encodedArray){
                var legDetails = encodedArray;
                var parsedDetails = JSON.parse(legDetails);
        
                //Get required information
                var legislatorImage ="<img src=\"https://theunitedstates.io/images/congress/225x275/"+parsedDetails.results[0].bioguide_id+".jpg\"></img>";
                var name = parsedDetails.results[0].first_name+" "+parsedDetails.results[0].last_name;
                var fullName =parsedDetails.results[0].title+" "+parsedDetails.results[0].first_name+" "+parsedDetails.results[0].last_name;
                var termEnds =parsedDetails.results[0].term_end;
                
                if(parsedDetails.results[0].website == null){
                    var website ="N/A";
                }
                else{
                    var website =parsedDetails.results[0].website;
                }
                
                var office =parsedDetails.results[0].office;
                
                if(parsedDetails.results[0].facebook_id == null){
                    var facebook ="N/A";
                    name="N/A";
                }
                else{
                    var facebook ="https://www.facebook.com/"+parsedDetails.results[0].facebook_id;
                }
                
                if(parsedDetails.results[0].twitter_id == null){
                    var twitter ="N/A";
                    name="N/A";
                }
                else{
                    var twitter ="https://twitter.com/"+parsedDetails.results[0].twitter_id;
                }
                
                //Build Details page
                var legislatorDetailsTable ="";
                legislatorDetailsTable +="<div id='viewDetails'>";
                legislatorDetailsTable +="<div id='legImage'>"+legislatorImage+"</div>";
                legislatorDetailsTable +="<div id='titles'>";
                legislatorDetailsTable +="<span>Full Name</span><br>";
                legislatorDetailsTable +="<span>Term Ends on</span><br>";
                legislatorDetailsTable +="<span>Website</span><br>";
                legislatorDetailsTable +="<span>Office</span><br>";
                legislatorDetailsTable +="<span>Facebook</span><br>";
                legislatorDetailsTable +="<span>Twitter</span><br>";
                legislatorDetailsTable +="</div>";
                legislatorDetailsTable +="<div id='titleContent'>";
                legislatorDetailsTable +="<span>"+fullName+"</span><br>";
                legislatorDetailsTable +="<span>"+termEnds+"</span><br>";
                legislatorDetailsTable +="<span><a href="+website+">"+website+"</a></span><br>";
                legislatorDetailsTable +="<span>"+office+"</span><br>";
                legislatorDetailsTable +="<span><a href="+facebook+">"+name+"</a></span><br>";
                legislatorDetailsTable +="<span><a href="+twitter+">"+name+"</a></span><br>";
                legislatorDetailsTable +="</div>";
                legislatorDetailsTable +="</div>";
                
                document.getElementById("resultsArea").innerHTML=legislatorDetailsTable;
                return false;
            }
            
            //Function to view Details of bills
            function viewBillDetails(encodedBillArray){
                var billDetails = encodedBillArray;
                var parsedBillDetails = JSON.parse(billDetails);
                
                //Get required information
                var billID = parsedBillDetails.results[0].bill_id;
                
                if(parsedBillDetails.results[0].short_title == null){
                    var billTitle = "N/A";
                }
                else{
                    var billTitle = parsedBillDetails.results[0].short_title;
                }
                
                var sponsor = parsedBillDetails.results[0].sponsor['title']+" "+parsedBillDetails.results[0].sponsor['first_name']+" "+parsedBillDetails.results[0].sponsor['last_name'];
                var introducedOn = parsedBillDetails.results[0].introduced_on;
                var lastActionDate = parsedBillDetails.results[0].last_version['version_name']+", "+parsedBillDetails.results[0].last_action_at;
                
                if(parsedBillDetails.results[0].last_version['urls']['pdf'] == null){
                    var billURL = "N/A";
                }
                else{
                    var billURL = parsedBillDetails.results[0].last_version['urls']['pdf'];
                }
                
                
                //Build Details page
                var billDetailsTable ="";
                billDetailsTable +="<div id='viewBillDetails'>";
                billDetailsTable +="<div id='titles'>";
                billDetailsTable +="<span>Bill ID</span><br>";
                billDetailsTable +="<span>Bill Title</span><br>";
                billDetailsTable +="<span>Sponsor</span><br>";
                billDetailsTable +="<span>Introduced On</span><br>";
                billDetailsTable +="<span>Last action with date</span><br>";
                billDetailsTable +="<span>Bill URL</span><br>";
                billDetailsTable +="</div>";
                
                billDetailsTable +="<div id='titleContent'>";
                billDetailsTable +="<span>"+billID+"</span><br>";
                billDetailsTable +="<span>"+billTitle+"</span><br>";
                billDetailsTable +="<span>"+sponsor+"</span><br>";
                billDetailsTable +="<span>"+introducedOn+"</span><br>";
                billDetailsTable +="<span>"+lastActionDate+"</span><br>";
                
                if(parsedBillDetails.results[0].short_title == null){
                    billDetailsTable +="<span><a href="+billURL+">"+billID+"</a></span><br>";
                }
                else{
                    billDetailsTable +="<span><a href="+billURL+">"+billTitle+"</a></span><br>";
                }
                
                
                billDetailsTable +="</div>";
                billDetailsTable +="</div>";
                
                document.getElementById("resultsArea").innerHTML=billDetailsTable;
                
                return false;
            }
        </script>
        
        
        <!--Embedded CSS for Congress Info Page -->
        <style type="text/css">
            
            #bodyCenter {
                min-width: 750px;
                max-width: 750px;
                margin: 0 auto;
            }
            
            #form {
                border: 1px;
                border-color: grey;
                border-width: 1px;
                border-style: solid;
                width: 310px;
                align-content: center;
                margin: auto;
            }
            
            #formLabels {
                float: left;
                align-content: center;
                text-align: center;
                padding-left: 10px;
                padding-top: 10px;
            }
            
            #formInputs {
                float:right;
                align-content: center;
                text-align: center;
                padding-right: 10px;
                padding-top: 10px;
            }
            
            #sunlightLink {
                padding-top: 120px;
                margin-bottom: -10px;
                align-content: center;
                text-align: center;
            }
            
            #resultsArea {
                align-content: center;
                margin: auto;
            }
            
            #viewDetails{
                border: 1px;
                border-color: black;
                border-width: 1px;
                border-style: solid;
                align-content: center;
                margin: auto;
                height: 450px;
            }
            
            #viewBillDetails{
                border: 1px;
                border-color: black;
                border-width: 1px;
                border-style: solid;
                align-content: center;
                margin: auto;
                height: 150px;
                
                
            }
            
            #legImage{
                align-content: center;
                padding-left: 255px;
                padding-top: 20px;
            }
            
            #titles{
                float: left;
                align-content: left;
                text-align: left;
                padding-left:150px;
                padding-top:15px;
                line-height: 0.5px;
            }
            
            #titleContent{
                float:right;
                align-content: left;
                text-align: left;
                padding-top:15px;
                padding-right: 100px;
                line-height: 0.5px;
            }
            
            br {
                margin-top: 10px;
                margin-bottom: 10px;
            }
            
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                align-content: center;
                margin: auto;
            }
            
            td {
                width: 190px; 
                align-content: center;
                text-align: center;
            }
        </style>
    </head>
    
    <?php
    
    //Define Input Variables
    $keywordText="";
    $keywordTextFirst=""; //Variable for Full Name query Searches
    $keywordTextSecond=""; //Variable for Full Name query Searches
    $congressDatabase = "";
    $chamber = "";
    
    
    //Define Web URL Variables
    $stateKey ="";
    $idQueryString =""; //state OR query OR bill_id OR committee_id OR amendment_id
    $congressTable ="";
    $webStringDetails ="";
    
    
    
    
    
    //Array of States and their two-letter Abbreviations    
    $stateArray = array('ALABAMA' => 'AL', 'ALASKA' => 'AK', 'ARIZONA' => 'AZ', 'ARKANSAS' => 'AR', 'CALIFORNIA' => 'CA',
                        'COLORADO' => 'CO', 'CONNECTICUT' => 'CT', 'DELAWARE' => 'DE', 'DISTRICT OF COLUMBIA' => 'DC', 'MONTANA' => 'MT',
                        'NEBRASKA' => 'NE', 'NEVADA' => 'NV', 'NEW HAMPSHIRE' => 'NH', 'NEW JERSEY' => 'NJ', 'NEW MEXICO' => 'NM',
                        'NEW YORK' => 'NY', 'NORTH CAROLINA' => 'NC', 'NORTH DAKOTA' => 'ND', 'FLORIDA' => 'FL', 'GEORGIA' => 'GA',
                        'HAWAII' => 'HI', 'IDAHO' => 'ID', 'ILLINOIS' => 'IL', 'INDIANA' => 'IN', 'IOWA' => 'IA',
                        'KANSAS' => 'KS', 'KENTUCKY' => 'KY', 'LOUISIANA' => 'LA', 'MAINE' => 'ME', 'MARYLAND' => 'MD',
                        'MASSACHUSETTS' => 'MA', 'MICHIGAN' => 'MI', 'MINNESOTA' => 'MN', 'MISSISSIPPI' => 'MS', 'MISSOURI' => 'MO',
                        'OHIO' => 'OH', 'OKLAHOMA' => 'OK', 'OREGON' => 'OR', 'PENNSYLVANIA' => 'PA', 'RHODE ISLAND' => 'RI',
                        'SOUTH CAROLINA' => 'SC', 'SOUTH DAKOTA' => 'SD', 'TENNESSEE' => 'TN', 'TEXAS' => 'TX', 'UTAH' => 'UT',
                        'VERMONT' => 'VT', 'VIRGINIA' => 'VA', 'WASHINGTON' => 'WA', 'WEST VIRGINIA' => 'WV', 'WISCONSIN' => 'WI', 'WYOMING' => 'WY');
 
  
    
   //Function to clean up input
    function inputCleanup($inputData){
        $inputData = trim($inputData);
        return $inputData;
    }
        
    
    if(isset($_POST['submit'])){
        
        //Check if input conditions have been met; if so, generate Web URL
        if(!empty($_POST['keywordText']) && ($_POST['congressDatabase'] != "Select your option")){
            
            $congressDatabase = inputCleanup($_POST['congressDatabase']);
            
            //BUILD WEB URL FOR LEGISLATOR DATABASE
            if($_POST['congressDatabase'] == "legislators"){
            
            
                //If input is in state Array, save two-letter state into keyword variable for web url
                if(array_key_exists(strtoupper($_POST['keywordText']), $stateArray)){
                    $keywordText = inputCleanup($_POST['keywordText']);
                    $stateKey = $stateArray[strtoupper($_POST['keywordText'])];
                    $idQueryString = "state=".$stateKey;
                }

                else if(str_word_count($_POST['keywordText']) == 2){
                    $explodedInputArray = explode(" ",$_POST['keywordText']);
                    $keywordText = inputCleanup($_POST['keywordText']);
                    $keywordTextFirst = ucfirst(strtolower(inputCleanup($explodedInputArray[0])));
                    $keywordTextSecond = ucfirst(strtolower(inputCleanup($explodedInputArray[1]))); //For searching Full Names
                    $idQueryString = "first_name=".$keywordTextFirst."&last_name=".$keywordTextSecond;
                }

                else{
                    $keywordText = ucfirst(strtolower(inputCleanup($_POST['keywordText'])));
                    $idQueryString = "query=".$keywordText;
                }    
            }
            
            //BUILD WEB URL FOR COMMITTEE DATABASE
            else if($_POST['congressDatabase'] == "committees"){
                $keywordText = strtoupper(inputCleanup($_POST['keywordText']));
                $idQueryString = "committee_id=".$keywordText;
            }
            
            //BUILD WEB URL FOR BILL DATABASE
            else if($_POST['congressDatabase'] == "bills"){
                $keywordText = strtolower(inputCleanup($_POST['keywordText']));
                $idQueryString = "bill_id=".$keywordText;
            }

            //BUILD WEB URL FOR AMENDMENT DATABASE
            else if($_POST['congressDatabase'] == "amendments"){
                $keywordText = strtolower(inputCleanup($_POST['keywordText']));
                $idQueryString = "amendment_id=".$keywordText;
            }


            if(empty($_POST['chamber'])){
                $chamber = "";
            }
            else{
                $chamber = inputCleanup($_POST['chamber']);
            }

            $webString = "http://congress.api.sunlightfoundation.com/".$congressDatabase."?".$idQueryString."&chamber=".$chamber."&apikey=dfbc7131ab4240338f3ac0d8bb9adcd6";
            $array = file_get_contents($webString);
            $decodedArray= json_decode($array, true);
            
            //Check if API returns zero results
            if(empty($decodedArray['results'])){ 
                $congressTable ="<b style=\"text-align: center; padding-left:223px\">The API returned zero results for the request.</b>";
            }
            
            
            //BUILD TABLES
            else{
               
                
                if($_POST['congressDatabase'] == "legislators"){
                    
                    $congressTable.= "<table>";
                    $congressTable.= "<tr>";
                    $congressTable.= "<th>Name</th>";
                    $congressTable.= "<th>State</th>";
                    $congressTable.= "<th>Chamber</th>";
                    $congressTable.= "<th>Details</th>";
                    $congressTable.= "</tr>";
                    
                    for($rows=0; $rows < sizeof($decodedArray['results']); $rows++){
                        
                                          
                        $webStringDetails=$webString."&bioguide_id=".$decodedArray['results'][$rows]['bioguide_id'];
                        $newArray = file_get_contents($webStringDetails);
                        $encodedNewArray = json_encode($newArray, JSON_PRETTY_PRINT);
                        
                        
                        $congressTable.= "<tr>";
                        $congressTable.= "<td style='text-align:left; padding-left:20px;'>".$decodedArray['results'][$rows]['first_name']." ".$decodedArray['results'][$rows]['last_name']."</td>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['state_name']."</td>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['chamber']."</td>";
                        $congressTable.= "<td>";
                        $congressTable.= "<a href='' onClick='return viewLegislatorDetails(".$encodedNewArray.")'>View Details</a>";
                        $congressTable.= "</td>";
                        $congressTable.= "<tr>";
                    }
                    
                    $congressTable.= "</table>";
                }
                
                else if($_POST['congressDatabase'] == "committees"){
                    
                    $congressTable.= "<table>";
                    $congressTable.= "<tr>";
                    $congressTable.= "<th>Committee ID</th>";
                    $congressTable.= "<th>Committee Name</th>";
                    $congressTable.= "<th>Chamber</th>";
                    $congressTable.= "</tr>";
                    
                    for($rows=0; $rows < sizeof($decodedArray['results']); $rows++){
                        
                        $congressTable.= "<tr>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['committee_id']."</td>";
                        $congressTable.= "<td style=\" width:auto;\">".$decodedArray['results'][$rows]['name']."</td>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['chamber']."</td>";
                        $congressTable.= "<tr>";
                    }
                    
                    $congressTable.= "</table>";
                    
                }
                
                
                else if($_POST['congressDatabase'] == "bills"){
                    
                    $congressTable.= "<table>";
                    $congressTable.= "<tr>";
                    $congressTable.= "<th>Bill ID</th>";
                    $congressTable.= "<th>Short Title</th>";
                    $congressTable.= "<th>Chamber</th>";
                    $congressTable.= "<th>Details</th>";
                    $congressTable.= "</tr>";
                    
                    $encodedBillArray = json_encode($array, JSON_PRETTY_PRINT);
                    
                    for($rows=0; $rows < sizeof($decodedArray['results']); $rows++){
                        
                        $congressTable.= "<tr>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['bill_id']."</td>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['short_title']."</td>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['chamber']."</td>";
                        $congressTable.= "<td>";
                        $congressTable.= "<a href='' onClick='return viewBillDetails(".$encodedBillArray.")'>View Details</a>";
                        $congressTable.= "</td>";
                        $congressTable.= "<tr>";
                    }
                    
                    $congressTable.= "</table>";
                    
                }
                
                else if($_POST['congressDatabase'] == "amendments"){
                    $congressTable.= "<table>";
                    $congressTable.= "<tr>";
                    $congressTable.= "<th>Amendment ID</th>";
                    $congressTable.= "<th>Amendment Type</th>";
                    $congressTable.= "<th>Chamber</th>";
                    $congressTable.= "<th>Introduced on</th>";
                    $congressTable.= "</tr>";
                    
                    for($rows=0; $rows < sizeof($decodedArray['results']); $rows++){
                        $congressTable.= "<tr>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['amendment_id']."</td>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['amendment_type']."</td>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['chamber']."</td>";
                        $congressTable.= "<td>".$decodedArray['results'][$rows]['introduced_on']."</td>";
                        $congressTable.= "<tr>";
                    }
                    
                    $congressTable.= "</table>";    
                } 
            }
        }
        
        //For previous inputs to get saved
        else{
            $keywordText = inputCleanup($_POST['keywordText']);
            $chamber = inputCleanup($_POST['chamber']);
            $congressDatabase = inputCleanup($_POST['congressDatabase']);
        }
    } 
    ?>
    
    <!--Page Body -->
    <body onload="selectChange()">
        <div id="bodyCenter">
        <h1 style="text-align: center;">Congress Information Search</h1>
            
        <!--Congress Information Search Form Start -->
        <div id="form">
        <form name="congressDatabaseForm" method="POST" onsubmit="validateFormFields()" action="<?php echo $_SERVER['PHP_SELF']?>">
            
            <!--Labels -->
            <div id="formLabels">
                <label for="congressDatabase">Congress Database</label><br>
                <label for="chamber">Chamber</label><br>
                <label for="keywordText" id="keyword">Keyword*</label><br>
            </div>
            
            <!--Form Inputs -->
            <div id="formInputs">
                <!--Congress Database Select Dropdown -->
                <select name="congressDatabase" id="congressDatabaseSelect" onchange="selectChange()">
                    <option>Select your option</option>
                    <option <?php if (isset($congressDatabase) && $congressDatabase =="legislators") echo "selected";?> value="legislators">Legislators</option>
                    <option <?php if (isset($congressDatabase) && $congressDatabase =="committees") echo "selected";?> value="committees">Committees</option>
                    <option <?php if (isset($congressDatabase) && $congressDatabase =="bills") echo "selected";?> value="bills">Bills</option>
                    <option <?php if (isset($congressDatabase) && $congressDatabase =="amendments") echo "selected";?> value="amendments">Amendments</option>
                </select>
                <br>
                <!--Chamber Radio Buttons -->
                <input type="radio" name="chamber" <?php if (isset($chamber) && $chamber =="senate") echo "checked";?> value="senate" checked>Senate</input>
                <input type="radio" name="chamber" <?php if (isset($chamber) && $chamber =="house") echo "checked";?> value="house">House</input>
                <br>
                <!--Keyword text -->
                <input type="text" name="keywordText" value="<?php echo $keywordText;?>">
                <br>
                <!--Submit and Clear buttons -->
                <input type="submit" name="submit" value="Search">
                <input type="button" name="clear" value="Clear" onclick="clearForm()">
                <br>
            </div>
            <!--Sunlight Foundation Link -->
            <div id="sunlightLink">
            <a target="_blank" href="http://www.sunlightfoundation.com">Powered by Sunlight Foundation</a>
            </div>
        </form>
        </div>
        <br>
    
        <!--RESULTS AREA DIV SECTION (DYNAMICALLY BUILT) -->
        <div id="resultsArea"><?php echo $congressTable?></div>  
        </div>
    </body>
</html>