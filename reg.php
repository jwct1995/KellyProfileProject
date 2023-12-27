<html>
<head>

<?php 
include "db.php";


    $listarr=0;
    $fType=5;
    $uname=" ";
    if(isset($_POST["regsbtn"]))
    {
        $id=DateTimeForId();
        $uname=$_POST["regemail"];




        $query="SELECT * FROM `tbluserloginacc` WHERE `UserName`='".$_POST["regemail"]."'";	
        $sql=mysqli_query($mysqli,$query);
        $row = mysqli_fetch_array($sql, MYSQLI_BOTH);
        $result = mysqli_num_rows($sql);
        if($result==1)
            $fType=3;
        else
        {
            $query="INSERT INTO `tbluserloginacc`(`UserId`, `UserName`, `UserPsw`, `UserFname`, `LastLogin`, `AccStatus`, `UserPhoneNumber`) VALUES ('U".$id."','".$_POST["regemail"]."','".$_POST["regpassword"]."','".$_POST["regfname"]."',' ','T','".$_POST["regphone"]."')";
            $result=mysqli_query($mysqli,$query);
            if($result==true)
                $fType=2;
            else
                $fType=4;
        }
    }
    else if(isset($_POST["logsbtn"]))
    {
        $query="SELECT * FROM `tbluserloginacc` WHERE `UserName`='".$_POST["logemail"]."' AND `UserPsw`='".$_POST["logpassword"]."' ";	
        $sql=mysqli_query($mysqli,$query);
        $row = mysqli_fetch_array($sql, MYSQLI_BOTH);
        $result = mysqli_num_rows($sql);
        if($result==1)
        {
            //echo $row["AccStatus"];
            if($row["AccStatus"]=="T")
            {
                $fType=6;
                $query="UPDATE `tbluserloginacc` SET `LastLogin`='".DateTime()."' WHERE `UserId`='".$row["UserId"]."'";	
                $sql=mysqli_query($mysqli,$query);
            }
            else if($row["AccStatus"]=="F")
            {
                $fType=8;
            }

            
        }
        else
            $fType=7;


    }
    else if(isset($_POST["prosbtn"]))
    {

        $query="UPDATE `tbluserloginacc` SET `UserFname`='".$_POST["profname"]."',`UserPhoneNumber`='".$_POST["prophone"]."' WHERE `UserId`='".$_POST["prouid"]."'";
        $sql=mysqli_query($mysqli,$query);
        if($sql==true)
            $fType=9;
        else
            $fType=10;
    }
    else if(isset($_POST["menuAllProfilebtn"]))
    {
        $c=0;
        $query="SELECT * FROM `tbluserloginacc`";	
        $sql=mysqli_query($mysqli,$query);
       // $row = mysqli_fetch_array($sql, MYSQLI_BOTH);
        $result = mysqli_num_rows($sql);
        if($result>=1)
        {
            $listarr=1;
            $fType=11;
        }
    }
    else if(isset($_POST["listsbtn"]))
    {
        //print_r($_POST);
        //var_dump($_POST);
        $statusUserId=$_POST;
        //echo $statusUserId["listsbtn"];
        $statusUserId=$statusUserId["listsbtn"];
        //echo $statusUserId;
        
        $query="SELECT * FROM `tbluserloginacc` WHERE `UserId`='".$statusUserId."' ";	
        $sql=mysqli_query($mysqli,$query);
        $row = mysqli_fetch_array($sql, MYSQLI_BOTH);
        $result = mysqli_num_rows($sql);
        if($result==1)
        {
            $userstatus="";
            if($row["AccStatus"]=="T")
                $userstatus="F";
            else if($row["AccStatus"]=="F")
                $userstatus="T";

            
            $query="UPDATE `tbluserloginacc` SET `AccStatus`='".$userstatus."' WHERE `UserId`='".$statusUserId."'";
            $sql=mysqli_query($mysqli,$query);
            if($sql==true)
            {
                if($row["AccStatus"]=="T")
                    $fType=12;
                if($row["AccStatus"]=="F")
                    $fType=13;
            }   
            else
            {
                if($row["AccStatus"]=="T")
                    $fType=14;
                if($row["AccStatus"]=="F")
                    $fType=15;
            }
        }


        
    }
    

		

    

//`UserId`, `UserName`, `UserPsw`, `UserFname`, `LastLogin`, `AccStatus`, `UserPhoneNumber`
/*
            $row["UserId"];
            $row["UserName"];
            $row["UserPsw"];
            $row["UserFname"];
            $row["LastLogin"];
            $row["AccStatus"];
            $row["UserPhoneNumber"];
            */


/////////////////////////////////////////////////////////
    function DateTimeForId()
    {
        $t = microtime(true);
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        return $d->format("YmdHisu"); 	
    }
    function DateTime()
    {
        $t = microtime(true);
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        return $d->format("Y-m-d~H:i:s.u"); 	
    }
        

?>



<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js" charset="utf-8"></script>
<script>

var fType=<?php echo $fType;?>;
var uname="<?php echo $uname;?>";


<?php 
if($listarr==1)
{
    echo"var listarr=";
    echo"[";
    $c=0;
	while ($row = mysqli_fetch_array($sql, MYSQLI_BOTH)) 
	{
		echo"['".$row["UserId"]."','".$row["UserName"]."','".$row["UserFname"]."','".$row["LastLogin"]."','".$row["AccStatus"]."','".$row["UserPhoneNumber"]."']";
        if($c<$result-1)
            echo",";
        $c++;
    }
/*
    for($c=0;$c<$result;$c++)
    {
        echo"['".$row["UserId"]."','".$row["UserName"]."','".$row["UserFname"]."','".$row["LastLogin"]."','".$row["AccStatus"]."','".$row["UserPhoneNumber"]."']";
        if($c<$result-1)
            echo",";
    }*/
    echo"];";

}
?>

window.onload = function exampleFunction()
{
    

    if(fType==1)
        $("#regTable").css("display","unset");
    if(fType==2 || fType==3 || fType==4 || fType==7 || fType==8 || fType==9 || fType==10|| fType==11|| fType==12|| fType==13)
    {
        $("#StatusDisplayPage").css("display","unset");

        if(fType==2)
            $("#StatusDisplayPage").html("Your ID \""+uname+"\" is register Success.");
        if(fType==3)
            $("#StatusDisplayPage").html("Register Fail .\nYour ID \""+uname+"\" is registed by other user.");
        if(fType==4)
            $("#StatusDisplayPage").html("Register Fail some other error.");
        if(fType==7)
            $("#StatusDisplayPage").html("Login Fail.");
        if(fType==8)
            $("#StatusDisplayPage").html("Yout account is Disable.");
        if(fType==9)
            $("#StatusDisplayPage").html("Yout account is updated.");
        if(fType==10)
            $("#StatusDisplayPage").html("Yout account is update fail.");
        if(fType==12)
            $("#StatusDisplayPage").html("Success to block that account.");
        if(fType==13)
            $("#StatusDisplayPage").html("Success to active that account.");
        if(fType==14)
            $("#StatusDisplayPage").html("Fail block that account.");
        if(fType==15)
            $("#StatusDisplayPage").html("Fail active that account.");

        if(fType==11)
        {
            
            var eleform=$("<form action='reg.php' method='post' id='listTable'></form>");
            var eletbl=$("<table border='1'></table>");
            var eleTR=$("<tr></tr>");

            var eleTH1=$("<th>ID</th>");
            var eleTH2=$("<th>Email</th>");
            var eleTH3=$("<th>Full Name</th>");
            var eleTH4=$("<th>Last Login</th>");
            var eleTH5=$("<th>Status</th>");
            var eleTH6=$("<th>Phone Number</th>");
            var eleTH7=$("<th>Status On/Off</th>");
            
            $("#StatusDisplayPage").append(eleform);
            eleform.append(eletbl);
            eletbl.append(eleTR);
            eleTR.append(eleTH1);
            eleTR.append(eleTH2);
            eleTR.append(eleTH3);
            eleTR.append(eleTH4);
            eleTR.append(eleTH5);
            eleTR.append(eleTH6);
            eleTR.append(eleTH7);
            <?php
            if($listarr==1)
            {
            ?>
                var ccount=0;
                for(var c=0;c<listarr.length;c++)
                {

                    var btntxt="";
                    var ustatus="";
                    if(listarr[c][4]=="T")
                    {
                        ustatus="Active";
                        btntxt="Block";
                    }
                    else if(listarr[c][4]=="F")
                    {
                        ustatus="Block";
                        btntxt="Active";
                    }

                    eletbl.append("<tr><td>"+listarr[c][0]+"</td><td>"+listarr[c][1]+"</td><td>"+listarr[c][2]+"</td><td>"+listarr[c][3]+"</td><td>"+ustatus+"</td><td>"+listarr[c][5]+"</td><td><button id='"+listarr[c][0]+"' name='listsbtn' value='"+listarr[c][0]+"'>"+btntxt+"</button></td></tr>");
                }
            <?php
            }
            ?>
        }
    }
        
    if(fType==5)
        $("#logTable").css("display","unset");
    
    if(fType==6)
        $("#proTable").css("display","unset");
        
    <?php 
    if($fType==6)
    {
    ?>
        $("[name='proid']").val("<?php echo$row["UserId"]; ?>");
        $("[name='prouid']").val("<?php echo$row["UserId"]; ?>");
        $("[name='proemail']").val("<?php echo$row["UserName"]; ?>");
        $("[name='profname']").val("<?php echo$row["UserFname"]; ?>");
        $("[name='prophone']").val("<?php echo$row["UserPhoneNumber"]; ?>");
        $("[name='prologin']").val("<?php echo$row["LastLogin"]; ?>");
    <?php
    }
    ?>
            


    $("[name='regsbtn']").attr("disabled", true);
    $("[name='logsbtn']").attr("disabled", true);
}

$( document ).ready(function()
{
    $(":input").on("keyup change", function(e) 
    {
        if($("[name='regemail']").val() && $("[name='regpassword']").val()==$("[name='regcpassword']").val()&&$("[name='regfname']").val() &&$("[name='regphone']").val() )
            $("[name='regsbtn']").attr("disabled", false);
        else
            $("[name='regsbtn']").attr("disabled", true);
    });

    $(":input").on("keyup change", function(e) 
    {
        if($("[name='logemail']").val() && $("[name='logpassword']").val())
            $("[name='logsbtn']").attr("disabled", false);
        else
            $("[name='logsbtn']").attr("disabled", true);
    });

    $("body").on("click", "[name='menubtn']", function()
    {
        $("#logTable , #regTable , #proTable , #StatusDisplayPage" ).css("display","none");

        var eleID=$(this).attr("id");

        if(eleID=="menuregbtn")
            $("#regTable").css("display","unset");
        else if(eleID=="menulogbtn")
            $("#logTable").css("display","unset");
    });
});

</script>
</head>

<body>
    <div>
        <button id="menuregbtn" name="menubtn" >Register</button>
        <button id="menulogbtn" name="menubtn" >Profile Login</button>
        <form action="reg.php" method="post" id="menuTable" style="display: contents;">
            <input type="submit" name="menuAllProfilebtn" value="AllProfile">
        </form>
    </div>
<center>

<form action="reg.php" method="post" id="logTable" style="display: none;">
    <table>
    <tr>
            <td colspan="2" align="center">Login Page</td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="logemail"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="logpassword"></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="logsbtn">
                <input type="reset" name="logrbtn">
            </td>
        </tr>
    </table>
</form>

<form action="reg.php" method="post" id="regTable" style="display: none;">
    <table>
        <tr>
            <td colspan="2" align="center">Register Page</td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="regemail"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="regpassword"></td>
        </tr>
        <tr>
            <td>Confirm Password</td>
            <td><input type="password" name="regcpassword"></td>
        </tr>
        <tr>
            <td>Full Name</td>
            <td><input type="text" name="regfname"></td>
        </tr>""
        <tr>
            <td>Phone Number</td>
            <td><input type="text" name="regphone"></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="regsbtn">
                <input type="reset" name="regrbtn">
            </td>
        </tr>
    </table>
</form>

<form action="reg.php" method="post" id="proTable" style="display: none;">
    <table>
        <tr>
            <td colspan="2" align="center">User Profile</td>
        </tr>
        <tr>
            <td>uid</td>
            <td><input type="text" name="proid" disabled><input type="text" name="prouid" style="display: none;"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="proemail" disabled></td>
        </tr>
        <tr>
            <td>Full Name</td>
            <td><input type="text" name="profname" ></td>
        </tr>""
        <tr>
            <td>Phone Number</td>
            <td><input type="text" name="prophone" ></td>
        </tr>
        <tr>
            <td>Last Login</td>
            <td><input type="text" name="prologin" disabled></td>
        </tr>
        <td colspan="2" align="center">
                <input type="submit" name="prosbtn">
        </td>
    </table>
</form>

<div id="StatusDisplayPage"></div>
</center>
</body>
</html>



