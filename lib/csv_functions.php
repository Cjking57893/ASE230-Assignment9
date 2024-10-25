<?php 
    //function for reading awards csv file
    function read_csv_awards($file_path){
        //open file for reading
        $file = fopen($file_path,'r');
        //loop runs as long as there is data to read from file
        if(file_exists($file_path)){
            while(($section = fgetcsv($file)) !== false) {
                //write html to page
                '<br>';
                echo "<div class=\"col-lg-4\">
                        <div class=\"card mt-4 border-0 shadow\">
                            <div class=\"card-body p-4\">
                                <h4 class=\"font-size-22 my-4\"><a href=\"javascript: void(0);\">$section[0]</a></h4>
                                <p class=\"text-muted\">$section[1]</p>
                            </div><!-- end cardbody -->
                        </div><!-- end card -->
                    </div><!-- end col -->";
            }
        }
        else{
            echo 'File not found.';
        }
        //close file
        fclose($file);
    }
// this function creates an award based on the name
        function create_award($file_path, $award_year, $award_description){
            $file = fopen($file_path,'a');
            //create array to hold award info
            $data = [$award_year, $award_description];
            //open file for reading to check award year
            $file_read = fopen($file_path, 'r');
            //variable to act as a flag if a matching award yearis found
            $found = false;
            if(file_exists($file_path)){
                while(($section = fgetcsv($file_read)) !== false) {
                    if($section[1] == $award_description){
                            $found = true;
                    }
                }
                fclose($file_read);
                //write data if no award year match is not found
                if($found==false){
                    fputcsv($file, $data);
                    //redirect to edit.php
                    header("Location: edit.php?award_description=$award_description");
                    exit; // Stop script execution
                }
                else{
                    echo"<div class=\"text-center alert alert-light\" role=\"alert\" style=\"font-weight: bold;\">
                        File not found 
                        </div>
                        ";
                }
            }
        }    
        //this function reads the awards list for the index page
        function read_awards_admin_index($file_path): void{
            $file = fopen($file_path,'r');
            //loop runs as long as there is data to read from file
            if(file_exists($file_path)){
                while(($section = fgetcsv($file)) !== false) {
                    echo "<tr>
                        <td class=\"align-middle\">$section[1]</td>
                        <td class=\"align-middle\"><a href=detail.php?award_description=",urlencode($section[1]),">$section[0]</a></td> 
                        </tr>";
                }
            }
        }
            //function creates form with award data already inside.
    function create_award_edit($file_path, $award_description){
        //open file for reading
        $file = fopen($file_path, 'r');
        if(file_exists($file_path)){
            while (($section = fgetcsv($file)) !== false) {
                // Check if the year matches the year number in the URL
                if ($section[1] == $award_description) {
                    echo "<form method=\"post\" action=\"\">
                    <div class=\"mb-3\">
                        <label for=\"year\" class=\"form-label\">Year the award was given</label>
                        <input type=\"text\" class=\"form-control w-25\" id=\"award_year\" name=\"award_year\" value=\"$section[0]\" style=\"border-color: black\">
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"description\" class=\"form-label\">Award Description</label>
                        <input type=\"text\" class=\"form-control w-25\" id=\"description\"  name=\"description\" value=\"$section[1]\" style=\"border-color: black\">
                    </div>
                    <button type=\"submit\" class=\"btn btn-primary\">Save Changes</button>
                </form>";
                break;
                }
            }
        }
    }
        //function edits entry in the csv file according to input from edit form
        function edit_awards_info($file_path, $award_description, $award_year, $old){
            //open file for reading to find award entry
            $file_read = fopen($file_path, 'r');
            //create array to hold award info
            $data = [$award_year, $award_description];
            
            if(file_exists($file_path)){
                while(($section = fgetcsv($file_read)) !== false) {
                    
                   
                    if ($section[1] == $old) {
                       // $section[0] == $award_year;
                       // $section[1] == $award_description;
                        continue; //skip over existing entry
                    }
                    $lines[] = $section;  
                    
                }
                $lines[] = $data;
                $file = fopen($file_path, 'w');
                foreach ($lines as $line) {
                    fputcsv($file, $line);
                }
                fclose($file);
            }
        }

    function delete_award($file_path, $award_description){
        $file = fopen($file_path, 'r');
        $lines = [];
        if(file_exists($file_path)){
            while (($section = fgetcsv($file)) !== false) {
                // Check if the emp number matches the emp number in the URL
                if ($section[1] == $award_description) {
                    continue;
                }
                $lines[] = $section; 
            }
        }
        
        fclose($file);


        // Write the modified array back to the CSV file
        $file = fopen($file_path, 'w');
        foreach ($lines as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
    }   
        
    //function for reading team csv file
    function read_csv_team($file_path){
        //iterator for team member images
        $i = 1;
        //open file
        $file = fopen($file_path,'r');
        //loop runs as long as there is data to read from file
        if(file_exists($file_path)){
            while(($section = fgetcsv($file)) !== false) {
                
                //write html to page
                '<br>';
                echo "<div class=\"col-lg-3 col-sm-6\">
                        <div class=\"team-box mt-4 position-relative overflow-hidden rounded text-center shadow\">
                            <div class=\"position-relative overflow-hidden\">
                                <img src=\"images/team/img_$i.jpg\" alt=\"\" class=\"img-fluid d-block mx-auto\" />
                                <ul class=\"list-inline p-3 mb-0 team-social-item\">
                                <p style=\"color: white\">$section[3]</p>
                                </ul>
                            </div>
                            <div class=\"p-4\">
                                <h5 class=\"font-size-19 mb-1\">$section[1]</h5>
                                <p class=\"text-muted text-uppercase font-size-14 mb-0\">$section[2]</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->";
                 $i++;   
            }
        }
        else{
            echo 'File not found.';
        }
        //close file
        fclose($file);
    }

    //function to read specific award for admin detail page
    function read_awards_admin_detail($file_path,$award_description): void{
        $file = fopen($file_path,'r');
        //loop runs as long as there is data to read from file
        if(file_exists($file_path)){
            while(($section = fgetcsv($file)) !== false) {
                //check if the employee number in the file matches the award year in the URL
                if($section[1] == $award_description){
                    echo"<h3>Year: $section[0]</h3>
                        <p>Award Description $section[1]</p>";
                        
                }
            }
        }
    }